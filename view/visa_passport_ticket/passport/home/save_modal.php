<?php
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/passport/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="passport_sc" name="passport_sc">
<input type="hidden" id="passport_taxes" name="passport_taxes">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
<div class="modal fade" id="passport_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New passport</h4>
      </div>
      <div class="modal-body">

      	<form id="frm_passport_save" name="frm_passport_save">
        
	        <div class="panel panel-default panel-body fieldset">
	        	<legend>Customer Details</legend>

	        	<div class="row">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load();get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','service_charge');">
	        				<?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
	        			</select>
	        		</div>
	        		<div id="new_cust_div"></div>
	        		<div id="cust_details">	     
	        		 <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	                  <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>
	                </div>	
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	                  <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	                  <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
	                </div>
	                <div class="col-md-3 col-sm-4 col-xs-12">
	                  <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
	                </div> 
	        	</div>	
	        	</div>  
				<div class="row mg_tp_10">
					<div class="col-md-3 col-sm-4 col-xs-12">
	                  <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
	                </div>
				</div>    
				<div class="row mg_tp_10">
					<div class="col-md-4">
						<input id="copy_details1" name="copy_details1" type="checkbox" onClick="copy_details();">
				&nbsp;&nbsp;<label for="copy_details1">Passenger Details same as above</label>
					</div>
				</div>        	

	        </div>

	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Passenger Details</legend>
				
				 <div class="row mg_bt_10">
	                <div class="col-xs-12 text-right text_center_xs">
	                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_passport')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
	                    <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_passport')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
	                </div>
	            </div>    
	            
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_passport" name="tbl_dynamic_passport" class="table table-bordered no-marg" style="width:1100px">
	                       <?php include_once('passport_member_tbl.php'); ?>                        
	                    </table>
	                    </div>
	                </div>
	            </div>
	        </div>

	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Costing Details</legend>

	        	<div class="row mg_bt_10">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="basic_show">&nbsp;</small>
		        		<input type="text" id="passport_issue_amount" name="passport_issue_amount" placeholder="*Amount" title="Amount" onchange="calculate_total_amount();validate_balance(this.id);get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','basic');">
		        	</div>  
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="service_show">&nbsp;</small>
		        		<input type="text" name="service_charge" id="service_charge" placeholder="*Service Charge" title="Service Charge" onchange="validate_balance(this.id);get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','false','service_charge')">
		        	</div>       		
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
				        <input type="text" id="service_tax_subtotal" class="text-right" name="service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly>
	        		</div>
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
                		<input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" readonly>
            		</div> 
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="passport_total_cost" id="passport_total_cost" class="amount_feild_highlight text-right" placeholder="*Net Total" title="Net Total" readonly>
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="due_date" id="due_date" placeholder="Due Date" title="Due Date" value="<?= date('d-m-Y') ?>">
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="balance_date" id="balance_date" value="<?= date('d-m-Y') ?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','service_charge',true);">
	        		</div>
	        	</div>

	        </div>

	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Advance Details</legend>
				
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y');?>" onchange="check_valid_date(this.id)">
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<select name="payment_mode" id="payment_mode" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','service_charge',true);get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
							<?php get_payment_mode_dropdown(); ?>
						</select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');validate_balance(this.id)">
					</div>
				</div>
				<div class="row mg_bt_10">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
						><option value=''>Select Identifier</option></select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
					</div>
				</div>
				<div class="row mg_bt_10">				
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="text" id="bank_name" name="bank_name" class="bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="text" id="transaction_id"  onchange="validate_specialChar(this.id)" name="transaction_id" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<select name="bank_id" id="bank_id" title="Bank ID" disabled>
							<?php get_bank_dropdown(); ?>
						</select>
					</div>
				</div>
		        <div class="row">
					<div class="col-md-9 col-sm-9">
					<span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
					</div>
		        </div>

	        </div>

	        <div class="row text-center">
	        	<div class="col-xs-12">
	        		<button id="btn_passport_master_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	        	</div>
	        </div>
		</form>

    </div>  
    </div>
