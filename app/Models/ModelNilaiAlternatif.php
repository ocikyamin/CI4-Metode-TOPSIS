<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilaiAlternatif extends Model
{
    protected $table            = 'nilai_alternatif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];



    public function ListAlternatif($where= null)
    {
        if ($where !== null) {
            # code...
        }

        $query = $this->db->table('nilai_alternatif')
        ->select('nilai_alternatif.id_anggota, anggota.nama')
        ->join('anggota', 'anggota.id = nilai_alternatif.id_anggota')
        ->groupBy('nilai_alternatif.id_anggota')
        ->orderBy('nilai_alternatif.id_anggota', 'ASC')
        ->get();
        return $query->getResultArray();

    }


    public function ListKriteria()
    {

        $query = $this->db->table('kriteria')
        ->select('*')
        ->orderBy('id', 'ASC')
        ->get();
        return $query->getResultArray();

    }


    public function HasilTOPSIS()
    {


        $query = $this->db->table('nilai_topsis')
        ->select('anggota.nama,nilai_topsis.nilai')
        ->join('anggota', 'nilai_topsis.alternatif_id = anggota.id')
        ->get();
        return $query->getResultArray();

    }



}