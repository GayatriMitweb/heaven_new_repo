<?php
include "../../../../../model/model.php";
/*======******Header******=======*/
include_once('../../../../layouts/fullwidth_app_header.php'); 

$quotation_id = $_GET['quotation_id'];
$role = $_SESSION['role'];

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from car_rental_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$emp_name = 'Admin';
}
else{
	$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Online Booking</title>	

	<?php admin_header_scripts(); ?>

</head>
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">

<?= begin_panel('Quotation View') ?>
<div class="container">


<div class="main_block mg_tp_30"></div>
<h3 class="editor_title main_block">Enquiry Information</h3>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Customer Name</label> : <?= $sq_quotation['customer_name'] ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Email ID </label> : <?= $sq_quotation['email_id'] ?></div> 
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Mobile No</label> : <?= $sq_quotation['mobile_no'] ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>No Of Pax</label> : <?= $sq_quotation['total_pax'] ?> </div>
		
	</div>
	<div class="row">
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Days Of Travelling</label> : <?= $sq_quotation['days_of_traveling'] ?> </div>
		<?php if($sq_quotation['travel_type']=='Outstation'){ ?> <div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Travelling Date</label> : <?= get_date_user($sq_quotation['traveling_date']) ?> </div> <?php } ?> 
		<!-- <div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Vehicle Type</label> : <?= $sq_quotation['vehicle_type'] ?> </div> -->
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Travel Type</label> : <?= $sq_quotation['travel_type'] ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Route</label> : <?= ($sq_quotation['travel_type']=='Local')?$sq_quotation['local_places_to_visit']:$sq_quotation['places_to_visit'] ?> </div>
		
	</div>
	<!-- <div class="row">
		<div class="col-md-12 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Route</label> : <?= $sq_quotation['places_to_visit'] ?> </div>
	</div> -->
	<div class="row">
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Vehicle Name</label> : <?= $sq_quotation['vehicle_name'] ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Travel D/T From</label> : <?= get_date_db($sq_quotation['from_date']) ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Travel D/T To</label> : <?= get_date_db($sq_quotation['to_date']) ?> </div>
		<!--<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Trip Type</label> : <?= $sq_quotation['trip_type'] ?> </div>-->
	</div>
	<div class="row">
		<!-- <div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Route</label> : <?=  $sq_quotation['route'] ?> </div> -->
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Extra KM Cost</label> : <?= $sq_quotation['extra_km_cost'] ?> </div>
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Extra Hr Cost</label> : <?= ($sq_quotation['extra_hr_cost']) ?> </div>
		<!--<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Daily KM</label> : <?= $sq_quotation['daily_km'] ?> </div>-->
		<div class="col-md-3 mg_bt_10" style="border-right: 1px solid #ddd;"> <label>Quotation Date</label> : <?=  get_date_user($sq_quotation['quotation_date']) ?> </div>		
	</div>
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs" style="border-right: 1px solid #ddd;"> <div class="highlighted_cost"><label>Quotation Cost</label> : <?= $sq_quotation['total_tour_cost'] ?> </div></div>
		<div class="col-md-3" style="border-right: 1px solid #ddd;"> <div class="highlighted_cost"><label>Created By</label> : <?= $emp_name ?> </div></div>
	</div>
</div>

<div class="main_block mg_tp_30"></div>
<h3 class="editor_title main_block">Costing Information</h3>
<table class="table table-bordered">
	<thead>
		<tr class="table-heading-row">
			<th>Basic</th>
			<th>Service_Charge</th>
			<th>Tax</th>
			<?php if($sq_quotation['markup_cost'] != '0'){ ?>
			<th>Markup</th> <?php } ?>
			<th>Markup TAX</th>
			<?php if($sq_quotation['travel_type'] == 'Outstation'){ ?>
			<th>Permit</th>
			<th>Toll Parking</th>
			<th>Driver Allowance</th>
			<th>State Entry</th>
			<th>Other Charges</th>
			<?php } ?>
			<th>Round Off</th>
			<th>Quotation_cost</th>
		</tr>
	</thead>
	<tbody>
			<tr>
				<td><?= number_format($sq_quotation['subtotal'],2) ?></td>
				<td><?= number_format($sq_quotation['service_charge'],2) ?></td>
				<td><?= $sq_quotation['service_tax_subtotal'] ?></td>
				<?php if($sq_quotation['markup_cost'] != '0'){ ?>
				<td><?= number_format($sq_quotation['markup_cost'],2) ?></td> <?php } ?>
				<td><?= $sq_quotation['markup_cost_subtotal'] ?></td>
				<?php if($sq_quotation['travel_type'] == 'Outstation'){ ?>
				<td><?= number_format($sq_quotation['permit'],2) ?></td>
				<td><?= number_format($sq_quotation['toll_parking'],2) ?></td>
				<td><?= number_format($sq_quotation['driver_allowance'],2)?></td>
				<td><?= number_format($sq_quotation['state_entry'],2)?></td>
				<td><?= number_format($sq_quotation['other_charge'],2)?></td>
				<?php } ?>
				<td><?= number_format($sq_quotation['roundoff'],2) ?></td>
				<td><?= number_format($sq_quotation['total_tour_cost'],2) ?></td>
			</tr>
	</tbody>
</table>
	
</div>
<?= end_panel() ?>

</script>
<?php
/*======******Footer******=======*/
include_once('../../../../layouts/fullwidth_app_footer.php');
?>