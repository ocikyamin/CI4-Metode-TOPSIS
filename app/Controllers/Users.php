<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;

class Users extends BaseController
{
    protected $helpers=['topsis'];
    
    function __construct()
    {
        $this->userM = new ModelUser;
    }
    public function index()
    {
        $data = ['title'=> 'Dashboard'];
        return view('User/Home', $data);
    }
    public function Akun()
    {
        $data = [
            'title'=> 'My Account',
            'list_user'=> $this->userM->findAll()
    ];
        return view('User/Akun', $data);
    }


    public function Add()
    {
        if ($this->request->isAJAX()) {
            $response = ['form'=> view('User/Add')];
           echo json_encode($response);
        }
    }

    public function Edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $data = ['data'=> $this->userM->find($id)];
            $response = ['form'=> view('User/Edit', $data)];
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
            'email' => [
            'label'  => 'Email',
            'rules'  => 'required|is_unique[users.email]',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'nama_user' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'new_pass' => [
            'label'  => 'Password Baru',
            'rules'  => 'required',
            'errors' => [
            'required' => '{field} Harus Diisi'
            ]
            ],
            'conf_pass' => [
            'label'  => 'Konfirmasi Password',
            'rules'  => 'required|matches[new_pass]',
            'errors' => [
            'required' => '{field} Harus Diisi',
            'matches' => '{field} Tidak Sesuai',
            ]
            ],
            ]
            );
            // Jika Tidak Tervalidasi, Kembalikan Pesan Error 
            if (!$validate) {
            $response = [
            'error' => [
            'email' => $this->validate->getError('email'),
            'nama_user' => $this->validate->getError('nama_user'),
            'new_pass' => $this->validate->getError('new_pass'),
            'conf_pass' => $this->validate->getError('conf_pass')
            ]
            ];

            }else{
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('conf_pass');
                $nama_user = $this->request->getVar('nama_user');
                $data = [
                    'email'=> $email,
                    'password'=> password_hash($password, PASSWORD_BCRYPT),
                    'nama_user'=> $nama_user,
                ];

                $this->userM->save($data);
                $response = [
                    'sukses'=> true,
                    'msg'=> 'Data Berhasil Ditambahkan',
                    'url'=> base_url('user/akun')
                ];
                
            }
           echo json_encode($response);
        }
    }


    public function Update()
    {
        if ($this->request->isAJAX()) {
            $this->validate= \Config\Services::validation();
            $old_email = $this->request->getVar('old_email');
            $email = $this->request->getVar('email');
            // Deklarasi Validasi Login 
            $validate = $this->validate(
            [
            'email' => [
            'label'  => 'Email',
            'rules'  => $old_email==$email ? 'required' : 'required|is_unique[users.email]',
            'errors' => [
            'required' => '{field} Harus Diisi',
            'is_unique' => '{field} Telah digunakan'
            ]
            ],
            'nama_user' => [
            'label'  => 'Nama User',
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
            'email' => $this->validate->getError('email'),
            'nama_user' => $this->validate->getError('nama_user'),
            ]
            ];

            }else{
                $id = $this->request->getVar('id');
                $email = $this->request->getVar('email');
                $nama_user = $this->request->getVar('nama_user');
                $data = [
                    'id'=>$id,
                    'email'=> $email,
                    'nama_user'=> $nama_user,
                ];

                $this->userM->save($data);
                $response = [
                    'sukses'=> true,
                    'msg'=> 'Data Berhasil Diperbarui',
                    'url'=> base_url('user/akun')
                ];
                
            }
           echo json_encode($response);
        }
    }

    public function Del()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
           $this->userM->delete($id);
           $response = [
            'sukses'=> true,
            'msg'=>  'Data Berhasil Dihapus',
            'url'=> base_url('user/akun')
        ];
           echo json_encode($response);
        }
    }
    public function Logout()
    {
        session()->remove('USER');
        return redirect()->to(base_url('/'));
    }
}