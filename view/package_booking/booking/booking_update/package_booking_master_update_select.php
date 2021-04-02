<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>
<?= begin_panel('Booking Information Update') ?>
<form id="frm_booking_update_select" method="POST" action="package_booking_master_update.php">
    
    <div class="row">
        <div class="col-md-2 col-sm-3 text-right text_center_xs">
            <label for="cmb_booking_id">Select Booking ID</label>
        </div>
        <div class="col-md-4 col-sm-5 mg_bt_10_xs">
            <select id="cmb_booking_id" name="cmb_booking_id" style="width:100%"> 
                <?php get_package_booking_dropdown(); ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-4 text_center_xs">
            <button class="btn btn-info ico_right">Submit&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
    </div>

</form> 
<?= end_panel() ?>                   

<script>
$(document).ready(function() {
    $("#cmb_booking_id").select2();   

    $('#frm_booking_update_select').validate({
        submitHandler:function(form){
            var booking_id = $('#cmb_booking_id').val();
            if(booking_id==""){
                error_msg_alert('Select booking number.');
                return false;
            }
            form.submit();
        }
    });    
});
</script>

<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>