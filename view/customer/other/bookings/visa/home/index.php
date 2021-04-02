<?php 
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="visa_id_filter" id="visa_id_filter" class="form-control" onchange="visa_customer_list_reflect()">
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

<div id="div_visa_customer_list_reflect" class="main_block"></div>
<div id="div_visa_content_display" class="main_block"></div>
<script>
$('#visa_id_filter').select2();
	function visa_customer_list_reflect()
	{
		var visa_id = $('#visa_id_filter').val()
		$.post('bookings/visa/home/visa_list_reflect.php', { visa_id : visa_id }, function(data){
			$('#div_visa_customer_list_reflect').html(data);
		});
	}
	visa_customer_list_reflect();
	
	function visa_display_modal(visa_id)
	{
		$.post('bookings/visa/home/view/index.php', { visa_id : visa_id }, function(data){
			$('#div_visa_content_display').html(data);
		});
	}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>