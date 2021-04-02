<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
include_once('../inc/quotation_hints_modal.php');
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='package_booking/quotation/home/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Package Tour Quotation',40) ?>
	<div class="app_panel_content">
	    <div class="row">
	        <div class="col-md-12">
	            <div id="div_id_proof_content"> </div>
		        <div class="row mg_bt_20">
		            <div class="col-xs-12 text-right">
						<form action="save/index.php" method="POST">
							<button class="btn btn-info btn-sm ico_left" id="quot_save"><i class="fa fa-plus"></i>&nbsp;&nbsp;Quotation</button>
						</form>
		            </div>
		        </div> 

				<div class="app_panel_content Filter-panel">
					<div class="row">
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="validate_validDate('from_date_filter' , 'to_date_filter');quotation_list_reflect()">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="validate_issueDate('from_date_filter' , 'to_date_filter');quotation_list_reflect()">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="booking_type_filter" id="booking_type_filter" title="Booking Type" onchange="quotation_list_reflect()">
					        	<option value="">Booking Type</option>
					        	<option value="Domestic">Domestic</option>
					        	<option value="International">International</option>
					        </select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="tour_name" id="tour_name_filter" title="Select Package Name" style="width:100%" onchange="quotation_list_reflect()">
								<option value="">Select Package Name</option>
								<?php 
								$sq_tour = mysql_query("select * from custom_package_master order by package_name");
								while($row_tour = mysql_fetch_assoc($sq_tour)){
									?>
									<option value="<?= $row_tour['package_id'] ?>"><?= $row_tour['package_name'] ?></option>
									<?php
								}
								?>				
							</select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="quotation_id" id="quotation_id" title="Select Quotation" onchange="quotation_list_reflect()" style="width:100%">
								<option value="">Select Quotation</option>
								<?php 
								$query = "select * from package_tour_quotation_master where 1 ";				
								if($role=='B2b' || $role=='Sales' || $role=='Backoffice'){
									$query .= " and emp_id='$emp_id'";
								}
								if($branch_status=='yes' && $role!='Admin'){
										$query .= " and branch_admin_id = '$branch_admin_id'";
								}
								if($branch_status=='yes' && $role=='Branch Admin'){
									$query .= " and branch_admin_id='$branch_admin_id'";
								}
								$query .= " order by quotation_id desc";
								$sq_quotation = mysql_query($query);
								while($row_quotation = mysql_fetch_assoc($sq_quotation)){

									$quotation_date = $row_quotation['quotation_date'];
						            $yr = explode("-", $quotation_date);
						           	$year =$yr[0];
									?>
									<option value="<?= $row_quotation['quotation_id'] ?>"><?= get_quotation_id($row_quotation['quotation_id'],$year) ?></option>
									<?php
								}
								?>
							</select>
						</div>
						 <?php if($role=='Admin'){ ?>
				        <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
				            <select name="branch_id_filter" id="branch_id_filter1" title="Branch Name" style="width: 100%" onchange="quotation_list_reflect()">
				            <?php get_branch_dropdown($role, $branch_admin_id, $branch_status) ?>
				            </select>
				        </div>
				        <?php } ?>
					</div>
				</div>

				<div id="div_quotation_list_reflect" class="main_block loader_parent">
					<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
        				<table id="package_table" class="table table-hover" style="margin: 20px 0 !important;">         
        				</table>
    				</div></div></div>
				</div>
				<div id="div_quotation_form"></div>
				<div id="div_quotation_save"></div>
				<div id="backoffice_mail"></div>
            </div>
        </div>
    </div>
</div>
<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#quotation_id,#tour_name_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('[data-toggle="tooltip"]').tooltip();

var column = [
	{ title : "S_No."},
	{ title:"ID", className:"text-center"},
	{ title : "Package_Name"},
	{ title : "Customer"},
	{ title : "Quotation_Date"},
	{ title : "Amount"},
	{ title : "Created_by"},
	{ title : "Actions" , className:"text-center action_width"}
];
function quotation_list_reflect(){
	$('#div_quotation_list_reflect').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var booking_type = $('#booking_type_filter').val();
	var package_id = $('#tour_name_filter').val();
	var quotation_id = $('#quotation_id').val();
	var branch_status = $('#branch_status').val();
	var branch_id = $('#branch_id_filter1').val();

	$.post('quotation_list_reflect.php', { from_date : from_date, to_date : to_date, booking_type : booking_type, package_id : package_id, quotation_id : quotation_id, branch_status : branch_status,branch_id : branch_id}, function(data){
		pagination_load(data, column, true, false, 20, 'package_table');
		$('.loader').remove();
	})
}
quotation_list_reflect();

function quotation_clone(quotation_id){
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
	callback: function(data1){
		if(data1=="yes"){
			$.ajax({
				type:'post',
				url: base_url+'controller/package_tour/quotation/quotation_clone.php',
				data:{ quotation_id : quotation_id },
				success:function(result){
					msg_alert(result);
					console.log(result);
					quotation_list_reflect();
				}
			});
		}
	}
	});
}
function quotation_email_send(btn_id, quotation_id, email_id, mobile_no)
{
	$('#'+btn_id).button('loading');
	var base_url = $('#base_url').val();
	$.post('send_quotation.php', { email_id : email_id,mobile_no : mobile_no}, function(data){
		$('#div_quotation_form').html(data);
		$('#'+btn_id).button('reset');    
	});

}
function quotation_email_send_backoffice_modal(quotation_id){
	// $('#quot_save').button('loading');
	$.post('backoffice_mail.php', {quotation_id : quotation_id }, function(data){
		$('#backoffice_mail').html(data);
		// $('#quot_save').button('reset');
	});
}
function save_modal(){
	var branch_status = $('#branch_status').val();
	$('#quot_save').button('loading');
	$.post('save/index.php', {branch_status : branch_status }, function(data){
		$('#div_quotation_save').html(data);
		$('#quot_save').button('reset');
	});
}
// function update_modal(quotation_id,package_id){
// 	alert(quotation_id);
// 	var branch_status = $('#branch_status').val();
// 	$.post('update/index.php', { quotation_id : quotation_id,package_id : package_id , branch_status : branch_status}, function(data){
// 		$('#div_quotation_update').html(data);
// 	});
// }
</script>
<style>
.action_width{
	width:250px;
}
</style>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>