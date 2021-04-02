<?php 
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];
$exc_id = $_POST['exc_id'];

$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$exc_id'"));
$reflections = json_decode($sq_exc_info['reflections']);
?>
<div class="modal fade" id="exc_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="min-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Activity</h4>
      </div>
      <div class="modal-body">

      	<form id="frm_exc_update" name="frm_exc_save">
		  <input type="hidden" id="booking_id" name="booking_id" value="<?= $exc_id ?>">
			<input type="hidden" id="act_sc" name="act_sc" value="<?php echo $reflections[0]->act_sc ?>">
			<input type="hidden" id="act_markup" name="act_markup" value="<?php echo $reflections[0]->act_markup ?>">
			<input type="hidden" id="act_taxes" name="act_taxes" value="<?php echo $reflections[0]->act_taxes ?>">
			<input type="hidden" id="act_markup_taxes" name="act_markup_taxes" value="<?php echo $reflections[0]->act_markup_taxes ?>">

      		<input type="hidden" id="exc_id_hidden" name="exc_id_hidden" value="<?= $exc_id ?>">
        
	        <div class="panel panel-default panel-body app_panel_style feildset-panel">
	        	<legend>Customer Details</legend>

	        	<div class="row">
	        		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	        			<select name="customer_id1" id="customer_id1" style="width:100%" onchange="customer_info_load('1')" disabled>
	        				<?php 
	        				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_info[customer_id]'"));
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
				

	        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
	        	<legend>Excursion Details</legend>
				
				 <div class="row mg_bt_10">
	                <div class="col-xs-12 text-right text_center_xs">
	                    <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_exc_booking_update')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
	                </div>
	            </div>    
	            
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="table-responsive">
	                    <?php $offset = ""; ?>
	                    <table id="tbl_dynamic_exc_booking_update" name="tbl_dynamic_exc_booking_update" class="table table-bordered no-marg pd_bt_51">
	                       <?php 
	                       $offset = "_u";
	                       $sq_entry_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$exc_id'"));
	                       if($sq_entry_count==0){
	                       		include_once('exc_member_tbl.php');	
	                       }
	                       else{
							$count = 0;
							$bg="";
							$sq_entry = mysql_query("select * from excursion_master_entries where exc_id='$exc_id'");
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
								 <td><input class="css-checkbox" id="chk_exc<?= $offset.$count?>" onchange="excursion_amount_calculate('exc_date-<?= $offset.$count ?>','1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1');" type="checkbox" checked><label class="css-label" for="chk_exc<?=  $count ?>"><label></td>
								 <td><input maxlength="15" value="<?=  $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
								 <td><input type="text" id="exc_date-<?= $offset.$count ?>" name="exc_date-<?= $offset.$count ?>" placeholder="Activity Date & Time" title="Activity Date & Time" class="app_datetimepicker form-control" value="<?php echo get_datetime_user($row_entry['exc_date']); ?>" onchange="get_excursion_update_amount(this.id)"></td>
								 <td><select id="city_name-<?= $offset.$count ?>" class="app_select2 form-control" name="city_name-<?= $offset.$count ?>" title="City Name" onchange="get_excursion_list(this.id);">
									 <?php
										   $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'")); ?>
										   <option value="<?php echo $sq_city['city_id'] ?>" selected="selected"><?php echo $sq_city['city_name'] ?></option>
									 <?php
										   $sq_city = mysql_query("select * from city_master where 1");
									 while($row_city = mysql_fetch_assoc($sq_city)){ ?>
										   <option value="<?php echo $row_city['city_id'] ?>"><?php echo $row_city['city_name'] ?></option>
									 <?php } ?>
									 </select>
								 </td>
								 <td><select id="excursion-<?= $offset.$count ?>" class="app_select2 form-control" title="Activity Name" name="excursion-<?= $offset.$count ?>" onchange="get_excursion_update_amount(this.id);">
								 <?php
										   $sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_entry[exc_name]'")); ?>
										   <option value="<?php echo $sq_exc['entry_id'] ?>"><?php echo $sq_exc['excursion_name'] ?></option>
									 <option value="">*Excursion Name</option>                                      
								 </select></td>
								 <td><select name="transfer_option-<?= $offset.$count ?>" id="transfer_option-<?= $offset.$count ?>" data-toggle="tooltip" class="form-control app_select2" title="Transfer Option" style="width:150px" onchange="get_excursion_update_amount(this.id);">
									 <option value="<?php echo $row_entry['transfer_option'] ?>"><?php echo $row_entry['transfer_option'] ?></option>
									 <option value="">*Transfer Option</option>
									 <option value="Without Transfer">Without Transfer</option>
									 <option value="Sharing Transfer">Sharing Transfer</option>
									 <option value="Private Transfer">Private Transfer</option>
									 <option value="SIC">SIC</option>
									 </select></td>
								 <td><input type="text" id="total_adult-<?= $offset.$count ?>" name="total_adult-<?= $offset.$count ?>" placeholder="*Total Adult" title="Total Adult" value="<?php echo $row_entry['total_adult'] ?>" onchange="excursion_amount_calculate(this.id,'1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1'); validate_balance(this.id);get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');"></td>
								 <td><input type="text" id="total_children-<?= $offset.$count ?>" name="total_children-<?= $offset.$count ?>" placeholder="*Total Child" title="Total Child" value="<?php echo $row_entry['total_child'] ?>" onchange="excursion_amount_calculate(this.id,'1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1'); validate_balance(this.id);get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');"></td>
								 <td><input type="text" id="adult_cost-<?= $offset.$count ?>" name="adult_cost-<?= $offset.$count ?>" placeholder="Adult Cost" title="Adult Cost" value="<?php echo $row_entry['adult_cost'] ?>" onchange="excursion_amount_calculate(this.id,'1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1'); validate_balance(this.id);"></td>
								 <td><input type="text" id="child_cost-<?= $offset.$count ?>" name="child_cost-<?= $offset.$count ?>" placeholder="Child Cost" title="Child Cost" value="<?php echo $row_entry['child_cost'] ?>" onchange="excursion_amount_calculate(this.id,'1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1'); validate_balance(this.id);"> </td>
								 <td><input type="text" id="total_amount-<?= $offset.$count ?>" name="total_amount-<?= $offset.$count ?>" placeholder="Total Amount" title="Excursion Amount" value="<?php echo $row_entry['total_cost'] ?>" onchange="validate_balance(this.id);excursion_amount_calculate(this.id,'1');calculate_exc_expense('tbl_dynamic_exc_booking_update','1');"></td>
								 <td><input type="hidden" value="<?= $row_entry['entry_id'] ?>"></td>
							 </tr>  
							 <script>
								 $("#exc_date-<?= $offset.$count?>").datetimepicker({ format:'d-m-Y H:i' });
								 $("#city_name-<?= $offset.$count?>").select2();
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
$visa_issue_amount = $sq_exc_info['exc_issue_amount'];
$service_charge = $sq_exc_info['service_charge'];
$markup = $sq_exc_info['markup'];

$bsmValues = json_decode($sq_exc_info['bsm_values']);
$service_tax_amount = 0;
if($sq_exc_info['service_tax_subtotal'] !== 0.00 && ($sq_exc_info['service_tax_subtotal']) !== ''){
	$service_tax_subtotal1 = explode(',',$sq_exc_info['service_tax_subtotal']);
	for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount = $service_tax_amount + $service_tax[2];
	}
}
$markupservice_tax_amount = 0;
if($sq_exc_info['service_tax_markup'] !== 0.00 && $sq_exc_info['service_tax_markup'] !== ""){
	$service_tax_markup1 = explode(',',$sq_exc_info['service_tax_markup']);
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
?>
<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
	<legend>Costing Details</legend>

	<div class="row">	        		
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		<small id="basic_show1" style="color:red"><?= ($inclusive_b == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_b ?></span></small>
			<input type="text" id="exc_issue_amount1" name="exc_issue_amount1" placeholder="Amount" title="Amount" value="<?= $visa_issue_amount; ?>" onchange="validate_balance(this.id);get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');">
		</div>	
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		<small id="service_show1" style="color:red"><?= ($inclusive_s == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_s ?></span></small>
			<input type="text" name="service_charge1" id="service_charge1" placeholder="*Service Charge" title="Service Charge" value="<?= $service_charge;?>" onchange="validate_balance(this.id);get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
		<small>&nbsp;</small>
			<input type="text" id="service_tax_subtotal1" name="service_tax_subtotal1" value="<?= $sq_exc_info['service_tax_subtotal'] ?>" placeholder="Tax Amount" title="Tax Amount" readonly>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		<small id="markup_show1" style="color:red"><?= ($inclusive_m == '') ? '&nbsp;' : 'Inclusive Amount : <span>'.$inclusive_m ?></span></small>
			<input type="text" id="markup1" name="markup1" placeholder="Markup " title="Markup" onchange="get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','false','markup');" value="<?= $markup ?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="service_tax_markup1" name="service_tax_markup1" placeholder="*Tax on Markup" title="Tax on Markup" value="<?= $sq_exc_info['service_tax_markup'] ?>" readonly>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="roundoff1" id="roundoff1" class="text-right" placeholder="Round Off" title="RoundOff" value="<?= $sq_exc_info['roundoff'] ?> " readonly>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="exc_total_cost1" id="exc_total_cost1"  class="amount_feild_highlight text-right" placeholder="Net Total" title="Net Total" value="<?= $sq_exc_info['exc_total_cost'] ?>" readonly>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="due_date1" id="due_date1" id="due_date" placeholder="Due Date" title="Due Date" value="<?= get_date_user($sq_exc_info['due_date'])?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" name="balance_date1" id="balance_date1" value="<?= get_date_user($sq_exc_info['created_at'])?>" placeholder="Booking Date" title="Booking Date" onchange="check_valid_date(this.id);get_auto_values('balance_date1','exc_issue_amount1','payment_mode','service_charge1','markup1','update','true','service_charge');">
		</div>
	</div>
</div>
<div class="row text-center">
	<div class="col-md-12">
		<button class="btn btn-sm btn-success" id="exc_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
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
$('#birth_date1, #issue_date1, #due_date1,#balance_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#exc_update_modal').modal('show');
city_lzloading('.city_name_u');
$(function(){

$('#frm_exc_update').validate({
	rules:{
			customer_id1: { required: true},
			exc_issue_amount1: { required: true, number: true },
			service_charge1 :{ required : true, number:true },
			markup1 :{ required : true, number:true },
			exc_total_cost1 :{ required : true, number:true },
			balance_date1 : { required : true },
			 
	},
	submitHandler:function(form){

		    var exc_id = $('#exc_id_hidden').val();
		    var customer_id = $('#customer_id1').val();
			var exc_issue_amount = $('#exc_issue_amount1').val();	
			var service_charge = $('#service_charge1').val();
			var service_tax_subtotal = $('#service_tax_subtotal1').val();
			var exc_total_cost = $('#exc_total_cost1').val();
			var roundoff = $('#roundoff1').val();		
			var due_date1 = $('#due_date1').val();
			var balance_date1 = $('#balance_date1').val();
			var markup = $('#markup1').val();
			var service_tax_markup = $('#service_tax_markup1').val();

			var exc_check_arr = new Array();
			var exc_date_arr = new Array();
			var city_id_arr = new Array();
			var exc_name_arr = new Array();
			var transfer_option_arr = new Array();
			var total_adult_arr = new Array();
			var total_child_arr = new Array();
			var adult_cost_arr = new Array();
			var child_cost_arr = new Array();
			var total_amt_arr = new Array();
			var entry_id_arr = new Array();

	        var table = document.getElementById("tbl_dynamic_exc_booking_update");
	        var rowCount = table.rows.length;
	        
	        for(var i=0; i<rowCount; i++)
	        {
				var row = table.rows[i]; 

				var status = row.cells[0].childNodes[0].checked;
				var exc_date = row.cells[2].childNodes[0].value;
				var city_id = row.cells[3].childNodes[0].value;
				var exc_name = row.cells[4].childNodes[0].value;
				var transfer_option = row.cells[5].childNodes[0].value;
				var total_adult = row.cells[6].childNodes[0].value;
				var total_child = row.cells[7].childNodes[0].value;
				var adult_cost = row.cells[8].childNodes[0].value;
				var child_cost = row.cells[9].childNodes[0].value;
				var total_amt = row.cells[10].childNodes[0].value;
				
				if(row.cells[11]){
					var entry_id = row.cells[11].childNodes[0].value;	
				}
				else{
					var entry_id = "";
				}
				var msg = "";

				if(exc_date==""){ msg +="Excursion Date is required in row:"+(i+1)+"<br>"; }
				if(city_id==""){ msg +="City name is required in row:"+(i+1)+"<br>"; }
				if(exc_name==""){ msg +="Excursion Name is required in row:"+(i+1)+"<br>"; }
				if(transfer_option==""){ msg +="Transfer option is required in row:"+(i+1)+"<br>"; }
				if(total_adult==""){ msg +="Total Adult is required in row:"+(i+1)+"<br>"; }
				if(total_child==""){ msg +="Total Children is required in row:"+(i+1)+"<br>"; }

				if(msg!=""){
					error_msg_alert(msg);
					return false;
				}
				exc_check_arr.push(status);
				exc_date_arr.push(exc_date);
				city_id_arr.push(city_id);
				exc_name_arr.push(exc_name);
				total_adult_arr.push(total_adult);
				total_child_arr.push(total_child);
				adult_cost_arr.push(adult_cost);
				child_cost_arr.push(child_cost);
				total_amt_arr.push(total_amt); 
				entry_id_arr.push(entry_id);            
				transfer_option_arr.push(transfer_option);
	        }
	        var act_sc = $('#act_sc').val();
			var act_markup = $('#act_markup').val();
			var act_taxes = $('#act_taxes').val();
			var act_markup_taxes = $('#act_markup_taxes').val();
			var reflections = [];
			reflections.push({
				'act_sc':act_sc,
				'act_markup':act_markup,
				'act_taxes':act_taxes,
				'act_markup_taxes':act_markup_taxes
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
						$('#exc_update').button('loading');
						$.ajax({
							type: 'post',
							url: base_url+'controller/excursion/exc_master_update.php',
							data:{ exc_id : exc_id, customer_id : customer_id, exc_issue_amount : exc_issue_amount, service_charge : service_charge, service_tax_subtotal : service_tax_subtotal, exc_total_cost : exc_total_cost,due_date1 : due_date1,balance_date : balance_date1,exc_date_arr : exc_date_arr,exc_check_arr:exc_check_arr,city_id_arr : city_id_arr,exc_name_arr : exc_name_arr, total_adult_arr : total_adult_arr,total_child_arr : total_child_arr,adult_cost_arr : adult_cost_arr,child_cost_arr : child_cost_arr,total_amt_arr : total_amt_arr, entry_id_arr : entry_id_arr,transfer_option_arr:transfer_option_arr, markup : markup , service_tax_markup : service_tax_markup, reflections : reflections,roundoff: roundoff,bsmValues:bsmValues},
							success: function(result){
								var msg = result.split('-');
								if(msg[0]=='error'){
									msg_alert(result);
								}
								else{
									msg_alert(result);
									$('#exc_update').button('reset');
									reset_form('frm_exc_update');
									$('#exc_update_modal').modal('hide');
									exc_customer_list_reflect();
								}
								
							}
						});
					}
			});
	}
});

});
</script>