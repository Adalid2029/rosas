<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// return view('welcome_message');
		return $this->templater->view('/Home/home', []);
	}
	public function preview()
	{
		return $this->templater->view('/Home/home', []);
	}
}
