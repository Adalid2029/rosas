<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class KardexModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    // responsable
    public function kardex($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("kardex");
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

    // select para listado de tutores en la vista
    public function listarCursos()
    {
        $builder = $this->db->table("view_curso_paralelo");
        $builder->select('id_curso_paralelo, concat(nivel, " ", paralelo) as curso');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select para listado de tutores en la vista
    public function listarTipoFaltas()
    {
        $builder = $this->db->table("tipo_falta");
        $builder->select('id_tipo_falta, nombre');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select maestros
    public function listarMaestros()
    {
        $builder = $this->db->table("view_maestro");
        $builder->select('nombres_apellidos');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select materias
    public function listarMaterias()
    {
        $builder = $this->db->table("materia");
        $builder->select('id_materia, nombre');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select maestros
    public function listarTutoresEstudiante($condicion = null)
    {
        $builder = $this->db->table("kardex k");
        $builder->select('*');
        $builder->join('estudiante e', 'e.id_estudiante = k.id_estudiante');
        $builder->join('responsable r', 'r.id_estudiante = e.id_estudiante');
        $builder->join('tutor t', 't.id_tutor = r.id_tutor');
        $builder->join('persona p', 'p.id_persona = t.id_tutor');
        $builder->where("p.estado", 1);
        return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
    }
} // class
