passport_fields_toggle();

$(function () {
	$('#frm_tab_4').validate({
		rules: {
			txt_hotel_expenses: { required: true },
			service_charge: { required: true },
			subtotal: { required: true },
			txt_tour_service_tax: { required: true },
			currency_code: { required: true },
			rue_cost: { required: true },
			txt_actual_tour_cost: { required: true }
		},
		submitHandler: function (form) {
			var base_url = $('#base_url').val();
			var booking_id = $('#booking_id').val();
			var customer_id = $('#customer_id1').val();
			var tour_name = $('#txt_package_tour_name').val();
			var tour_type = $('#tour_type').val();

			var tour_from_date = $('#txt_package_from_date');
			tour_from_date = $(tour_from_date).val();
			var tour_to_date = $('#txt_package_to_date');
			tour_to_date = $(tour_to_date).val();

			var total_tour_days = $('#txt_tour_total_days').val();
			var taxation_type = $('#taxation_type').val();

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
			var m_traveler_id = new Array();

			var table = document.getElementById('tbl_package_tour_member');
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
					var traveler_id = row.cells[13].childNodes[0].value;

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
					m_traveler_id.push(traveler_id);
				}
			}

			var contact_person_name = $('#txt_contact_person_name1').val();
			var email_id = $('#txt_m_email_id1').val();
			var mobile_no = $('#txt_m_mobile_no1').val();
			var address = $('#txt_m_address1').val();
			var country_name = $('#country_name1').val();
			var city = $('#txt_m_city1').val();
			var state = $('#txt_m_state1').val();

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
			var train_id = new Array();

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
					var travel_class1 = row.cells[8].childNodes[0].value;
					var train_travel_priority1 = row.cells[9].childNodes[0].value;
					var amount1 = row.cells[7].childNodes[0].value;
					var seats1 = row.cells[6].childNodes[0].value;

					if (row.cells[10]) {
						var train_id1 = row.cells[10].childNodes[0].value;
					}
					else {
						var train_id1 = '';
					}

					train_travel_date.push(travel_date1);
					train_from_location.push(from_location1);
					train_to_location.push(to_location1);
					train_train_no.push(train_no1);
					train_travel_class.push(travel_class1);
					train_travel_priority.push(train_travel_priority1);
					train_amount.push(amount1);
					train_seats.push(seats1);
					train_id.push(train_id1);
				}
			}

			//** Plane travel details starts here
			var plane_travel_date = new Array();
			var from_city_id_arr = new Array();
			var to_city_id_arr = new Array();
			var plane_from_location = new Array();
			var plane_to_location = new Array();
			var plane_train_no = new Array();
			var plane_amount = new Array();
			var plane_seats = new Array();
			var plane_company = new Array();
			var plane_id = new Array();
			var arrval_arr = new Array();

			var table = document.getElementById('tbl_plane_travel_details_dynamic_row');

			var rowCount = table.rows.length;

			for (var i = 0; i < rowCount; i++) {
				var row = table.rows[i];

				if (row.cells[0].childNodes[0].checked) {
					var travel_date_temp = row.cells[2].childNodes[0];
					var travel_date1 = $(travel_date_temp).val();

					var from_location1 = row.cells[3].childNodes[0].value;
					var to_location1 = row.cells[4].childNodes[0].value;
					var amount1 = row.cells[7].childNodes[0].value;
					var seats1 = row.cells[6].childNodes[0].value;
					var company1 = row.cells[5].childNodes[0].value;
					var arrval1 = row.cells[8].childNodes[0].value;
					var from_city_id1 = row.cells[9].childNodes[0].value;
					var to_city_id1 = row.cells[10].childNodes[0].value;

					if (row.cells[11]) {
						var plane_id1 = row.cells[11].childNodes[0].value;
					}
					else {
						var plane_id1 = '';
					}

					from_city_id_arr.push(from_city_id1);
					to_city_id_arr.push(to_city_id1);
					plane_travel_date.push(travel_date1);
					plane_from_location.push(from_location1);
					plane_to_location.push(to_location1);
					plane_amount.push(amount1);
					plane_seats.push(seats1);
					plane_company.push(company1);
					plane_id.push(plane_id1);
					arrval_arr.push(arrval1);
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
			var cruise_id_arr = new Array();

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
					if (row.cells[9]) {
						var c_entry_id = row.cells[9].childNodes[0].value;
					}
					else {
						var c_entry_id = '';
					}
					cruise_dept_date_arr.push(dept_date);
					cruise_arrival_date_arr.push(arrival_date);
					route_arr.push(route);
					cabin_arr.push(cabin);
					sharing_arr.push(sharing);
					cruise_seats_arr.push(seats1);
					cruise_amount_arr.push(amount1);
					cruise_id_arr.push(c_entry_id);
				}
			}

			//Hotel Info
			var city_id = new Array();
			var hotel_id = new Array();
			var hotel_from_date = new Array();
			var hotel_to_date = new Array();
			var hotel_rooms = new Array();
			var hotel_catagory = new Array();
			var room_type = new Array();
			var hotel_meal_plan = new Array();
			var confirmation_no = new Array();
			var hotel_acc_id = new Array();

			var table = document.getElementById('tbl_package_hotel_infomration');
			var rowCount = table.rows.length;

			for (var i = 0; i < rowCount; i++) {
				var row = table.rows[i];

				if (row.cells[0].childNodes[0].checked) {
					var city_id1 = row.cells[2].childNodes[0].value;
					var hotel_id1 = row.cells[3].childNodes[0].value;
					var hotel_from_date1 = row.cells[4].childNodes[0];
					var hotel_from_date1 = $(hotel_from_date1).val();
					var hotel_to_date1 = row.cells[5].childNodes[0];
					var hotel_to_date1 = $(hotel_to_date1).val();
					var hotel_rooms1 = row.cells[6].childNodes[0].value;
					var hotel_catagory1 = row.cells[7].childNodes[0].value;
					var room_type1 = row.cells[9].childNodes[0].value;
					var meal_plan1 = row.cells[8].childNodes[0].value;
					var confirmation_no1 = row.cells[10].childNodes[0].value;

					if (row.cells[11]) {
						var hotel_acc_id1 = row.cells[11].childNodes[0].value;
					}
					else {
						var hotel_acc_id1 = '';
					}
					city_id.push(city_id1);
					hotel_id.push(hotel_id1);
					hotel_from_date.push(hotel_from_date1);
					hotel_to_date.push(hotel_to_date1);
					hotel_rooms.push(hotel_rooms1);
					hotel_catagory.push(hotel_catagory1);
					room_type.push(room_type1);
					hotel_meal_plan.push(meal_plan1);
					confirmation_no.push(confirmation_no1);
					hotel_acc_id.push(hotel_acc_id1);
				}
			}

			//**Transport travel details starts here
			var transp_vehicle_arr = new Array();
			var transp_start_date = new Array();
			var trans_pickup_arr = new Array();
			var trans_drop_arr = new Array();
			var trans_pickuptype_arr = new Array();
			var trans_droptype_arr = new Array();
			var trans_count_arr = new Array();
			var trans_entry_id_arr = new Array();

			var table = document.getElementById('tbl_package_transport_infomration');
			var rowCount = table.rows.length;

			for (var i = 0; i < rowCount; i++) {
				var row = table.rows[i];
				if (row.cells[0].childNodes[0].checked) {

					var vehicle = row.cells[2].childNodes[0].value;
					var start_date = row.cells[3].childNodes[0].value;
					var pickup = row.cells[4].childNodes[0].value;
					var drop = row.cells[5].childNodes[0].value;
					var pickup_type = $("option:selected", $("#" + row.cells[4].childNodes[0].id)).parent().attr('value');
					var drop_type = $("option:selected", $("#" + row.cells[5].childNodes[0].id)).parent().attr('value');
					var vcount = row.cells[6].childNodes[0].value;

					if (row.cells[7]) {
						var trans_entry_id = row.cells[7].childNodes[0].value;
					}
					else {
						var trans_entry_id = '';
					}

					transp_vehicle_arr.push(vehicle);
					transp_start_date.push(start_date);
					trans_pickuptype_arr.push(pickup_type);
					trans_pickup_arr.push(pickup);
					trans_droptype_arr.push(drop_type);
					trans_drop_arr.push(drop);
					trans_count_arr.push(vcount);
					trans_entry_id_arr.push(trans_entry_id);
				}
			}
			//**Activity travel details starts here
			var exc_date_arr = new Array();
			var exc_city_arr = new Array();
			var exc_name_arr = new Array();
			var transfer_arr = new Array();
			var exc_entry_id_arr = new Array();

			var table = document.getElementById('tbl_package_exc_infomration');
			var rowCount = table.rows.length;

			for (var i = 0; i < rowCount; i++) {
				var row = table.rows[i];
				if (row.cells[0].childNodes[0].checked) {
					var exc_date = row.cells[2].childNodes[0].value;
					var exc_city = row.cells[3].childNodes[0].value;
					var exc_name = row.cells[4].childNodes[0].value;
					var transfer_option = row.cells[5].childNodes[0].value;


					if (row.cells[6]) {
						var exc_entry_id = row.cells[6].childNodes[0].value;
					}
					else {
						var exc_entry_id = '';
					}

					exc_date_arr.push(exc_date);
					exc_city_arr.push(exc_city);
					exc_name_arr.push(exc_name);
					transfer_arr.push(transfer_option)
					exc_entry_id_arr.push(exc_entry_id);
				}
			}

			//Itinerary Table
			var quotation_id = $('#quotation_id1').val();
			if (quotation_id == 0) {
				var special_attraction_arr = new Array();
				var day_program_arr = new Array();
				var stay_arr = new Array();
				var meal_plan_arr = new Array();
				var iti_entry_id_arr = new Array();

				var table = document.getElementById('package_program_list');
				var rowCount = table.rows.length;

				for (var i = 0; i < rowCount; i++) {
					var row = table.rows[i];
					if (row.cells[0].childNodes[0].checked) {
						var special_attraction = row.cells[2].childNodes[0].value;
						var day_program = row.cells[3].childNodes[0].value;
						var stay = row.cells[4].childNodes[0].value;
						var meal_plan = row.cells[5].childNodes[0].value;

						if (row.cells[7]) {
							var iti_entry_id = row.cells[7].childNodes[0].value;
						}
						else {
							var iti_entry_id = '';
						}
						special_attraction_arr.push(special_attraction);
						day_program_arr.push(day_program);
						stay_arr.push(stay);
						meal_plan_arr.push(meal_plan);
						iti_entry_id_arr.push(iti_entry_id);
					}
				}
			}

			var incl = $('#incl').val();
			var excl = $('#excl').val();

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

			//**Tour Costing
			var total_hotel_expense = $('#txt_hotel_expenses').val();
			var service_charge = $('#service_charge').val();
			var subtotal = $('#subtotal').val();

			var tour_taxation_id = $('#tour_taxation_id').val();
			var tour_service_tax = $('#txt_tour_service_tax').val();
			var tour_service_tax_subtotal = $('#tour_service_tax_subtotal').val();

			// if(parseFloat(tour_taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; }

			var currency_code = $('#currency_code').val();
			var rue_cost = $('#rue_cost').val();
			var subtotal_with_rue = $('#subtotal_with_rue').val();
			var net_total = $('#txt_actual_tour_cost1').val();
			var actual_tour_cost = $('#txt_actual_tour_cost').val();
			var basic_amount = $('#total_basic_amt').val();

			//**Form information
			var special_request = $('#txt_special_request').val();
			var summary_validate = validate_address('txt_special_request');
			if (!summary_validate) {
				error_msg_alert('More than 155 characters are not allowed.');
				return false;
			}
			var booking_date = $('#booking_date').val();
			var hotel_sc = $('#hotel_sc').val();
			var hotel_markup = $('#hotel_markup').val();
			var hotel_taxes = $('#hotel_taxes').val();
			var hotel_markup_taxes = $('#hotel_markup_taxes').val();
			var hotel_tds = $('#hotel_tds').val();

			var roundoff = $('#roundoff').val();
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
				"discount": $('#discount_show1').find('span').text()
			});
			$('#vi_confirm_box').vi_confirm_box({
				callback: function (data1) {
					if (data1 == 'yes') {
						$('#btn_package_tour_master_update').button('loading');

						$.post(
							base_url + 'controller/package_tour/booking/package_tour_booking_master_update_c.php',
							{
								booking_id: booking_id,
								customer_id: customer_id,
								tour_name: tour_name,
								tour_type: tour_type,
								tour_from_date: tour_from_date,
								tour_to_date: tour_to_date,
								total_tour_days: total_tour_days,
								taxation_type: taxation_type,
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
								'm_traveler_id[]': m_traveler_id,
								contact_person_name: contact_person_name,
								email_id: email_id,
								mobile_no: mobile_no,
								address: address,
								country_name: country_name,
								city: city,
								state: state,
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
								'train_id[]': train_id,
								'plane_travel_date[]': plane_travel_date,
								'plane_from_location[]': plane_from_location,
								'plane_to_location[]': plane_to_location,
								'plane_amount[]': plane_amount,
								'plane_seats[]': plane_seats,
								'plane_company[]': plane_company,
								'plane_id[]': plane_id,
								from_city_id_arr: from_city_id_arr,
								to_city_id_arr: to_city_id_arr,
								'city_id[]': city_id,
								'hotel_id[]': hotel_id,
								'hotel_from_date[]': hotel_from_date,
								'hotel_to_date[]': hotel_to_date,
								'hotel_rooms[]': hotel_rooms,
								'hotel_catagory[]': hotel_catagory,
								'room_type[]': room_type,
								'hotel_meal_plan[]': hotel_meal_plan,
								transp_vehicle_arr: transp_vehicle_arr,
								transp_start_date: transp_start_date,
								trans_pickuptype_arr: trans_pickuptype_arr,
								trans_pickup_arr: trans_pickup_arr,
								trans_droptype_arr: trans_droptype_arr,
								trans_drop_arr: trans_drop_arr,
								trans_count_arr: trans_count_arr,
								trans_entry_id_arr: trans_entry_id_arr,
								exc_city_arr: exc_city_arr,
								exc_name_arr: exc_name_arr,
								exc_date_arr: exc_date_arr,
								transfer_arr: transfer_arr,
								exc_entry_id_arr: exc_entry_id_arr,
								confirmation_no: confirmation_no,
								'hotel_acc_id[]': hotel_acc_id,
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
								total_hotel_expense: total_hotel_expense,
								service_charge: service_charge,
								subtotal: subtotal,
								tour_taxation_id: tour_taxation_id,
								tour_service_tax: tour_service_tax,
								tour_service_tax_subtotal: tour_service_tax_subtotal,
								currency_code: currency_code,
								rue_cost: rue_cost,
								subtotal_with_rue: subtotal_with_rue,
								actual_tour_cost: actual_tour_cost,
								special_request: special_request,
								booking_date: booking_date,
								'arrval_arr[]': arrval_arr,
								cruise_dept_date_arr: cruise_dept_date_arr,
								cruise_arrival_date_arr: cruise_arrival_date_arr,
								route_arr: route_arr,
								cabin_arr: cabin_arr,
								sharing_arr: sharing_arr,
								cruise_seats_arr: cruise_seats_arr,
								cruise_amount_arr: cruise_amount_arr,
								cruise_id_arr: cruise_id_arr,
								cruise_ticket_path: cruise_ticket_path,
								cruise_expense: cruise_expense,
								cruise_service_charge: cruise_service_charge,
								cruise_taxation_id: cruise_taxation_id,
								cruise_service_tax: cruise_service_tax,
								cruise_service_tax_subtotal: cruise_service_tax_subtotal,
								total_cruise_expense: total_cruise_expense,
								incl: incl,
								excl: excl,
								quotation_id: quotation_id,
								special_attraction_arr: special_attraction_arr,
								day_program_arr: day_program_arr,
								stay_arr: stay_arr,
								meal_plan_arr: meal_plan_arr,
								iti_entry_id_arr: iti_entry_id_arr,
								basic_amount: basic_amount,
								reflections: reflections, bsmValues: bsmValues, roundoff: roundoff, net_total: net_total
							},
							function (data) {
								console.log(data);
								booking_save_message(data);
								$('#btn_package_tour_master_update').button('reset');
							}
						);
					}
				}
			});
		}
	});
});

function booking_save_message(data) {
	var base_url = $('#base_url').val();
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
