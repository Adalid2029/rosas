<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\CursoModel;

class Curso extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CursoModel();
        $this->fecha = new \DateTime();
    }

    public function listarCursos()
    {
        $this->data["niveles"] = $this->model->listarNiveles();
        $this->data["paralelos"] = $this->model->listarParalelos();

        return $this->templater->view('materias_cursos/listarCursos', $this->data);

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
                if(is_null($res->getRowArray()))
                {
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
                }else{
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

}//class
