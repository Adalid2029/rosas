<?php

namespace App\Libraries;

use App\Controllers\BaseController;

class Email extends BaseController
{
    public $config = [];
    public $email = null;

    public function __construct(
        $SMTPHost = 'mail.platzi.xyz',
        $SMTPUser = 'platzixy@platzi.xyz',
        $SMTPPass = 'NbEQ6uyMAMa%',
        $SMTPPort = 465,
        $SMTPCrypto = 'tls'
    ) {
        $this->email = \Config\Services::email();
        $this->config['protocol'] = 'SMTP';
        $this->config['SMTPHost'] = $SMTPHost;
        $this->config['SMTPUser'] = $SMTPUser;
        $this->config['SMTPPass'] = $SMTPPass;
        $this->config['SMTPPort'] = $SMTPPort;
        $this->config['SMTPCrypto'] = $SMTPCrypto;
        $this->config['CRLF'] = '\r\n';
        $this->config['newline'] = '\r\n';
        $this->config['mailType'] = 'html';
    }

    function enviarCorreo($correo, $sujeto, $mensaje, $tipoCorreo)
    {
        $this->config['mailType'] = $tipoCorreo;
        $this->email->initialize($this->config);
        
        $this->email->setFrom('platzixy@platzi.xyz', 'Unidad Educativa las Rosas');
        $this->email->setTo($correo);

        $this->email->setSubject($sujeto);
        $this->email->setMessage($mensaje);
        $this->email->send();
    }
}
