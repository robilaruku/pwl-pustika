<?php

namespace App\Controllers;

use App\Models\Agenda;
use App\Models\Buku;
use App\Models\Genre;
use App\Models\OurLocation;
use App\Models\Penerbit;
use Core\Database;
use Core\FileDisplay;
use Core\Request;

class DetailBukuController
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

    public function index(Request $request, $id)
    {
        $sql = "
            SELECT 
                buku.*, 
                penerbit.nama AS penerbit_nama, 
                genre.nama AS genre_nama
            FROM 
                buku
            JOIN 
                penerbit ON buku.penerbit_id = penerbit.id
            JOIN 
                genre ON buku.genre_id = genre.id
            WHERE 
                buku.id = :id
        ";

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $book = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$book) {
            $this->page404();
            return;
        }

        FileDisplay::initializeBaseUrl();
        $fileDisplay = new FileDisplay('uploaded_files');

        $data = [
            'book' => $book,  
            'fileDisplay' => $fileDisplay,
        ];


        return view('detail', $data, 'landing');
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