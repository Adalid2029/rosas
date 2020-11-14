/** @format */

$(document).ready(function () {
	/**
	 * Se dispara cuando se quiera agregar un nuevo grado academico para la persona
	 */
	$('#insertar_grado_academico_persona').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			url: '/persona/campos_grados_academicos',
			data: {
				id_persona: e.target.getAttribute('data-value'),
			},
			dataType: 'html',
		}).done(function (data) {
			parametrosModal('#grado-academico', 'Agregando Grados Academicos', 'modal-lg', false, false);
			$('#grado-academico-body').html(data);

			$('#insertar_grado_academico').on('click', function (event) {
				event.preventDefault();

				// let formData = new FormData();
				// formData.append('id_unidad_academica', $('[name="id_unidad_academica"]').val());
				// formData.append('id_persona', $('#id_persona').val());
				// formData.append('id_grado_academico', $('[name="id_grado_academico"]').val());
				// formData.append('id_tipo_documento_academico', $('[name="id_tipo_documento_academico"]').val());
				// formData.append('numero_titulo', $('[name="numero_titulo"]').val());
				// formData.append('id_modalidad_titulacion', $('[name="id_modalidad_titulacion"]').val());
				// formData.append('descripcion_grado_academico', $('[name="descripcion_grado_academico_persona"]').val());
				// formData.append('observacion', $('[name="observacion"]').val());
				// formData.append('fecha_emision', $('[name="fecha_emision"]').val());
				// formData.append('id_respaldo_digital', $('[name="id_respaldo_digital"]').val());

				$.ajax({
					type: 'POST',
					url: '/persona/insertar_grados_academicos',
					data: new FormData($('#form_campos_grados_academicos')[0]),
					processData: false,
					contentType: false,
					cache: false,
					async: false,
				})
					.done(function (data) {
						if (typeof data.exito !== 'undefined') {
							$('#grado-academico').modal('hide');
							$('#tabla_listar_grados_academicos').DataTable().draw();
						} else {
							alertaSimple('ERROR', data.error, 'top-right', 'error', 3000);
						}
					})
					.fail(function (jqXHR, textStatus) {
						alertaSimple(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
						console.log(jqXHR.responseText);
					});
			});

			/**
			 * Este evento se dispara cuando el usuario desea subir su fotografia de su diploma
			 */
			// $('#respaldo_digital').on('click', function (event) {
			// 	event.preventDefault();
			// 	event.stopPropagation();
			// 	listar_archivos();
			// });
		});
	});
	$('#tabla_listar_grados_academicos')
		.DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
			language: {
				url: 'assets/plugins/datatables/Spanish.json',
			},
			ajax: {
				type: 'GET',
				url: '/persona/ajax_listar_grados_academicos/?id_persona=' + $('#id_persona').val(),
			},
			columnDefs: [
				{
					searchable: false,
					orderable: false,
					targets: 1,
					data: null,
					render: function (data, type, row, meta) {
						return (
							`<div class ="btn-group" >
									<button type="button" class="btn btn-block btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Acci&oacute;n
									</button>								
									<div class="dropdown-menu animated flipInY">
										<a id="editar" style="cursor:default" class="dropdown-item small editar" 
										data-value="` +
							data[0] +
							`" title="Editar">
											<i class="ti-pencil-alt"> </i>Editar
										</a>
										<a id="eliminar" style="cursor:default" class="dropdown-item small eliminar" data-value = "` +
							data[0] +
							`"	title="Eliminar">
											<i class="ti-trash"> </i>Eliminar
										</a>
										<a id="respaldo_digital" style="cursor:default" class="dropdown-item small respaldo_digital" data-value = "` +
							data[0] +
							`"	title="respaldo digital">
											<i class="ti-eye"> </i>respaldo digital
										</a>
										
									</div>									
						</div> 
						
						`
							// <button class="btn btn-sm btn-info respaldo_digital" id="respaldo_digital" data-value="` + data[0] + `"><i class="fa fa-eye"></i></button>
						);
					},
				},
			],
		})
		.on('click', '#editar', function (event) {
			$.ajax({
				method: 'post',
				url: '/persona/campos_grados_academicos_editar',
				data: {
					id_grado_academico_persona: event.target.getAttribute('data-value'),
					id_persona: $('#id_persona').val(),
				},
				dataType: 'html',
			}).done(function (data) {
				parametrosModal('#grado-academico', 'Actualizando Grado Academico', 'modal-lg', true, true);
				$('#grado-academico-body').html(data);

				$('#actualizar_grado_academico').on('click', function (event) {
					event.preventDefault();

					// let formData = new FormData();
					// formData.append('id_grado_academico_persona', $('#id_grado_academico_persona').val());
					// formData.append('id_unidad_academica', $('[name="id_unidad_academica"]').val());
					// formData.append('id_grado_academico', $('[name="id_grado_academico"]').val());
					// formData.append('id_tipo_documento_academico', $('[name="id_tipo_documento_academico"]').val());
					// formData.append('numero_titulo', $('[name="numero_titulo"]').val());
					// formData.append('id_modalidad_titulacion', $('[name="id_modalidad_titulacion"]').val());
					// formData.append('fecha_emision', $('[name="fecha_emision"]').val());
					// formData.append('descripcion_grado_academico', $('[name="descripcion_grado_academico_persona"]').val());
					// // formData.append('id_respaldo_digital', $('[name="id_respaldo_digital"]').val());
					// formData.append('observacion', $('[name="observacion"]').val());

					$.ajax({
						type: 'POST',
						url: '/persona/actualizar_grados_academicos',
						data: new FormData($('#form_campos_grados_academicos')[0]),
						processData: false,
						contentType: false,
						cache: false,
						async: false,
					})
						.done(function (data) {
							if (typeof data.exito !== 'undefined') {
								$('#grado-academico').modal('hide');
								$('#tabla_listar_grados_academicos').DataTable().draw();
							} else {
								alertaSimple('ERROR', data.error, 'top-right', 'error', 3000);
							}
						})
						.fail(function (jqXHR, textStatus) {
							alertaSimple(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
							console.log(jqXHR.responseText);
						});
				});

				/**
				 * Este evento se dispara cuando el usuario desea subir su fotografia de su diploma
				 */

				/**
				 * Este evento se dispara cuando el usuario desea subir su fotografia de su diploma
				 */
				// $('#respaldo_digital').on('click', function (event) {
				// 	event.preventDefault();
				// 	event.stopPropagation();
				// 	listar_archivos();
				// });
			});
		})
		.on('click', 'a#eliminar', function (event) {
			confirm('¿Esta usted seguro que desea eliminar el registro?')
				? $.post('/persona/eliminar_grados_academicos', {
						id_grado_academico_persona: event.target.getAttribute('data-value'),
				  })
						.done(function (response) {
							$('#tabla_listar_grados_academicos').DataTable().draw();
							alertaSimple('EXITOSO', 'Se elimino el registro ' + event.target.getAttribute('data-value'), 'top-right', 'info', 4000);
						})
						.fail(function (jqXHR, textStatus) {
							alertaSimple(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
							console.log(jqXHR.resposnseText);
						})
				: false;
		})
		.on('click', 'a#respaldo_digital', function (event) {
			$.ajax({
				method: 'post',
				url: '/persona/vista_respaldo_digital',
				data: {
					id_persona: $('#id_persona').val(),
					id_grado_academico_persona: event.target.getAttribute('data-value'),
				},
				dataType: 'html',
			}).done(function (data) {
				parametrosModal('#grado-academico', 'GALERIA DE RESPALDO DIGITAL DEL GRADO ACADEMICO', 'modal-lg', true, true);
				$('#grado-academico-body').html(data);
			});
		});

	/**
	 * Accion: Determina que campo se ha cambiado y hace una actualizacion en la base de datos
	 * Retorna: Un objeto JSON informando si todo fue correcto
	 */
	$('#form_campos_datos_personales').on('change', 'input, select', function (event) {
		event.preventDefault();
		var ci_persona = $('[name="ci"]').val();
		let formData = new FormData();
		formData.append(event.target.name, event.target.value.trim());
		formData.append('ci', ci_persona);
		$.ajax({
			type: 'POST',
			url: '/persona/actualizar_datos_personales',
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			async: false,
		})
			.done(function (data) {
				if (typeof data.exito !== 'undefined') {
					alertaSimple('EXITOSO', 'Se actualizo el campo ' + event.target.name, 'top-right', 'info', 4000);
					$('#tabla_listar_personas').DataTable().draw();
				} else {
					alertaSimple('ERROR', data.error, 'top-right', 'error', 3000);
				}
			})
			.fail(function (jqXHR, textStatus) {
				alertaSimple(jqXHR.statusText, jqXHR.status, 'top-right', 'error', 3000);
				console.log(jqXHR.responseText);
			});
	});
});
