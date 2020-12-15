<?php

namespace App\Models;
use CodeIgniter\Database\Database;

class ReporteModel extends Database
{
    public $db = null;
    public $fecha;

    public function __construct()
    {
        $this->db = \config\Database::connect();
        $this->fecha = new \DateTime();
    }

    public function listarCursosParalelos()
    {
        $builder = $this->db->table("view_curso_paralelo");
        $builder->select('id_curso_paralelo, id_curso, concat(nivel, " ", paralelo)as curso');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

    public function listarFaltas()
    {
        $builder = $this->db->table("falta");
        $builder->select('id_falta, descripcion');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

    public function listarFaltasEstudiantes($id, $fecha)
    {
        $builder = $this->db->table("view_falta_estudiante");
        $builder->select('fecha, area, id_falta, descripcion');
        $builder->where("id_estudiante", $id);
        $builder->where("gestion", $this->fecha->format('Y'));
        $builder->where("fecha =", $fecha);
        return $builder->get()->getResultArray();
    }

    public function listarFaltasEstudiantesFechas($id, $fechaInicial, $fechaFinal)
    {
        $builder = $this->db->table("view_falta_estudiante");
        $builder->select('distinct(fecha)');
        $builder->where("id_estudiante", $id);
        $builder->where("gestion", $this->fecha->format('Y'));
        $builder->where("fecha >=", $fechaInicial);
        $builder->where("fecha <=", $fechaFinal);
        return $builder->get()->getResultArray();
    }

    public function listarGestiones()
    {
        $builder = $this->db->table("gestion");
        $builder->select('id_gestion, gestion');
        $builder->orderBy("id_gestion DESC");
        return $builder->get()->getResultArray();
    }

}//class
