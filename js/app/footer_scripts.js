$(function () {
	$('form').attr('autocomplete', 'off');
	$('input').attr('autocomplete', 'off');
});

$(function () {
	$('.feature_editor').wysiwyg({
		controls: 'bold,italic,|,undo,redo,image|h1,h2,h3,decreaseFontSize,highlight',
		initialContent: ''
	});
});

//**Sidebar Scroll
(function ($) {
	$(window).on('load', function () {
		$('.sidebar_wrap').mCustomScrollbar();
	});
})(jQuery);

//**Site Tooltips
$(function () {
	$("[data-toggle='tooltip']").tooltip({ placement: 'bottom' });
	$("[data-toggle='tooltip']").click(function () {
		$('.tooltip').remove();
	});
});

$(function () {
	$('input[type="text"], input[type="number"], select, textarea').addClass('form-control');
	$('.no_form_control').removeClass('form-control');
});

//* round off values function *//

function round_off_value(amount) {
	var amount1 = parseFloat(amount).toFixed(2);
	return amount1;
}

//**Message alert

function msg_alert(message) {
	var msg = message.split('--');
	if (msg[0] == 'error') {
		error_msg_alert(msg[1]);
	}
	else {
		success_msg_alert(message);
	}
}
//branch reflect
function emp_branch_reflect() {
	var base_url = $('#base_url').val();
	var emp_id = $('#booker_id_filter').val();

	$.post(base_url + 'view/load_data/branch_reflect.php', { emp_id: emp_id }, function (data) {
		$('#branch_id_filter').html(data);
	});
}

//Customer branch reflect
function cust_branch_reflect() {
	var base_url = $('#base_url').val();
	var cust_id = $('#customer_filter').val();

	$.post(base_url + 'view/load_data/cust_branch_reflect.php', { cust_id: cust_id }, function (data) {
		$('#branch_id_filter').html(data);
	});
}
//**Error Message Alert

function error_msg_alert(message, delay = '6000') {
	$('#site_alert').empty(); // to only display one error message
	$('#site_alert').vialert({ type: 'error', title: 'Error', message: message, delay: delay });
}

//**Success Message Alert

function success_msg_alert(message) {
	$('#site_alert').empty(); // to only display one success message
	$('#site_alert').vialert({ message: message });
}

//**Message popup reload
function msg_popup_reload(message) {
	var msg = message.split('--');

	if (msg[0] == 'error') {
		error_msg_alert(msg[1]);
	}
	else {
		$('#vi_confirm_box').vi_confirm_box({
			false_btn: false,
			message: message,
			true_btn_text: 'Ok',
			callback: function (data1) {
				if (data1 == 'yes') {
					document.location.reload();
				}
			}
		});
	}
}

//**Reset Form
function reset_form(form_id) {
	$('#' + form_id).find('input[type="text"]').each(function () {
		$(this).val('');
	});

	$('#' + form_id).find('textarea').each(function () {
		$(this).val('');
	});

	$('#' + form_id).find('select').each(function () {
		$(this).prop('selected', function () {
			return this.defaultSelected;
		});
	});
	document.getElementById(form_id).reset();
	$("select").closest("form").on("reset", function (ev) { // for resetting Select2
		var targetJQForm = $(ev.target);
		setTimeout((function () {
			this.find("select").trigger("change");
		}).bind(targetJQForm), 0);
	});
	document.getElementById(form_id).reset();
	$('#basic_show').html('&nbsp;'); $('#basic_show1').html('&nbsp;');
	$('#service_show').html('&nbsp;'); $('#service_show1').html('&nbsp;');
	$('#markup_show').html('&nbsp;'); $('#markup_show1').html('&nbsp;');
	$('#discount_show').html('&nbsp;'); $('#discount_show1').html('&nbsp;');
}

//**Element count in array

function isInArray(value, array1) {
	for (var arr_count = 0; arr_count < array1.length; arr_count++) {
		if (array1[arr_count] == value) {
			return false;
		}
	}
	return true;
}

//**Generic Tooltip
/*$(function() {
	$('input, select, textarea, span, a').tooltip({placement: 'bottom'});
});*/
$(function () {
	$('input,textarea,span, a').tooltip({ placement: 'bottom' });
	$('input,textarea,span, a').focus(function () {
		$('input,textarea,span, a').tooltip('hide');
	});
});

