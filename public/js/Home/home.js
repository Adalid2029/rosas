$(document).ready(function () {
	$('#tbl_list_people').DataTable({
		ajax: '/Home/ajaxListPeople',
	});
});
