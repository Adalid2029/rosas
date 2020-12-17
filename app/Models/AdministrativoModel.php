<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class AdministrativoModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    // INSERT PERSONA
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

    // select para edit persona y administrativo
    public function personaAdministrativo($id)
    {
        $builder = $this->db->table("persona as p");
        $builder->select('*');
        $builder->join("administrativo as a", "p.id_persona = a.id_administrativo");
        $builder->join("usuario as u", "u.id_usuario = p.id_persona");
        $builder->join("grupo_usuario as gu", "gu.id_usuario = u.id_usuario", 'left');
        $builder->where("p.id_persona", $id);
        return $builder->get()->getResultArray();
    }

    // INSERT ADMINISTRATIVO
    public function administrativo($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this->db->table("administrativo");
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

    // VERIFICAR NOMBRE USUARIO
    public function verificarNombreUsuario($ci)
    {
        $builder = $this->db->table("usuario");
        $res = $builder->getWhere(["usuario" => $ci])->getResultArray();
        if ($res) {
            return false;
        } else {
            return true;
        }
    }

    // INSERT USUARIO
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
    public function administrativoReporte()
    {
        $builder = $this->db->table("view_administrativo");
        $builder->select('ci, nombres_apellidos, nacimiento, telefono, sexo, cargo, gestion_ingreso');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    public function contarPersonas($table)
    {
        $builder = $this->db->table($table);
        $builder->select('count(id_persona) as cantidad');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    public function contarKardex()
    {
        $builder = $this->db->table("kardex");
        $builder->select('count(id_kardex) as cantidad');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    public function contarCursos()
    {
        $builder = $this->db->table("curso_paralelo");
        $builder->select('count(id_curso_paralelo) as cantidad');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    public function contarAsistencia()
    {
        $builder = $this->db->table("asistencia");
        $builder->select('count(id_asistencia) as cantidad');
        $builder->where("estado", 1);
        return $builder->get()->getResultArray();
    }

    public function contarCalificaciones()
    {
        $builder = $this->db->table("calificacion");
        $builder->select('count(id_calificacion) as cantidad');
        return $builder->get()->getResultArray();
    }

    public function contarFaltasPorFechas()
    {
        $builder = $this->db->table("falta_cometida");
        $builder->select('count(fecha), fecha');
        $builder->where("estado", 1);
        $builder->groupBy("fecha");
        $builder->limit(9);
        return $builder->get()->getResultArray();
    }

}// class
