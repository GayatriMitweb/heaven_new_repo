<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="misc_id_filter1" id="misc_id_filter1" class="form-control" onchange="misc_payment_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_misc = mysql_query("select * from miscellaneous_master where customer_id='$customer_id'");
			        while($row_misc = mysql_fetch_assoc($sq_misc)){
								$date = $row_misc['created_at'];
								$yr = explode("-", $date);
								$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_misc[customer_id]'"));
			          ?>
			          <option value="<?= $row_misc['misc_id'] ?>"><?= get_misc_booking_id($row_misc['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>		
		</div>
	  </div>

<div id="div_misc_payment_list" class="main_block"></div>


<script>
$('#misc_id_filter1').select2();
	function misc_payment_list_reflect()
	{
		var misc_id = $('#misc_id_filter1').val();
		$.post('bookings/miscellaneous/payment/misc_payment_list_reflect.php', { misc_id : misc_id }, function(data){
			$('#div_misc_payment_list').html(data);
		});
	}
	misc_payment_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>