$(
	'#txt_package_from_date,#txt_package_to_date,#txt_m_passport_issue_date1,#txt_m_passport_expiry_date1'
).datetimepicker({
	timepicker: false,
	format: 'd-m-Y'
});
var date = new Date();
var yest = date.setDate(date.getDate() - 1);

$('#m_birthdate1').datetimepicker({ timepicker: false, maxDate: yest, format: 'd-m-Y' });
$('#customer_id_p,#quotation_id, #country_name').select2();

function total_days_reflect(offset = '') {
	var from_date = $('#txt_package_from_date' + offset).val();
	var to_date = $('#txt_package_to_date' + offset).val();

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

	$('#txt_tour_total_days' + offset).val(total_days);
}

//////////////////Due date reflect start/////////////////////////////
function due_date_reflect() {
	var text = $('#txt_package_from_date').val();
	var date_arr = text.split('-');

	var d = new Date();
	d.setDate(date_arr[0]);
	d.setMonth(date_arr[1] - 1);
	d.setFullYear(date_arr[2]);
	var yesterdayMs = d.getTime() - 1000 * 60 * 60 * 24; // Offset by one day;
	d.setTime(yesterdayMs);
	var month = d.getMonth() + 1;

	var date1 = d.getDate();
	if(date1 <= 9){
		date1 = '0'+date1;
	}
	if(month <= 9){
		month = '0'+month;
	}
	var due_date = date1 + '-' + month + '-' + d.getFullYear();
	$('#txt_balance_due_date').val(due_date);
}

//////////////////Due date reflect end////////////////////////
function customer_info_load(div_id, offset = '') {
	var customer_id = $('#' + div_id).val();
	if (customer_id == 'ncust') {
		customer_save_modal();
		return false;
	}
	$.ajax({
		type: 'post',
		url: '../inc/customer_info_load.php',
		dataType: 'json',
		data: { customer_id: customer_id },
		success: function (result) {
			console.log(result.state_name + ' State ID');
			$('#txt_m_mobile_no' + offset).val(result.contact_no);
			$('#txt_m_email_id' + offset).val(result.email_id);
			$('#txt_m_address' + offset).val(result.address);
			$('#txt_contact_person_name' + offset).val(
				result.first_name + ' ' + result.middle_name + ' ' + result.last_name
			);
			$('#txt_m_city' + offset).val(result.city);
			$('#txt_m_state' + offset).val(result.state_name);

			if (result.payment_amount != '' || result.payment_amount != '0') {
				$('#credit_amount' + offset).removeClass('hidden');
				$('#credit_amount' + offset).val(result.payment_amount);
			}
			else {
				$('#credit_amount' + offset).addClass('hidden');
			}
		}
	});
}
function state_dropdown_load(country_name, offset = '') {
	var country_name = $('#' + country_name).val();
	$.post('../inc/state_dropdown_load.php', { country_name: country_name }, function (data) {
		$('#txt_m_state' + offset).html(data);
	});
}