//**Radio button and checkboxes
$(document).ready(function () {
	$("input[type='radio'], input[type='checkbox']").labelauty({ label: false, maximum_width: '20px' });
});

//**Dual button
$(function () {
	$('.app_dual_button input[type="checkbox"], .app_dual_button input[type="radio"]').change(function () {
		$(this).parent().siblings().removeClass('active');

		$(this).parent().addClass('active');
	});
});

//**First letter capital event start**//
$(function () {
	var exception_fields_arr = [
		'app_website',
		'sms_username',
		'sms_password',
		'server_username',
		'txt_username',
		'app_smtp_host',
		'app_smtp_port',
		'app_smtp_password',
		'app_smtp_method',
		'airport_code1',
		'check_in',
		'check_out',
		'check_in1',
		'check_out1',
		're_password',
		'new_password',
		'current_password',
		'app_name',
		'bank_name',
		'bank_ifsc_code',
		'bank_swift_code',
		'package_name',
		'package_code',
		'package_name1',
		'package_code1',
		'corpo_company_name'
	];

	$('input[type="text"]').change(function () {
		var str_arr = $(this).val();
		var id = $(this).attr('id');

		if (jQuery.inArray(id, exception_fields_arr) == -1) {
			// if (!id.includes('email')) {
			// 	$(this).val( toTitleCase(str_arr) );
			// }
		}
	});
});

//**First letter capital event end**//
function toTitleCase(str) {
	return str.replace(/\w\S*/g, function (txt) {
		return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	});
}

//**App Base URL start**//
function base_url() {
	var base_url = $('#base_url').val();
	return base_url;
}

$.validator.addMethod('regex', function (value, element, param) {
	return this.optional(element) || param.test(value);
});

//**Bank List reflect autocomplete start**//
function bank_list_reflect() {
	var base_url = $('#base_url').val();

	$.post(base_url + 'view/load_data/bank_list_json_response.php', {}, function (data) {
		var data = jQuery.parseJSON(data);
		bank_name_autocomplete(data);
	});
}
bank_list_reflect();
function bank_name_autocomplete(data) {
	$('.bank_suggest').each(function () {
		$(this).autocomplete({ source: data });
	});
}
//**Bank List reflect autocomplete end**//

//**Route List reflect autocomplete start**//
function route_list_reflect() {
	var base_url = $('#base_url').val();

	$.post(base_url + 'view/load_data/route_list_json_response.php', {}, function (data) {
		var data = jQuery.parseJSON(data);
		route_name_autocomplete(data);
	});
}
route_list_reflect();
function route_name_autocomplete(data) {
	$('.route_suggest').each(function () {
		$(this).autocomplete({ source: data });
	});
}
//**Route List reflect autocomplete end**//


function today_date(id) {
	var today = new Date();
	var todaydate =
		String(today.getDate()).padStart(2, '0') +
		'-' +
		String(today.getMonth() + 1).padStart(2, '0') +
		'-' +
		today.getFullYear();
	$('#' + id).val(todaydate);
}
today_date('as_of_date');
//**Calculate age generic start**//
function calculate_age_generic(from, to) {
	var dateString1 = $('#' + from).val();
	var get_new = dateString1.split('-');

	var day = get_new[0];

	var month = get_new[1];

	var year = get_new[2];

	var dateString = month + '/' + day + '/' + year;

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

	$('#' + to).val(age);
}

//**Calculate age generic start**//

//**Generic Customer save start**//

function customer_save_modal(client_modal_type = 'other') {
	var base_url = $('#base_url').val();

	$.post(base_url + 'view/customer_master/save_modal.php', { client_modal_type: client_modal_type }, function (data) {
		$('#div_customer_save_modal').html(data);
	});
}

function customer_dropdown_reload(cust_id = '') {
	var base_url = $('#base_url').val();

	$('.customer_dropdown').each(function () {
		var cur_ele = $(this);

		$.post(base_url + 'view/customer_master/customer_dropdown_load.php', {}, function (data) {
			$(cur_ele).select2();

			$(cur_ele).css('width', '100%');

			$(cur_ele).html(data);

			if (cust_id != '') {
				$(cur_ele).val(cust_id);
			}

			$(cur_ele).trigger('change');
		});
	});
}

//**Generic Customer save end**//
//**Generic Hotel save start**//
function hotel_save_modal() {
	var base_url = $('#base_url').val();
	var target = '_blank';
	window.open(base_url + 'view/hotels/master/index.php', target);
}

