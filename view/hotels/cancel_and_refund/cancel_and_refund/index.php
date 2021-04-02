<?php
include "../../../../model/model.php";
?>
<div class="panel panel-default panel-body pad_8 mg_bt_-1">
	<div class="col-md-4 col-md-offset-4">
		<select name="booking_id" id="booking_id" style="width:100%" onchange="hotel_entries_reflect()">
	        <option value="">Select Booking</option>
	        <?php 
	        $sq_hotel = mysql_query("select * from hotel_booking_master");
	        while($row_hotel = mysql_fetch_assoc($sq_hotel)){

	          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_hotel[customer_id]'"));
	          ?>
	          <option value="<?= $row_hotel['booking_id'] ?>"><?= get_hotel_booking_id($row_hotel['booking_id']).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	          <?php
	        }
	        ?>
	    </select>
	</div>
</div>
<div id="div_cancel_hotel"></div>


<script>
$('#booking_id').select2();
function hotel_entries_reflect()
{
	var booking_id = $('#booking_id').val();
	$.post('cancel_and_refund/hotel_entries_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_cancel_hotel').html(data);
	});
}
</script>