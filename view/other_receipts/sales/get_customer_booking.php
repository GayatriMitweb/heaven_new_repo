<?php	
$count = 1;
//B2B
$query = "select * from b2b_booking_master where 1 and customer_id='$customer_id'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$sq_b2b = mysql_query($query);
while($row_b2b = mysql_fetch_assoc($sq_b2b)){
	$hotel_total = 0;
	$transfer_total = 0;
	$activity_total = 0;
	$tours_total = 0;
	$servie_total = 0;
	$cart_checkout_data = json_decode($row_b2b['cart_checkout_data']);
	for($i=0;$i<sizeof($cart_checkout_data);$i++){

		if($cart_checkout_data[$i]->service->name == 'Hotel'){
			$tax_amount = 0;
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
				$room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
				$room_cost = $room_types[2];
				$h_currency_id = $room_types[3];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] == "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;
				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$hotel_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Transfer'){
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			$tax_amount = 0;
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
			$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_cost);
				$room_cost = $transfer_cost[0];
				$h_currency_id = $transfer_cost[1];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
					if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
					}
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$transfer_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Activity'){
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
				
				$tax_amount = 0;
				$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_type);
				$room_cost = $transfer_cost[1];
				$h_currency_id = $transfer_cost[2];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] === "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$activity_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
				$tax_amount = 0;
				$taxation_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$room_cost = $cart_checkout_data[$i]->service->service_arr[$j]->total_cost;
				$h_currency_id = $cart_checkout_data[$i]->service->service_arr[$j]->currency_id;
				
				$tax_arr1 = explode('+',$taxation_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] === "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;
	
				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$tours_total += $total_amount;
			}
		}
	}

	$servie_total = $hotel_total + $transfer_total + $activity_total + $tours_total;
	if($row_b2b['coupon_code'] != ''){
		$sq_hotel_count = mysql_num_rows(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_b2b[coupon_code]'"));
		if($sq_hotel_count > 0){
			$sq_coupon = mysql_fetch_assoc(mysql_query("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_b2b[coupon_code]'"));
		}else{
			$sq_coupon = mysql_fetch_assoc(mysql_query("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_b2b[coupon_code]'"));
		}
		if($sq_coupon['offer']=="Flat"){
			$servie_total = $servie_total - $sq_coupon['offer_amount'];
		}else{
			$servie_total = $servie_total - ($servie_total * $sq_coupon['offer_amount']/100);
		}
	}
	$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_b2b[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
	$total_paid +=$sq_payment_info['sum'];
	$bal_amt = $servie_total-$sq_payment_info['sum'];
   	if((int)$bal_amt>0){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "B2B Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_b2b['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= round($bal_amt,2) ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//FIT
	$query = "select * from package_tour_booking_master where 1 and customer_id='$customer_id' ";
	$booking_amt =0;
	$pending_amt=0;
	$sq_booking = mysql_query($query);
	while($row_booking = mysql_fetch_assoc($sq_booking)){

		$cancel_est=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
		$total_pay=mysql_fetch_assoc(mysql_query("select sum(amount) as sum,sum(credit_charges) as sumc from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

		$booking_amt=$row_booking['net_total']+$total_pay['sumc'];
		$total_purches=$booking_amt;
		//Consider sale cancel amount
		if($cancel_est['cancel_amount'] != ''){ 			
			if($cancel_est['cancel_amount'] <= $total_pay['sum']){
				$pending_amt = 0;
			}
			else{
				$pending_amt =  $cancel_est['cancel_amount'] - $total_pay['sum'] - $total_pay['sumc'];
			}
		}
		else{
			$pending_amt=$total_purches-$total_pay['sum'] -$total_pay['sumc'];
		}
		if($pending_amt>'0'){
		?>
		<tr>
		    <td class="col-md-2"><?= $count++ ?></td>
			<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Package Booking" ?>" class="form-control" readonly></td>
			<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
			<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $pending_amt ?>" class="text-right form-control" readonly></td>
			<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
		</tr>
	<?php 
		}
	}
//visa
$query = "select * from visa_master where 1 and customer_id='$customer_id'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;

$sq_visa = mysql_query($query);
while($row_visa = mysql_fetch_assoc($sq_visa)){	  
   //Get Total visa cost
   $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from visa_payment_master where visa_id='$row_visa[visa_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
    $visa_total_amount=$row_visa['visa_total_cost']+$sq_payment_info['sumc'];	   
	//Get total refund amount
	$cancel_amount=$row_visa['cancel_amount'];	

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = 0;
		}
		else{
			$bal_amt =  $cancel_amount - $sq_payment_info['sum']-$sq_payment_info['sumc'];
		}
	}
	else{
		$bal_amt = $visa_total_amount-$sq_payment_info['sum']-$sq_payment_info['sumc']; 
	}
   if($bal_amt>'0'){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Visa Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_visa['visa_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Air Ticket
$query = "select * from ticket_master where 1 and customer_id='$customer_id' ";
$sq_ticket = mysql_query($query);
while($row_ticket = mysql_fetch_assoc($sq_ticket)){

$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from ticket_payment_master where ticket_id='$row_ticket[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$paid_amount = $sq_paid_amount['sum']+$sq_paid_amount['sumc'];
$sale_amount = $row_ticket['ticket_total_cost']+$sq_paid_amount['sumc'];

//Consider sale cancel amount
if($row_ticket['cancel_amount'] != '0'){ 
	if($row_ticket['cancel_amount'] <= $paid_amount){
		$bal_amount = '0';
	}
	else{
		$bal_amount =  $row_ticket['cancel_amount'] - $paid_amount;
	}
}
else{
	$bal_amount = $sale_amount - $paid_amount;
}

 if($bal_amount>'0'){
?>		
<tr>
    <td class="col-md-2"><?= $count++ ?></td>
	<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Air Ticket Booking" ?>" class="form-control" readonly></td>
	<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ticket['ticket_id'] ?>" class="form-control" readonly></td>
	<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amount ?>" class="text-right form-control" readonly></td>
	<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
</tr>
<?php
}
}
//Train ticket
$query = "select * from train_ticket_master where 1 and customer_id='$customer_id'";
$sq_ticket = mysql_query($query);
while($row_ticket = mysql_fetch_assoc($sq_ticket)){
	
	$sq_payment = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum_pay,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$row_ticket[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

	$paid_amount = $sq_payment['sum_pay'] + $sq_payment['sumc'];
	$sale_amount = $row_ticket['net_total'] + $sq_payment['sumc'];	

	//Consider sale cancel amount
	if($row_ticket['cancel_amount'] != '0'){ 
		if($row_ticket['cancel_amount'] <= $paid_amount){
			$bal = '0';
		}
		else{
			$bal =  $row_ticket['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$bal = $sale_amount - $paid_amount;
	}
	if($bal>'0'){
	?>		
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Train Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ticket['train_ticket_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Hotel 
$query = "select * from hotel_booking_master where 1 and customer_id='$customer_id' ";
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){

	$sq_payment_total = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$paid_amount = $sq_payment_total['sum'];			
	$total_paid += $sq_payment_total['sum'];
	$sale_bal = $row_booking['total_fee'];
	
	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $paid_amount){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$total_bal = $sale_bal - $paid_amount;
	}
	if($total_bal>'0'){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Hotel Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Bus
$query = "select * from bus_booking_master where 1 and customer_id='$customer_id' ";

$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){

	$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from bus_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_purchase = $row_booking['net_total']+$sq_payment_info['sumc'];

	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
	
	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $sq_payment_info['sum']){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $sq_payment_info['sum']-$sq_payment_info['sumc'];
		}
	}
	else{
		$total_bal=$total_purchase-$sq_payment_info['sum']-$sq_payment_info['sumc'];
	}
	if($total_bal>'0'){	
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Bus Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Car Rental
$query = "select * from car_rental_booking where 1 and customer_id='$customer_id'";
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{
	$total_purchase=$row_booking['total_fees'];

	$sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from car_rental_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum'];
	 
	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $sq_payment_info['sum']){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $sq_payment_info['sum'];
		}
	}
	else{
		$total_bal=$total_purchase-$sq_payment_info['sum'];	
	}

	if($total_bal>'0'){
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Car Rental Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Forex
$query = "select * from forex_booking_master where booking_type='Sale' and customer_id='$customer_id'";
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){

	$sq_paid_sum = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from forex_booking_payment_master where booking_id='$row_booking[booking_id]'"));

    $sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from forex_booking_payment_master where booking_id='$row_booking[booking_id]' and (clearance_status!='Pending' and clearance_status!='Cancelled')"));

	$total_paid = $sq_payment_info['sum'] + $sq_payment_info['sumc'];

	$bal_amount = $row_booking['net_total'] + $sq_payment_info['sumc'] - $total_paid;
	if($bal_amount>'0'){
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Forex Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id" value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amount ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>"  class="form-control" name="chk_pr_payment" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}

//Group
$cancel_amount = 0;
$query = "select * from tourwise_traveler_details where 1 and customer_id='$customer_id'";
$sq1 =mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{
	$tourwise_id = $row1['id'];
	$sale_total_amount = $row1['net_total'];
	$query = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
	$paid_amount = $query['sum'];
	$paid_amount = ($paid_amount == '')?'0':$paid_amount;

	if($row1['tour_group_status'] == 'Cancel'){
		//Group Tour cancel
		$cancel_tour_count2=mysql_num_rows(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
		if($cancel_tour_count2 >= '1'){
			$cancel_tour=mysql_fetch_assoc(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
			$cancel_amount2 = $cancel_tour['cancel_amount'];
		}
		else{ $cancel_amount2 = 0; }

		if($cancel_esti_count1 >= '1'){
			$cancel_amount = $cancel_amount1;
		}else{
			$cancel_amount = $cancel_amount2;
		}	
	}
	else{
		// Group booking cancel
		$cancel_esti_count1=mysql_num_rows(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_id'"));
		if($cancel_esti_count1 >= '1'){
			$cancel_esti1=mysql_fetch_assoc(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_id'"));
			$cancel_amount = $cancel_esti1['cancel_amount'];
		}
		else{ $cancel_amount = 0; }

	}

	$cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;

	if($row1['tour_group_status'] == 'Cancel'){
		if($cancel_amount > $paid_amount){
			$balance_amount = $cancel_amount - $paid_amount;
		}
		else{
			$balance_amount = 0;
		}
	}
	else{
		if($cancel_esti_count1 >= '1'){
			if($cancel_amount > $paid_amount){
				$balance_amount = $cancel_amount - $paid_amount;
			}
			else{
				$balance_amount = 0;
			}
		}
		else{
			$balance_amount = $sale_total_amount - $paid_amount;
		}
	}

   	if($balance_amount>'0'){
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Group Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $tourwise_id ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $balance_amount ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php	
	}
}
//Passport
$query = "select * from passport_master where 1 and customer_id='$customer_id' ";
$sq_passport = mysql_query($query);
while($row_passport = mysql_fetch_assoc($sq_passport)){

	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

	$paid_amount = $sq_paid_amount['sum'] + $sq_paid_amount['sumc'];
	$sale_amount = $row_passport['passport_total_cost'] + $sq_paid_amount['sumc'];

	//Consider sale cancel amount
	if($row_passport['cancel_amount'] != '0'){ 
		if($row_passport['cancel_amount'] <= $paid_amount){
			$bal_amount = '0';
		}
		else{
			$bal_amount =  $row_passport['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$bal_amount =$sale_amount - $paid_amount;
	}

   	if($bal_amount>'0'){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Passport Booking" ?>" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_passport['passport_id'] ?>" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amount ?>" class="text-right" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Excursion
$query = "select * from excursion_master where 1 and customer_id='$customer_id'";
$sq_ex = mysql_query($query);
while($row_ex= mysql_fetch_assoc($sq_ex)){

    //Get Total cost
    $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from exc_payment_master where exc_id='$row_ex[exc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum'];

    $ex_total_amount=$row_ex['exc_total_cost'];
    
	//Get total refund amount
	$cancel_amount=$row_ex['cancel_amount'];
	
    $total_ex_amount=$ex_total_amount;
    
    $total_amount=$total_amount+$ex_total_amount;

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = '0';
		}
		else{
			$bal_amt = $cancel_amount - $sq_payment_info['sum'];
		}
	}
	else{
    	$bal_amt = $total_ex_amount - $sq_payment_info['sum'];
	}
   	if($bal_amt>'0'){
	?>		
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Excursion Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ex['exc_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Miscellaneous
$query = "select * from miscellaneous_master where 1 and customer_id='$customer_id'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;

$sq_misc = mysql_query($query);
while($row_msc = mysql_fetch_assoc($sq_misc)){
   //Get Total Miscellaneous cost
    $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_msc[misc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
    $misc_total_amount=$row_msc['misc_total_cost']+$sq_payment_info['sumc'];	   
	//Get total refund amount
	$cancel_amount=$row_msc['cancel_amount'];	

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = 0;
		}
		else{
			$bal_amt =  $cancel_amount - $sq_payment_info['sum'] -$sq_payment_info['sumc'];
		}
	}
	else{
		$bal_amt = $misc_total_amount-$sq_payment_info['sum'] -$sq_payment_info['sumc']; 
	}
	if($bal_amt>'0'){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Miscellaneous Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_msc['misc_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
?>