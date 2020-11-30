$('#tbl-asignaciones-cursos')
	.DataTable({
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
					return (
						'<div class="btn-group" role="group">' +
						'<a data-id-curso-estudiante="' +
						data[0] +
						'" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn-editar-asignaciones-curso-estudiante" data-toggle="tooltip" title="Editar">' +
						'<i class="fa fa-pencil-square-o"></i></a>' +
						'<a data-id-curso-estudiante="' +
						data[0] +
						'" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn-eliminar-asignaciones-curso-estudiante" data-toggle="tooltip" title="Eliminar">' +
						'<i class="fa fa-trash-o"></i></a>' +
						'</div>'
					);
				},
			},
		],
	})
	.on('click', '.btn-editar-asignaciones-curso-estudiante', function (event) {
		var botonSubir = $('button[type=submit]', $('#frm-asignaciones-curso-estudiante'));
		botonSubir.html('Editar');
		botonSubir.attr('id', 'actualizar-asignacion-curso-estudiante');
		parametrosModal('#asignar-curso', 'Asignar Curso', 'modal-lg', false, true);
		$.post('/curso/editarAsignacionesCursoEstudiante', { id_curso_estudiante: $(this).attr('data-id-curso-estudiante') }).done(function (r) {
			if (typeof r.exito !== 'undefined') {
				$('#id_gestion').val(r.datos.id_gestion).trigger('change');
				$('#id_estudiante').val(r.datos.id_estudiante).trigger('change');
				$('#id_curso_paralelo').val(r.datos.id_curso_paralelo).trigger('change');
				botonSubir.attr('data-id-curso-estudiante', r.datos.id_curso_estudiante);
			} else {
			}
		});
	})
	.on('click', '.btn-eliminar-asignaciones-curso-estudiante', function (event) {
		boton = this;
		bootbox.confirm({
			centerVertical: true,
			animate: false,
			size: 'large',
			onEscape: false,
			backdrop: 'static',
			locale: 'es',
			message: '¿Esta usted seguro que desea eliminar esta asignación?, no se podra recuperar la información',
			callback: function (result) {
				if (result) {
					$.post('/curso/eliminarAsignacionesCursoEstudiante', { id_curso_estudiante: $(boton).attr('data-id-curso-estudiante') }).done(function (response) {
						if (typeof response.exito !== 'undefined') {
							mensajeAlert('success', response.exito, 'Exito');
							$('#tbl-asignaciones-cursos').DataTable().draw();
						} else if (typeof response.error !== 'undefined') {
							mensajeAlert('warning', response.form, 'Advertencia');
						}
					});
				}
			},
		});
	});

$('#btn-agregar-asignaciones-curso-estudiante').on('click', function (e) {
	var botonSubir = $('button[type=submit]', $('#frm-asignaciones-curso-estudiante'));
	botonSubir.html('Agregar');
	botonSubir.attr('id', 'insertar-asignacion-curso-estudiante');
	parametrosModal('#asignar-curso', 'Asignar Curso', 'modal-lg', false, true);
});

$('#frm-asignaciones-curso-estudiante').on('submit', function (event) {
	event.preventDefault();
	var botonSubir = $('button[type=submit]', $('#frm-asignaciones-curso-estudiante'));
	if ($(botonSubir).attr('id') === 'actualizar-asignacion-curso-estudiante') insertarActualizarAsignacion('/curso/actualizarAsignacionesCursoEstudiante', botonSubir);
	else insertarActualizarAsignacion('/curso/insertarAsignacionesCursoEstudiante', botonSubir);
});

function insertarActualizarAsignacion(url, event) {
	var formData = new FormData($('#frm-asignaciones-curso-estudiante')[0]);
	if ($(event).attr('id') === 'actualizar-asignacion-curso-estudiante') {
		formData.append('id_curso_estudiante', $(event).attr('data-id-curso-estudiante'));
	}

	$.ajax({
		type: 'post',
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		async: false,
		dataType: 'json',
	})
		.done(function (response) {
			if (typeof response.exito !== 'undefined') {
				mensajeAlert('success', response.exito, 'Exito');
				$('#tbl-asignaciones-cursos').DataTable().draw();
				$('#asignar-curso').modal('hide');
				limpiarCampos();
			} else if (typeof response.error !== 'undefined') {
				mensajeAlert('warning', response.form, 'Advertencia');
			}
		})
		.fail(function (e) {
			mensajeAlert('error', 'Error al registrar/editar la asignación', 'Error');
		});
}

function limpiarCampos() {
	$('#id_gestion').val('').trigger('change');
	$('#id_estudiante').val('').trigger('change');
	$('#id_curso_paralelo').val('').trigger('change');
}

$('#id_gestion,#id_estudiante,#id_curso_paralelo').select2({
	placeholder: '-- Seleccione --',
	allowClear: true,
	dropdownParent: $(`#asignar-curso`),
	width: '100%',
});

$('.btn-cerrar').on('click', function (e) {
	limpiarCampos();
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
