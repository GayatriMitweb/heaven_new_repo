<?php 
include_once('../../../../model/model.php');

$estimate_id = $_POST['estimate_id'];
$sq_vendor_estimate = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));
$reflections = json_decode($sq_vendor_estimate['reflections']);
?>
<input type="hidden" id="booking_id" name="booking_id" value="<?= $estimate_id ?>">
<input type="hidden" id="purchase_sc1" name="purchase_sc" value="<?php echo $reflections[0]->purchase_sc ?>">
<input type="hidden" id="purchase_commission1" name="purchase_commission" value="<?php echo $reflections[0]->purchase_commission ?>">
<input type="hidden" id="purchase_taxes1" name="purchase_taxes" value="<?php echo $reflections[0]->purchase_taxes ?>">
<input type="hidden" id="purchase_tds1" name="purchase_tds" value="<?php echo $reflections[0]->purchase_tds ?>">
<form id="frm_vendor_estimate_update">
<input type="hidden" id="estimate_id_update" name="estimate_id_update" value="<?= $estimate_id ?>">

<div class="modal fade" id="estimate_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:95%; margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Purchase Cost</h4>
      </div>
      <div class="modal-body">
			<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20 mg_bt_30">
			<legend>Select Sale</legend>

				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<select name="estimate_type1" id="estimate_type1" title="Purchase Type" onchange="payment_for_data_load(this.value, 'div_payment_for_content1', '1')" disabled>
							<option value="<?= $sq_vendor_estimate['estimate_type'] ?>"><?= $sq_vendor_estimate['estimate_type'] ?></option>
							<?php 
							$sq_estimate_type = mysql_query("select * from estimate_type_master order by estimate_type");
							while($row_estimate = mysql_fetch_assoc($sq_estimate_type)){
								?>
								<option value="<?= $row_estimate['estimate_type'] ?>"><?= $row_estimate['estimate_type'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div id="div_payment_for_content1" style="pointer-events: none;"></div>
					<script>
						payment_for_data_load('<?= $sq_vendor_estimate['estimate_type'] ?>', 'div_payment_for_content1', '1', <?= $sq_vendor_estimate['estimate_type_id'] ?>);
					</script>
				</div>

			</div>

			<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
			<legend>Supplier Type</legend>

				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
						<select name="vendor_type1" id="vendor_type1" title="Vendor Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content1', '1','','estimate')" disabled>
							<option value="<?= $sq_vendor_estimate['vendor_type'] ?>"><?= $sq_vendor_estimate['vendor_type'] ?></option>
							<?php 
							$sq_vendor = mysql_query("select * from vendor_type_master order by vendor_type");
							while($row_vendor = mysql_fetch_assoc($sq_vendor)){
								?>
								<option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div id="div_vendor_type_content1" style="pointer-events: none;"></div>
					<script>
						vendor_type_data_load('<?= $sq_vendor_estimate['vendor_type'] ?>', 'div_vendor_type_content1', '1',<?= $sq_vendor_estimate['vendor_type_id'] ?>,'estimate');
					</script>
				</div>

			</div>
			<div class="row text-right">  
			<div class="col-xs-12">    
			     <div class="div-upload">
	                <div id="id_upload_btn_update" class="upload-button1"><span>Upload Invoice</span></div>
	                <span id="id_proof_status" ></span>
	                <ul id="files" ></ul>
	                <input type="hidden" id="id_upload_url2" name="id_upload_url1" value="<?= $sq_vendor_estimate['invoice_proof_url'] ?>">
	              </div> 
	       </div>
	       </div>

			<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20" id="div_estimate_<?= $offset ?>">
			<legend>Supplier Purchase</legend>

				<div class="row">					
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="basic_cost" name="basic_cost" placeholder="Basic Cost" title="Basic Cost" onchange="validate_balance(this.id);calculate_estimate_amount('');get_auto_values('purchase_date1','basic_cost','payment_mode','service_charge','update','true','service_charge','discount','our_commission');" value="<?= $sq_vendor_estimate['basic_cost'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="non_recoverable_taxes" name="non_recoverable_taxes" placeholder="Non Recoverable Taxes" title="Non Recoverable Taxes" onchange="validate_balance(this.id);calculate_estimate_amount('')" value="<?= $sq_vendor_estimate['non_recoverable_taxes'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="validate_balance(this.id);calculate_estimate_amount('');get_auto_values('purchase_date1','basic_cost','payment_mode','service_charge','update','false','service_charge','discount','our_commission');" value="<?= $sq_vendor_estimate['service_charge'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="other_charges" name="other_charges" placeholder="Other Charges" title="Other Charges" onchange="validate_balance(this.id);calculate_estimate_amount('')" value="<?= $sq_vendor_estimate['other_charges'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" placeholder="Tax Subtotal" title="Tax Subtotal" readonly value="<?= $sq_vendor_estimate['service_tax_subtotal'] ?>">
					</div>		
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="discount" name="discount" placeholder="Discount" title="Discount" onchange="validate_balance(this.id);calculate_estimate_amount('');get_auto_values('purchase_date1','basic_cost','payment_mode','service_charge','update','true','discount','discount','our_commission');" value="<?= $sq_vendor_estimate['discount'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="our_commission" name="our_commission" placeholder="Our commission" title="Our commission" onchange="validate_balance(this.id);calculate_estimate_amount('');get_auto_values('purchase_date1','basic_cost','payment_mode','service_charge','update','true','service_charge','discount','our_commission');" value="<?= $sq_vendor_estimate['our_commission'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="tds" name="tds" placeholder="TDS On Commision" title="TDS On Commision" onchange="validate_balance(this.id);calculate_estimate_amount('')" value="<?= $sq_vendor_estimate['tds'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="roundoff" class="text-right" name="roundoff" placeholder="Round Off" title="Round Off" readonly value="<?= $sq_vendor_estimate['roundoff'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" id="net_total" class="amount_feild_highlight text-right" name="net_total" placeholder="Net Total" title="Net Total" readonly value="<?= $sq_vendor_estimate['net_total'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<textarea name="remark" id="remark" placeholder="Remark" title="Remark" rows="1"><?= $sq_vendor_estimate['remark'] ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
				  		<input type="text" placeholder="Invoice ID" onchange="validate_spaces(this.id)" title="Invoice ID" id="invoice_id1" name="invoice_id" value="<?= $sq_vendor_estimate['invoice_id'] ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" placeholder="Due date" title="Due Date" id="payment_due_date" name="payment_due_date"  value="<?= date('d-m-Y', strtotime($sq_vendor_estimate['due_date'])) ?>">
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
						<input type="text" placeholder="Purchase date" title="Purchase Date" id="purchase_date1" name="purchase_date1"  value="<?= date('d-m-Y', strtotime($sq_vendor_estimate['purchase_date'])) ?>" onchange="check_valid_date(this.id);get_auto_values('purchase_date1','basic_cost','payment_mode','service_charge','update','true','service_charge','discount','our_commission');">
					</div>
				</div>
			</div>
			

			<div class="row text-center">
				<div class="col-xs-12">
					<button class="btn btn-sm btn-success" id="btn_update_estimate"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
				</div>
			</div>

        
      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#request_id1').select2();
 $('#payment_due_date,#purchase_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#estimate_update_modal').modal('show');

function upload_hotel_pic_attch()
{
    var btnUpload=$('#id_upload_btn_update');
    $(btnUpload).find('span').text('Upload Invoice');
    new AjaxUpload(btnUpload, {
      action: 'estimate/upload_invoice_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $("#id_upload_url2").val(response);
        //  upload_pic();
        }
      }
    });
}
upload_hotel_pic_attch();
$(function(){
	$('#frm_vendor_estimate_update').validate({
		rules:{
				estimate_type1: { required: function(){ if($('#vendor_type1').val()!='Other Vendor'){ return true }else{ return false; } } },
				vendor_type1: { required: true },
				basic_cost: { required : true, number : true },
				taxation_type : { required : true },
				net_total: { required : true, number : true },
				 
		},
		submitHandler:function(form){
			
				var base_url = $('#base_url').val();
				var status = validate_estimate_vendor('estimate_type1', 'vendor_type1', '1');
 				if(!status){ return false; }

				var estimate_id = $('#estimate_id_update').val();
				var estimate_type = $('#estimate_type1').val();
 				var vendor_type = $('#vendor_type1').val(); 	 				
 				var estimate_type_id = get_estimate_type_id('estimate_type1', '1');
 				var vendor_type_id = get_vendor_type_id('vendor_type1', '1');

 				if(vendor_type=="Other Vendor"){
 					//estimate_type = "";
 					//estimate_type_id = "";
 				}

				var basic_cost = $('#basic_cost').val();
				var non_recoverable_taxes = $('#non_recoverable_taxes').val();
				var service_charge = $('#service_charge').val();
				var other_charges = $('#other_charges').val();
				var taxation_id = $('#taxation_id').val();
				var taxation_type = $('#taxation_type').val();
				var service_tax = $('#service_tax').val();
				var service_tax_subtotal = $('#service_tax_subtotal').val();
				var discount = $('#discount').val();
				var our_commission = $('#our_commission').val();
				var tds = $('#tds').val();
				var net_total = $('#net_total').val();
				var roundoff = $('#roundoff').val();
				var remark = $('#remark').val();
				var invoice_url = $('#id_upload_url2').val();
				var invoice_id = $('#invoice_id1').val();
				var payment_due_date = $('#payment_due_date').val();
				var purchase_date = $('#purchase_date1').val();
				var purchase_sc = $('#purchase_sc1').val();
				var purchase_commission = $('#purchase_commission1').val();
				var purchase_taxes = $('#purchase_taxes1').val();
				var purchase_tds = $('#purchase_tds1').val();
				var reflections = [];
				reflections.push({
				'purchase_sc':purchase_sc,
				'purchase_commission':purchase_commission,
				'purchase_taxes':purchase_taxes,
				'purchase_tds':purchase_tds
				});
				
				$.post(base_url+'view/load_data/finance_date_validation.php', { check_date: purchase_date }, function(data){
					if(data !== 'valid'){
						error_msg_alert("The Purchase Date does not match between selected Financial year.");
						return false;
					}
					else{
						$('#btn_update_estimate').button('loading');
						$.ajax({
							type:'post',
							url: base_url+'controller/vendor/dashboard/estimate/vendor_estimate_update.php',
							data:{ estimate_id : estimate_id, estimate_type : estimate_type, vendor_type : vendor_type, estimate_type_id : estimate_type_id, vendor_type_id : vendor_type_id, basic_cost : basic_cost, non_recoverable_taxes : non_recoverable_taxes, service_charge : service_charge, other_charges : other_charges,service_tax_subtotal : service_tax_subtotal, discount : discount, our_commission : our_commission, tds : tds, net_total : net_total, roundoff : roundoff,remark : remark, invoice_id : invoice_id, payment_due_date : payment_due_date,invoice_url : invoice_url,purchase_date : purchase_date,reflections:reflections },
							success:function(result){
								$('#btn_update_estimate').button('reset');
								msg_alert(result);
								$('#estimate_update_modal').modal('hide');
								$('#estimate_update_modal').on('hidden.bs.modal', function(){
									vendor_estimate_list_reflect();
								});
							}
						});
					}
				});
 
		}
	});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>