function visa_id_dropdown_load(customer_id_filter, visa_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var branch_status = $('#branch_status').val();
	$.post('visa_id_dropdown_load.php', { customer_id : customer_id , branch_status : branch_status}, function(data){
		$('#'+visa_id_filter).html(data);
	});
}

function generate_visa_payment_receipt(payment_id)
{
	url = 'payment/payment_receipt.php?payment_id='+payment_id;
	window.open(url, '_blank');
}

function cash_bank_receipt_generate()
{
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();

	$('input[name="chk_visa_payment"]:checked').each(function(){

		payment_id_arr.push($(this).val());

	});

	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	var base_url = $('#base_url').val();

	var url = base_url+"view/bank_receipts/miscellaneous_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}

function cheque_bank_receipt_generate(){
	var bank_name_reciept = $('#bank_name_reciept').val();
	var payment_id_arr = new Array();
	var branch_name_arr = new Array();

	$('input[name="chk_visa_payment"]:checked').each(function(){
		var id = $(this).attr('id');
		var offset = id.substring(17);
		var branch_name = $('#branch_name_'+offset).val();
		payment_id_arr.push($(this).val());
		branch_name_arr.push(branch_name);

	});
	if(payment_id_arr.length==0){
		error_msg_alert('Please select at least one payment to generate receipt!');
		return false;
	}

	$('input[name="chk_visa_payment"]:checked').each(function(){
		var id = $(this).attr('id');
		var offset = id.substring(17);
		var branch_name = $('#branch_name_'+offset).val();
		if(branch_name==""){
			error_msg_alert("Please enter branch name for selected payments!");	
			//return false;
			exit(0);
		}
	});

	var base_url = $('#base_url').val();
	var url = base_url+"view/bank_receipts/miscellaneous_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
	window.open(url, '_blank');
}