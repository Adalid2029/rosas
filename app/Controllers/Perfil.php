<?php


namespace App\Controllers;


use App\Models\PerfilModel;

class Perfil extends  BaseController
{
    public $model = null;

    /**
     * Perfil constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this -> model = new PerfilModel();
    }

    // Cargar la vista perfil
    public function perfil()
    {

        return $this->templater->view('perfil/verPerfil', []);
    }

    // cambiar contrasenia
    public function cambiar_password()
    {
        if ($this -> request -> isAJAX())
        {
            // se verifica si la contrasenia actual iguala con lo ingresado

            $res = $this -> model -> verificarPasswordActual();
            if (md5( $this->request->getPost("password_actual") ) == $res[0]["clave"])
            {
                // igual la contrasenia actual y el confirmar
                if ($this->request->getPost("password_nuevo") != $this->request->getPost("confirmar_password")){
                    return $this->response->setJSON(json_encode(array(
                        "rep" => "Repita la contraseña"
                    )));
                }else{
                    // actualizar
                    $data = array(
                        "clave" => md5($this->request->getPost("password_nuevo"))
                    );

                    $res = $this -> model ->usuario("update", $data, array("id_persona" => $_SESSION["id_persona"]), null );
                    if ($res){
                        return $this->response->setJSON(json_encode(array(
                            "success" => "Contraseña cambiada correctemente"
                        )));
                    }else{
                        return $this->response->setJSON(json_encode(array(
                            "error" => "Error al cambiar la Contraseña"
                        )));
                    }


                }

            }else{
                //retorna el error
                return $this->response->setJSON(json_encode(array(
                    "pass" => "Ingrese la contraseña actual correctamente"
                )));
            }
        }
    }

}
