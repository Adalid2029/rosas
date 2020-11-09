<?php

namespace App\Controllers;
use App\Libraries\SSP;
class Persona extends BaseController
{
    // ADMINISTRATIVOS
    public function administrativo()
    {
        return $this->templater->view('administrativo', []);
    }

    // Listado de administrativos
    public function ajaxListarAdministrativos()
    {
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $table = "rs_view_administrativo";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_administrativo', 'dt' => 1),
                array('db' => 'nombres_apellidos', 'dt' => 2),
                array('db' => 'nacimiento', 'dt'        => 3),
                array('db' => 'telefono', 'dt'          => 4),
                array('db' => 'sexo', 'dt'              => 5),
                array('db' => 'cargo', 'dt'             => 6),
                array('db' => 'gestion_ingreso', 'dt'   => 7)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
        }else{
            return null;
        }

    }

    // MAESTROS
    public function maestro()
    {
        return $this->templater->view('maestro', []);
    }

    // Listado de administrativos
    public function ajaxListarMaestros()
    {
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $table = "rs_view_maestro";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_maestro', 'dt' => 1),
                array('db' => 'nombres_apellidos', 'dt' => 2),
                array('db' => 'nacimiento', 'dt'        => 3),
                array('db' => 'telefono', 'dt'          => 4),
                array('db' => 'sexo', 'dt'              => 5),
                array('db' => 'grado_academico', 'dt'   => 6)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
        }else{
            return null;
        }

    }
}
