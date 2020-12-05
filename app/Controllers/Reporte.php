<?php

namespace App\Controllers;

use App\Controllers\Reportes\SeguimientoReporte;
use App\Models\ReporteModel;

class Reporte extends  BaseController
{

    public $model = null;
    public $reporteSeguimiento;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ReporteModel();
        $this->reporteSeguimiento = new SeguimientoReporte();
    }

    public function imprimirSeguimiento()
    {
        $this->data["cursos_paralelos"] = $this->model->listarCursosParalelos();
        return $this->templater->view('reportes/imprimirSeguimiento', $this->data);
    }

    public function imprimirSeguimientoEstudiante()
    {
        set_time_limit(1000000000);
        $id = $this->request->getGet("id");
        $fechaI = $this->request->getGet("fechaInicio");
        $fechaF = $this->request->getGet("fechaFinal");

        $data = array();
        $this->response->setContentType('application/pdf');
        $this->reporteSeguimiento->imprimir($data, $fechaI, $fechaF, null);

    }


}//class
