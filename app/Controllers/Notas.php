<?php

namespace App\Controllers;

use App\Controllers\Reportes\NotasReporte;
use App\Libraries\SSP;

class Notas extends BaseController
{
	public $notasReporte = null;
	public function __construct()
	{
		parent::__construct();
		$this->notasReporte = new NotasReporte();
	}
	public function imp()
	{
		$this->response->setContentType('application/pdf');
		$this->notasReporte->imp();
	}
	public function listarEstudiantes()
	{
		return $this->templater->view('Notas/listarEstudiantes', []);
	}
	public function ajaxListarEstudiantes()
	{
		$table = <<<EOT
			(SELECT e.id_estudiante, p.id_persona, rude, concat(ci, ' ', exp) ci, rc.nota1, rc.nota2, rc.nota3, rc.nota_final, concat(paterno, ' ', materno, ' ', nombres) as nombre_completo, nacimiento, sexo, telefono, domicilio
			FROM
			  rs_estudiante e
			  join rs_persona p on e.id_estudiante = p.id_persona
			  left join rs_calificacion rc on rc.id_estudiante = e.id_estudiante
			) temp 
			EOT;
		$primaryKey = 'id_persona';
		$columns = array(
			array('db' => 'id_estudiante', 'dt' => 0),
			array('db' => 'nombre_completo', 'dt' => 1),
			array('db' => 'nacimiento', 'dt' => 2),
			array('db' => 'ci', 'dt' => 3),
			array('db' => 'nota1', 'dt' => 4),
			array('db' => 'nota2', 'dt' => 5),
			array('db' => 'nota3', 'dt' => 6),
			array('db' => 'nota_final', 'dt' => 7),
			// array(
			// 	'db'        => 'start_date',
			// 	'dt'        => 4,
			// 'formatter' => function ($d, $row) {
			// 	return date('jS M y', strtotime($d));
			// }
			// ),
			// array(
			// 	'db'        => 'nota1',
			// 	'dt'        => 4,
			// 	'formatter' => function ($d, $row) {
			// 		return '$' . number_format($d);
			// 	}
			// )
		);

		$sql_details = array('user' => $this->db->username, 'pass' => $this->db->password, 'db'   => $this->db->database, 'host' => $this->db->hostname);
		return $this->response->setJSON(json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)));
	}
}
