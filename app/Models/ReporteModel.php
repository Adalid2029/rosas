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

    // Listar estudiantes para el reporte de centralizado
    public function listarEstudiantesCentralizador($id_curso_paralelo, $gestion)
    {
        $builder = $this->db->table("curso_estudiante");
        $builder->select('id_estudiante');
        $builder->where("id_curso_paralelo", $id_curso_paralelo);
        $builder->where("id_gestion", $gestion);
        return $builder->get()->getResultArray();
    }

    // LIstar nombre completo del estudiante segun id
    public function listarNombreCompletoEstudiante($id_estudiante)
    {
        $builder = $this->db->table("persona as p");
        $builder->select('p.materno, p.paterno, p.nombres');
        $builder->join('estudiante as e', 'p.id_persona = e.id_estudiante');
        $builder->where("e.id_estudiante", $id_estudiante);
        return $builder->get()->getResultArray();
    }

    // Obtener materias que para un curso
    public function obtenerMaterias($id_curso_paralelo, $gestion)
    {
        $builder = $this->db->table("estudiante_notas_curso");
        $builder->select('distinct(codigo)');
        $builder->where("id_curso_paralelo", $id_curso_paralelo);
        $builder->where("gestion", $gestion);
        return $builder->get()->getResultArray();
    }

    // obtener gestion
    public function sacarGestion($id_gestion)
    {
        $builder = $this->db->table("gestion");
        $builder->select('gestion');
        $builder->where("id_gestion", $id_gestion);
        return $builder->get()->getResultArray();
    }

    // Obtener notas de estudiantes
    public function obtenerNotasEstudiantes($id_estudiante, $codigo, $gestion)
    {
        $builder = $this->db->table("estudiante_notas_curso");
        $builder->select('nota1, nota2, nota3');
        $builder->where("id_estudiante", $id_estudiante);
        $builder->where("codigo", $codigo);
        $builder->where("gestion", $gestion);
        return $builder->get()->getResultArray();
    }

}//class
