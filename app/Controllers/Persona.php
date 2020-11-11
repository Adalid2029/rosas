<?php

namespace App\Controllers;
use App\Libraries\SSP;
use App\Models\PersonaModel;

class Persona extends BaseController
{
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
        $data_aux = null;
        $fecha = new \DateTime();
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            if( preg_match('/^[a-zA-Z0-9]+$/', trim($this->request->getPost("ci"))) &&
                preg_match('/^[A-Z]+$/', trim($this->request->getPost("exp"))) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', trim($this->request->getPost("paterno"))) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', trim($this->request->getPost("materno"))) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', trim($this->request->getPost("nombre"))) &&
                preg_match('/^[A-Z]+$/', trim($this->request->getPost("sexo"))) &&
                preg_match('/^[0-9 ]+$/', trim($this->request->getPost("telefono"))) &&
                preg_match('/^[a-z0-9A-ZñÑáéíóúÁÉÍÓÚ ]+$/', trim($this->request->getPost("domicilio"))) &&
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', trim($this->request->getPost("cargo"))) &&
                preg_match('/^[0-9]+$/', trim($this->request->getPost("gestion_ingreso")))
            ){
                $p = new PersonaModel();

                $respuesta = $p -> verificarNombreUsuario(trim($this->request->getPost("ci")));

                if($respuesta)
                {
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
                    $respuesta = $p->persona("insert", $data, null, null,);
                    if(is_numeric($respuesta))
                    {
                        $data2 = array(
                            "id_persona" => $respuesta,
                            "cargo" => $this->request->getPost("cargo"),
                            "gestion_ingreso" => $this->request->getPost("gestion_ingreso")
                        );

                        $respuesta2 = $p ->administrativo("insert", $data2, null, null);
                        if (is_numeric($respuesta2))
                        {
                            $data3 = array(
                                "id_persona" => $respuesta,
                                "usuario"    => trim($this->request->getPost("ci")),
                                "clave"      => md5($this->request->getPost("nacimiento")),
                                "creado_en"  => $fecha -> format('Y-m-d H:i:s')
                            );

                            $respuesta3 = $p ->usuario("insert", $data3, null, null);
                            if(is_numeric($respuesta3))
                            {
                                return $this->response->setJSON(json_encode(array(
                                    'exito' => "Administrativo registrado correctamente"
                                )));
                            }
                        }

                    }
                }
                else{
                    $data_aux = array(
                        "ci"            => trim($this->request->getPost("ci")),
                        "exp"           => $this->request->getPost("exp"),
                        "paterno"       => trim($this->request->getPost("paterno")),
                        "materno"       => trim($this->request->getPost("materno")),
                        "nombres"       => trim($this->request->getPost("nombre")),
                        "nacimiento"    => $this->request->getPost("nacimiento"),
                        "sexo"          => $this->request->getPost("sexo"),
                        "telefono"      => trim($this->request->getPost("telefono")),
                        "domicilio"     => trim($this->request->getPost("domicilio")),
                        "cargo" => $this->request->getPost("cargo"),
                        "gestion_ingreso" => $this->request->getPost("gestion_ingreso")
                    );
                    return $this->response->setJSON(json_encode($data_aux));
                }
            }else{
                $data_aux = array(
                    "ci"            => trim($this->request->getPost("ci")),
                    "exp"           => $this->request->getPost("exp"),
                    "paterno"       => trim($this->request->getPost("paterno")),
                    "materno"       => trim($this->request->getPost("materno")),
                    "nombres"       => trim($this->request->getPost("nombre")),
                    "nacimiento"    => $this->request->getPost("nacimiento"),
                    "sexo"          => $this->request->getPost("sexo"),
                    "telefono"      => trim($this->request->getPost("telefono")),
                    "domicilio"     => trim($this->request->getPost("domicilio")),
                    "cargo" => $this->request->getPost("cargo"),
                    "gestion_ingreso" => $this->request->getPost("gestion_ingreso"),
                    "error" => "error"
                );
                return $this->response->setJSON(json_encode($data_aux));
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
