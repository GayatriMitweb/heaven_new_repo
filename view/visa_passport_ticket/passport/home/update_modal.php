<?php 
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];
$passport_id = $_POST['passport_id'];

$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
$reflections = json_decode($sq_passport_info['reflections']);
?>
 <input type="hidden" id="passport_sc" name="passport_sc" value="<?php echo $reflections[0]->passport_sc ?>">
 <input type="hidden" id="passport_taxes" name="passport_taxes" value="<?php echo $reflections[0]->passport_taxes ?>">

<div class="modal fade" id="passport_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update passport</h4>
      </div>
      <div class="modal-body">

      	<form id="frm_passport_update" name="frm_passport_save">

      		<input type="hidden" id="passport_id_hidden" name="passport_id_hidden" value="<?= $passport_id ?>">
        
	        <div class="panel panel-default panel-body fieldset">
	        	<legend>Customer Details</legend>

	        	<div class="row">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<select name="customer_id1" id="customer_id1" title="Customer Name" onchange="customer_info_load('1')" style="width:100%" disabled>
	        				<?php 
	        				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));
	        				if($sq_customer['type']=='Corporate'){
	        				?>
	        					<option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
	        				<?php }  else{ ?>
	        					<option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	        				<?php } ?>
	        				<?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
	        			</select>
	        		</div>
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	                  <input type="text" id="mobile_no1" name="mobile_no1" placeholder="Mobile No" title="Mobile No" readonly>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	                  <input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" readonly>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	                  <input type="text" id="company_name1" class="hidden" name="company_name1" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
	                </div> 	
	                <script>
						customer_info_load('1');
					</script>        		        		        		        	   		
		        </div>
	        </div>	

	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Passenger Details</legend>
				
				 <div class="row mg_bt_10">
	                <div class="col-xs-12 text-right text_center_xs">
	                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_passport_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Row</button>
	                </div>
	            </div>    
	            
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_passport_update" name="tbl_dynamic_passport_update" class="table table-bordered no-marg" style="width:1100px">
	                       <?php 
	                       $offset = "_u";
	                       $sq_entry_count = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$passport_id'"));
	                       if($sq_entry_count==0){
	                       		include_once('passport_member_tbl.php');	
	                       }
	                       else{
	                       		$count = 0;
	                       		$sq_entry = mysql_query("select * from passport_master_entries where passport_id='$passport_id'");
	                       		while($row_entry = mysql_fetch_assoc($sq_entry)){
	                       			$count++;
	                       			?>
									 <tr>
									    <td><input class="css-checkbox" id="chk_passport<?= $offset.$count ?>_d" type="checkbox" checked onclick="get_auto_values('balance_date1','passport_issue_amount1','payment_mode1','service_charge1','update','true','service_charge')" disabled><label class="css-label" for="chk_passport<?= $offset ?>" > <label></td>
									    <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
									    <td><select name="honorific" id="honorific1" title="Honorific">
									        <option value="<?= $row_entry['honorific'] ?>"><?= $row_entry['honorific'] ?></option>
									        <?php get_hnorifi_dropdown(); ?>
									    </select></td>
									    <td><input type="text" id="first_name<?= $offset.$count ?>_d" name="first_name<?= $offset.$count ?>_d" onchange="fname_validate(this.id);" placeholder="*First Name" title="First Name" value="<?= $row_entry['first_name'] ?>" /></td>
									    <td><input type="text" id="middle_name<?= $offset.$count ?>_d" onchange="fname_validate(this.id);" name="middle_name<?= $offset.$count ?>_d" placeholder="Middle Name" title="Middle Name" value="<?= $row_entry['middle_name'] ?>" /></td>
									    <td><input type="text" onchange="fname_validate(this.id);" id="last_name<?= $offset.$count ?>_d" name="last_name<?= $offset.$count ?>_d" placeholder="Last Name" title="Last Name" value="<?= $row_entry['last_name'] ?>" /></td>
									    <td><input type="text"  id="birth_date<?= $offset.$count ?>_d" name="birth_date<?= $offset.$count ?>_d" class="app_datepicker" placeholder="*Birth Date" title="Birth Date" value="<?= get_date_user($row_entry['birth_date']) ?>" onchange="adolescence_reflect(this.id)" /></td>
									    <td style="width:80px"><input type="text" id="adolescence<?= $offset.$count ?>_d" name="adolescence<?= $offset.$count ?>_d" placeholder="Adolescence" onchange="get_auto_values('balance_date1','passport_issue_amount1','payment_mode','service_charge1','update','true','service_charge')" title="Adolescence" disabled value="<?= $row_entry['adolescence'] ?>" /></td>
									    <td style="width:200px"><select name="received_documents" id="received_documents<?= $offset.$count ?>1" title="Document" multiple>

												<?php 
											    $docs_arr = explode(',', $row_entry['received_documents']);
											    ?>
									            <?php $sel = (in_array("Aadhaar Card", $docs_arr)) ? "selected" : "" ?>
									            <option value="Aadhaar Card" <?= $sel ?>>Aadhaar Card</option>
									            
									            <?php $sel = (in_array("Driving Licence", $docs_arr)) ? "selected" : "" ?>
									            <option value="Driving Licence" <?= $sel ?>>Driving Licence</option>

									            <?php $sel = (in_array("Pan Card", $docs_arr)) ? "selected" : "" ?>
									            <option value="Pan Card" <?= $sel ?>>Pan Card</option>

									            <?php $sel = (in_array("Voter Identity Card", $docs_arr)) ? "selected" : "" ?>
									            <option value="Voter Identity Card" <?= $sel ?>>Voter Identity Card</option>

									            <?php $sel = (in_array("PassPort", $docs_arr)) ? "selected" : "" ?>
									            <option value="PassPort" <?= $sel ?>>PassPort</option>

									            <?php $sel = (in_array("Telephone Bill", $docs_arr)) ? "selected" : "" ?>
									            <option value="Telephone Bill" <?= $sel ?>>Telephone Bill</option>

									            <?php $sel = (in_array("Electricity Bill", $docs_arr)) ? "selected" : "" ?>
									            <option value="Electricity Bill" <?= $sel ?>>Electricity Bill</option>

									            <?php $sel = (in_array("Ration Card", $docs_arr)) ? "selected" : "" ?>
									            <option value="Ration Card" <?= $sel ?>>Ration Card</option>

									            <?php $sel = (in_array("Bank Passbook", $docs_arr)) ? "selected" : "" ?>
									            <option value="Bank Passbook" <?= $sel ?>>Bank Passbook</option>

									            <?php $sel = (in_array("Bank Statement", $docs_arr)) ? "selected" : "" ?>
									            <option value="Bank Statement" <?= $sel ?>>Bank Statement</option>

									            <?php $sel = (in_array("Employer Letter", $docs_arr)) ? "selected" : "" ?>
									            <option value="Employer Letter" <?= $sel ?>>Employer Letter</option>

									            <?php $sel = (in_array("Employer Invitation", $docs_arr)) ? "selected" : "" ?>
									            <option value="Employer Invitation" <?= $sel ?>>Employer Invitation</option>
									    </select></td>
										<td><input type="text" id="appointment<?= $offset ?>_d" name="appointment<?= $offset ?>1" class="app_datepicker" value="<?= get_date_user($row_entry['appointment_date']) ?>"  placeholder="Appointment Date" title="Appointment Date" ></td>
									    <td class="hidden"><input type="text" value="<?= $row_entry['entry_id'] ?>"></td>
									</tr>    
									<script>
									$("#birth_date<?= $offset.$count ?>_d,#appointment<?= $offset ?>_d").datetimepicker({ timepicker:false, format:'d-m-Y' });
									</script>    
	                       			<?php

	                       		}

	                       }
	                       ?>
	                    </table>
	                    </div>
	                </div>
	            </div>        

	        </div> 
			<?php
				$passport_issue_amount1 = $sq_passport_info['passport_issue_amount'];
				$service_charge = $sq_passport_info['service_charge'];

				$bsmValues = json_decode($sq_passport_info['bsm_values']);
				$service_tax_amount = 0;
				if($sq_passport_info['service_tax_subtotal'] !== 0.00 && ($sq_passport_info['service_tax_subtotal']) !== ''){
					$service_tax_subtotal1 = explode(',',$sq_passport_info['service_tax_subtotal']);
					for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
						$service_tax = explode(':',$service_tax_subtotal1[$i]);
						$service_tax_amount = $service_tax_amount + $service_tax[2];
					}
				}
				foreach($bsmValues[0] as $key => $value){
					switch($key){
						case 'basic' : $passport_issue_amount1 = ($value != "") ? $passport_issue_amount1 + $service_tax_amount : $passport_issue_amount1;$inclusive_b = $value;break;
						case 'service' : $service_charge = ($value != "") ? $service_charge + $service_tax_amount : $service_charge;$inclusive_s = $value;
					}
				}
				$readonly = ($inclusive_d != '') ? 'readonly' : '';
        	?>
	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Costing Details</legend>

	        	<div class="row">
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="basic_show1"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
		        		<input type="text" id="passport_issue_amount1" name="passport_issue_amount1" placeholder="Amount" title="Amount" value="<?= $passport_issue_amount1 ?>" onchange="calculate_total_amount('1');validate_balance(this.id);get_auto_values('balance_date1','passport_issue_amount1','payment_mode','service_charge1','update','true','service_charge',true);">
		        	</div>
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="service_show1"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
		        		<input type="text" name="service_charge1" id="service_charge1" placeholder="Service Charge" title="Service Charge" value="<?= $service_charge ?>" onchange="calculate_total_amount('1');validate_balance(this.id);get_auto_values('balance_date1','passport_issue_amount1','payment_mode','service_charge1','update','false','service_charge');">
		        	</div>		  		
		              		
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<small>&nbsp;</small>
				        <input type="text" id="service_tax_subtotal1" name="service_tax_subtotal1" value="<?= $sq_passport_info['service_tax_subtotal'] ?>" placeholder="Tax Amount" title="Tax Amount" readonly>
	        		</div>
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
					<small>&nbsp;</small>
                		<input type="text" name="roundoff1" id="roundoff1" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $sq_passport_info['roundoff'] ?> " readonly>
            		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<input type="text" name="passport_total_cost1" id="passport_total_cost1" class="amount_feild_highlight text-right" placeholder="Net Total " title="Net Total" value="<?= $sq_passport_info['passport_total_cost'] ?>" readonly>
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12">
	        			<input type="text" name="due_date1" id="due_date1" placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_passport_info['due_date']) ?>">
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12">
	        			<input type="text" name="balance_date1" id="balance_date1" placeholder="Booking Date" title="Booking Date" value="<?= get_date_user($sq_passport_info['created_at']) ?>" onchange="check_valid_date(this.id);get_auto_values('balance_date1','passport_issue_amount1','payment_mode','service_charge1','update','true','service_charge',true);">
	        		</div>
	        	</div>
	        </div> 

	        <div class="row text-center">
	        	<div class="col-xs-12">
	        		<button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
	        	</div>
	        </div>
        </form>
      </div>  
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#customer_id1').select2();
$('#birth_date_u1,#due_date1,#balance_date1,#appointment1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#passport_update_modal').modal('show');

