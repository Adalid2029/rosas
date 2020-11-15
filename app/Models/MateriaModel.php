<?php

namespace App\Models;
use CodeIgniter\Database\Database;

class MateriaModel extends Database
{

    public $db = null;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

}
