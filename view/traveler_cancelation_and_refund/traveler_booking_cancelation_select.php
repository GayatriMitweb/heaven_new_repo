<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
?>
<div class="app_panel_content Filter-panel">
    <div class="row"> 
        <div class="col-md-4 col-md-offset-4 col-xs-12">
            <select title="Booking ID" id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" style="width:100%;" onchange="cancel_booking_reflect();">
                <?php get_group_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id,$role_id) ?>
            </select>   
        </div>
    </div>
</div>
<div id="div_cancelrefund_reflect"></div>
<script>
$("#cmb_tourwise_traveler_id").select2();

function cancel_booking_reflect(){
    var booking_id = $('#cmb_tourwise_traveler_id').val();
    if(booking_id!=''){
        $.post('traveler_booking_cancelation.php', { cmb_tourwise_traveler_id : booking_id }, function(data){
            $('#div_cancelrefund_reflect').html(data);
        });
    }else{
        $('#div_cancelrefund_reflect').html('');
    }
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>