function hotel_dropdown_reload(hotel_id = '') {
	var base_url = $('#base_url').val();

	$('.hotel_dropdown').each(function () {
		var cur_ele = $(this);

		$.post(base_url + 'view/hotels/master/hotel/hotel_dropdown_load.php', {}, function (data) {
			$(cur_ele).select2();

			$(cur_ele).css('width', '100%');

			$(cur_ele).html(data);

			if (hotel_id != '') {
				$(cur_ele).val(hotel_id);
			}

			$(cur_ele).trigger('change');
		});
	});
}

//**Generic Hotel save end**//

function corporate_fields_reflect() {
	var base_url = $('#base_url').val();

	var cust_type = $('#cust_type').val();

	var customer_id = $('#customer_id').val();

	$.post(
		base_url + 'view/customer_master/corporate_fields_reflect.php',
		{ cust_type: cust_type, customer_id: customer_id },
		function (data) {
			$('#corporate_fields').html(data);
		}
	);
}

//**Generic City save modal start**//

function generic_city_save_modal(modal_type = '') {
	$('#btn_city_save_modal').button('loading');

	var base_url = $('#base_url').val();

	$.post(base_url + 'view/other_masters/cities/save_modal.php', { modal_type: modal_type }, function (data) {
		$('#btn_city_save_modal').button('reset');

		$('#div_city_save_modal').html(data);
	});
}

function city_master_dropdown_reload() {
	var city_master_dropdown = 'city_master_dropdown';

	var base_url = $('#base_url').val();

	$('.city_master_dropdown').each(function () {
		var cur_ele = $(this);

		$.post(
			base_url + 'modal/app_settings/dropdown_master.php',
			{ city_master_dropdown: city_master_dropdown },
			function (data) {
				$(cur_ele).select2();

				$(cur_ele).css('width', '100%');

				$(cur_ele).html(data).trigger('change');
			}
		);
	});
}
//City Dropdown Lazy Loading
function city_lzloading(element, placeholder = "City Name", valueasText = false) {
	var base_url = $("#base_url").val();
	url = base_url + '/view/load_data/generic_city_loading.php';
	$(element).append($("<option></option>").attr("value", "").text(placeholder)); 
	$(element).select2({
		placeholder: placeholder,
		ajax: {
			url: url,
			dataType: 'json',
			type: 'GET',
			data: function (params) { return { term: params.term, page: params.page || 0, valueasText: valueasText } },
			processResults: function (data) {
				let more = data.pagination;
				return {
					results: data.results,
					pagination: {
						more: more.more,
					}
				};
			}
		}
	});

}
function destinationLoading(element, placeholder = "Destination", valueasText = false) {
	var base_url = $("#base_url").val();
	url = base_url + '/view/load_data/generic_destination_loading.php';

	$(element).select2({
		placeholder: placeholder,
		ajax: {
			url: url,
			dataType: 'json',
			type: 'GET',
			data: function (params) { return { term: params.term, page: params.page || 0, valueasText: valueasText } },
			processResults: function (data) {
				let more = data.pagination;
				return {
					results: data.results,
					pagination: {
						more: more.more,
					}
				};
			}
		}
	});
}
//**Generic City save modal end**//

//**Generic PAyment fields toggle function start**//

function payment_master_toggles(payment_mode_id, bank_name_id, transaction_id_id, bank_id_id) {

	var payment_mode = $('#' + payment_mode_id).val();

	if (payment_mode == 'Cash' || payment_mode == 'Credit Card' || payment_mode == '' || payment_mode == 'Credit Note' || payment_mode == 'Debit Note') {

		$('#' + bank_name_id).prop({ disabled: 'disabled', readonly: 'readonly', value: '' });
		$('#' + transaction_id_id).prop({ disabled: 'disabled', readonly: 'readonly', value: '' });
		$('#' + bank_id_id).prop({ disabled: 'disabled', readonly: 'readonly', value: '' });
	}
	else {

		$('#' + bank_name_id).prop({ disabled: '', readonly: '' });
		$('#' + transaction_id_id).prop({ disabled: '', readonly: '' });
		$('#' + bank_id_id).prop({ disabled: '', readonly: '' });
	}
}

//**Generic PAyment fields toggle function end**//

//If payment amount 0 disable payment mode

