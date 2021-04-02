<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">
 
<div class="row">
    <div class="col-sm-12 text-right text_left_sm_xs">
        <?php if($role == 'Admin' || $role == 'Branch Admin'){?>
            <button class="btn btn-info btn-sm mg_bt_20 ico_left" id="btn_save_modal" onclick="save_modal();" title="Add Credit Limit" data-toggle="tooltip"><i class="fa fa-plus"></i>&nbsp;&nbsp;Credit Limit</button>
        <?php } ?>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="approve_statuss" id="approve_statuss" title="Approval Status" data-toggle="tooltip" onchange="customer_list_reflect()">
                <option value="">Approval Status</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>
</div>

<div class="row"></div>

<div id="div_customer_list" class="loader_parent"></div>
<div id="div_view_modal"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
function customer_list_reflect(){
  $('#div_customer_list').append('<div class="loader"></div>');
  var approve_status = $('#approve_statuss').val();
  var branch_status = $('#branch_status').val();
 
	$.post('credit_management/customer_list_reflect.php',{  branch_status : branch_status,approve_status:approve_status}, function(data){
		$('#div_customer_list').html(data);
	});
}
customer_list_reflect();

function save_modal(){
    var branch_status = $('#branch_status').val();
    $.post('credit_management/save_modal.php', {}, function(data){
          $('#div_view_modal').html(data);
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>