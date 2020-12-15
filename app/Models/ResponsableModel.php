<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class ResponsableModel extends Database
{

    public $db = null;
    public $fecha;

    public function __construct()
    {
        $this->db = \config\Database::connect();
        $this->fecha = new \DateTime();
    }

    // responsable
    public function responsable($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("responsable");
        switch ($accion) {
            case 'select':
                if (is_array($condicion)) {
                    return $builder->getWhere($condicion);
                } else {
                    return $builder->get();
                }
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();
                break;
            case 'search':
                return $builder->like('nombres', $busqueda)->get()->getResultArray();
                break;
        }

        return null;
    }

    // select para listado de estudiantes en la vista
    public function listarEstudiantes()
    {
        $builder = $this->db->table("view_estudiante");
        $builder->select('id_estudiante, nombres_apellidos, ci');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select para listado de estudiantes con sus cursos
    public function listarEstudiantesCursos($curso_paralelo)
    {
        $builder = $this->db->table("view_estudiantes_cursos");
        $builder->select('id_estudiante, nombre_completo');
        $builder->where("estado", 1);
        $builder->where("id_curso_paralelo", $curso_paralelo);
        $builder->where("gestion", $this->fecha->format('Y'));
        return $builder->get()->getResultArray();
    }

    // select para listado de tutores en la vista
    public function listarTutores()
    {
        $builder = $this->db->table("view_tutor");
        $builder->select('id_tutor, nombres_apellidos, ci');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

}//class // class
