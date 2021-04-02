<?php
include_once('../../../../model/model.php');
$offset = $_POST['dynamic_estimate_count'];
?>
<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30" id="div_estimate_<?= $offset ?>">

<legend> Supplier Purchase - <?= $offset ?></legend> 

	<div class="row text-right">  
	<div class="col-xs-12 mg_bt_10_sm_xs">     
          <div class="div-upload">
            <div id="id_upload_btn<?= $offset ?>" class="upload-button1"><span>Upload Invoice</span></div>
            <span id="id_proof_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="id_upload_url<?= $offset ?>" name="id_upload_url1">
          </div> 
	</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-12">
			<select name="vendor_type" id="vendor_type_s-<?= $offset ?>" title="Supplier Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content_s-<?= $offset ?>', '_s-<?= $offset ?>','','estimate')">
				<option value="">*Supplier Type</option>
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

		<div id="div_vendor_type_content_s-<?= $offset ?>"></div>

			

		 

		<?php 
		if($offset!=1){
			?>
			<div class="col-sm-2 col-xs-12 pull-right text-right mg_tp_10">

				<button type="button" class="btn btn-danger btn-sm" onclick="close_estimate('div_estimate_<?= $offset ?>')"><i class="fa fa-times"></i></button>
			</div>
			<?php	
		}
		?>
	</div>

	

	<hr class="mg_tp_10 mg_bt_10">



	<div class="row">

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="basic_cost_s-<?= $offset ?>" name="basic_cost_s" placeholder="*Basic Cost" title="Basic Cost" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'true','basic')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="non_recoverable_taxes_s-<?= $offset ?>" name="non_recoverable_taxes_s" placeholder="Non Recoverable Taxes" title="Non Recoverable Taxes" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'false','service_charge')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="service_charge_s-<?= $offset ?>" name="service_charge_s" placeholder="Service Charge" title="Service Charge" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'false','service_charge')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="other_charges_s-<?= $offset ?>" name="other_charges_s" placeholder="Other Charges" title="Other Charges" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'false','service_charge')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="discount_s-<?= $offset ?>" name="discount_s" placeholder="Discount" title="Discount" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'true','discount')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="service_tax_subtotal_s-<?= $offset ?>" name="service_tax_subtotal_s" placeholder="Tax Subtotal" title="Tax Subtotal" readonly>

		</div>					

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="our_commission_s-<?= $offset ?>" name="our_commission_s" placeholder="Our commission" title="Our commission" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');brule_for_one(this.id,'true','service_charge')">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="tds_s-<?= $offset ?>" name="tds_s" placeholder="TDS On Commission" title="TDS On Commission" onchange="validate_balance(this.id);calculate_estimate_amount('_s-<?= $offset ?>');">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="roundoff_s-<?= $offset ?>" class="text-right" name="roundoff_s" placeholder="Round Off" title="Round Off" readonly>

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" id="net_total_s-<?= $offset ?>" class="amount_feild_highlight text-right" name="net_total_s" placeholder="*Net Total" title="Net Total" readonly>

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<textarea name="remark_s" id="remark_s-<?= $offset ?>" placeholder="Remark" title="Remark" rows="1"></textarea>

		</div>	
	</div>
	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" placeholder="Invoice ID" onchange="validate_spaces(this.id)" title="Invoice ID" id="invoice_id_s-<?= $offset ?>" name="invoice_id">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" placeholder="Due date" title="Due Date" id="payment_due_date_s-<?= $offset ?>" name="payment_due_date_s" value="<?= date('d-m-Y') ?>">

		</div>

		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">

			<input type="text" placeholder="Purchase date" title="Purchase Date" id="purchase_date_s-<?= $offset ?>" name="purchase_date_s" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id);brule_for_one(this.id,'true','service_charge')">

		</div>

	</div>



</div>

<script>

 $('#payment_due_date_s-<?= $offset ?>,#purchase_date_s-<?= $offset ?>').datetimepicker({ timepicker:false, format:'d-m-Y' });

 upload_invoice_pic_attch();

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>