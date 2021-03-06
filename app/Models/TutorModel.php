<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class TutorModel extends Database
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
    public function tutor($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("tutor");
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
    public function personaTutor($id)
    {
        $builder = $this->db->table("persona as p");
        $builder->select('*');
        $builder->join("tutor as t", "p.id_persona = t.id_tutor");
        $builder->join("usuario as u", "u.id_usuario = p.id_persona");
        $builder->join("grupo_usuario as gu", "gu.id_usuario = p.id_persona", 'left');
        $builder->where("p.id_persona", $id);
        return $builder->get()->getResultArray();
    }

    // select para edit persona y administrativo
    public function listarTutoresReporte()
    {
        $builder = $this->db->table("view_tutor");
        $builder->select('ci, nombres_apellidos, correo, telefono, sexo, parentesco');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }
}// class
