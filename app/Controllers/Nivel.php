<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\NivelModel;

class Nivel extends BaseController
{

    public $model = null;
    public $fecha = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new NivelModel();
        $this->fecha = new \DateTime();
    }

    public function listarNiveles()
    {
        return $this->templater->view('materias_cursos/listarNiveles', $this->data);
    }

    // Listado de niveles
    public function ajaxListarNiveles()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_curso";
            $where = "estado=1";
            $primaryKey = "id_curso";
            $columns = array(
                array('db' => 'id_curso', 'dt' => 0),
                array('db' => 'nivel', 'dt'    => 1)
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

    // Insert o Update nivel
    public function guardar_nivel()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_curso") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "nivel" => "required|numeric|max_length[1]"
                    ],
                    [ // errors
                        "nivel" => [
                            "required" => "El nivel es requerido",
                            "numeric"  => "El nivel debe tener caracteres numéricos",
                            "max_length" => "El debe tener un caracter"
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
                        "nivel"      => trim($this->request->getPost("nivel")),
                        "creado_en"   => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->nivel("insert", $data, null, null);

                    if (is_numeric($respuesta)) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Nivel registrado correctamente"
                        )));
                    }else{
                        return $this->response->setJSON(json_encode(array(
                            'error' => "Error al registrar el nivel"
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
                        "nivel" => "required|numeric|max_length[1]"
                    ],
                    [ // errors
                        "nivel" => [
                            "required" => "El nivel es requerido",
                            "numeric"  => "El nivel debe tener caracteres numéricos",
                            "max_length" => "El debe tener un caracter"
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
                        "nivel" => trim($this->request->getPost("nivel")),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->nivel("update", $data, array(
                        "id_curso" => $this->request->getPost("id_curso")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Nivel editado correctamente"
                        )));
                    }else{
                        return $this->response->setJSON(json_encode(array(
                            'error' => "Error al actualizar el nivel"
                        )));
                    }
                }
            }
        }
        return null;
    }

    // Editar nivel
    public function editar_nivel()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_curso" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->nivel("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar nivel
    public function eliminar_nivel()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->nivel("update", array("estado" => 0), array(
                "id_curso" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Nivel Eliminado correctamente"
                )));
            }else{
                return $this->response->setJSON(json_encode(array(
                    'error' => "Error al eliminar el nivel"
                )));
            }
        }
    }


}
