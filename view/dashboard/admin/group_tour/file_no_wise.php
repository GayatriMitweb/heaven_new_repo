<?php 
include "../../../../model/model.php";
require_once('../../../../classes/tour_booked_seats.php');
require_once('../../../layouts/app_functions.php');

$tourwise_id = $_POST['tourwise_id'];

$sq_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));

$sq_tourwise =  mysql_fetch_assoc( mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'") );
$traveler_group_id = $sq_tourwise['traveler_group_id'];

$sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='tour' "));
$sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='traveling' "));
?>
<div class="row">
	
<div class="col-md-6">

	<div class="panel panel-default panel-body mg_bt_0 mg_bt_10_sm_xs" style="height:270px;">

		<div class="row"> <div class="col-md-12"> <div class="table-responsive">

			<table class="table table-bordered table-hover mg_bt_0">
				<thead>
					<th>No</th>
					<th>Name</th>
					<th>Booking Date</th>
					<th>Mobile</th>
				</thead>
				<tbody>
				<?php
				$count = 0;
				$sq_traveler = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");
				while($row_traveler = mysql_fetch_assoc($sq_traveler)){
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $row_traveler['m_honorific'].' '.$row_traveler['first_name'].' '.$row_traveler['last_name'] ?></td>
					<td><?= date('d-m-Y', strtotime($sq_tourwise['form_date'])) ?></td>
					<td><?= $sq_personal_info['mobile_no'] ?></td>
				</tr>
				<?php
				}
				?>			
				</tbody>
			</table>

		</div> </div> </div>

	</div>
	
</div>

<div class="col-md-6">
	
	<div class="panel panel-default panel-body mg_bt_0" style="height:270px;">
	<div class="row">
		<div class="col-md-6 col-sm-6">
	        <?php     
	            begin_widget();
	                $title_arr = array("Travel Fee", "Paid");
	                $content_arr = array($sq_tourwise['total_travel_expense'], $sq_total_travel_paid_amount['sum']);
	                $percent = ($sq_total_travel_paid_amount['sum']/$sq_tourwise['total_travel_expense'])*100;
	                $percent = round($percent, 2);
	                $label = "Travel Fee Paid";
	                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
	            end_widget();
	        ?>
	    </div>
	    <div class="col-md-6 col-sm-6">
	        <?php     
	            begin_widget();
	                $title_arr = array("Tour Fee", "Tour Paid");
	                $content_arr = array($sq_tourwise['total_tour_fee'], $sq_total_tour_paid_amount['sum']);
	                $percent = ($sq_total_tour_paid_amount['sum']/$sq_tourwise['total_tour_fee'])*100;
	                $percent = round($percent, 2);
	                $label = "Tour Fee Paid";
	                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
	            end_widget();
	        ?>
	    </div> 
	</div>

	</div>

</div>

</div>

<script>
	$(".dash_file_no .panel").mCustomScrollbar();
</script>