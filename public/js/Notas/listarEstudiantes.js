$(document).ready(function () {
	tbl_listar_estudiantes = $('#tbl_listar_estudiantes').DataTable({
		ajax: '/Notas/ajaxListarEstudiantes',
		columnDefs: [
			{
				targets: -1,
				data: null,
				defaultContent: '<button>Click!</button>',
			},
		],
	});
	$('#tbl_listar_estudiantes tbody').on('click', 'button', function () {
		var data = tbl_listar_estudiantes.row($(this).parents('tr')).data();
		parametrosModal('#modal', 'sljds', 'modal-lg', false, true);
	});
});
