<div class="container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
			<div class="row no-gutters">
				<legend>Hotel Details</legend>
					<div class="col-md-12 mg_bt_20">
						<div class="row">
							<?php
								$customer_det = mysql_fetch_assoc(mysql_query("select first_name,middle_name,last_name from customer_master where customer_id = ".$sq_b2b['customer_id']));
							?>
							<div class='col-md-6'>Customer Name :  <strong><?= ucfirst($customer_det['first_name']).' '.$customer_det['middle_name'].' '.$customer_det['last_name'] ?></strong></div>
						</div>
					</div>
					<?php
					for($i=0;$i<sizeof($hotel_detail);$i++){
					?>
					<div class="col-md-12 mg_bt_20">
						<div class="row">
							<div class='col-md-6'>Check-In Date :  <strong><?= get_date_user($hotel_detail[$i]['checkin'][0]) ?></strong></div>
							<div class='col-md-6'>Check-Out Date : <strong><?= get_date_user($hotel_detail[$i]['checkout'][0]) ?></strong></div>
							<div class='col-md-6'>Room Type(s) : <strong><?= implode(',',$hotel_detail[$i]['room_cat']) ?></strong></div>
							<div class='col-md-6'>No. of Rooms : <strong><?= sizeof($hotel_detail[$i]['room_cat']) ?></strong></div>
							<div class='col-md-6'>Total Guest(s) : <strong><?= $hotel_detail[$i]['adults']." Adult(s), ".$hotel_detail[$i]['child']." Child(ren)" ?></strong></div>
						</div>
					</div>
					<br>
					<?php } ?>
			</div>
		</div>
	</div>
</div>