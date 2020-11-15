<?php

namespace App\Controllers;

use App\Controllers\Reportes\NotasReporte;
use App\Libraries\SSP;
use App\Models\NotasModel;

class Notas extends BaseController
{
	public $notasReporte = null;
	public $notasModel = null;
	public function __construct()
	{
		parent::__construct();
		$this->notasReporte = new NotasReporte();
		$this->notasModel = new NotasModel();
	}
	public function index()
	{
		return $this->templater->view('Notas/notasListarCursos', $this->data);
	}
	public function imp()
	{
		$this->response->setContentType('application/pdf');
		$this->notasReporte->imp();
	}
	public function listarEstudiantes()
	{
		$this->data['id_materia'] = $this->request->getGet('id_materia');
		$this->data['id_maestro'] = $this->request->getGet('id_maestro');
		$this->data['id_curso'] = $this->request->getGet('id_curso');
		return $this->templater->view('Notas/notasListarEstudiantes', $this->data);
	}
	public function editarNota()
	{
		if ($this->request->isAJAX()) {
			print_r($_REQUEST);
		}
	}
	public function actualizarNota()
	{
		if ($this->request->isAJAX()) {
			print_r($_REQUEST);
		}
	}
	public function listarCursos()
	{
		$cursos = $this->notasModel->listarCursos(['m.id_maestro' => 1], '', 'cu.id_curso')->getResultArray();
		$cursosMaterias = [];
		foreach ($cursos as $key => $value) {
			$cursosMaterias[] = $this->notasModel->listarCursos(['m.id_maestro' => 1, 'cu.id_curso' => $value['id_curso']], '', '')->getResultArray();
		}
		// var_dump($cursosMaterias);
		if (!empty($cursosMaterias)) {
			$vista = '';
			foreach ($cursosMaterias as $key => $value) {
				$vista .= view('Notas/tarjetas/notasTarjetaCurso', ['curso' => $value]);
			}
			return $this->response->setJSON(json_encode(['exito' => true, 'vista' => $vista]));
		} else
			return $this->response->setJSON(json_encode(['error' => 'No se encontro registros']));
	}
	public function ajaxListarEstudiantes()
	{
		$table = <<<EOT
			(SELECT e.id_estudiante, p.id_persona, rude, concat(ci, ' ', exp) ci, rc.id_materia, rc.nota1, rc.nota2, rc.nota3, rc.nota_final, concat(paterno, ' ', materno, ' ', nombres) as nombre_completo, nacimiento, sexo, telefono, domicilio
			FROM
			  rs_estudiante e
			  join rs_persona p on p.id_persona = e.id_persona
			  left join rs_calificacion rc on rc.id_estudiante = e.id_estudiante
			) temp
			EOT;
		$primaryKey = 'id_persona';
		// $where = "id_materia = 2";
		$columns = array(
			array('db' => 'id_estudiante', 'dt' => 0),
			array('db' => 'nombre_completo', 'dt' => 1),
			array('db' => 'nacimiento', 'dt' => 2),
			array('db' => 'ci', 'dt' => 3),
			array('db' => 'nota1', 'dt' => 4),
			array('db' => 'nota2', 'dt' => 5),
			array('db' => 'nota3', 'dt' => 6),
			array('db' => 'nota_final', 'dt' => 7)
		);

		$sql_details = array('user' => $this->db->username, 'pass' => $this->db->password, 'db'   => $this->db->database, 'host' => $this->db->hostname);
		return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null)));
	}
}
