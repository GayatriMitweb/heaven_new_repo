var g_validate_status = true;

function get_date() {
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1; //January is 0!

	var yyyy = today.getFullYear();
	if (dd < 10) {
		dd = '0' + dd;
	}
	if (mm < 10) {
		mm = '0' + mm;
	}
	var today = dd + '-' + mm + '-' + yyyy;

	return today;
}
function validate_recover_fields(id) {
	$('#' + id).css({ border: '1px solid #ddd' });
	return true;
}

function validate_empty_fields(id) {
	if ($('#' + id).val() == '') {
		$('#' + id).css({ border: '1px solid red' });
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$('#'+id).next().hide();
		return true;
	}
}

function validate_empty_select(id) {
	if ($('#' + id).val() == '') {
		$('#' + id).css({ border: '1px solid red' });
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$('#'+id).next().hide();
		return true;
	}
}

function validate_empty_date(id) {
	var data1 = $('#' + id);
	var data = $(data1).val();

	if (data == '') {
		$('#' + id).css({ border: '1px solid red' });
		//$('#'+id).next().hide();
		//$('#'+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$('#'+id).next().hide();
		return true;
	}
}

function validate_empty_radio(name) {
	var val = $('input[name=' + name + ']:checked').val();

	if (val == undefined) {
		//$( "input[name="+name+"]" ).parent( "div" ).next().hide();
		//$( "input[name="+name+"]" ).parent( "div" ).css( "border", "1px solid red" ).after("<span style='border:0px; color:red' class='form-control text-right'>*This field is required.</span>");
		$('input[name=' + name + ']').parent('div').css('border', '1px solid red');
		g_validate_status = false;
		return false;
	}
	else {
		$('input[name=' + name + ']').parent('div').css('border', '0');
		//$( "input[name="+name+"]" ).parent( "div" ).next().hide();
		return true;
	}
}

function validate_empty_container(id) {
	var data1 = document.getElementById(id);
	var data = new Array();
	for (i = 0; i < data1.options.length; i++) {
		data.push(data1.options[i].value);
	}

	if (data == 0) {
		$('#' + id).css({ border: '1px solid red' });
		//$( '#'+id ).parent( "div" ).next().hide();
		//$( '#'+id ).parent( "div" ).css( "border", "1px solid red; float:right" ).after("<span style='border:0px; color:red' class='form-control text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$( '#'+id ).parent( "div" ).css( "border", "0" );
		//$( '#'+id ).parent( "div" ).next().hide();
		return true;
	}
}

function validate_dynamic_empty_fields(id) {
	if (id.value == '') {
		id.style.border = '1px solid red';
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		id.style.border = '1px solid #ddd';
		//$('#'+id).next().hide();
		return true;
	}
}

function validate_dynamic_empty_select(id) {
	if (id.value == '') {
		id.style.border = '1px solid red';
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		id.style.border = '1px solid #ddd';
		//$('#'+id).next().hide();
		return true;
	}
}

function validate_dynamic_empty_date(id) {
	var data = $(id).val();

	if (data == '') {
		id.style.border = '1px solid red';
		//$('#'+id).next().hide();
		//$('#'+id).after("<span style='border:0px; color:red; float:right' class='text-right'>*This field is required.</span>");
		g_validate_status = false;
		return false;
	}
	else {
		id.style.border = '1px solid #ddd';
		//$('#'+id).next().hide();
		return true;
	}
}

//Validation for date in login financial year
function check_valid_date(date) {
	var base_url = $('#base_url').val();
	var check_date1 = $('#' + date).val();

	$.post(base_url + 'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function (data) {
		if (data !== 'valid' && data !== '') {
			error_msg_alert(data);
			return false;
		}
		else {
			return true;
		}
	});
}

//check future date
function checkDate(id) {
	var date = document.getElementById(id).value;

	if (date == '') {
		alert('Please enter the Date..!!');
		return false;
	}
	else if (!date.match(/^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)) {
		alert('date format is wrong');
		return false;
	}

	var today = new Date();
	date = Date.parse(date);
	if (today <= date) {
		alert('Current or future date is not allowed.');
		return false;
	}
}
// Validation for Issue date
function validate_issueDate(from, to) {
	var from_date = $('#' + from).val();
	var to_date = $('#' + to).val();
	var parts = from_date.split('-');
	var date = new Date();
	var new_month = parseInt(parts[1]) - 1;
	date.setFullYear(parts[2]);
	date.setDate(parts[0]);
	date.setMonth(new_month);

	var parts1 = to_date.split('-');
	var date1 = new Date();
	var new_month1 = parseInt(parts1[1]) - 1;
	date1.setFullYear(parts1[2]);
	date1.setDate(parts1[0]);
	date1.setMonth(new_month1);

	var one_day = 1000 * 60 * 60 * 24;

	var from_date_ms = date.getTime();
	var to_date_ms = date1.getTime();

	if (from_date_ms > to_date_ms) {
		error_msg_alert(" Date should be greater than passport issue date");
		$('#' + to).css({ 'border': '1px solid red' });
		document.getElementById(to).value = "";
		$('#' + to).focus();
		g_validate_status = false;
		return false;
	}
}
/*function mobile_validate(id)
{
  var pass1 = document.getElementById(id).value; 

  if(isNaN(pass1))
  {   
	error_msg_alert('Please enter valid mobile number');
	$('#'+id).css({'border':'1px solid red'}); 
	//$('#'+id).next().hide();   
	//$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>Enter number only in mobile number!</span>");
	document.getElementById(id).value="";
	$('#'+id).focus();
	g_validate_status = false;
	return false;
  }
  /*else if(pass1.length!=10)
  {  
	 error_msg_alert('Please enter valid mobile number');
	 $('#'+id).css({'border':'1px solid red'}); 
	 //$('#'+id).next().hide();   
	 //$("#"+id).after("<span style='border:0px; color:red; float:right' class='text-right'>Lenght of mobile no should be 10 digits!</span>");  
	 document.getElementById(id).value="";
	 $('#'+id).focus();
	 g_validate_status = false;
	 return false;
  }*/
/*else
  {
	$('#'+id).css({'border':'1px solid #ddd'});
	 //$('#'+id).next().hide();
	 return true;
  }  

  return true;
}*/

function land_line_validate(id) {
	var pass1 = document.getElementById(id).value;

	if (isNaN(pass1)) {
		$('#' + id).css({ border: '1px solid red' });
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right; background: initial;' class='form-control text-right'>Enter number only in Land line number!</span>");
		document.getElementById(id).value = '';
		g_validate_status = false;
		return false;
	}
	else {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$('#'+id).next().hide();
		return true;
	}
}

