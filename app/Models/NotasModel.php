<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class NotasModel extends Database
{
    public $db = null;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function listarCursos($condicion = null, $orden = '', $agrupacion = '')
    {
        $builder = $this->db->table('maestro m');
        $builder->select('*');
        $builder->join('materia_maestro mm', 'mm.id_maestro = m.id_maestro', 'left');
        $builder->join('curso_paralelo cu', 'cu.id_curso_paralelo = mm.id_curso_paralelo');
        $builder->join('curso c', 'c.id_curso = cu.id_curso');
        $builder->join('materia ma', 'ma.id_materia = mm.id_materia');
        $builder->join('gestion g', 'g.id_gestion = mm.id_gestion');
        if (is_array($condicion))
            $builder->where($condicion);
        $builder->groupBy($agrupacion);
        $builder->orderBy($orden);
        return $builder->get();
    }

    public function calificacion($accion, $datos, $condicion = null)
    {
        $builder = $this->db->table('calificacion');
        switch ($accion) {
            case 'select':
                return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
                break;
            case 'insert':
                return $builder->insert($datos) ? $this->db->insertID() : $this->db->error();
                break;
            case 'update':
                return $builder->update($datos, $condicion) ? true : $this->db->error();
                break;
        }

        return null;
    }
    public function listarEstudiantes($condicion = null)
    {
        $builder = $this->db->table('persona p');
        $builder->select("e.id_estudiante, concat(p.nombres,' ',p.paterno,' ', p.materno,' CI.: ',p.ci,' ',p.exp) as nombre_completo");
        $builder->join('estudiante e', 'e.id_estudiante = p.id_persona');
        return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
    }

    public function cursosParalelos($condicion = null)
    {
        $builder = $this->db->table('curso_paralelo cp');
        $builder->select("*");
        $builder->join('curso c', 'c.id_curso = cp.id_curso');
        $builder->join('paralelo p', 'p.id_paralelo = cp.id_paralelo');
        return is_array($condicion) ? $builder->getWhere($condicion) : $builder->get();
    }
}
