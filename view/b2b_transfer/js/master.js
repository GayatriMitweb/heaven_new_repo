$('#master_save_modal').on('shown.bs.modal', function () {
	$('#vehicle_name').focus();
});
var columns = [
	{ title: 'S_No.' },
	{ title: 'Vehicle_type' },
	{ title: 'Vehicle_name' },
	{ title: 'Seating_capacity' },
	{ title: 'Actions', className: 'text-center' }
];
function master_list_reflect () {
	$.post('master/list_reflect.php', {}, function (data) {
		setTimeout(() => {
			pagination_load(data, columns, true, false, 20, 'tbl_list');
		}, 1000);
	});
}
master_list_reflect();

function edit_modal (entry_id) {
	$.post('master/edit_modal.php', { entry_id: entry_id }, function (data) {
		$('#div_edit_modal').html(data);
	});
}

function service_time_modal () {
	$.post('master/service_time_add.php', {}, function (data) {
		$('#div_view_modal').html(data);
	});
}

$('body').delegate('.servingTime .st-toggleProfile', 'click', function () {
	var thidParent = $(this).parents('.servingTime');
	if (!thidParent.hasClass('st-editable')) {
		thidParent.addClass('st-editable');
		thidParent.find('.form-control').prop('readonly', false);
		$('#pickup_from_time,#pickup_to_time,#return_from_time,#return_to_time').datetimepicker({
			datepicker: false,
			format: 'H:i A'
		});
	}
	else {
		thidParent.removeClass('st-editable');
		thidParent.find('.form-control').prop('readonly', true);
		$('#pickup_from_time,#pickup_to_time,#return_from_time,#return_to_time').datetimepicker('destroy');
	}
});
function save_service_timing () {
	var base_url = $('#base_url').val();
	var pickup_from_time = $('#pickup_from_time').val();
	var pickup_to_time = $('#pickup_to_time').val();
	var return_from_time = $('#return_from_time').val();
	var return_to_time = $('#return_to_time').val();

	if (pickup_from_time == '') {
		error_msg_alert('Please select Pickup From Time');
		return false;
	}
	if (pickup_to_time == '') {
		error_msg_alert('Please select Pickup To Time');
		return false;
	}
	if (return_from_time == '') {
		error_msg_alert('Please select Return From Time');
		return false;
	}
	if (return_to_time == '') {
		error_msg_alert('Please select Return To Time');
		return false;
	}

	var time_array = [];
	time_array.push({
		pick_from   : pickup_from_time,
		pick_to     : pickup_to_time,
		return_from : return_from_time,
		return_to   : return_to_time
	});
	$.ajax({
		type    : 'post',
		url     : base_url + 'controller/b2b_transfer/service_time_save.php',
		data    : { time_array: time_array },
		success : function (result) {
			var msg = result.split('--');
			$('.saveprofile').button('reset');
			if (msg[0] == 'error') {
				error_msg_alert(msg[1]);
				return false;
			}
			else {
				msg_alert(result);
				update_b2c_cache();
				reset_form('frm_time_save');
				$('#time_save_modal').modal('hide');
			}
		}
	});
}
$(function () {
	$('#frm_master_save').validate({
		rules         : {},
		submitHandler : function (form) {
			var image_upload_url = $('#image_upload_url').val();
			var vehicle_type = $('#vehicle_type').val();
			var vehicle_name = $('#vehicle_name').val();
			var seating_capacity = $('#seating_capacity').val();
			var canc_policy = $('#canc_policy').val();

			var vehicle_array = [];
			vehicle_array.push({
				seating_capacity : seating_capacity,
				image            : image_upload_url
			});
			$('#save').button('loading');
			var base_url = $('#base_url').val();
			$.ajax({
				type    : 'post',
				url     : base_url + 'controller/b2b_transfer/vehicle_save.php',
				data    : {
					vehicle_array: JSON.stringify(vehicle_array),
					vehicle_type: vehicle_type,
					vehicle_name: vehicle_name,
					canc_policy: canc_policy
				},
				success : function (result) {
					var msg = result.split('--');
					$('#save').button('reset');
					if (msg[0] == 'error') {
						error_msg_alert(msg[1]);
						return false;
					}
					else {
						msg_alert(result);
						update_b2c_cache();
						master_list_reflect();
						reset_form('frm_master_save');
						$('#master_save_modal').modal('hide');
					}
				}
			});
		}
	});
});
