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
					return '<div class="btn-group" role="group"> <a data-id-estudiante="' + data[0] + '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white editar-estudiante" data-toggle="tooltip" title="Editar"> <i class="fa fa-pencil-square-o"></i></a> </div>';
				},
			},
		],
	});
	$.get('/notas/listarCursos').done(function (r) {
		$('.panel-body').html(r.vista);
	});

	$('#tbl_listar_estudiantes').on('click', '.editar-estudiante', function () {
		var botonSubir = $('button[type=submit]', $('#frm-nota'));
		$.get('/notas/editarNota', { id_estudiante: $(this).attr('data-id-estudiante') }).done(function (r) {
			botonSubir.html('Editar');
			botonSubir.attr('id', 'editar-nota');
		});
		parametrosModal('#modal', 'Editar notas del Estudiante: ', 'modal-lg', false, true);
	});

	$('#frm-nota').on('keyup', 'input, select', function (event) {
		event.preventDefault();
		var id_estudiante = $('[name="id_estudiante"]').val();
		let formData = new FormData();
		formData.append(event.target.name, event.target.value.trim());
		formData.append('id_estudiante', id_estudiante);
		$.ajax({
			type: 'post',
			url: '/notas/actualizarNota',
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			async: false,
		})
			.done(function (data) {
				if (typeof data.exito !== 'undefined') {
					mensajeAlert('success', data.exito + event.target.name, 'Exito');
					$('#tbl_listar_estudiantes').DataTable().draw();
				} else {
					mensajeAlert('warning', data.error, 'Advertencia');
				}
			})
			.fail(function (jqXHR, textStatus) {
				console.log(jqXHR.responseText);
			});
	});
});
