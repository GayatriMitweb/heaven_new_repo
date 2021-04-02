<?php
include "../../../../model/model.php";
/*======******Header******=======*/
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='vendor/quotation_request/index.php'"));
$branch_status = $sq['branch_status'];
 ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select name="quotation_for_filter" id="quotation_for_filter" title="Quotation For" style="width:100%">
				<option value="">Quotation For</option>
				<option value="DMC Vendor">DMC</option>
				<option value="Hotel Vendor">Hotel</option>			
				<option value="Transport Vendor">Transport</option>
			</select>
		</div>
		 <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select name="enquiry_id_filter" id="enquiry_id_filter" title="Select Enquiry" style="width:100%">
				<option value="">Select Enquiry</option>
				<?php
					$query = "SELECT * FROM `enquiry_master` where 1";
						$query .=" and status!='Disabled'";
						$query .=" and enquiry_type='Package Booking'"; 
						if($branch_status=='yes'){
							if($role=='Branch Admin' || $role=='Backoffice'){
								$query .= " and branch_admin_id = '$branch_admin_id'";
							} 
							elseif($role=='Sales'){
								$query .= " and assigned_emp_id='$emp_id'";
							}
						}
						$query .= " order by enquiry_id desc";
						$sq_enq = mysql_query($query);
						while($row_enq = mysql_fetch_assoc($sq_enq)){
							$query="select enquiry_id from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]') and followup_status !='Dropped'";
							$sq_enq_query=mysql_query($query);
							while($row_enq_query =mysql_fetch_assoc($sq_enq_query)){
								$booking_date = $row_enq['enquiry_date'];
								$yr = explode("-", $booking_date);
								$year =$yr[0];
							?>
					<option value="<?= $row_enq_query['enquiry_id'] ?>"><?= get_enquiry_id($row_enq_query['enquiry_id'],$year).' : '.$row_enq['name']; ?></option>
					<?php } } ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-info btn-sm ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>
<div id="div_quotation_list_reflect" class="main_block loader_parent">
	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="best_supplier" class="table table-hover" style="margin: 20px 0 !important;">         
		</table>
	</div></div></div>
</div>
<div id="div_list_reflect" class="main_block loader_parent"></div>
<div id="div_req_view"></div>

<script>
$('#quotation_for_filter,#enquiry_id_filter').select2();
var column = [
	{ title : "S_No."},
	{ title:"City_Name", className:"text-center"},
	{ title : "Supplier_Name"},
	{ title : "Supplier_id"},
	{ title : "Total cost"},
	{ title : "Actions", className : "text-center"}
];
function list_reflect()
{
	$('#div_list_reflect').append('<div class="loader"></div>');
	var quotation_for = $('#quotation_for_filter').val();
	var enquiry_id = $('#enquiry_id_filter').val();
	var branch_status = $('#branch_status').val();
 
	$.post('best_supplier/list_reflect.php', { quotation_for : quotation_for, enquiry_id : enquiry_id,  branch_status : branch_status }, function(data){
		pagination_load(data, column, true, false, 10, 'best_supplier');
		$('.loader').remove();
	});
}
list_reflect();

function view_modal(id,quotation_for,enquiry_id){
	$.post('best_supplier/cost_view/index.php', { id : id , quotation_for : quotation_for, enquiry_id : enquiry_id}, function(data){
		$('#div_req_view').html(data);
	});
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
 
 