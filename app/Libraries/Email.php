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
        $this->email->initialize($this->config);
    }

    function enviarCorreo()
    {
        $this->email->setFrom('platzixy@platzi.xyz', 'Stack News');
        $this->email->setTo('jcondori92@outlook.es');
        $this->email->setCC('juanzapanacondori@gmail.com');
        
        $this->email->setSubject('Hola de nuevo');
        $this->email->setMessage('Testing the email class.');
        var_dump($this->email->send());
        var_dump($this->email->printDebugger());
    }
}
