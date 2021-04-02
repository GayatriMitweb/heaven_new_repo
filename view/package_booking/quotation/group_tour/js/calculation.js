function get_auto_values(
	booking_date,
	sub_total,
	payment_mode,
	service_charge,
	markup,
	type,
	charges_flag,
	amount_type,
	discount,
	change
) {
	$('#service_show').html('&nbsp;');
	$('#service_show1').html('&nbsp;');
	$('#markup_show').html('&nbsp;');
	$('#markup_show1').html('&nbsp;');
	const rules = get_other_rules('Group Tour', booking_date);
	console.log(rules);
	var basic_amount = $('#' + sub_total).val();
	var payment_mode = $('#' + payment_mode).val();
	var markup_amount = $('#' + markup).val();
	var discount_amount = $('#' + discount).val();

	if (basic_amount === '') basic_amount = 0;
	if (markup_amount === '') markup_amount = 0;
	if (discount_amount === '' || discount_amount === undefined) discount_amount = 0;

	if (charges_flag === 'true') {
		var service_charge_result = rules && rules.filter((rule) => rule['rule_for'] === '1');
		var markup_amount_result = rules && rules.filter((rule) => rule['rule_for'] === '2');

		/////////////////Service charge Start/////////////////
		var rules_array = get_charges_on_conditions(service_charge_result, basic_amount, payment_mode, type);
		console.log(rules_array);

		if (parseInt(rules_array.length) === 0) {
			if ($('#' + service_charge).val() == '') $('#' + service_charge).val(parseInt(0).toFixed(2));
		}
		else {
			var service_charge1 = calculate_charges(rules_array, type, basic_amount, 0);
			service_charge1 =

				service_charge1 == '' ||
					typeof service_charge1 === NaN ||
					service_charge1 === undefined ? parseFloat(0).toFixed(2) :
					parseFloat(service_charge1).toFixed(2);
			// $('#' + service_charge).val(service_charge1);
			if (change && $('#' + service_charge).val() != service_charge1) {

				$('#vi_confirm_box').vi_confirm_box({
					message: "<span style='font-size:20px'>As per the Business rule Service Charge should be <b>" + service_charge1 + "</b> but the same has been altered by you with <b>" + $('#' + service_charge).val() + "</b> , Click on Yes to accept the Business Rule Service Charge.</span>",
					callback: function (result) {
						if (result == 'yes') {
							$('#' + service_charge).val(service_charge1);
							$('#' + service_charge).trigger('change');
						}
					}
				});
			} else {
				$('#' + service_charge).val(service_charge1);
			}

			$('#hotel_sc').val(rules_array[0].ledger_id);
		}
		if (rules_array.length && rules_array[0].type === 'Automatic')
			$('#' + service_charge).attr({ disabled: 'disabled' });
		else $('#' + service_charge).removeAttr('disabled');

		// console.log(service_charge1 + '----------------------');
		/////////////////Service charge End/////////////////

		/////////////////Markup Start///////////////////////
		var markup_amount_rules_array = get_charges_on_conditions(
			markup_amount_result,
			basic_amount,
			payment_mode,
			type
		);
		// console.log({markup_amount_rules_array});
		if (parseInt(markup_amount_rules_array.length) === 0) $('#' + markup).val(parseInt(0).toFixed(2));
		else {
			var markup_cost = calculate_charges(markup_amount_rules_array, type, basic_amount, markup_amount);
			markup_cost =

				markup_cost == '' || typeof markup_cost === NaN || markup_cost === undefined ? parseFloat(
					0
				).toFixed(2) :
					parseFloat(markup_cost).toFixed(2);
			// $('#' + markup).val(markup_cost);
			if (change && $('#' + markup).val() != markup_cost) {
				$('#markup_confirm').vi_confirm_box({
					message: "<span style='font-size:20px'>As per the Business rule Markup should be <b>" + markup_cost + "</b> but the same has been altered by you with <b>" + $('#' + markup).val() + "</b> , Click on Yes to accept the Business Rule Markup.</span>",
					callback: function (result) {
						if (result == 'yes') {
							$('#' + markup).val(markup_cost);
							$('#' + markup).trigger('change');
						}
					}
				});
			} else {
				$('#' + markup).val(markup_cost);
			}
			$('#hotel_markup').val(markup_amount_rules_array[0].ledger_id);
		}
		if (markup_amount_rules_array.length && markup_amount_rules_array[0].type === 'Automatic')
			$('#' + markup).attr({ disabled: 'disabled' });
		else $('#' + markup).removeAttr('disabled');
		/////////////////Markup End///////////////////////
	}
	/////////////////Tax Start///////////////////////
	var taxes_result =
		rules &&
		rules.filter((rule) => {
			var { entry_id, rule_id } = rule;
			return entry_id !== '' && !rule_id;
		});
	var tax_service_charge = $('#' + service_charge).val();
	var tax_markup = $('#' + markup).val();
	get_tax_rules(
		rules,
		taxes_result,
		basic_amount,
		sub_total,
		tax_markup,
		markup,
		tax_service_charge,
		service_charge,
		payment_mode,
		type,
		amount_type,
		discount_amount,
		charges_flag
	);
	/////////////////Tax End///////////////////////

	if (type === 'save') group_quotation_cost_calculate(sub_total);
	// else group_quotation_cost_calculate1(sub_total);
}

