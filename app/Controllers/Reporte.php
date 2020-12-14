<?php

namespace App\Controllers;

use App\Controllers\Reportes\SeguimientoReporte;
use App\Libraries\Ssp;
use App\Models\ReporteModel;
use App\Models\NotasModel;

class Reporte extends  BaseController
{

    public $model = null;
    public $reporteSeguimiento;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ReporteModel();
        $this->reporteSeguimiento = new SeguimientoReporte();
        $this->fecha = new \DateTime();
    }

    public function imprimirSeguimiento()
    {
        $this->data["cursos_paralelos"] = $this->model->listarCursosParalelos();
        return $this->templater->view('reportes/imprimirSeguimiento', $this->data);
    }

    public function imprimirCentralizadorInterno()
    {
        $cursos = [];
        foreach ((new NotasModel)->listarCursos(null, '', 'cu.id_curso_paralelo')->getResultArray() as $key => $value) {
            $materiasCurso = (new NotasModel)->listarCursos(['mm.id_curso_paralelo' => $value['id_curso_paralelo']], '', '')->getResultArray();
            if ($materiasCurso != null) $cursos[] = array_merge($materiasCurso[0], ['materiasCurso' => $materiasCurso]);
        }
        $this->data['materiasCurso'] = $cursos;
        // var_dump($this->db->getLastQuery());
        // echo json_encode($cursos);
        // return;
        return $this->templater->view('reportes/imprimirCentralizadorInterno', $this->data);
    }

    // listado de estudiantes por pararelos y gestion
    public function ajaxListarEstudiantesParalelos()
    {
        $anio = $this->fecha->format('Y');
        $table = "rs_view_seguimiento";
        $primaryKey = 'id_persona';
        $curso_recibido = $this->request->getGet("curso");
        $curso = explode(" ", $curso_recibido);
        $where = "estado = 1 and gestion=" . $anio . " and nivel='" . $curso[0] . "' and paralelo='" . $curso[1] . "'";
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

    public function imprimirSeguimientoEstudiante()
    {
        //        set_time_limit(1000000000);
        $id = $this->request->getGet("id");
        $fechaI = $this->request->getGet("fechaInicio");
        $fechaF = $this->request->getGet("fechaFinal");
        $nombre_completo = $this->request->getGet("nombre");
        $curso_paralelo = $this->request->getGet("curso_paralelo");
        $faltas = $this->model->listarFaltas();
        $fechas = $this->model->listarFaltasEstudiantesFechas($id, $fechaI, $fechaF);

        if (count($fechas) != 0) {
            $data = array();
            for ($k = 0; $k < count($fechas); $k++) {
                $fila = array();
                $consulta = $this->model->listarFaltasEstudiantes($id, $fechas[$k]["fecha"]);
                $j = 0;
                array_push($fila, $consulta[$j]['fecha']);
                array_push($fila, $consulta[$j]['area']);
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                array_push($fila, "0");
                for ($j = 0; $j < count($consulta); $j++) {
                    $fila[$consulta[$j]["id_falta"] + 1] = "x";
                }
                array_push($data, $fila);
            }
            $this->response->setContentType('application/pdf');
            $this->reporteSeguimiento->imprimir($data, $fechaI, $fechaF, $faltas, $nombre_completo, $curso_paralelo, $fechas);
        } else {
            $data = null;
            $this->response->setContentType('application/pdf');
            $this->reporteSeguimiento->imprimir($data, $fechaI, $fechaF, $faltas, $nombre_completo, $curso_paralelo, $fechas);
        }
    }
}//class
