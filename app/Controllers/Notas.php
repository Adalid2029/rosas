<?php

namespace App\Controllers;

use App\Controllers\Reportes\NotasReporte;
use App\Libraries\Ssp;
use App\Models\NotasModel;
use App\Libraries\Email;

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
		// (new Email)->enviarCorreo();

		// return;
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
		$this->data['id_curso_paralelo'] = $this->request->getGet('id_curso_paralelo');
		$this->data['access'] = $this->db->table('grupo g')->select('GROUP_CONCAT(nombre_grupo) as grupo_usuario')->join('grupo_usuario gu', 'gu.id_grupo = g.id_grupo ')->where(['gu.id_usuario' => $this->user['id_persona']])->get()->getRowArray()['grupo_usuario'];
		return $this->templater->view('Notas/notasListarEstudiantes', $this->data);
	}
	public function editarNota()
	{
		if ($this->request->isAJAX()) {
			// print_r($_REQUEST);
			$notas = $this->notasModel->calificacion('select', null, [
				'id_estudiante' => $this->request->getGet('id_estudiante'),
				'id_curso_paralelo' => $this->request->getGet('id_curso_paralelo'),
				'id_materia' => $this->request->getGet('id_materia'),
				'id_maestro' => $this->request->getGet('id_maestro')
			]);
			if ($notas->getRowArray() !== null) {
				return $this->response->setJSON(json_encode(['exito' => true, 'datos' => $notas->getRowArray()]));
			} else
				return $this->response->setJSON(json_encode(['error' => false]));
		}
	}
	public function actualizarNota()
	{
		if ($this->request->isAJAX()) {
			// print_r($_REQUEST);

			$notas = $this->notasModel->calificacion('select', null, [
				'id_estudiante' => $this->request->getPost('id_estudiante'),
				'id_curso_paralelo' => $this->request->getPost('id_curso_paralelo'),
				'id_materia' => $this->request->getPost('id_materia'),
				'id_maestro' => $this->request->getPost('id_maestro')
			]);

			$datos = [
				'id_estudiante' => $this->request->getPost('id_estudiante'),
				'id_materia' => $this->request->getPost('id_materia'),
				'id_maestro' => $this->request->getPost('id_maestro'),
				'id_curso_paralelo' => $this->request->getPost('id_curso_paralelo'),
				'nota1' => empty($this->request->getPost('nota1')) ? null : $this->request->getPost('nota1'),
				'nota2' => empty($this->request->getPost('nota2')) ? null : $this->request->getPost('nota2'),
				'nota3' => empty($this->request->getPost('nota3')) ? null : $this->request->getPost('nota3'),
				'nota_final' => (intval($this->request->getPost('nota1')) + intval($this->request->getPost('nota2')) + intval($this->request->getPost('nota3'))) / 3,
				'fecha_registro' => date('Y-m-d H:i:s')
			];
			if ($datos['nota_final'] > 0) {
				if ($notas->getRowArray() !== null) {
					$calificacion = $this->notasModel->calificacion('update', $datos, ['id_calificacion' => $notas->getRowArray()['id_calificacion']]);
					return ($calificacion == true) ? $this->response->setJSON(json_encode(['exito' => 'Se actualizo la calificacion con exito'])) : $this->response->setJSON(json_encode(['error' => 'Ha ocurrido un error al actualizar la calificacion']));
				} else {
					$id_calificacion = $this->notasModel->calificacion('insert', $datos, null);
					return is_numeric($id_calificacion) ? $this->response->setJSON(json_encode(['exito' => 'Se inserto la calificacion con exito'])) : $this->response->setJSON(json_encode(['error' => 'Ha ocurrido un error al insertar la calificacion']));
				}
			} else return $this->response->setJSON(json_encode(['error' => 'Error al intentar agregar Nota']));
		}
	}
	public function listarCursos()
	{
		if (is(['MAESTRO']))
			$cursos = $this->notasModel->listarCursos(['m.id_maestro' => $this->user['id_persona']], '', 'cu.id_curso_paralelo')->getResultArray();
		else if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA']))
			$cursos = $this->notasModel->listarCursos(null, '', 'cu.id_curso_paralelo')->getResultArray();
		else if (is(['ESTUDIANTE'])) {
			$cursos = $this->notasModel->listarCursosEstudiante(['ce.id_estudiante' => $this->user['id_persona']], '', 'cp.id_curso_paralelo')->getResultArray();
		}
		// echo json_encode($cursos);
		// var_dump($this->db->getLastQuery());
		// return;
		$cursosMaterias = [];
		foreach ($cursos as $key => $value) {
			if (is(['MAESTRO']))
				$cursosMaterias[] = $this->notasModel->listarCursos(['m.id_maestro' => $this->user['id_persona'], 'cu.id_curso_paralelo' => $value['id_curso_paralelo']], '', '')->getResultArray();
			else if (is(['SUPERADMIN', 'DIRECTOR', 'SECRETARIA']))
				$cursosMaterias[] = $this->notasModel->listarCursos(['cu.id_curso_paralelo' => $value['id_curso_paralelo']], '', '')->getResultArray();
			else if (is(['ESTUDIANTE']))
				$cursosMaterias[] = $this->notasModel->listarCursosEstudiante(['ce.id_estudiante' => $this->user['id_persona'], 'cp.id_curso_paralelo' => $value['id_curso_paralelo']], '', '')->getResultArray();
		}
		// var_dump($cursosMaterias);
		// var_dump($this->db->getLastQuery());
		// return;
		if (!empty($cursosMaterias)) {
			$vista = '';
			foreach ($cursosMaterias as $key => $value) {
				$vista .= view('Notas/tarjetas/notasTarjetaCurso', ['curso' => $value]);
			}
			return $this->response->setJSON(json_encode(['exito' => true, 'vista' => $vista]));
		} else
			return $this->response->setJSON(json_encode(['error' => 'No se encontraron registros']));
	}
	public function ajaxListarEstudiantes()
	{
		// print_r($_REQUEST);
		$table = <<<EOT
			(SELECT e.id_estudiante, p.estado, rude, concat(ci, ' ', exp) ci, rmm.id_maestro, cp.id_curso_paralelo, rmm.id_materia, rc.nota1, rc.nota2, rc.nota3, rc.nota_final, concat(paterno, ' ', materno, ' ', nombres) as nombre_completo, nacimiento, sexo, telefono, domicilio
			from rs_estudiante e
			join rs_persona p on p.id_persona = e.id_estudiante
			join rs_curso_estudiante rce on rce.id_estudiante = e.id_estudiante
			join rs_curso_paralelo cp on cp.id_curso_paralelo =  rce.id_curso_paralelo  
			join rs_materia_maestro rmm on rmm.id_curso_paralelo = cp.id_curso_paralelo
			left join rs_calificacion rc on rc.id_materia = rmm.id_materia and rc.id_maestro = rmm.id_maestro  and rc.id_curso_paralelo = rmm.id_curso_paralelo and rc.id_estudiante = e.id_estudiante
			) temp
			EOT;
		$primaryKey = 'id_estudiante';
		$where = "id_curso_paralelo = " . $this->request->getGet('id_curso_paralelo') . " and id_maestro = " . $this->request->getGet('id_maestro') . " and id_materia = " . $this->request->getGet('id_materia') . " and estado=1 ";
		if (is(['ESTUDIANTE']))
			$where .= 'and id_estudiante = ' . $this->user['id_persona'];
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
		return $this->response->setJSON(json_encode(SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)));
	}
}