///////////////////////////////////// TAXES FUNCTIONS START /////////////////////////////////////////////
function get_tax_rules(
	rules,
	taxes_result,
	basic_amount,
	basic_amountid,
	markup,
	markupid,
	service_charge,
	service_chargeid,
	payment_mode,
	type,
	amount_type,
	discount,
	charges_flag
) {
	var final_taxes_rules = [];
	taxes_result &&
		taxes_result.filter((tax_rule) => {
			var tax_rule_array = [];
			rules &&
				rules.forEach((rule) => {
					if (parseInt(tax_rule['entry_id']) === parseInt(rule['entry_id']) && rule['rule_id'])
						tax_rule_array.push(rule);
				});
			final_taxes_rules.push({ entry_id: tax_rule['entry_id'], tax_rule_array });
		});

	var new_taxes_rules = get_tax_rules_on_conditions(final_taxes_rules, basic_amount, payment_mode, type);
	var tax_for = '';

	//service_charge////////////////////////////////////
	var other_charge_results = new_taxes_rules.filter((rule) => {
		return rule['target_amount'] !== 'Markup' && rule['target_amount'] !== 'Discount';
	});
	tax_for = 'service_charge';
	get_tax_charges(
		other_charge_results,
		taxes_result,
		basic_amount,
		basic_amountid,
		markup,
		markupid,
		service_charge,
		service_chargeid,
		payment_mode,
		type,
		amount_type,
		discount,
		tax_for
	);

	//markup/////////////////////////////////////////////
	var markup_results = new_taxes_rules.filter((rule) => {
		return rule['target_amount'] === 'Markup';
	});
	tax_for = 'markup';
	get_tax_charges(
		markup_results,
		taxes_result,
		basic_amount,
		basic_amountid,
		markup,
		markupid,
		service_charge,
		service_chargeid,
		payment_mode,
		type,
		amount_type,
		discount,
		tax_for
	);

	if (charges_flag === 'true') {
		//discount//////////////////////////////////////////
		var disc_results = new_taxes_rules.filter((rule) => {
			return rule['target_amount'] === 'Discount';
		});
		tax_for = 'discount';
		get_tax_charges(
			disc_results,
			taxes_result,
			basic_amount,
			basic_amountid,
			markup,
			markupid,
			service_charge,
			service_chargeid,
			payment_mode,
			type,
			amount_type,
			discount,
			tax_for
		);
	}
}

