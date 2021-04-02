<?php
include "../../../../model/model.php";
?>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="exc_id" id="exc_id" style="width:100%" onchange="exc_entries_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_exc = mysql_query("select * from excursion_master order by exc_id desc");
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


<div id="div_content" class="main_block"></div>


<script>
$('#exc_id').select2();
function exc_entries_reflect()
{
	var exc_id = $('#exc_id').val();
	if(exc_id!=''){
		$.post('cancel/content_reflect.php', { exc_id : exc_id }, function(data){
			$('#div_content').html(data);
		});
	}
	else{
		$('#div_content').html('');
	}
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>