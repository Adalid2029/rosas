$(document).ready(function () {
	$('#tbl-asignaciones-materias')
		.DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
			ajax: '/maestro/ajaxListarAsignacionesMaestros',
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
							'<a data-id-materia-maestro="' +
							data[0] +
							'" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white btn-editar-asignaciones-materia-maestro" data-toggle="tooltip" title="Editar">' +
							'<i class="fa fa-pencil-square-o"></i></a>' +
							'<a data-id-materia-maestro="' +
							data[0] +
							'" class="btn btn-danger btn-sm mdi mdi-delete-forever text-white btn-eliminar-asignaciones-materia-maestro" data-toggle="tooltip" title="Eliminar">' +
							'<i class="fa fa-trash-o"></i></a>' +
							'</div>'
						);
					},
				},
			],
		})
		.on('click', '.btn-editar-asignaciones-materia-maestro', function (event) {
			var botonSubir = $('button[type=submit]', $('#frm-asignaciones-materia-maestro'));
			botonSubir.html('Editar');
			botonSubir.attr('id', 'actualizar-asignacion-materia-maestro');
			parametrosModal('#asignar-materia', 'Asignar Materia', 'modal-lg', false, true);
			$.post('/maestro/editarAsignacionesMateriaMaestro', { id_materia_maestro: $(this).attr('data-id-materia-maestro') }).done(function (r) {
				if (typeof r.exito !== 'undefined') {
					$('#id_gestion').val(r.datos.id_gestion).trigger('change');
					$('#id_maestro').val(r.datos.id_maestro).trigger('change');
					$('#id_curso_paralelo').val(r.datos.id_curso_paralelo).trigger('change');
					$('#id_materia').val(r.datos.id_materia).trigger('change');
					botonSubir.attr('data-id-materia-maestro', r.datos.id_materia_maestro);
				} else {
				}
			});
		})
		.on('click', '.btn-eliminar-asignaciones-materia-maestro', function (event) {
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
						$.post('/maestro/eliminarAsignacionesMateriaMaestro', { id_materia_maestro: $(boton).attr('data-id-materia-maestro') }).done(function (response) {
							if (typeof response.exito !== 'undefined') {
								mensajeAlert('success', response.exito, 'Exito');
								$('#tbl-asignaciones-materias').DataTable().draw();
							} else if (typeof response.error !== 'undefined') {
								mensajeAlert('warning', response.form, 'Advertencia');
							}
						});
					}
				},
			});
		});

	$('#btn-agregar-asignaciones-materia-maestro').on('click', function (e) {
		var botonSubir = $('button[type=submit]', $('#frm-asignaciones-materia-maestro'));
		botonSubir.html('Agregar');
		botonSubir.attr('id', 'insertar-asignacion-materia-maestro');
		parametrosModal('#asignar-materia', 'Asignar Curso', 'modal-lg', false, true);
	});

	$('#frm-asignaciones-materia-maestro').on('submit', function (event) {
		event.preventDefault();
		var botonSubir = $('button[type=submit]', $('#frm-asignaciones-materia-maestro'));
		if ($(botonSubir).attr('id') === 'actualizar-asignacion-materia-maestro') insertarActualizarAsignacion('/maestro/actualizarAsignacionesMateriaMaestro', botonSubir);
		else insertarActualizarAsignacion('/maestro/insertarAsignacionesMateriaMaestro', botonSubir);
	});

	$('#id_gestion,#id_maestro,#id_curso_paralelo,#id_materia').select2({
		placeholder: '-- Seleccione --',
		allowClear: true,
		dropdownParent: $(`#asignar-materia`),
		width: '100%',
	});

	$('.btn-cerrar').on('click', function (e) {
		limpiarCampos();
	});
});
function insertarActualizarAsignacion(url, event) {
	var formData = new FormData($('#frm-asignaciones-materia-maestro')[0]);
	if ($(event).attr('id') === 'actualizar-asignacion-materia-maestro') {
		formData.append('id_materia_maestro', $(event).attr('data-id-materia-maestro'));
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
				$('#tbl-asignaciones-materias').DataTable().draw();
				$('#asignar-materia').modal('hide');
				limpiarCampos();
			} else if (typeof response.error !== 'undefined') {
				mensajeAlert('warning', response.error, 'Advertencia');
			}
		})
		.fail(function (e) {
			mensajeAlert('error', 'Error al registrar/editar la asignación', 'Error');
		});
}
function limpiarCampos() {
	$('#id_gestion').val('').trigger('change');
	$('#id_maestro').val('').trigger('change');
	$('#id_curso_paralelo').val('').trigger('change');
	$('#id_materia').val('').trigger('change');
}
