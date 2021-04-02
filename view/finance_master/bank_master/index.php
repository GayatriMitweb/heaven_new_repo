<?php
include "../../../model/model.php";
/*======******Header******=======*/
// require_once('../../layouts/admin_header.php');
?>
 <!-- begin_panel('Bank Account Details',32)  -->
      <div class="header_bottom">
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Bank A/c</button>
            </div>
        </div>
      </div> 

  <!--=======Header panel end======-->


<div class="app_panel_content">

<div id="div_modal"></div>
<div id="div_list_content"></div>
<div id="div_view_modal"></div>

<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('../finance_master/bank_master/save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}
function list_reflect()
{
	$.post('../finance_master/bank_master/list_reflect.php', {}, function(data){
        $('#div_list_content').html(data);
    });
}
list_reflect();

function update_modal(bank_id)
{
    $.post('../finance_master/bank_master/update_modal.php', {bank_id : bank_id}, function(data){
        $('#div_modal').html(data);
    });
}
function display_modal(bank_id)
{
    $.post('../finance_master/bank_master/view/index.php', {bank_id : bank_id}, function(data){
        $('#div_view_modal').html(data);
    });
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>