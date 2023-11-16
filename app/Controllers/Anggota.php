<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $helpers=['topsis'];
    function __construct()
    {
        $this->AnggotaM = new AnggotaModel;
    }
    public function index()
    {
        $data = [
            'title'=> 'Anggota',
            'anggota'=> $this->AnggotaM->findAll()
        ];
        return view('Anggota/index', $data);
    }
    public function Add()
    {
        if ($this->request->isAJAX()) {
           
            $response = ['form'=> view('Anggota/Add')];
           echo json_encode($response);
        }
    }
    public function Edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = ['data'=> $this->AnggotaM->find($id)];
            $response = ['form'=> view('Anggota/Edit', $data)];
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
            'no_anggota' => [
            'label'  => 'Nomor Anggota',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'nama' => [
            'label'  => 'Nama Anggota',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'jk' => [
            'label'  => 'Jenis Kelamin',
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
            'no_anggota' => $this->validate->getError('no_anggota'),
            'nama' => $this->validate->getError('nama'),
            'jk' => $this->validate->getError('jk')
            ]
            ];

            }else{
                $id = $this->request->getVar('id');
                $no_anggota = $this->request->getVar('no_anggota');
                $nama = $this->request->getVar('nama');
                $jk = $this->request->getVar('jk');
                $data = [
                    'id'=> $id==""? NULL : $id,
                    'no_anggota'=> $no_anggota,
                    'nama'=> $nama,
                    'jk'=> $jk
                ];

                $this->AnggotaM->save($data);
                $response = [
                    'sukses'=> true,
                    'msg'=>  $id==""? 'Data Berhasil Ditambahkan' : 'Data Berhasil Diperbarui',
                    'url'=> base_url('anggota')
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
           $this->AnggotaM->delete($id);
           $response = [
            'sukses'=> true,
            'msg'=>  'Data Berhasil Dihapus',
            'url'=> base_url('anggota')
        ];
           echo json_encode($response);
        }
    }
}