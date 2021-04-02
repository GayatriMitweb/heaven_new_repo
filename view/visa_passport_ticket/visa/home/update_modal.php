<?php 
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];
$visa_id = $_POST['visa_id'];

$sq_visa_info = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id='$visa_id'"));
$reflections = json_decode($sq_visa_info['reflections']);
?>
<div class="modal fade" id="visa_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="min-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Visa</h4>
      </div>
      <div class="modal-body">
	  <input type="hidden" id="booking_id" name="booking_id" value="<?= $visa_id ?>">
        <input type="hidden" id="hotel_sc" name="hotel_sc" value="<?php echo $reflections[0]->hotel_sc ?>">
        <input type="hidden" id="hotel_markup" name="hotel_markup" value="<?php echo $reflections[0]->hotel_markup ?>">
        <input type="hidden" id="hotel_taxes" name="hotel_taxes" value="<?php echo $reflections[0]->hotel_taxes ?>">
        <input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes" value="<?php echo $reflections[0]->hotel_markup_taxes ?>">
        <input type="hidden" id="hotel_tds" name="hotel_tds" value="<?php echo $reflections[0]->hotel_tds ?>">

      	<form id="frm_visa_update" name="frm_visa_save">

      		<input type="hidden" id="visa_id_hidden" name="visa_id_hidden" value="<?= $visa_id ?>">
        
	        <div class="panel panel-default panel-body fieldset">
	        	<legend>Customer Details</legend>

	        	<div class="row">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<select name="customer_id1" id="customer_id1" style="width:100%" onchange="customer_info_load('1')" disabled>
	        				<?php 
	        				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));
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
	                  <input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" readonly>
	                </div>	
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	                  <input type="text" id="mobile_no1" name="mobile_no1" placeholder="Mobile No" title="Mobile No" readonly>
	                </div>
	                <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	                  <input type="text" id="company_name1" class="hidden" name="company_name1" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
	                </div>       		        		        	
		        </div>
				<script>
					customer_info_load('1');
				</script>

			</div>	  
				

	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Passenger Details</legend>
				
				 <div class="row mg_bt_10">
	                <div class="col-xs-12 text-right text_center_xs">
	                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_visa_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
	                </div>
	            </div>    
	            
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_visa_update" name="tbl_dynamic_visa_update" class="table table-bordered no-marg" style="min-width:1500px">
	                       <?php 
	                       $offset = "_u";
	                       $sq_entry_count = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$visa_id'"));
	                       if($sq_entry_count==0){
	                       		include_once('visa_member_tbl.php');	
	                       }
	                       else{
	                       		$count = 0;
	                       		$bg="";
	                       		$sq_entry = mysql_query("select * from visa_master_entries where visa_id='$visa_id'");
	                       		while($row_entry = mysql_fetch_assoc($sq_entry)){
	                       			 if($row_entry['status']=='Cancel'){
						            	$bg="danger";
						            }else
						            {
						            	$bg="FFF";
						            }
	                       			$count++;
	                       			?>
									 <tr class="<?= $bg ?>">
									    <td><input class="css-checkbox" id="chk_visa<?= $offset.$count ?>_d" type="checkbox" checked disabled><label class="css-label" for="chk_visa<?= $offset ?>"> <label></td>
									    <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
									    <td><input type="text" id="first_name<?= $offset.$count ?>_d" onchange="fname_validate(this.id)" name="first_name<?= $offset.$count ?>_d" placeholder="First Name" title="First Name" value="<?= $row_entry['first_name'] ?>" /></td>
									    <td><input type="text" id="middle_name<?= $offset.$count ?>_d" name="middle_name<?= $offset.$count ?>_d" onchange="fname_validate(this.id)" placeholder="Middle Name" title="Middle Name" value="<?= $row_entry['middle_name'] ?>" /></td>
									    <td><input type="text" id="last_name<?= $offset.$count ?>_d" name="last_name<?= $offset.$count ?>_d" onchange="fname_validate(this.id)" placeholder="Last Name" title="Last Name" value="<?= $row_entry['last_name'] ?>" /></td>
									    <td><input type="text" id="birth_date<?= $offset.$count ?>_d" name="birth_date<?= $offset.$count ?>_d" placeholder="Birth Date" title="Birth Date" class="app_datepicker" onchange="adolescence_reflect(this.id)" value="<?= get_date_user($row_entry['birth_date']) ?>" /></td>
    									<td style="width:80px"><input type="text" id="adolescence<?= $offset.$count ?>_d" name="adolescence<?= $offset.$count ?>_d" placeholder="Adolescence" title="Adolescence" readonly value="<?= $row_entry['adolescence'] ?>" /></td>
									    <td><select name="visa_country_name<?= $offset ?>1" id="visa_country_name<?= $offset ?>1" title="Visa Country Name" style="width:150px" class="app_select2">
									            <option value="<?= $row_entry['visa_country_name'] ?>"><?= $row_entry['visa_country_name'] ?></option>
									            <?php 
									            $sq_country = mysql_query("select * from country_list_master");
									            while($row_country = mysql_fetch_assoc($sq_country)){
									                ?>
									                <option value="<?= $row_country['country_name'] ?>"><?= $row_country['country_name'] ?></option>
									                <?php
									            }
									            ?>
									        </select>
									    </td>
									    <td><select name="visa_type<?= $offset ?>1" id="visa_type<?= $offset ?>1" title="Visa Type">
									            <option value="<?= $row_entry['visa_type'] ?>"><?= $row_entry['visa_type'] ?></option>
									            <?php 
									            $sq_visa_type = mysql_query("select * from visa_type_master");
									            while($row_visa_type = mysql_fetch_assoc($sq_visa_type)){
									                ?>
									                <option value="<?= $row_visa_type['visa_type'] ?>"><?= $row_visa_type['visa_type'] ?></option>
									                <?php
									            }
									            ?>
									        </select>
									    </td>
									    <td><input type="text" id="passport_id<?= $offset.$count ?>_d" name="passport_id<?= $offset.$count ?>_d" placeholder="*Passport ID" title="Passport ID" value="<?= $row_entry['passport_id'] ?>" onchange="validate_passport(this.id);" style="text-transform: uppercase;" required/></td>
									    <td><input type="text" id="issue_date<?= $offset ?>1" name="issue_date<?= $offset ?>1" class="app_datepicker"  placeholder="Issue Date" title="Issue Date" value="<?= get_date_user($row_entry['issue_date']) ?>" onchange="checkPassportDate(this.id);"/></td>
									    <td><input type="text" id="expiry_date<?= $offset ?>1"  name="expiry_date<?= $offset ?>1" class="app_datepicker" placeholder="Expire Date" title="Expire Date" value="<?=  get_date_user($row_entry['expiry_date']) ?>" onchange="validate_issueDate('issue_date<?= $offset ?>1',this.id)"></td>
									    <td ><input type="text" id="nationality<?= $offset ?>1" name="nationality<?= $offset ?>1" onchange="validate_city(this.id)" placeholder="Nationality" title="Nationality" value="<?=  $row_entry['nationality'] ?>"/></td>

									    <?php 
									    $docs_arr = explode(',', $row_entry['received_documents']);

									    ?>
									    <td style="width:200px"><select name="received_documents" id="received_documents<?= $offset ?>1" multiple>

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

									            <?php $sel = (in_array("Passport Front", $docs_arr)) ? "selected" : "" ?>
									            <option value="Passport Front"<?= $sel ?>>Passport Front</option>

									            <?php $sel = (in_array("Passport Back", $docs_arr)) ? "selected" : "" ?>
									            <option value="Passport Back" <?= $sel ?>>Passport Back</option>

									            <?php $sel = (in_array("Photographs", $docs_arr)) ? "selected" : "" ?>
									            <option value="Photographs" <?= $sel ?>>Photographs</option>

									            <?php $sel = (in_array("Birth Certificate", $docs_arr)) ? "selected" : "" ?>
									            <option value="Birth Certificate" <?= $sel ?>>Birth Certificate</option>

									            <?php $sel = (in_array("Parent Employment Visa", $docs_arr)) ? "selected" : "" ?>
									            <option value="Parent Employment Visa" <?= $sel ?>>Parent Employment Visa</option>

									            <?php $sel = (in_array("Parent Passport", $docs_arr)) ? "selected" : "" ?>
									            <option value="Parent Passport" <?= $sel ?>>Parent Passport</option>
									    </select></td>
										<td><input type="text" id="appointment<?= $offset ?>1" name="appointment<?= $offset ?>1" class="app_datepicker"  placeholder="Appointment Date" title="Appointment Date" value="<?= get_date_user($row_entry['appointment_date']) ?>" onchange="validate_issueDate('issue_date<?= $offset ?>1',this.id)"></td>
									    <td class="hidden"><input type="text" value="<?= $row_entry['entry_id'] ?>"></td>
										<td><input type="hidden" id="visa_cost<?= $offset ?>1" name="visa_cost<?= $offset ?>1"></td>
    									<td><input type="hidden" id="visa_service_cost<?= $offset ?>1" name="visa_service_cost<?= $offset ?>1"></td>

									</tr>  
									<script>
										$("#birth_date<?= $offset.$count ?>_d, #issue_date<?= $offset ?>1, #expiry_date<?= $offset ?>1,#appointment<?= $offset ?>1").datetimepicker({ timepicker:false, format:'d-m-Y' });

    									$('#visa_country_name<?= $offset ?>1').select2();
 
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
$visa_issue_amount = $sq_visa_info['visa_issue_amount'];
$service_charge = $sq_visa_info['service_charge'];
$markup = $sq_visa_info['markup'];

$bsmValues = json_decode($sq_visa_info['bsm_values']);
$service_tax_amount = 0;
if($sq_visa_info['service_tax_subtotal'] !== 0.00 && ($sq_visa_info['service_tax_subtotal']) !== ''){
	$service_tax_subtotal1 = explode(',',$sq_visa_info['service_tax_subtotal']);
	for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
	  $service_tax = explode(':',$service_tax_subtotal1[$i]);
	  $service_tax_amount = $service_tax_amount + $service_tax[2];
	}
}
 $markupservice_tax_amount = 0;
    if($sq_visa_info['markup_tax'] !== 0.00 && $sq_visa_info['markup_tax'] !== ""){
      $service_tax_markup1 = explode(',',$sq_visa_info['markup_tax']);
      for($i=0;$i<sizeof($service_tax_markup1);$i++){
        $service_tax = explode(':',$service_tax_markup1[$i]);
        $markupservice_tax_amount = $markupservice_tax_amount+ $service_tax[2];
      }
	}
foreach($bsmValues[0] as $key => $value){
	switch($key){
		case 'basic' : $visa_issue_amount = ($value != "") ? $visa_issue_amount + $service_tax_amount : $visa_issue_amount;$inclusive_b = $value;break;
		case 'service' : $service_charge = ($value != "") ? $service_charge +  $service_tax_amount : $service_charge;$inclusive_s = $value;break;
		case 'markup' : $markup = ($value != "") ? $markup + $markupservice_tax_amount : $markup;$inclusive_m = $value;break;
	}
}
// echo "<pre>";
// var_dump($bsmValues)
?>
	        <div class="panel panel-default panel-body fieldset mg_tp_30">
	        	<legend>Costing Details</legend>

	        	<div class="row">	        		
		        	<div class="col-md-3 col-sm-6 col-xs-12">
						<small id="basic_show1" style="color:red"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
		        		<input type="text" id="visa_issue_amount1" name="visa_issue_amount1" placeholder="Amount" title="Amount" value="<?= $visa_issue_amount ?>" onchange="get_auto_values('balance_date1','visa_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge','discount1');validate_balance(this.id);calculate_total_amount('1')">
		        	</div>	
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="service_show1" style="color:red"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
		        		<input type="text" name="service_charge1" id="service_charge1" placeholder="Service Charge" title="Service Charge" value="<?= $service_charge ?>" onchange="validate_balance(this.id);get_auto_values('balance_date1','visa_issue_amount1','payment_mode','service_charge1','markup1','update','false','service_charge','discount')">
		        	</div>
		        	<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small>&nbsp;</small>
		        		<input type="text" name="service_tax_subtotal1" id="service_tax_subtotal1" placeholder="Tax Amount" title="Tax Amount" value="<?= $sq_visa_info['service_tax_subtotal'] ?>" onchange="validate_balance(this.id);" readonly>
		        	</div>		
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
						<small id="markup_show1" style="color:red"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
              			<input type="text" id="markup1" name="markup1" placeholder="Markup " title="Markup" onchange="validate_balance(this.id);get_auto_values('balance_date1','visa_issue_amount1','payment_mode','service_charge1','markup1','update','false','markup','discount1');" value="<?= $markup ?>">
            		</div>
            		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                		<input type="text" id="service_tax_markup1" name="service_tax_markup1" placeholder="*Tax on Markup" title="Tax on Markup" value="<?= $sq_visa_info['markup_tax'] ?>" readonly>
            		</div>
					<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" name="roundoff1" id="roundoff1" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $sq_visa_info['roundoff'] ?> " readonly>
            </div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="visa_total_cost1" id="visa_total_cost1"  class="amount_feild_highlight text-right" placeholder="Net Total" title="Net Total" value="<?= $sq_visa_info['visa_total_cost'] ?>" readonly>
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="due_date1" id="due_date1"  placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_visa_info['due_date'])?>">
	        		</div>
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	        			<input type="text" name="balance_date1" id="balance_date1" value="<?= date('d-m-Y',strtotime($sq_visa_info['created_at']))?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date1','visa_issue_amount1','payment_mode','service_charge1','markup1','update','false','markup','discount1',true);">
	        		</div>
	        	</div>
			</div>

	        <div class="row text-center">
	        	<div class="col-md-12">
	        		<button class="btn btn-sm btn-success" id="visa_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
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
$('#due_date1,#balance_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#birth_date1,#issue_date_u1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });

$('#visa_update_modal').modal('show');
//check future date
function checkPassportDate (id) {
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
        error_msg_alert(" Date cannot be future date");
      $('#'+id).css({'border':'1px solid red'});  
        document.getElementById(id).value="";
        $('#'+id).focus();
        g_validate_status = false;
      return false;		
	}
}

