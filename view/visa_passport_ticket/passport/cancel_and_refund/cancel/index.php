<?php
include "../../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="passport_id" id="passport_id" style="width:100%" onchange="content_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_passport = mysql_query("select * from passport_master order by passport_id desc");
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

<div id="div_cancel_passport" class="main_block"></div>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>


<script>
$('#passport_id').select2();
function content_reflect()
{
	var passport_id = $('#passport_id').val();
	if(passport_id!=''){
		$.post('cancel/content_reflect.php', { passport_id : passport_id }, function(data){
			$('#div_cancel_passport').html(data);
		});
	}else{
		$('#div_cancel_passport').html('');
	}
}
</script>