<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="passport_id1" id="passport_id1" style="width:100%" onchange="refund_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_passport = mysql_query("select * from passport_master where customer_id='$customer_id' and passport_id in ( select passport_id from passport_master_entries where status='Cancel' )  order by passport_id desc");
			        while($row_passport = mysql_fetch_assoc($sq_passport)){

						$date = $row_passport['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
			          ?>
			          <option value="<?= $row_passport['passport_id'] ?>"><?= get_passport_booking_id($row_passport['passport_id']).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	  </div>

<div id="div_report_refund" class="main_block"></div>


<script>
$('#passport_id1').select2();
function refund_report_reflect()
{
	var passport_id = $('#passport_id1').val();
	$.post('bookings/passport/refund/refund_report_reflect.php', { passport_id : passport_id }, function(data){
		$('#div_report_refund').html(data);
	});
}
refund_report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>