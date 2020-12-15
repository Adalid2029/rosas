$(document).ready(function () {
	$('.seleccion-materia').on('click', function () {
		$.get('/notas/imprimirCentralizadorInterno').done(function (r) {
			$('#centralizador-interno-body').html('<embed type="application/pdf" src="' + r.exito + '" width="100%" height="' + $(window).height() + '" style="border: none;" />');
			parametrosModal('#centralizador-interno', 'Editar notas del Estudiante: ', 'modal-lg', false, 'static');
		});
	});
});
