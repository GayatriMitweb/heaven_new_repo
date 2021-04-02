<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<div class="app_panel_content Filter-panel">
		
	<div class="col-md-4 col-md-offset-4">
		<select name="train_ticket_id_filter" id="train_ticket_id_filter" style="width:100%" title="Booking ID" onchange="train_ticket_upload_list_reflect()">
	        <option value="">Select Booking ID</option>
	        <?php 
	        $query = "select * from train_ticket_master where 1 ";
	        include "../../../../model/app_settings/branchwise_filteration.php";
	        $query .= " order by train_ticket_id desc ";
	        $sq_ticket = mysql_query($query);
	        while($row_ticket = mysql_fetch_assoc($sq_ticket)){
	        	$booking_date = $row_ticket['created_at'];
				$yr = explode("-", $booking_date);
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
<div id="div_train_ticket_upload_list"></div>
<script>
$('#train_ticket_id_filter').select2();
function train_ticket_upload_list_reflect()
{
	var train_ticket_id = $('#train_ticket_id_filter').val();
	$.post('upload_ticket/ticket_upload_list_reflect.php', { train_ticket_id : train_ticket_id }, function(data){
		$('#div_train_ticket_upload_list').html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>