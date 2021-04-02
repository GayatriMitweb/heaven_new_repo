<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
        <div class="row">
        	<div class="col-md-3">
        		<select name="tourwise_traveler_idtr" id="tourwise_traveler_idtr" title="Select Booking" onchange="refund_list_reflect()" class="form-control">
        			<option value="">Select Booking</option>
                    <?php 
                        $sq_tourwise_traveler_det = mysql_query("select id, traveler_group_id,form_date from tourwise_traveler_details where customer_id='$customer_id'");
                        while($row_tourwise_traveler_details = mysql_fetch_assoc( $sq_tourwise_traveler_det ))
                        {
                          $date = $row_tourwise_traveler_details['form_date'];
                          $yr = explode("-", $date);
                          $year =$yr[0];
                           $sq_travelers_details = mysql_query("select m_honorific, first_name, last_name from travelers_details where traveler_group_id='$row_tourwise_traveler_details[traveler_group_id]' and status='Cancel' "); 
                           while($row_travelers_details = mysql_fetch_assoc( $sq_travelers_details ))
                           {
                            ?>
                            <option value="<?php echo $row_tourwise_traveler_details['id'] ?>"><?= get_group_booking_id($row_tourwise_traveler_details['id'],$year).' : '.$row_travelers_details['m_honorific'].' '.$row_travelers_details['first_name'].' '.$row_travelers_details['last_name']; ?></option>
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

<div id="div_payment_list" class="main_block"></div>

<script>
$('#tourwise_traveler_idtr').select2();
function refund_list_reflect()
{
	var tourwise_traveler_id = $('#tourwise_traveler_idtr').val();
	$.post('bookings/group_booking/traveler_refund/refund_list_reflect.php', { tourwise_traveler_id : tourwise_traveler_id }, function(data){
		$('#div_payment_list').html(data);
	});
}
refund_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>