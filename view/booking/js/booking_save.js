//$('#txt_date').datetimepicker({ format:'d-m-Y H:i:s' });
$('#frm_tab_3').validate({
	rules: {
		txt_repeater_discount: { required: true },
		txt_adjustment_discount: { required: true },
		txt_date: { required: true },

		txt_payment_date1: {
			required: function () {
				if ($('#chk_pay_for_tour').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},
		cmb_payment_mode1: {
			required: function () {
				if ($('#chk_pay_for_tour').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},
		txt_amount1: {
			required: function () {
				if ($('#chk_pay_for_tour').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},

		txt_payment_date2: {
			required: function () {
				if ($('#chk_pay_for_traveling').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},
		cmb_payment_mode2: {
			required: function () {
				if ($('#chk_pay_for_traveling').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},
		txt_amount2: {
			required: function () {
				if ($('#chk_pay_for_traveling').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		},
		cmb_travel_of_type2: {
			required: function () {
				if ($('#chk_pay_for_traveling').is(':checked') == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		}
	},
	submitHandler: function (form) {
		var tour_payment = document.getElementById('chk_pay_for_tour').checked;
		var traveling_payment = document.getElementById('chk_pay_for_traveling').checked;

		var payment_mode1 = $('#cmb_payment_mode1').val();
		var payment_date1 = $('#txt_payment_date1').val();
		var payment_amount1 = $('#txt_amount1').val();

		var bank_name1 = $('#txt_bank_name1').val();
		var transaction_id1 = $('#txt_transaction_id1').val();
		var bank_id1 = $('#bank_id1').val();

		var payment_date2 = $('#txt_payment_date2').val();
		var payment_mode2 = $('#cmb_payment_mode2').val();
		var payment_amount2 = $('#txt_amount2').val();
		var bank_name2 = $('#txt_bank_name2').val();
		var transaction_id2 = $('#txt_transaction_id2').val();
		var travel_of_type2 = $('#cmb_travel_of_type2').val();
		var bank_id2 = $('#bank_id2').val();

		var credit_amount = $('#credit_amount').val();

		if (tour_payment == true) {
			if (
				payment_mode1 != 'Cash' &&
				payment_mode1 != 'Credit Note' &&
				payment_mode1 != 'Credit Card' &&
				payment_mode1 != 'Online' &&
				payment_amount1 != '0'
			) {
				if (bank_name1 == '') {
					error_msg_alert('Enter tour payment bank name.');
					return false;
				}
				if (transaction_id1 == '') {
					error_msg_alert('Enter tour payment transaction ID.');
					return false;
				}
				if (bank_id1 == '') {
					error_msg_alert('Select creditor bank name.');
					return false;
				}
			}
		}

		if (traveling_payment == true) {
			if (
				payment_mode2 != 'Cash' &&
				payment_mode2 != 'Credit Note' &&
				payment_mode2 != 'Credit Card' &&
				payment_mode2 != 'Online' &&
				payment_amount2 != '0'
			) {
				if (bank_name2 == '') {
					error_msg_alert('Enter travel payment bank name.');
					return false;
				}
				if (transaction_id2 == '') {
					error_msg_alert('Enter travel payment transaction ID.');
					return false;
				}
				if (bank_id2 == '') {
					error_msg_alert('Select creditor bank name.');
					return false;
				}
			}
			if (travel_of_type2 == '') {
				error_msg_alert('Enter travel payment for.');
				return false;
			}
		}

		var total_payment = parseFloat(payment_amount1) + parseFloat(payment_amount2);
		if (credit_amount != '') {
			if (parseFloat(total_payment) > parseFloat(credit_amount)) {
				error_msg_alert('Low Credit note balance');
				return false;
			}
		}
		save_booking_details();
	}
});

/////////////***********Save Complete Booking Details Start**********************************

function save_booking_details() {
	var base_url = $('#base_url').val();
	var unique_timestamp = $('#txt_unique_timestamp').val();

	//** Getting tour information
	var tour_id = $('#cmb_tour_name').val();
	var tour_group_id = $('#cmb_tour_group').val();
	var taxation_type = $('#taxation_type').val();
	var emp_id = $('#emp_id').val();
	var customer_id = $('#customer_id_p').val();
	var branch_admin_id1 = $('#branch_admin_id1').val();
	var financial_year_id = $('#financial_year_id').val();
	//** Getting member information
	var m_honorific = new Array();
	var m_first_name = new Array();
	var m_middle_name = new Array();
	var m_last_name = new Array();
	var m_gender = new Array();
	var m_birth_date = new Array();
	var m_age = new Array();
	var m_adolescence = new Array();
	var m_passport_no = new Array();
	var m_passport_issue_date = new Array();
	var m_passport_expiry_date = new Array();

	var table = document.getElementById('tbl_member_dynamic_row');
	var rowCount = table.rows.length;
	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked) {
			var honorific = row.cells[2].childNodes[0].value;
			var first_name = row.cells[3].childNodes[0].value;
			var middle_name = row.cells[4].childNodes[0].value;
			var last_name = row.cells[5].childNodes[0].value;
			var gender = row.cells[6].childNodes[0].value;
			var birth_date1 = row.cells[7].childNodes[0];
			var birth_date = $(birth_date1).val();
			var age = row.cells[8].childNodes[0].value;
			var adolescence = row.cells[9].childNodes[0].value;
			var passport_no = row.cells[10].childNodes[0].value;
			var passport_issue_date = row.cells[11].childNodes[0].value;
			var passport_expiry_date = row.cells[12].childNodes[0].value;

			m_honorific.push(honorific);
			m_first_name.push(first_name);
			m_middle_name.push(middle_name);
			m_last_name.push(last_name);
			m_gender.push(gender);
			m_birth_date.push(birth_date);
			m_age.push(age);
			m_adolescence.push(adolescence);
			m_passport_no.push(passport_no);
			m_passport_issue_date.push(passport_issue_date);
			m_passport_expiry_date.push(passport_expiry_date);
		}
	}

	var m_email_id = $('#txt_m_email_id').val();
	var m_mobile_no = $('#txt_m_mobile_no').val();
	var m_address = $('#txt_m_address').val();
	var m_handover_adnary = 'no';
	var m_handover_gift = 'no';

	//**Getting relatives details
	var relative_honorofic = $('#cmb_r_honorific').val();
	var relative_name = $('#txt_r_name').val();
	var relative_relation = $('#cmb_relation').val();
	var relative_mobile_no = $('#txt_r_mobile').val();

	//**Hoteling facility
	var single_bed_room = $('#txt_single_bed_room').val();
	var double_bed_room = $('#txt_double_bed_room').val();
	var extra_bed = $('#txt_extra_bed').val();
	var on_floor = $('#txt_on_floor').val();

	//**Traveling information
	var train_expense = $('#txt_train_expense').val();
	var train_service_charge = $('#txt_train_service_charge').val();
	var train_taxation_id = $('#train_taxation_id').val();
	var train_service_tax = $('#train_service_tax').val();
	var train_service_tax_subtotal = $('#train_service_tax_subtotal').val();
	var total_train_expense = $('#txt_train_total_expense').val();

	var plane_expense = $('#txt_plane_expense').val();
	var plane_service_charge = $('#txt_plane_service_charge').val();
	var plane_taxation_id = $('#plane_taxation_id').val();
	var plane_service_tax = $('#plane_service_tax').val();
	var plane_service_tax_subtotal = $('#plane_service_tax_subtotal').val();
	var total_plane_expense = $('#txt_plane_total_expense').val();

	var cruise_expense = $('#txt_cruise_expense').val();
	var cruise_service_charge = $('#txt_cruise_service_charge').val();
	var cruise_taxation_id = $('#cruise_taxation_id').val();
	var cruise_service_tax = $('#cruise_service_tax').val();
	var cruise_service_tax_subtotal = $('#cruise_service_tax_subtotal').val();
	var total_cruise_expense = $('#txt_cruise_total_expense').val();

	var total_travel_expense = $('#txt_travel_total_expense').val();
	var train_ticket_path = $('#txt_train_upload_dir').val();
	var plane_ticket_path = $('#txt_plane_upload_dir').val();
	var cruise_ticket_path = $('#txt_cruise_upload_dir').val();

	//**Train travel details starts here
	var train_travel_date = new Array();
	var train_from_location = new Array();
	var train_to_location = new Array();
	var train_train_no = new Array();
	var train_travel_class = new Array();
	var train_travel_priority = new Array();
	var train_amount = new Array();
	var train_seats = new Array();

	var table = document.getElementById('tbl_train_travel_details_dynamic_row');
	var rowCount = table.rows.length;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked) {
			var travel_date_temp = row.cells[2].childNodes[0];
			var travel_date1 = $(travel_date_temp).val();
			var from_location1 = row.cells[3].childNodes[0].value;
			var to_location1 = row.cells[4].childNodes[0].value;
			var train_no1 = row.cells[5].childNodes[0].value;
			var seats1 = row.cells[6].childNodes[0].value;
			var amount1 = row.cells[7].childNodes[0].value;
			var travel_class1 = row.cells[8].childNodes[0].value;
			var train_travel_priority1 = row.cells[9].childNodes[0].value;

			train_travel_date.push(travel_date1);
			train_from_location.push(from_location1);
			train_to_location.push(to_location1);
			train_train_no.push(train_no1);
			train_travel_class.push(travel_class1);
			train_travel_priority.push(train_travel_priority1);
			train_amount.push(amount1);
			train_seats.push(seats1);
		}
	}

	//** Plane travel details starts here
	var from_city_id_arr = new Array();
	var to_city_id_arr = new Array();
	var plane_travel_date = new Array();
	var plane_from_location = new Array();
	var plane_to_location = new Array();
	var plane_train_no = new Array();
	var plane_amount = new Array();
	var plane_seats = new Array();
	var plane_company = new Array();
	var arravl_arr = new Array();

	var table = document.getElementById('tbl_plane_travel_details_dynamic_row');
	var rowCount = table.rows.length;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];

		if (row.cells[0].childNodes[0].checked) {
			var travel_date_temp = row.cells[2].childNodes[0];
			var travel_date1 = $(travel_date_temp).val();

			var plane_from_location1 = row.cells[3].childNodes[0].value;           
			var to_location1 = row.cells[4].childNodes[0].value;
			var company1 = row.cells[5].childNodes[0].value;
			var seats1 = row.cells[6].childNodes[0].value;
			var amount1 = row.cells[7].childNodes[0].value;
			var arravl1 = row.cells[8].childNodes[0].value;
			var from_city_id1 = row.cells[9].childNodes[0].value;
			var to_city_id1 = row.cells[10].childNodes[0].value;

			from_city_id_arr.push(from_city_id1);
			to_city_id_arr.push(to_city_id1);
			plane_travel_date.push(travel_date1);
			plane_from_location.push(plane_from_location1);
			plane_to_location.push(to_location1);
			plane_amount.push(amount1);
			plane_seats.push(seats1);
			plane_company.push(company1);
			arravl_arr.push(arravl1);
		}
	}

	//**Cruise travel details starts here
	var cruise_dept_date_arr = new Array();
	var cruise_arrival_date_arr = new Array();
	var route_arr = new Array();
	var cabin_arr = new Array();
	var sharing_arr = new Array();
	var cruise_seats_arr = new Array();
	var cruise_amount_arr = new Array();

	var table = document.getElementById('tbl_dynamic_cruise_package_booking');
	var rowCount = table.rows.length;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked) {
			var dept_date = row.cells[2].childNodes[0].value;
			var arrival_date = row.cells[3].childNodes[0].value;
			var route = row.cells[4].childNodes[0].value;
			var cabin = row.cells[5].childNodes[0].value;
			var sharing = row.cells[6].childNodes[0].value;
			var seats1 = row.cells[7].childNodes[0].value;
			var amount1 = row.cells[8].childNodes[0].value;

			cruise_dept_date_arr.push(dept_date);
			cruise_arrival_date_arr.push(arrival_date);
			route_arr.push(route);
			cabin_arr.push(cabin);
			sharing_arr.push(sharing);
			cruise_seats_arr.push(seats1);
			cruise_amount_arr.push(amount1);
		}
	}

	//**Visa & Insurance Details
	var visa_country_name = $('#visa_country_name').val();
	var visa_amount = $('#visa_amount').val();
	var visa_service_charge = $('#visa_service_charge').val();
	var visa_taxation_id = $('#visa_taxation_id').val();
	var visa_service_tax = $('#visa_service_tax').val();
	var visa_service_tax_subtotal = $('#visa_service_tax_subtotal').val();
	var visa_total_amount = $('#visa_total_amount').val();

	var insuarance_company_name = $('#insuarance_company_name').val();
	var insuarance_amount = $('#insuarance_amount').val();
	var insuarance_service_charge = $('#insuarance_service_charge').val();
	var insuarance_taxation_id = $('#insuarance_taxation_id').val();
	var insuarance_service_tax = $('#insuarance_service_tax').val();
	var insuarance_service_tax_subtotal = $('#insuarance_service_tax_subtotal').val();
	var insuarance_total_amount = $('#insuarance_total_amount').val();

	//**Discount details
	var adult_expense = $('#txt_adult_expense').val();
	var child_with_bed = $('#txt_child_bed_expense').val();
	var child_without_bed = $('#txt_child_wbed_expense').val();
	var infant_expense = $('#txt_infant_expense').val();
	var tour_fee = $('#txt_total_expense').val();
	var repeater_discount = $('#txt_repeater_discount').val();
	var adjustment_discount = $('#txt_adjustment_discount').val();
	var tour_fee_subtotal_1 = $('#txt_tour_fee').val();
	var tour_taxation_id = $('#tour_taxation_id').val();
	var service_tax_per = $('#service_tax_per').val();
	var service_tax = $('#txt_service_charge').val();
	var tour_fee_subtotal_2 = $('#txt_total_tour_fee1').val();
	var basic_amount = $('#basic_amount').val();
	var net_total = $('#txt_total_tour_fee').val();

	//**Payment details
	var payment_date1 = $('#txt_payment_date1').val();
	var payment_mode1 = $('#cmb_payment_mode1').val();
	var payment_amount1 = $('#txt_amount1').val();
	var bank_name1 = $('#txt_bank_name1').val();
	var transaction_id1 = $('#txt_transaction_id1').val();
	var payment_for1 = $('#cmb_payment_of_type1').val();
	var p_travel_type1 = $('#cmb_travel_of_type1').val();
	var bank_id1 = $('#bank_id1').val();
	var credit_charges = $('#credit_charges').val();
	var identifier = $('#identifier').val();
	var credit_card_details = $('#credit_card_details').val();
	
	var payment_date2 = $('#txt_payment_date2').val();
	var payment_mode2 = $('#cmb_payment_mode2').val();
	var payment_amount2 = $('#txt_amount2').val();
	var bank_name2 = $('#txt_bank_name2').val();
	var transaction_id2 = $('#txt_transaction_id2').val();
	var payment_for2 = $('#cmb_payment_of_type2').val();
	var p_travel_type2 = $('#cmb_travel_of_type2').val();
	var bank_id2 = $('#bank_id2').val();

	var payment_date = new Array();
	var payment_mode = new Array();
	var payment_amount = new Array();
	var bank_name = new Array();
	var transaction_id = new Array();
	var payment_for = new Array();
	var p_travel_type = new Array();
	var bank_id_arr = new Array();

	var pay_for_tour = document.getElementById('chk_pay_for_tour').checked;
	if (pay_for_tour == true) {
		if (payment_mode1 == 'Cash') {
			bank_name1 = '';
			transaction_id1 = '';
			bank_id1 = '';
		}
		payment_date.push(payment_date1);
		payment_mode.push(payment_mode1);
		payment_amount.push(payment_amount1);
		bank_name.push(bank_name1);
		transaction_id.push(transaction_id1);
		payment_for.push(payment_for1);
		p_travel_type.push(p_travel_type1);
		bank_id_arr.push(bank_id1);
	}

	var pay_for_traveling = document.getElementById('chk_pay_for_traveling').checked;
	if (pay_for_traveling == true) {
		if (payment_mode2 == 'Cash') {
			bank_name2 = '';
			transaction_id2 = '';
			bank_id2 = '';
		}
		payment_date.push(payment_date2);
		payment_mode.push(payment_mode2);
		payment_amount.push(payment_amount2);
		bank_name.push(bank_name2);
		transaction_id.push(transaction_id2);
		payment_for.push(payment_for2);
		p_travel_type.push(p_travel_type2);
		bank_id_arr.push(bank_id2);
	}

	//**Form information
	var special_request = $('#txt_special_request').val();
	var summary_validate = validate_address('txt_special_request');
	if (!summary_validate) {
		error_msg_alert('More than 155 characters are not allowed.');
		return false;
	}
	var due_date1 = $('#txt_balance_due_date');
	var due_date = $(due_date1).val();
	var form_date = $('#txt_date').val();

	var hotel_sc = $('#hotel_sc').val();
	var hotel_markup = $('#hotel_markup').val();
	var hotel_taxes = $('#hotel_taxes').val();
	var hotel_markup_taxes = $('#hotel_markup_taxes').val();
	var hotel_tds = $('#hotel_tds').val();
	var roundoff = $('#roundoff').val();
	var total_discount = $('#txt_total_discount').val();
	var reflections = [];
	reflections.push({
		hotel_sc: hotel_sc,
		hotel_markup: hotel_markup,
		hotel_taxes: hotel_taxes,
		hotel_markup_taxes: hotel_markup_taxes,
		hotel_tds: hotel_tds
	});
	var bsmValues = [];
	bsmValues.push({
		"basic": $('#basic_show').find('span').text(),
		"service": $('#service_show').find('span').text(),
		"markup": $('#markup_show').find('span').text(),
		"discount": $('#discount_show').find('span').text()
	});
	//Validation for booking and payment date in login financial year
	var tour_payment = document.getElementById('chk_pay_for_tour').checked;
	var traveling_payment = document.getElementById('chk_pay_for_traveling').checked;
	var check_date1 = form_date;
	$.post(base_url + 'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function (data) {
		if (data !== 'valid') {
			error_msg_alert('The Booking date does not match between selected Financial year.');
			return false;
		}
		else {
			var test_payment_date1 = payment_date1;
			$.post(
				base_url + 'view/load_data/finance_date_validation.php',
				{ check_date: test_payment_date1 },
				function (data) {
					if (tour_payment == true) {
						if (data !== 'valid') {
							error_msg_alert('The Tour Payment date does not match between selected Financial year.');
							return false;
						}
					}
					var test_payment_date2 = payment_date2;
					$.post(
						base_url + 'view/load_data/finance_date_validation.php',
						{ check_date: test_payment_date2 },
						function (data) {
							if (traveling_payment == true) {
								if (data !== 'valid') {
									error_msg_alert(
										'The Travel Payment date does not match between selected Financial year.'
									);
									return false;
								}
							}
							if (traveling_payment == true || traveling_payment == false) {
								$('#btn_save_booking').button('loading');
								$('#vi_confirm_box').vi_confirm_box({
									callback: function (result) {
										if (result == 'yes') {
											if ($('#whatsapp_switch').val() == 'on')
												whatsapp_send(tour_id, customer_id, tour_group_id, emp_id, base_url);
											$('#btn_save_booking').prop('disabled', true);
											$('#btn_save_booking').val('Saving...');

											$.post(
												base_url +
												'controller/group_tour/booking/booking_details_complete_save.php',
												{
													unique_timestamp: unique_timestamp,
													tour_id: tour_id,
													tour_group_id: tour_group_id,
													emp_id: emp_id,
													taxation_type: taxation_type,
													customer_id: customer_id,
													'm_honorific[]': m_honorific,
													'm_first_name[]': m_first_name,
													'm_middle_name[]': m_middle_name,
													'm_last_name[]': m_last_name,
													'm_gender[]': m_gender,
													'm_birth_date[]': m_birth_date,
													'm_age[]': m_age,
													'm_adolescence[]': m_adolescence,
													m_passport_no: m_passport_no,
													m_passport_issue_date: m_passport_issue_date,
													m_passport_expiry_date: m_passport_expiry_date,
													m_email_id: m_email_id,
													m_mobile_no: m_mobile_no,
													m_address: m_address,
													m_handover_adnary: m_handover_adnary,
													m_handover_gift: m_handover_gift,
													relative_honorofic: relative_honorofic,
													relative_name: relative_name,
													relative_relation: relative_relation,
													relative_mobile_no: relative_mobile_no,
													single_bed_room: single_bed_room,
													double_bed_room: double_bed_room,
													extra_bed: extra_bed,
													on_floor: on_floor,
													train_expense: train_expense,
													train_service_charge: train_service_charge,
													train_taxation_id: train_taxation_id,
													train_service_tax: train_service_tax,
													train_service_tax_subtotal: train_service_tax_subtotal,
													total_train_expense: total_train_expense,
													plane_expense: plane_expense,
													plane_service_charge: plane_service_charge,
													plane_taxation_id: plane_taxation_id,
													plane_service_tax: plane_service_tax,
													plane_service_tax_subtotal: plane_service_tax_subtotal,
													total_plane_expense: total_plane_expense,
													total_travel_expense: total_travel_expense,
													train_ticket_path: train_ticket_path,
													plane_ticket_path: plane_ticket_path,
													'train_travel_date[]': train_travel_date,
													'train_from_location[]': train_from_location,
													'train_to_location[]': train_to_location,
													'train_train_no[]': train_train_no,
													'train_travel_class[]': train_travel_class,
													'train_travel_priority[]': train_travel_priority,
													'train_amount[]': train_amount,
													'train_seats[]': train_seats,
													'plane_travel_date[]': plane_travel_date,
													'plane_from_location[]': plane_from_location,
													'plane_to_location[]': plane_to_location,
													'plane_amount[]': plane_amount,
													'plane_seats[]': plane_seats,
													'plane_company[]': plane_company,
													from_city_id_arr: from_city_id_arr,
													to_city_id_arr: to_city_id_arr,
													visa_country_name: visa_country_name,
													visa_amount: visa_amount,
													visa_service_charge: visa_service_charge,
													visa_taxation_id: visa_taxation_id,
													visa_service_tax: visa_service_tax,
													visa_service_tax_subtotal: visa_service_tax_subtotal,
													visa_total_amount: visa_total_amount,
													insuarance_company_name: insuarance_company_name,
													insuarance_amount: insuarance_amount,
													insuarance_service_charge: insuarance_service_charge,
													insuarance_taxation_id: insuarance_taxation_id,
													insuarance_service_tax: insuarance_service_tax,
													insuarance_service_tax_subtotal: insuarance_service_tax_subtotal,
													insuarance_total_amount: insuarance_total_amount,
													adult_expense: adult_expense,
													child_with_bed: child_with_bed,
													child_without_bed: child_without_bed,
													infant_expense: infant_expense,
													tour_fee: tour_fee,
													repeater_discount: repeater_discount,
													adjustment_discount: adjustment_discount,
													tour_fee_subtotal_1: tour_fee_subtotal_1,
													tour_taxation_id: tour_taxation_id,
													service_tax_per: service_tax_per,
													service_tax: service_tax,
													tour_fee_subtotal_2: tour_fee_subtotal_2,
													net_total: net_total,
													'payment_date[]': payment_date,
													'payment_mode[]': payment_mode,
													'payment_amount[]': payment_amount,
													'bank_name[]': bank_name,
													'transaction_id[]': transaction_id,
													'payment_for[]': payment_for,
													'p_travel_type[]': p_travel_type,
													bank_id_arr: bank_id_arr,
													special_request: special_request,
													due_date: due_date,
													form_date: form_date,
													'arravl_arr[]': arravl_arr,
													cruise_dept_date_arr: cruise_dept_date_arr,
													cruise_arrival_date_arr: cruise_arrival_date_arr,
													route_arr: route_arr,
													cabin_arr: cabin_arr,
													sharing_arr: sharing_arr,
													cruise_seats_arr: cruise_seats_arr,
													cruise_amount_arr: cruise_amount_arr,
													cruise_ticket_path: cruise_ticket_path,
													cruise_expense: cruise_expense,
													cruise_service_charge: cruise_service_charge,
													cruise_taxation_id: cruise_taxation_id,
													cruise_service_tax: cruise_service_tax,
													cruise_service_tax_subtotal: cruise_service_tax_subtotal,
													total_cruise_expense: total_cruise_expense,
													branch_admin_id1: branch_admin_id1,
													financial_year_id: financial_year_id,
													reflections: reflections,
													basic_amount: basic_amount, roundoff: roundoff, bsmValues: bsmValues, total_discount: total_discount, credit_charges: credit_charges, credit_card_details: credit_card_details
												},
												function (data) {
													console.log(data);
													booking_save_message(data);
													$('#btn_save_booking').button('reset');
												}
											);
										}
										else {
											$('#btn_save_booking').button('reset');
										}
									}
								});
							}
						}
					);
				}
			);
		}
	});
}
function whatsapp_send(tour_id, customer_id, tour_group_id, emp_id) {
	$.post(
		$('#base_url').val() + 'controller/group_tour/booking/whatsapp_send.php',
		{ tour_id: tour_id, customer_id: customer_id, tour_group_id: tour_group_id, emp_id: emp_id },
		function (data) {
			window.open(data);
		}
	);
}

function booking_save_message(data) {
	$('#vi_confirm_box').vi_confirm_box({
		false_btn: false,
		message: data,
		true_btn_text: 'Ok',
		callback: function (data1) {
			if (data1 == 'yes') {
				window.location.href = '../index.php';
			}
		}
	});
}

/////////////***********Save Complete Booking Details End**********************************