function validate_issueDate (from, to) {
	var from_date = $('#'+from).val(); 
    var to_date = $('#'+to).val(); 

    var parts = from_date.split('-');
    var date = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);

    var parts1 = to_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;

    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();

    if(from_date_ms>to_date_ms ){
      error_msg_alert(" Date should be greater than passport issue date");
      $('#'+to).css({'border':'1px solid red'});  
        document.getElementById(to).value="";
        $('#'+to).focus();
        g_validate_status = false;
      return false;
    } 
  }
$(function(){

$('#frm_visa_update').validate({
	rules:{
			customer_id1: { required: true},
			visa_issue_amount1: { required: true, number: true },
			service_charge1 :{ required : true, number:true },
			markup1 : {required : true , number : true},
			visa_total_cost1 :{ required : true, number:true },
			balance_date1 : { required : true },
			 
	},
	submitHandler:function(form){

		    var visa_id = $('#visa_id_hidden').val();
		    var customer_id = $('#customer_id1').val();
			var visa_issue_amount = $('#visa_issue_amount1').val();	
			var service_charge = $('#service_charge1').val();
			var service_tax_subtotal = $('#service_tax_subtotal1').val();
			var visa_total_cost = $('#visa_total_cost1').val();	
			var roundoff = $('#roundoff1').val();	
			var due_date1 = $('#due_date1').val();
			var balance_date1 = $('#balance_date1').val();
			var markup = $('#markup1').val();
			var service_tax_markup = $('#service_tax_markup1').val();

			var first_name_arr = new Array();
			var middle_name_arr = new Array();
			var last_name_arr = new Array();
			var birth_date_arr = new Array();
			var adolescence_arr = new Array();
			var visa_country_name_arr = new Array();
			var visa_type_arr = new Array();
			var passport_id_arr = new Array();
			var issue_date_arr = new Array();
			var expiry_date_arr = new Array();
			var nationality_arr = new Array();
			var received_documents_arr = new Array();
			var appointment_date_arr = new Array();
			var entry_id_arr = new Array();


	        var table = document.getElementById("tbl_dynamic_visa_update");
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

				  var first_name = row.cells[2].childNodes[0].value;
				  var middle_name = row.cells[3].childNodes[0].value;
				  var last_name = row.cells[4].childNodes[0].value;
				  var birth_date = row.cells[5].childNodes[0].value;
				  var adolescence = row.cells[6].childNodes[0].value;
				  var visa_country_name = row.cells[7].childNodes[0].value;
				  var visa_type = row.cells[8].childNodes[0].value;
				  var passport_id = row.cells[9].childNodes[0].value;
				  var issue_date = row.cells[10].childNodes[0].value;
				  var expiry_date = row.cells[11].childNodes[0].value;
				  var nationality = row.cells[12].childNodes[0].value;
				  var received_documents = "";
				  $(row.cells[13]).find('option:selected').each(function(){ received_documents += $(this).attr('value')+','; });
				  received_documents = received_documents.trimChars(",");
				  var apointment = row.cells[14].childNodes[0].value;
				  if(row.cells[15]){
				  	var entry_id = row.cells[15].childNodes[0].value;	
				  }
				  else{
				  	var entry_id = "";
				  }

	              var msg = "";
	              if(!isInArray(passport_id, passport_id_arr)){ msg +="Passport no duplicated in row:"+(i+1)+"<br>"; }
	              //if(php_to_js_date_converter(issue_date)>php_to_js_date_converter(expiry_date)){ msg +="Issue date greater in row:"+(i+1)+"<br>"; }

				  if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }
				  if(visa_country_name==""){ msg +="Visa Country name is required in row:"+(i+1)+"<br>"; }
				   if(passport_id==""){ msg +="Visa Country name is required in row:"+(i+1)+"<br>"; }
				  if(visa_type==""){ msg +="Visa Type is required in row:"+(i+1)+"<br>"; }
				  if(nationality==""){ msg +="Nationality is required in row:"+(i+1)+"<br>"; }
				 

	              if(msg!=""){
	                error_msg_alert(msg);
	                return false;
	              }

				  first_name_arr.push(first_name);
				  middle_name_arr.push(middle_name);
				  last_name_arr.push(last_name);
				  birth_date_arr.push(birth_date);
				  adolescence_arr.push(adolescence);
				  visa_country_name_arr.push(visa_country_name);
				  visa_type_arr.push(visa_type);
				  passport_id_arr.push(passport_id);
				  issue_date_arr.push(issue_date);
				  expiry_date_arr.push(expiry_date);
				  nationality_arr.push(nationality);
				  received_documents_arr.push(received_documents);
				  entry_id_arr.push(entry_id);	              
				  appointment_date_arr.push(apointment);
	          }      
	        }

			var hotel_sc = $('#hotel_sc').val();
			var hotel_markup = $('#hotel_markup').val();
			var hotel_taxes = $('#hotel_taxes').val();
			var hotel_markup_taxes = $('#hotel_markup_taxes').val();
			var hotel_tds = $('#hotel_tds').val();
			var reflections = [];
			reflections.push({
				'hotel_sc':hotel_sc,
				'hotel_markup':hotel_markup,
				'hotel_taxes':hotel_taxes,
				'hotel_markup_taxes':hotel_markup_taxes,
				'hotel_tds':hotel_tds
			});
			var bsmValues = [];
			bsmValues.push({
				"basic" : $('#basic_show1').find('span').text(),
				"service" : $('#service_show1').find('span').text(),
				"markup" : $('#markup_show1').find('span').text()
			});
			var base_url = $('#base_url').val();
			//Validation for booking and payment date in login financial year
			var check_date1 = $('#balance_date1').val();
			$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
				if(data !== 'valid'){
					error_msg_alert("The Booking date does not match between selected Financial year.");
					return false;
				}else{
					$('#visa_update').button('loading');
					$.ajax({
						type: 'post',
						url: base_url+'controller/visa_passport_ticket/visa/visa_master_update.php',
						data:{ visa_id : visa_id, customer_id : customer_id, visa_issue_amount : visa_issue_amount, service_charge : service_charge,  service_tax_subtotal : service_tax_subtotal, visa_total_cost : visa_total_cost, first_name_arr : first_name_arr, middle_name_arr : middle_name_arr, last_name_arr : last_name_arr, birth_date_arr : birth_date_arr, adolescence_arr : adolescence_arr, visa_country_name_arr : visa_country_name_arr, visa_type_arr : visa_type_arr, passport_id_arr : passport_id_arr, issue_date_arr : issue_date_arr, expiry_date_arr : expiry_date_arr, received_documents_arr : received_documents_arr, entry_id_arr : entry_id_arr, due_date1 : due_date1,balance_date1 : balance_date1 , nationality_arr : nationality_arr,appointment_date_arr:appointment_date_arr, markup : markup , service_tax_markup : service_tax_markup, reflections : reflections, bsmValues : bsmValues , roundoff :roundoff},
						success: function(result){
							var msg = result.split('-');
							if(msg[0]=='error'){
								msg_alert(result);
							}
							else{
								msg_alert(result);
								$('#visa_update').button('reset');
								reset_form('frm_visa_update');
								$('#visa_update_modal').modal('hide');	
								visa_customer_list_reflect();
							}
							
						}
					});
			}
		});
	}
});

});
function alltable_visa_cost(id){
	var table = document.getElementById(id);
	$('#visa_issue_amount1').val(0);
	$('#service_charge1').val(0);
	var rowCount = table.rows.length;
	var total_amt = 0, total_markup = 0;
	for(var i=0; i<rowCount; i++){
    	var row = table.rows[i];
    	if(row.cells[0].childNodes[0].checked == true){  
			var amt = row.cells[16].childNodes[0].value;
			total_amt += parseFloat(amt);
        }
	}
	if(isNaN(total_amt)) total_amt = 0;
	if(isNaN(total_markup)) total_markup = 0;
	$('#visa_issue_amount1').val(total_amt);$('#visa_issue_amount1').trigger('change');
	// $('#service_charge').val(total_markup);$('#service_charge').trigger('change');
}

function reflect_cost(id){
	var offset = id.substr(9);
	
	var visa_type = $('#visa_type'+offset).val(), visa_country = $('#visa_country_name'+offset).val();
	$.post('<?= BASE_URL?>view/visa_passport_ticket/visa/home/visa_cost_reflect.php', {visa_type : visa_type, visa_country : visa_country}, function(data){
		var json_data = JSON.parse(data);
		var amount = isNaN(parseFloat(json_data.amount)) ? 0.00 : parseFloat(json_data.amount);
		var service = isNaN(parseFloat(json_data.service)) ? 0.00 : parseFloat(json_data.service);
		$('#visa_cost'+offset).val(amount);
		// $('#visa_service_cost'+offset).val(service);

		alltable_visa_cost('tbl_dynamic_visa_update');
	});	
}
</script>