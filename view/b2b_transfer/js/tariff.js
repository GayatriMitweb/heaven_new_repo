var columns1 = [
	{ title: 'S_NO' },
	{ title: 'Vehicle_Name' },
	{ title: 'Currency' },
	{ title: 'Actions', className: 'text-center' }
];
tariff_list_reflect();
function tariff_list_reflect () {
	$('#div_request_list').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	$.post('tariff/list_reflect.php', { from_date: from_date, to_date: to_date }, function (data) {
		setTimeout(() => {
			pagination_load(data, columns1, true, false, 20, 'b2b_tarrif_tab'); // third parameter is for bg color show yes or not
			$('.loader').remove();
		}, 800);
	});
}

function view_modal (tariff_id) {
	$.post('tariff/view/index.php', { tariff_id: tariff_id }, function (data) {
		$('#div_tariffsave_modal').html(data);
	});
}
function tredit_modal (tariff_id) {
	$.post('tariff/edit_modal.php', { tariff_id: tariff_id }, function (data) {
		$('#div_tariffsave_modal').html(data);
	});
}
