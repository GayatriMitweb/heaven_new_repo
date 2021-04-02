<?php
include "../../../model/model.php";
/*======******Header******=======*/
// require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
?>

 <!-- begin_panel('Account Group',35) ?> -->

<div class="row text-right">
    <div class="col-md-12">
        <?php if($role=='Admin'){ ?>
        <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
    <?php } ?>
        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Group</button>
    </div>
</div>

<div id="div_modal"></div>
<div id="div_list_content" class="main_block loader_parent mg_tp_20"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('../finance_master/group_master/save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}

function list_reflect()
{
    $('#div_list_content').append('<div class="loader"></div>');
	$.post('../finance_master/group_master/list_reflect.php', {}, function(data){
        $('#div_list_content').html(data);
    });
}
list_reflect();

function update_modal(group_id)
{
    $.post('../finance_master/group_master/update_modal.php', {group_id : group_id}, function(data){
        $('#div_modal').html(data);
    });
}

function excel_report()
{ 
    window.location = '../finance_master/group_master/excel_report.php';
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>