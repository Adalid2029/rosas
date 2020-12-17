<?php

namespace App\Controllers;

use App\Controllers\Reportes\CentralizadorAreasReporte;
use App\Controllers\Reportes\SeguimientoReporte;
use App\Libraries\Ssp;
use App\Models\ReporteModel;
use App\Models\NotasModel;

class Reporte extends  BaseController
{

    public $model = null;
    public $reporteSeguimiento;
    public $reporteCentralizador;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ReporteModel();
        $this->reporteSeguimiento = new SeguimientoReporte();
        $this->reporteCentralizador = new CentralizadorAreasReporte();
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

    public function imprimirCentralizador()
    {
        $this->data["cursos_paralelos"] = $this->model->listarCursosParalelos();
        $this->data["gestiones"] = $this->model->listarGestiones();
        return $this->templater->view('reportes/imprimirCentralizador', $this->data);
    }

    public function imprimirCentralizadorAreas()
    {
        $paralelo = $this->request->getGet("paralelo");
        $id_gestion = $this->request->getGet("gestion");



        $curso = explode(' ', $paralelo);

        if (isset($curso[0]) && $curso[0] == "PRIMERO" || $curso[0] == "SEGUNDO") {
            // Imprimir para los paralelos primero y segundo de secundaria
            $id_curso_paralelo = $this->request->getGet("id_curso_paralelo");
            $data = array();
            $estudiantes = $this->model->listarEstudiantesCentralizador($id_curso_paralelo, $id_gestion);
            $gestion = $this->model->sacarGestion($id_gestion);

            $codigo_materias = array("LCO", "LE", "CS", "EFI", "EMU", "APV", "MAT", "TTG", "CNBIO", "VER", "CFS");
            for($i = 0; $i < count($estudiantes); $i++)
            {

                $nombre_completo = $this->model->listarNombreCompletoEstudiante($estudiantes[$i]["id_estudiante"]);
                $fila = array();
                for ($j = 0; $j < count($nombre_completo); $j++)
                {
                    array_push($fila, $nombre_completo[$j]["paterno"]);
                    array_push($fila, $nombre_completo[$j]["materno"]);
                    array_push($fila, $nombre_completo[$j]["nombres"]);

                    $suma1 = 0;
                    $suma2 = 0;
                    $suma3 = 0;

                    for($h = 0; $h < count($codigo_materias); $h++)
                    {
                        $notas = $this->model->obtenerNotasEstudiantes($estudiantes[$i]["id_estudiante"], $codigo_materias[$h], $gestion[0]["gestion"]);

                        if (count($notas) == 0 ||count($notas) == null)
                        {
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                        }else{

                            for ($b = 0; $b < count($notas); $b++)
                            {
                                $nota1 = $notas[0]["nota1"]== null? 0 : $notas[0]["nota1"];
                                $nota2 = $notas[0]["nota2"]== null? 0 : $notas[0]["nota2"];
                                $nota3 = $notas[0]["nota3"]== null? 0 : $notas[0]["nota3"];

                                $suma1 = $suma1 + $nota1;
                                $suma2 = $suma2 + $nota2;
                                $suma3 = $suma3 + $nota3;

                                array_push($fila, $notas[0]["nota1"]== null? "" : $notas[0]["nota1"]);
                                array_push($fila,  $notas[0]["nota2"]== null? "" : $notas[0]["nota2"]);
                                array_push($fila,  $notas[0]["nota3"]== null? "" : $notas[0]["nota3"]);

                            }


                        }


                    }

                    array_push($fila, round($suma1/11));
                    array_push($fila, round($suma2/11));
                    array_push($fila, round($suma3/11));


                }

                if (isset($fila)) {
                    array_push($data, $fila);
                }

            }
        } else if ($curso[0] == "TERCERO" || $curso[0] == "CUARTO") {
            // Imprimir para los paralelos tercero y cuarto de secundaria
            $id_curso_paralelo = $this->request->getGet("id_curso_paralelo");
            $data = array();
            $estudiantes = $this->model->listarEstudiantesCentralizador($id_curso_paralelo, $id_gestion);
            $gestion = $this->model->sacarGestion($id_gestion);

            $codigo_materias = array("LCO", "LE", "CS", "EFI", "EMU", "APV", "MAT", "TTG","CNFIS", "CNQMC", "CNBIO", "VER", "CFS");
            for($i = 0; $i < count($estudiantes); $i++)
            {

                $nombre_completo = $this->model->listarNombreCompletoEstudiante($estudiantes[$i]["id_estudiante"]);
                $fila = array();
                for ($j = 0; $j < count($nombre_completo); $j++)
                {
                    array_push($fila, $nombre_completo[$j]["paterno"]);
                    array_push($fila, $nombre_completo[$j]["materno"]);
                    array_push($fila, $nombre_completo[$j]["nombres"]);

                    $suma1 = 0;
                    $suma2 = 0;
                    $suma3 = 0;

                    for($h = 0; $h < count($codigo_materias); $h++)
                    {
                        $notas = $this->model->obtenerNotasEstudiantes($estudiantes[$i]["id_estudiante"], $codigo_materias[$h], $gestion[0]["gestion"]);

                        if (count($notas) == 0 ||count($notas) == null)
                        {
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                        }else{

                            for ($b = 0; $b < count($notas); $b++)
                            {
                                $nota1 = $notas[0]["nota1"]== null? 0 : $notas[0]["nota1"];
                                $nota2 = $notas[0]["nota2"]== null? 0 : $notas[0]["nota2"];
                                $nota3 = $notas[0]["nota3"]== null? 0 : $notas[0]["nota3"];

                                $suma1 = $suma1 + $nota1;
                                $suma2 = $suma2 + $nota2;
                                $suma3 = $suma3 + $nota3;

                                array_push($fila, $notas[0]["nota1"]== null? "" : $notas[0]["nota1"]);
                                array_push($fila,  $notas[0]["nota2"]== null? "" : $notas[0]["nota2"]);
                                array_push($fila,  $notas[0]["nota3"]== null? "" : $notas[0]["nota3"]);

                            }


                        }


                    }

                    array_push($fila, round($suma1/11));
                    array_push($fila, round($suma2/11));
                    array_push($fila, round($suma3/11));


                }

                if (isset($fila)) {
                    array_push($data, $fila);
                }

            }
        } else {
            // Imprimir para los paralelos quinto y sexto de secundaria
            $id_curso_paralelo = $this->request->getGet("id_curso_paralelo");
            $data = array();
            $estudiantes = $this->model->listarEstudiantesCentralizador($id_curso_paralelo, $id_gestion);
            $gestion = $this->model->sacarGestion($id_gestion);

            $codigo_materias = array("LCO", "LE", "CS", "EFI", "EMU", "APV", "MAT", "TTE","CNFIS", "CNQMC", "CNBIO", "VER", "CFS");
            for($i = 0; $i < count($estudiantes); $i++)
            {

                $nombre_completo = $this->model->listarNombreCompletoEstudiante($estudiantes[$i]["id_estudiante"]);
                $fila = array();
                for ($j = 0; $j < count($nombre_completo); $j++)
                {
                    array_push($fila, $nombre_completo[$j]["paterno"]);
                    array_push($fila, $nombre_completo[$j]["materno"]);
                    array_push($fila, $nombre_completo[$j]["nombres"]);

                    $suma1 = 0;
                    $suma2 = 0;
                    $suma3 = 0;

                    for($h = 0; $h < count($codigo_materias); $h++)
                    {
                        $notas = $this->model->obtenerNotasEstudiantes($estudiantes[$i]["id_estudiante"], $codigo_materias[$h], $gestion[0]["gestion"]);

                        if (count($notas) == 0 ||count($notas) == null)
                        {
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                            array_push($fila, "");
                        }else{

                            for ($b = 0; $b < count($notas); $b++)
                            {
                                $nota1 = $notas[0]["nota1"]== null? 0 : $notas[0]["nota1"];
                                $nota2 = $notas[0]["nota2"]== null? 0 : $notas[0]["nota2"];
                                $nota3 = $notas[0]["nota3"]== null? 0 : $notas[0]["nota3"];

                                $suma1 = $suma1 + $nota1;
                                $suma2 = $suma2 + $nota2;
                                $suma3 = $suma3 + $nota3;

                                array_push($fila, $notas[0]["nota1"]== null? "" : $notas[0]["nota1"]);
                                array_push($fila,  $notas[0]["nota2"]== null? "" : $notas[0]["nota2"]);
                                array_push($fila,  $notas[0]["nota3"]== null? "" : $notas[0]["nota3"]);

                            }


                        }


                    }

                    array_push($fila, round($suma1/11));
                    array_push($fila, round($suma2/11));
                    array_push($fila, round($suma3/11));


                }

                if (isset($fila)) {
                    array_push($data, $fila);
                }

            }

        }

        $this->response->setContentType('application/pdf');
        $this->reporteCentralizador->imprimir($data, $paralelo, $gestion[0]["gestion"]);
    }
}//class
