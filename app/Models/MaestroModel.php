<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class MaestroModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
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

    // MAESTRO
    public function maestro($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("maestro");
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

    // select para edit persona y maestro
    public function personaMaestro($id)
    {
        $builder = $this->db->table("persona as p");
        $builder->select('*');
        $builder->join("maestro as m", "p.id_persona = m.id_maestro");
        $builder->join("usuario as u", "u.id_usuario = p.id_persona");
        $builder->where("p.id_persona", $id);
        return $builder->get()->getResultArray();
    }
    public function listarMaestros($condicion = null)
    {
        $builder = $this->db->table('persona p');
        $builder->select('*');
        $builder->join('maestro m', 'm.id_maestro = p.id_persona');
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
}// class
