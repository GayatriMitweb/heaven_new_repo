<?php
include "../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="visa_id" id="visa_id" style="width:100%" title="Select Booking" onchange="content_reflect()">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_visa = mysql_query("select * from miscellaneous_master where misc_id in ( select misc_id from miscellaneous_master_entries where status='Cancel')order by misc_id desc");
		        while($row_visa = mysql_fetch_assoc($sq_visa)){

		         $date = $row_visa['created_at'];
		         $yr = explode("-", $date);
		         $year =$yr[0];

		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
		          ?>
		          <option value="<?= $row_visa['misc_id'] ?>"><?= get_misc_booking_id($row_visa['misc_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
</div>


<div id="div_content" class="main_block"></div>

<script>
$('#visa_id').select2();
function content_reflect()
{
	var misc_id = $('#visa_id').val();
	if(misc_id!= ''){
		$.post('refund/content_reflect.php', { misc_id : misc_id }, function(data){
			$('#div_content').html(data);
		});
	}
	else{
		$('#div_content').html('');
	}
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>