function calculate_age_member(id) {
	var dateString1 = $('#' + id).val();
	var get_new = dateString1.split('-');
	var day = get_new[0];
	var month = get_new[1];
	var year = get_new[2];

	var fromdate = month + '/' + day + '/' + year;

	var todate = new Date();

	var age = [],
		fromdate = new Date(fromdate),
		y = [
			todate.getFullYear(),
			fromdate.getFullYear()
		],
		ydiff = y[0] - y[1],
		m = [
			todate.getMonth(),
			fromdate.getMonth()
		],
		mdiff = m[0] - m[1],
		d = [
			todate.getDate(),
			fromdate.getDate()
		],
		ddiff = d[0] - d[1];

	if (mdiff < 0 || (mdiff === 0 && ddiff < 0)) --ydiff;
	if (mdiff < 0) mdiff += 12;
	if (ddiff < 0) {
		fromdate.setMonth(m[1] + 1, 0);
		ddiff = fromdate.getDate() - d[1] + d[0];
		--mdiff;
	}

	if (ydiff >= 0)
		age.push(
			ydiff +
			'Y' +
			(
				ydiff > 0 ? ': ' :
					' ')
		);
	if (mdiff >= 0)
		age.push(
			mdiff +
			'M' +
			(
				mdiff > 0 ? ': ' :
					' ')
		);
	if (ddiff >= 0)
		age.push(
			ddiff +
			'D' +
			(
				ddiff > 0 ? ' ' :
					' ')
		);
	if (age.length > 1) age.splice(age.length - 1, 0, ':');
	var age1 = age.join('');
	var count = id.substr(11);
	var id1 = 'txt_m_age' + count;

	if (age < 1) {
		//document.getElementById("id").value="";
		//alert("Age should be greater than 0.");
	}
	document.getElementById(id1).value = age1;

	var dateString2 = $('#' + id).val();
	var today = new Date();
	var birthDate = php_to_js_date_converter(dateString2);
	var millisecondsPerDay = 1000 * 60 * 60 * 24;
	var millisBetween = today.getTime() - birthDate.getTime();
	var days = millisBetween / millisecondsPerDay;

	var count = id.substr(11);
	var adl = '';
	var no_days = Math.floor(days);

	if (no_days <= 730 && no_days > 0) {
		adl = 'Infant';
	}
	if (no_days > 730 && no_days <= 4383) {
		adl = 'Children';
	}
	if (no_days > 4383) {
		adl = 'Adult';
	}

	$('#txt_m_adolescence' + count).val(adl);
}
function adolescence_reflect(id) {
	var age = $('#' + id).val();
	var count = id.substr(9);
	if (age <= 2 && age > 0) {
		document.getElementById('txt_m_adolescence' + count).value = 'Infant';
	}
	if (age > 2 && age <= 12) {
		document.getElementById('txt_m_adolescence' + count).value = 'Children';
	}
	if (age > 12) {
		document.getElementById('txt_m_adolescence' + count).value = 'Adult';
	}
}

/////////////////////////////////////Site seeing related info start/////////////////////////////////////
$(function () {
	$('#frm_tab_1').validate({
		rules: {
			quotation_id: { required: true },
			txt_package_tour_name: { required: true },
			tour_type: { required: true },
			txt_package_from_date: { required: true },
			txt_package_to_date: { required: true },
			txt_package_to_date: { required: true },
			txt_tour_total_days: { required: true },
			taxation_type: { required: true },
			customer_id_p: { required: true },
			txt_total_required_rooms: { number: true },
			txt_child_with_bed: { number: true },
			txt_child_without_bed: { number: true },
			txt_contact_person_name: { required: true },
			txt_m_passport_no1: { required: function () { if ($('#tour_type').val() == "International") { return true; } else { return false; } } },
			txt_m_passport_issue_date1: { required: function () { if ($('#tour_type').val() == "International") { return true; } else { return false; } } },
			txt_m_passport_expiry_date1: { required: function () { if ($('#tour_type').val() == "International") { return true; } else { return false; } } },

		},
		submitHandler: function (form) {
			var quotation_id = $('#quotation_id').val();
			var customer_id = $('#customer_id_p').val();

			var from_date = $('#txt_package_from_date').val();
			var to_date = $('#txt_package_to_date').val();

			var valid_state = package_tour_booking_tab1_validate();
			if (valid_state == false) {
				return false;
			}
			if (customer_id == '' || customer_id == 0 || customer_id == 'ncust') {
				error_msg_alert('Select Customer!');
				return false;
			}

			if (quotation_id == 0) {
				var table = document.getElementById('package_program_list');
				var rowCount = table.rows.length;
				for (var i = 0; i < rowCount; i++) {
					var row = table.rows[i];
					if (rowCount == 1) {
						if (!row.cells[0].childNodes[0].checked) {
							error_msg_alert('Atleast one day program is required!');
							return false;
						}
					}
					if (row.cells[0].childNodes[0].checked) {
						if (row.cells[3].childNodes[0].value == '') {
							error_msg_alert('Daywise Program is mandatory in row-' + (i + 1) + '<br>');
							return false;
						}
						var flag1 = validate_spattration(row.cells[2].childNodes[0].id);
						var flag2 = validate_dayprogram(row.cells[3].childNodes[0].id);
						var flag3 = validate_onstay(row.cells[4].childNodes[0].id);
						if (!flag1 || !flag2 || !flag3) {
							return false;
						}
					}
				}
				//Hotel info
				var table = document.getElementById('tbl_package_hotel_infomration');
				for (var i = 0; i < table.rows.length; i++) {
					var row = table.rows[i];
					row.cells[4].childNodes[0].value = from_date;
					row.cells[5].childNodes[0].value = to_date;
				}
				//Transport info
				var table = document.getElementById('tbl_package_transport_infomration');
				for (var i = 0; i < table.rows.length; i++) {
					var row = table.rows[i];
					row.cells[3].childNodes[0].value = from_date;
				}
				//Flight info
				var table = document.getElementById('tbl_plane_travel_details_dynamic_row');
				for (var i = 0; i < table.rows.length; i++) {
					var row = table.rows[i];
					row.cells[2].childNodes[0].value = from_date;
				}
			}

			//Passenger count for total seats
			var table = document.getElementById('tbl_package_tour_member');
			var rowCount = table.rows.length;
			var pass_count = 0;
			for (var i = 0; i < rowCount; i++) {
				var row = table.rows[i];
				if (row.cells[0].childNodes[0].checked) {
					pass_count++;
				}
			}
			//Train info
			var table = document.getElementById('tbl_train_travel_details_dynamic_row');
			for (var i = 0; i < table.rows.length; i++) {
				var row = table.rows[i];
				row.cells[6].childNodes[0].value = pass_count;
			}
			//Flight info
			var table = document.getElementById('tbl_plane_travel_details_dynamic_row');
			for (var i = 0; i < table.rows.length; i++) {
				var row = table.rows[i];
				row.cells[6].childNodes[0].value = pass_count;
			}
			//Cruise info
			var table = document.getElementById('tbl_dynamic_cruise_package_booking');
			for (var i = 0; i < table.rows.length; i++) {
				var row = table.rows[i];
				row.cells[7].childNodes[0].value = pass_count;
			}
			due_date_reflect();
			$('#tab_1_head').addClass('done');
			$('#tab_2_head').addClass('active');
			$('.bk_tab').removeClass('active');
			$('#tab_2').addClass('active');
			$('html, body').animate({ scrollTop: $('.bk_tab_head').offset().top }, 200);

			return false;
		}
	});
});