function get_tax_charges(
	new_taxes_rules,
	taxes_result,
	basic_amount,
	basic_amountid,
	markup,
	markupid,
	service_charge,
	service_chargeid,
	payment_mode,
	type,
	amount_type,
	discount,
	tax_for
) {
	var service_tax_subtotal = 'service_tax_subtotal';
	var service_tax_markup = 'service_tax_markup';
	var tds = 'tds';
	var discount_id = 'discount';

	var ledger_posting = '';
	var applied_taxes = '';
	var total_tax = 0;
	console.log(basic_amount + ' basic ');
	if (new_taxes_rules.length > 0) {
		new_taxes_rules &&
			new_taxes_rules.map((rule) => {
				var tax_data = taxes_result.find((entry_id_tax) => entry_id_tax['entry_id'] === rule['entry_id']);
				var { rate_in, rate } = tax_data;
				// rate = parseFloat(rate).toFixed(2);
				var { target_amount, ledger_id, calculation_mode, name } = rule;
				// target_amount = 'Service Charge','Basic','Total','Commission','Markup','Discount'
				// console.log(service_charge);
				if (target_amount === 'Service Charge') {
					var charge_amount = service_charge;
				}
				else if (target_amount === 'Basic') {
					var charge_amount = basic_amount;
				}
				else if (target_amount === 'Markup') {
					var charge_amount = markup;
				}
				else if (target_amount === 'Total') {

					var charge_amount = parseFloat(service_charge) + parseFloat(basic_amount);

				}
				else if (target_amount === 'Discount') {
					var charge_amount = discount;
				}
				else {
					var charge_amount = 0;
				}
				if (calculation_mode === '"Exclusive"') {
					if (rate_in === 'Percentage') {
						var rate_in_text = '%';
						var tax_amount = parseFloat(charge_amount) * parseFloat(rate) / 100;
					}
					else {
						var rate_in_text = '';
						var tax_amount = parseFloat(rate);
					}
				}
				else {
					if (rate_in === 'Percentage') {
						var rate_in_text = '%';
						var tax_rate = parseInt(100) + parseFloat(rate);
						var tax_amount =
							parseFloat(charge_amount) - parseFloat(charge_amount) / parseFloat(tax_rate) * 100;
					}
					else {
						var rate_in_text = '';
						var tax_amount = parseFloat(rate);
					}
					total_tax = parseFloat(total_tax) + parseFloat(tax_amount);
				}
				tax_amount =

					tax_amount !== '' || typeof tax_amount !== NaN || tax_amount !== undefined ? parseFloat(
						tax_amount
					).toFixed(2) :
						parseFloat(0).toFixed(2);

				var new_service_charge = parseFloat(charge_amount) - parseFloat(total_tax);
				new_service_charge =

					new_service_charge !== '' ||
						typeof new_service_charge !== NaN ||
						new_service_charge !== undefined ? parseFloat(new_service_charge).toFixed(2) :
						parseFloat(0).toFixed(2);

				console.log(target_amount + ' target');
				console.log(charge_amount);
				console.log(tax_amount);


				if (applied_taxes != '') {
					applied_taxes = applied_taxes + ', ' + name + ':(' + rate + rate_in_text + '):' + tax_amount;
					ledger_posting = ledger_posting + ',' + ledger_id;
				}
				else {
					applied_taxes += name + ':(' + rate + rate_in_text + '):' + tax_amount;
					ledger_posting += ledger_id;
				}
				if (calculation_mode == '"Inclusive"') {
					if (tax_for === 'service_charge') {
						if (target_amount === 'Service Charge') {
							// $('#' + service_chargeid).val(new_service_charge);
							$('#service_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
							$('#service_show1').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
						}
						else if (target_amount === 'Discount') {
							$('#' + discount_id).val(new_service_charge);
						}
						else if (target_amount === 'Markup') {
							// $('#' + markupid).val(new_service_charge);
							$('#markup_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
							$('#markup_show1').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
						}
						else if (target_amount === 'Basic') {
							// $('#' + basic_amountid).val(new_service_charge);
							$('#basic_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
							$('#basic_show1').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
						}
						$('#' + service_tax_subtotal).val(applied_taxes);
						$('#hotel_taxes').val(ledger_posting);
					}
					else if (tax_for === 'discount') {
						if (target_amount === 'Discount') {
							$('#' + discount_id).val(new_service_charge);
							$('#' + tds).val(tax_amount);
							$('#hotel_tds').val(ledger_posting);
						}
					}
					else if (tax_for === 'markup') {
						if (target_amount === 'Markup') {
							// $('#' + markupid).val(new_service_charge);
							$('#markup_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
							$('#markup_show1').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
							$('#' + service_tax_markup).val(applied_taxes);
							$('#hotel_markup_taxes').val(ledger_posting);
						}
					}
				}
				else {
					if (tax_for === 'service_charge') {
						if (target_amount === 'Service Charge') {
							$('#' + service_chargeid).val(new_service_charge);
							$('#service_show').html('&nbsp;');
							$('#service_show1').html('&nbsp;');
						}
						else if (target_amount === 'Discount') {
							$('#' + discount_id).val(new_service_charge);
						}
						else if (target_amount === 'Markup') {
							$('#' + markupid).val(new_service_charge);
							$('#markup_show').html('&nbsp;');
							$('#markup_show1').html('&nbsp;');
						}
						else if (target_amount === 'Basic') {
							$('#' + basic_amountid).val(new_service_charge);
							$('#basic_show').html('&nbsp;');
							$('#basic_show1').html('&nbsp;');
						}
						$('#' + service_tax_subtotal).val(applied_taxes);
						$('#hotel_taxes').val(ledger_posting);
					}
					else if (tax_for === 'discount') {
						if (target_amount === 'Discount') {
							$('#' + discount_id).val(new_service_charge);
							$('#' + tds).val(tax_amount);
							$('#hotel_tds').val(ledger_posting);
						}
					}
					else if (tax_for === 'markup') {
						if (target_amount === 'Markup') {
							$('#' + markupid).val(new_service_charge);
							$('#markup_show').html('&nbsp;');
							$('#markup_show1').html('&nbsp;');
							$('#' + service_tax_markup).val(applied_taxes);
							$('#hotel_markup_taxes').val(ledger_posting);
						}
					}
				}
				// console.log(applied_taxes);
			});
	}
	else {
		if (tax_for === 'service_charge') {
			$('#' + service_tax_subtotal).val('');
			$('#hotel_taxes').val('');
		}
		else if (tax_for === 'markup') {
			$('#' + service_tax_markup).val('');
			$('#hotel_markup_taxes').val('');
		}
		else if (tax_for === 'discount') {
			$('#' + tds).val('');
			$('#hotel_tds').val('');
		}
	}
}
function get_tax_rules_on_conditions(final_taxes_rules, basic_amount, payment_mode, type) {
	let applied_rules = [];

	final_taxes_rules &&
		final_taxes_rules.map((tax) => {
			var entry_id_rules = tax['tax_rule_array'];
			var flag = false;
			var conditions_flag_array = [];
			entry_id_rules &&
				entry_id_rules.forEach((rule) => {
					var condition = JSON.parse(rule['conditions']);
					if (rule['applicableOn'] == '1') return;
					condition &&
						condition.forEach((cond) => {
							var condition = cond.condition;
							var for1 = cond.for1;

							var value = cond.value;
							var amount = cond.amount;
							//Conditions- '1-Place of supply','2-Routing','3-Payment Mode','4-Target Amount','5-Supplier','6-Customer Type','7-Customer','8-Product','9-Fee Type'
							rule['name'] = 'TAX';
							switch (condition) {
								case '1':
									var place_flag = null;
									place_flag_array = [];
									switch (for1) {
										case '!=':
											place_flag = true;

											break;
										case '==':
											place_flag = false;
											break;
										default:
											place_flag = false;
											break;
									}

									flag = place_flag;

									break;
								case '2':
									var routing_flag = null;
									var routing_flag1 = null;
									routing_flag_array = [];
									switch (for1) {
										case '!=':
											place_flag = true;
											rule['name'] = 'GST';
											break;
										case '==':
											place_flag = false;
											break;
										default:
											place_flag = false;
											break;
									}

									flag = routing_flag1;

									break;

								case '8':
									if (value == 'Group' || value == 'All') flag = true;
									break;
								case '3':
									switch (for1) {
										case '!=':
											if (payment_mode != value) flag = true;
											break;
										case '==':
											if (payment_mode === value) flag = true;
											break;
									}
									break;

								case '4':
									switch (for1) {
										case '<':
											flag = parseFloat(basic_amount) < parseFloat(amount);
											break;
										case '<=':
											flag = parseFloat(basic_amount) <= parseFloat(amount);
											break;
										case '>':
											flag = parseFloat(basic_amount) > parseFloat(amount);
											break;
										case '>=':
											flag = parseFloat(basic_amount) >= parseFloat(amount);
											break;
										case '!=':
											flag = parseFloat(basic_amount) != parseFloat(amount);
											break;
										case '==':
											flag = parseFloat(basic_amount) === parseFloat(amount);
											break;
									}
									break;

								default:
									flag = false;
									break;
							}
							conditions_flag_array.push(flag);
						});
					// console.log(rule['rule_id'] + '-' + conditions_flag_array);
					if (!conditions_flag_array.includes(false)) applied_rules.push(rule);
				});
		});
	return applied_rules;
}
//////////////////////////// TAXES FUNCTIONS END //////////////////////////////////////////

function get_charges_on_conditions(service_charge_result, basic_amount, payment_mode, type) {
	//console.log(service_charge_result);
	let rules_array =
		service_charge_result &&
		service_charge_result.filter((rule) => {
			var cond = JSON.parse(rule['conditions']);
			var conditions_flag_array = [];
			var flag = false;
			cond &&
				cond.forEach((item) => {
					if (type === 'save') {
						var customer = $('#customer_id').val();
					}
					else {
						var customer = $('#customer_id1').val();
					}
					var condition = item.condition;
					var for1 = item.for1;
					var value = item.value;
					var amount = item.amount;

					//conditions-'2-Routing','11-Price','5-Supplier','8-Product','12-Airline','13-Transaction Type','14-Booking Cabin','15-Service(Itinerary)','10-Supplier Type','3-Payment Mode','7-Customer','6-Customer Type','16-Reissue'
					switch (condition) {
						case '2':
							var booking_type = $('#booking_type').val();
							var supplier_flag = false;
							switch (for1) {
								case '!=':
									if (booking_type !== value || booking_type === '') supplier_flag = true;
									else supplier_flag = false;
									break;
								case '==':
									if (booking_type === value || booking_type === '') supplier_flag = true;
									else supplier_flag = false;
									break;
								default:
									supplier_flag = false;
							}
							flag = supplier_flag;
							break;
						case '11':
							switch (for1) {
								case '<':
									flag = parseFloat(basic_amount) < parseFloat(amount);
									break;
								case '<=':
									flag = parseFloat(basic_amount) <= parseFloat(amount);
									break;
								case '>':
									flag = parseFloat(basic_amount) > parseFloat(amount);
									break;
								case '>=':
									flag = parseFloat(basic_amount) >= parseFloat(amount);
									break;
								case '!=':
									flag = parseFloat(basic_amount) != parseFloat(amount);
									break;
								case '==':
									flag = parseFloat(basic_amount) === parseFloat(amount);
									break;
							}
							break;
						case '5':
							var supplier_flag = null;
							var supplier_flag1 = null;
							supplier_flag_array = [];
							if (hotel_ids) {
								$.ajax({
									async: false,
									type: 'POST',
									global: false,
									dataType: 'html',
									url: '../booking/booking/inc/get_supplier.php',
									data: { hotel_ids: hotel_ids },
									success: (data) => {
										data = data.split(',');
										data &&
											data.forEach((hotel) => {
												switch (for1) {
													case '!=':
														if (hotel !== value || hotel === '') supplier_flag = true;
														else supplier_flag = false;
														break;
													case '==':
														if (hotel === value || hotel === '') supplier_flag = true;
														else supplier_flag = false;
														break;
													default:
														supplier_flag = false;
												}
												supplier_flag_array.push(supplier_flag);
											});
										if (supplier_flag_array.includes(false)) supplier_flag1 = false;
										else supplier_flag1 = true;
									}
								});
								flag = supplier_flag1;
							}
							else flag = false;
							break;
						case '8':
							if (value == 'Group' || value == 'All') flag = true;
							break;
						case '12':
							flag = false;
							break;
						case '13':
							if (value == 'Sale') flag = true;
							break;
						case '14':
							flag = false;
							break;
						case '15':
							flag = false;
							break;
						case '10':
							if (value == 'Group' || value == 'All') flag = true;
							break;
						case '3':
							switch (for1) {
								case '!=':
									if (payment_mode != value) flag = true;
									break;
								case '==':
									if (payment_mode === value) flag = true;
									break;
							}
							break;
						case '7':
							var customer_flag = null;
							if (customer !== 0 && customer !== '') {
								$.ajax({
									async: false,
									type: 'POST',
									global: false,
									dataType: 'html',
									url: '../booking/booking/inc/get_customer.php',
									data: { customer: customer },
									success: function (data) {
										data = data.split('-');
										switch (for1) {
											case '!=':
												if (data[1] !== value || data[1] === '') customer_flag = true;
												else customer_flag = false;
												break;
											case '==':
												if (data[1] === value || data[1] === '') customer_flag = true;
												else customer_flag = false;
												break;
										}
									}
								});
								flag = customer_flag;
							}
							else {
								flag = false;
							}
							break;
						case '6':
							var customer_type_flag = null;
							if (customer !== '0' && customer !== '') {
								$.ajax({
									async: false,
									type: 'POST',
									global: false,
									dataType: 'html',
									url: '../booking/booking/inc/get_customer.php',
									data: { customer: customer },
									success: function (data) {
										data = data.split('-');
										switch (for1) {
											case '!=':
												if (data[0] !== value || data[0] === '') customer_type_flag = true;
												else customer_type_flag = false;
												break;
											case '==':
												if (data[0] === value || data[0] === '') customer_type_flag = true;
												else customer_type_flag = false;
												break;
										}
									}
								});
								flag = customer_type_flag;
							}
							else {
								flag = false;
							}
							break;
						case '16':
							flag = false;
							break;
						default:
							flag = false;
							break;
					}
					conditions_flag_array.push(flag);
				});
			// console.log(rule.rule_id+'-'+conditions_flag_array);
			if (conditions_flag_array.includes(false)) return null;
			else {
				return rule;
			}
		});
	var final_rule = get_final_rule(rules_array);
	return final_rule;
}

function get_final_rule(rules_array) {
	if (rules_array && (rules_array.length === 1 || rules_array.length === 0)) return rules_array;
	else {
		// Only one valid rule is there
		var conditional_rule =
			rules_array &&
			rules_array.filter((rule) => {
				if (rule['conditions']) {
					return rule;
				}
				return null;
			});
		if (conditional_rule && (conditional_rule.length === 0 || conditional_rule.length === 1))
			return conditional_rule;
		else {
			// If only one Conditional rule is there
			var customer_condition_rules =
				conditional_rule &&
				conditional_rule.filter((rule) => {
					var cond = JSON.parse(rule['conditions']);
					return cond && cond.includes((obj) => obj.conditions === '7');
				});
			if (customer_condition_rules && customer_condition_rules.length === 1) return customer_condition_rules;
			else {
				// If only one 'Customer' Conditional rule is there
				var sorted_array = conditional_rule.sort((a, b) => a.rule_id - b.rule_id);
				var latest_arr = [];
				latest_arr.push(sorted_array[sorted_array.length - 1]);
				return latest_arr; // Return latest rule
			}
		}
	}
}

function calculate_charges(rules_array, type, basic_amount, markup_amount1) {
	console.log(basic_amount + ' basic Amount');
	if (rules_array.length) {
		var apply_on = rules_array[0].apply_on;

		if (rules_array[0].target_amount != '') {
			if (rules_array[0].target_amount === 'Basic') var target_amount = basic_amount;
			else if (rules_array[0].target_amount === 'Total')
				var target_amount = parseFloat(basic_amount) + parseFloat(markup_amount1);
		}
		else var target_amount = 0;

		if (type === 'save') {
			var adults = $('#total_adult').val();
			var children_with_bed = $('#children_with_bed').val();
			var children_without_bed = $('#children_without_bed').val();

			if (children_with_bed == '') children_with_bed = 0;
			if (children_without_bed == '') children_without_bed = 0;

			var child = parseFloat(children_without_bed) + parseFloat(children_with_bed);
			var hotel_table = 'tbl_package_tour_quotation_dynamic_costing';
		}
		else {
			var adults = $('#total_adult1').val();
			var children_with_bed = $('#children_with_bed1').val();
			var children_without_bed = $('#children_without_bed1').val();

			if (children_with_bed == '') children_with_bed = 0;
			if (children_without_bed == '') children_without_bed = 0;

			var child = parseFloat(children_without_bed) + parseFloat(children_with_bed);
		}

		switch (apply_on) {
			case '1':
				//Per pax
				adults =

					adults === '' ? 0 :
						adults;
				child =

					child === '' ? 0 :
						child;

				var service_fee =

					rules_array[0].fee_type === 'Flat' ? parseFloat(rules_array[0].fee) *
						(parseInt(adults) + parseInt(child)) :
						parseFloat(target_amount) *
						parseFloat(rules_array[0].fee) /
						100 *
						(parseInt(adults) + parseInt(child));
				return service_fee;
				break;
			case '2':
				//Per Invoice
				var service_fee =

					rules_array[0].fee_type === 'Flat' ? parseFloat(rules_array[0].fee) :
						parseFloat(target_amount) * parseFloat(rules_array[0].fee) / 100;
				return service_fee;
				break;
		}
	}
}
