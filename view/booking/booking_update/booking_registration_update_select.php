<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Update Booking') ?>
<form action="booking_update.php" method="POST" onsubmit="return validate_submit()">
    <div class="panel panel-default panel-body">

        <div class="row">

            <div class="col-md-3 col-sm-4 text-right text_center_xs">
                <label for="cmb_tourwise_traveler_id">Select Booking ID</label>
            </div>
            <div class="col-md-4 col-sm-4 mg_bt_10_xs mg_bt_10_xs">
                <select id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" style="width:100%;">
                    <?php get_group_booking_dropdown(); ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-4 text_center_xs">
                <button class="btn btn-info ico_right">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
        </div>


    </div>

</form>
<?= end_panel() ?>                       

<script>
$(document).ready(function() {
    $("#cmb_tourwise_traveler_id").select2();   
});
</script>


<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>