<?php


namespace App\Controllers;


use App\Libraries\Ssp;
use App\Models\EstudianteModel;

class Estudiante extends BaseController
{

    public $model = null;

    public function __construct()
    {
        parent::__construct();
        $this -> model = new EstudianteModel();
    }

    // Cargar la vista estudiantes
    public function listarEstudiantes()
    {
        return $this->templater->view('personas/listarEstudiantes', []);
    }

    // Listado de estudiantes
    public function ajaxListarEstudiantes()
    {
        if ($this -> request -> isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_estudiante";
            $where = "estado = 1";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_estudiante', 'dt'     => 1),
                array('db' => 'rude', 'dt'              => 2),
                array('db' => 'ci', 'dt'                => 3),
                array('db' => 'nombres_apellidos', 'dt' => 4),
                array('db' => 'nacimiento', 'dt'        => 5),
                array('db' => 'telefono', 'dt'          => 6),
                array('db' => 'sexo', 'dt'              => 7),
                array('db' => 'gestion_ingreso', 'dt'   => 8)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where)));
        }else{
            return null;
        }

    }

}
