<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\KardexModel;
use App\Models\ResponsableModel;

class Kardex extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $data;
    public $estudiante;

    public function __construct()
    {
        parent::__construct();
        $this->model = new KardexModel();
        $this->estudiante = new ResponsableModel();
        $this->fecha = new \DateTime();
    }

    // Listado de kardex
    public function listarKardex()
    {
        $this->data["cursos"] = $this->model->listarCursos();
        $this->data["estudiantes"] = $this->estudiante->listarEstudiantes();

        return $this->templater->view('kardex/listarKardex', $this->data);

    }

    // Listado de kardex
    public function ajaxListarKardex()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_kardex";
            $where = "estado=1";
            $primaryKey = "id_kardex";
            $columns = array(
                array('db' => 'id_kardex', 'dt'         => 0),
                array('db' => 'id_curso_paralelo', 'dt' => 1),
                array('db' => 'estudiante', 'dt'        => 2),
                array('db' => 'gestion', 'dt'           => 3),
                array('db' => 'contador', 'dt'          => 4),
                array('db' => 'creado_en', 'dt'         => 5)
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

    // Insert kardex
    public function guardar_kardex()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_kardex") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_curso_paralelo" => "required|numeric",
                        "id_estudiante"     => "required|numeric",
                        "gestion"           => "required|numeric|max_length[4]"
                    ],
                    [ // errors
                        "id_curso_paralelo" => [
                            "required" => "El curso es requerido",
                            "numeric"  => "El curso debe llevar caracteres numéricos"
                        ],
                        "id_estudiante" => [
                            "required" => "El estudiante es requerido",
                            "numeric"  => "El estudiante debe llevar caracteres numéricos"
                        ],
                        "gestion" => [
                            "required" => "La gestión es requerido",
                            "numeric"  => "El gestión debe llevar caracteres numéricos",
                            "gestion"  => "La gestión debe llevar un máximo de 4 caracteres"
                        ]
                    ]
                );
                // se verifica la existencia del registro del estudiante en el año
                $cond = array(
                    "id_estudiante" => $this->request->getPost("id_estudiante"),
                    "gestion"       => $this->request->getPost("gestion"),
                    "estado"        => "1"
                );

                $res = $this->model->kardex("select", null, $cond, null);
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
                            "id_curso_paralelo" => $this->request->getPost("id_curso_paralelo"),
                            "id_estudiante"     => $this->request->getPost("id_estudiante"),
                            "gestion"           => $this->request->getPost("gestion"),
                            "creado_en"         => $this->fecha->format('Y-m-d H:i:s')
                        );

                        $respuesta = $this->model->kardex("insert", $data, null, null);

                        if (is_numeric($respuesta)) {
                            return $this->response->setJSON(json_encode(array(
                                'exito' => "Estudiante registrado al kardex correctamente gestión" . $this->request->getPost("gestion")
                            )));
                        }
                    }
                }else{
                    return $this->response->setJSON(json_encode(array(
                        "warni" => "El estudiante ya está registrado para esta gestión: ". $this->request->getPost("gestion")
                    )));
                }


            } else {
                // actualizar formulario
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_curso_paralelo" => "required|numeric",
                        "id_estudiante"     => "required|numeric",
                        "gestion"           => "required|numeric|max_length[4]"
                    ],
                    [ // errors
                        "id_curso_paralelo" => [
                            "required" => "El curso es requerido",
                            "numeric"  => "El curso debe llevar caracteres numéricos"
                        ],
                        "id_estudiante" => [
                            "required" => "El estudiante es requerido",
                            "numeric"  => "El estudiante debe llevar caracteres numéricos"
                        ],
                        "gestion" => [
                            "required" => "La gestión es requerido",
                            "numeric"  => "El gestión debe llevar caracteres numéricos",
                            "gestion"  => "La gestión debe llevar un máximo de 4 caracteres"
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
                        "id_curso_paralelo"     => $this->request->getPost("id_curso_paralelo"),
                        "id_estudiante"  => $this->request->getPost("id_estudiante"),
                        "gestion"  => $this->request->getPost("gestion"),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->kardex("update", $data, array(
                        "id_kardex" => $this->request->getPost("id_kardex")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Kardex editado correctamente"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar Kardex
    public function editar_kardex()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_kardex" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->kardex("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar kardex
    public function eliminar_kardex()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->kardex("update", array("estado" => 0), array(
                "id_kardex" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Registro de kardex eliminado correctamente"
                )));
            }
        }
    }

}
