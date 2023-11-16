<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    public function CekEmail($email)
    {
     return $this->db->table('users')
     ->where('email', $email)
     ->get()
     ->getRow();
    }

   
}