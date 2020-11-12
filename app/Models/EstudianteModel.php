<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class EstudianteModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this -> db = \config\Database::connect();
    }

}
