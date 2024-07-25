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
        // Fetch data with joins
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
        // CSRF Token Check
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect(
                '/admin-buku/create?error=' . urlencode('Invalid CSRF token')
            );
        }

        // Get form inputs
        $judul = htmlspecialchars($request->input('judul'));
        $penerbit_id = intval($request->input('penerbit_id'));
        $genre_id = intval($request->input('genre_id'));
        $tahun_terbit = intval($request->input('tahun_terbit'));
        $content = htmlspecialchars($request->input('content'));
        $gambar = null;

        // Handle file upload
        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {
                // Create an instance of UploadedFile
                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);

                // Move the file to the storage directory
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

        // Prepare data for database insertion
        $data = [
            'judul' => $judul,
            'penerbit_id' => $penerbit_id,
            'genre_id' => $genre_id,
            'tahun_terbit' => $tahun_terbit,
            'content' => $content,
            'gambar' => $gambar,
        ];

        // Save data to the database
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
}
