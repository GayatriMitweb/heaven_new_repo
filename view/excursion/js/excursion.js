function exc_id_dropdown_load(customer_id_filter, exc_id_filter)
{
  var customer_id = $('#'+customer_id_filter).val();
  var branch_status = $('#branch_status').val();
  $.post('exc_id_dropdown_load.php', { customer_id : customer_id , branch_status : branch_status}, function(data){
    $('#'+exc_id_filter).html(data);
  });
}
/**Excursion Name load**/
function get_excursion_list(id)
{
  var city_id = $("#"+id).val();
  var base_url = $('#base_url').val();

  var count = id.substring(10);
  $.post("inc/excursion_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#excursion-"+count).html(data);              
  } ) ;   
}


//Excursion Amounnt calculate
function excursion_amount_calculate(id,offset='')
{
  if(offset!=''){
    var table_name = 'tbl_dynamic_exc_booking_update';
  }
  else{
    var table_name = 'tbl_dynamic_exc_booking';
  }
  var table = document.getElementById(table_name);
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		if(row.cells[0].childNodes[0].checked){

			var total_adult = row.cells[6].childNodes[0].value;
			var total_children = row.cells[7].childNodes[0].value;
			var adult_cost = row.cells[8].childNodes[0].value;
			var child_cost = row.cells[9].childNodes[0].value;
			var total_amount = row.cells[10].childNodes[0].value;
      if(total_adult == ''){ total_adult = 0; }
      if(total_children == ''){ total_children = 0; }
      if(adult_cost == ''){ adult_cost = 0; }
      if(child_cost == ''){ child_cost = 0; }
      if(total_amount == ''){ total_amount = 0; }
      
      var total_adult_cost = parseFloat(total_adult) * parseFloat(adult_cost);
      var total_child_cost = parseFloat(total_children) * parseFloat(child_cost);
    
      total_cost = parseFloat(total_adult_cost) + parseFloat(total_child_cost);
      $("#"+row.cells[10].childNodes[0].id).val(total_cost.toFixed(2));
    }
  }
}

/**Excursion Amount load**/
function get_excursion_amount()
{
  var exc_date_arr = new Array();
	var exc_arr = new Array();
  var transfer_arr = new Array();
  
	var table = document.getElementById("tbl_dynamic_exc_booking");
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];
		// if(row.cells[0].childNodes[0].checked){

			var exc_date = row.cells[2].childNodes[0].value;
			var exc = row.cells[4].childNodes[0].value;
			var transfer = row.cells[5].childNodes[0].value;

			exc_date_arr.push(exc_date);
			exc_arr.push(exc);
			transfer_arr.push(transfer);

		// }
  }
  $.post("inc/excursion_amount_load.php" , { exc_date_arr : exc_date_arr,exc_arr:exc_arr,transfer_arr:transfer_arr} , function ( data ){
      var amount_arr = JSON.parse(data);
			for(var i=0; i<amount_arr.length; i++){

        var row = table.rows[i];
        row.cells[8].childNodes[0].value = amount_arr[i]['adult_cost'];
        row.cells[9].childNodes[0].value = amount_arr[i]['child_cost'];
        row.cells[10].childNodes[0].value = amount_arr[i]['total_cost'];
			}
      excursion_amount_calculate(row.cells[2].childNodes[0].id);
  });
}
function get_excursion_update_amount(eleid){

  var exc_date_arr = new Array();
	var exc_arr = new Array();
  var transfer_arr = new Array();
  var id = eleid.split('-');
  exc_date_arr.push($('#exc_date-'+id[1]).val());
  exc_arr.push($('#excursion-'+id[1]).val());
  transfer_arr.push($('#transfer_option-'+id[1]).val());

  $.post("inc/excursion_amount_load.php" , { exc_date_arr : exc_date_arr,exc_arr:exc_arr,transfer_arr:transfer_arr} , function ( data ){
    var amount_arr = JSON.parse(data); 
    $('#adult_cost-'+id[1]).val(amount_arr[0]['adult_cost']);
    $('#child_cost-'+id[1]).val(amount_arr[0]['child_cost']);
    $('#total_amount-'+id[1]).val(0);
    excursion_amount_calculate(eleid,'1');
    calculate_exc_expense('tbl_dynamic_exc_booking_update','1');
    get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');
  });

}
//cash reciept
function cash_bank_receipt_generate()
{
  var bank_name_reciept = $('#bank_name_reciept').val();
  var payment_id_arr = new Array();

  $('input[name="chk_exc_payment"]:checked').each(function(){

    payment_id_arr.push($(this).val());

  });

  if(payment_id_arr.length==0){
    error_msg_alert('Please select at least one payment to generate receipt!');
    return false;
  }

  var base_url = $('#base_url').val();

  var url = base_url+"view/bank_receipts/exc_payment/cash_bank_receipt.php?payment_id_arr="+payment_id_arr+'&bank_name_reciept='+bank_name_reciept;
  window.open(url, '_blank');
}

function cheque_bank_receipt_generate()
{
  var bank_name_reciept = $('#bank_name_reciept').val();
  var payment_id_arr = new Array();
  var branch_name_arr = new Array();

  $('input[name="chk_exc_payment"]:checked').each(function(){

    var id = $(this).attr('id');
    var offset = id.substring(16);
    var branch_name = $('#branch_name_'+offset).val();

    payment_id_arr.push($(this).val());
    branch_name_arr.push(branch_name);

  });

  if(payment_id_arr.length==0){
    error_msg_alert('Please select at least one payment to generate receipt!');
    return false;
  }

  $('input[name="chk_exc_payment"]:checked').each(function(){

    var id = $(this).attr('id');
    var offset = id.substring(16);
    var branch_name = $('#branch_name_'+offset).val();

    if(branch_name==""){
      error_msg_alert("Please enter branch name for selected payments!"); 
      exit(0);
    }

  });

  
  var base_url = $('#base_url').val();

  var url = base_url+"view/bank_receipts/exc_payment/cheque_bank_receipt.php?payment_id_arr="+payment_id_arr+'&branch_name_arr='+branch_name_arr+'&bank_name_reciept='+bank_name_reciept;
  window.open(url, '_blank');
}

///////Excursion amount calculate start/////////////////////////////////////////////////
function calculate_exc_expense(id,offset='')
{
  var table = document.getElementById(id);
  var rowCount = table.rows.length;
  var total_expense = 0;
  
  for(var i=0; i<rowCount; i++){

    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked == true){  

        var amt = row.cells[10].childNodes[0].value;
        if(!isNaN(amt)){

          if(amt == 0) { amt = 0; }
          total_expense = parseFloat(total_expense) + parseFloat(amt);;
        }
    }
  }  
  $('#exc_issue_amount'+offset).val(total_expense.toFixed(2));
}
///////Excursion amount calculate end/////////////////////////////////////////////////