$(function(){

$('#frm_passport_update').validate({
	rules:{
			customer_id1: { required: true},
			passport_issue_amount1: { required: true, number: true },
			service_charge1 :{ required : true, number:true },
			passport_total_cost1 :{ required : true, number:true },
			balance_date1 : { required : true },
			birth_date1 : { required : true },
			received_documents1 : { required : true },
			 
			
	},
	submitHandler:function(form){

		    var passport_id = $('#passport_id_hidden').val();
		    var customer_id = $('#customer_id1').val();
			var passport_issue_amount = $('#passport_issue_amount1').val();
			var service_charge = $('#service_charge1').val();
			var service_tax_subtotal = $('#service_tax_subtotal1').val();
			var passport_total_cost = $('#passport_total_cost1').val();
			var due_date1 = $('#due_date1').val();	
			var balance_date1 = $('#balance_date1').val();
			var passport_sc = $('#passport_sc').val();
      		var passport_taxes = $('#passport_taxes').val();
      		var reflections = [];
      		reflections.push({
      		  'passport_sc':passport_sc,	
      		  'passport_taxes':passport_taxes,	  
			  });
			var bsmValues = [];
				bsmValues.push({
				"basic" : $('#basic_show1').find('span').text(),
				"service" : $('#service_show1').find('span').text(),
        	});
			var roundoff = $('#roundoff1').val();
			var honorific_arr = new Array();
			var first_name_arr = new Array();
			var middle_name_arr = new Array();
			var last_name_arr = new Array();
			var birth_date_arr = new Array();
			var adolescence_arr = new Array();
			var received_documents_arr = new Array();
			var appointment_date_arr = new Array();
			var entry_id_arr = new Array();


	        var table = document.getElementById("tbl_dynamic_passport_update");
	        var rowCount = table.rows.length;
	        
	        for(var i=0; i<rowCount; i++)
	        {
	          var row = table.rows[i];
	           
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
				  if(row.cells[10]){
				  	var entry_id = row.cells[10].childNodes[0].value;
				  }
				  else{
				  	var entry_id = "";
				  }

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
				  entry_id_arr.push(entry_id);          
				  appointment_date_arr.push(appointment);
	          }      
	        }

			var base_url = $('#base_url').val();
			//Validation for booking and payment date in login financial year
			var check_date1 = $('#balance_date1').val();
			$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
				if(data !== 'valid'){
					error_msg_alert("The Booking date does not match between selected Financial year.");
					return false;
				}else{
					$.ajax({
						type: 'post',
						url: base_url+'controller/visa_passport_ticket/passport/passport_master_update.php',
						data:{ passport_id : passport_id, customer_id : customer_id, passport_issue_amount : passport_issue_amount, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal, passport_total_cost : passport_total_cost, honorific_arr : honorific_arr, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, birth_date_arr : birth_date_arr, adolescence_arr : adolescence_arr, received_documents_arr : received_documents_arr, entry_id_arr : entry_id_arr,appointment_date_arr:appointment_date_arr,due_date1 : due_date1,balance_date1 : balance_date1,roundoff : roundoff, reflections : reflections, bsmValues : bsmValues },
						success: function(result){
							var msg = result.split('-');
							if(msg[0]=='error'){
								msg_alert(result);
							}
							else{
								msg_alert(result);
								reset_form('frm_passport_update');
								$('#customer_id1').val('').trigger('change');
								$('#passport_update_modal').modal('hide');	
								window.location.reload();
								passport_customer_list_reflect();
							}
							
						}
					});
				}
			});
	}
});

});
</script>