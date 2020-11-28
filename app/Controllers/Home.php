<?php

namespace App\Controllers;

use App\Libraries\SSP;
use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{
		// return view('welcome_message');
		return view('principal/index', []);
	}

    public function contacto()
    {
        // return view('welcome_message');
        return view('principal/contacto', []);
    }

    public function nosotros()
    {
        // return view('welcome_message');
        return view('principal/nosotros', []);
    }

}// class
