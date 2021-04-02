<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='b2b_customer/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >

<div class="row">
    <div class="col-sm-12 text-right text_left_sm_xs">
        <button class="btn btn-excel btn-sm mg_bt_20" id="send_btn" onclick="send_reg()" data-toggle="tooltip" title="Send Registration Form"><i class="fa fa-paper-plane-o"></i></button>
        <?php if($role == 'Admin' || $role == 'Branch Admin'){?>
        <button class="btn btn-excel btn-sm mg_bt_20" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
        <?php } ?><button class="btn btn-info btn-sm mg_bt_20 ico_left" id="btn_save_modal" onclick="save_modal();" title="Add B2B Agnet" data-toggle="tooltip"><i class="fa fa-plus"></i>&nbsp;&nbsp;B2B Agent</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="approve_status" id="approve_status" data-toggle="tooltip" title="Approval Status" onchange="customer_list_reflect()">
                <option value="">Approval Status</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="active_flag_filter" id="active_flag_filter" data-toggle="tooltip" title="Status" onchange="customer_list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row"></div>

<div id="div_customer_list" class="loader_parent"></div>
<div id="div_view_modal"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
function send_reg(){
	$('#send_btn').button('loading');
	$.post('inc/send_reg_form.php', { }, function(data){
        $('#div_modal').html(data);
        $('#send_btn').button('reset');
	});
}

function customer_list_reflect(){
    $('#div_customer_list').append('<div class="loader"></div>');
    var approve_status = $('#approve_status').val();
    var active_flag = $('#active_flag_filter').val();
    var branch_status = $('#branch_status').val();
 
	$.post('customer_list_reflect.php',{ active_flag : active_flag, branch_status : branch_status,approve_status:approve_status}, function(data){
		$('#div_customer_list').html(data);
	});
}
customer_list_reflect();

function excel_report(){
    var approve_status = $('#approve_status').val();
    var active_flag = $('#active_flag_filter').val();
    var branch_id = $('#branch_id_filter1').val();
    
    window.location = 'excel_report.php?active_flag='+active_flag+'&branch_status='+branch_status+'&approve_status='+approve_status;
}
function save_modal(){
    var branch_status = $('#branch_status').val();
    $.post('save/index.php', {branch_status, branch_status}, function(data){
          $('#div_view_modal').html(data);
    });
}
function change_fields_status(approval_status){
    var approve_status1 = $('#'+approval_status).val();
    if(approve_status1 == 'Approved'){
      $('input[name="app_credit"]').prop('disabled', false);
    }
    else{
      $('input[name="app_credit"]').prop('disabled', true);
    }
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>