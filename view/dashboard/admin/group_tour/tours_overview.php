<?php 
include "../../../../model/model.php";
require_once('../../../../classes/tour_booked_seats.php');
?>

<div class="dash_tour_overview_body_inner">

<?php
$tour_id = $_POST['tour_id'];
$query = "select * from tour_master where 1 ";
if($tour_id!=""){
	$query .=" and tour_id='$tour_id'";	
}

$count = 0;
$color_arr = array('success_bg', 'danger_bg', 'primary_bg', 'info_bg');

$sq_tours = mysql_query($query);
while($row_tours = mysql_fetch_assoc($sq_tours)){

	$tour_id = $row_tours['tour_id'];
	$tour_name = $row_tours['tour_name'];

	$sq_groups = mysql_query("select * from tour_groups where tour_id='$tour_id'");	
	while($row_groups = mysql_fetch_assoc($sq_groups)){

		$tour_group_id = $row_groups['group_id'];
		$tour_group = date('d-m-Y', strtotime($row_groups['from_date'])).' to '.date('d-m-Y', strtotime($row_groups['to_date']));

		$capacity = $row_groups['capacity'];
		$booked_seats = $bk_seats->booked_seats($tour_id, $tour_group_id);
		$available_seats = $capacity - $booked_seats;

		$sq_travel_total = mysql_fetch_assoc(mysql_query("select sum(total_travel_expense) as sum from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id'"));
		$sq_tour_total = mysql_fetch_assoc(mysql_query("select sum(total_tour_fee) as sum from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id'"));

		$travel_total = $sq_travel_total['sum'];
		$tour_total = $sq_tour_total['sum'];
		$total_fee = $travel_total + $tour_total;

		$sq_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id in ( select id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id')") );
		$paid_fee = $sq_payment['sum'];

		$balance_fee = $total_fee - $paid_fee;

		$count++;

		if($count==4){ $count=0; }

		?>
		<div class="dash_tour_overview">

			<div class="col-md-12 group_name"><?= $tour_group ?></div>
		
			<div class="col-sm-6">
					
				<div class="head green">
					<div class="element">
						<div class="stat"><?= $capacity ?></div>
						<div class="text">Capacity</div>	
					</div>
					<div class="element">
						<div class="stat"><?= $booked_seats ?></div>
						<div class="text">Booked</div>
					</div>						
				</div>
				<div class="footer mg_bt_10_xs"><span>Available Seats</span><span><?= $available_seats ?></span></div>
					
			</div>

			<div class="col-sm-6">
					
				<div class="head yellow">
					<div class="element">
						<div class="stat"><?= $total_fee ?></div>
						<div class="text">Tour Amount</div>	
					</div>
					<div class="element">
						<div class="stat"><?= $paid_fee ?></div>
						<div class="text">Received</div>
					</div>						
					
				</div>
				<div class="footer"><span>Balance</span><span><?= $balance_fee ?></span></div>

			</div>

		</div>
		<?php


	}

}
?>

</div>

<script>
	//$(".dash_tour_overview_body").owlCarousel('destroy');
	$(".dash_tour_overview_body_inner").owlCarousel({ items : 1, navigation : true, navigationText : ["",""], itemsDesktopSmall : [1500,1], itemsTablet: [600,1] });
</script>