function payment_amount_validate(payment_amount_id, payment_mode_id, transaction_id_id, bank_name_name, bank_id_id) {
	var payment_amt = $('#' + payment_amount_id).val();

	if (payment_amt == 0) {
		$('#' + payment_mode_id).prop({ disabled: 'disabled', value: '' });

		$('#' + transaction_id_id).prop({ disabled: 'disabled', value: '' });

		$('#' + bank_name_name).prop({ disabled: 'disabled', value: '' });

		$('#' + bank_id_id).prop({ disabled: 'disabled', value: '' });
	}
	else {
		$('#' + payment_mode_id).prop({ disabled: '' });
	}
}

function event_airport(id, fromSectornum = 2, toSectornum = 3) { //driver function
	var table1 = document.getElementById(id);
	var rows = table1.rows;
	for (var i = 0; i < parseInt(rows.length); i++) {
		var id1 = rows[i].cells[fromSectornum].childNodes[0].getAttribute('id');
		var id2 = rows[i].cells[toSectornum].childNodes[0].getAttribute('id');

		var ids = [{ "dep": id1 }, { "arr": id2 }];
		try {
			airport_load_main(ids);
		}
		catch (e) {
			continue;
		}
	}
}
function airport_load_main(ids) {
	ids.forEach(function (id) {
		var object_id = Object.values(id)[0];
		var base_url = $('#base_url').val();
		$("#" + object_id).autocomplete({
			source: function (request, response) {
				$.ajax({
					method: 'get',
					url: base_url + '/view/visa_passport_ticket/ticket/home/airport_list.php',
					dataType: 'json',
					data: { request: request.term },
					success: function (data) {
						response(data);
					}
				});
			},
			select: function (event, ui) {
				// var substr_id =  object_id.substr(6);
				var substr_id = object_id.split('-')[1];
				if (Object.keys(id)[0] == 'dep') {
					$('#from_city-' + substr_id).val(ui.item.city_id);
				}
				else {
					$('#to_city-' + substr_id).val(ui.item.city_id);
				}
			},
			open: function (event, ui) {
				$(this).autocomplete("widget").css({
					"width": document.getElementById(object_id).offsetWidth
				});
			},
			minLength: 3,
			change: function (event, ui) {
				var substr_id = object_id.substr(6);
				if (!ui.item) {
					$(this).val('');
					$('#from_city-' + substr_id).val("");
					$('#to_city-' + substr_id).val("");
					error_msg_alert('Please select Airport from the list!!');
					$(this).css('border', '1px solid red;');
					return;
				}
				if (($('#' + ids[0].dep).val() == $("#" + ids[1].arr).val()) && $('#' + ids[0].dep).val() != '' && $('#' + ids[1].arr).val() != '') {
					$(this).val('');
					$('#from_city-' + substr_id).val("");
					$('#to_city-' + substr_id).val("");
					$(this).css('border', '1px solid red;');
					error_msg_alert('Same Arrival and Boarding Airport Not Allowed!!');
				}

			}
		}).data("ui-autocomplete")._renderItem = function (ul, item) {
			return $("<li disabled>")
				.append("<a>" + item.value.split(" -")[1] + "<br><b>" + item.value.split(" -")[0] + "<b></a>")
				.appendTo(ul);
		}
	});
}

function generic_tax_reflect_temp(src_id, desc_id, funct_call) {
	var offset = src_id.split('-');

	desc_id = desc_id + '' + offset[1];

	generic_tax_reflect(src_id, desc_id, funct_call, src_id);
}

//**Generic service tax reflect start**//

function generic_tax_reflect(src_id, desc_id, funct_call, offset = '', temp_data = '') {
	var taxation_id = $('#' + src_id).val();

	$.post(base_url() + 'view/load_data/generic_tax_reflect.php', { taxation_id: taxation_id }, function (data) {
		$('#' + desc_id).val(data);

		if (temp_data != '') {
			window[funct_call](offset, temp_data);
		}
		else {
			if (funct_call != '') {
				if (offset == '') {
					window[funct_call]();
				}
				else {
					window[funct_call](offset);
				}
			}
		}
	});
}

//**Generic service tax reflect end**//
//**PHP to Javascript date converter**//
function php_to_js_date_converter(dateString1) {
	var get_new = dateString1.split('-');

	var day = get_new[0];

	var month = get_new[1];

	var year = get_new[2];

	var dateString = month + '/' + day + '/' + year;

	tagText = dateString.replace(/-/g, '/');

	var new_date = new Date(tagText);

	return new_date;
}

