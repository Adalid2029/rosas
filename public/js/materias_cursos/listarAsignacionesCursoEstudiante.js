$('#tbl-asignaciones-cursos').DataTable({
	responsive: true,
	processing: true,
	serverSide: true,
	ajax: '/curso/ajaxListarAsignacionesEstudiantes',
	language: {
		url: '/plugins/datatables/lang/Spanish.json',
	},
	columnDefs: [
		{
			searchable: false,
			orderable: false,
			targets: -1,
			data: null,
			render: function (data, type, row, meta) {
				return '<div class="btn-group" role="group">' + '<a data="' + data[0] + '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn-editar-asignaciones-curso-estudiante" data-toggle="tooltip" title="Editar">' + '<i class="fa fa-pencil-square-o"></i></a>' + '<a data="' + data[0] + '" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn-eliminar-asignaciones-curso-estudiante" data-toggle="tooltip" title="Eliminar">' + '<i class="fa fa-trash-o"></i></a>' + '</div>';
			},
		},
	],
});

$('#btn-agregar-asignaciones-curso-estudiante').on('click', function (e) {
	parametrosModal('#asignar-curso', 'Asignar Curso', 'modal-lg', false, true);
});

$('#frm-asignaciones-curso-estudiante').on('submit', function (e) {
	e.preventDefault();
	$.ajax({
		type: 'post',
		url: '/curso/guardar_curso',
		data: new FormData($('#form_iniciar_tramite')[0]),
		processData: false,
		contentType: false,
		cache: false,
		async: false,
		dataType: 'json',
	})
		.done(function (response) {
			if (typeof response.exito !== 'undefined') {
				mensajeAlert('warning', response.form, 'Advertencia');
			} else if (typeof response.error !== 'undefined') {
				$('#tbl_curso').DataTable().draw();
				$('#agregar-curso').modal('hide');
				mensajeAlert('success', response.exito, 'Exito');
				limpiarCampos();
			}
		})
		.fail(function (e) {
			mensajeAlert('error', 'Error al registrar/editar la asignación', 'Error');
		});
});

function limpiarCampos() {
	$('#id_curso_paralelo').val('');
	$('#id_curso').val('').trigger('change');
	$('#id_paralelo').val('').trigger('change');
	$('#accion').val('');
}

$('select').select2({
	placeholder: '-- Seleccione --',
	allowClear: true,
	dropdownParent: $(`#asignar-curso`),
	width: '100%',
});

$('.btn-cerrar').on('click', function (e) {
	limpiarCampos();
});

// Editar curso y paralelo
$('#tbl_curso').on('click', '.btn_editar_curso_p', function (e) {
	let id = $(this).attr('data');
	$.ajax({
		type: 'POST',
		url: '/curso/editar_curso_paralelo',
		data: {
			id: id,
		},
		dataType: 'JSON',
	})
		.done(function (response) {
			$('#id_curso_paralelo').val(response[0]['id_curso_paralelo']);
			$('#id_curso').val(response[0]['id_curso']).trigger('change');
			$('#id_paralelo').val(response[0]['id_paralelo']).trigger('change');
			$('#accion').val('up');

			$('#btn-guardar-curso').html('Editar');
			parametrosModal('#agregar-curso', 'Editar Curso y Paralelo', 'modal-lg', false, true);
		})
		.fail(function (e) {
			$('#agregar-curso').modal('hide');
		});
});

// Eliminar curso paralelo
$('#tbl_curso').on('click', '.btn_eliminar_curso_p', function (e) {
	let id = $(this).attr('data');
	bootbox.confirm('¿Estas seguro de eliminar el curso seleccionado?', function (result) {
		if (result) {
			$.ajax({
				type: 'POST',
				url: '/curso/eliminar_curso',
				data: {
					id: id,
				},
				dataType: 'JSON',
			})
				.done(function (response) {
					if (typeof response.exito !== 'undefined') {
						$('#tbl_curso').DataTable().draw();
						mensajeAlert('success', response.exito, 'Exito');
					}
				})
				.fail(function (e) {
					mensajeAlert('error', 'Error al procesar la peticion', 'Error');
				});
		}
	});
});
