<?php
include "../../../../model/model.php";
$branch_status = $_POST['branch_status'];
include_once('payment_save_modal.php');
?>
<div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#v_payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Advance</button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="vendor_type2" id="vendor_type2" title="Supplier Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content2')">
				<option value="">Supplier Type</option>
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
		<div id="div_vendor_type_content2"></div>
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
				<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
					<?php get_financial_year_dropdown(); ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="col-md-3">
				<button class="btn btn-sm btn-info ico_right" onclick="payment_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
	</div>
</div>
<div id="div_quotation_list_reflect" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="advance_payment" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
    <div id="div_vendor_report_content" class="main_block loader_parent"></div>
	<div id="div_payment_update_content"></div>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
var column = [
	{ title : "S_No."},
	{ title:"Supplier_Type", className:"text-center"},
	{ title : "Supplier_Name"},
	{ title : "Payment_Date"},
	{ title : "Amount"},
	{ title : "Mode"},
	{ title : "Bank_Name"},
	{ title : "Cheque_No/Id"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions", className:"action_width text-center"}
];
function payment_list_reflect()
{
	$('#div_vendor_report_content').append('<div class="loader"></div>');
	var vendor_type = $('#vendor_type2').val();
 	var vendor_type_id = get_vendor_type_id('vendor_type2');
 	var financial_year_id = $('#financial_year_id_filter').val();
    var branch_status = $('#branch_status').val();
    
	$.post('advances/payment_list_reflect.php', { vendor_type : vendor_type, vendor_type_id : vendor_type_id, financial_year_id : financial_year_id, branch_status : branch_status }, function(data){
		pagination_load(data, column, true, true, 20, 'advance_payment');
		$('.loader').remove();
	});
}
payment_list_reflect();

payment_evidence_upload();
function payment_evidence_upload(offset='')
{
    var btnUpload=$('#payment_evidence_upload'+offset);
    var status=$('#payment_evidence_status'+offset);
    new AjaxUpload(btnUpload, {
      action: 'advances/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         var id_proof_url = $("#payment_evidence_url"+offset).val();
          
     
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG or GIF files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          $("#payment_evidence_url"+offset).val(response);
          msg_alert('File uploaded!');
        }
      }
    });

}

function payment_update_modal(payment_id){
	$.post('advances/payment_update_modal.php', { payment_id : payment_id }, function(data){
		$('#div_payment_update_content').html(data);
	});
}
function excel_report()
{
	var vendor_type = $('#vendor_type2').val();
	var vendor_type_id = get_vendor_type_id('vendor_type2');
 	var estimate_type = $('#estimate_type2').val();
  var branch_status = $('#branch_status').val();
  var financial_year_id = $('#financial_year_id_filter').val();
	window.location = 'advances/excel_report.php?financial_year_id='+financial_year_id+'&vendor_type='+vendor_type+''+'&vendor_type_id='+vendor_type_id+'&branch_status='+branch_status;
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<style>
.action_width{
	width : 250px !important;
}
</style>