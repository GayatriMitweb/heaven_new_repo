<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="passport_id_filter2" id="passport_id_filter2" style="width:100%" onchange="passport_report_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_passport = mysql_query("select * from passport_master where customer_id='$customer_id'");
			        while($row_passport = mysql_fetch_assoc($sq_passport)){

						$date = $row_passport['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
			          ?>
			          <option value="<?= $row_passport['passport_id'] ?>"><?= get_passport_booking_id($row_passport['passport_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>		
		</div>
	</div>

<div id="div_passport_report_list" class="main_block"></div>

<script>
$('#passport_id_filter2').select2();
function passport_report_list_reflect()
{
	var passport_id = $('#passport_id_filter2').val();

	$.post('bookings/passport/report/passport_report_list_reflect.php', { passport_id : passport_id }, function(data){
		$('#div_passport_report_list').html(data);
	});
}
passport_report_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>