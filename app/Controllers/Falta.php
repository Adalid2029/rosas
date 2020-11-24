<?php

namespace App\Controllers;

use App\Controllers\Reportes\CitacionReporte;
use App\Libraries\Ssp;
use App\Models\FaltaModel;
use App\Models\KardexModel;

class Falta extends BaseController
{
    public $model = null;
    public $fecha = null;
    public $data;
    public $kardex;
    public $reporte;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FaltaModel();
        $this->kardex = new KardexModel();
        $this->reporte = new CitacionReporte();
        $this->fecha = new \DateTime();
    }

    // Insert falta
    public function guardar_falta()
    {
        $data  = null;

        if ($this->request->isAJAX()) {

            if ($this->request->getPost("accion_falta") == "in" && $this->request->getPost("id_tipo_falta") == "") {
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_kardex_falta"     => "required",
                        "tipo"          => "required",
                        "descripcion"   => "required|alpha_space",
                        "fecha"         => "required",
                        "registrante"   => "required|alpha_space"
                    ],
                    [ // errors
                        "id_kardex_falta" => [
                            "required" => "El kardex es requerido"
                        ],
                        "tipo" => [
                            "required" => "El tipo de falta es requerido"
                        ],
                        "descripcion" => [
                            "required" => "La descripción de la falta es requerido",
                            "alpha_space"    => "La descripción de la falta debe llevar caracteres alfabéticos y espacios"
                        ]
                        ,
                        "fecha" => [
                            "required" => "La fecha de la falta es requerido"
                        ],
                        "registrante" => [
                            "required" => "El registrante de la falta es requerido",
                            "alpha_space"    => "El registrante de la falta debe llevar caracteres alfabéticos y espacios"
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
                        "id_kardex"     => $this->request->getPost("id_kardex_falta"),
                        "tipo"          => $this->request->getPost("tipo"),
                        "descripcion"   => trim($this->request->getPost("descripcion")),
                        "fecha"         => $this->request->getPost("fecha"),
                        "registrante"   => trim($this->request->getPost("registrante")),
                        "creado_en"     => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->tipo_falta("insert", $data, null, null);

                    if (is_numeric($respuesta)) {

                        $respuesta1 = $this->model->selectContador($this->request->getPost("id_kardex_falta"));

                        if ($respuesta1)
                        {
                            $cont = intval($respuesta1[0]["contador"])+1;
                            $res = $this->kardex->kardex("update", array("contador" => $cont), array("id_kardex" => $this->request->getPost("id_kardex_falta")), null );
                            if ($res){

                                // se verifica el contador de faltas
                                $respuesta = $this->model->verificar5Faltas($this->request->getPost("id_kardex_falta"));

                                if (intval($respuesta[0]["contador"]) == 5){
                                    // si el contador es 5 entonces se inserta la citacion
                                    $data3 = array(
                                        "id_kardex"     => $this->request->getPost("id_kardex_falta"),
                                        "fecha"     => $this->fecha->format('Y-m-d H:i:s')
                                    );
                                    $re = $this->model->citacion("insert", $data3, null, null);
                                    if (is_numeric($re))
                                    {
                                        $res = $this->kardex->kardex("update", array("contador" => 0), array("id_kardex" => $this->request->getPost("id_kardex_falta")), null );
                                        return $this->response->setJSON(json_encode(array(
                                            'exito' => "Falta registrado correctamente y una CITACION GENERADO!!!"
                                        )));
                                    }

                                }else{
                                    return $this->response->setJSON(json_encode(array(
                                        'exito' => "Falta registrado correctamente"
                                    )));
                                }

                            }
                        }



                    }
                }

            } else {
                // actualizar formulario
                //validación de formulario
                $validation = \Config\Services::validation();
                helper(['form', 'url']);
                $val = $this->validate(
                    [ // rules
                        "id_kardex_falta"     => "required",
                        "tipo"          => "required",
                        "descripcion"   => "required|alpha_space",
                        "fecha"         => "required",
                        "registrante"   => "required|alpha_space"
                    ],
                    [ // errors
                        "id_kardex_falta" => [
                            "required" => "El kardex es requerido"
                        ],
                        "tipo" => [
                            "required" => "El tipo de falta es requerido"
                        ],
                        "descripcion" => [
                            "required" => "La descripción de la falta es requerido",
                            "alpha_space"    => "La descripción de la falta debe llevar caracteres alfabéticos y espacios"
                        ]
                        ,
                        "fecha" => [
                            "required" => "La fecha de la falta es requerido"
                        ],
                        "registrante" => [
                            "required" => "El registrante de la falta es requerido",
                            "alpha_space"    => "El registrante de la falta debe llevar caracteres alfabéticos y espacios"
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
                        "tipo"           => $this->request->getPost("tipo"),
                        "descripcion"    => trim($this->request->getPost("descripcion")),
                        "fecha"          => $this->request->getPost("fecha"),
                        "registrante"    => trim($this->request->getPost("registrante")),
                        "actualizado_en" => $this->fecha->format('Y-m-d H:i:s')
                    );

                    $respuesta = $this->model->tipo_falta("update", $data, array(
                        "id_tipo_falta" => $this->request->getPost("id_tipo_falta")
                    ), null);

                    if ($respuesta) {
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Tipo de falta actualizado correctamente"
                        )));
                    }
                }
            }
        }
        return null;
    }


    // Listado de kardex
    public function ajaxListarFaltas()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_tipo_falta";
            $where = "id_kardex=".$this->request->getGet("id_kardex") . " AND estado = 1";
            $primaryKey = "id_tipo_falta";
            $columns = array(
                array('db' => 'id_tipo_falta', 'dt' => 0),
                array('db' => 'id_kardex', 'dt'     => 1),
                array('db' => 'tipo', 'dt'          => 2),
                array('db' => 'descripcion', 'dt'   => 3),
                array('db' => 'fecha', 'dt'         => 4),
                array('db' => 'registrante', 'dt'   => 5),
                array('db' => 'visto', 'dt'         => 6)
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

    // Editar visto
    public function editar_visto()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $respuesta = $this->model->tipo_falta("update", array("visto" => $this->request->getPost("visto")), array(
                "id_tipo_falta" => trim($this->request->getPost("id_tipo_falta"))
            ), null);

            if (($this->request->getPost("visto") === "0")) {
                $msg = "Registro marcado de estado como no visto";
            } else {
                $msg = "Registro marcado de estado como visto";
            }

            if ($respuesta) {
                return $this->response->setJSON(json_encode(array(
                    'exito' => $msg
                )));
            }
        }
    }

    // Editar Kardex
    public function editar_falta()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {
            $condicion = array(
                "id_tipo_falta" => trim($this->request->getPost("id"))
            );
            $respuesta = $this->model->tipo_falta("select", null, $condicion, null);
            return $this->response->setJSON(json_encode($respuesta->getResultArray()));
        }
    }

    // Eliminar faltas
    public function eliminar_falta()
    {
        // se Verifica si es petición ajax
        if ($this->request->isAJAX()) {

            $respuesta = $this->model->tipo_falta("update", array("estado" => 0), array(
                "id_tipo_falta" => trim($this->request->getPost("id"))
            ), null);

            if ($respuesta) {
                $respuesta1 = $this->model->selectContador($this->request->getPost("kardex"));
                if ($respuesta1){
                    $cont = intval($respuesta1[0]["contador"])-1;
                    $res = $this->kardex->kardex("update", array("contador" => $cont), array("id_kardex" => $this->request->getPost("kardex")), null );
                    if ($res){
                        return $this->response->setJSON(json_encode(array(
                            'exito' => "Registro de kardex eliminado correctamente"
                        )));
                    }
                }


            }
        }
    }

    // Listado de citacion
    public function ajaxListarCitacion()
    {
        if ($this->request->isAJAX()) {
            $this->db->transBegin();
            $table = "rs_view_citacion";
            $where = "id_kardex=".$this->request->getGet("id_kardex") ;
            $primaryKey = "id_citacion";
            $columns = array(
                array('db' => 'id_citacion', 'dt'      => 0),
                array('db' => 'id_kardex', 'dt'        => 1),
                array('db' => 'nombres_apellidos', 'dt'=> 2),
                array('db' => 'fecha', 'dt'            => 3)
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

    public function imprimirCitacion(){
        $name = $this->request->getGet("name");
        $fecha = $this->request->getGet("fecha");
        $this->response->setContentType('application/pdf');
        $this->reporte->imprimir($name, $fecha);

    }

}
