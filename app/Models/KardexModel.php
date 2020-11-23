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


} // class
