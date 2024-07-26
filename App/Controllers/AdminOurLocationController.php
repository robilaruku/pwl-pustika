<?php

namespace App\Controllers;

use App\Models\OurLocation;
use Core\FileDisplay;
use Core\Request;
use Core\Security;

class AdminOurLocationController
{
    protected $ourLocationModel;

    public function __construct()
    {
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        $this->ourLocationModel = new OurLocation();
    }

    /**
     * Display the list of our locations.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $ourLocations = $this->ourLocationModel->all();

        FileDisplay::initializeBaseUrl();

        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'user' => auth(),
            'ourLocations' => $ourLocations,
            'fileDisplay' => $fileDisplay,
        ];

        return view('admin/our_location/index', $data, 'admin');
    }

    /**
     * Show the form to create a new our location.
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

        return view('admin/our_location/tambah', $data, 'admin');
    }

    /**
     * Show the form to create a new our location.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect(
                '/admin-our-location/create?error=' . urlencode('Invalid CSRF token')
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

                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'our_location_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    '/admin-our-location/create?error=' . urlencode($error)
                );
            }
        } else {
            if (
                isset($_FILES['gambar']['error']) &&
                $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $error = 'Error uploading file: ' . $_FILES['gambar']['error'];
                return redirect(
                    '/admin-our-location/create?error=' . urlencode($error)
                );
            }
        }

        $data = [
            'title' => $title,
            'description' => $description,
            'gambar' => $gambar,
        ];

        if ($this->ourLocationModel->create($data)) {
            return redirect(
                '/admin-our-location/index?success=' .
                    urlencode('Data created successfully')
            );
        } else {
            return redirect(
                '/admin-our-location/create?error=' .
                    urlencode('Failed to create data')
            );
        }
    }

    /**
     * Show the form to edit an existing our location.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $ourLocation = $this->ourLocationModel->find($id);

        if (!$ourLocation) {
            return redirect('/admin-our-location/index?error=Data not found');
        }

        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'ourLocation' => $ourLocation,
        ];

        return view('admin/our_location/edit', $data, 'admin');
    }

    public function update(Request $request, $id)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect("/admin-our-location/edit/$id?error=Invalid CSRF token");
        }

        $title = htmlspecialchars($request->input('title'));
        $description = htmlspecialchars($request->input('description'));
        $gambar = null;

        $existingOurLocation = $this->ourLocationModel->find($id);

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] === UPLOAD_ERR_OK
        ) {
            try {
                if (!empty($existingOurLocation['gambar'])) {
                    $existingImagePath = public_path(
                        'storage/uploaded_files/' . $existingOurLocation['gambar']
                    );
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $uploadedFile = new \Core\UploadedFile($_FILES['gambar']);

                $gambar = $uploadedFile->moveTo('uploaded_files', '', 'our_location_');
            } catch (\Exception $e) {
                $error = 'File upload failed: ' . $e->getMessage();
                return redirect(
                    "/admin-our-location/edit/$id?error=" . urlencode($error)
                );
            }
        } else {
            $gambar = $existingOurLocation['gambar'];
        }

        
        $data = [
            'title' => $title,
            'description' => $description,
            'gambar' => $gambar,
        ];


        if ($this->ourLocationModel->update($id, $data)) {
            return redirect(
                '/admin-our-location/index?success=Data updated successfully'
            );
        } else {
            return redirect("/admin-our-location/edit/$id?error=Failed to update data");
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
        $ourLocation = $this->ourLocationModel->find($id);

        if (!$ourLocation) {
            return redirect('/admin-our-location/index?error=Data not found');
        }

        if (!empty($book['gambar'])) {
            $filePath = 'storage/uploaded_files/' . $ourLocation['gambar'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($this->ourLocationModel->delete($id)) {
            return redirect(
                '/admin-our-location/index?success=Data deleted successfully'
            );
        } else {
            return redirect('/admin-our-location/index?error=Failed to delete data');
        }
    }
}
