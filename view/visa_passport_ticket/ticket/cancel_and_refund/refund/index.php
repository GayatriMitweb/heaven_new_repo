<?php
include "../../../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
			<select name="ticket_id" id="ticket_id" style="width:100%" onchange="content_reflect()" title="Select Booking">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_ticket = mysql_query("select * from ticket_master where ticket_id in ( select ticket_id from ticket_master_entries where status='Cancel' ) order by ticket_id desc");
		        while($row_ticket = mysql_fetch_assoc($sq_ticket)){

		         $date = $row_ticket['created_at'];
		          $yr = explode("-", $date);
		          $year =$yr[0];
		          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
		          ?>
		          <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
	</div>
</div>

<div id="div_cancel_ticket" class="main_block"></div>


<script>
$('#ticket_id').select2();
function content_reflect()
{
	var ticket_id = $('#ticket_id').val();
	if(ticket_id!=''){
		$.post('refund/content_reflect.php', { ticket_id : ticket_id }, function(data){
			$('#div_cancel_ticket').html(data);
		});
	}else{
		$('#div_cancel_ticket').html('');
	}
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>