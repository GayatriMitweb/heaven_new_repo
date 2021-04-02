///////Train amount calculate start/////////////////////////////////////////////////
function calculate_train_expense(id, start = false) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var amt = row.cells[7].childNodes[0].value;
			if (!isNaN(amt)) {
				if (amt == 0) {
					amt = 0;
				}
				total_expense = parseFloat(total_expense) + parseFloat(amt);
			}
		}
	}
	$('#txt_train_expense').val(total_expense.toFixed(2));

	calculate_total_train_expense(start);
}
function calculate_total_train_expense(start = false) {
	var train_expense = $('#txt_train_expense').val();
	var service_charge = $('#txt_train_service_charge').val();
	var train_service_tax = $('#train_service_tax').val();

	if (train_expense == '') {
		train_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (train_service_tax == '') {
		train_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(train_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#train_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(train_expense) + parseFloat(service_tax_subtotal);

	$('#txt_train_total_expense').val(total_expense.toFixed(2));

	calculate_total_travel_amount(start);
}
///////Train amount calculate end/////////////////////////////////////////////////

///////Plane amount calculate start///////////////////////////////////////////////
function calculate_plane_expense(id, start = false) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;
	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var value1 = row.cells[7].childNodes[0].value;

			if (!isNaN(value1) && value1 != '') {
				total_expense = parseFloat(total_expense) + parseFloat(value1);
			}
		}
	}
	$('#txt_plane_expense').val(total_expense.toFixed(2));

	calculate_total_plane_expense(start);
}
function calculate_total_plane_expense(start = false) {
	var plane_expense = $('#txt_plane_expense').val();
	var service_charge = $('#txt_plane_service_charge').val();
	var plane_service_tax = $('#plane_service_tax').val();

	if (plane_expense == '') {
		plane_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (plane_service_tax == '') {
		plane_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(plane_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#plane_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(plane_expense) + parseFloat(service_tax_subtotal);

	$('#txt_plane_total_expense').val(parseFloat(total_expense).toFixed(2));

	calculate_total_travel_amount(start);
}
///////Plane amount calculate end///////////////////////////////////////////////

///////Cruise amount calculate start/////////////////////////////////////////////////
function calculate_cruise_expense(id, start = false) {
	var table = document.getElementById(id);
	var rowCount = table.rows.length;
	var total_expense = 0;

	for (var i = 0; i < rowCount; i++) {
		var row = table.rows[i];
		if (row.cells[0].childNodes[0].checked == true) {
			var amt = row.cells[8].childNodes[0].value;
			if (!isNaN(amt)) {
				if (amt == 0) {
					amt = 0;
				}
				total_expense = parseFloat(total_expense) + parseFloat(amt);
			}
		}
	}
	$('#txt_cruise_expense').val(total_expense.toFixed(2));

	calculate_total_cruise_expense(start);
}
function calculate_total_cruise_expense(start = false) {
	var cruise_expense = $('#txt_cruise_expense').val();
	var service_charge = $('#txt_cruise_service_charge').val();
	var cruise_service_tax = $('#cruise_service_tax').val();

	if (cruise_expense == '') {
		cruise_expense = 0;
	}
	if (service_charge == '') {
		service_charge = 0;
	}
	if (cruise_service_tax == '') {
		cruise_service_tax = 0;
	}

	var service_tax_per = parseFloat(service_charge) / 100 * parseFloat(cruise_service_tax);
	service_tax_per = Math.round(service_tax_per);
	$('#cruise_service_tax_subtotal').val(service_tax_per.toFixed(2));

	var service_tax_subtotal = parseFloat(service_charge) + parseFloat(service_tax_per);

	var total_expense = parseFloat(cruise_expense) + parseFloat(service_tax_subtotal);

	$('#txt_cruise_total_expense').val(total_expense.toFixed(2));

	calculate_total_travel_amount(start);
}
///////Cruise amount calculate end/////////////////////////////////////////////////

///////Total travel amount start///////////////////////////////////////////////
function calculate_total_travel_amount(start = false) {
	var total_train_expense = $('#txt_train_total_expense').val();
	if (total_train_expense == '') {
		total_train_expense = 0;
	}

	var total_plane_expense = $('#txt_plane_total_expense').val();
	if (total_plane_expense == '') {
		total_plane_expense = 0;
	}

	var total_cruise_expense = $('#txt_cruise_total_expense').val();
	if (total_cruise_expense == '') {
		total_cruise_expense = 0;
	}

	var total_travel_expense =
		parseFloat(total_train_expense) + parseFloat(total_plane_expense) + parseFloat(total_cruise_expense);
	$('#txt_travel_total_expense').val(total_travel_expense.toFixed(2));
	$('#txt_travel_total_expense1').val(total_travel_expense.toFixed(2));
	if (!start) calculate_tour_cost('');
}
///////Total travel amount end///////////////////////////////////////////////
