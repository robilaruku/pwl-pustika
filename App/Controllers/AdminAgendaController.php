<?php

namespace App\Controllers;

use App\Models\Agenda;
use Core\FileDisplay;
use Core\Request;
use Core\Security;

class AdminAgendaController
{
    protected $agendaModel;

    public function __construct()
    {
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        $this->agendaModel = new Agenda();
    }

    /**
     * Display the list of agendas with joined data.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $agendas = $this->agendaModel->all();

        FileDisplay::initializeBaseUrl();

        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'user' => auth(),
            'agendas' => $agendas,
            'fileDisplay' => $fileDisplay,
        ];

        return view('admin/agenda/index', $data, 'admin');
    }

    /**
     * Show the form to create a new agenda.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
        ];

        return view('admin/agenda/tambah', $data, 'admin');
    }

    /**
     * Show the form to create a new agenda.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect(
                '/admin-agenda/create?error=' . urlencode('Invalid CSRF token')
            );
        }

        $title = htmlspecialchars($request->input('title'));
        $description = htmlspecialchars($request->input('description'));
        $gambar = null;

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {
                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);

                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'agenda_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    '/admin-agenda/create?error=' . urlencode($error)
                );
            }
        } else {
            if (
                isset($_FILES['gambar']['error']) &&
                $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $error = 'Error uploading file: ' . $_FILES['gambar']['error'];
                return redirect(
                    '/admin-agenda/create?error=' . urlencode($error)
                );
            }
        }

        $data = [
            'title' => $title,
            'description' => $description,
            'gambar' => $gambar,
        ];

        if ($this->agendaModel->create($data)) {
            return redirect(
                '/admin-agenda/index?success=' .
                    urlencode('Data created successfully')
            );
        } else {
            return redirect(
                '/admin-agenda/create?error=' .
                    urlencode('Failed to create data')
            );
        }
    }

    /**
     * Show the form to edit an existing agenda.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect('/admin-agenda/index?error=Data not found');
        }

        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'agenda' => $agenda,
        ];

        return view('admin/agenda/edit', $data, 'admin');
    }

    public function update(Request $request, $id)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect("/admin-agenda/edit/$id?error=Invalid CSRF token");
        }

        $title = htmlspecialchars($request->input('title'));
        $description = htmlspecialchars($request->input('description'));
        $gambar = null;

        $existingAgenda = $this->agendaModel->find($id);

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {
                if (!empty($existingAgenda['gambar'])) {
                    $existingImagePath = public_path(
                        'storage/uploaded_files/' . $existingAgenda['gambar']
                    );
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);

                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'agenda_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    "/admin-agenda/edit/$id?error=" . urlencode($error)
                );
            }
        } else {
            $gambar = $existingAgenda['gambar'];
        }

        
        $data = [
            'title' => $title,
            'description' => $description,
            'gambar' => $gambar,
        ];


        if ($this->agendaModel->update($id, $data)) {
            return redirect(
                '/admin-agenda/index?success=Data updated successfully'
            );
        } else {
            return redirect("/admin-agenda/edit/$id?error=Failed to update data");
        }
    }

    /**
     * Handle the deletion of a agenda and its associated file.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect('/admin-agenda/index?error=Data not found');
        }

        if (!empty($book['gambar'])) {
            $filePath = 'storage/uploaded_files/' . $agenda['gambar'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($this->agendaModel->delete($id)) {
            return redirect(
                '/admin-agenda/index?success=Data deleted successfully'
            );
        } else {
            return redirect('/admin-agenda/index?error=Failed to delete data');
        }
    }
}
