<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\CursoModel;
use App\Models\NotasModel;

class Curso extends BaseController
{
    public $model = null;
    public $notasModel = null;
    public $fecha = null;
    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CursoModel();
        $this->notasModel = new NotasModel();
        $this->fecha = new \DateTime();
    }

    public function listarCursos()
    {
        $this->data["niveles"] = $this->model->listarNiveles();
        $this->data["paralelos"] = $this->model->listarParalelos();

        return $this->templater->view('materias_cursos/listarCursos', $this->data);
    }

    public function listarAsignacionesCursoEstudiante()
    {
        $this->data['gestiones'] = $this->db->table('gestion')->orderBy('id_gestion DESC')->get()->getResultArray();
        $this->data['estudiantes'] = $this->notasModel->listarEstudiantes()->getResultArray();
        $this->data['cursos_paralelos'] = $this->notasModel->cursosParalelos()->getResultArray(9);
        return $this->templater->view('materias_cursos/listarAsignacionesCursoEstudiante', $this->data);
    }

    public function insertarAsignacionesCursoEstudiante()
    {
        if ($this->request->isAJAX()) {
            print_r($_REQUEST);
        }
    }
    public function actualizarAsignacionesCursoEstudiante()
    {
        if ($this->request->isAJAX()) {
            print_r($_REQUEST);
        }
    }
    public function editarAsignacionesCursoEstudiante()
    {
        if ($this->request->isAJAX()) {
            print_r($_REQUEST);
        }
    }

    // Listado de cursos
    public function ajaxListarCursos()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_curso_paralelo";
            $where = "estado=1";
            $primaryKey = "id_curso";
            $columns = array(
                array('db' => 'id_curso_paralelo', 'dt' => 0),
                array('db' => 'nivel', 'dt'             => 1),
                array('db' => 'paralelo', 'dt'          => 2),
                array('db' => 'creado_en', 'dt'         => 3)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where)));
        } else {
            return null;
        }
    }

    public function ajaxListarAsignacionesEstudiantes()
    {
        // print_r($_REQUEST);
        $table = <<<EOT
        (SELECT rce.id_curso_estudiante, p.estado, concat(c.nivel, ' ', rp.paralelo)as curso, concat(paterno, ' ', materno, ' ', nombres, ' CI. ', ci, ' ', exp) as nombre_completo, rg.gestion 
                from rs_estudiante e
                join rs_persona p on p.id_persona = e.id_estudiante
                join rs_curso_estudiante rce on rce.id_estudiante = e.id_estudiante
                join rs_gestion rg on rg.id_gestion = rce.id_gestion 
                join rs_curso_paralelo cp on cp.id_curso_paralelo =  rce.id_curso_paralelo 
                join rs_curso c on c.id_curso =  cp.id_curso
                join rs_paralelo rp on rp.id_paralelo = cp.id_paralelo) temp
        EOT;
        $primaryKey = 'id_curso_estudiante';
        $where = "estado = 1";
        $columns = array(
            array('db' => 'id_curso_estudiante', 'dt' => 0),
            array('db' => 'curso', 'dt' => 1),
            array('db' => 'nombre_completo', 'dt' => 2),
            array('db' => 'gestion', 'dt' => 3),
        );

        $sql_details = array('user' => $this->db->username, 'pass' => $this->db->password, 'db'   => $this->db->database, 'host' => $this->db->hostname);
        return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)));
    }

    // Insert curso y paralelo
    public function guardar_curso()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_curso_paralelo") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_curso" => "required",
                        "id_paralelo" => "required"
                    ],
                    [ // errors
                        "nivel" => [
                            "required" => "El nivel del curso es requerido"
                        ],
                        "paralelo" => [
                            "required" => "El paralelo del curso es requerido"
                        ]
                    ]
                );
                // se verifica la existencia del nivel y del paralelo
                $cond = array(
                    "id_curso"     => $this->request->getPost("id_curso"),
                    "id_paralelo"  => $this->request->getPost("id_paralelo")
                );
                $res = $this->model->curso_paralelo("select", null, $cond, null);
                if (is_null($res->getRowArray())) {
                    if (!$val) {
                        // se devuelve todos los errores
                        return $this->response->setJSON(json_encode(array(
                            "form" => $validation->listErrors()
                        )));
                    } else {
                        // Insertar datos
                        $data = array(
                            "id_curso"     => $this->request->getPost("id_curso"),
                            "id_paralelo"  => $this->request->getPost("id_paralelo"),
                            "creado_en"   => $this->fecha->format('Y-m-d H:i:s')
                        );

                        $respuesta = $this->model->curso_paralelo("insert", $data, null, null);

                        if (is_numeric($respuesta)) {
                            return $this->response->setJSON(json_encode(array(
                                'exito' => "Curso y Paralelo registrado correctamente"
                            )));
                        }
                    }
                } else {
                    return $this->response->setJSON(json_encode(array(
                        "warni" => "El nivel y el paralelo ya existe"
                    )));
                }
            } else {
                // actualizar formulario
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_curso" => "required",
                        "id_paralelo" => "required"
                    ],
                    [ // errors
                        "nivel" => [
                            "required" => "El nivel del curso es requerido"
                        ],
                        "paralelo" => [
                            "required" => "El paralelo del curso es requerido"
                        ]
                    ]
                );

                if (!$val) {
                    // se devuelve todos los errores
                    return $this->response->setJSON(json_encode(array(
                        "form" => $validation->listErrors()
                    )));
                } else {

                    // Actualizar datos
                    $data = array(
                        "id_curso"     => $this->request->getPost("id_curso"),
                        "id_paralelo"  => $this->request->getPost("id_paralelo"),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->curso_paralelo("update", $data, array(
                        "id_curso_paralelo" => $this->request->getPost("id_curso_paralelo")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Curso y Paralelo editado correctamente"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar Curso Paralelo
    public function editar_curso_paralelo()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_curso_paralelo" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->curso_paralelo("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar curso y paralelo
    public function eliminar_curso()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->curso_paralelo("update", array("estado" => 0), array(
                "id_curso_paralelo" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Curso y Paralelo Eliminado correctamente"
                )));
            }
        }
    }
}//class // class
