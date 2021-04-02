$('#train_arrival_date1, #train_departure_date1').datetimepicker({ format: 'd-m-Y H:i:s' });
$('#transport_start_date1, #transport_end_date1').datetimepicker({ timepicker: false, format: 'd-m-Y' });

function total_days_reflect(offset = '') {
	var from_date = $('#from_date' + offset).val();
	var to_date = $('#to_date' + offset).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var one_day = 1000 * 60 * 60 * 24;

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	var difference_ms = to_date_ms - from_date_ms;
	var total_days = Math.round(Math.abs(difference_ms) / one_day);

	total_days = parseFloat(total_days) + 1;
	$('#total_days' + offset).val(total_days);
}

function package_dynamic_reflect(dest_name) {
	var dest_id = $('#' + dest_name).val();
	var base_url = $('#base_url').val();

	$.ajax({
		type: 'post',
		url: base_url + 'view/package_booking/quotation/inc/get_packages.php',
		data: { dest_id: dest_id },
		success: function (result) {
			$('#package_name_div').html(result);
		},
		error: function (result) {
			console.log(result.responseText);
		}
	});
}

/////////////////////////////////////Site seeing related info start/////////////////////////////////////

function citywise_site_seeing_dynamic_reflect(city_id) {
	if (city_id == '') {
		$('#ul_site_seeing_list li').removeClass('hidden');
	}
	else {
		$('#ul_site_seeing_list li').addClass('hidden');
		$('#ul_site_seeing_list li[data-city-id="' + city_id + '"]').removeClass('hidden');
	}
}

/////////////////////////////////////Site seeing related info end/////////////////////////////////////

function total_passangers_calculate(offset = '') {
	var total_adult = $('#total_adult' + offset).val();
	var children_with_bed = $('#children_with_bed' + offset).val();
	var children_without_bed = $('#children_without_bed' + offset).val();
	var total_infant = $('#total_infant' + offset).val();

	if (total_adult == '') total_adult = 0;
	if (children_with_bed == '') children_with_bed = 0;
	if (children_without_bed == '') children_without_bed = 0;
	if (total_infant == '') total_infant = 0;


	var total_passangers = parseFloat(total_adult) + parseFloat(total_infant) + parseFloat(children_with_bed) + parseFloat(children_without_bed);
	$('#total_passangers' + offset).val(total_passangers);
}

