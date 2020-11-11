<?php

namespace App\Controllers;
use App\Libraries\SSP;
use App\Models\PersonaModel;

class Persona extends BaseController
{
    public $model = null;
    public function __construct()
    {
        parent::__construct();
        $this -> model = new PersonaModel();
    }

    // ADMINISTRATIVOS
    public function administrativo()
    {
        return $this->templater->view('administrativo', []);
    }

    // Listado de administrativos
    public function ajaxListarAdministrativos()
    {
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->db->transBegin();
            $table = "rs_view_administrativo";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_administrativo', 'dt' => 1),
                array('db' => 'ci', 'dt' => 2),
                array('db' => 'nombres_apellidos', 'dt' => 3),
                array('db' => 'nacimiento', 'dt'        => 4),
                array('db' => 'telefono', 'dt'          => 5),
                array('db' => 'sexo', 'dt'              => 6),
                array('db' => 'cargo', 'dt'             => 7),
                array('db' => 'gestion_ingreso', 'dt'   => 8)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
        }else{
            return null;
        }

    }

    // INSERTAR ADMINISTRATIVO
    public function insertar_administrativo()
    {

        $fecha = new \DateTime();

        // se Verifica si es petición ajax
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            // Verificación del usuario
            $res = $this-> model -> verificarNombreUsuario(trim($this->request->getPost("ci")));
            if($res) {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate([ // rules
                    "ci" => "required|alpha_numeric|min_length[6]",
                    "exp" => "required|max_length[2]|alpha",
                    "nombre" => "required|alpha_space",
                    "paterno" => "required|alpha_space",
                    "materno" => "alpha_space",
                    "nacimiento" => 'required',
                    "telefono" => "required|numeric",
                    "sexo" => "required|max_length[1]|alpha",
                    "cargo" => "required|alpha",
                    "gestion_ingreso" => "required|numeric|max_length[4]"
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
                        "nombre" => [
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
                            "required" => "El telefono es requerido",
                            "numeric" => "El telefono debe llevar caracteres numéricos."
                        ],
                        "sexo" => [
                            "required" => "El sexo es requerido",
                            "max_length" => "El sexo debe llevar máximo 1 caracter",
                            "alpha" => "El sexo no debe llevar caracteres especiales."
                        ],
                        "cargo" => [
                            "required" => "El cargo es requerido",
                            "alpha" => "El cargo debe llevar caracteres alfabéticos o espacios."
                        ],
                        "gestion_ingreso" => [
                            "required" => "La gestión de ingreso es requerido",
                            "numeric" => "La gestión de ingreso debe llevar caracteres numéricos",
                            "max_length" => "La gestion de ingreso debe llevar máximo 4 caracteres"
                        ]
                    ]);

                if (!$val) {
                    // se devuelve todos los errores
                    return $this->response->setJSON(json_encode(array(
                        "form" => $validation->listErrors()
                    )));
                } else {
                    // Guardar el administrativo
                    $data = array(
                        "ci"            => trim($this->request->getPost("ci")),
                        "exp"           => $this->request->getPost("exp"),
                        "paterno"       => trim($this->request->getPost("paterno")),
                        "materno"       => trim($this->request->getPost("materno")),
                        "nombres"       => trim($this->request->getPost("nombre")),
                        "nacimiento"    => $this->request->getPost("nacimiento"),
                        "sexo"          => $this->request->getPost("sexo"),
                        "telefono"      => trim($this->request->getPost("telefono")),
                        "domicilio"     => trim($this->request->getPost("domicilio")),
                        "creado_en"     => $fecha -> format('Y-m-d H:i:s')
                    );

                    $respuesta = $this-> model ->persona("insert", $data, null, null,);

                    if(is_numeric($respuesta))
                    {
                        $data2 = array(
                            "id_persona" => $respuesta,
                            "cargo" => $this->request->getPost("cargo"),
                            "gestion_ingreso" => $this->request->getPost("gestion_ingreso")
                        );

                        $respuesta2 = $this-> model ->administrativo("insert", $data2, null, null);

                        if (is_numeric($respuesta2))
                        {
                            $data3 = array(
                                "id_persona" => $respuesta,
                                "usuario"    => trim($this->request->getPost("ci")),
                                "clave"      => md5($this->request->getPost("nacimiento")),
                                "creado_en"  => $fecha -> format('Y-m-d H:i:s')
                            );

                            $respuesta3 = $this -> model -> usuario("insert", $data3, null, null);

                            if(is_numeric($respuesta3))
                            {
                                return $this->response->setJSON(json_encode(array(
                                    'exito' => "Administrativo registrado correctamente"
                                )));
                            }
                        }

                    }
                }
            }else{
                // nombre de usuario exite
                return $this->response->setJSON(json_encode(array(
                    'warning' => "El ci ingresado ya  se encuentra registrado"
                )));
            }
        }

        return $this->response->setJSON(json_encode(array(
            'error' => "Error al registrar administrativo"
        )));
    }

    // MAESTROS
    public function maestro()
    {
        return $this->templater->view('maestro', []);
    }

    // Listado de administrativos
    public function ajaxListarMaestros()
    {
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $table = "rs_view_maestro";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_maestro', 'dt' => 1),
                array('db' => 'nombres_apellidos', 'dt' => 2),
                array('db' => 'nacimiento', 'dt'        => 3),
                array('db' => 'telefono', 'dt'          => 4),
                array('db' => 'sexo', 'dt'              => 5),
                array('db' => 'grado_academico', 'dt'   => 6)
            );

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
        }else{
            return null;
        }

    }
}
