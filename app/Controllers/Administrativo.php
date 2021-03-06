<?php

namespace App\Controllers;

use App\Controllers\Reportes\AdministrativosReporte;
use App\Libraries\Ssp;
use App\Models\AdministrativoModel;

class Administrativo extends BaseController
{
    public $model = null;
    public $reporte;
    public function __construct()
    {
        parent::__construct();
        $this->model = new AdministrativoModel();
        $this->reporte = new AdministrativosReporte();
    }

    // ADMINISTRATIVOS
    public function listarAdministrativos()
    {
        return $this->templater->view('personas/administrativo', $this->data);
    }

    public function index()
    {
        $this->data['administrativos'] = $this->model->contarPersonas("view_administrativo")[0]["cantidad"];
        $this->data['maestros'] = $this->model->contarPersonas("view_maestro")[0]["cantidad"];
        $this->data['estudiantes'] = $this->model->contarPersonas("view_estudiante")[0]["cantidad"];
        $this->data['tutores'] = $this->model->contarPersonas("view_tutor")[0]["cantidad"];
//        $this->data['kardex'] = $this->model->contarKardex();
//        $this->data['cursos'] = $this->model->contarCursos();
//        $this->data['asistencia'] = $this->model->contarAsistencia();
//        $this->data['calificacion'] = $this->model->contarCalificaciones();
        $this->data["faltas"] = json_encode($this->model->contarFaltasPorFechas());
        return $this->templater->view('Home/home', $this->data);
    }

    // Listado de administrativos
    public function ajaxListarAdministrativos()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_administrativo";
            $where = "estado = 1";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_administrativo', 'dt' => 1),
                array('db' => 'ci', 'dt'                => 2),
                array('db' => 'nombres_apellidos', 'dt' => 3),
                array('db' => 'correo', 'dt'            => 4),
                array('db' => 'nacimiento', 'dt'        => 5),
                array('db' => 'telefono', 'dt'          => 6),
                array('db' => 'sexo', 'dt'              => 7),
                array('db' => 'cargo', 'dt'             => 8),
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

    // INSERTAR ADMINISTRATIVO
    public function insertar_administrativo()
    {

        $fecha = new \DateTime();

        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            // Verificación del usuario
            $res = $this->model->verificarNombreUsuario(trim($this->request->getPost("ci")));
            if ($res) {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "ci" => "required|alpha_numeric|min_length[6]",
                        "exp" => "required|max_length[2]|alpha",
                        "nombre" => "required|alpha_space",
                        "paterno" => "required|alpha_space",
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
                    ]
                );

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
                        "correo"        => $this->request->getPost("correo"),
                        "sexo"          => $this->request->getPost("sexo"),
                        "telefono"      => trim($this->request->getPost("telefono")),
                        "domicilio"     => trim($this->request->getPost("domicilio")),
                        "creado_en"     => $fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->persona("insert", $data, null, null);

