<?php

namespace App\Controllers;

use App\Models\Agenda;
use App\Models\Buku;
use App\Models\Genre;
use App\Models\OurLocation;
use App\Models\Penerbit;
use Core\FileDisplay;
use Core\Request;

class SiteController
{

    protected $bukuModel, $penerbitModel, $genreModel, $ourLocationModel, $agendaModel;

    public function __construct()
    {
        $this->bukuModel = new Buku();
        $this->penerbitModel = new Penerbit();
        $this->genreModel = new Genre();
        $this->ourLocationModel = new OurLocation();
        $this->agendaModel = new Agenda();
    }

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
            'books' => $books,
            'fileDisplay' => $fileDisplay,
        ];

        return view('index', $data, 'landing');
    }


    public function location(Request $request)
    {
        $ourLocations = $this->ourLocationModel->all();

        FileDisplay::initializeBaseUrl();

        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'ourLocations' => $ourLocations,
            'fileDisplay' => $fileDisplay,
        ];

        return view('location', $data, 'landing');
    }

    public function agenda(Request $request)
    {
        $agendaLists = $this->agendaModel->all();

        FileDisplay::initializeBaseUrl();

        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'agendaLists' => $agendaLists,
            'fileDisplay' => $fileDisplay,
        ];

        return view('agenda', $data, 'landing');
    }

    public function api(Request $request)
    {
        return json(['name' => $request->query('name')]);
    }

    public function page404(Request $request)
    {
        return view('page404')
            ->withStatus(404);
    }
}