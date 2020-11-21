<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class CursoModel extends Database
{

    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }


    // select para listado de niveles
    public function listarNiveles()
    {
        $builder = $this->db->table("curso");
        $builder->select('id_curso, nivel');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // select para listado de paralelos
    public function listarParalelos()
    {
        $builder = $this->db->table("paralelo");
        $builder->select('id_paralelo, paralelo');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    // responsable
    public function curso_paralelo($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("curso_paralelo");
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

}// class
