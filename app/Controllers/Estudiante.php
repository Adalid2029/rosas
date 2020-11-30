<?php


namespace App\Controllers;


use App\Libraries\Ssp;
use App\Models\AdministrativoModel;
use App\Models\EstudianteModel;

class Estudiante extends BaseController
{

    public $model = null;
    public $fecha = null;
    public $administrativo = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new EstudianteModel();
        $this->fecha = new \DateTime();
        $this->administrativo = new AdministrativoModel();
    }

    // Cargar la vista estudiantes
    public function listarEstudiantes()
    {
        return $this->templater->view('personas/listarEstudiantes', []);
    }

    // Listado de estudiantes
    public function ajaxListarEstudiantes()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_estudiante";
            $where = "estado = 1";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_estudiante', 'dt'     => 1),
                array('db' => 'rude', 'dt'              => 2),
                array('db' => 'ci', 'dt'                => 3),
                array('db' => 'nombres_apellidos', 'dt' => 4),
                array('db' => 'correo', 'dt'            => 5),
                array('db' => 'nacimiento', 'dt'        => 6),
                array('db' => 'telefono', 'dt'          => 7),
                array('db' => 'sexo', 'dt'              => 8),
                array('db' => 'gestion_ingreso', 'dt'   => 9)
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

    // Insert o Update estudiante
    public function guardar_estudiante()
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
                            "rude" => "required|alpha_numeric",
                            "ci" => "required|alpha_numeric|min_length[6]",
                            "exp" => "required|max_length[2]|alpha",
                            "nombres" => "required|alpha_space",
                            "paterno" => "required|alpha_space",
                            "materno" => "alpha_space",
                            "nacimiento" => 'required',
                            "telefono" => "required|numeric|min_length[6]",
                            "sexo" => "required|max_length[1]|alpha",
                            "gestion_ingreso" => "required|numeric|max_length[4]"
                        ],
                        [ // errors
                            "rude" => [
                                "required" => "El rude  del estudiante es requerido",
                                "alpha_numeric"  => "El rude debe contener caracteres alfabéticos y numéricos"
                            ],
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
                                "alpha_space" => "El apellido paterno debe llevar caracteres alfabéticos o espacios."
                            ],
                            "materno" => [
                                "alpha_space" => "El apellido materno debe llevar caracteres alfabéticos o espacios."
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
                            "gestion_ingreso" => [
                                "required" => "La gestión de ingreso es requerido",
                                "numeric" => "La gestión de ingreso debe llevar caracteres numéricos",
                                "max_length" => "La gestion de ingreso debe llevar máximo 4 caracteres"
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
                            "correo"    => $this->request->getPost("correo"),
                            "sexo"          => $this->request->getPost("sexo"),
                            "telefono"      => trim($this->request->getPost("telefono")),
                            "domicilio"     => trim($this->request->getPost("domicilio")),
                            "creado_en"     => $this->fecha->format('Y-m-d H:i:s')
                        );

                        $respuesta = $this->model->persona("insert", $data, null, null);

                        if (is_numeric($respuesta)) {
                            $data2 = array(
                                "id_estudiante"      => $respuesta,
                                "rude"            => trim($this->request->getPost("rude")),
                                "gestion_ingreso" => trim($this->request->getPost("gestion_ingreso")),
                            );

                            $respuesta1 = $this->model->estudiante("insert", $data2, null, null);

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
                                        'exito' => "Estudiante registrado correctamente"
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
                        "rude" => "required|alpha_numeric",
                        "ci" => "required|alpha_numeric|min_length[6]",
                        "exp" => "required|max_length[2]|alpha",
                        "nombres" => "required|alpha_space",
                        "paterno" => "required|alpha_space",
                        "materno" => "alpha_space",
                        "nacimiento" => 'required',
                        "telefono" => "required|numeric|min_length[6]",
                        "sexo" => "required|max_length[1]|alpha",
                        "gestion_ingreso" => "required|numeric|max_length[4]"
                    ],
                    [ // errors
                        "rude" => [
                            "required" => "El rude  del estudiante es requerido",
                            "alpha_numeric"  => "El rude debe contener caracteres alfabéticos y numéricos"
                        ],
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
                            "alpha_space" => "El apellido paterno debe llevar caracteres alfabéticos o espacios."
                        ],
                        "materno" => [
                            "alpha_space" => "El apellido materno debe llevar caracteres alfabéticos o espacios."
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
                        "gestion_ingreso" => [
                            "required" => "La gestión de ingreso es requerido",
                            "numeric" => "La gestión de ingreso debe llevar caracteres numéricos",
                            "max_length" => "La gestion de ingreso debe llevar máximo 4 caracteres"
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
                        "correo"    => $this->request->getPost("correo"),
                        "sexo"          => $this->request->getPost("sexo"),
                        "telefono"      => trim($this->request->getPost("telefono")),
                        "domicilio"     => trim($this->request->getPost("domicilio")),
                        "actualizado_en"     => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->persona("update", $data,
                        array(
                            "id_persona" => $this->request->getPost("id_persona")
                        ), null);

                    if ($respuesta) {
                        $data2 = array(
                            "rude"            => trim($this->request->getPost("rude")),
                            "gestion_ingreso" => trim($this->request->getPost("gestion_ingreso")),
                        );

                        $respuesta1 = $this->model->estudiante("update", $data2, array(
                            "id_estudiante" => $this->request->getPost("id_estudiante")), null);

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
                                    'exito' => "Estudiante editado correctamente"
                                )));
                            }
                        }
                    }
                }
            }
        }
    }

    // Editar Estudiante
    public function editar_estudiante()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $respuesta = $this->model->personaEstudiante(trim($this->request->getPost("id")));
            return $this->response->setJSON(json_encode($respuesta));
        }
    }

    // Eliminar estudiante
    public function eliminar_estudiante()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $data = array(
                "estado" => 0
            );

            $respuesta = $this->model->persona("update", $data, array(
                "id_persona" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Estudiante Eliminado correctamente"
                )));
            }
        }
    }
}// class
