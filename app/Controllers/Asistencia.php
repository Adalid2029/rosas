<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\AsistenciaModel;

class Asistencia extends BaseController
{
    public $model = null;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AsistenciaModel();
        $this->fecha = new \DateTime();
    }

    public function index()
    {
        $this->data["cursos_paralelos"] = $this->model->listarCursosParalelos();
        $this->data["maestros"] = $this->model->listarMaestros();
        return $this->templater->view('asistencia/asistencia', $this->data);
    }

    // listado de estudiantes por pararelos y gestion
    public function ajaxListarEstudiantesParalelos()
    {
        $anio = $this->fecha->format('Y');
        $table = "rs_view_asistencia";
        $primaryKey = 'id_persona';
        $curso_recibido = $this->request->getGet("curso");
        $curso = explode(" ", $curso_recibido);
        $where = "estado = 1 and gestion=".$anio." and nivel='".$curso[0]."' and paralelo='".$curso[1]."'";
        $columns = array(
            array('db' => 'id_persona', 'dt'          => 0),
            array('db' => 'id_curso_estudiante', 'dt' => 1),
            array('db' => 'nombre_completo', 'dt'     => 2),
            array('db' => 'curso', 'dt'               => 3),
            array('db' => 'gestion', 'dt'             => 4),
            array('db' => 'nivel', 'dt'               => 5),
            array('db' => 'paralelo', 'dt'            => 6)
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where)));
    }


}// class
