<?php

namespace App\Controllers;

use App\Models\Buku;
use Core\Request;

class AdminBukuController
{
    protected $bukuModel;

    public function __construct()
    {
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
        }

        $this->bukuModel = new Buku();
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
        $books = $this->bukuModel->join('penerbit', 'buku.penerbit_id', '=', 'penerbit.id')
            ->join('genre', 'buku.genre_id', '=', 'genre.id')
            ->select(['buku.*', 'penerbit.nama as penerbit_nama', 'genre.nama as genre_nama'])
            ->get();

        $data = [
            'user' => auth(),
            'books' => $books
        ];

        return view('admin/buku/index', $data, 'admin');
    }
}