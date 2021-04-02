$('#quotation_date').datetimepicker({ timepicker: false, format: 'd-m-Y' });

function quotation_cost_calculate () {
	var quotation_cost = 0;
	var subtotal = $('#subtotal').val();
	var markup_cost = $('#markup_cost').val();
	var service_tax_markup = $('#service_tax_markup').val();
	var service_tax_subtotal = $('#service_tax_subtotal').val();
	var service_charge = $('#service_charge').val();
	var permit = $('#permit').val();
	var toll_parking = $('#toll_parking').val();
	var driver_allowance = $('#driver_allowance').val();
	var state_entry = $('#state_entry').val();
	var other_charges = $('#other_charges').val();

	var service_tax_amount = 0;
    if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

      var service_tax_subtotal1 = service_tax_subtotal.split(",");
      for(var i=0;i<service_tax_subtotal1.length;i++){
        var service_tax = service_tax_subtotal1[i].split(':');
        service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
      }
	}
	var markupservice_tax_amount = 0;
    if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
      var service_tax_markup1 = service_tax_markup.split(",");
      for(var i=0;i<service_tax_markup1.length;i++){
        var service_tax = service_tax_markup1[i].split(':');
        markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
      }
	}

	if (subtotal == '') {
		subtotal = 0;
	}
	// if (markup_cost == '') {
	// 	markup_cost = 0;
	// }
	// if (markup_cost_subtotal == '') {
	// 	markup_cost_subtotal = 0;
	// }
	// if (service_tax == '') {
	// 	service_tax = 0;
	// }
	if (permit == '') {
		permit = 0;
	}
	if (toll_parking == '') {
		toll_parking = 0;
	}
	if (driver_allowance == '') {
		driver_allowance = 0;
	}
	if (state_entry == '') {
		state_entry = 0;
	}
	if (other_charges == '') {
		other_charges = 0;
	}

	if (markup_cost == '') {
		markup_cost = 0;
	}
	// if (parseFloat(markup_cost) == 0) {
	// 	var t_subtotal = parseFloat(subtotal) + parseFloat(markup_cost_subtotal);
	// }
	// else {
	// 	markup_cost_subtotal = parseFloat(subtotal) / 100 * parseFloat(markup_cost);
	// 	var t_subtotal = parseFloat(subtotal) + parseFloat(markup_cost_subtotal);
	// }

	// var service_tax_amount = parseFloat(t_subtotal) / 100 * parseFloat(service_tax);
	subtotal = ($('#basic_show').html() == '&nbsp;') ? subtotal : parseFloat($('#basic_show').text().split(' : ')[1]);
	service_charge = ($('#service_show').html() == '&nbsp;') ? service_charge : parseFloat($('#service_show').text().split(' : ')[1]);
	markup_cost = ($('#markup_show').html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show').text().split(' : ')[1]);
	
	total_tour_cost =
		parseFloat(subtotal) +
		parseFloat(markupservice_tax_amount) +
		parseFloat(permit) +
		parseFloat(toll_parking) +
		parseFloat(driver_allowance) +
		parseFloat(state_entry) +
		parseFloat(other_charges) +
		parseFloat(service_tax_amount)+
		parseFloat(markup_cost)+
		parseFloat(service_charge);
	quotation_cost = parseFloat(total_tour_cost.toFixed(2));
	var roundoff = Math.round(quotation_cost)-quotation_cost;
	$('#roundoff').val(roundoff.toFixed(2));
	
	$('#total_tour_cost').val(parseFloat(quotation_cost.toFixed(2)) + parseFloat(roundoff.toFixed(2)));
}

