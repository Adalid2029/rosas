<?php


namespace App\Controllers;


use App\Models\MateriaModel;

class Materia extends BaseController
{

    public $model = null;

    public function __construct()
    {
        parent::__construct();
        $this -> model = new MateriaModel();
    }

    public function listarMaterias()
    {
        return $this->templater->view('materias_cursos/listarMaterias', []);
    }


}
