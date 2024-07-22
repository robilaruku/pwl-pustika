<?php

namespace App\Controllers;

use App\Models\Penerbit;
use Core\Request;
use Core\Security;

class AdminPenerbitController
{
    protected $penerbitModel;

    public function __construct()
    {
        // Ensure user is authenticated
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        // Initialize Penerbit model
        $this->penerbitModel = new Penerbit();
    }

    /**
     * Display the list of penerbit.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'user' => auth(),
            'penerbit' => $this->penerbitModel->all()
        ];

        return view('admin/penerbit/index', $data, 'admin');
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
            'csrfToken' => Security::getCsrfToken()
        ];

        return view('admin/penerbit/tambah', $data, 'admin');
    }

    /**
     * Handle the creation of a new penerbit.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect('/admin-penerbit/create?error=Invalid CSRF token');
        }

        $data = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
        ];

        if ($this->penerbitModel->create($data)) {
            return redirect('/admin-penerbit/index?success=Data created successfully');
        } else {
            return redirect('/admin-penerbit/create?error=Failed to create data');
        }
    }

    /**
     * Show the form to edit an existing penerbit.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $penerbit = $this->penerbitModel->find($id);

        if (!$penerbit) {
            return redirect('/admin-penerbit/index?error=Data not found');
        }

        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'penerbit' => $penerbit
        ];

        return view('admin/penerbit/edit', $data, 'admin');
    }

    /**
     * Handle the update of an existing penerbit.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect("/admin-penerbit/edit/$id?error=Invalid CSRF token");
        }

        $data = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
        ];

        if ($this->penerbitModel->update($id, $data)) {
            return redirect('/admin-penerbit/index?success=Data updated successfully');
        } else {
            return redirect("/admin-penerbit/edit/$id?error=Failed to update data");
        }
    }

    /**
     * Handle the deletion of a penerbit.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        if ($this->penerbitModel->delete($id)) {
            return redirect('/admin-penerbit/index?success=Data deleted successfully');
        } else {
            return redirect('/admin-penerbit/index?error=Failed to delete data');
        }
    }
}