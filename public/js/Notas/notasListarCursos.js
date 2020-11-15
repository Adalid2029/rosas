$(document).ready(function () {
	$.get('/notas/listarCursos').done(function (r) {
		$('.panel-body').html(r.vista);
	});
	$('.panel-body').on('click', '.seleccion-materia', function () {
		id_materia = $(this).attr('data-id-materia');
		id_maestro = $(this).attr('data-id-maestro');
		id_curso = $(this).attr('data-id-curso');
		$.get('/notas/listarEstudiantes', { id_materia, id_maestro, id_curso }).done(function (r) {
			parametrosModal('#estudiantes', 'Editar notas del Estudiante: ', 'modal-lg', false, 'static');
			$('#estudiantes-body').html(r);
		});
	});
});