function number_validate(id) {
	var pass1 = document.getElementById(id).value;

	if (!isNaN(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		//$('#'+id).next().hide();
		return true;
	}
	else {
		error_msg_alert('Please enter valid number');
		$('#' + id).css({ border: '1px solid red' });
		//$('#'+id).next().hide();
		//$("#"+id).after("<span style='border:0px; color:red; float:right; background: initial;' class='form-control text-right'>Enter Number Only!</span>");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

function name_validate(id) {
	var pass1 = document.getElementById(id).value;

	if (/^[A-z ]+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid name');
		$('#' + id).css({ border: '1px solid red' });
		//alert("Use only letter in name!");
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

function validate_email(id) {
	var pass1 = document.getElementById(id).value;

	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(pass1)) {
		$('#' + id).css({ border: '1px solid #ddd' });
		return true;
	}
	else {
		error_msg_alert('Please enter valid Email Id');
		$('#' + id).css({ border: '1px solid red' });
		//alert("You have entered an invalid email address!");
		//document.getElementById("display_data").innerHTML="You have entered an invalid email address.";
		document.getElementById(id).value = '';
		$('#' + id).focus();
		g_validate_status = false;
		return false;
	}
}

count = 1;

function calculate_age_member(id) {
	var dateString1 = $('#' + id).val();
	var get_new = dateString1.split('-');

	var day = get_new[0];
	var month = get_new[1];
	var year = get_new[2];

	var dateString = month + '/' + day + '/' + year;

	tagText = dateString.replace(/-/g, '/');
	var today = new Date();
	var birthDate = new Date(tagText);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age--;
	}

	var count = id.substr(3);
	var id1 = 'txt_age' + count;

	if (age < 1) {
		//document.getElementById("id").value="";
		//alert("Age should be greater than 0.");
	}
	document.getElementById(id1).value = age;
	if (age <= 5 && age > 0) {
		document.getElementById('txt_adolescence' + count).value = 'I';
	}
	if (age > 5 && age <= 12) {
		document.getElementById('txt_adolescence' + count).value = 'C';
	}
	if (age > 12) {
		document.getElementById('txt_adolescence' + count).value = 'A';
	}
}

/// **** Dynamic Table Entries ***********************//////////////////////////////

function dynamic_date(id) {
	id = id.trim();
	jQuery('#' + id).datetimepicker({ timepicker: false, format: 'd-m-Y' });
	jQuery('#' + id).addClass('form-control');
}
function dynamic_birthdate(id) {
	id = id.trim();
	var date = new Date();
	var yest = date.setDate(date.getDate() - 1);
	jQuery('#' + id).datetimepicker({ timepicker: false, maxDate: yest, format: 'd-m-Y' });
	jQuery('#' + id).addClass('form-control');
}
function dynamic_datetime(id) {
	id = id.trim();
	jQuery('#' + id).datetimepicker({ format: 'd-m-Y H:i:s' });
	jQuery('#' + id).addClass('form-control');
}

function dynamic_city(id) {
	id = id.trim();
	$(document).ready(function () {
		$('#' + id).select2();
	});
}

function foo(tableID, quot_table_id,rowCounts) {
	if (typeof foo.counter == 'undefined') {
		foo.counter = 1;
	}
	foo.counter++;
	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	var sr_no_count = 0;

	for (var i = 0; i < rowCount; i++) {
		sr_no_count++;
		var row = table.rows[i];
		//document.write(foo.counter+"<br />");
		row.cells[1].childNodes[0].value = sr_no_count;
	}
	//row.cells[1].childNodes[0].value = foo.counter;

	//sightseeing table
	if (tableID == 'tbl_site_seeing') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_sight_seeing' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'sight' + foo.counter);
	}

	if (tableID == 'tbl_member_dynamic_row') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-member-' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'cmb_m_honorific' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'txt_m_first_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'txt_m_middle_name' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_m_last_name' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'cmb_m_gender' + foo.counter);

		for (var i = row.cells[7].childNodes[0].attributes.length; i-- > 0;)
			row.cells[7].childNodes[0].removeAttributeNode(row.cells[7].childNodes[0].attributes[i]);
		row.cells[7].childNodes[0].setAttribute('id', 'm_birthdate' + foo.counter);
		row.cells[7].childNodes[0].setAttribute(
			'onchange',
			'calculate_age_member(id); payment_details_reflected_data("tbl_member_dynamic_row")'
		);

		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;
		row.cells[7].childNodes[0].value = yesterdayStr;
		row.cells[7].childNodes[0].placeholder = 'Birth Date';

		dynamic_birthdate(row.cells[7].childNodes[0].id);

		row.cells[8].childNodes[0].setAttribute('id', 'txt_m_age' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'txt_m_adolescence' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'txt_m_passport_no' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'txt_m_passport_issue_date' + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'txt_m_passport_expiry_date' + foo.counter);
		if (row.cells[13]) {
			$(row.cells[13]).addClass('hidden');
		}
	}

	if (tableID == 'tbl_train_travel_details_dynamic_row') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-train-' + foo.counter);
		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'txt_train_date' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Departure Date & Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);
		row.cells[3].childNodes[0].setAttribute('id', 'txt_train_from_location' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'txt_train_to_location' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_train_no' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'txt_train_total_seat' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'txt_train_amount' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'txt_train_class' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'cmb_train_priority' + foo.counter);
		$(row.cells[3].childNodes[0]).next("span").remove();
		$(row.cells[4].childNodes[0]).next("span").remove();
	}

	if (tableID == 'tbl_plane_travel_details_dynamic_row' || tableID == 'tbl_plane_travel_details_dynamic_row_update') {
		var prefix = '';
		//if(tableID=="tbl_plane_travel_details_dynamic_row_update") { var prefix = "_u"; }else{ var prefix = ""; }
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-plane-' + prefix + foo.counter);

		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'txt_plane_date-' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);
		row.cells[2].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"txt_arravl-"+foo.counter)');
		row.cells[3].childNodes[0].setAttribute('id', 'from_sector-' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'to_sector-' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_plane_company-' + prefix + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'txt_plane_seats-' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'txt_plane_amount-' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'txt_arravl-' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'from_city-' + prefix + foo.counter);
		$(row.cells[9].childNodes[0]).addClass('hidden');
		row.cells[10].childNodes[0].setAttribute('id', 'to_city-' + prefix + foo.counter);
		$(row.cells[10].childNodes[0]).addClass('hidden');
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[8].childNodes[0].value = today;
		dynamic_datetime(row.cells[8].childNodes[0].id);
		$(row.cells[11]).addClass('hidden');
	}

	if (tableID == 'tbl_check_daily_collection_dynamic_row') {
		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'txt_chk_collection_date' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Date';
		row.cells[2].childNodes[0].style.width = '100px';
		dynamic_date(row.cells[2].childNodes[0].id);

		row.cells[3].childNodes[0].setAttribute('id', 'txt_chk_collection_bank' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'txt_chk_collection_check_no' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_chk_collection_check_amount' + foo.counter);
	}

	if (tableID == 'tbl_dynamic_tour_group') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
		row.cells[0].childNodes[1].setAttribute('for', 'chk_tour_group' + foo.counter);

		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'txt_from_date' + foo.counter);
		row.cells[2].childNodes[0].placeholder = '*From Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[2].childNodes[0].value = today;

		for (var i = row.cells[3].childNodes[0].attributes.length; i-- > 0;)
			row.cells[3].childNodes[0].removeAttributeNode(row.cells[3].childNodes[0].attributes[i]);
		row.cells[3].childNodes[0].setAttribute('id', 'txt_to_date' + foo.counter);
		row.cells[3].childNodes[0].placeholder = '*To Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var yyyy = today.getFullYear();
		var hr = today.getHours();
		var mn = today.getMinutes();
		var sc = today.getSeconds();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[3].childNodes[0].value = today;
		row.cells[2].childNodes[0].setAttribute('onchange', 'get_to_date(id,"txt_to_date"+foo.counter)');

		row.cells[4].childNodes[0].setAttribute('id', 'txt_capacity' + foo.counter);

		jQuery(row.cells[2].childNodes[0])
			.addClass('form-control')
			.datetimepicker({ timepicker: false, minDate: new Date(), format: 'd-m-Y' });
		jQuery(row.cells[3].childNodes[0])
			.addClass('form-control')
			.datetimepicker({ timepicker: false, minDate: new Date(), format: 'd-m-Y' });
	}

	if (tableID == 'dynamic_table_list_p_' + quot_table_id) {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_program1' + foo.counter);
		row.cells[0].childNodes[1].setAttribute('for', 'chk_program1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'special_attaraction' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'day_program' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'overnight_stay' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttribute(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'add_itinerary' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('onclick', 'add_itinerary("dest_name","special_attaraction'+foo.counter+'","day_program'+ foo.counter+'","overnight_stay'+ foo.counter+'","Day-'+(rowCounts+1)+'")');
		if (row.cells[7]) {
			$(row.cells[7]).addClass('hidden');
		}
		$(row.cells[1]).addClass('hidden');
	}
	if (tableID == 'dynamic_table_list_update') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_program1' + foo.counter);
		row.cells[0].childNodes[1].setAttribute('for', 'chk_program1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'special_attaraction' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'day_program' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'overnight_stay' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttribute(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'add_itinerary' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('onclick', 'add_itinerary("dest_name_u","special_attaraction'+foo.counter+'","day_program'+ foo.counter+'","overnight_stay'+ foo.counter+'","Day-'+(rowCounts+1)+'")');
		if (row.cells[7]) {
			$(row.cells[7]).addClass('hidden');
		}
		$(row.cells[1]).addClass('hidden');
	}
	//Package Sale Itinerary
	if (tableID == 'package_program_list') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_program1' + foo.counter);
		row.cells[0].childNodes[1].setAttribute('for', 'chk_program1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'special_attaraction' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'day_program' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'overnight_stay' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttribute(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'add_itinerary' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('onclick', 'add_itinerary("dest_name2","special_attaraction'+foo.counter+'","day_program'+ foo.counter+'","overnight_stay'+ foo.counter+'","Day-'+(rowCounts+1)+'")');
		if (row.cells[7]) {
			$(row.cells[7]).addClass('hidden');
		}
	}
	//Sale default Itinerary
	if (tableID == 'default_program_list') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_programd1' + foo.counter);
		row.cells[0].childNodes[1].setAttribute('for', 'chk_programd1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'special_attaraction' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'day_program' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'overnight_stay' + foo.counter);
		if (row.cells[5]) {
			$(row.cells[5]).addClass('hidden');
		}
	}

	if (tableID == 'tbl_dynamic_city_name') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'cmb_city_' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'active_flag' + foo.counter);
	}

	if (tableID == 'tbl_dynamic_state_name') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'cmb_state_' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'active_flag' + foo.counter);
	}

	if (tableID == 'tbl_airport_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_airport' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'airport_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'airport_code' + foo.counter);
	}

	if (tableID == 'tbl_airline_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_airport' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'airline_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'airline_code' + foo.counter);
	}

	if (tableID == 'tbl_roe_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_currency' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'currency_code' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'currency_rate' + foo.counter);
	}

	if (tableID == 'tbl_destination_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dest' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'destination_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'active_flag' + foo.counter);
	}

	if (tableID == 'tbl_package_hotel_master' || tableID == 'tbl_package_hotel_master_dynamic_update') {
		// new edits
		var prefix =

			tableID == 'tbl_package_tour_quotation_dynamic_plane_update' ? '_d' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dest' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_name' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_name' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'hotel_type' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'hotel_tota_days1' + prefix + foo.counter);
		if (row.cells[6]) {
			row.cells[6].childNodes[0].setAttribute('value', '');
			$(row.cells[6]).addClass('hidden');
		}
	}

	if (tableID == 'tbl_tour_entities') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
	}

	if (tableID == 'tbl_dynamic_transport_agency_bus') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
	}

	////////Journal Entry table/////////
	if (tableID == 'tbl_debited') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_debit1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'ledger_id1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'amount' + foo.counter);
		if (row.cells[5]) {
			$(row.cells[5]).addClass('hidden');
		}
	}

	if (tableID == 'tbl_credited') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_credit1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'ledger_id1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'amount' + foo.counter);
		if (row.cells[5]) {
			$(row.cells[5]).addClass('hidden');
		}
	}

	////////Bank Renconciliation table/////////
	if (tableID == 'tbl_bank_debited') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_b_debit1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'debit_date1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'debit_for' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'amount' + foo.counter);
	}

	if (tableID == 'tbl_bank_credited') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_b_credit1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'credit_date1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'credit_for' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'amount' + foo.counter);
	}
	////////B2b CMS///////////
	if (tableID == 'tbl_dest_packages') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dest1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'dest_name-1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'package-1' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'image-1' + foo.counter);
	}
	if (tableID == 'tbl_activities') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_city1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_name-1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'exc-1' + foo.counter);
		$(row.cells[2].childNodes[0]).next("span").remove();
		city_lzloading('#city_name-1' + foo.counter);
	}
	if (tableID == 'tbl_hotels') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_city1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_name-1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_name-1' + foo.counter);
		$(row.cells[2].childNodes[0]).next("span").remove();
		city_lzloading('#city_name-1' + foo.counter);
	}
	if (tableID == 'tbl_dest_packages_datewise') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dest1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'dest_name-1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'package-1' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'validity-1' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'from_date-1' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'to_date-1' + foo.counter);
		dynamic_date(row.cells[5].childNodes[0].id);
		dynamic_date(row.cells[6].childNodes[0].id);
	}
	if (tableID == 'tbl_grp_packages_datewise') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dest1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'cmb_tour_name-1' + foo.counter);
		// row.cells[3].childNodes[0].setAttribute('id', 'cmb_tour_group-1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'validity-1' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'from_date-1' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'to_date-1' + foo.counter);
		dynamic_date(row.cells[4].childNodes[0].id);
		dynamic_date(row.cells[5].childNodes[0].id);
	}
	//////////END/////////////
	if (tableID == 'tbl_package_tour_member') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-member-' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'cmb_m_honorific' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'txt_m_first_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'txt_m_middle_name' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_m_last_name' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'cmb_m_gender' + foo.counter);

		for (var i = row.cells[7].childNodes[0].attributes.length; i-- > 0;)
			row.cells[7].childNodes[0].removeAttributeNode(row.cells[7].childNodes[0].attributes[i]);
		row.cells[7].childNodes[0].setAttribute('id', 'm_birthdate' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('onchange', 'calculate_age_member(id)');
		row.cells[7].childNodes[0].placeholder = 'Birth Date';
		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;

		row.cells[7].childNodes[0].value = yesterdayStr;
		dynamic_birthdate(row.cells[7].childNodes[0].id);

		row.cells[8].childNodes[0].setAttribute('id', 'txt_m_age' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'txt_m_adolescence' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'txt_m_passport_no' + foo.counter);

		row.cells[11].childNodes[0].setAttribute('id', 'txt_m_passport_birth_date' + foo.counter);
		dynamic_date(row.cells[11].childNodes[0].id);

		row.cells[12].childNodes[0].setAttribute('id', 'txt_m_passport_expiry_date' + foo.counter);
		dynamic_date(row.cells[12].childNodes[0].id);
		row.cells[11].childNodes[0].setAttribute('onchange', 'validate_futuredate(id)');
		row.cells[12].childNodes[0].setAttribute('onchange', 'validate_pastDate(id)');
		$("[name='txt_train_total_seat1']").val(rowCount);
		$("[name='txt_plane_seats-1']").val(rowCount);
		$("[name='txt_cruise_total_seat1']").val(rowCount);
		if (row.cells[13]) {
			$(row.cells[13]).addClass('hidden');
		}
	}

	if (tableID == 'tbl_package_hotel_infomration') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-hotel-acm-' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'city_name1' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_name1' + foo.counter);


		$(row.cells[2].childNodes[0]).next("span").remove();
		city_lzloading(row.cells[2].childNodes[0]);


		for (var i = row.cells[4].childNodes[0].attributes.length; i-- > 0;)
			row.cells[4].childNodes[0].removeAttributeNode(row.cells[4].childNodes[0].attributes[i]);
		row.cells[4].childNodes[0].setAttribute('id', 'txt_hotel_from_date' + foo.counter);
		row.cells[4].childNodes[0].placeholder = 'Check-In Date';
		dynamic_datetime(row.cells[4].childNodes[0].id);

		for (var i = row.cells[5].childNodes[0].attributes.length; i-- > 0;)
			row.cells[5].childNodes[0].removeAttributeNode(row.cells[5].childNodes[0].attributes[i]);
		row.cells[5].childNodes[0].setAttribute('id', 'txt_hotel_to_date' + foo.counter);
		row.cells[5].childNodes[0].placeholder = 'Check-Out Date';
		dynamic_datetime(row.cells[5].childNodes[0].id);

		row.cells[6].childNodes[0].setAttribute('id', 'txt_room' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'txt_catagory' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'room_type' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'cmb_meal_plan' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'txt_hotel_acm_confirmation_no' + foo.counter);

		$('#' + row.cells[7].childNodes[0].id).select2().trigger("change");

		if (row.cells[11]) {
			row.cells[11].style.display = 'none';
		}
	}

	if (tableID == 'tbl_package_transport_infomration') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-tr-acm-1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'vehicle_name1' + foo.counter);


		for (var i = row.cells[3].childNodes[0].attributes.length; i-- > 0;)
			row.cells[3].childNodes[0].removeAttributeNode(row.cells[3].childNodes[0].attributes[i]);
		row.cells[3].childNodes[0].setAttribute('id', 'txt_tsp_from_date' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('class', 'form-control');
		row.cells[3].childNodes[0].placeholder = 'Start Date';
		dynamic_date(row.cells[3].childNodes[0].id);

		row.cells[4].childNodes[0].setAttribute('id', 'pickup_from' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'drop_to' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'no_vehicles' + foo.counter);
		$(row.cells[4].childNodes[0]).select2().trigger('change');
		$(row.cells[5].childNodes[0]).select2().trigger('change');

		if (row.cells[7]) {
			row.cells[7].style.display = 'none';
		}
	}

	if (tableID == 'tbl_package_tour_transport' || tableID == 'tbl_package_tour_transport_update') {
		var prefix =

			tableID == 'tbl_package_tour_transport_update' ? '-u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transport1' + foo.counter + prefix);
		row.cells[2].childNodes[0].setAttribute('id', 'vehicle_name1' + foo.counter + prefix);
		row.cells[3].childNodes[0].setAttribute('id', 'pickup_from' + foo.counter + prefix);
		row.cells[4].childNodes[0].setAttribute('id', 'drop_to' + foo.counter + prefix);

		if (row.cells[5]) {
			row.cells[5].style.display = 'none';
			row.cells[5].childNodes[0].setAttribute('value', '');
		}
	}

	if (tableID == 'tbl_package_exc_infomration') {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-exc' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'exc_date-' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'city_name-' + foo.counter);
		$(row.cells[3].childNodes[0]).next("span").remove();
		row.cells[4].childNodes[0].setAttribute('id', 'excursion-' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'transfer_option-' + foo.counter);

		if (row.cells[6]) {
			row.cells[6].style.display = 'none';
		}
	}
	//*******Package tour quotation dynamic table start*******//
	if (tableID == 'tbl_vendor_quotation_hotel_entries') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_hotel' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'hotel_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'checkin_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'checkout_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		if (row.cells[6]) {
			row.cells[6].innerHTML = '';
		}
	}

	//*******Package tour quotation dynamic table start*******//
	if (tableID == 'tbl_vendor_quotation_transport_entries') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dmc' + foo.counter);
		row.cells[2].setAttribute('class', 'col-md-10');

		row.cells[2].childNodes[0].setAttribute('id', 'transport_agency_id' + foo.counter);
		if (row.cells[3]) {
			row.cells[3].innerHTML = '';
		}
	}

	if (tableID == 'tbl_package_tour_quotation_dynamic_hotel' || tableID == 'tbl_package_tour_quotation_dynamic_hotel_update') {

		var prefix = (tableID == 'tbl_package_tour_quotation_dynamic_hotel_update') ? '_u' : '';

		row.cells[0].childNodes[0].setAttribute('id', 'chk_hotel1' + prefix + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'city_name' + prefix + foo.counter);
		$(row.cells[2].childNodes[0]).next("span").remove();
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_name-' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'room_cat-' + prefix + foo.counter);

		for (var i = row.cells[5].childNodes[0].attributes.length; i-- > 0;)
			row.cells[5].childNodes[0].removeAttributeNode(row.cells[5].childNodes[0].attributes[i]);
		row.cells[5].childNodes[0].setAttribute('id', 'check_in-' + prefix + foo.counter);
		row.cells[5].childNodes[0].placeholder = 'Check-In Date';
		dynamic_date(row.cells[5].childNodes[0].id);

		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttributeNode(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'check_out-' + prefix + foo.counter);
		row.cells[6].childNodes[0].placeholder = 'Check-Out Date';
		dynamic_date(row.cells[6].childNodes[0].id);

		row.cells[7].childNodes[0].setAttribute('id', 'hotel_type-' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'hotel_stay_days-' + prefix + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'no_of_rooms-' + prefix + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'extra_bed-' + prefix + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'package_name' + prefix + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'hotel_cost' + prefix + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'package_id' + prefix + foo.counter);
		row.cells[14].childNodes[0].setAttribute('id', 'extra_bed_cost-' + prefix + foo.counter);

		row.cells[5].childNodes[0].style.width = '150px';
		row.cells[6].childNodes[0].style.width = '150px';
		row.cells[8].style.display = 'none';
		row.cells[12].style.display = 'none';
		row.cells[13].style.display = 'none';
		row.cells[14].style.display = 'none';
		row.cells[5].childNodes[0].setAttribute('onchange', 'get_auto_to_date(id);get_hotel_cost();');
		row.cells[6].childNodes[0].setAttribute('onchange', 'calculate_total_nights(id);validate_validDates(id);get_hotel_cost();');

		row.cells[0].childNodes[0].setAttribute('onchange', 'get_hotel_cost();');
		row.cells[3].childNodes[0].setAttribute('onchange', 'get_hotel_cost();');
		row.cells[4].childNodes[0].setAttribute('onchange', 'get_hotel_cost();');
		row.cells[9].childNodes[0].setAttribute('onchange', 'get_hotel_cost();');
		row.cells[10].childNodes[0].setAttribute('onchange', 'get_hotel_cost();');

		if (row.cells[15]) {
			row.cells[15].innerHTML = '';
			row.cells[15].style.display = 'none';
		}
	}

	if (tableID == 'tbl_package_tour_quotation_dynamic_transport' || tableID == 'tbl_package_tour_quotation_dynamic_transport_u') {

		let fun_name = '';
		if (tableID == 'tbl_package_tour_quotation_dynamic_transport_u') {
			fun_name = 'get_transport_cost_update(id);';
		}
		else {
			fun_name = 'get_transport_cost();';
		}
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transport-' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'transport_vehicle-' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'transport_start_date-' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'pickup_from-' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'drop_to-' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'no_vehicles-' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'transport_cost-' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'package_name-' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'package_id-' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'pickup_type-' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'drop_type' + foo.counter);

		row.cells[0].childNodes[0].setAttribute('onchange', fun_name);
		row.cells[2].childNodes[0].setAttribute('onchange', fun_name);
		row.cells[3].childNodes[0].setAttribute('onchange', fun_name);
		row.cells[4].childNodes[0].setAttribute('onchange', fun_name);
		row.cells[3].childNodes[0].setAttribute('onchange', fun_name);
		row.cells[6].childNodes[0].setAttribute('onchange', fun_name);

		$('#' + row.cells[2].childNodes[0].id).select2().trigger("change");
		$('#' + row.cells[4].childNodes[0].id).select2().trigger("change");
		$('#' + row.cells[5].childNodes[0].id).select2().trigger("change");

		if (row.cells[12]) {
			row.cells[12].innerHTML = '';
			row.cells[12].style.display = 'none';
		}
	}

	if (tableID == 'tbl_package_tour_quotation_dynamic_excursion') {

		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group-' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'exc_date-' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'city_name-' + foo.counter);
		$(row.cells[3].childNodes[0]).next("span").remove();
		row.cells[4].childNodes[0].setAttribute('id', 'excursion-' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'transfer_option-' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'excursion_amount-' + foo.counter);

		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'exc_date-' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Excursion Date';

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);
		jQuery(row.cells[2].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });

		if (quot_table_id == '')
			var function_name = 'get_excursion_amount()';
		else
			var function_name = "get_excursion_amount_update(id)";
		row.cells[0].childNodes[0].setAttribute('onchange', function_name);
		row.cells[2].childNodes[0].setAttribute('onchange', function_name);
		row.cells[4].childNodes[0].setAttribute('onchange', function_name);
		row.cells[5].childNodes[0].setAttribute('onchange', function_name);

		if (row.cells[7]) {
			row.cells[7].innerHTML = '';
			row.cells[7].style.display = 'none';
		}
	}

	if (tableID == 'tbl_dynamic_exc_booking' || tableID == 'tbl_dynamic_exc_booking_update') {
		var current_counter = foo.counter;
		var prefix =

			tableID == 'tbl_dynamic_exc_booking_update' ? '_u' :
				'';
		if (prefix != '') {
			var currentRowCount = document.getElementById('tbl_dynamic_exc_booking_update').rows.length;
			current_counter = currentRowCount + 1;
		}
		if (tableID == 'tbl_dynamic_exc_booking') {
			var function_name = 'get_excursion_amount()';
			var function_name1 = "excursion_amount_calculate(id);calculate_exc_expense('"+tableID+"')";
		}
		else {
			var function_name = "get_excursion_update_amount(id);";
			var function_name1 = "excursion_amount_calculate(id,'1');calculate_exc_expense('"+tableID+"','1')";
		}

		row.cells[0].childNodes[0].setAttribute('id', 'chk_exc' + prefix + current_counter);
		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'exc_date-' + prefix + current_counter);
		row.cells[2].childNodes[0].placeholder = 'Excursion Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}

		var today = dd + '-' + mm + '-' + yyyy + ' 00:00';
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);
		jQuery(row.cells[2].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		row.cells[3].childNodes[0].setAttribute('id', 'city_name-' + prefix + current_counter);
		$(row.cells[3].childNodes[0]).next("span").remove();
		row.cells[4].childNodes[0].setAttribute('id', 'excursion-' + prefix + current_counter);
		row.cells[5].childNodes[0].setAttribute('id', 'transfer_option-' + prefix + current_counter);
		row.cells[6].childNodes[0].setAttribute('id', 'total_adult-' + prefix + current_counter);
		row.cells[7].childNodes[0].setAttribute('id', 'total_children-' + prefix + current_counter);
		row.cells[8].childNodes[0].setAttribute('id', 'adult_cost-' + prefix + current_counter);
		row.cells[9].childNodes[0].setAttribute('id', 'child_cost-' + prefix + current_counter);
		row.cells[10].childNodes[0].setAttribute('id', 'total_amount-' + prefix + current_counter);

		row.cells[0].childNodes[0].setAttribute('onchange', function_name1);
		row.cells[2].childNodes[0].setAttribute('onchange', function_name);
		row.cells[4].childNodes[0].setAttribute('onchange', function_name);
		row.cells[5].childNodes[0].setAttribute('onchange', function_name);

		if (row.cells[11]) {
			row.cells[11].style.display = 'hidden';
		}
	}

	if (tableID == 'tbl_package_tour_quotation_dynamic_costing') {
		row.cells[0].childNodes[1].setAttribute('id', 'chk_costing1' + foo.counter);
		row.cells[2].childNodes[1].setAttribute('id', 'tour_cost-' + foo.counter);
		row.cells[3].childNodes[1].setAttribute('id', 'transport_cost1-' + foo.counter);
		row.cells[4].childNodes[1].setAttribute('id', 'excursion_cost-' + foo.counter);
		row.cells[5].childNodes[1].setAttribute('id', 'basic_amount-' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'basic_show-' + foo.counter);
		row.cells[6].childNodes[1].setAttribute('id', 'service_charge-' + foo.counter);
		row.cells[6].childNodes[1].setAttribute('value', '0.00');
		row.cells[6].childNodes[0].setAttribute('id', 'service_show-' + foo.counter);
		row.cells[7].childNodes[1].setAttribute('id', 'service_tax_subtotal-' + foo.counter)
		row.cells[8].childNodes[1].setAttribute('id', 'total_tour_cost-' + foo.counter);
		row.cells[9].childNodes[1].setAttribute('id', 'package_name1' + foo.counter);
		row.cells[10].childNodes[1].setAttribute('id', 'package_id' + foo.counter);

		$(row.cells[1]).addClass('header_btn');
		$(row.cells[2]).addClass('header_btn');
		$(row.cells[3]).addClass('header_btn');
		$(row.cells[4]).addClass('header_btn');
		$(row.cells[5]).addClass('header_btn');
		$(row.cells[6]).addClass('header_btn');
		$(row.cells[7]).addClass('header_btn');
		$(row.cells[8]).addClass('header_btn');
		$(row.cells[9]).addClass('header_btn');
		$(row.cells[10]).addClass('header_btn');


		if (row.cells[11]) {
			row.cells[11].style.display = 'hidden';
		}
	}
	if (tableID == 'tbl_vendor_quotation_dmc_entries') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_dmc' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'dmc_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'checkin_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'checkout_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'total_rooms' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'room_cat1' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);

		row.cells[3].childNodes[0].setAttribute('onchange', 'get_to_date(id,"checkout_date"+foo.counter)');
		if (row.cells[8]) {
			row.cells[8].innerHTML = '';
		}
	}

	if (tableID == 'tbl_vendor_quotation_services_entries') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_service' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'service_id' + foo.counter);
		if (row.cells[3]) {
			row.cells[3].innerHTML = '';
		}
	}
	//*******Package tour quotation dynamic table end*******//

	//*******Vendor dynamic table start*******//
	if (tableID == 'tbl_vendor_hotel') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_hotel' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'hotel_city_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_id' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'hotel_amount' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'hotel_rating' + foo.counter);

		row.cells[6].innerHTML = '';

		if (row.cells[7]) {
			row.cells[7].style.display = 'none';
		}
	}
	if (tableID == 'tbl_vendor_transport') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transport' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'transport_city_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'transport_agency_id' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'hotel_amount' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'hotel_rating' + foo.counter);

		row.cells[6].innerHTML = '';
		if (row.cells[7]) {
			row.cells[7].style.display = 'none';
		}
	}
	if (tableID == 'tbl_group_tour_save_dynamic_train' || tableID == 'tbl_group_tour_save_dynamic_train_update') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_train1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'train_from_location1' + foo.counter);
		//$('#'+row.cells[2].childNodes[0].id).select2({minimumInputLength: 1});
		row.cells[3].childNodes[0].setAttribute('id', 'train_to_location1' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'train_class1' + foo.counter);
		if (row.cells[5]) {
			row.cells[5].innerHTML = '';
			row.cells[5].style.display = 'none';
		}
	}
	if (tableID == 'tbl_package_tour_quotation_dynamic_train') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_train1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'train_from_location1' + foo.counter);
		//$('#'+row.cells[2].childNodes[0].id).select2({minimumInputLength: 1});
		row.cells[3].childNodes[0].setAttribute('id', 'train_to_location1' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'train_class1' + foo.counter);
		for (var i = row.cells[5].childNodes[0].attributes.length; i-- > 0;)
			row.cells[5].childNodes[0].removeAttributeNode(row.cells[5].childNodes[0].attributes[i]);
		row.cells[5].childNodes[0].setAttribute('id', 'train_departure_date1' + foo.counter);
		row.cells[5].childNodes[0].placeholder = 'Departure Datetime';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0;
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[5].childNodes[0].value = today;
		dynamic_datetime(row.cells[5].childNodes[0].id);
		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttributeNode(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'train_arrival_date1' + foo.counter);
		row.cells[6].childNodes[0].placeholder = 'Arrival Datetime';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[6].childNodes[0].value = today;
		dynamic_datetime(row.cells[6].childNodes[0].id);

		row.cells[5].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"train_arrival_date1"+foo.counter)');
		if (row.cells[7]) {
			row.cells[7].innerHTML = '';
			row.cells[7].style.display = 'none';
		}

		// $('#'+row.cells[2].childNodes[0].id).select2({minimumInputLength: 1});
		// $(this).select2('destroy');
	}
	if (
		tableID == 'tbl_group_tour_quotation_dynamic_plane' ||
		tableID == 'tbl_group_tour_quotation_dynamic_plane_update'
	) {
		var prefix =

			tableID == 'tbl_package_tour_quotation_dynamic_plane_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_plan-' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'from_sector-' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'to_sector-' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'airline_name-' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'plane_class-' + prefix + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'from_city-' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'to_city-' + prefix + foo.counter);
		event_airport(tableID);
	}
	if (
		tableID == 'tbl_enquiry_flight'
	) {
		row.cells[0].childNodes[0].setAttribute('id', 'check-btn-enq-' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'travel_datetime-' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'sector_from-' + foo.counter);
		//$('#'+row.cells[2].childNodes[0].id).select2({minimumInputLength: 1});
		row.cells[4].childNodes[0].setAttribute('id', 'sector_to-' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'preffered_airline-' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'class_type-' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'total_adults_flight-' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'total_child_flight-' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'total_infant_flight-' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'from_city-' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'to_city-' + foo.counter);

		$(row.cells[2].childNodes[0]).datetimepicker({ format: 'd-m-Y H:i:s' });
	}
	if (
		tableID == 'tbl_package_tour_quotation_dynamic_plane' ||
		tableID == 'tbl_package_tour_quotation_dynamic_plane_update'
	) {
		var prefix =

			tableID == 'tbl_package_tour_quotation_dynamic_plane_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_plan-' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'from_sector-' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'to_sector-' + prefix + foo.counter);
		event_airport(tableID);
		row.cells[4].childNodes[0].setAttribute('id', 'airline_name-' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'plane_class-' + prefix + foo.counter);

		for (var i = row.cells[6].childNodes[0].attributes.length; i-- > 0;)
			row.cells[6].childNodes[0].removeAttributeNode(row.cells[6].childNodes[0].attributes[i]);
		row.cells[6].childNodes[0].setAttribute('id', 'txt_dapart-' + foo.counter);
		row.cells[6].childNodes[0].placeholder = 'Departure Date & Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[6].childNodes[0].value = today;
		dynamic_datetime(row.cells[6].childNodes[0].id);

		for (var i = row.cells[7].childNodes[0].attributes.length; i-- > 0;)
			row.cells[7].childNodes[0].removeAttributeNode(row.cells[7].childNodes[0].attributes[i]);
		row.cells[7].childNodes[0].setAttribute('id', 'txt_arrval1-' + foo.counter);
		row.cells[7].childNodes[0].placeholder = 'Arrival Date & Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[7].childNodes[0].value = today;
		dynamic_datetime(row.cells[7].childNodes[0].id);

		row.cells[6].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"txt_arrval1-"+foo.counter)');
		jQuery(row.cells[6].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		jQuery(row.cells[7].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });

		row.cells[8].childNodes[0].setAttribute('id', 'from_city-' + prefix + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'to_city-' + prefix + foo.counter);
		$(row.cells[8]).addClass('hidden');
		$(row.cells[9]).addClass('hidden');

		if (row.cells[10]) {
			$(row.cells[10]).addClass('hidden');
		}
	}
	//*******Vendor dynamic table end*******//
	//Flight Quotation Plane

	if (tableID == 'tbl_flight_quotation_dynamic_plane' || tableID == 'tbl_flight_quotation_dynamic_plane_update') {
		if (tableID == 'tbl_flight_quotation_dynamic_plane_update') {
			var prefix = '_u';
		}
		else {
			var prefix = '';
		}
		row.cells[0].childNodes[0].setAttribute('id', 'chk_plan-' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'from_sector-' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'to_sector-' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'airline_name-' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'plane_class-' + prefix + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'adult-' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'child-' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'infant-' + prefix + foo.counter);
		// row.cells[8].childNodes[0].setAttribute("id", "txt_dapart-"+prefix+foo.counter);
		// row.cells[9].childNodes[0].setAttribute("id", "txt_arrval-"+prefix+foo.counter);
		// for (var i = row.cells[8].childNodes[0].attributes.length; i-- > 0;)
		// 	row.cells[8].childNodes[0].removeAttributeNode(row.cells[8].childNodes[0].attributes[i]);
		row.cells[9].childNodes[0].setAttribute('id', 'txt_dapart-' + prefix + foo.counter);
		row.cells[9].childNodes[0].placeholder = 'Departure Date & Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[9].childNodes[0].value = today;
		dynamic_datetime(row.cells[9].childNodes[0].id);

		for (var i = row.cells[10].childNodes[0].attributes.length; i-- > 0;)
			row.cells[10].childNodes[0].removeAttributeNode(row.cells[10].childNodes[0].attributes[i]);
		row.cells[10].childNodes[0].setAttribute('id', 'txt_arrval-' + prefix + foo.counter);
		row.cells[10].childNodes[0].placeholder = 'Arrival Date & Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[10].childNodes[0].value = today;
		dynamic_datetime(row.cells[10].childNodes[0].id);
		row.cells[9].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"txt_arrval-"' + foo.counter + '")');
		jQuery(row.cells[9].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		jQuery(row.cells[10].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		$(row.cells[10].childNodes[0]).on("change", function () {
			validate_validDatetime('txt_dapart-' + prefix + foo.counter, 'txt_arrval-' + prefix + foo.counter);
		});
		row.cells[11].childNodes[0].setAttribute('id', 'from_city-' + prefix + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'to_city-' + prefix + foo.counter);
		if (row.cells[13]) {
			$(row.cells[13]).addClass('hidden');
		}
	}
	// Group Tour Cruise table
	if (tableID == 'tbl_dynamic_cruise' || tableID == 'tbl_dynamic_cruise_update') {
		var prefix =

			tableID == 'tbl_dynamic_cruise_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_cruise1' + prefix + foo.counter);

		row.cells[2].childNodes[0].setAttribute('id', 'route' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'cabin' + prefix + foo.counter);
	}

	// GIT/FIT Cruise table
	if (tableID == 'tbl_dynamic_cruise_quotation' || tableID == 'tbl_dynamic_cruise_quotation_update') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_cruise1' + foo.counter);
		// row.cells[2].childNodes[0].setAttribute("id", "cruise_departure_date"+foo.counter);
		// row.cells[3].childNodes[0].setAttribute("id", "cruise_arrival_date"+foo.counter);
		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'cruise_departure_date' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Departure Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);
		for (var i = row.cells[3].childNodes[0].attributes.length; i-- > 0;)
			row.cells[3].childNodes[0].removeAttributeNode(row.cells[3].childNodes[0].attributes[i]);
		row.cells[3].childNodes[0].setAttribute('id', 'cruise_arrival_date' + foo.counter);
		row.cells[3].childNodes[0].placeholder = 'Arrival Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[3].childNodes[0].value = today;
		dynamic_datetime(row.cells[3].childNodes[0].id);
		row.cells[4].childNodes[0].setAttribute('id', 'route' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'cabin' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'sharing' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"cruise_arrival_date"+foo.counter)');
		jQuery(row.cells[2].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		jQuery(row.cells[3].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });

		if (row.cells[7]) {
			row.cells[7].style.display = 'none';
		}
	}

	// GIT/FIT Booking Cruise table
	if (tableID == 'tbl_dynamic_cruise_package_booking') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_cruise1' + foo.counter);
		// row.cells[2].childNodes[0].setAttribute("id", "cruise_departure_date"+foo.counter);
		// row.cells[3].childNodes[0].setAttribute("id", "cruise_arrival_date"+foo.counter);
		for (var i = row.cells[2].childNodes[0].attributes.length; i-- > 0;)
			row.cells[2].childNodes[0].removeAttributeNode(row.cells[2].childNodes[0].attributes[i]);
		row.cells[2].childNodes[0].setAttribute('id', 'cruise_departure_date' + foo.counter);
		row.cells[2].childNodes[0].placeholder = 'Departure Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[2].childNodes[0].value = today;
		dynamic_datetime(row.cells[2].childNodes[0].id);

		for (var i = row.cells[3].childNodes[0].attributes.length; i-- > 0;)
			row.cells[3].childNodes[0].removeAttributeNode(row.cells[3].childNodes[0].attributes[i]);
		row.cells[3].childNodes[0].setAttribute('id', 'cruise_arrival_date' + foo.counter);
		row.cells[3].childNodes[0].placeholder = 'Arrival Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[3].childNodes[0].value = today;
		dynamic_datetime(row.cells[3].childNodes[0].id);

		row.cells[4].childNodes[0].setAttribute('id', 'route' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'cabin' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'sharing' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'txt_cruise_total_seat1' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'txt_cruise_amount1' + foo.counter);

		row.cells[2].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"cruise_arrival_date"+foo.counter)');
		jQuery(row.cells[2].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });
		jQuery(row.cells[3].childNodes[0]).addClass('form-control').datetimepicker({ format: 'd-m-Y H:i:s' });

		if (row.cells[9]) {
			$(row.cells[9]).addClass('hidden');
		}
	}

	//*******Vendor Emails start*******//
	if (tableID == 'tbl_dynamic_vendor_request_vendors') {
		row.cells[2].childNodes[0].setAttribute('id', 'vendor_type' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'vendor_id' + foo.counter);

		if (row.cells[4]) {
			row.cells[4].style.display = 'none';
		}
	}
	if (tableID == 'tbl_dynamic_domestic_hotel_vendor') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transport' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'check_in_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'check_out_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);

		if (row.cells[6]) {
			row.cells[6].style.display = 'none';
		}

		dynamic_date(row.cells[3].childNodes[0].id);
		dynamic_date(row.cells[4].childNodes[0].id);
	}
	if (tableID == 'tbl_dynamic_optional_tours_hotel_vendor') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transport' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_id' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'service_id' + foo.counter);

		if (row.cells[4]) {
			row.cells[4].style.display = 'none';
		}
	}
	//*******Vendor Emails end*******//

	//*******Car rental vendor tbl start*******//
	if (tableID == 'tbl_dynamic_car_rental_vehicle_local' || tableID == 'tbl_dynamic_car_rental_vehicle_local1') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_vehicle' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'vehicle_name1' + foo.counter);
		$('#' + row.cells[2].childNodes[0].id).select2();
		row.cells[3].childNodes[0].setAttribute('id', 'seating_capacity' + foo.counter);
		$(row.cells[3]).addClass('hidden');
		row.cells[4].childNodes[0].setAttribute('id', 'total_hrs' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'total_km' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'extra_hrs_rate' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'extra_km' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'rate' + foo.counter);
	}
	if (tableID == 'tbl_dynamic_car_rental_vehicle_local1') {
		$(row.cells[9]).addClass('hidden');
	}
	if (tableID == 'tbl_dynamic_car_rental_vehicle_out' || tableID == 'tbl_dynamic_car_rental_vehicle_out1') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_vehicle' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'vehicle_name1' + foo.counter);
		$('#' + row.cells[2].childNodes[0].id).select2();
		row.cells[3].childNodes[0].setAttribute('id', 'seating_capacity' + foo.counter);
		$(row.cells[3]).addClass('hidden');
		row.cells[4].childNodes[0].setAttribute('id', 'route' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'total_days' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'total_km' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'rate' + foo.counter);

		row.cells[8].childNodes[0].setAttribute('id', 'extra_hrs_rate' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'extra_km' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'driver_allowance' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'permit_charges' + foo.counter);

		row.cells[12].childNodes[0].setAttribute('id', 'toll_parking' + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'state_entry_pass' + foo.counter);
		row.cells[14].childNodes[0].setAttribute('id', 'other_charges' + foo.counter);
	}
	if (tableID == 'tbl_dynamic_car_rental_vehicle_out1') {
		$(row.cells[15]).addClass('hidden');
	}
	//*******Car rental vendor tbl end*******//

	//*******Hotel Booking table start*******//
	if (tableID == 'tbl_hotel_booking' || tableID == 'tbl_hotel_booking_update') {
		if (tableID == 'tbl_hotel_booking_update') {
			var prefix = '_u';
		}
		else {
			var prefix = '';
		}
		row.cells[0].childNodes[0].setAttribute('id', 'chk_hotel_' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_id' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_id' + prefix + foo.counter);

		$(row.cells[2].childNodes[0]).next("span").remove();
		city_lzloading(row.cells[2].childNodes[0]);
		for (var i = row.cells[4].childNodes[0].attributes.length; i-- > 0;)
			row.cells[4].childNodes[0].removeAttributeNode(row.cells[4].childNodes[0].attributes[i]);
		row.cells[4].childNodes[0].setAttribute('id', 'check_in' + foo.counter);
		row.cells[4].childNodes[0].placeholder = 'Check-In Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' ' + '00' + ':' + '00' + ':' + '00';
		row.cells[4].childNodes[0].value = today;
		dynamic_datetime(row.cells[4].childNodes[0].id);

		for (var i = row.cells[5].childNodes[0].attributes.length; i-- > 0;)
			row.cells[5].childNodes[0].removeAttributeNode(row.cells[5].childNodes[0].attributes[i]);
		row.cells[5].childNodes[0].setAttribute('id', 'check_out' + foo.counter);
		row.cells[5].childNodes[0].placeholder = 'Check-Out Date Time';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' ' + '00' + ':' + '00' + ':' + '00';
		row.cells[5].childNodes[0].value = today;
		dynamic_datetime(row.cells[5].childNodes[0].id);
		row.cells[6].childNodes[0].setAttribute('id', 'no_of_nights' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'rooms' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'room_type' + prefix + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'category' + prefix + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'accomodation_type' + prefix + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'extra_beds' + prefix + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'meal_plan' + prefix + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'conf_no' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('onchange', 'get_to_datetime(id,"check_out"+foo.counter)');
		$(row.cells[14]).addClass('hidden');
	}
	//*******Hotel Booking table start*******//

	//*******Visa table start*******//
	if (tableID == 'tbl_dynamic_visa' || tableID == 'tbl_dynamic_visa_update') {
		var prefix =

			tableID == 'tbl_dynamic_visa_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_visa' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'first_name' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'middle_name' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'last_name' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'birth_date' + prefix + foo.counter);
		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;

		row.cells[5].childNodes[0].value = yesterdayStr;
		dynamic_birthdate(row.cells[5].childNodes[0].id);
		row.cells[6].childNodes[0].setAttribute('id', 'adolescence' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'visa_country_name' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'visa_type' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('onchange', 'reflect_cost(this.id)');
		row.cells[9].childNodes[0].setAttribute('id', 'passport_id' + prefix + foo.counter);

		for (var i = row.cells[10].childNodes[0].attributes.length; i-- > 0;)
			row.cells[10].childNodes[0].removeAttributeNode(row.cells[10].childNodes[0].attributes[i]);
		row.cells[10].childNodes[0].setAttribute('id', 'issue_date' + prefix + foo.counter);
		row.cells[10].childNodes[0].placeholder = 'Issue Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[10].childNodes[0].value = today;
		dynamic_date(row.cells[10].childNodes[0].id);
		var date = new Date();
		var yest = date.setDate(date.getDate() - 1);
		var tom = date.setDate(date.getDate() + 1);
		$(row.cells[10].childNodes[0]).datetimepicker({ timepicker: false, maxDate: yest, format: 'd-m-Y' });

		for (var i = row.cells[11].childNodes[0].attributes.length; i-- > 0;)
			row.cells[11].childNodes[0].removeAttributeNode(row.cells[11].childNodes[0].attributes[i]);
		row.cells[11].childNodes[0].setAttribute('id', 'expiry_date' + prefix + foo.counter);
		row.cells[11].childNodes[0].placeholder = 'Expiry Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[11].childNodes[0].value = today;
		dynamic_date(row.cells[11].childNodes[0].id);

		row.cells[12].childNodes[0].setAttribute('id', 'nationality' + prefix + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'received_documents' + prefix + foo.counter);
		for (var i = row.cells[14].childNodes[0].attributes.length; i-- > 0;)
			row.cells[14].childNodes[0].removeAttributeNode(row.cells[14].childNodes[0].attributes[i]);
		row.cells[14].childNodes[0].setAttribute('id', 'appointment' + prefix + foo.counter);
		row.cells[14].childNodes[0].placeholder = 'Appointment Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[14].childNodes[0].value = today;
		dynamic_date(row.cells[14].childNodes[0].id);
		var tom = date.setDate(date.getDate() + 1);
		$(row.cells[14].childNodes[0]).datetimepicker({ timepicker: false, minDate: tom, format: 'd-m-Y' });
		if (tableID == 'tbl_dynamic_visa') {
			row.cells[15].childNodes[0].setAttribute('id', 'visa_cost' + prefix + foo.counter);
			row.cells[15].childNodes[0].value = 0.0;
			$(row.cells[15]).addClass('hidden');
		}
		else {
			$(row.cells[15].childNodes[0]).trigger('change');
			$(row.cells[15]).addClass('hidden');
			row.cells[16].childNodes[0].setAttribute('id', 'visa_cost' + prefix + foo.counter);
			row.cells[16].childNodes[0].value = 0.0;
			// $(row.cells[16]).addClass('hidden');
		}

	}
	//*******Visa table end*******//

	//*******miscellaneous table start*******//
	if (tableID == 'tbl_dynamic_miscellaneous' || tableID == 'tbl_dynamic_miscellaneous_update') {
		var prefix =

			tableID == 'tbl_dynamic_miscellaneous_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_visa' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'first_name' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'middle_name' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'last_name' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'birth_date' + prefix + foo.counter);
		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;

		row.cells[5].childNodes[0].value = yesterdayStr;
		dynamic_birthdate(row.cells[5].childNodes[0].id);
		row.cells[6].childNodes[0].setAttribute('id', 'adolescence' + prefix + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'passport_id' + prefix + foo.counter);

		for (var i = row.cells[8].childNodes[0].attributes.length; i-- > 0;)
			row.cells[8].childNodes[0].removeAttributeNode(row.cells[8].childNodes[0].attributes[i]);
		row.cells[8].childNodes[0].setAttribute('id', 'issue_date' + prefix + foo.counter);
		row.cells[8].childNodes[0].placeholder = 'Issue Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[8].childNodes[0].value = today;
		dynamic_date(row.cells[8].childNodes[0].id);

		for (var i = row.cells[9].childNodes[0].attributes.length; i-- > 0;)
			row.cells[9].childNodes[0].removeAttributeNode(row.cells[9].childNodes[0].attributes[i]);
		row.cells[9].childNodes[0].setAttribute('id', 'expiry_date' + prefix + foo.counter);
		row.cells[9].childNodes[0].placeholder = 'Expiry Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy;
		row.cells[9].childNodes[0].value = today;
		dynamic_date(row.cells[9].childNodes[0].id);

		$(row.cells[10]).addClass('hidden');
	}
	//*******Miscellaneous table end*******//

	//*******Passport table start*******//
	if (tableID == 'tbl_dynamic_passport' || tableID == 'tbl_dynamic_passport_update') {
		var prefix =

			tableID == 'tbl_dynamic_passport_update' ? '_u' :
				'';
		row.cells[0].childNodes[0].setAttribute('id', 'chk_passport' + prefix + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'honorific' + prefix + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'first_name' + prefix + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'middle_name' + prefix + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'last_name' + prefix + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'birth_date' + prefix + foo.counter);
		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;

		row.cells[6].childNodes[0].value = yesterdayStr;
		dynamic_birthdate(row.cells[6].childNodes[0].id);
		row.cells[7].childNodes[0].setAttribute('id', 'adolescence' + prefix + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'received_documents' + prefix + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'appointment' + prefix + foo.counter);
		$(row.cells[10]).addClass('hidden');
	}
	//*******Passport table end*******//

	//*******Ticket table start*******//
	if (tableID == 'tbl_dynamic_ticket_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'first_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'middle_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'last_name' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'birth_date' + foo.counter);
		$(row.cells[5]).addClass('hidden');
		// row.cells[5].childNodes[0].setAttribute('onchange', 'adolescence_reflect(id)');
		// row.cells[5].childNodes[0].placeholder = 'Birth Date';
		// var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		// var d = yesterday.getDate();
		// var m = yesterday.getMonth() + 1; //Month from 0 to 11
		// var y = yesterday.getFullYear();
		// var yesterdayStr =
		// 	'' +
		// 	(
		// 		d <= 9 ? '0' + d :
		// 			d) +
		// 	'-' +
		// 	(
		// 		m <= 9 ? '0' + m :
		// 			m) +
		// 	'-' +
		// 	y;

		// row.cells[5].childNodes[0].value = yesterdayStr;
		// dynamic_birthdate(row.cells[5].childNodes[0].id);

		row.cells[6].childNodes[0].setAttribute('id', 'adolescence' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'ticket_no' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'gds_pnr' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'baggage_info' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'main_ticket' + foo.counter);
		$(row.cells[11]).addClass('hidden');
		$(row.cells[6].childNodes[0]).prop('disabled', false);
	}
	if (tableID == 'tbl_dynamic_ticket_master_airfile') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'first_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'middle_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'last_name' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'adolescence' + foo.counter);
		row.cells[5].childNodes[0].disabled = false;
		row.cells[6].childNodes[0].setAttribute('id', 'ticket_no' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'gds_pnr' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'conjunction' + foo.counter);
		$(row.cells[8]).addClass('hidden');
	}
	//*******Ticket table end*******//

	//*******Ticket table start*******//
	if (tableID == 'tbl_dynamic_train_ticket_master') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'honorific' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'first_name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'middle_name' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'last_name' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'birth_date' + foo.counter);
		var yesterday = new Date(new Date().valueOf() - 1000 * 60 * 60 * 24);
		var d = yesterday.getDate();
		var m = yesterday.getMonth() + 1; //Month from 0 to 11
		var y = yesterday.getFullYear();
		var yesterdayStr =
			'' +
			(
				d <= 9 ? '0' + d :
					d) +
			'-' +
			(
				m <= 9 ? '0' + m :
					m) +
			'-' +
			y;

		row.cells[6].childNodes[0].value = yesterdayStr;
		dynamic_birthdate(row.cells[6].childNodes[0].id);
		row.cells[7].childNodes[0].setAttribute('id', 'adolescence' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'coach_number' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'seat_number' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'ticket_number' + foo.counter);

		$(row.cells[11]).addClass('hidden');
	}
	//*******Ticket table end*******//

	//*******Ticket table start*******//
	if (tableID == 'tbl_dynamic_bus_booking') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'company_name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'seat_type' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'bus_type' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'pnr_no' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'origin' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'destination' + foo.counter);
		// row.cells[8].childNodes[0].setAttribute("id", "date_of_journey"+foo.counter);
		for (var i = row.cells[8].childNodes[0].attributes.length; i-- > 0;)
			row.cells[8].childNodes[0].removeAttributeNode(row.cells[8].childNodes[0].attributes[i]);
		row.cells[8].childNodes[0].setAttribute('id', 'date_of_journey' + prefix + foo.counter);
		row.cells[8].childNodes[0].placeholder = 'Journey Date';
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!

		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '-' + mm + '-' + yyyy + ' 00:00:00';
		row.cells[8].childNodes[0].value = today;
		dynamic_datetime(row.cells[8].childNodes[0].id);
		row.cells[9].childNodes[0].setAttribute('id', 'reporting_time' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'boarding_point_access' + foo.counter);

		$(row.cells[11]).addClass('hidden');
	}
	//*******Ticket table end*******//

	//********vendor Pricing********//
	if (tableID == 'table_vendor_pricing') {
		// var prefix = tableID=="tbl_dynamic_booking_quotation" ? "_u" : "";
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'without_bed' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'from_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'to_date' + foo.counter);
		row.cells[3].childNodes[0].value = get_date();
		dynamic_date(row.cells[3].childNodes[0].id);
		row.cells[4].childNodes[0].value = get_date();
		dynamic_date(row.cells[4].childNodes[0].id);
		row.cells[5].childNodes[0].setAttribute('id', 'single_bed' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'double_bed' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'triple_bed' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'quad_bed' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'with_bed' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'queen' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'king' + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'twin' + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		$(row.cells[14]).addClass('hidden');
	}

	//********Daily activity********//
	if (tableID == 'tbl_dynamic_daily_activity') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'activity_date' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'activity_type' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'time_taken' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'description' + foo.counter);
		$(row.cells[6]).addClass('hidden');
	}
	//*******Daily activity*******//
	// Customer Testimonials
	if (tableID == "tbl_customer_tm") {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ctm' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'name' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'designation' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'testm' + foo.counter);
	}

	//********checklist-to do entries***//
	if (tableID == 'tbl_dynamic_tour_name' || tableID == 'tbl_dynamic_tour_name_update') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tour_group' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'entity_name' + foo.counter);
	}
	//********checklist-to do entries end***//

	//********Hotel Tarrif Pricing********//
	if (tableID == 'table_hotel_tarrif' + quot_table_id || tableID == 'table_hotel_tarrif_update') {
		// var prefix = tableID=="tbl_dynamic_booking_quotation" ? "_u" : "";
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + quot_table_id + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'room_cat' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'occupancy' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'from_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'to_date' + foo.counter);
		row.cells[4].childNodes[0].value = get_date();
		dynamic_date(row.cells[4].childNodes[0].id);
		row.cells[5].childNodes[0].value = get_date();
		dynamic_date(row.cells[5].childNodes[0].id);
		row.cells[6].childNodes[0].setAttribute('id', 'single_bed' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'double_bed' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'triple_bed' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'cwbed' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'cwobed' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'first_child' + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'second_child' + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'with_bed' + foo.counter);
		row.cells[14].childNodes[0].setAttribute('id', 'queen' + foo.counter);
		row.cells[15].childNodes[0].setAttribute('id', 'king' + foo.counter);
		row.cells[16].childNodes[0].setAttribute('id', 'quad_bed' + foo.counter);
		row.cells[17].childNodes[0].setAttribute('id', 'twin' + foo.counter);
		row.cells[18].childNodes[0].setAttribute('id', 'markup_per' + foo.counter);
		row.cells[19].childNodes[0].setAttribute('id', 'flat_markup' + foo.counter);
		row.cells[20].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);

		row.cells[4].childNodes[0].setAttribute('onchange', 'get_to_date(id,"to_date"+foo.counter)');
		if (row.cells[21]) {
			$(row.cells[21]).addClass('hidden');
		}

		$(row.cells[6]).addClass('hidden');
		$(row.cells[8]).addClass('hidden');
		$(row.cells[11]).addClass('hidden');
		$(row.cells[12]).addClass('hidden');
		$(row.cells[14]).addClass('hidden');
		$(row.cells[15]).addClass('hidden');
		$(row.cells[16]).addClass('hidden');
		$(row.cells[17]).addClass('hidden');
	}
	if (tableID == 'table_hotel_tarrif_offer') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_offer' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'offer_type' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'from_date_h' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'to_date_h' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'amount_in' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'coupon_code' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'amount' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'agent_type' + foo.counter);

		row.cells[3].childNodes[0].value = get_date();
		dynamic_date(row.cells[3].childNodes[0].id);
		row.cells[4].childNodes[0].value = get_date();
		dynamic_date(row.cells[4].childNodes[0].id);
		row.cells[3].childNodes[0].setAttribute('onchange', 'get_to_date(id,"to_date_h"+foo.counter)');

		$(row.cells[9]).addClass('hidden');
	}
	if (tableID == 'table_hotel_weekend_tarrif') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_ticket' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'room_cat' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'occupancy' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'day' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'single_bed' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'double_bed' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'triple_bed' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'cwbed' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'cwobed' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'first_child' + foo.counter);
		row.cells[11].childNodes[0].setAttribute('id', 'second_child' + foo.counter);
		row.cells[12].childNodes[0].setAttribute('id', 'with_bed' + foo.counter);
		row.cells[13].childNodes[0].setAttribute('id', 'queen' + foo.counter);
		row.cells[14].childNodes[0].setAttribute('id', 'king' + foo.counter);
		row.cells[15].childNodes[0].setAttribute('id', 'quad_bed' + foo.counter);
		row.cells[16].childNodes[0].setAttribute('id', 'twin' + foo.counter);
		row.cells[17].childNodes[0].setAttribute('id', 'markup_per' + foo.counter);
		row.cells[18].childNodes[0].setAttribute('id', 'flat_markup' + foo.counter);
		row.cells[19].childNodes[0].setAttribute('id', 'meal_plan' + foo.counter);
		$(row.cells[20]).addClass('hidden');

		row.cells[2].childNodes[0].setAttribute('data-toggle', 'tooltip');

		$(row.cells[5]).addClass('hidden');
		$(row.cells[7]).addClass('hidden');
		$(row.cells[10]).addClass('hidden');
		$(row.cells[11]).addClass('hidden');
		$(row.cells[13]).addClass('hidden');
		$(row.cells[14]).addClass('hidden');
		$(row.cells[15]).addClass('hidden');
		$(row.cells[16]).addClass('hidden');
	}
	if (tableID == 'table_transfer_tarrif') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_transfer' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'pickup_from' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'drop_to' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'duration' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'from_date' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'to_date' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'luggage' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'total_cost' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'markup_in' + foo.counter);
		row.cells[10].childNodes[0].setAttribute('id', 'markup_amount' + foo.counter);

		row.cells[5].childNodes[0].value = get_date();
		dynamic_date(row.cells[5].childNodes[0].id);
		row.cells[6].childNodes[0].value = get_date();
		dynamic_date(row.cells[6].childNodes[0].id);

		$('#' + row.cells[5].childNodes[0].id).datetimepicker({ timepicker: false, format: 'd-m-Y' });
		$('#' + row.cells[6].childNodes[0].id).datetimepicker({ timepicker: false, format: 'd-m-Y' });
		row.cells[5].childNodes[0].setAttribute('onchange', 'get_to_date(id,"to_date"+foo.counter)');

		$(row.cells[11]).addClass('hidden');
	}
	if (tableID == 'table_exc_tarrif_basic') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_basic' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'transfer_option' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'from_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'to_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'adult_cost' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'child_cost' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'infant_cost' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'markup_in' + foo.counter);
		row.cells[9].childNodes[0].setAttribute('id', 'amount' + foo.counter);

		row.cells[3].childNodes[0].value = get_date();
		dynamic_date(row.cells[3].childNodes[0].id);
		row.cells[4].childNodes[0].value = get_date();
		dynamic_date(row.cells[4].childNodes[0].id);

		$(row.cells[10]).addClass('hidden');
	}
	if (tableID == 'table_exc_tarrif_offer') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_offer' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'offer_type' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'from_date' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'to_date' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'offer_in' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'coupon_code' + foo.counter);
		row.cells[7].childNodes[0].setAttribute('id', 'offer' + foo.counter);
		row.cells[8].childNodes[0].setAttribute('id', 'agent_type' + foo.counter);

		row.cells[3].childNodes[0].value = get_date();
		dynamic_date(row.cells[3].childNodes[0].id);
		row.cells[4].childNodes[0].value = get_date();
		dynamic_date(row.cells[4].childNodes[0].id);
		$('#' + row.cells[8].childNodes[0].id).select2();

		$(row.cells[9]).addClass('hidden');
	}
	if (tableID == 'table_exc_time_slot') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_time' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'from_time' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'to_time' + foo.counter);

		$('#' + row.cells[2].childNodes[0].id).datetimepicker({
			datepicker: false,
			format: 'H:i A',
			showMeridian: true
		});
		$('#' + row.cells[3].childNodes[0].id).datetimepicker({
			datepicker: false,
			format: 'H:i A',
			showMeridian: true
		});
		$(row.cells[4]).addClass('hidden');
	}

	if (tableID == 'tbl_similar_hotels' + quot_table_id) {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_hh1' + quot_table_id + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'city_id1' + quot_table_id + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'hotel_id1' + quot_table_id + foo.counter);
	}

	if (tableID == 'tbl_taxes') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tax1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'code' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'name' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'rate_in' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'rate' + foo.counter);
	}

	if (tableID == 'tbl_taxe_rule_conditions') {
		row.cells[0].childNodes[0].setAttribute('id', 'chk_tax1' + foo.counter);
		row.cells[2].childNodes[0].setAttribute('id', 'condition' + foo.counter);
		row.cells[3].childNodes[0].setAttribute('id', 'for' + foo.counter);
		row.cells[4].childNodes[0].setAttribute('id', 'value' + foo.counter);
		row.cells[5].childNodes[0].setAttribute('id', 'currency' + foo.counter);
		row.cells[6].childNodes[0].setAttribute('id', 'amount' + foo.counter);
		if (row.cells[7]) {
			row.cells[7].childNodes[0].setAttribute('id', 'entry_id' + foo.counter);
		}
		document.getElementById('currency' + foo.counter).setAttribute('style', 'display:none;');
		document.getElementById('amount' + foo.counter).setAttribute('style', 'display:none;');
	}
	$("input[type='radio'], input[type='checkbox']").labelauty({ label: false, maximum_width: '20px' });
	$('#' + tableID).find('.app_select2').each(function () {
		$(this).select2();
	});
	$('#' + tableID).find('.app_minselect2').each(function () {
		$(this).select2({ minimumInputLength: 1 });
	});
	$('#' + tableID).find('.app_datetimepicker').each(function () {
		$(this).datetimepicker({ format: 'd-m-Y H:i:s' });
	});
	$('#' + tableID).find('.app_datepicker').each(function () {
		$(this).datetimepicker({ timepicker: false, format: 'd-m-Y' });
	});
	$('#' + tableID).find('.app_timepicker').each(function () {
		$(this).datetimepicker({ datepicker: false, format: 'H:i' });
	});
}
function addRow(tableID, quot_table = '') {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);

	var colCount = table.rows[0].cells.length;

	$('#' + tableID).find('.app_select2').each(function () {
		$(this).select2();
		$(this).select2('destroy');
	});
	$('#' + tableID).find('.app_minselect2').each(function () {
		$(this).select2({ minimumInputLength: 1 });
		$(this).select2('destroy');
	});
	for (var i = 0; i < colCount; i++) {
		var newcell = row.insertCell(i);
		var val_data = table.rows[0].cells[i].childNodes[0].value;

		newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		newcell.setAttribute('title', table.rows[0].cells[i].childNodes[0].getAttribute('title') != "" ? table.rows[0].cells[i].childNodes[0].getAttribute('title') :table.rows[0].cells[i].childNodes[0].getAttribute('data-original-title'));
		$(newcell.childNodes[0]).tooltip({placement: 'bottom'});
		$(newcell.childNodes[0]).click(function(){$('.tooltip').remove()})
		switch (newcell.childNodes[0].type) {
			case 'text':
				if (quot_table == '' || quot_table == '2') {
					newcell.childNodes[0].value = '';
				}
				else {
					newcell.childNodes[0].value = val_data;
				}
				break;

			case 'hidden':
				if (quot_table == '' || quot_table == '2') {
					newcell.childNodes[0].value = '';
				}
				else {
					newcell.childNodes[0].value = val_data;
				}
				break;
			case 'checkbox':
				newcell.childNodes[0].checked = true;
				newcell.childNodes[0].disabled = false;
				break;
			case 'select-one':
				newcell.childNodes[0].selectedIndex = 0;
				break;
			case 'textarea':
				if (quot_table == '' || quot_table == '2') {
					newcell.childNodes[0].value = '';
				}
				else {
					newcell.childNodes[0].value = val_data;
				}
		}
	}
	foo(tableID, quot_table,rowCount);
}

function deleteRow(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		for (var i = 0; i < rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];

			if (null != chkbox && true == chkbox.checked) {
				if (rowCount <= 1) {
					error_msg_alert('Cannot delete all the rows.');
					break;
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}
		}
	} catch (e) {
		alert(e);
	}
	if (tableID == 'tbl_member_dynamic_row') {
		payment_details_reflected_data(tableID);
	}
	if (tableID == 'tbl_package_tour_member') {
		$("[name='txt_train_total_seat1']").val(rowCount);
		$("[name='txt_plane_seats-1']").val(rowCount);
		$("[name='txt_cruise_total_seat1']").val(rowCount);
	}
}

/// **** Dynamic Table Entries ***********************//////////////////////////////
