<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class AsistenciaModel extends Database
{

    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    public function asistencia($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("asistencia");
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

    public function listarCursosParalelos()
    {
        $builder = $this->db->table("view_curso_paralelo");
        $builder->select('id_curso_paralelo, id_curso, concat(nivel, " ", paralelo)as curso');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }

    public function listarMaestros()
    {
        $builder = $this->db->table("view_maestro");
        $builder->select('id_maestro, nombres_apellidos');
        $builder->where(array("estado" => 1));
        return $builder->get()->getResultArray();
    }


}// class
