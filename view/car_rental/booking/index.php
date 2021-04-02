<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='car_rental/booking/index.php'"));
$branch_status = $sq['branch_status'];
 
?>
<div id="markup_confirm"></div>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
 <input type="hidden" id="whatsapp_switch"  value="<?= $whatsapp_switch ?>" >
<?= begin_panel('Car Rental Booking',56) ?>

 <div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<label for="rd_booking" class="app_dual_button active">
	        <input type="radio" id="rd_booking" name="rd_app" checked onchange="car_content_load()">
	        &nbsp;&nbsp;Booking
	    </label>
	    <label for="rd_payment" class="app_dual_button">
	        <input type="radio" id="rd_payment" name="rd_app" onchange="car_content_load()">
	        &nbsp;&nbsp;Receipt
	    </label>
	</div>   
</div>

<div id="div_car_booking_content"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function business_rule_load(){
	get_auto_values('balance_date','basic_amount','payment_mode','service_charge','markup_cost','save','false','service_charge');
}
function car_content_load(offset='')
{
	var id = $('input[name="rd_app"]:checked').attr('id');
    var branch_status = $('#branch_status').val();
	if(id=="rd_booking"){
		$.post('booking_home.php', {branch_status : branch_status}, function(data){
			$('#div_car_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('../payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_car_booking_content').html(data);
		});
	}
}
car_content_load();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>