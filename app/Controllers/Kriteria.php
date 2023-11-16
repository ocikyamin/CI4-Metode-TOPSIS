<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModel;

class Kriteria extends BaseController
{
    protected $helpers=['topsis'];
    function __construct()
    {
        $this->KriteriaM = new KriteriaModel;
    }
    public function index()
    {
        $data = [
            'title'=> 'Kriteria',
            'kriteria'=> $this->KriteriaM->findAll()
        ];
        return view('Kriteria/index', $data);
    }
    public function Add()
    {
        if ($this->request->isAJAX()) {
           
            $response = ['form'=> view('Kriteria/Add')];
           echo json_encode($response);
        }
    }
    public function Edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = ['data'=> $this->KriteriaM->find($id)];
            $response = ['form'=> view('Kriteria/Edit', $data)];
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
            'kode' => [
            'label'  => 'Kode Kriteria',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'nm_kriteria' => [
            'label'  => 'Nama Kriteria',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'bobot' => [
            'label'  => 'Bobot Kriteria',
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
            'kode' => $this->validate->getError('kode'),
            'nm_kriteria' => $this->validate->getError('nm_kriteria'),
            'bobot' => $this->validate->getError('bobot')
            ]
            ];

            }else{
                $id = $this->request->getVar('id');
                $kode = $this->request->getVar('kode');
                $nm_kriteria = $this->request->getVar('nm_kriteria');
                $bobot = $this->request->getVar('bobot');
                $data = [
                    'id'=> $id==""? NULL : $id,
                    'kode'=> $kode,
                    'nm_kriteria'=> $nm_kriteria,
                    'bobot'=> $bobot
                ];

                $this->KriteriaM->save($data);
                $response = [
                    'sukses'=> true,
                    'msg'=>  $id==""? 'Data Berhasil Ditambahkan' : 'Data Berhasil Diperbarui',
                    'url'=> base_url('kriteria')
                ];
                
            }
            // $response = $_POST; 
           echo json_encode($response);
        }
    }

    public function Del()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
           $this->KriteriaM->delete($id);
           $response = [
            'sukses'=> true,
            'msg'=>  'Data Berhasil Dihapus',
            'url'=> base_url('kriteria')
        ];
           echo json_encode($response);
        }
    }
}