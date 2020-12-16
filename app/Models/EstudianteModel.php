<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class EstudianteModel extends Database
{
    public $db = null;
    public $fecha = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
        $this->fecha = new \DateTime();
    }

    // PERSONA
    public function persona($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("persona");
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

    // ESTUDIANTE
    public function estudiante($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("estudiante");
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

    // USUARIO
    public function usuario($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("usuario");
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

    // select para edit persona y administrativo
    public function personaEstudiante($id)
    {
        $builder = $this->db->table("persona as p");
        $builder->select('*');
        $builder->join("estudiante as e", "p.id_persona = e.id_estudiante");
        $builder->join("usuario as u", "u.id_usuario = p.id_persona");
        $builder->join("grupo_usuario as gu", "gu.id_usuario = p.id_persona", 'left');
        $builder->where("p.id_persona", $id);
        return $builder->get()->getResultArray();
    }

    // select para listado de estudiantes con sus cursos
    public function listarEstudiantesCursos($curso_paralelo)
    {
        $builder = $this->db->table("rs_view_estudiantes_cursos_consulta");
        $builder->select('rude, ci, nombre_completo, curso, nacimiento, telefono, sexo, gestion');
        $builder->where("estado", 1);
        if ($curso_paralelo != "todos")
        {
            $builder->where("id_curso_paralelo", $curso_paralelo);
        }

        $builder->where("gestion", $this->fecha->format('Y'));
        return $builder->get()->getResultArray();
    }

    public function seleccionarCursoParalelo($id_curso_paralelo)
    {
        $builder = $this->db->table("rs_view_estudiantes_cursos_consulta");
        $builder->select('curso');
        $builder->where("estado", 1);
        $builder->where("id_curso_paralelo", $id_curso_paralelo);
        $builder->where("gestion", $this->fecha->format('Y'));
        return $builder->get()->getResultArray();
    }

}// class
