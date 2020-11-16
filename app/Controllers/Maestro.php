<?php

namespace App\Controllers;

use App\Libraries\Ssp;
use App\Models\AdministrativoModel;
use App\Models\MaestroModel;

class Maestro extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $administrativo = null;
    public function __construct()
    {
        parent::__construct();
        $this->model = new MaestroModel();
        $this->fecha = new \DateTime();
        $this->administrativo = new AdministrativoModel();
    }

    // Cargar la vista maestros
    public function listarMaestros()
    {
        return $this->templater->view('personas/listarMaestros', []);
    }

    // Listado de maestros
    public function ajaxListarMaestros()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_maestro";
            $where = "estado = 1";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_maestro', 'dt'     => 1),
                array('db' => 'ci', 'dt'                => 2),
                array('db' => 'nombres_apellidos', 'dt' => 3),
                array('db' => 'nacimiento', 'dt'        => 4),
                array('db' => 'telefono', 'dt'          => 5),
                array('db' => 'sexo', 'dt'              => 6),
                array('db' => 'grado_academico', 'dt'   => 7)
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

    // Insert o Update maestro
    public function guardar_maestro()
    {
        $data  = null;
        $data1 = null;
        $data2 = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion") == "in" && $this->request->getPost("id_persona") == "") {
                // Se verifica el registro de CI del estudiante
                $res = $this->administrativo->verificarNombreUsuario(trim($this->request->getPost("ci")));
                if ($res) {
                    //validación de formulario
                    $validation = \Config\Services::validation();
                    helper(['form', 'url']);
                    $val = $this->validate(
                        [ // rules
                            "ci" => "required|alpha_numeric|min_length[6]",
                            "exp" => "required|max_length[2]|alpha",
                            "nombres" => "required|alpha_space",
                            "paterno" => "required|alpha_space",
                            "materno" => "alpha_space",
                            "nacimiento" => 'required',
                            "telefono" => "required|numeric|min_length[6]",
                            "sexo" => "required|max_length[1]|alpha",
                            "grado_academico" => "required|alpha_space"
                        ],
                        [ // errors
                            "ci" => [
                                "required" => "El CI del usuario es requerido",
                                "alpha_numeric" => "El CI del usuario no debe llevar caracteres especiales",
                                "min_length" => "El CI del usuario debe tener al menos 6 caracteres"
                            ],
                            "exp" => [
                                "required" => "La expedición del ci es requerido",
                                "max_length" => "La expedición del ci debe llevar máximo 2 caracteres",
                                "alpha" => "La expedición del ci debe llevar caracteres especiales"
                            ],
                            "nombres" => [
                                "required" => "El nombre es requerido",
                                "alpha_space" => "El nombre debe llevar caracteres alfabéticos o espacios."
                            ],
                            "paterno" => [
                                "required" => "El apellido paterno es requerido",
                                "alpha_space" => "El apellido paterno debe llevar caracteres alfabéticos y espacios."
                            ],
                            "materno" => [
                                "alpha_space" => "El apellido materno debe llevar caracteres alfabéticos y espacios."
                            ],
                            "nacimiento" => [
                                "required" => "La fecha de nacimiento es requerido"
                            ],
                            "telefono" => [
                                "required"   => "El telefono es requerido",
                                "numeric"    => "El telefono debe llevar caracteres numéricos.",
                                "min_length" => "El teléfono debe llevar al menos 6 caracteres"
                            ],
                            "sexo" => [
                                "required" => "El sexo es requerido",
                                "max_length" => "El sexo debe llevar máximo 1 caracter",
                                "alpha" => "El sexo no debe llevar caracteres especiales."
                            ],
                            "grado_academico" => [
                                "required" => "La grado académico del maestro(a) es requerido",
                                "alpha_space" => "El grado académico debe llevar caracteres alfabéticos y espacios."
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
                            "ci"            => trim($this->request->getPost("ci")),
                            "exp"           => $this->request->getPost("exp"),
                            "paterno"       => trim($this->request->getPost("paterno")),
                            "materno"       => trim($this->request->getPost("materno")),
                            "nombres"       => trim($this->request->getPost("nombres")),
                            "nacimiento"    => $this->request->getPost("nacimiento"),
                            "sexo"          => $this->request->getPost("sexo"),
                            "telefono"      => trim($this->request->getPost("telefono")),
                            "domicilio"     => trim($this->request->getPost("domicilio")),
                            "creado_en"     => $this->fecha->format('Y-m-d H:i:s')
                        );

                        $respuesta = $this->model->persona("insert", $data, null, null,);

                        if (is_numeric($respuesta)) {
                            $data2 = array(
                                "id_maestro"      => $respuesta,
                                "grado_academico" => trim($this->request->getPost("grado_academico"))
                            );

                            $respuesta1 = $this->model->maestro("insert", $data2, null, null);

                            if (is_numeric($respuesta1)) {
                                $data2 = array(
                                    "id_usuario" => $respuesta,
                                    "usuario"    => trim($this->request->getPost("ci")),
                                    "clave"      => hash("sha512", $this->request->getPost("nacimiento")),
                                    "creado_en"  => $this->fecha->format('Y-m-d H:i:s')
                                );

                                $respuesta2 = $this->model->usuario("insert", $data2, null, null);

                                if (is_numeric($respuesta2)) {
                                    return $this->response->setJSON(json_encode(array(
                                        'exito' => "Maestro registrado correctamente"
                                    )));
                                }
                            }
                        }
                    }
                } else {
                    return $this->response->setJSON(json_encode(array(
                        'warning' => "El ci ingresado ya  se encuentra registrado"
                    )));
                }
            } else {
                // actualizar formulario
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "ci" => "required|alpha_numeric|min_length[6]",
                        "exp" => "required|max_length[2]|alpha",
                        "nombres" => "required|alpha_space",
                        "paterno" => "required|alpha_space",
                        "materno" => "alpha_space",
                        "nacimiento" => 'required',
                        "telefono" => "required|numeric|min_length[6]",
                        "sexo" => "required|max_length[1]|alpha",
                        "grado_academico" => "required|alpha_space"
                    ],
                    [ // errors
                        "ci" => [
                            "required" => "El CI del usuario es requerido",
                            "alpha_numeric" => "El CI del usuario no debe llevar caracteres especiales",
                            "min_length" => "El CI del usuario debe tener al menos 6 caracteres"
                        ],
                        "exp" => [
                            "required" => "La expedición del ci es requerido",
                            "max_length" => "La expedición del ci debe llevar máximo 2 caracteres",
                            "alpha" => "La expedición del ci debe llevar caracteres especiales"
                        ],
                        "nombres" => [
                            "required" => "El nombre es requerido",
                            "alpha_space" => "El nombre debe llevar caracteres alfabéticos o espacios."
                        ],
                        "paterno" => [
                            "required" => "El apellido paterno es requerido",
                            "alpha_space" => "El apellido paterno debe llevar caracteres alfabéticos y espacios."
                        ],
                        "materno" => [
                            "alpha_space" => "El apellido materno debe llevar caracteres alfabéticos y espacios."
                        ],
                        "nacimiento" => [
                            "required" => "La fecha de nacimiento es requerido"
                        ],
                        "telefono" => [
                            "required"   => "El telefono es requerido",
                            "numeric"    => "El telefono debe llevar caracteres numéricos.",
                            "min_length" => "El teléfono debe llevar al menos 6 caracteres"
                        ],
                        "sexo" => [
                            "required" => "El sexo es requerido",
                            "max_length" => "El sexo debe llevar máximo 1 caracter",
                            "alpha" => "El sexo no debe llevar caracteres especiales."
                        ],
                        "grado_academico" => [
                            "required" => "La grado académico del maestro(a) es requerido",
                            "alpha_space" => "El grado académico debe llevar caracteres alfabéticos y espacios."
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
                        "ci"            => trim($this->request->getPost("ci")),
                        "exp"           => $this->request->getPost("exp"),
                        "paterno"       => trim($this->request->getPost("paterno")),
                        "materno"       => trim($this->request->getPost("materno")),
                        "nombres"       => trim($this->request->getPost("nombres")),
                        "nacimiento"    => $this->request->getPost("nacimiento"),
                        "sexo"          => $this->request->getPost("sexo"),
                        "telefono"      => trim($this->request->getPost("telefono")),
                        "domicilio"     => trim($this->request->getPost("domicilio")),
                        "actualizado_en"     => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->persona("update", $data, array(
                        "id_persona" => $this->request->getPost("id_persona")
                    ), null,);

                    if ($respuesta) {
                        $data2 = array(
                            "grado_academico"            => trim($this->request->getPost("grado_academico")),
                        );

                        $respuesta1 = $this->model->maestro("update", $data2, array(
                            "id_maestro" => $this->request->getPost("id_maestro")
                        ), null);

                        if ($respuesta1) {
                            $data2 = array(
                                "usuario"    => trim($this->request->getPost("ci")),
                                "clave"      => hash("sha512", $this->request->getPost("nacimiento")),
                                "actualizado_en"  => $this->fecha->format('Y-m-d H:i:s')
                            );

                            $respuesta2 = $this->model->usuario("update", $data2, array(
                                "id_usuario" =>  $this->request->getPost("id_usuario")
                            ), null);

                            if ($respuesta2) {
                                return $this->response->setJSON(json_encode(array(
                                    'exito' => "Usuario editado correctamente"
                                )));
                            }
                        }
                    }
                }
            }
        }
    }

    // Editar Maestro
    public function editar_maestro()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $respuesta = $this->model->personaMaestro(trim($this->request->getPost("id")));
            return $this->response->setJSON(json_encode($respuesta));
        }
    }

    // Eliminar estudiante
    public function eliminar_maestro()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->persona("update", array("estado" => 0), array(
                "id_persona" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Maestro Eliminado correctamente"
                )));
            }

        }
    }
}
