<?php
include "../../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="visa_id" id="visa_id" style="width:100%" onchange="content_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_visa = mysql_query("select * from visa_master where visa_id in ( select visa_id from visa_master_entries where status='Cancel')order by visa_id desc");
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


<div id="div_content" class="main_block"></div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_id').select2();
function content_reflect()
{
	var visa_id = $('#visa_id').val();
	if(visa_id != ''){
		$.post('refund/content_reflect.php', { visa_id : visa_id }, function(data){
			$('#div_content').html(data);
		});
	}
	else{
		$('#div_content').html('');
	}
}
</script>