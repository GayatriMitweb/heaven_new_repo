function get_bank_info(bank_id)
{
	var bank_id = $('#'+bank_id).val();
  	var branch_admin_id = $('#branch_admin_id1').val();
	$.post('report_reflect/bank_reconcilation/get_pending_cheque.php',{  bank_id : bank_id,branch_admin_id : branch_admin_id  }, function(data){
		$('#pending_cheque_div').html(data);
	});
}

function cal_reconcl_amount(){
	var txt_system_bank = $('#txt_system_bank').val();
	var total_r_amount = $('#total_r_amount').val();
	var total_p_amount = $('#total_p_amount').val();
	var total_d_amount = $('#total_d_amount').val();
	var total_c_amount = $('#total_c_amount').val();
	var txt_bank_book = $('#txt_bank_book').val();

	if(txt_system_bank == '0'|| typeof txt_system_bank == 'undefined' || txt_system_bank == ''){ txt_system_bank = 0; }
	if(total_r_amount == '0' || typeof total_r_amount == 'undefined'  || total_r_amount == ''){ total_r_amount = 0; }
	if(total_p_amount == '0' || typeof total_p_amount == 'undefined' || total_p_amount == ''){ total_p_amount = 0; }
	if(total_d_amount == '0'|| typeof total_d_amount == 'undefined' || total_d_amount == ''){ total_d_amount = 0; }
	if(total_c_amount == '0'|| typeof total_c_amount == 'undefined' || total_c_amount == ''){ total_c_amount = 0; }
	if(txt_bank_book == '0' || typeof txt_bank_book == 'undefined' || txt_bank_book == ''){ txt_bank_book = 0; }
	
	var reconcl_amount = parseFloat(txt_system_bank) - parseFloat(total_r_amount) + parseFloat(total_p_amount) - parseFloat(total_d_amount) + parseFloat(total_c_amount);
	var diff_amount = parseFloat(reconcl_amount) - parseFloat(txt_bank_book);

	reconcl_amount = parseFloat(reconcl_amount);
	diff_amount = parseFloat(diff_amount);

	$('#reconcl_amount').val(reconcl_amount.toFixed(2));
	$('#txt_rec_diff').val(diff_amount.toFixed(2));

}
function cal_bank_dc_amount(table_id,result_id){
	var r_amount = 0;
	var table = document.getElementById(table_id);
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
      var row = table.rows[i];
      if(row.cells[0].childNodes[0].checked)
      {  
          var amount = row.cells[4].childNodes[0].value;
          if(amount == ''){ amount = 0; }
          var r_amount = parseFloat(r_amount) + parseFloat(amount);
          
      }

     }
	total_amount = parseFloat(r_amount);
	$('#'+result_id).val(total_amount.toFixed(2));
	cal_reconcl_amount();
}

function get_total_receipt_pending(amount){
	var r_amount = $('#total_r_amount').val();
	if(r_amount == ''){ r_amount = 0; }

	var total_amount = parseFloat(r_amount) + parseFloat(amount);
	total_amount = parseFloat(total_amount);
	$('#total_r_amount').val(total_amount.toFixed(2));
	cal_reconcl_amount();
}

function get_total_payment_pending(amount){
	var r_amount = $('#total_p_amount').val();
	if(r_amount == ''){ r_amount = 0; }

	var total_amount = parseFloat(r_amount) + parseFloat(amount);
	total_amount = parseFloat(total_amount);
	$('#total_p_amount').val(total_amount.toFixed(2));
	cal_reconcl_amount();
}
