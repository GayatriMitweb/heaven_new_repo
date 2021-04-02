<?php
include "../../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="train_ticket_id" id="train_ticket_id" style="width:100%" onchange="content_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_ticket = mysql_query("select * from train_ticket_master where train_ticket_id in ( select train_ticket_id from train_ticket_master_entries where status='Cancel' ) order by train_ticket_id desc");
		        while($row_ticket = mysql_fetch_assoc($sq_ticket)){
		        $date = $row_ticket['created_at'];
		          $yr = explode("-", $date);
		          $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
		          ?>
		          <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
</div>

<div id="div_cancel_ticket" class="main_block"></div>

<script>
$('#train_ticket_id').select2();
function content_reflect(){
	var train_ticket_id = $('#train_ticket_id').val();
	if(train_ticket_id!=''){
		$.post('refund/content_reflect.php', { train_ticket_id : train_ticket_id }, function(data){
			$('#div_cancel_ticket').html(data);
		});
	}else{
		$('#div_cancel_ticket').html('');
	}
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>    