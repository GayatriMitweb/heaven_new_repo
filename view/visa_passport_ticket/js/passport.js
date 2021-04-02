function passport_id_dropdown_load(customer_id_filter, passport_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var branch_status = $('#branch_status').val();
	$.post('passport_id_dropdown_load.php', { customer_id : customer_id, branch_status : branch_status }, function(data){
		$('#'+passport_id_filter).html(data);
	});
}

function generate_passport_payment_receipt(payment_id)
{
	url = 'payment/payment_receipt.php?payment_id='+payment_id;
	window.open(url, '_blank');
}

function cash_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_passport_payment"]:checked').each(function(){

		payment_id_arr.push($(this).val());

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/passport_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_passport_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(21);
		var branch_name = $('#branch_name_'+offset).val();

		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}
	$('input[name="chk_passport_payment"]:checked').each(function(){

		var id = $(this).attr('id');
		var offset = id.substring(21);
		var branch_name = $('#branch_name_'+offset).val();

		if(branch_name==""){
			error_msg_alert("Please enter branch name for selected payments!");				
			exit(0);
		}
	});

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/passport_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}
function whatsapp_send(emp_id, customer_id, booking_date, base_url){
	$.post(base_url+'controller/visa_passport_ticket/passport/whatsapp_send.php',{emp_id:emp_id,booking_date:booking_date ,customer_id:customer_id,booking_date:booking_date}, function(data){
		window.open(data);
	});
}
function whatsapp_send_r(booking_id, payment_amount, base_url){ // for receipt
	$.post(base_url+'controller/visa_passport_ticket/passport/receipt_whatsapp_send.php',{booking_id:booking_id, payment_amount:payment_amount}, function(data){
	window.open(data);
});
}