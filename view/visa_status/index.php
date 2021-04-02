<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_status/index.php'"));
$branch_status = $sq['branch_status'];
 
?>
<?= begin_panel('Visa Current Status',48) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="header_bottom">
<div class="row text-center mg_bt_20 text_left_sm_xs">
    <div class="col-md-12">          
        <label for="rd_visa" class="app_dual_button active mg_bt_10">
            <input type="radio" id="rd_visa" name="app_id_proof" checked onchange="dropdown_load()">
            &nbsp;&nbsp;Visa
        </label>
        <label for="rd_package_tour" class="app_dual_button mg_bt_10">
            <input type="radio" id="rd_package_tour" name="app_id_proof" onchange="dropdown_load()">
            &nbsp;&nbsp;Package Tour
        </label>           
        <label for="rd_air_ticket" class="app_dual_button">
            <input type="radio" id="rd_air_ticket" name="app_id_proof" onchange="dropdown_load()">
            &nbsp;&nbsp;Flight Ticket
        </label>
         <label for="rd_group_tour" class="app_dual_button">
            <input type="radio" id="rd_group_tour" name="app_id_proof" onchange="dropdown_load()" >
            &nbsp;&nbsp;Group Tour
        </label> 
    </div>
</div>
</div>

<div id="div_id_proof_content" class="main_block"></div>



<?= end_panel() ?>

<script>
function dropdown_load()
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
    if($("#rd_visa").is(':checked')){
        $.post('visa/index.php', {branch_status : branch_status}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }
}
dropdown_load();

function load_visa_report(booking_id,booking_type,result_div)
{
    var booking_id = $('#'+booking_id).val();

    $.post( base_url()+"view/visa_status/inc/get_visa_status_report.php" , {booking_id : booking_id, booking_type : booking_type } , function ( data ) {
        $ ("#"+result_div).html(data) ;
    });
}
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>