/////////////////////////////////////Package Tour Master Tab1 validate start/////////////////////////////////////
function package_tour_booking_tab1_validate() {
	g_validate_status = true;
	var validate_message = '';
	var tour_type = $('#tour_type').val();

	var table = document.getElementById('tbl_package_tour_member');
	var rowCount = table.rows.length;
	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (rowCount == 1) {
			if (!row.cells[0].childNodes[0].checked) {
				error_msg_alert('Atleast one passenger is required!');
				return false;
			}
		}
		if (row.cells[0].childNodes[0].checked && tour_type == 'International') {
			if (row.cells[10].childNodes[0].value == '') {
				validate_message += 'Enter traveller Passport no in row-' + (i + 1) + '<br>';
			}
			if (row.cells[11].childNodes[0].value == '') {
				validate_message += 'Enter traveller Passport issue date in row-' + (i + 1) + '<br>';
			}
			if (row.cells[12].childNodes[0].value == '') {
				validate_message += 'Enter traveller Passport expiry date in row-' + (i + 1) + '<br>';
			}
		}
		if (row.cells[0].childNodes[0].checked) {
			validate_dynamic_empty_fields(row.cells[3].childNodes[0]);
			validate_dynamic_empty_fields(row.cells[8].childNodes[0]);

			if (row.cells[3].childNodes[0].value == '') {
				validate_message += 'Enter traveller first name in row-' + (i + 1) + '<br>';
			}
			if (!row.cells[4].childNodes[0].value.match(/^[A-z]*$/)) {
				validate_message += 'Enter valid middle name in row-' + (i + 1) + '<br>';
			}

			if (
				!row.cells[7].childNodes[0].value.match(/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/) &&
				!row.cells[7].childNodes[0].value.match(/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/)
			) {
				validate_message += 'Enter valid birth date in row-' + (i + 1) + '<br>';
			}

			if (row.cells[11].childNodes[0].value != '') {
				if (
					!row.cells[11].childNodes[0].value.match(/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/) &&
					!row.cells[11].childNodes[0].value.match(/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/)
				) {
					validate_message += 'Enter valid Issue date in row-' + (i + 1) + '<br>';
				}
			}
			if (row.cells[12].childNodes[0].value != '') {
				if (
					!row.cells[12].childNodes[0].value.match(/^([0-9]{2})\-([0-9]{2})\-([0-9]{4})$/) &&
					!row.cells[12].childNodes[0].value.match(/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/)
				) {
					validate_message += 'Enter valid Expiry date in row-' + (i + 1) + '<br>';
				}
			}

			if (row.cells[8].childNodes[0].value == '') {
				validate_message += 'Enter traveller age in row-' + (i + 1) + '<br>';
			}
		}
	}

	if (validate_message != '') {
		error_msg_alert(validate_message, 10000);
		return false;
	}

	if (g_validate_status == false) {
		return false;
	}
}
/////////////////////////////////////Package Tour Master Tab1 validate end/////////////////////////////////////
function taxes_reflect(tax_id, tax) {
	var base_url = $('#base_url').val();
	$.post(base_url + 'model/app_settings/tax_reflect.php', { tax_id: tax_id, tax: tax }, function (data) {
		$('#tour_taxation_id').html(data);
	});
}

