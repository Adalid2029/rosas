<?php


namespace App\Controllers;


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
        return $this->templater->view('listarEstudiantes', []);
    }

}