function get_enquiry_details (offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	$.ajax({
		type     : 'post',
		url      : base_url + 'view/package_booking/quotation/car_flight/car_rental/get_enquiry_details.php',
		dataType : 'json',
		data     : { enquiry_id: enquiry_id },
		success  : function (result) {
			$('#customer_name' + offset).val(result.name);
			$('#email_id' + offset).val(result.email_id);
			$('#mobile_no' + offset).val(result.mobile_no);
			$('#total_pax' + offset).val(result.total_pax);
			$('#days_of_traveling' + offset).val(result.days_of_traveling);
			$('#traveling_date' + offset).val(result.traveling_date);
			$('#vehicle_name' + offset).val(result.vehicle_type);
			$('#travel_type' + offset).val(result.travel_type);
			// $('#local_places_to_visit' + offset).val(result.places_to_visit);
			reflect_feilds();
			get_car_cost();
			get_capacity();
		},
		error    : function (result) {
			// alert(result);
			console.log(result.responseText);
		}
	});
	get_basic_amount()
}
function get_car_cost(){
	var travel_type = $('#travel_type').val();
	var vehicle_name = $('#vehicle_name').val();
	var places_to_visit = $('#places_to_visit').val();
	
	var base_url = $('#base_url').val();
	$.ajax({
		type     : 'post',
		url      : base_url + 'view/package_booking/quotation/car_flight/car_rental/get_car_cost.php',
		dataType : 'json',
		data     : { travel_type: travel_type, vehicle_name: vehicle_name,places_to_visit:places_to_visit },
		success  : function (result) {
			//var result = JSON.parse(result);
			console.log(result[0].total_hrs);

			$('#total_hr').val(result[0].total_hrs);
			$('#total_km').val(result[0].total_km);
			$('#extra_hr_cost').val(result[0].extra_hrs_rate);
			$('#extra_km_cost').val(result[0].extra_km_rate);
			$('#route').val(result[0].route);
			//$('#days_of_traveling').val(result[0].total_days);
			$('#total_max_km').val(result[0].total_max_km);
			$('#rate').val(result[0].rate);
			$('#driver_allowance').val(result[0].driver_allowance);
			$('#permit').val(result[0].permit_charges);
			$('#toll_parking').val(result[0].toll_parking);
			$('#state_entry').val(result[0].state_entry_pass);
			$('#other_charges').val(result[0].other_charges);
		},
		error    : function (result) {
			// alert(result);
			//console.log(result.responseText);
		}
	});
}

function reflect_feilds() {
	var type = $('#travel_type').val();
	if (type == 'Local') {
		$('#total_hr,#total_km,#local_places_to_visit').show();
		$('#total_max_km,#driver_allowance,#permit,#toll_parking,#state_entry,#other_charges,#places_to_visit,#traveling_date').hide();
	}
	if (type == 'Outstation') {
		$('#total_hr,#total_km,#local_places_to_visit').hide();
		$('#total_max_km,#driver_allowance,#permit,#toll_parking,#state_entry,#other_charges,#places_to_visit,#traveling_date').show();
	}
}

function get_flight_enquiry_details (offset = '') {
	var enquiry_id = $('#enquiry_id' + offset).val();
	var base_url = $('#base_url').val();
	$.ajax({
		type     : 'GET',
		url      : base_url + 'view/package_booking/quotation/car_flight/flight/get_enquiry_details.php',
		dataType : 'json',
		data     : { enquiry_id: enquiry_id },
		success  : function (result) {
			$('#customer_name' + offset).val(result.name);
			$('#email_id' + offset).val(result.email_id);
			$('#mobile_no' + offset).val(result.mobile_no);
			var enquiry_content = JSON.parse(result.enquiry_content);
			console.log(enquiry_content.length);
			var count_td = 1;
			var table = document.getElementById('tbl_flight_quotation_dynamic_plane');
			// $('#tbl_flight_quotation_dynamic_plane').empty()
			$("#tbl_flight_quotation_dynamic_plane").find("tr:gt(0)").remove();
			$.each(enquiry_content, function( index, value){
				
				var rows = table.rows;
				var table_offset = rows[rows.length - 1].cells[0].childNodes[0].getAttribute('id').split('-')[1];
				$('#from_sector-'+table_offset).val(value.sector_from);
				$('#to_sector-'+table_offset).val(value.sector_to);
				$('#plane_class-'+table_offset).val(value.class_type);
				$('#airline_name-'+table_offset).val(value.preffered_airline);
				$('#airline_name-'+table_offset).trigger('change');
				$('#txt_dapart-'+table_offset).val(value.travel_datetime);
				$('#adult-'+table_offset).val(value.total_adults_flight);
				$('#child-'+table_offset).val(value.total_child_flight);
				$('#infant-'+table_offset).val(value.total_infant_flight);
				$('#from_city-'+table_offset).val(value.from_city_id_flight);
				$('#to_city-'+table_offset).val(value.to_city_id_flight);
				if(enquiry_content.length > count_td++)
					addRow('tbl_flight_quotation_dynamic_plane');
			});
			// $('#travel_datetime' + offset).val(result.travel_datetime);
			// $('#sector_from' + offset).val(result.sector_from);
			// $('#sector_to' + offset).val(result.sector_to);
			// $('#preffered_airline' + offset).val(result.preffered_airline);
			// $('#class_type' + offset).val(result.class_type);
			// $('#trip_type' + offset).val(result.trip_type);
			// $('#total_seats' + offset).val(result.total_seats);
			// $('#from_city-1').val(result.from_city_name.city_id);
			// $('#from_city-1').trigger('change');
			// $('#to_city-1').val(result.to_city_name.city_id);
			// $('#to_city-1').trigger('change');
			// $('#handler').on('click', function () {
			// 	$('#plane_from_location-1').val(result.sector_from_added);
			// 	$('#plane_from_location-1').trigger('change');
			// 	$('#plane_to_location-1').val(result.sector_to_added);
			// 	$('#plane_to_location-1').trigger('change');
			// });
			// $('#plane_class-1').val(result.class_type);
			// $('#plane_class-1').trigger('change');
			// $('#airline_name-1').val(result.preffered_airline_id);
			// $('#airline_name-1').trigger('change');
		},
		error    : function (result) {
			console.log(result.responseText);
		}
	});
}