function group_quotation_cost_calculate(id) {
	var total_adult = $('#total_adult').val();
	var total_infant = $('#total_infant').val();
	var total_children = $('#total_children').val();
	var adult_cost = $('#adult_cost').val();
	var children_cost = $('#children_cost').val();
	var infant_cost = $('#infant_cost').val();
	var with_bed_cost = $('#with_bed_cost').val();
	var total_tour_cost = $('#total_tour_cost').val();

	if (infant_cost == '') infant_cost = 0;
	if (tour_cost == '') {
		tour_cost = 0;
	}
	if (total_tour_cost == '') {
		total_tour_cost1 = 0;
	}
	if (infant_cost == '') {
		infant_cost = 0;
	}
	if (adult_cost == '') {
		adult_cost = 0;
	}
	var total = parseFloat(adult_cost) + parseFloat(children_cost) + parseFloat(infant_cost) + parseFloat(with_bed_cost);
	$('#tour_cost').val(total.toFixed(2));

	if (id != 'tour_cost') {
		$('#tour_cost').trigger('change');
	}
	var service_charge = $('#service_charge').val();
	var service_tax_subtotal = $('#service_tax_subtotal').val();
	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}
	total = ($('#basic_show').html() == '&nbsp;') ? total : parseFloat($('#basic_show').text().split(' : ')[1]);
	service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);

	total_tour_cost1 = parseFloat(total) + parseFloat(service_tax_amount) + parseFloat(service_charge);
	$('#total_tour_cost').val(Math.round(total_tour_cost1));

}
function quotation_cost_calculate(id) {
	var offset = id.split('-');
	var quotation_cost = 0;
	var tour_cost = $('#tour_cost-' + offset[1]).val();
	var transport_cost = $('#transport_cost1-' + offset[1]).val();
	var excursion_cost = $('#excursion_cost-' + offset[1]).val();
	var service_tax = $('#service_tax-' + offset[1]).val();

	if (tour_cost == '') {
		tour_cost = 0;
	}
	if (transport_cost == '') {
		transport_cost = 0;
	}
	if (excursion_cost == '') {
		excursion_cost = 0;
	}


	var sub_total = parseFloat(tour_cost) + parseFloat(transport_cost) + parseFloat(excursion_cost);
	$('#basic_amount-' + offset[1]).val(sub_total.toFixed(2));

	if (id != 'basic_amount-' + offset[1]) {
		$('#basic_amount-' + offset[1]).trigger('change');
	}

	var service_charge = $('#service_charge-' + offset[1]).val();
	var service_tax_subtotal = $('#service_tax_subtotal-' + offset[1]).val();
	if (service_charge == '') {
		service_charge = 0;
	}
	var service_tax_amount = 0;
	if (parseFloat(service_tax_subtotal) !== 0.0 && service_tax_subtotal !== '' && typeof service_tax_subtotal != 'undefined') {
		var service_tax_subtotal1 = service_tax_subtotal.split(',');
		for (var i = 0; i < service_tax_subtotal1.length; i++) {
			var service_tax = service_tax_subtotal1[i].split(':');
			service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
		}
	}
	sub_total = ($('#basic_show-' + offset[1]).html() == '&nbsp;') ? sub_total : parseFloat($('#basic_show-' + offset[1]).text().split(' : ')[1]);
	service_charge = ($('#service_show-' + offset[1]).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show-' + offset[1]).text().split(' : ')[1]);


	var total_amt = parseFloat(sub_total) + parseFloat(service_tax_amount) + parseFloat(service_charge);

	$('#total_tour_cost-' + offset[1]).val(Math.round(total_amt).toFixed(2));
}

function get_enquiry_details(offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	$.ajax({
		type: 'post',
		url: base_url + 'view/package_booking/quotation/get_enquiry_details.php',
		dataType: 'json',
		data: { enquiry_id: enquiry_id },
		success: function (result) {
			$('#tour_name' + offset).val(result.tour_name);
			$('#total_days' + offset).val(result.total_days);
			$('#customer_name' + offset).val(result.name);
			$('#email_id' + offset).val(result.email_id);
			$('#mobile_no' + offset).val(result.landline_no);
			$('#total_adult' + offset).val(result.total_adult);
			$('#total_infant' + offset).val(result.total_infant);

			$('#total_adult1' + offset).val(result.total_adult);
			$('#children_without_bed' + offset).val(result.children_without_bed);
			$('#children_with_bed' + offset).val(result.children_with_bed);

			if (result.total_adult === undefined) result.total_adult = 0;
			if (result.total_infant === undefined) result.total_infant = 0;
			if (result.children_without_bed === undefined) result.children_without_bed = 0;
			if (result.children_with_bed === undefined) result.children_with_bed = 0;

			var total_pax = parseFloat(result.total_adult) + parseFloat(result.children_without_bed) + parseFloat(result.children_with_bed) + parseFloat(result.total_infant);
			if (total_pax == '') total_pax = 0;
			$('#total_passangers' + offset).val(total_pax);
			$('#from_date' + offset).val(result.travel_from_date);
			$('#to_date' + offset).val(result.travel_to_date);

			if (enquiry_id != '0') {
				$('#train_departure_date').val(result.travel_from_date + ' 00:00:00');
				$('#txt_dapart1').val(result.travel_from_date + ' 00:00:00');
				$('#cruise_departure_date').val(result.travel_from_date + ' 00:00:00');
				$('#train_dept_date_hidde').val(result.travel_from_date + ' 00:00:00');
				$('#cruise_dept_date_hidde').val(result.travel_from_date + ' 00:00:00');
				$('#plane_dept_date_hidde').val(result.travel_from_date + ' 00:00:00');
			}

			total_days_reflect(offset);
		},
		error: function (result) {
			//console.log(result.responseText);
		}
	});
}
//Get To Date
function get_auto_to_date(from_date) {

	var from_date1 = $('#' + from_date).val();
	var offset = from_date.split('-');
	if (from_date1 != '') {
		var edate = from_date1.split('-');
		e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
		var currentDate = new Date(new Date(e_date).getTime() + 24 * 60 * 60 * 1000);
		var day = currentDate.getDate();
		var month = currentDate.getMonth() + 1;
		var year = currentDate.getFullYear();
		if (day < 10) {
			day = '0' + day;
		}
		if (month < 10) {
			month = '0' + month;
		}
		$('#check_out-' + offset[1]).val(day + '-' + month + '-' + year);
	}
	else {
		$('#check_out-' + offset[1]).val('');
	}
	calculate_total_nights('check_out-' + offset[1]);
}

function calculate_total_nights(to_date1) {

	var offset = to_date1.split('-');
	var from_date = $('#check_in-' + offset[1]).val();
	var to_date = $('#' + to_date1).val();
	if (from_date != '' && to_date != '') {
		var edate = from_date.split('-');
		e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
		var edate1 = to_date.split('-');
		e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

		var one_day = 1000 * 60 * 60 * 24;

		var from_date_ms = new Date(e_date).getTime();
		var to_date_ms = new Date(e_date1).getTime();

		var difference_ms = to_date_ms - from_date_ms;
		var total_days = Math.round(Math.abs(difference_ms) / one_day);

		total_days = parseFloat(total_days);
		$('#hotel_stay_days-' + offset[1]).val(total_days);
	}
	else {
		$('#hotel_stay_days-' + offset[1]).val(0);
	}

}

//function for valid to date
function validate_validDates(to) {

	var offset = to.split('-');
	var from_date = $('#check_in-' + offset[1]).val();
	var to_date1 = $('#' + to).val();

	var edate = from_date.split('-');
	e_date = new Date(edate[2], edate[1] - 1, edate[0]).getTime();
	var edate1 = to_date1.split('-');
	e_date1 = new Date(edate1[2], edate1[1] - 1, edate1[0]).getTime();

	var from_date_ms = new Date(e_date).getTime();
	var to_date_ms = new Date(e_date1).getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert('Date should not be greater than valid to date');
		$('#check_in-' + offset[1]).css({ border: '1px solid red' });
		$('#check_in-' + offset[1]).focus();
		g_validate_status = false;
		return false;
	}
	else {
		$('#check_in-' + offset[1]).css({ border: '1px solid #ddd' });
		return true;
	}
}

