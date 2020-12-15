$(document).ready(function () {
	$('.seleccion-materia').on('click', function () {
		parametrosModal('#centralizador-interno', 'Editar notas del Estudiante: ', 'modal-lg', false, 'static');
		$('#centralizador-interno-body').html('<embed type="application/pdf" src="' + respuesta.exito + '" width="100%" height="' + $(window).height() + '" style="border: none;" />');
	});
});