//**Trim characters**//

String.prototype.trimChars = function (chars) {
	var l = 0;

	var r = this.length - 1;

	while (chars.indexOf(this[l]) >= 0 && l < r) l++;

	while (chars.indexOf(this[r]) >= 0 && r >= l) r--;

	return this.substring(l, r + 1);
};

function printdiv(printpage, tbl_id) {
	$('#' + tbl_id).dataTable().fnDestroy();

	var headstr = '<html><head><title></title></head><body>';

	var footstr = '</body>';

	var newstr = document.all.item(printpage).innerHTML;

	var oldstr = document.body.innerHTML;

	document.body.innerHTML = headstr + newstr + footstr;

	window.print();

	document.body.innerHTML = oldstr;

	$('#' + tbl_id).dataTable();

	return false;
}

function check_pdf_size(pdf_size, url, url1) {
	var pdf_size = $('#' + pdf_size).val();

	if (pdf_size == 'A4 Full Size') {
		window.open(url, '_blank');
	}
	else {
		window.open(url1, '_blank');
	}
}
//Print
function loadOtherPage(url) {
	$('<iframe>').hide().attr('src', url).appendTo('body');
	window.location.href= url;
}

function check_package_type(setup_package, module_name) {
	var base_url = $('#base_url').val();
	if (module_name == 'user') {
		$.ajax({
			type: 'POST',
			url: base_url + 'view/package_permission/user_permission.php',
			data: {},
			async: false,
			success: function (data1) {
				$('#user_count').val(data1);
			}
		});
	}
	if (module_name == 'branch') {
		$.ajax({
			type: 'POST',
			url: base_url + 'view/package_permission/branch_permission.php',
			data: {},
			async: false,
			success: function (data1) {
				$('#branch_count').val(data1);
			}
		});
	}
}
function remove_hidden_class() {
	$('#package_permission').addClass('hidden');
}
function display_description(type, entry_id) {
	var base_url = $('#base_url').val();
	$.post(base_url + 'view/load_data/module_description_modal.php', { entry_id: entry_id, type: type }, function (
		data
	) {
		$('#div_content_modal').html(data);
	});
}

function select_all_check(id, custom_package) {
	var checked = $('#' + id).is(':checked');
	// Select all
	if (checked) {
		$('.' + custom_package).each(function () {
			$(this).prop('checked', true);
		});
	}
	else {
		// Deselect All
		$('.' + custom_package).each(function () {
			$(this).prop('checked', false);
		});
	}
}

function show_password(password) {
	var x = document.getElementById(password);
	if (x.type === 'password') {
		x.type = 'text';
	}
	else {
		x.type = 'password';
	}
}

function pagination_load(
	dataset,
	columns,
	bg_stat = false,
	footer_string = false,
	pg_length = 20,
	table_id = 'tbl_list'
) {
	//1. dataset,2.columns titles,3.if want bg color,4.if want footer,5.manual pagelength change
	var html = '';
	var dataset_main = JSON.parse(dataset);
	if (bg_stat) {
		var table_data = [];
		var bg = [];
		$.each(dataset_main, function (i, item) {
			table_data.push(dataset_main[i].data); //+ keeping different arrays for data and background color
			bg.push(dataset_main[i].bg);
		});
		table_data = JSON.parse(JSON.stringify(table_data));
	}
	else {
		var table_data = JSON.parse(dataset);
	}

	if (footer_string) {
		table_data.pop();
		if ($.trim($('#' + table_id + ' tfoot').html())) {
			document.getElementById(table_id).deleteTFoot();
		}
		for (var i = 0; i < parseInt(dataset_main[dataset_main.length - 1].footer_data['total_footers']); i++) {
			html +=
				'<th class="text-right ' +
				dataset_main[dataset_main.length - 1].footer_data['class' + i] +
				' " colspan=\'' +
				dataset_main[dataset_main.length - 1].footer_data['col' + i] +
				"'>" +
				dataset_main[dataset_main.length - 1].footer_data['foot' + i] +
				'</th>';
		}
		html = '<tfoot><tr>' + html + '</tr></tfoot>';
	}
	if ($.fn.DataTable.isDataTable('#' + table_id)) {
		$('#' + table_id).DataTable().clear().destroy(); // for managin error
	}
	var table = $('#' + table_id).DataTable({
		data: table_data,
		pageLength: pg_length,
		columns: columns,
		searching: true,
		// "scrollX": true,
		createdRow: function (row, data, dataIndex) {
			// adds bg color for every invalid point
			if (bg_stat) $(row).addClass(bg[dataIndex]);
			$(row.cells[1].childNodes[0]).labelauty({ label: false, maximum_width: '20px' });
		},
		initComplete: function (settings, json) {
			$("[data-toggle='tooltip']").tooltip({ placement: 'bottom' });
			$("[data-toggle='tooltip']").click(function () {
				$('.tooltip').remove();
			});
		},
		lengthMenu: [
			[
				10,
				20,
				30,
				-1
			],
			[
				'10',
				'20',
				'30',
				'Show all'
			]
		],
		buttons: [
			'pageLength'
		]
	});
	$('#' + table_id).append(html);
	return table;
}
function convert_date_to_db(date) {
	var parts = date.split('-');
	date = parts[2] + '-' + parts[1] + '-' + parts[0];
	return Date.parse(date);
}

