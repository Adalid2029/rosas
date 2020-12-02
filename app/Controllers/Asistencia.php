<?php

namespace App\Controllers;

use App\Controllers\Reportes\AsistenciaReporte;
use App\Libraries\Ssp;
use App\Models\AsistenciaModel;

class Asistencia extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $reporteAsistencia ;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AsistenciaModel();
        $this->reporteAsistencia = new AsistenciaReporte();
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

    // insertar asistencia o actualizar
    public function agregar_asistencia()
    {
        if($this->request->isAJAX())
        {
            $respuesta = $this->model->verificarMarcadoAsistenciaHoy($this->request->getPost("id"));
            if($respuesta){
                // Actualizar
                $data = array(
                    "id_maestro"    => $this->request->getPost("id_maestro"),
                    "valor"         => $this->request->getPost("valor"),
                    "actualizado_en"=> $this->fecha->format('Y-m-d H:i:s')
                );
                $cond = array(
                    "id_estudiante" => $this->request->getPost("id"),
                    "fecha"         => $this->fecha->format('Y-m-d')
                );

                $respuesta1 = $this->model->asistencia("update", $data, $cond, null);
                if ($respuesta1)
                {
                    return $this->response->setJSON(json_encode(array(
                        'exito' => "Asistencia modificado correctamente"
                    )));
                }
            }else{
                // Insertar
                $data = array(
                    "id_estudiante" => $this->request->getPost("id"),
                    "id_maestro"    => $this->request->getPost("id_maestro"),
                    "valor"         => $this->request->getPost("valor"),
                    "fecha"         => $this->fecha->format('Y-m-d'),
                    "hora"          => $this->fecha->format('H:i:s'),
                    "creado_en"     => $this->fecha->format('Y-m-d H:i:s')
                );

                $respuesta1 = $this->model->asistencia("insert", $data, null, null);
                if (is_numeric($respuesta1))
                {
                    return $this->response->setJSON(json_encode(array(
                        'exito' => "Asistencia registrado correctamente"
                    )));
                }
            }
        }
    }

    public function imprimirAsistencia()
    {
        $this->data["cursos_paralelos"] = $this->model->listarCursosParalelos();
        return $this->templater->view('reportes/reporteAsistencia', $this->data);
    }

    public function imprimir()
    {
        $this->response->setContentType('application/pdf');
        $this->reporteAsistencia->imprimir();
    }

}// class
