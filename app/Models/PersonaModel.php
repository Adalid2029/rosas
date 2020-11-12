<?php

namespace App\Models;

use CodeIgniter\Database\Database;

class PersonaModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this -> db = \config\Database::connect();
    }

    // INSERT PERSONA
    public function persona($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this -> db -> table("persona");
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
        $builder = $this -> db -> table("persona as p");
        $builder -> select('*');
        $builder -> join("administrativo as a", "p.id_persona = a.id_persona");
        $builder -> where("p.id_persona", $id);
        return $builder->get() ->getResultArray();
    }

    // INSERT ADMINISTRATIVO
    public function administrativo($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this -> db -> table("administrativo");
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
        $builder = $this -> db -> table("usuario");
        $res = $builder ->getWhere(["usuario" => $ci])->getResultArray();
        if($res)
        {
            return false;
        }else{
            return true;
        }
    }

    // INSERT USUARIO
    public function usuario($accion, $datos, $condicion = null, $busqueda = null)
    {
        $builder = $this -> db -> table("usuario");
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


}
