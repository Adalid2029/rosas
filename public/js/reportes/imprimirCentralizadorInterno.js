$(document).ready(function () {
	$('.seleccion-materia').on('click', function () {
		var id_materia = $(this).attr('data-id-materia');
		var id_maestro = $(this).attr('data-id-maestro');
		var id_curso_paralelo = $(this).attr('data-id-curso-paralelo');
		$.get('/notas/imprimirCentralizadorInterno', { id_materia, id_maestro, id_curso_paralelo }).done(function (r) {
			if (typeof r.exito !== 'undefined') {
				$('#centralizador-interno-body').html('<embed type="application/pdf" src="' + r.exito + '" width="100%" height="' + $(window).height() + '" style="border: none;" />');
				parametrosModal('#centralizador-interno', 'Centralizador Interno', 'modal-lg', false, 'static');
			} else {
				mensajeAlert('warning', r.error, 'Advertencia');
			}
		});
	});
});
