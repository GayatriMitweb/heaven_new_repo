<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="visa_id_filter1" id="visa_id_filter1" class="form-control" onchange="visa_payment_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_visa = mysql_query("select * from visa_master where customer_id='$customer_id'");
			        while($row_visa = mysql_fetch_assoc($sq_visa)){
						$date = $row_visa['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
			          ?>
			          <option value="<?= $row_visa['visa_id'] ?>"><?= get_visa_booking_id($row_visa['visa_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>		
		</div>
	  </div>

<div id="div_visa_payment_list" class="main_block"></div>


<script>
$('#visa_id_filter1').select2();
	function visa_payment_list_reflect()
	{
		var visa_id = $('#visa_id_filter1').val();
		$.post('bookings/visa/payment/visa_payment_list_reflect.php', { visa_id : visa_id }, function(data){
			$('#div_visa_payment_list').html(data);
		});
	}
	visa_payment_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>