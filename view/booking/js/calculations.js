////////////////////////////////////////////*************Calculation for Booking registration start****************///////////////////////////////////////////////////////

/////// Data reflect for payment details start/////////////////////////////////////////////////
function payment_details_reflected_data(tbl_id) {
	var tour_id = $('#cmb_tour_name').val();
	var count = 0;
	var table = document.getElementById(tbl_id);
	var rowCount = table.rows.length;

	var adult_seats = 0;
	var child_b_seats = 0;
	var child_wb_seats = 0;
	var infant_seats = 0;

	for (
		var i = 0;
		i < rowCount;
		i++ //for loop1 start
	) {
		var row = table.rows[i];

		if (row.cells[0].childNodes[0].checked == true) {
			var adolescence = row.cells[9].childNodes[0].value;
			adolescence = adolescence.trim();
			count++;
			if (adolescence == 'Adult') {
				adult_seats = parseInt(adult_seats) + 1;
			}
			if (adolescence == 'Child With Bed') {
				child_b_seats = parseInt(child_b_seats) + 1;
			}
			if (adolescence == 'Child Without Bed') {
				child_wb_seats = parseInt(child_wb_seats) + 1;
			}
			if (adolescence == 'Infant') {
				infant_seats = parseInt(infant_seats) + 1;
			}
		}
	} //for loop end

	$('#txt_adult_seats').val(parseInt(adult_seats));
	$('#txt_child_b_seats').val(parseInt(child_b_seats));
	$('#txt_child_wb_seats').val(parseInt(child_wb_seats));
	$('#txt_infant_seats').val(parseInt(infant_seats));

	var total_seats =
		parseInt(adult_seats) + parseInt(child_b_seats) + parseInt(child_wb_seats) + parseInt(infant_seats);
	$('#txt_stay_total_seats').val(count);
	$('#txt_total_seats').val(total_seats);

	var adult_type = 'Adult';
	var child_b_type = 'Child With Bed';
	var child_wb_type = 'Child Without Bed';
	var infant_type = 'Infant';
	var total_type = 'total';

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: adult_type, adult_seats: adult_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_adult_expense').val(data);
		}
	);

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: child_b_type, children_seats: child_b_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_child_bed_expense').val(data);
		}
	);
	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: child_wb_type, children_seats: child_wb_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_child_wbed_expense').val(data);
		}
	);

	$.get(
		'../inc/payment_reflect_data.php',
		{ tour_id: tour_id, type: infant_type, infant_seats: infant_seats },
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_infant_expense').val(data);
		}
	);

	///This part calculates total tour fee considering hoteling details
	var tot_members = $('#txt_stay_total_seats').val();
	var extra_bed = $('#txt_extra_bed').val();
	var on_floor = $('#txt_on_floor').val();
	var double_bed_room = $('#txt_double_bed_room').val();

	$.get(
		'../inc/stay_calculations_for_booking.php',
		{
			tour_id: tour_id,
			tot_members: tot_members,
			extra_bed: extra_bed,
			on_floor: on_floor,
			child_b_seats: child_b_seats,
			child_wb_seats: child_wb_seats,
			adult_seats: adult_seats,
			infant_seats: infant_seats,
			double_bed_room: double_bed_room
		},
		function (data) {
			data = parseFloat(data).toFixed(2);
			$('#txt_total_expense').val(data);
			calculate_total_discount('');
		}
	);
}
/////// Data reflect for payment details end/////////////////////////////////////////////////

/////// Calculate Total discount Start /////////////////////////////////////////////////

function calculate_total_discount(id) {
	var repeater_discount = $('#txt_repeater_discount').val();
	var adjustment_discount = $('#txt_adjustment_discount').val();
	var total_expense = $('#txt_total_expense').val();
	var adult_expense = $('#txt_adult_expense').val();
	var child_b_expense = $('#txt_child_bed_expense').val();
	var child_wb_expense = $('#txt_child_wbed_expense').val();
	var infant_expense = $('#txt_infant_expense').val();
	var travel_cost = $('#txt_travel_total_expense1').val();

	if (travel_cost == '') {
		travel_cost = 0;
	}
	if (adult_expense == '') {
		adult_expense = 0;
	}
	if (child_b_expense == '') {
		child_b_expense = 0;
	}
	if (child_wb_expense == '') {
		child_wb_expense = 0;
	}
	if (infant_expense == '') {
		infant_expense = 0;
	}
	if (repeater_discount == '') {
		repeater_discount = 0;
	}
	if (adjustment_discount == '') {
		adjustment_discount = 0;
	}
	if (total_expense == '') {
		total_expense = 0;
	}

	var total_expense =
		parseFloat(adult_expense) +
		parseFloat(child_b_expense) +
		parseFloat(child_wb_expense) +
		parseFloat(infant_expense);

	$('#txt_total_expense').val(total_expense.toFixed(2));

	//This calculates total discount
	var total_discount = parseFloat(repeater_discount) + parseFloat(adjustment_discount);
	if (parseFloat(total_discount) > parseFloat(total_expense)) {
		$('#txt_repeater_discount').val(0);
		$('#txt_adjustment_discount').val(0);
		error_msg_alert("Total discount can't be greater than tour expense!");
		return false;
	}
	$('#txt_total_discount').val(parseFloat(total_discount).toFixed(2));

	//This calculates tour fee
	var tour_fee = parseFloat(total_expense);
	$('#txt_tour_fee').val(parseFloat(tour_fee).toFixed(2));

	var basic_amount = parseFloat(tour_fee) + parseFloat(travel_cost) - parseFloat(total_discount);
	$('#basic_amount').val(parseFloat(basic_amount));

	if (id != 'basic_amount') {
		$('#basic_amount').trigger('change');
	}

	basic_amount = ($('#basic_show').html() == '&nbsp;') ? basic_amount : parseFloat($('#basic_show').text().split(' : ')[1]);
	total_discount = ($('#discount_show').html() == '&nbsp;') ? total_discount : parseFloat($('#discount_show').text().split(' : ')[1]);

	//This calculates 4.35 service tax
	var service_tax_subtotal = $('#txt_service_charge').val();
	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}

	//This calculates total tour fee
	var total_tour_fee = parseFloat(basic_amount) + parseFloat(service_tax_amount);
	var roundoff = Math.round(total_tour_fee) - total_tour_fee;
	$('#roundoff').val(roundoff.toFixed(2));
	$('#txt_total_tour_fee').val(parseFloat(total_tour_fee) + parseFloat(roundoff));

}

/////// Calculate Total discount End /////////////////////////////////////////////////

////////////////////////////////////////////*************Calculation for Booking registration End****************////////////////////////////////////////////////////////
