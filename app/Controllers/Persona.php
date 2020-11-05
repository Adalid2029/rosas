<?php

namespace App\Controllers;
use App\Libraries\SSP;
class Persona extends BaseController
{
    public function administrativo()
    {
        return $this->templater->view('administrativo', []);
    }

    // Listado de administrativos
    public function ajaxListarAdministrativos()
    {
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $table = "view_administrativo";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_administrativo', 'dt' => 1),
                array('db' => 'tipo_marcado', 'dt'      => 2),
                array('db' => 'nombres_apellidos', 'dt' => 3),
                array('db' => 'nacimiento', 'dt'        => 4),
                array('db' => 'telefono', 'dt'          => 5),
                array('db' => 'sexo', 'dt'              => 6),
                array('db' => 'cargo', 'dt'             => 7),
                array('db' => 'gestion_ingreso', 'dt'   => 8)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            echo json_encode(
                SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
            );
        }

    }
}