/////////////////////////////////////Quotation information load start/////////////////////////////////////
function quotation_info_load() {
	var quotation_id = $('#quotation_id').val();
	//Quotation is selected
	if (quotation_id != 0) {
		$('#dest_div').html('');
		$('#package_div').html('');
		$('#package_program').html('');
		$.ajax({
			type: 'post',
			url: '../inc/quotation_info_load.php',
			data: { quotation_id: quotation_id },
			success: function (result) {
				var response = JSON.parse(result);
				$('#txt_package_tour_name').val(response.tour_name);
				$('#txt_package_package_id').val(response.package_id);
				$('#txt_package_from_date').val(response.from_date);
				$('#txt_package_to_date').val(response.to_date);
				$('#tour_type').val(response.booking_type);
				$('#txt_tour_total_days').val(response.total_days);
				$('#txt_child_without_bed').val(response.children_without_bed);
				$('#txt_child_with_bed').val(response.children_with_bed);

				var subtotal = parseFloat(response.tour_cost) + parseFloat(response.markup_cost);
				response.tour_cost = response.tour_cost.toFixed(2);
				$('#txt_hotel_expenses').val(response.tour_cost);

				//Passenger Rows
				var table = document.getElementById('tbl_package_tour_member');
				if (table.rows.length == 1) {
					for (var k = 1; k < table.rows.length; k++) {
						document.getElementById('tbl_package_tour_member').deleteRow(k);
					}
				}
				else {
					while (table.rows.length > 1) {
						document.getElementById('tbl_package_tour_member').deleteRow(k);
						table.rows.length--;
					}
				}

				if (table.rows.length != response.total_passangers) {
					for (var j = 0; j < response.total_passangers - 1; j++) {
						addRow('tbl_package_tour_member');
					}
				}

				//Transport Info
				var transport_info_arr = response.transport_info_arr;
				var table = document.getElementById('tbl_package_transport_infomration');
				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_package_transport_infomration').deleteRow(i);
				}
				if (table.rows.length != transport_info_arr.length) {
					for (var i = 1; i < transport_info_arr.length; i++) {
						addRow('tbl_package_transport_infomration');
					}
				}
				for (var i = 0; i < transport_info_arr.length; i++) {
					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');
					row.cells[2].childNodes[0].value = transport_info_arr[i]['vehicle_id'];
					row.cells[3].childNodes[0].value = transport_info_arr[i]['start_date'];

					$(row.cells[4].childNodes[0]).prepend('<optgroup value=' + transport_info_arr[i]['pickup_type'] + ' label="' + (transport_info_arr[i]['pickup_type']).charAt(0).toUpperCase() + (transport_info_arr[i]['pickup_type']).slice(1) + ' Name"><option value="' +transport_info_arr[i]['pickup_type']+'-'+ transport_info_arr[i]['pickup_id'] + '">' + transport_info_arr[i]['pickup'] + '</option></optgroup>');
					document.getElementById(row.cells[4].childNodes[0].id).value = transport_info_arr[i]['pickup_type']+'-'+transport_info_arr[i]['pickup_id'];

					$(row.cells[5].childNodes[0]).prepend('<optgroup value=' + transport_info_arr[i]['drop_type'] + ' label="' + (transport_info_arr[i]['drop_type']).charAt(0).toUpperCase() + (transport_info_arr[i]['drop_type']).slice(1) + ' Name"><option value="'+transport_info_arr[i]['drop_type']+'-' + transport_info_arr[i]['drop_id'] + '">' + transport_info_arr[i]['drop'] + '</option></optgroup>');
					document.getElementById(row.cells[5].childNodes[0].id).value = transport_info_arr[i]['drop_type']+'-'+transport_info_arr[i]['drop_id'];

					row.cells[6].childNodes[0].value = transport_info_arr[i]['vehicle_count'];

					$(row.cells[4].childNodes[0]).select2().trigger('change');
					$(row.cells[5].childNodes[0]).select2().trigger('change');
				}
				destinationLoading("select[name^=pickup_from]", "Pickup Location");
				destinationLoading("select[name^=drop_to]", "Drop-off Location");
				//Excursion Info
				var exc_info_arr = response.exc_info_arr;
				var table = document.getElementById('tbl_package_exc_infomration');
				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_package_exc_infomration').deleteRow(i);
				}
				if (table.rows.length != exc_info_arr.length) {
					for (var i = 1; i < exc_info_arr.length; i++) {
						addRow('tbl_package_exc_infomration');
					}
				}
				for (var i = 0; i < exc_info_arr.length; i++) {

					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');

					// row.cells[3].childNodes[0].value = exc_info_arr[i]['city_id'];
					row.cells[3].childNodes[0].value = exc_info_arr[i]['city_id'];
					$(row.cells[3].childNodes[0]).html(
						'<option value="' +
						exc_info_arr[i]['city_id'] +
						'" selected="selected">' +
						exc_info_arr[i]['city_name'] +
						'</option>'
					);
					city_lzloading(row.cells[3].childNodes[0]);

					$(row.cells[4].childNodes[0]).html(
						'<option value="' + exc_info_arr[i]['exc_id'] + '">' + exc_info_arr[i]['exc_name'] + '</option>'
					);
					row.cells[2].childNodes[0].value = exc_info_arr[i]['exc_date'];
					$(row.cells[5].childNodes[0]).prepend(
						'<option value="' + exc_info_arr[i]['transfer_option'] + '">' + exc_info_arr[i]['transfer_option'] + '</option>'
					);
					row.cells[5].childNodes[0].value = exc_info_arr[i]['transfer_option'];
					$(row.cells[5].childNodes[0]).select2().trigger('change');
				}

				//Train Info
				var train_info_arr = response.train_info_arr;
				var table = document.getElementById('tbl_train_travel_details_dynamic_row');
				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_train_travel_details_dynamic_row').deleteRow(i);
				}
				if (table.rows.length != train_info_arr.length) {
					for (var i = 1; i < train_info_arr.length; i++) {
						addRow('tbl_train_travel_details_dynamic_row');
					}
				}
				for (var i = 0; i < train_info_arr.length; i++) {
					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');

					row.cells[2].childNodes[0].value = train_info_arr[i]['departure_date'];
					// row.cells[3].childNodes[0].value = train_info_arr[i]['from_location'];
					// row.cells[4].childNodes[0].value = train_info_arr[i]['to_location'];
					$(row.cells[3].childNodes[0]).html(
						'<option value="' +
						train_info_arr[i]['from_location'] +
						'" selected="selected">' +
						train_info_arr[i]['from_location'] +
						'</option>'
					);
					city_lzloading(row.cells[3].childNodes[0]);
					$(row.cells[4].childNodes[0]).html(
						'<option value="' +
						train_info_arr[i]['to_location'] +
						'" selected="selected">' +
						train_info_arr[i]['to_location'] +
						'</option>'
					);
					city_lzloading(row.cells[4].childNodes[0]);
					$(row.cells[2].childNodes[0]).trigger('change');
					$(row.cells[3].childNodes[0]).trigger('change');
					$(row.cells[4].childNodes[0]).trigger('change');
				}


				//Flight info
				var flight_info_arr = response.flight_info_arr;
				var table = document.getElementById('tbl_plane_travel_details_dynamic_row');
				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_plane_travel_details_dynamic_row').deleteRow(i);
				}
				if (table.rows.length != flight_info_arr.length) {
					for (var i = 1; i < flight_info_arr.length; i++) {
						addRow('tbl_plane_travel_details_dynamic_row');
					}
				}
				for (var i = 0; i < flight_info_arr.length; i++) {
					var row = table.rows[i];
					row.cells[2].childNodes[0].value = flight_info_arr[i]['departure_date'];

					row.cells[3].childNodes[0].value = flight_info_arr[i]['from_city'] + ' - ' + flight_info_arr[i]['from_location'];


					row.cells[4].childNodes[0].value = flight_info_arr[i]['to_city'] + ' - ' + flight_info_arr[i]['to_location']
					row.cells[0].childNodes[0].setAttribute('checked', 'true');

					row.cells[5].childNodes[0].value = flight_info_arr[i]['airline_name'];
					row.cells[8].childNodes[0].value = flight_info_arr[i]['arrival_date'];
					row.cells[9].childNodes[0].value = flight_info_arr[i]['from_city_id'];
					row.cells[10].childNodes[0].value = flight_info_arr[i]['to_city_id'];

					$(row.cells[2].childNodes[0]).trigger('change');
					$(row.cells[5].childNodes[0]).trigger('change');
					$(row.cells[8].childNodes[0]).trigger('change');
				}
				//Cruise Info
				var cruise_info_arr = response.cruise_info_arr;
				var table = document.getElementById('tbl_dynamic_cruise_package_booking');

				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_dynamic_cruise_package_booking').deleteRow(i);
				}
				//add rows for that length
				if (table.rows.length != cruise_info_arr.length) {
					for (var i = 1; i < cruise_info_arr.length; i++) {
						addRow('tbl_dynamic_cruise_package_booking');
					}
				}
				for (var i = 0; i < cruise_info_arr.length; i++) {
					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');

					row.cells[2].childNodes[0].value = cruise_info_arr[i]['departure_date'];
					row.cells[3].childNodes[0].value = cruise_info_arr[i]['arrival_date'];
					row.cells[4].childNodes[0].value = cruise_info_arr[i]['route'];
					row.cells[5].childNodes[0].value = cruise_info_arr[i]['cabin'];
					row.cells[6].childNodes[0].value = cruise_info_arr[i]['sharing'];

					$(row.cells[2].childNodes[0]).trigger('change');
					$(row.cells[3].childNodes[0]).trigger('change');
					$(row.cells[4].childNodes[0]).trigger('change');
					$(row.cells[5].childNodes[0]).trigger('change');
					$(row.cells[6].childNodes[0]).trigger('change');
				}

				//Hotel info
				var hotel_info_arr = response.hotel_info_arr;
				var table = document.getElementById('tbl_package_hotel_infomration');

				for (var i = 1; i < table.rows.length; i++) {
					document.getElementById('tbl_package_hotel_infomration').deleteRow(i);
				}
				if (table.rows.length != hotel_info_arr.length) {
					for (var i = 1; i < hotel_info_arr.length; i++) {
						addRow('tbl_package_hotel_infomration');
					}
				}
				for (var i = 0; i < hotel_info_arr.length; i++) {
					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');

					$(row.cells[2].childNodes[0]).html(
						'<option value="' +
						hotel_info_arr[i]['city_id'] +
						'" selected="selected">' +
						hotel_info_arr[i]['city_name'] +
						'</option>'
					);
					city_lzloading(row.cells[2].childNodes[0]);
					$(row.cells[3].childNodes[0]).html('<option value="' + hotel_info_arr[i]['hotel_id1'] + '">' + hotel_info_arr[i]['hotel_name1'] + '</option>');
					document.getElementById(row.cells[3].childNodes[0].id).value = hotel_info_arr[i]['hotel_id1'];

					row.cells[4].childNodes[0].value = hotel_info_arr[i]['check_in'];
					row.cells[5].childNodes[0].value = hotel_info_arr[i]['check_out'];
					row.cells[6].childNodes[0].value = hotel_info_arr[i]['total_rooms'];
					$(row.cells[7].childNodes[0]).prepend(
						'<option value="' +
						hotel_info_arr[i]['room_category'] +
						'">' +
						hotel_info_arr[i]['room_category'] +
						'</option>'
					);
					document.getElementById(row.cells[7].childNodes[0].id).value = hotel_info_arr[i]['room_category'];

					$('#' + row.cells[7].childNodes[0].id).select2().trigger("change");

				}
				var tour_type = $('#tour_type').val();
				passport_fields_toggle(tour_type);
			}
		});
	}
	else {
		$('#txt_package_tour_name').val('');
		$('#tour_type').val('');
		$('#txt_package_from_date').val('');
		$('#txt_package_to_date').val('');
		$('#txt_tour_total_days').val('');

		//Train Info
		var table = document.getElementById('tbl_train_travel_details_dynamic_row');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_train_travel_details_dynamic_row').deleteRow(i);
		}
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.cells[2].childNodes[0].value = '';
		}
		//Flight Info
		var table = document.getElementById('tbl_plane_travel_details_dynamic_row');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_plane_travel_details_dynamic_row').deleteRow(i);
		}
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.cells[2].childNodes[0].value = '';
			row.cells[10].childNodes[0].value = '';
		}
		//Cruise Info
		var table = document.getElementById('tbl_dynamic_cruise_package_booking');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_dynamic_cruise_package_booking').deleteRow(i);
		}
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.cells[2].childNodes[0].value = '';
			row.cells[3].childNodes[0].value = '';
			row.cells[4].childNodes[0].value = '';
			row.cells[5].childNodes[0].value = '';
		}
		//Hotel Info
		var table = document.getElementById('tbl_package_hotel_infomration');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_package_hotel_infomration').deleteRow(i);
		}
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.cells[4].childNodes[0].value = '';
			row.cells[5].childNodes[0].value = '';
			row.cells[6].childNodes[0].value = '';
		}
		//Transport Info
		var table = document.getElementById('tbl_package_transport_infomration');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_package_transport_infomration').deleteRow(i);
		}
		for (var i = 0; i < table.rows.length; i++) {
			var row = table.rows[i];
			row.cells[3].childNodes[0].value = '';
			row.cells[4].childNodes[0].value = '';
		}
		//Excursion Info
		var table = document.getElementById('tbl_package_exc_infomration');
		for (var i = 1; i < table.rows.length; i++) {
			document.getElementById('tbl_package_exc_infomration').deleteRow(i);
		}

		//Destination dropdown load
		$.get('../inc/get_destin_dropdown.php', {}, function (data) {
			$('#dest_div').html(data);
		});

		taxes_reflect('', '');

		//Packages load
		var dest_id = $('#dest_name2').val();
		if (dest_id != 0) {
			$.ajax({
				type: 'post',
				url: '../inc/get_packages.php',
				data: { dest_id: dest_id },
				success: function (result) {
					$('#package_program').html(result);
				},
				error: function (result) {
					console.log(result.responseText);
				}
			});
		}
	}
}


