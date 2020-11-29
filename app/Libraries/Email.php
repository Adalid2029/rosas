<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;

class Templater extends BaseController
{
    public $request = null;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    function login()
    {
        echo view('login');
    }

    function view($content, $data = array(), $base = "base")
    {

        $email = \Config\Services::email();
        $config['protocol'] = 'SMTP';
        $config['SMTPHost'] = 'mail.platzi.xyz';
        $config['SMTPUser'] = 'platzixy@platzi.xyz';
        $config['SMTPPass'] = 'NbEQ6uyMAMa%';
        $config['SMTPPort'] = 465;
        $config['SMTPCrypto'] = 'tls';
        $config['CRLF'] = '\r\n';
        $config['newline'] = '\r\n';

        $email->initialize($config);

        $email->setFrom('platzixy@platzi.xyz', 'Stack News');
        $email->setTo('adalidalanoca2029@gmail.com');


        $email->setSubject('Hola de nuevo');
        $email->setMessage('Hola Enrique vagillo.');

        $email->send();
        return;
    }
}
