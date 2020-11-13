$(document).ready(function () {
	tbl_listar_estudiantes = $('#tbl_listar_estudiantes').DataTable({
		ajax: '/Notas/ajaxListarEstudiantes',
		columnDefs: [
			{
				searchable: false,
				orderable: false,
				targets: -1,
				data: null,
				render: function (data, type, row, meta) {
					return '<div class="btn-group" role="group"> <a data-id-estudiante="' + data[0] + '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white editar-estudiante" data-toggle="tooltip" title="Editar"> <i class="fa fa-pencil-square-o"></i></a> <a data="' + data[0] + '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white eliminar-estudiante" data-toggle="tooltip" title="Eliminar"> <i class="fa fa-trash-o"></i></a> </div>';
				},
			},
		],
	});
	$('#tbl_listar_estudiantes').on('click', '.editar-estudiante', function () {
		var botonSubir = $('button[type=submit]', $('#frm-nota'));
		$.get('/notas/editarNota', { id_estudiante: $(this).attr('data-id-estudiante') }).done(function (r) {
			botonSubir.html('Editar');
			botonSubir.attr('id', 'editar-nota');
		});
		parametrosModal('#modal', 'Editar notas del Estudiante: ', 'modal-lg', false, true);
	});
	$('#frm-nota').on('submit', function (e) {
		e.preventDefault();
		e.stopPropagation();
		alert();
		console.log($(this).serialize());
	});
});
