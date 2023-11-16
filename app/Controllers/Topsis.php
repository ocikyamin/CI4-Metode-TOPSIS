<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilaiAlternatif;

class Topsis extends BaseController
{

    function __construct()
    {
        $this->MNA = new ModelNilaiAlternatif;
    }
    protected $helpers=['topsis'];
    public function index()
    {
        $data = [
            'title'=> 'Metode TOPSIS',
            'list_alternatif'=> $this->MNA->ListAlternatif(),
            'list_kriteria'=> $this->MNA->ListKriteria()
        ];
        return view('Topsis/index', $data);
    }
    public function Hasil()
    {
        $data = [
            'title'=> 'Hasil Keputusan TOPSIS',
            'hasil'=> $this->MNA->HasilTOPSIS()
        ];
        return view('Topsis/Hasil', $data);
    }
}