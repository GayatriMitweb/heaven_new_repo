<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
include_once('../inc/quotation_hints_modal.php');


$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='package_booking/quotation/group_tour/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="whatsapp_switch" name="whatsapp_switch" value="<?= $whatsapp_switch ?>" >
<?= begin_panel('Group Tour Quotation',41) ?>
<div class="app_panel_content">
    <div class="row">
        <div class="col-md-12">
            <div id="div_id_proof_content">
            	<div class="row mg_bt_20">
		            <div class="col-md-8">
		            </div>
		            <div class="col-md-4 text-right">
		                <button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="gquot_save"><i class="fa fa-plus"></i>&nbsp;&nbsp;Quotation</button>
		            </div>
		        </div>


				<div class="app_panel_content Filter-panel">
					<div class="row">
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="quotation_list_reflect()">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="quotation_list_reflect()">
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="booking_type_filter" id="booking_type_filter" title="Booking Type" onchange="quotation_list_reflect()">
					        	<option value="">Booking Type</option>
					        	<option value="Domestic">Domestic</option>
					        	<option value="International">International</option>
					        </select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="tour_name" id="tour_name_filter" title="Select Tour Name" style="width:100%" onchange="quotation_list_reflect()">
								<option value="">Select Tour Name</option>
								<?php 
								$sq_tour = mysql_query("select distinct(tour_name) from group_tour_quotation_master order by tour_name");
								while($row_tour = mysql_fetch_assoc($sq_tour)){
									?>
									<option value="<?= $row_tour['tour_name'] ?>"><?= $row_tour['tour_name'] ?></option>
									<?php
								}
								?>				
							</select>
						</div>
						<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
							<select name="quotation_id" id="quotation_id" title="Select Quotation" onchange="quotation_list_reflect()" style="width:100%">
								<option value="">Select Quotation</option>
								<?php 
								$query = "select * from group_tour_quotation_master where 1 ";				
								if($role == 'B2b' || $role=='Sales' || $role=='Backoffice'){
									$query .= " and emp_id='$emp_id'";
								}
								if($branch_status=='yes' && $role!='Admin'){
										$query .= " and branch_admin_id = '$branch_admin_id'";
								}
								if($branch_status=='yes' && $role=='Branch Admin'){
									$query .= " and branch_admin_id='$branch_admin_id'";
								}
								$query .= "  order by quotation_id desc";
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
        				<table id="group_table" class="table table-hover" style="margin: 20px 0 !important;">         
        				</table>
    				</div></div></div>
				</div>
				<div id="div_quotation_form"></div>
				<div id="div_quotation_update"></div>
				<div id="div_modal_content"></div>
				<div id="backoffice_mail"></div>
            </div>
        </div>
    </div>
</div>
<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<style>
.action_width{
	width:200px;
}
.s_no_width{
	width:5px !important;
}
</style>
<script>
$('[data-toggle="tooltip"]').tooltip();
$('#quotation_id,#tour_name_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

column = [
	{ title : "S_No."  , className:"s_no_width"},
	{ title :"ID" },
	{ title : "Tour&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
	{ title : "Customer" },
	{ title : "Date&nbsp;&nbsp;&nbsp;&nbsp;" },
	{ title : "Amount" },
	{ title : "Created_by" },
	{ title : "Actions" , className:"text-center action_width"}
];

function quotation_list_reflect()
{
	$('#div_quotation_list_reflect').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var booking_type = $('#booking_type_filter').val();
	var tour_name = $('#tour_name_filter').val();
	var quotation_id = $('#quotation_id').val();
	var branch_status = $('#branch_status').val();
	var branch_id = $('#branch_id_filter1').val();

	$.post('quotation_list_reflect.php', { from_date : from_date, to_date : to_date, booking_type : booking_type, tour_name : tour_name, quotation_id : quotation_id, branch_status : branch_status , branch_id : branch_id}, function(data){
		//$('#div_quotation_list_reflect').html(data);
		pagination_load(data, column, true, false, 20, 'group_table');
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
			url: base_url+'controller/package_tour/quotation/group_tour/quotation_clone.php',
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

function save_modal()
{
	$('#gquot_save').button('loading');
	var branch_status = $('#branch_status').val();
	$.post('save/index.php', {branch_status : branch_status }, function(data){
		$('#div_quotation_form').html(data);
	  $('#gquot_save').button('reset');
	});
}
function update_modal(quotation_id)
{
	var branch_status = $('#branch_status').val();
	$.post('update/index.php', { quotation_id : quotation_id, branch_status : branch_status }, function(data){
		$('#div_quotation_update').html(data);
	});
}
$(document).ready(function(){
	let searchParams = new URLSearchParams(window.location.search);
	if( searchParams.get('enquiry_id') ){
		save_modal();
	}
});
function quotation_email_send_backoffice_modal(quotation_id){
	$.post('backoffice_mail.php', {quotation_id : quotation_id }, function(data){
		$('#backoffice_mail').html(data);
	});
}
function quotation_email_send(btn_id, quotation_id){
$('#'+btn_id).button('loading');
var base_url = $('#base_url').val();
$.ajax({
		type:'post',
		url: base_url+'controller/package_tour/quotation/group_tour/quotation_email_send.php',
		data:{ quotation_id : quotation_id },
		success: function(message){
			msg_alert(message);
			$('#'+btn_id).button('reset');              	
		}  
	});
	if($('#whatsapp_switch').val() == "on")quotation_whatsapp_send(quotation_id,base_url);
}
function quotation_whatsapp_send(quotation_id,base_url){
	$.post(base_url+'controller/package_tour/quotation/group_tour/quotation_whatsapp.php',{quotation_id:quotation_id }, function(link){
		window.open(link);
	});
}
</script>

<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>