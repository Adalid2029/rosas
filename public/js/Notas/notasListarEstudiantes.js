$(document).ready(function () {
	var t = $('#tbl_listar_estudiantes');
	var tbl_listar_estudiantes = $('#tbl_listar_estudiantes').DataTable({
		ajax: '/Notas/ajaxListarEstudiantes/?id_curso_paralelo=' + $(t).attr('data-id-curso-paralelo') + '&id_materia=' + $(t).attr('data-id-materia') + '&id_maestro=' + $(t).attr('data-id-maestro'),
		columnDefs: [
			{
				searchable: false,
				orderable: false,
				targets: -1,
				data: null,
				render: function (data, type, row, meta) {
					grupoUsuario = $(t).attr('data-grupo-usuario').split(',');
					console.log(data[7]);

					if ((grupoUsuario.includes('SECRETARIA') || grupoUsuario.includes('DIRECTOR')) && data[7] != null) return '<div class="btn-group" role="group"> <a data-id-estudiante="' + data[0] + '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white editar-estudiante" data-toggle="tooltip" title="Editar"> <i class="fa fa-pencil-square-o"></i></a> </div>';
					else if (grupoUsuario.includes('MAESTRO') || grupoUsuario.includes('SUPERADMIN')) return '<div class="btn-group" role="group"> <a data-id-estudiante="' + data[0] + '" class="btn btn-warning btn-sm mdi mdi-tooltip-edit text-white editar-estudiante" data-toggle="tooltip" title="Editar"> <i class="fa fa-pencil-square-o"></i></a> </div>';
					else return null;
				},
			},
		],
		language: {
			url: '/plugins/datatables/lang/Spanish.json',
		},
	});

	$('#tbl_listar_estudiantes').on('click', '.editar-estudiante', function () {
		var botonSubir = $('button[type=submit]', $('#frm-nota'));
		var id_estudiante = $(this).attr('data-id-estudiante');
		var id_curso_paralelo = $(t).attr('data-id-curso-paralelo');
		var id_materia = $(t).attr('data-id-materia');
		var id_maestro = $(t).attr('data-id-maestro');
		$.get('/notas/editarNota', { id_estudiante, id_curso_paralelo, id_materia, id_maestro }).done(function (r) {
			botonSubir.html('Editar');
			botonSubir.attr('id', 'editar-nota');
			botonSubir.attr('data-id-estudiante', id_estudiante);
			botonSubir.attr('data-id-curso-paralelo', id_curso_paralelo);
			botonSubir.attr('data-id-materia', id_materia);
			botonSubir.attr('data-id-maestro', id_maestro);
			if (typeof r.exito !== 'undefined') {
				$('#nota1').val(r.datos.nota1);
				$('#nota2').val(r.datos.nota2);
				$('#nota3').val(r.datos.nota3);
				$('#nota_final').val(r.datos.nota_final);
			} else {
				$('#nota1').val('');
				$('#nota2').val('');
				$('#nota3').val('');
				$('#nota_final').val('');
				// mensajeAlert('warning', r.error, 'Advertencia');
			}
			parametrosModal('#modal', 'Editar notas del Estudiante: ', 'modal-lg', false, 'static');
		});
	});
	$('#frm-nota').on('keyup', 'input, select', function (event) {
		var nota1 = parseInt($('#nota1').val()),
			nota2 = parseInt($('#nota2').val()),
			nota3 = parseInt($('#nota3').val()),
			resultado = 0;
		if (nota1 <= 0 || nota1 > 100 || isNaN(nota1)) {
			$('#nota1').val('');
		} else resultado += nota1;
		if (nota2 <= 0 || nota2 > 100 || isNaN(nota2)) {
			$('#nota2').val('');
		} else resultado += nota2;
		if (nota3 <= 0 || nota3 > 100 || isNaN(nota3)) {
			$('#nota3').val('');
		} else resultado += nota3;
		if (resultado > 0) $('#nota_final').val(resultado / 3);
		else $('#nota_final').val('');
	});
	$('#frm-nota').on('submit', function (event) {
		event.preventDefault();
		event.stopPropagation();
		var formData = new FormData($(this)[0]);
		formData.append('id_estudiante', $('#editar-nota').attr('data-id-estudiante'));
		formData.append('id_curso_paralelo', $('#editar-nota').attr('data-id-curso-paralelo'));
		formData.append('id_materia', $('#editar-nota').attr('data-id-materia'));
		formData.append('id_maestro', $('#editar-nota').attr('data-id-maestro'));

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
					tbl_listar_estudiantes.ajax.reload();
					$('#modal').modal('hide');
				} else {
					mensajeAlert('warning', data.error, 'Advertencia');
				}
			})
			.fail(function (jqXHR, textStatus) {
				console.log(jqXHR.responseText);
			});
	});
});
