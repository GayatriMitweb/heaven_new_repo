<?php
include "../../../model/model.php";
?>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="booking_id" id="booking_id" style="width:100%" title="Select Booking" onchange="content_reflect()">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_b2b = mysql_query("select * from b2b_booking_master where booking_id in ( select booking_id from b2b_booking_master where status='Cancel' )  order by booking_id desc");
		        while($row_b2b = mysql_fetch_assoc($sq_b2b)){

		        	$date = $row_b2b['created_at'];
		          $yr = explode("-", $date);
		          $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_b2b[customer_id]'"));
		          ?>
		          <option value="<?= $row_b2b['booking_id'] ?>"><?= get_b2b_booking_id($row_b2b['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
</div>

<div id="div_cancel_b2b" class="main_block"></div>


<script>
$('#booking_id').select2();
function content_reflect()
{
	var booking_id = $('#booking_id').val();
	if(booking_id != ''){
		$.post('refund/content_reflect.php', { booking_id : booking_id }, function(data){
			$('#div_cancel_b2b').html(data);
		});
	}
	else{
		$('#div_cancel_b2b').html('');
	}
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>