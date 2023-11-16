<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilaiAlternatif;
use App\Models\AnggotaModel;

class Alternatif extends BaseController
{
    
    function __construct()
    {
        $this->MNA = new ModelNilaiAlternatif;
        $this->AnggotaM = new AnggotaModel;
    }
    protected $helpers=['topsis'];
    public function index()
    {
        $data = [
            'title'=> 'Metode TOPSIS',
            'list_alternatif'=> $this->MNA->ListAlternatif(),
            'list_kriteria'=> $this->MNA->ListKriteria()
        ];
        return view('Alternatif/index', $data);
    }
    public function Add()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'anggota'=> $this->AnggotaM->findAll(),
                'kriteria'=> $this->MNA->ListKriteria()];
            $response = ['form'=> view('Alternatif/Add', $data)];
           echo json_encode($response);
        }
    }
    public function Save()
    {
        if ($this->request->isAJAX()) {
            $this->validate= \Config\Services::validation();
            // Deklarasi Validasi Login 
            $validate = $this->validate(
            [
            'anggota' => [
            'label'  => 'Nama Anggota',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'range' => [
            'label'  => 'Nama Kriteria',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            ]
            );
            // Jika Tidak Tervalidasi, Kembalikan Pesan Error 
            if (!$validate) {
            $response = [
            'error' => [
            'anggota' => $this->validate->getError('anggota'),
            'range' => $this->validate->getError('range')
            ]
            ];

            }else{
    
                $data = $this->request->getPost();
                $idAnggota = $data['anggota']; // Ambil satu ID anggota
                $alternatifData = [];
                foreach ($data['kriteria'] as $k => $kriteria_id) {
                    $alternatifData[] = [
                        'id_anggota' => $idAnggota,
                        'kriteria_id' => $kriteria_id,
                        'nilai' => $data['range'][$kriteria_id], // Perbarui ini
                    ];
                }

            // Cek apakah data alternatif sudah ada berdasarkan ID anggota
            $existingData = $this->MNA->where('id_anggota', $idAnggota)->findAll();
            if (!empty($existingData)) {
            // Jika data sudah ada, update data yang ada
            $this->MNA->whereIn('id_anggota', [$idAnggota])->delete(); // Hapus data lama
            // Kemudian insert data baru (termasuk data yang diupdate)
            $this->MNA->insertBatch($alternatifData);
            } else {
            // Jika data belum ada, langsung insert data baru
            $this->MNA->insertBatch($alternatifData);
            }        
            $response = [
            'sukses'=> true,
            'msg'=> !empty($existingData) ?  'Data Berhasil Diperbarui' : 'Data Berhasil Ditambahkan',
            'url'=> base_url('alternatif')
            ];
                
            }
            // $response = $_POST; 
           echo json_encode($response);
        }
    }

    public function getDataAlternatifByAnggota()
    {
        $anggota = $this->request->getPost('anggota'); // Ambil anggota yang dipilih dari AJAX POST
        $dataAlternatif = $this->MNA->where('id_anggota', $anggota)->findAll();
        // Mengirim data dalam format JSON sebagai respons AJAX
        return $this->response->setJSON($dataAlternatif);
    }

// Hapus Nilai Alternatif 
    public function Del()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
           $this->MNA->where('id_anggota', $id)->delete();
           $response = [
            'sukses'=> true,
            'msg'=>  'Data Berhasil Dihapus',
            'url'=> base_url('alternatif')
        ];
           echo json_encode($response);
        }
    }
}