function get_other_rules(travel_type, booking_date) {
	var cache_rules = JSON.parse($('#cache_data').val());

	var invoice_date = $('#' + booking_date).val();
	invoice_date = convert_date_to_db(invoice_date);

	var other_rules = cache_rules[0]['other_rules'];
	var service_charge_result = [];
	var markup_result = [];
	var commission_result = [];

	//Filter rules Eg. Rule for == 'Service charge', Travel type='Hotel&All', Validity='Permanent||Period(from-to date)' //Service charge rules
	service_charge_result = other_rules.filter((rule) => {
		var from_date = new Date(rule['from_date']).getTime();
		var to_date = new Date(rule['to_date']).getTime();
		return (
			rule['rule_for'] === '1' &&
			rule['status'] === 'Active' &&
			(rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&
			(rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))
		);
	});

	//Markup rules
	markup_result =
		other_rules &&
		other_rules.filter((rule) => {
			var from_date = new Date(rule['from_date']).getTime();
			var to_date = new Date(rule['to_date']).getTime();

			return (
				rule['rule_for'] === '2' &&
				rule['status'] === 'Active' &&
				(rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&
				(rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))
			);
		});

	//Commission rules
	commission_result = other_rules.filter((rule) => {
		var from_date = new Date(rule['from_date']).getTime();
		var to_date = new Date(rule['to_date']).getTime();

		return (
			rule['rule_for'] === '3' &&
			rule['status'] === 'Active' &&
			(rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&
			(rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))
		);
	});

	//Taxes
	var taxes = cache_rules[0]['taxes'];
	taxes = taxes.filter((tax) => {
		return tax['status'] === 'Active';
	});

	//Tax Rules
	var tax_rules = cache_rules[0]['tax_rules'];
	tax_rules = tax_rules.filter((rule) => {
		var from_date = new Date(rule['from_date']).getTime();
		var to_date = new Date(rule['to_date']).getTime();

		return (
			rule['status'] === 'Active' &&
			(rule['travel_type'] === travel_type || rule['travel_type'] === 'All') &&
			(rule['validity'] == 'Permanent' || (invoice_date >= from_date && invoice_date <= to_date))
		);
	});

	var result = service_charge_result.concat(markup_result, commission_result, taxes, tax_rules);
	return result;
}
function update_cache() {
	var base_url = $('#base_url').val();
	$.post(base_url + 'model/update_cache.php', {}, function (data) {
		$('#cache_data').val(data);
	});
}

