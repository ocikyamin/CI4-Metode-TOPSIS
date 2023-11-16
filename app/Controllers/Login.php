<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;

class Login extends BaseController
{
    function __construct()
    {
        $this->userM = new ModelUser;
    }
    public function index()
    {
        //  $tes = password_hash('admin', PASSWORD_BCRYPT);
        //  var_dump($tes);
        return view('Login');
    }
    
    public function Cek()
    {
        if ($this->request->isAJAX()) {
                 // Pangil Service Validation 
          $this->validate= \Config\Services::validation();
          // Deklarasi Validasi Login 
          $validate = $this->validate(
              [
          'email' => [
              'label'  => 'Email',
              'rules'  => 'required',
              'errors' => [
                  'required' => '{field} Harus Diisi'
                  ]
          ],
          'password' => [
              'label'  => 'Password',
              'rules'  => 'required',
              'errors' => [
                  'required' => '{field} Harus Diisi'
                  ]
              ],
              ]
          );
          // Jika Tidak Tervalidasi, Kembalikan Pesan Error 
          if (!$validate) {
              $reponse = [
              'error' => [
              'email' => $this->validate->getError('email'),
              'password' => $this->validate->getError('password')
              ]
              ];

            }else{
           
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                // Dapatkan Identitas User 
                $user = $this->userM->CekEmail($email);
                if ($user) {
                // Verifikasi password
                $is_valid = password_verify($password, $user->password);
                if ($is_valid) {
                # Redirect ke halaman user
                $new_session = ['USER' => $user->id];
                session()->set($new_session);
                $reponse = [
                'sukses'=> 'ok',
                'url'=> base_url('user')
                ];

                }else{
                // Jika Email Tidak tersedia 
                $reponse = [
                'error'=> [
                'email'=> 'Email Tidak Ditemukan.']
                ];
                }

                }
        }
            
        }

        echo json_encode($reponse);
        
     
    }
}