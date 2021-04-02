<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">		
			<div class="col-md-3">
				<select name="miscellaneous_id_filter2" id="miscellaneous_id_filter2" style="width:100%" onchange="miscellaneous_report_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_miscellaneous = mysql_query("select * from miscellaneous_master where customer_id='$customer_id' ");
			        while($row_miscellaneous = mysql_fetch_assoc($sq_miscellaneous)){
						$date = $row_miscellaneous['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_miscellaneous[customer_id]'"));
			          ?>
			          <option value="<?= $row_miscellaneous['misc_id'] ?>"><?= get_misc_booking_id($row_miscellaneous['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>	
		</div>
	  </div>

<div id="div_miscellaneous_report_list" class="main_block"></div>

<script>
$('#miscellaneous_id_filter2').select2();
	function miscellaneous_report_list_reflect()
	{
		var miscellaneous_id = $('#miscellaneous_id_filter2').val();

		$.post('bookings/miscellaneous/report/misc_report_list_reflect.php', { misc_id : miscellaneous_id }, function(data){
			$('#div_miscellaneous_report_list').html(data);
		});
	}
	miscellaneous_report_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>