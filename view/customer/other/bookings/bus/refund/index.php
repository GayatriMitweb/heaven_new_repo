<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="booking_idb" id="booking_idb" style="width:100%" onchange="list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_booking = mysql_query("select * from bus_booking_master where customer_id='$customer_id' and booking_id in(select booking_id from bus_booking_entries where status='Cancel')  order by booking_id desc");
			        while($row_booking = mysql_fetch_assoc($sq_booking)){
					  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
					  $date = $row_booking['created_at'];
					  $yr = explode("-", $date);
					  $year =$yr[0];
			          ?>
			          <option value="<?= $row_booking['booking_id'] ?>"><?= get_bus_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_report_content" class="main_block"></div>

<script>
$('#booking_idb').select2();
function list_reflect()
{
	var booking_id = $('#booking_idb').val();
	$.post('bookings/bus/refund/list_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_report_content').html(data);
	});
}
list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>