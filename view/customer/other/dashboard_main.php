<?php 
include_once('../../../model/model.php');
include_once('../layouts/admin_header.php');

$customer_id = $_SESSION['customer_id'];

$sq_group_booking_count = mysql_num_rows(mysql_query("select * from tourwise_traveler_details where customer_id='$customer_id'"));
$sq_package_booking_count = mysql_num_rows(mysql_query("select * from package_tour_booking_master where customer_id='$customer_id'"));
$sq_visa_count = mysql_num_rows(mysql_query("select * from visa_master where customer_id='$customer_id'"));
$sq_passport_count = mysql_num_rows(mysql_query("select * from passport_master where customer_id='$customer_id'"));
$sq_ticket_count = mysql_num_rows(mysql_query("select * from ticket_master where customer_id='$customer_id'"));
$sq_hotel_booking_count = mysql_num_rows(mysql_query("select * from hotel_booking_master where customer_id='$customer_id'"));
$sq_car_rental_booking_count = mysql_num_rows(mysql_query("select * from car_rental_booking where customer_id='$customer_id'"));
$sq_train_ticket_count = mysql_num_rows(mysql_query("select * from train_ticket_master where customer_id='$customer_id'"));
$sq_bus_booking_count = mysql_num_rows(mysql_query("select booking_id from bus_booking_master where customer_id='$customer_id'"));
$sq_forex_booking_count = mysql_num_rows(mysql_query("select booking_id from forex_booking_master where customer_id='$customer_id'"));
?>

<div class="col-md-12 mg_tp_20">
	<div class="panel panel-default panel-body pad_8 bg_light mg_bt_-1 text-center main_block">
		<div class="row">
			<div class="col-md-2 col-md-offset-5">
				<select name="booking_type" id="booking_type" title="Booking Type" onchange="customer_bookings_reflect(this.value)">
		            <option value="">Booking Type</option>
		            <option value="Package Tour">Package Tour</option>
		            <option value="Group Tour">Group Tour</option>
		            <option value="Visa">Visa</option> 
		            <option value="Passport">Passport</option>
		            <option value="Air Ticket">Flight Ticket</option>
		            <option value="Train Ticket">Train Ticket</option>
		            <option value="Hotel">Hotel</option>
		            <option value="Car Rental">Car Rental</option>
		            <option value="Bus">Bus</option>
		            <option value="Forex">Forex</option>
		            <option value="Activity">Activity</option>
		            <option value="Miscellaneous">Miscellaneous</option>
		        </select>
			</div>
		</div>
	</div> 
</div>

<div id="div_customer_booking_content" class="main_block mg_tp_20"></div>

<script>
 function customer_bookings_reflect(booking_type){

	if(booking_type=="Group Tour"){
		$.post('bookings/group_booking/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Package Tour"){
		$.post('bookings/package_booking/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Visa"){
		$.post('bookings/visa/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Passport"){
		$.post('bookings/passport/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Air Ticket"){
		$.post('bookings/ticket/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Hotel"){
		$.post('bookings/hotel/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Car Rental"){
		$.post('bookings/car_rental/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Train Ticket"){
		$.post('bookings/train_ticket/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Bus"){
		$.post('bookings/bus/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Forex"){
		$.post('bookings/forex/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Activity"){
		$.post('bookings/excursion/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});	
	}
	if(booking_type=="Miscellaneous"){
		$.post('bookings/miscellaneous/index.php', {}, function(data){
			$('#div_customer_booking_content').html(data);
		});
	}
}
customer_bookings_reflect('Package Tour');
</script>
<?php 
include_once('../layouts/admin_footer.php');
?>