function flight_quotation_cost_calculate (offset = '') {
	var quotation_cost = 0;
	var subtotal = $('#subtotal' + offset).val();
	var service_charge = $('#service_charge' + offset).val();
	var service_tax_subtotal = $('#service_tax' + offset).val();
	var markup_cost = $('#markup_cost' + offset).val();
	var service_tax_markup = $('#markup_cost_subtotal' + offset).val();

	if (subtotal == '') {
		subtotal = 0;
	}
	if (markup_cost == '') {
		markup_cost = 0;
	}
	if (service_charge == ''){
		service_charge = 0;
	}

	var service_tax_amount = 0;
    if(parseFloat(service_tax_subtotal) !== 0.00 && (service_tax_subtotal) !== ''){

      var service_tax_subtotal1 = service_tax_subtotal.split(",");
      for(var i=0;i<service_tax_subtotal1.length;i++){
        var service_tax = service_tax_subtotal1[i].split(':');
        service_tax_amount = parseFloat(service_tax_amount) + parseFloat(service_tax[2]);
      }
	}
	var markupservice_tax_amount = 0;
    if(parseFloat(service_tax_markup) !== 0.00 && (service_tax_markup) !== ""){
      var service_tax_markup1 = service_tax_markup.split(",");
      for(var i=0;i<service_tax_markup1.length;i++){
        var service_tax = service_tax_markup1[i].split(':');
        markupservice_tax_amount = parseFloat(markupservice_tax_amount) + parseFloat(service_tax[2]);
      }
	}

	subtotal = ($('#basic_show'+offset).html() == '&nbsp;') ? subtotal : parseFloat($('#basic_show'+offset).text().split(' : ')[1]);
	service_charge = ($('#service_show'+offset).html() == '&nbsp;') ? service_charge : parseFloat($('#service_show'+offset).text().split(' : ')[1]);
	markup_cost = ($('#markup_show'+offset).html() == '&nbsp;') ? markup_cost : parseFloat($('#markup_show'+offset).text().split(' : ')[1]);
	
	total_tour_cost = parseFloat(subtotal) + parseFloat(service_charge) + parseFloat(service_tax_amount) + parseFloat(markup_cost) + parseFloat(markupservice_tax_amount);

	var roundoff = Math.round(total_tour_cost)-total_tour_cost;
	$('#roundoff'+offset).val(roundoff.toFixed(2));

	quotation_cost = parseFloat(total_tour_cost) + parseFloat(roundoff);

	$('#total_tour_cost' + offset).val(quotation_cost.toFixed(2));
}
