<?php

namespace App\Controllers;

use App\Models\Genre; // Assuming the model name is Genre
use Core\Request;
use Core\Security;

class AdminGenreController
{
    protected $genreModel;

    public function __construct()
    {
        // Ensure user is authenticated
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        // Initialize Genre model
        $this->genreModel = new Genre();
    }

    /**
     * Display the list of genres.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = [
            'user' => auth(),
            'genres' => $this->genreModel->all()
        ];

        return view('admin/genre/index', $data, 'admin');
    }

    /**
     * Show the form to create a new genre.
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

        return view('admin/genre/tambah', $data, 'admin');
    }

    /**
     * Handle the creation of a new genre.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect('/admin-genre/create?error=Invalid CSRF token');
        }

        $data = [
            'nama   ' => $request->input('nama'),
        ];

        if ($this->genreModel->create($data)) {
            return redirect('/admin-genre/index?success=Data created successfully');
        } else {
            return redirect('/admin-genre/create?error=Failed to create data');
        }
    }

    /**
     * Show the form to edit an existing genre.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $genre = $this->genreModel->find($id);

        if (!$genre) {
            return redirect('/admin-genre/index?error=Data not found');
        }

        $data = [
            'user' => auth(),
            'csrfToken' => Security::getCsrfToken(),
            'genre' => $genre
        ];

        return view('admin/genre/edit', $data, 'admin');
    }

    /**
     * Handle the update of an existing genre.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect("/admin-genre/edit/$id?error=Invalid CSRF token");
        }

        $data = [
            'nama' => $request->input('nama'),
        ];

        if ($this->genreModel->update($id, $data)) {
            return redirect('/admin-genre/index?success=Data updated successfully');
        } else {
            return redirect("/admin-genre/edit/$id?error=Failed to update data");
        }
    }

    /**
     * Handle the deletion of a genre.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        if ($this->genreModel->delete($id)) {
            return redirect('/admin-genre/index?success=Data deleted successfully');
        } else {
            return redirect('/admin-genre/index?error=Failed to delete data');
        }
    }
}