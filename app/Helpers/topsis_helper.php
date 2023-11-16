<?php
function DB()
{
return $db= \Config\Database::connect(); 
}

// User Login 

function UserLogin()
{   
     return DB()->table('users')
       ->where('id',session('USER'))
       ->get()
       ->getRow();

       
     
}


// Dapatkan Nilai setiap alternatif 
function NilaiAlternatif($id_anggota=null, $kriteria_id=null)
{
    if ($id_anggota===null || $kriteria_id===null) {
        return 0;
    }
   
     return DB()->table('nilai_alternatif')
       ->select('nilai_alternatif.nilai')
       ->where('nilai_alternatif.id_anggota',$id_anggota)
       ->where('nilai_alternatif.kriteria_id',$kriteria_id)
       ->get()
       ->getRow();

       
     
}


function SubKriteria($kriteria_id=null)
{
    if ($kriteria_id===null) {
        return 0;
    }
   
     return DB()->table('kriteria_sub')
       ->select('*')
       ->where('kriteria_id',$kriteria_id)
       ->get()
       ->getResultArray();

       
     
}


// Update Nilai akar ke tabel kriteria
function updateNilaiAkar($idKriteria, $nilaiAkar)
{
    $data = [
        'nilai_akar' => $nilaiAkar
    ];
    DB()->table('kriteria')
        ->where('id', $idKriteria)
        ->update($data);
}


function TotalBobot()
{
return DB()->table('kriteria')
->selectSum('bobot')
->get()
->getRow();

}


if (!function_exists('simpanNilaiMax')) {
    function simpanNilaiMax($idKriteria, $nilaiMax)
    {
        $data = [
            'nilai_max' => $nilaiMax
        ];

        DB()->table('kriteria')
            ->where('id', $idKriteria)
            ->update($data);
    }
}

if (!function_exists('simpanNilaiMin')) {
    function simpanNilaiMin($idKriteria, $nilaiMin)
    {
     

        $data = [
            'nilai_min' => $nilaiMin
        ];

        DB()->table('kriteria')
            ->where('id', $idKriteria)
            ->update($data);
    }
}

if (!function_exists('hitungBesarPinjaman')) {
    function hitungBesarPinjaman($referensi)
    {
        if ($referensi <= 0) {
            return '<span class="badge rounded-pill text-bg-danger">Besar Pinjaman 0</span>';
        } elseif ($referensi <= 0.25) {
            // return 'Besar Pinjaman Maksimal 25 Juta';
            return '<span class="badge rounded-pill text-bg-warning">Maksimal 25 Juta</span>';
        } elseif ($referensi <= 0.50) {
            // return 'Besar Pinjaman Maksimal 50 Juta';
            return '<span class="badge rounded-pill text-bg-warning">Maksimal 50 Juta</span>';
        } elseif ($referensi <= 0.75) {
            return '<span class="badge rounded-pill text-bg-primary"> Maksimal 100 Juta</span>';
            // return 'Besar Pinjaman Maksimal 100 Juta';
        } else {
            return '<span class="badge rounded-pill text-bg-success"> Maksimal 200 Juta</span>';
            // return 'Besar Pinjaman Maksimal 200 Juta';
        }
    }
}
if (!function_exists('Keputusan')) {
    function Keputusan($referensi)
    {
        if ($referensi <= 0) {
            return '><=0';
            
        } elseif ($referensi <= 0.25) {
            return '>0 - <=0,25';
        } elseif ($referensi <= 0.50) {
            return '>0,25 - <=0,50';
        } elseif ($referensi <= 0.75) {
            return '>0,50 - <=0,75';
        } else {
            return '>0,75';
        }
    }
}



if (!function_exists('simpanNilaiTopsis')) {
    function simpanNilaiTopsis($alternatif_id, $nilai)
    {
        $data = [
            'alternatif_id' => $alternatif_id,
            'nilai' => $nilai
        ];

        // Cek apakah data dengan alternatif_id sudah ada dalam tabel
        $existingData = DB()->table('nilai_topsis')
            ->where('alternatif_id', $alternatif_id)
            ->get()
            ->getRow();

        if ($existingData) {
            // Jika data sudah ada, update nilai
            DB()->table('nilai_topsis')
                ->where('alternatif_id', $alternatif_id)
                ->update($data);
        } else {
            // Jika data belum ada, insert data baru
            DB()->table('nilai_topsis')->insert($data);
        }
    }
}