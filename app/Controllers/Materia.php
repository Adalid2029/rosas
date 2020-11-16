<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\MateriaModel;

class Materia extends BaseController
{

    public $model = null;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MateriaModel();
        $this->fecha = new \DateTime();
    }

    public function listarMaterias()
    {
        return $this->templater->view('materias_cursos/listarMaterias', []);
    }

    // Listado de materia
    public function ajaxListarMaterias()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_materia";
            $where = "estado=1";
            $primaryKey = "id_materia";
            $columns = array(
                array('db' => 'id_materia', 'dt' => 0),
                array('db' => 'codigo', 'dt'     => 1),
                array('db' => 'nombre', 'dt'     => 2),
                array('db' => 'creado_en', 'dt'  => 3)
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

    // verificar repetido codigo y nombre de materia
    public function verificar()
    {
        if ($this->request->isAJAX()) {
            // codicion
            $campo = null;
            if ($this->request->getPost("columna") == "codigo") {
                $condicion = array(
                    "codigo" => trim($this->request->getPost("cod"))
                );
                $campo = "codigo";
            } else {
                $condicion = array(
                    "nombre" => trim($this->request->getPost("cod"))
                );
                $campo = "nombre de la materia";
            }

            $respuesta = $this->model->materia("select", null, $condicion, null);
            if ($respuesta->getRowArray() != null) {
                return $this->response->setJSON(json_encode(array(
                    'warning' => "El " . $campo . " ingresado ya esta en uso !!!"
                )));
            }
        }
    }

    // Insert o Update materia
    public function guardar_materia()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_materia") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "codigo" => "required",
                        "nombre" => "required"
                    ],
                    [ // errors
                        "codigo" => [
                            "required" => "El codigo de la materia es requerido"
                        ],
                        "nombre" => [
                            "required" => "El nombre de la materia es requerido"
                        ]
                    ]
                );

                if (!$val) {
                    // se devuelve todos los errores
                    return $this->response->setJSON(json_encode(array(
                        "form" => $validation->listErrors()
                    )));
                } else {
                    // Insertar datos
                    $data = array(
                        "codigo"      => mb_strtoupper(trim($this->request->getPost("codigo")), "utf-8"),
                        "nombre"      => mb_strtoupper(trim($this->request->getPost("nombre")), "utf-8"),
                        "creado_en"   => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->materia("insert", $data, null, null);

                    if (is_numeric($respuesta)) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Tutor registrado correctamente"
                        )));
                    }
                }
            } else {
                // actualizar formulario
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "codigo" => "required",
                        "nombre" => "required"
                    ],
                    [ // errors
                        "codigo" => [
                            "required" => "El codigo de la materia es requerido"
                        ],
                        "nombre" => [
                            "required" => "El nombre de la materia es requerido"
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
                        "codigo" => mb_strtoupper(trim($this->request->getPost("codigo")),"utf-8"),
                        "nombre" => mb_strtoupper(trim($this->request->getPost("nombre")), "utf-8"),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->materia("update", $data, array(
                        "id_materia" => $this->request->getPost("id_materia")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Tutor(a) editado correctamente"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar materia
    public function editar_materia()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_materia" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->materia("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar materia
    public function eliminar_materia()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->materia("update", array("estado" => 0), array(
                "id_materia" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Materia Eliminado correctamente"
                )));
            }
        }
    }

}