                    if (is_numeric($respuesta)) {
                        $data2 = array(
                            "id_administrativo" => $respuesta,
                            "cargo" => $this->request->getPost("cargo"),
                            "gestion_ingreso" => $this->request->getPost("gestion_ingreso")
                        );

                        $respuesta2 = $this->model->administrativo("insert", $data2, null, null);

                        if (is_numeric($respuesta2)) {
                            $data3 = array(
                                "id_usuario" => $respuesta,
                                "usuario"    => trim($this->request->getPost("ci")),
                                "clave"      => hash("sha512", $this->request->getPost("nacimiento")),
                                "creado_en"  => $fecha->format('Y-m-d H:i:s')
                            );

                            $respuesta3 = $this->model->usuario("insert", $data3, null, null);

                            if (is_numeric($respuesta3)) {
                                $id_grupo_usuario = ($this->db->table('grupo_usuario')->insert([
                                    'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => strtoupper($this->request->getPost("cargo"))])->getRowArray()['id_grupo'],
                                    'id_usuario' => $respuesta,
                                    'estado_grupo_usuario' => 'ACTIVO',
                                ])) ? $this->db->insertID() : $this->db->error();
                                if (is_numeric($id_grupo_usuario)) {
                                    return $this->response->setJSON(json_encode(array(
                                        'exito' => "Administrativo registrado correctamente"
                                    )));
                                }
                            }
                        }
                    }
                }
            } else {
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

    // Editar administrativo
    public function editar_administrativo()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $respuesta = $this->model->personaAdministrativo(trim($this->request->getPost("id")));
            return $this->response->setJSON(json_encode($respuesta));
        }
    }

    // ACTUALIZAR ADMINISTRATIVO
    public function actualizar_administrativo()
    {

        $fecha = new \DateTime();

        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            // Verificación del usuario
            $res = true;
            if ($res) {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "edit_ci"               => "required|alpha_numeric|min_length[6]",
                        "edit_exp"              => "required|max_length[2]|alpha",
                        "edit_nombre"           => "required|alpha_space",
                        "edit_paterno"          => "required",
                        "edit_nacimiento"       => 'required',
                        "edit_telefono"         => "required|numeric",
                        "edit_sexo"             => "required|max_length[1]|alpha",
                        "edit_cargo"            => "required|alpha",
                        "edit_gestion_ingreso"  => "required|numeric|max_length[4]"
                    ],
                    [ // errors
                        "edit_ci" => [
                            "required" => "El CI del usuario es requerido",
                            "alpha_numeric" => "El CI del usuario no debe llevar caracteres especiales",
                            "min_length" => "El CI del usuario debe tener al menos 6 caracteres"
                        ],
                        "edit_exp" => [
                            "required" => "La expedición del ci es requerido",
                            "max_length" => "La expedición del ci debe llevar máximo 2 caracteres",
                            "alpha" => "La expedición del ci debe llevar caracteres especiales"
                        ],
                        "edit_nombre" => [
                            "required" => "El nombre es requerido",
                            "alpha_space" => "El nombre debe llevar caracteres alfabéticos o espacios."
                        ],
                        "edit_paterno" => [
                            "required" => "El apellido paterno es requerido"
                        ],
                        "edit_nacimiento" => [
                            "required" => "La fecha de nacimiento es requerido"
                        ],
                        "edit_telefono" => [
                            "required" => "El telefono es requerido",
                            "numeric" => "El telefono debe llevar caracteres numéricos."
                        ],
                        "edit_sexo" => [
                            "required" => "El sexo es requerido",
                            "max_length" => "El sexo debe llevar máximo 1 caracter",
                            "alpha" => "El sexo no debe llevar caracteres especiales."
                        ],
                        "edit_cargo" => [
                            "required" => "El cargo es requerido",
                            "alpha" => "El cargo debe llevar caracteres alfabéticos o espacios."
                        ],
                        "edit_gestion_ingreso" => [
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
                    // Actualizar el administrativo
                    $data = array(
                        "ci"            => trim($this->request->getPost("edit_ci")),
                        "exp"           => $this->request->getPost("edit_exp"),
                        "paterno"       => trim($this->request->getPost("edit_paterno")),
                        "materno"       => trim($this->request->getPost("edit_materno")),
                        "nombres"       => trim($this->request->getPost("edit_nombre")),
                        "nacimiento"    => $this->request->getPost("edit_nacimiento"),
                        "correo"        => $this->request->getPost("edit_correo"),
                        "sexo"          => $this->request->getPost("edit_sexo"),
                        "telefono"      => trim($this->request->getPost("edit_telefono")),
                        "domicilio"     => trim($this->request->getPost("edit_domicilio")),
                        "actualizado_en" => $fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->persona("update", $data, array(
                        "id_persona" => trim($this->request->getPost("edit_id_persona"))
                    ), null);

                    if ($respuesta) {
                        $data2 = array(
                            "cargo" => trim($this->request->getPost("edit_cargo")),
                            "gestion_ingreso" => trim($this->request->getPost("edit_gestion_ingreso"))
                        );

                        $respuesta2 = $this->model->administrativo("update", $data2, array(
                            "id_administrativo" => trim($this->request->getPost("edit_id_administrativo"))
                        ), null);

                        if ($respuesta2) {
                            $data3 = array(
                                "usuario" => trim($this->request->getPost("edit_ci")),
                                "clave"   => hash("sha512", $this->request->getPost("edit_nacimiento")),
                                "actualizado_en"     => $fecha->format('Y-m-d H:i:s')
                            );
                            $respuesta3 = $this->model->usuario("update", $data3, array(
                                "id_usuario" => trim($this->request->getPost("edit_id_usuario"))
                            ), null);

                            if ($respuesta3) {
                                if (empty($this->request->getPost("edit_id_grupo_usuario"))) {
                                    $id_grupo_usuario = ($this->db->table('grupo_usuario')->insert([
                                        'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => strtoupper($this->request->getPost("edit_cargo"))])->getRowArray()['id_grupo'],
                                        'id_usuario' => trim($this->request->getPost("edit_id_persona")),
                                        'estado_grupo_usuario' => 'ACTIVO',
                                    ])) ? $this->db->insertID() : $this->db->error();
                                } else {
                                    $id_grupo_usuario = ($this->db->table('grupo_usuario')->update([
                                        'id_grupo' => $this->db->table('grupo')->getWhere(['nombre_grupo' => strtoupper($this->request->getPost("edit_cargo"))])->getRowArray()['id_grupo'],
                                        'estado_grupo_usuario' => 'ACTIVO',
                                    ], [
                                        'id_grupo_usuario' => $this->request->getPost("edit_id_grupo_usuario"),
                                    ]));
                                }
                                if ($id_grupo_usuario || is_numeric($id_grupo_usuario)) {
                                    return $this->response->setJSON(json_encode(array(
                                        'exito' => "Administrativo editado correctamente"
                                    )));
                                }
                            }
                        }
                    }
                }
            } else {
                // nombre de usuario exite
                return $this->response->setJSON(json_encode(array(
                    'warning' => "El ci ingresado ya  se encuentra registrado"
                )));
            }
        }

        return $this->response->setJSON(json_encode(array(
            'error' => "Error al editar administrativo"
        )));
    }

    // Eliminar administrativo
    public function eliminar_administrativo()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $data = array(
                "estado" => 0
            );

            $condicion = array(
                "id_persona" => trim($this->request->getPost("id"))
            );

            $respuesta = $this->model->persona("update", $data, $condicion, null);

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => "Administrativo Eliminado correctamente"
                )));
            }
        }
        return null;
    }


    // MAESTROS
    public function maestro()
    {
        return $this->templater->view('maestro', []);
    }

    // Listado de administrativos
    public function ajaxListarMaestros()
    {
        if ($this->request->isAJAX()) {
            $table = "rs_view_maestro";
            $primaryKey = "id_persona";
            $columns = array(
                array('db' => 'id_persona', 'dt'        => 0),
                array('db' => 'id_maestro', 'dt'        => 1),
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
        } else {
            return null;
        }
    }

    public function imprimir()
    {
        $data = $this->model->administrativoReporte();
        $this->response->setContentType('application/pdf');
        $this->reporte->imprimir($data);
    }
} // Class
