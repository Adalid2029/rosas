<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\ParaleloModel;

class Paralelo extends BaseController
{

    public $model = null;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ParaleloModel();
        $this->fecha = new \DateTime();
    }

    public function listarParalelos()
    {
        return $this->templater->view('materias_cursos/listarParalelos', $this->data);
    }

    // Listado de paralelos
    public function ajaxListarParalelos()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_paralelo";
            $where = "estado=1";
            $primaryKey = "id_paralelo";
            $columns = array(
                array('db' => 'id_paralelo', 'dt' => 0),
                array('db' => 'paralelo', 'dt'    => 1)
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

    // Insert o Update paralelo
    public function guardar_paralelo()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_paralelo") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "paralelo" => "required|alpha"
                    ],
                    [ // errors
                        "paralelo" => [
                            "required" => "El paralelo es requerido",
                            "alpha"    => "El paralelo debe tener caracteres alfanuméricos"
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
                        "paralelo"      => mb_strtoupper(trim($this->request->getPost("paralelo")), "utf-8"),
                        "creado_en"   => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->paralelo("insert", $data, null, null);

                    if (is_numeric($respuesta)) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Paralelo registrado correctamente"
                        )));
                    }else{
                        return $this->response->setJSON(json_encode(array(
                            'error' => "Error al registrar el paralelo"
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
                        "paralelo" => "required|alpha"
                    ],
                    [ // errors
                        "paralelo" => [
                            "required" => "El paralelo es requerido",
                            "alpha"    => "El paralelo debe tener caracteres alfanuméricos"
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
                        "paralelo" => mb_strtoupper(trim($this->request->getPost("paralelo")),"utf-8"),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->paralelo("update", $data, array(
                        "id_paralelo" => $this->request->getPost("id_paralelo")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Paralelo editado correctamente"
                        )));
                    }else{
                        return $this->response->setJSON(json_encode(array(
                            'error' => "Error al actualizar el paralelo"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar paralelo
    public function editar_paralelo()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_paralelo" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->paralelo("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar paralelo
    public function eliminar_paralelo()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->paralelo("update", array("estado" => 0), array(
                "id_paralelo" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Paralelo Eliminado correctamente"
                )));
            }else{
                return $this->response->setJSON(json_encode(array(
                    'error' => "Error al eliminar el paralelo"
                )));
            }
        }
    }


}
