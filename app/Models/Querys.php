<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class Querys extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function view_users($condicion = null, $busqueda = null)
    {
        $builder = $this->db->table('view_users');
        if (is_array($condicion)) {
            return $builder->getWhere($condicion)->getResultArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }

}// class
