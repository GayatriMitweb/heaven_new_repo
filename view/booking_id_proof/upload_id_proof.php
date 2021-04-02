<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='booking_id_proof/upload_id_proof.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('ID Proof Upload',47) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center mg_bt_20 text_left_sm_xs">
    <div class="col-md-12">
         <label for="rd_group_tour" class="app_dual_button active mg_bt_10">
            <input type="radio" id="rd_group_tour" name="app_id_proof" checked onchange="id_proof_upload_content_show()" >
            &nbsp;&nbsp;Group Tour
        </label>    
        <label for="rd_package_tour" class="app_dual_button mg_bt_10">
            <input type="radio" id="rd_package_tour" name="app_id_proof" onchange="id_proof_upload_content_show()">
            &nbsp;&nbsp;Package Tour
        </label>           
        <label for="rd_air_ticket" class="app_dual_button">
            <input type="radio" id="rd_air_ticket" name="app_id_proof" onchange="id_proof_upload_content_show()">
            &nbsp;&nbsp;Flight Ticket
        </label>
    </div>
</div>

    
    <div id="div_id_proof_content"></div>



<?= end_panel() ?>
<script>
function id_proof_upload_content_show()
{
    var id = $('input[name="app_id_proof"]').attr('id');
    var branch_status = $('#branch_status').val();
    if($("#rd_group_tour").is(':checked')){
        $.post('group_tour/index.php', {branch_status : branch_status}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }
    if($("#rd_package_tour").is(':checked')){
        $.post('package_tour/index.php', {branch_status : branch_status}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }    
    if($("#rd_air_ticket").is(':checked')){
        $.post('air_ticket/index.php', {branch_status : branch_status}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }
}
id_proof_upload_content_show();
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>