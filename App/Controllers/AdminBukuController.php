<?php

namespace App\Controllers;

use App\Models\Buku;
use App\Models\Genre;
use App\Models\Penerbit;
use Core\FileDisplay;
use Core\Request;
use Core\Security;

class AdminBukuController
{
    protected $bukuModel, $penerbitModel, $genreModel;

    public function __construct()
    {
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        $this->bukuModel = new Buku();
        $this->penerbitModel = new Penerbit();
        $this->genreModel = new Genre();
    }

    /**
     * Display the list of books with joined data.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $books = $this->bukuModel
            ->join('penerbit', 'buku.penerbit_id', '=', 'penerbit.id')
            ->join('genre', 'buku.genre_id', '=', 'genre.id')
            ->select([
                'buku.*',
                'penerbit.nama as penerbit_nama',
                'genre.nama as genre_nama',
            ])
            ->get();

        FileDisplay::initializeBaseUrl();

        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'user' => auth(),
            'books' => $books,
            'fileDisplay' => $fileDisplay,
        ];

        return view('admin/buku/index', $data, 'admin');
    }

    /**
     * Show the form to create a new penerbit.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'penerbits' => $this->penerbitModel->all(),
            'genres' => $this->genreModel->all(),
        ];

        return view('admin/buku/tambah', $data, 'admin');
    }

    /**
     * Show the form to create a new penerbit.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect(
                '/admin-buku/create?error=' . urlencode('Invalid CSRF token')
            );
        }

        $judul = htmlspecialchars($request->input('judul'));
        $penerbit_id = intval($request->input('penerbit_id'));
        $genre_id = intval($request->input('genre_id'));
        $tahun_terbit = intval($request->input('tahun_terbit'));
        $content = htmlspecialchars($request->input('content'));
        $gambar = null;

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {
                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);

                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'book_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    '/admin-buku/create?error=' . urlencode($error)
                );
            }
        } else {
            if (
                isset($_FILES['gambar']['error']) &&
                $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $error = 'Error uploading file: ' . $_FILES['gambar']['error'];
                return redirect(
                    '/admin-buku/create?error=' . urlencode($error)
                );
            }
        }

        $data = [
            'judul' => $judul,
            'penerbit_id' => $penerbit_id,
            'genre_id' => $genre_id,
            'tahun_terbit' => $tahun_terbit,
            'content' => $content,
            'gambar' => $gambar,
        ];


        if ($this->bukuModel->create($data)) {
            return redirect(
                '/admin-buku/index?success=' .
                    urlencode('Data created successfully')
            );
        } else {
            return redirect(
                '/admin-buku/create?error=' . urlencode('Failed to create data')
            );
        }
    }

    /**
     * Show the form to edit an existing book.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $book = $this->bukuModel->find($id);

        if (!$book) {
            return redirect('/admin-buku/index?error=Data not found');
        }

        $penerbits = $this->penerbitModel->all();
        $genres = $this->genreModel->all();

        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'book' => $book,
            'penerbits' => $penerbits,
            'genres' => $genres,
        ];

        return view('admin/buku/edit', $data, 'admin');
    }

    /**
     * Update the form to edit an existing book.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect("/admin-buku/edit/$id?error=Invalid CSRF token");
        }

        $judul = $request->input('judul');
        $penerbit_id = $request->input('penerbit_id');
        $genre_id = $request->input('genre_id');
        $tahun_terbit = $request->input('tahun_terbit');
        $content = $request->input('content');
        $gambar = null;

        $existingBook = $this->bukuModel->find($id);

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {

                if (!empty($existingBook['gambar'])) {
                    $existingImagePath = public_path(
                        'storage/uploaded_files/' . $existingBook['gambar']
                    );
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath); 
                    }
                }

                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);


                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'book_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    "/admin-buku/edit/$id?error=" . urlencode($error)
                );
            }
        } else {
            $gambar = $existingBook['gambar'];
        }

        $data = [
            'judul' => $judul,
            'penerbit_id' => intval($penerbit_id),
            'genre_id' => intval($genre_id),
            'tahun_terbit' => intval($tahun_terbit),
            'content' => $content,
            'gambar' => $gambar,
        ];

        if ($this->bukuModel->update($id, $data)) {
            return redirect(
                '/admin-buku/index?success=Data updated successfully'
            );
        } else {
            return redirect("/admin-buku/edit/$id?error=Failed to update data");
        }
    }

    /**
     * Handle the deletion of a book and its associated file.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $book = $this->bukuModel->find($id);

        if (!$book) {
            return redirect('/admin-buku/index?error=Data not found');
        }

        if (!empty($book['gambar'])) {
            $filePath = 'storage/uploaded_files/' . $book['gambar'];

            if (file_exists($filePath)) {
                unlink($filePath); 
            }
        }

        if ($this->bukuModel->delete($id)) {
            return redirect(
                '/admin-buku/index?success=Data deleted successfully'
            );
        } else {
            return redirect('/admin-buku/index?error=Failed to delete data');
        }
    }
}
