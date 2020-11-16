<?php
namespace App\Models;
use CodeIgniter\Database\Database;

class PerfilModel extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = \config\Database::connect();
    }

    // select contrase:a
    public function verificarPasswordActual()
    {
        $builder = $this -> db -> table("usuario as u");
        $builder -> select('usuario, clave');
        $builder -> where("u.id_usuario", $_SESSION["id_persona"]);
        return $builder->get() ->getResultArray();
    }

    // USUARIO
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
