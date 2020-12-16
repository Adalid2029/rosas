$(document).ready(function () {
	$('.selectpicker').selectpicker();
	var curso = $('#curso_paralelo').val();
	listar();

	// cargar el listado de por paralelos
	$('#curso_paralelo').on('change', function (e) {
		curso = $('#curso_paralelo').val();
		$('#tbl_asistencia').dataTable().fnDestroy();
		listar();
	});

	// insertar asistencia del estudiante
	$('#tbl_asistencia').on('change', 'select.asistencia', function (e) {
		if ($(`#id_maestro`).val() === '') {
			mensajeAlert('warning', 'Por favor seleccione al maestro', 'Advertencia!!!');
			// console.log('#' + $(this).attr('id'));
			// $(this).val('').trigger('change');
		} else {
			let id = $(this).attr('data');
			let valor = $('#asistencia' + id).val();
			let id_maestro = $('#id_maestro').val();

			$.ajax({
				type: 'POST',
				url: '/asistencia/agregar_asistencia',
				data: {
					id: id,
					valor: valor,
					id_maestro: id_maestro,
				},
				dataType: 'JSON',
			})
				.done(function (response) {
					if (typeof response.exito !== 'undefined') {
						mensajeAlert('success', response.exito, 'Exito');
					}

					if (typeof response.cambio !== 'undefined') {
						mensajeAlert('success', response.cambio, 'Exito');
					}
				})
				.fail(function (e) {
					mensajeAlert('error', 'Error al procesar la peticion', 'Error');
				});
		}
	});
});

function listar() {
	tbl_asistencia = $('#tbl_asistencia').DataTable({
		responsive: true,
		processing: true,
		serverSide: true,
		order: [0, 'desc'],
		ajax: '/asistencia/ajaxListarEstudiantesParalelos/?curso=' + $('#curso_paralelo').val(),
		order: [0, 'desc'],
		// ajax: '/asistencia/ajaxListarEstudiantesParalelos/?curso=' + curso,
		language: {
			url: '/plugins/datatables/lang/Spanish.json',
		},
		columnDefs: [
			{
				searchable: false,
				orderable: false,
				visible: false,
				targets: 1,
			},
			{
				searchable: false,
				orderable: false,
				targets: -1,
				data: null,
				render: function (data, type, row, meta) {
					d = '<select id="asistencia' + data[0] + '" data="' + data[0] + '" name="asistencia" class="custom-select asistencia" data-style="btn-info" data-live-search="true">';
					switch (data[7]) {
						case 'A':
							d += '<option value="">--seleccione--</option><option value="A" selected>ASISTENCIA</option><option value="F">FALTA</option><option value="L">LICENCIA</option><option value="R">RETRASO</option>';
							break;
						case 'F':
							d += '<option value="">--seleccione--</option><option value="A">ASISTENCIA</option><option value="F" selected>FALTA</option><option value="L">LICENCIA</option><option value="R">RETRASO</option>';
							break;
						case 'L':
							d += '<option value="">--seleccione--</option><option value="A">ASISTENCIA</option><option value="F">FALTA</option><option value="L" selected>LICENCIA</option><option value="R">RETRASO</option>';
							break;
						case 'R':
							d += '<option value="">--seleccione--</option><option value="A">ASISTENCIA</option><option value="F">FALTA</option><option value="L">LICENCIA</option><option value="R" selected>RETRASO</option>';
							break;
						default:
							d += '<option value="" select>--seleccione--</option><option value="A">ASISTENCIA</option><option value="F">FALTA</option><option value="L">LICENCIA</option><option value="R">RETRASO</option>';
							break;
					}
					return (d += '</select>');
				},
			},
		],
	});
}
