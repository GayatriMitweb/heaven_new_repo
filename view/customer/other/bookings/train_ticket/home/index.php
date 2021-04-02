<?php 
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="ticket_id" id="ticket_id" style="width:100%" onchange="train_ticket_customer_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_ticket = mysql_query("select * from train_ticket_master where customer_id='$customer_id'");
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

<div id="div_ticket_customer_list_reflect" class="main_block"></div>
<div id="div_ticket_update_content" class="main_block"></div>
<div id="div_customer_save_modal" class="main_block"></div>
<div id="div_train_ticket_view_modal" class="main_block"></div>

<script>
$('#ticket_id').select2();
	function train_ticket_customer_list_reflect()
	{
		var ticket_id = $('#ticket_id').val()

		$.post('bookings/train_ticket/home/train_ticket_list_reflect.php', { ticket_id : ticket_id }, function(data){
			$('#div_ticket_customer_list_reflect').html(data);
		});
	}
	train_ticket_customer_list_reflect();
	function train_ticket_view_modal(train_ticket_id)
	{
		$.post('bookings/train_ticket/home/view/index.php', { train_ticket_id : train_ticket_id }, function(data){
			$('#div_train_ticket_view_modal').html(data);
		});
	}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>