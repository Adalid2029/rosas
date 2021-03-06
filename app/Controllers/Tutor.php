<?php

namespace App\Controllers;

use App\Controllers\Reportes\TutorReporte;
use App\Libraries\Ssp;
use App\Models\AdministrativoModel;
use App\Models\TutorModel;

class Tutor extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $administrativo = null;
    public $reporteTutor = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new TutorModel();
        $this->fecha = new \DateTime();
        $this->administrativo = new AdministrativoModel();
        $this->reporteTutor = new TutorReporte();
     }

    // Cargar la vista tutor
    public function listarTutor()
    {
        return $this->templater->view('personas/listarTutor', []);
    }

    // Listado de maestros
    public function ajaxListarTutor()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_tutor";
            $where = "estado = 1";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_tutor', 'dt'          => 1),
                array('db' => 'ci', 'dt'                => 2),
                array('db' => 'nombres_apellidos', 'dt' => 3),
                array('db' => 'correo', 'dt'            => 4),
                array('db' => 'nacimiento', 'dt'        => 5),
                array('db' => 'telefono', 'dt'          => 6),
                array('db' => 'sexo', 'dt'              => 7),
                array('db' => 'parentesco', 'dt'        => 8)
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

    // Insert o Update tutor
    public function guardar_tutor()
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
                            "nacimiento" => 'required',
                            "telefono" => "required|numeric|min_length[6]",
                            "sexo" => "required|max_length[1]|alpha",
                            "parentesco" => "required|alpha_space"
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
                            "parentesco" => [
                                "required" => "La grado académico del maestro(a) es requerido",
                                "alpha_space" => "El parentesco debe llevar caracteres alfabéticos y espacios."
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
                            "correo"        => $this->request->getPost("correo"),
                            "sexo"          => $this->request->getPost("sexo"),
                            "telefono"      => trim($this->request->getPost("telefono")),
                            "domicilio"     => trim($this->request->getPost("domicilio")),
                            "creado_en"     => $this->fecha->format('Y-m-d H:i:s')
                        );

                        $respuesta = $this->model->persona("insert", $data, null, null);

                        if (is_numeric($respuesta)) {
                            $data2 = array(
                                "id_tutor" => $respuesta,
                                "parentesco" => trim($this->request->getPost("parentesco"))
                            );

                            $respuesta1 = $this->model->tutor("insert", $data2, null, null);

                            if (is_numeric($respuesta1)) {
                                $data2 = array(
                                    "id_usuario" => $respuesta,
                                    "usuario"    => trim($this->request->getPost("ci")),
                                    "clave"      => hash("sha512", $this->request->getPost("nacimiento")),
                                    "creado_en"  => $this->fecha->format('Y-m-d H:i:s')
                                );

                                $respuesta2 = $this->model->usuario("insert", $data2, null, null);

                                if (is_numeric($respuesta2)) {
                                    $id_grupo_usuario = ($this->db->table('grupo_usuario')->insert([
                                        'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => 'PADRE_FAMILIA'])->getRowArray()['id_grupo'],
                                        'id_usuario' => $respuesta,
                                        'estado_grupo_usuario' => 'ACTIVO',
                                    ])) ? $this->db->insertID() : $this->db->error();
                                    if (is_numeric($id_grupo_usuario)) {
                                        return $this->response->setJSON(json_encode(array(
                                            'exito' => "Tutor registrado correctamente"
                                        )));
                                    }
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
                        "nacimiento" => 'required',
                        "telefono" => "required|numeric|min_length[6]",
                        "sexo" => "required|max_length[1]|alpha",
                        "parentesco" => "required|alpha_space"
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
                        "parentesco" => [
                            "required" => "La grado académico del maestro(a) es requerido",
                            "alpha_space" => "El parentesco debe llevar caracteres alfabéticos y espacios."
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

                    $respuesta = $this->model->persona("update", $data, array(
                        "id_persona" => $this->request->getPost("id_persona")
                    ), null);

                    if ($respuesta) {
                        $data2 = array(
                            "parentesco"            => trim($this->request->getPost("parentesco")),
                        );

                        $respuesta1 = $this->model->tutor("update", $data2, array(
                            "id_tutor" => $this->request->getPost("id_tutor")
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
                                if (empty($this->request->getPost("id_grupo_usuario"))) {
                                    $id_grupo_usuario = ($this->db->table('grupo_usuario')->insert([
                                        'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => 'PADRE_FAMILIA'])->getRowArray()['id_grupo'],
                                        'id_usuario' => $this->request->getPost("id_tutor"),
                                        'estado_grupo_usuario' => 'ACTIVO',
                                    ])) ? $this->db->insertID() : $this->db->error();
                                } else {
                                    $id_grupo_usuario = ($this->db->table('grupo_usuario')->update([
                                        'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => 'PADRE_FAMILIA'])->getRowArray()['id_grupo'],
                                        'estado_grupo_usuario' => 'ACTIVO',
                                    ], [
                                        'id_grupo_usuario' => $this->request->getPost("id_grupo_usuario"),
                                    ]));
                                }
                                if ($id_grupo_usuario || is_numeric($id_grupo_usuario)) {
                                    return $this->response->setJSON(json_encode(array(
                                        'exito' => "Tutor(a) editado correctamente"
                                    )));
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Editar Tutor
    public function editar_tutor()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $respuesta = $this->model->personaTutor(trim($this->request->getPost("id")));
            return $this->response->setJSON(json_encode($respuesta));
        }
    }

    // Eliminar tutor
    public function eliminar_tutor()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->persona("update", array("estado" => 0), array(
                "id_persona" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Tutor(a) Eliminado correctamente"
                )));
            }
        }
    }

    // Imprimir en pdf
    public function imprimir()
    {
        $data =$this->model->listarTutoresReporte();
        $this->response->setContentType('application/pdf');
        $this->reporteTutor->imprimir($data);
    }
}// class
