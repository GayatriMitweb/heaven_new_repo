<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="exc_id1" id="exc_id1" style="width:100%" onchange="refund_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_exc = mysql_query("select * from excursion_master where customer_id='$customer_id' and  exc_id in ( select exc_id from excursion_master_entries where status='Cancel')order by exc_id desc");
			        while($row_exc = mysql_fetch_assoc($sq_exc)){
						$date = $row_exc['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_exc[customer_id]'"));
			          ?>
			          <option value="<?= $row_exc['exc_id'] ?>"><?= get_exc_booking_id($row_exc['exc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_report_refund" class="main_block"></div>


<script>
$('#exc_id1').select2();
function refund_report_reflect()
{
	var exc_id = $('#exc_id1').val();
	$.post('bookings/excursion/refund/refund_report_reflect.php', { exc_id : exc_id }, function(data){
		$('#div_report_refund').html(data);
	});
}
refund_report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>