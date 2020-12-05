<?php

namespace App\Models;
use CodeIgniter\Database\Database;

class ReporteModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    public function listarCursosParalelos()
    {
        $builder = $this->db->table("view_curso_paralelo");
        $builder->select('id_curso_paralelo, id_curso, concat(nivel, " ", paralelo)as curso');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

}//class
