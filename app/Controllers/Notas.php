<?php

namespace App\Controllers;

use App\Libraries\SSP;

class Notas extends BaseController
{
	public function listarEstudiantes()
	{
		return $this->templater->view('Notas/listarEstudiantes', []);
	}
	public function ajaxListarEstudiantes()
	{
		$table = <<<EOT
			(SELECT id_estudiante, p.id_persona, rude, gestion_ingreso, concat(ci,' ', exp) ci,
			concat(paterno,' ',materno,' ',nombres)as nombre_completo, nacimiento, sexo, telefono, domicilio
			FROM rs_estudiante e join rs_persona p on e.id_estudiante  = p.id_persona) temp 
			EOT;
		$primaryKey = 'id_persona';
		$columns = array(
			array('db' => 'id_estudiante', 'dt' => 0),
			array('db' => 'nombre_completo', 'dt' => 1),
			array('db' => 'nacimiento', 'dt' => 2),
			array('db' => 'ci', 'dt' => 3),
			// array(
			// 	'db'        => 'start_date',
			// 	'dt'        => 4,
			// 	'formatter' => function ($d, $row) {
			// 		return date('jS M y', strtotime($d));
			// 	}
			// ),
			// array(
			// 	'db'        => 'salary',
			// 	'dt'        => 5,
			// 	'formatter' => function ($d, $row) {
			// 		return '$' . number_format($d);
			// 	}
			// )
		);

		$sql_details = array('user' => $this->db->username, 'pass' => $this->db->password, 'db'   => $this->db->database, 'host' => $this->db->hostname);
		return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
	}
}