</div>
</div>


<script>
$('#customer_id').select2();
var date = new Date();
var yest = date.setDate(date.getDate()-1);
$('#birth_date1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });
$('#payment_date,#due_date,#balance_date,#appointment1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){

$('#frm_passport_save').validate({
	rules:{
			customer_id: { required: true },
			passport_issue_amount: { required: true, number: true },
			service_charge :{ required : true, number:true },
			passport_total_cost :{ required : true, number:true },
			balance_date : { required : true},
			payment_date : { required : true },
			payment_amount : { required : true, number: true },
			payment_mode : { required : true },
			bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
            transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
            bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
	},
	submitHandler:function(form)
	{
	var base_url = $('#base_url').val();
	var customer_id = $('#customer_id').val();
	var cust_first_name = $('#cust_first_name').val();
	var cust_middle_name = $('#cust_middle_name').val();
	var cust_last_name = $('#cust_last_name').val();
	var gender = $('#cust_gender').val();
	var cust_birth_date = $('#cust_birth_date').val();
	var age = $('#cust_age').val();
	var contact_no = $('#cust_contact_no').val();
	var email_id = $('#cust_email_id').val();
	var address = $('#cust_address1').val();
	var address2 = $('#cust_address2').val();
	var city = $('#city').val();
	var service_tax_no = $('#cust_service_tax_no').val();  
	var landline_no = $('#cust_landline_no').val();
	var alt_email_id = $('#cust_alt_email_id').val();
	var company_name = $('#corpo_company_name').val();
	var cust_type = $('#cust_type').val();
	var country_code = $('#country_code').val();
	var state = $('#cust_state').val();
	var branch_admin_id = $('#branch_admin_id1').val();
	var financial_year_id = $('#financial_year_id').val();
	var credit_charges = $('#credit_charges').val();
	var credit_card_details = $('#credit_card_details').val();
	var active_flag = 'Active';
	
	//New Customer save
	if(customer_id == '0'){
		$.ajax({
			type: 'post',
			url: base_url+'controller/customer_master/customer_save.php',
			data:{ first_name : cust_first_name, middle_name : cust_middle_name, last_name : cust_last_name, gender : gender, birth_date : cust_birth_date, age : age, contact_no : contact_no, email_id : email_id, address : address,address2 : address2,city:city,  active_flag : active_flag ,service_tax_no : service_tax_no, landline_no : landline_no, alt_email_id : alt_email_id,company_name : company_name, cust_type : cust_type,state : state, branch_admin_id : branch_admin_id , country_code : country_code},
			success: function(result){
			}
		});
	}

	var emp_id = $('#emp_id').val();
	var passport_issue_amount = $('#passport_issue_amount').val();
	var service_charge = $('#service_charge').val();
	var service_tax_subtotal = $('#service_tax_subtotal').val();
	var passport_total_cost = $('#passport_total_cost').val();
	var payment_date = $('#payment_date').val();
	var payment_amount = $('#payment_amount').val();
	var payment_mode = $('#payment_mode').val();
	var bank_name = $('#bank_name').val();
	var transaction_id = $('#transaction_id').val();
	var bank_id = $('#bank_id').val();
	var due_date = $('#due_date').val();
	var balance_date = $('#balance_date').val();
	var credit_amount = $('#credit_amount').val();
	var roundoff = $('#roundoff').val();

	var passport_sc = $('#passport_sc').val();
    var passport_taxes = $('#passport_taxes').val();
	var reflections = [];
    reflections.push({
	'passport_sc':passport_sc,
	'passport_taxes':passport_taxes,
	});
	var bsmValues = [];
    bsmValues.push({
		"basic" : $('#basic_show').find('span').text(),
		"service" : $('#service_show').find('span').text(),
    });
	var honorific_arr = new Array();
	var first_name_arr = new Array();
	var middle_name_arr = new Array();
	var last_name_arr = new Array();
	var birth_date_arr = new Array();
	var adolescence_arr = new Array();
	var received_documents_arr = new Array();
	var appointment_date_arr = new Array();
	if(payment_mode == 'Credit Note' && credit_amount != ''){ 
		if(parseFloat(payment_amount) > parseFloat(credit_amount)) { error_msg_alert('Low Credit note balance'); return false; }
	}
	
	var table = document.getElementById("tbl_dynamic_passport");
	var rowCount = table.rows.length;
	
	for(var i=0; i<rowCount; i++)
	{
		var row = table.rows[i];
		if(rowCount == 1){
		if(!row.cells[0].childNodes[0].checked){
			error_msg_alert("Atleast one passenger is required!");
			return false;
		}
		} 	
		if(row.cells[0].childNodes[0].checked)
		{

			var honorific = row.cells[2].childNodes[0].value;
			var first_name = row.cells[3].childNodes[0].value;
			var middle_name = row.cells[4].childNodes[0].value;
			var last_name = row.cells[5].childNodes[0].value;
			var birth_date = row.cells[6].childNodes[0].value;
			var adolescence = row.cells[7].childNodes[0].value;
			var received_documents = "";
			$(row.cells[8]).find('option:selected').each(function(){ received_documents += $(this).attr('value')+','; });
			received_documents = received_documents.trimChars(",");
			var appointment = row.cells[9].childNodes[0].value;
			var msg = "";
			if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }
			if(birth_date==""){ msg +="Birth Date is required in row:"+(i+1)+"<br>"; }
			if(received_documents==""){ msg +="Received documents are required in row:"+(i+1)+"<br>"; }

			if(msg!=""){
			error_msg_alert(msg);
			return false;
			}

			honorific_arr.push(honorific);
			first_name_arr.push(first_name);
			middle_name_arr.push(middle_name);
			last_name_arr.push(last_name);
			birth_date_arr.push(birth_date);
			adolescence_arr.push(adolescence);
			received_documents_arr.push(received_documents);
			appointment_date_arr.push(appointment);
		}
	}

	//Validation for booking and payment date in login financial year
	var check_date1 = $('#balance_date').val();
		$('#btn_passport_master_save').button('loading');
		$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
			if(data !== 'valid'){
				error_msg_alert("The Booking date does not match between selected Financial year.");
				return false;
				$('#btn_passport_master_save').button('reset');
			}else{
				var payment_date = $('#payment_date').val();
				$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
				if(data !== 'valid'){
					error_msg_alert("The Payment date does not match between selected Financial year.");
					return false;
					$('#btn_passport_master_save').button('reset');
				}else{
			$('#btn_passport_master_save').button('loading');
			if($('#whatsapp_switch').val() == "on") whatsapp_send(emp_id, customer_id, balance_date, base_url);
					$.ajax({
						type: 'post',
						url: base_url+'controller/visa_passport_ticket/passport/passport_master_save.php',
						data:{ customer_id : customer_id, passport_issue_amount : passport_issue_amount, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal, passport_total_cost : passport_total_cost, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, honorific_arr : honorific_arr, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, birth_date_arr : birth_date_arr, adolescence_arr : adolescence_arr, received_documents_arr : received_documents_arr,appointment_date_arr:appointment_date_arr, bank_id : bank_id, due_date : due_date,emp_id : emp_id, balance_date : balance_date, branch_admin_id : branch_admin_id,financial_year_id :financial_year_id, roundoff : roundoff, reflections : reflections, bsmValues : bsmValues,credit_charges:credit_charges,credit_card_details:credit_card_details},
						success: function(result){
							$('#btn_passport_master_save').button('reset');
							var msg = result.split('-');
							if(msg[0]=='error'){
								msg_alert(result);
							}
							else{
								msg_alert(result);
								$('#passport_save_modal').modal('hide');
								reset_form('frm_passport_save');	
								// window.location.reload();
								passport_customer_list_reflect();
							}
							
						}
					});
					}
				});
			}
		});
	}
});

});
</script>