function get_package_program(package) {
	var package_id = $('#' + package).val();
	if (package_id != 0) {
		///Package hotel info load
		$.ajax({
			type: 'post',
			url: '../inc/package_hotel_info_load.php',
			data: { package_id: package_id },

			success: function (result) {
				var result1 = JSON.parse(result);
				var hotel_info_arr = result1.hotel_info_arr;
				var table = document.getElementById('tbl_package_hotel_infomration');

				if (table.rows.length == 1) {
					for (var i = 1; i < table.rows.length; i++) {
						document.getElementById('tbl_package_hotel_infomration').deleteRow(i);
					}
				}
				else {
					for (var i = 0; i < table.rows.length; i++) {
						document.getElementById('tbl_package_hotel_infomration').deleteRow(i);
					}
				}
				if (table.rows.length != hotel_info_arr.length) {
					for (var i = 1; i < hotel_info_arr.length; i++) {
						addRow('tbl_package_hotel_infomration');
					}
				}
				for (var i = 0; i < hotel_info_arr.length; i++) {

					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');
					$(row.cells[2].childNodes[0]).html(
						'<option value="' +
						hotel_info_arr[i]['city_id'] +
						'" selected="selected">' +
						hotel_info_arr[i]['city_name'] +
						'</option>'
					);
					city_lzloading(row.cells[2].childNodes[0]);

					$(row.cells[3].childNodes[0]).html(
						'<option value="' +
						hotel_info_arr[i]['hotel_id1'] +
						'">' +
						hotel_info_arr[i]['hotel_name'] +
						'</option>'
					);
				}

				//Transport Info
				var transport_info_arr = result1.transport_info_arr;
				var table = document.getElementById('tbl_package_transport_infomration');

				if (table.rows.length == 1) {
					for (var i = 1; i < table.rows.length; i++) {
						document.getElementById('tbl_package_transport_infomration').deleteRow(i);
					}
				}
				else {
					for (var i = 0; i < table.rows.length; i++) {
						document.getElementById('tbl_package_transport_infomration').deleteRow(i);
					}
				}
				if (table.rows.length != transport_info_arr.length) {
					for (var i = 1; i < transport_info_arr.length; i++) {
						addRow('tbl_package_transport_infomration');
					}
				}
				for (var i = 0; i < transport_info_arr.length; i++) {

					var row = table.rows[i];
					row.cells[0].childNodes[0].setAttribute('checked', 'true');
					row.cells[2].childNodes[0].value = transport_info_arr[i]['vehicle_id'];
					$(row.cells[4].childNodes[0]).prepend('<optgroup value=' + transport_info_arr[i]['pickup_type'] + ' label="' + (transport_info_arr[i]['pickup_type']).charAt(0).toUpperCase() + (transport_info_arr[i]['pickup_type']).slice(1) + ' Name"><option value="' +transport_info_arr[i]['pickup_type']+'-'+ transport_info_arr[i]['pickup_id'] + '">' + transport_info_arr[i]['pickup'] + '</option></optgroup>');
					document.getElementById(row.cells[4].childNodes[0].id).value = transport_info_arr[i]['pickup_type']+'-'+transport_info_arr[i]['pickup_id'];

					$(row.cells[5].childNodes[0]).prepend('<optgroup value=' + transport_info_arr[i]['drop_type'] + ' label="' + (transport_info_arr[i]['drop_type']).charAt(0).toUpperCase() + (transport_info_arr[i]['drop_type']).slice(1) + ' Name"><option value="' +transport_info_arr[i]['drop_type']+'-'+ transport_info_arr[i]['drop_id'] + '">' + transport_info_arr[i]['drop'] + '</option></optgroup>');
					document.getElementById(row.cells[5].childNodes[0].id).value = transport_info_arr[i]['drop_type']+'-'+transport_info_arr[i]['drop_id'];

					row.cells[6].childNodes[0].value = 1;

					$(row.cells[4].childNodes[0]).select2().trigger('change');
					$(row.cells[5].childNodes[0]).select2().trigger('change');
					
				}
				destinationLoading("select[name^=pickup_from]", "Pickup Location");
				destinationLoading("select[name^=drop_to]", "Drop-off Location");

				$('#txt_package_tour_name').val(result1.package_name);
			}
		});

		//Itinerary Reflection
		$.ajax({
			type: 'post',
			url: '../inc/get_package_program.php',
			data: { package_id: package_id },
			success: function (result) {
				if (package_id != 0) {
					$('#package_program').html(result);
				}
				else {
					$('#package_program').html('');
				}
			},
			error: function (result) {
				console.log(result.responseText);
			}
		});
	}
	else {
		$('#txt_package_tour_name').val('');
		$('#tour_type').val('');
		$('#txt_package_from_date').val('');
		$('#txt_package_to_date').val('');
		$('#txt_tour_total_days').val('');
	}
}