function update_b2c_cache() {
	var b2c_flag = $('#b2c_flag').val();
	if(b2c_flag === '1'){
		var base_url = $('#base_url').val();
		$.post(base_url + 'model/update_b2c_cache.php', {}, function (data) {
			console.log(data);
			return false;
		});
	}
}
function get_identifier_block(identifier, payment_mode, credit_card_details, credit_charges) {

	var payment_mode = $('#' + payment_mode).val();
	if (payment_mode === 'Credit Card') {
		document.getElementById(identifier).classList.remove("hidden");
		document.getElementById("identifier").innerHTML = '';
		var select = document.getElementById("identifier");
		select.options[select.options.length] = new Option('Select Identifier', '');

		var cache_rules = JSON.parse($('#cache_data').val());
		var credit_card_company = cache_rules[0]['credit_card_data'];

		credit_card_company && credit_card_company.filter((data) => {

			var card_memberships = [];
			card_memberships = JSON.parse(JSON.parse(data['membership_details_arr']));
			card_memberships.forEach(function (membership_no) {

				var identifiers = membership_no['nos'];
				identifiers && identifiers.map((i) => {
					let i1 = i.substring(0, 4);
					select.options[select.options.length] = new Option(i1, i1);
				});
			});
		});
	}
	else {
		document.getElementById(identifier).classList.add("hidden");
		document.getElementById(credit_card_details).classList.add("hidden");
		document.getElementById(credit_charges).classList.add("hidden");
	}
	document.getElementById(identifier).value = '';
	document.getElementById(credit_card_details).value = '';
	document.getElementById(credit_charges).value = '';
}
function get_credit_card_data(identifier, payment_mode, credit_card_details) {

	var identifier = $('#' + identifier).val();
	var payment_mode = $('#' + payment_mode).val();
	var cache_rules = JSON.parse($('#cache_data').val());
	var credit_card_company = cache_rules[0]['credit_card_data'];

	var identifiers1 = '';
	credit_card_company && credit_card_company.filter((data) => {

		var card_memberships = [];
		card_memberships = JSON.parse(JSON.parse(data['membership_details_arr']));
		card_memberships.forEach(function (membership_no) {

			var identifiers = membership_no['nos'];
			identifiers && identifiers.map((i) => {
				let i1 = i.substring(0, 4);
				if (identifier === i1)
					identifiers1 = data['entry_id'] + '-' + data['company_name'] + ':' + membership_no['membership_no'] + ':' + i;
			});
		});
	});
	if (payment_mode === 'Credit Card') {

		if (identifiers1 !== '') {
			document.getElementById(credit_card_details).classList.remove("hidden");
			document.getElementById('credit_card_details').value = identifiers1;
		} else {
			document.getElementById(credit_card_details).value = '';
			document.getElementById(credit_card_details).classList.add("hidden");
		}
	} else {
		document.getElementById(credit_card_details).value = '';
		document.getElementById(credit_card_details).classList.add("hidden");
	}
}

function get_credit_card_charges(identifier, payment_mode, payment_amount, credit_card_details, credit_charges) {

	var credit_card_charges = $('#credit_card_charges').val();
	var payment_mode = $('#' + payment_mode).val();
	var payment_amount = $('#' + payment_amount).val();
	if (payment_mode === 'Credit Card') {
		var result = payment_amount * (credit_card_charges / 100);
		document.getElementById(credit_charges).classList.remove("hidden");
		result = parseFloat(result).toFixed(2);
		document.getElementById(credit_charges).value = result;
	} else {
		document.getElementById(credit_charges).value = '';
		document.getElementById(credit_charges).classList.add("hidden");
		document.getElementById(credit_card_details).value = '';
		document.getElementById(credit_card_details).classList.add("hidden");
		document.getElementById(identifier).value = '';
		document.getElementById(identifier).classList.add("hidden");
	}
}

function check_updated_amount(payment_old_value, payment_amount) {

	if (parseFloat(payment_old_value) !== parseFloat(payment_amount)) {
		if (payment_amount != 0) return false;
		else return true;
	} else {
		return true;
	}
}
function add_itinerary(dest_id1,spa,dwp,ovs,dayp){

	var base_url = $('#base_url').val();
	var dest_id = $('#'+dest_id1).val();
	if(dest_id == ''){
		error_msg_alert('Please select destination!');
		return false;
	}
	$.post(base_url + 'view/load_data/itinerary_modal.php', { dest_id: dest_id,spa:spa,dwp:dwp,ovs:ovs,dayp:dayp }, function (data) {
		$('#div_itinerary_modal').html(data);
	});
}
function get_dest_itinerary(dest_id1){

	var base_url = $('#base_url').val();
	var dest_id = $('#'+dest_id1).val();
	if(dest_id == '' || dest_id==0){
		error_msg_alert('Please select destination!');
		$('#itinerary_data').html('');
		return false;
	}
	$.post(base_url + 'view/load_data/get_itinerary_data.php', { dest_id: dest_id}, function (data) {
		$('#itinerary_data').html(data);
	});
}
function vehicle_save_modal(vehicle_name1) {
	var base_url = $('#base_url').val();
	$.post(
		base_url + 'view/load_data/vehicle_save.php',
		{vehicle_name_id:vehicle_name1 },
		function (data) {
			$('#vehicle_add_modal').html(data);
		}
	);
}