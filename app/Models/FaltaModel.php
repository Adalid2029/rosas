<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class FaltaModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    // tipo falta
    public function falta_cometida($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("falta_cometida");
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

    // select contador
    public function selectContador($id)
    {
        $cond = array(
            "estado" => 1,
            "id_kardex" => $id
        );
        $builder = $this->db->table("kardex");
        $builder->select('contador');
        $builder->where($cond);
        return $builder->get()->getResultArray();
    }

    // verificar 5 faltas
    public function verificar5Faltas($idkardex)
    {
        $cond = array(
            "id_kardex" => $idkardex
        );
        $builder = $this->db->table("kardex");
        $builder->select('contador');
        $builder->where($cond);
        return $builder->get()->getResultArray();
    }

    // tipo falta
    public function citacion($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("citacion");
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

    // tipo falta
    public function seleccionarFaltas($id_tipo_falta)
    {
        $cond = array(
            "id_tipo_falta" => $id_tipo_falta
        );
        $builder = $this->db->table("falta");
        $builder->select('id_falta, descripcion');
        $builder->where($cond);
        return $builder->get()->getResultArray();
    }

    public function editarFalta($id_falta)
    {

        $builder = $this->db->table("falta_cometida as fc");
        $builder->select('fc.id_falta_cometida, fc.id_kardex, fc.id_falta, fc.fecha, fc.registrante, fc.visto, tf.id_tipo_falta, f.descripcion');
        $builder->join("falta as f", "fc.id_falta = f.id_falta");
        $builder->join("tipo_falta as tf", "f.id_tipo_falta = tf.id_tipo_falta");
        return $builder->getWhere(array("fc.id_falta_cometida" => $id_falta));
    }


}
