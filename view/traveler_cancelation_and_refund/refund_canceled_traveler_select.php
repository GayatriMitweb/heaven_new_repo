<?php
include "../../model/model.php";
?>
<!-- <?= begin_panel('Group Tour Refund',67); ?> -->

<div class="app_panel_content Filter-panel">
    <div class="row text_center_xs">
        <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-3 col-xs-12 mg_bt_10_xs">
            <select id="cmb_tourwise_traveler_id" name="cmb_tourwise_traveler_id" style="width:100%" title="Select Booking ID" class="form-control" onchange="cancel_booking_reflect();">
                <option value="">Select Booking</option>
                <?php 
                    $sq_tourwise_traveler_det = mysql_query("select id, traveler_group_id,form_date from tourwise_traveler_details where tour_group_status != 'Cancel' order by id desc");
                    while($row_tourwise_traveler_details = mysql_fetch_assoc( $sq_tourwise_traveler_det ))
                    {
                        $sq_travelers_details = mysql_query("select m_honorific, first_name, last_name from travelers_details where traveler_group_id='$row_tourwise_traveler_details[traveler_group_id]' and status='Cancel' "); 
                        while($row_travelers_details = mysql_fetch_assoc( $sq_travelers_details )){
                        $date = $row_tourwise_traveler_details['form_date'];
                        $yr = explode("-", $date);
                        $year =$yr[0];
                        ?>
                        <option value="<?php echo $row_tourwise_traveler_details['id'] ?>"><?php echo get_group_booking_id($row_tourwise_traveler_details['id'],$year).' : '.$row_travelers_details['m_honorific'].' '.$row_travelers_details['first_name'].' '.$row_travelers_details['last_name']; ?></option>
                        <?php
                        } 
                        ?>
                        <?php      
                    }    
                ?>
            </select>
        </div>
    </div>
</div>      
<div id="div_booking_refund_reflect"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
$("#cmb_tourwise_traveler_id").select2(); 
function cancel_booking_reflect(){
    var booking_id = $('#cmb_tourwise_traveler_id').val();
    if(booking_id!=''){
        $.post('refund_traveler_booking.php', { cmb_tourwise_traveler_id : booking_id }, function(data){
            $('#div_booking_refund_reflect').html(data);
        });
    }else{
        $('#div_booking_refund_reflect').html('');
    }
}
// function validate_submit()
// {
//     var tourwise_traveler_id = $("#cmb_tourwise_traveler_id").val();

//     if(tourwise_traveler_id=="")
//     {
//         error_msg_alert("Please select Guest Booking ID!");
//         return false;
//     }
    
// }

</script>


<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>       