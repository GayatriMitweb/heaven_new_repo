<?php 
include_once('../../../model/model.php');

$date = $_POST['date'];

$month = date('m', strtotime($date));
$year = date('Y', strtotime($date));

//*********Received Payment******//
$sq_group_total_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from payment_master where MONTH(date)='$month' and YEAR(date)='$year'") );
$sq_package_total_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from package_payment_master where MONTH(date)='$month' and YEAR(date)='$year'") );
$total_payment = $sq_group_total_payment['sum'] + $sq_package_total_payment['sum'];


//*********Expense Given******//
$sq_office_expense = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from office_expense_master where MONTH(expense_date)='$month' and YEAR(expense_date)='$year'") );
$office_expense = $sq_office_expense['sum'];

$sq_tour_refund = mysql_fetch_assoc( mysql_query("select sum(refund_amount) as sum from refund_tour_cancelation where MONTH(refund_date)='$month' and YEAR(refund_date)='$year'") );
$tour_refund = $sq_tour_refund['sum'];

$sq_traveler_refund = mysql_fetch_assoc( mysql_query("select sum(total_refund) as sum from refund_traveler_cancelation where MONTH(created_at)='$month' and YEAR(created_at)='$year'") );
$group_traveler_refund = $sq_traveler_refund['sum'];

$sq_package_traveler_refund = mysql_fetch_assoc( mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where MONTH(created_at)='$month' and YEAR(created_at)='$year'") );
$package_traveler_refund = $sq_package_traveler_refund['sum'];

$sq_group_tour_vendor_hotel_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from vendor_group_tour_hotel_payment where MONTH(payment_date)='$month' and YEAR(payment_date)='$year'") );
$group_tour_vendor_hotel_payment = $sq_group_tour_vendor_hotel_payment['sum'];

$sq_group_tour_vendor_transport_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from vendor_group_tour_transport_payment where MONTH(payment_date)='$month' and YEAR(payment_date)='$year'") );
$group_tour_vendor_transport_payment = $sq_group_tour_vendor_transport_payment['sum'];

$sq_package_tour_vendor_hotel_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from vendor_package_tour_hotel_payment where MONTH(payment_date)='$month' and YEAR(payment_date)='$year'") );
$package_tour_vendor_hotel_payment = $sq_package_tour_vendor_hotel_payment['sum'];

$sq_package_tour_vendor_transport_payment = mysql_fetch_assoc( mysql_query("select sum(amount) as sum from vendor_package_tour_transport_payment where MONTH(payment_date)='$month' and YEAR(payment_date)='$year'") );
$package_tour_vendor_transport_payment = $sq_package_tour_vendor_transport_payment['sum'];

$total_expense = $office_expense + $tour_refund + $group_traveler_refund + $package_traveler_refund + $group_tour_vendor_hotel_payment + $group_tour_vendor_transport_payment + $package_tour_vendor_hotel_payment + $package_tour_vendor_transport_payment;

//*********Total Revenue******//
$revenue = $total_payment - $total_expense;
if($revenue<0){ $revenue = 0; }
?>

<div class="dash_tour_overview">

	<div class="row">

		<div class="col-md-12 text-left">
			<label for="">Total revenue of <span class="theme_col"><?= $revenue ?></span></label>
		</div>
	
		<div class="col-md-4">
			<div class="head red">					
				<div class="element">
					<div class="stat"><?= $total_expense ?></div>
					<div class="text">Total Expense</div>
				</div>						
			</div>
			<div class="footer mg_bt_10_xs"><span>Expense</span></div>
		</div>

		<div class="col-md-4">
			<div class="head primary">					
				<div class="element">
					<div class="stat"><?= $total_payment ?></div>
					<div class="text">Payment</div>
				</div>						
			</div>
			<div class="footer mg_bt_10_xs"><span>Payment</span></div>
		</div>

		<div class="col-md-4">
			<div class="head info">					
				<div class="element">
					<div class="stat"><?= $revenue ?></div>
					<div class="text">Total Revenue</div>
				</div>						
			</div>
			<div class="footer"><span>Revenue</span></div>
		</div>

	</div>	

</div>