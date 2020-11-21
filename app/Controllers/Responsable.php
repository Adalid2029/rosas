<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\EstudianteModel;
use App\Models\ResponsableModel;
use App\Models\TutorModel;

class Responsable extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $estudiante = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ResponsableModel();
        $this->fecha = new \DateTime();
        $this->estudiante = new EstudianteModel();
    }

    // Cargar la vista tutores y estudiantes
    public function listarTutoresEstudiantes()
    {
        $this->data["estudiantes"] = $this->model ->listarEstudiantes();
        $this->data["tutores"] = $this->model ->listarTutores();

        return $this->templater->view('personas/listarTutorEstudiante', $this->data);

    }

    // Listado de estudiantes y sus tutores
    public function ajaxListarEstudianteTutor()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_estudiantes_tutores";
            $where = "estado=1";
            $primaryKey = "id_responsable";
            $columns = array(
                array('db' => 'id_responsable', 'dt'   => 0),
                array('db' => 'nombres_est', 'dt'      => 1),
                array('db' => 'ci_est', 'dt'           => 2),
                array('db' => 'telefono_est', 'dt'     => 3),
                array('db' => 'nombres_tutor', 'dt'    => 4),
                array('db' => 'ci_tutor', 'dt'         => 5),
                array('db' => 'telefono_tutor', 'dt'   => 6),
                array('db' => 'parentesco', 'dt'       => 7)
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

    // Insert o Update responsable
    public function guardar_responsable()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_responsable") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_tutor" => "required",
                        "id_estudiante" => "required"
                    ],
                    [ // errors
                        "id_tutor" => [
                            "required" => "El tutor(a) es requerido"
                        ],
                        "nombre" => [
                            "id_estudiante" => "El estudiante es requerido"
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
                        "id_tutor"      => trim($this->request->getPost("id_tutor")),
                        "id_estudiante"      => trim($this->request->getPost("id_estudiante")),
                        "creado_en"   => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->responsable("insert", $data, null, null);

                    if (is_numeric($respuesta)) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Tutor asignado correctamente"
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
                        "id_tutor" => "required",
                        "id_estudiante" => "required"
                    ],
                    [ // errors
                        "id_tutor" => [
                            "required" => "El tutor(a) es requerido"
                        ],
                        "nombre" => [
                            "id_estudiante" => "El estudiante es requerido"
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
                        "id_tutor"      => trim($this->request->getPost("id_tutor")),
                        "id_estudiante"      => trim($this->request->getPost("id_estudiante")),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->responsable("update", $data, array(
                        "id_responsable" => $this->request->getPost("id_responsable")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Tutor editado correctamente"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar Responsable
    public function editar_responsable()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_responsable" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->responsable("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar responsable
    public function eliminar_responsable()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->responsable("update", array("estado" => 0), array(
                "id_responsable" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Responsable Eliminado correctamente"
                )));
            }
        }
    }

}//class // class