function package_dynamic_reflect(dest_name) {
	var dest_id = $('#' + dest_name).val();
	$.ajax({
		type: 'post',
		url: '../inc/get_packages.php',
		data: { dest_id: dest_id },
		success: function (result) {
			if (dest_id != 0) {
				$('#package_div').html(result);
			}
			else {
				$('#package_program').html(result);
			}
		},
		error: function (result) {
			console.log(result.responseText);
		}
	});

	if (dest_id == 0) {
		$('#package_div').html('');
		$('#package_program').html('');
		$('#txt_package_tour_name').val('');
		$('#tour_type').val('');
		$('#txt_package_from_date').val('');
		$('#txt_package_to_date').val('');
		$('#txt_tour_total_days').val('');
	}
}

/**Excursion Name load**/
function get_excursion_list(id) {
	var city_id = $('#' + id).val();
	var base_url = $('#base_url').val();
	var count = id.substring(10);

	$.post(base_url + 'view/package_booking/quotation/home/excursion_name_load.php', { city_id: city_id }, function (
		data
	) {
		$('#excursion-' + count).html(data);
	});
}
/////////////////////////////////////Quotation information load end/////////////////////////////////////

/////////////////////////////////////Passport fields toggle start/////////////////////////////////////
function passport_fields_toggle(tour_type) {
	if (tour_type == 'International') {
		$(
			'input[name="txt_m_passport_no1"],input[name="txt_m_passport_issue_date1"], input[name="txt_m_passport_expiry_date1"]'
		).prop('disabled', false);
	}
	if (tour_type == 'Domestic') {
		$(
			'input[name="txt_m_passport_no1"], input[name="txt_m_passport_issue_date1"], input[name="txt_m_passport_expiry_date1"]'
		).prop('disabled', true);
	}
}
/////////////////////////////////////Passport fields toggle end/////////////////////////////////////
