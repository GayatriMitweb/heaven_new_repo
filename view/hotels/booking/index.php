<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='hotels/booking/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Hotel Booking',54) ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
    <label for="rd_booking" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_booking" name="app_hotel_booking" checked  onchange="hotel_booking_home_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_payment" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>
    <label for="rd_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_report" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
        &nbsp;&nbsp;Report
    </label>
    <!-- <label for="rd_payment_status" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_payment_status" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
        &nbsp;&nbsp;Summary
    </label> -->
</div>

<div id="div_hotel_booking_content"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function hotel_booking_home_content_reflect()
{
	var id = $('input[name="app_hotel_booking"]:checked').attr('id');
    var branch_status = $('#branch_status').val();
	if(id=="rd_booking"){
		$.post('booking/index.php', {branch_status : branch_status}, function(data){
			$('#div_hotel_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_hotel_booking_content').html(data);
		});
	}
    if(id=="rd_report"){
        $.post('report/index.php', {branch_status : branch_status}, function(data){
            $('#div_hotel_booking_content').html(data);
        });
    }
    if(id=="rd_payment_status"){
        $.post('payment_status/index.php', {branch_status : branch_status}, function(data){
            $('#div_hotel_booking_content').html(data);
        });
    }
}
hotel_booking_home_content_reflect();

function customer_booking_load(from, to)
{
    var customer_id = $('#'+from).val();
    $.post('inc/customer_booking_load.php', { customer_id : customer_id }, function(data){
        $('#'+to).html(data);
    });
}
</script>
<script src="js/booking.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>