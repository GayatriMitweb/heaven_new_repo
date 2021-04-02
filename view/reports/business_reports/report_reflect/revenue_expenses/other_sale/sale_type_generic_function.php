<?php
function get_sale_purchase($sale_type)
{
	$sale_array = array();
	$total_sale = 0;
	$total_purchase = 0;
	$total_expense = 0;

	///Visa Start
	if($sale_type == 'Visa'){
		//Sale
		$sq_visa = mysql_query("select * from visa_master where 1");
		while ($row_visa = mysql_fetch_assoc($sq_visa)) {
			$sq_visa_entry = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]'"));
			$sq_visa_cancel = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]' and status = 'Cancel'"));
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_visa['service_tax_subtotal'] !== 0.00 && ($row_visa['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_visa['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$markupservice_tax_amount = 0;
			if($row_visa['markup_tax'] !== 0.00 && $row_visa['markup_tax'] !== ""){
				$service_tax_markup1 = explode(',',$row_visa['markup_tax']);
				for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount += $service_tax[2];
			
				}
			}
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from visa_payment_master where visa_id='$row_visa[visa_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];

			if($sq_visa_entry != $sq_visa_cancel){
				$total_sale += $row_visa['visa_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Visa Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Visa End

	///Passport Start
	if($sale_type == 'Passport'){
		//Sale
		$sq_passport = mysql_query("select * from passport_master");
		while ($row_forex = mysql_fetch_assoc($sq_passport)) {
			
			$sq_passport_entry = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$row_forex[passport_id]'"));
			$sq_passport_cancel = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$row_forex[passport_id]' and status = 'Cancel'"));
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_forex['service_tax_subtotal'] !== 0.00 && ($row_forex['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_forex['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from passport_payment_master where passport_id='$row_forex[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];

			if($sq_passport_entry != $sq_passport_cancel){
				$total_sale += $row_forex['passport_total_cost'] - $service_tax_amount + $credit_charges;
			}
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Passport Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Passport End
	///Excursion Start
	if($sale_type == 'Excursion'){
		//Sale
		$sq_exc = mysql_query("select * from excursion_master");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {
			$sq_exc_entry = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_exc[exc_id]'"));
			$sq_exc_cancel = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_exc[exc_id]' and status = 'Cancel'"));
			//// Calculate Service Tax//////
			$service_tax_amount = 0;
			if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			  $service_tax = explode(':',$service_tax_subtotal1[$i]);
			  $service_tax_amount +=  $service_tax[2];
			  }
			}
	  
			//// Calculate Markup Tax//////
	  
			$markupservice_tax_amount = 0;
			if($row_exc['service_tax_markup'] !== 0.00 && $row_exc['service_tax_markup'] !== ""){
			$service_tax_markup1 = explode(',',$row_exc['service_tax_markup']);
			for($i=0;$i<sizeof($service_tax_markup1);$i++){
			  $service_tax = explode(':',$service_tax_markup1[$i]);
			  $markupservice_tax_amount += $service_tax[2];
	  
			  }
			}
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from exc_payment_master where exc_id='$row_exc[exc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];

			if($sq_exc_entry != $sq_exc_cancel){ 		
				$total_sale += $row_exc['exc_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Excursion Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Excursion End	
	///Forex Start
	if($sale_type == 'Forex'){
		//Sale
		$sq_forex = mysql_query("select * from forex_booking_master");
		while ($row_forex = mysql_fetch_assoc($sq_forex)) {
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_forex['service_tax_subtotal'] !== 0.00 && ($row_forex['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_forex['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from forex_booking_payment_master where booking_id='$row_forex[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];

			$total_sale += $row_forex['net_total'] - $service_tax_amount + $credit_charges;
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Forex Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Forex End
	///Bus Start
	if($sale_type == 'Bus'){
		//Sale
		$sq_exc = mysql_query("select * from bus_booking_master");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {
			
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from bus_booking_payment_master where booking_id='$row_exc[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];

			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$markupservice_tax_amount = 0;
			if($row_exc['markup_tax'] !== 0.00 && $row_exc['markup_tax'] !== ""){
				$service_tax_markup1 = explode(',',$row_exc['markup_tax']);
				for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount += $service_tax[2];
			
				}
			}
			$sq_exc_entry = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_exc[booking_id]'"));
			$sq_exc_cancel = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_exc[booking_id]' and status = 'Cancel'"));
			if($sq_exc_entry != $sq_exc_cancel){
				$total_sale += $row_exc['net_total'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Bus Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Bus End

	///Hotel Start
	if($sale_type == 'Hotel'){
		//Sale
		$sq_exc = mysql_query("select * from hotel_booking_master");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {

			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from hotel_booking_payment where booking_id='$row_exc[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_charges = $sq_paid_amount['sumc'];
			//// Calculate Service Tax//////
			$service_tax_amount = 0;
			if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			}
			}

			//// Calculate Markup Tax//////

			$markupservice_tax_amount = 0;
			if($row_exc['markup_tax'] !== 0.00 && $row_exc['markup_tax'] !== ""){
			$service_tax_markup1 = explode(',',$row_exc['markup_tax']);
			for($i=0;$i<sizeof($service_tax_markup1);$i++){
			$service_tax = explode(':',$service_tax_markup1[$i]);
			$markupservice_tax_amount += $service_tax[2];

			}
			}
			$sq_exc_entry = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_exc[booking_id]'"));
			$sq_exc_cancel = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_exc[booking_id]' and status = 'Cancel'"));
			if($sq_exc_entry != $sq_exc_cancel){ 		
				$total_sale += $row_exc['total_fee'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Hotel Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Hotel End
	///Car Start
	if($sale_type == 'Car Rental'){
		//Sale
		$sq_exc = mysql_query("select * from car_rental_booking where status != 'Cancel'");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {	
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum ,sum(`credit_charges`) as sumc from car_rental_payment where booking_id='$row_exc[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

//Service Tax and Markup Tax
            $service_tax_amount = 0;
            if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
                $service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
                for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                $service_tax = explode(':',$service_tax_subtotal1[$i]);
                $service_tax_amount +=  $service_tax[2];
                }
            }
            $markupservice_tax_amount = 0;
            if($row_exc['markup_cost_subtotal'] !== 0.00 && $row_exc['markup_cost_subtotal'] !== ""){
                $service_tax_markup1 = explode(',',$row_exc['markup_cost_subtotal']);
                for($i=0;$i<sizeof($service_tax_markup1);$i++){
                $service_tax = explode(':',$service_tax_markup1[$i]);
                $markupservice_tax_amount += $service_tax[2];
            
                }
            }

			$total_sale += $row_exc['total_fees'] - $service_tax_amount -$markupservice_tax_amount + $sq_paid_amount['sumc'];
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Car End
	///Ticket Start
	if($sale_type == 'Flight Ticket'){
		//Sale
		$sq_exc = mysql_query("select * from ticket_master");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {
			$sq_exc_entry = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_exc[ticket_id]'"));
			$sq_exc_cancel = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_exc[ticket_id]' and status = 'Cancel'"));
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$markupservice_tax_amount = 0;
			if($row_exc['markup_tax'] !== 0.00 && $row_exc['markup_tax'] !== ""){
				$service_tax_markup1 = explode(',',$row_exc['markup_tax']);
				for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount += $service_tax[2];
			
				}
			}
			
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from ticket_payment_master where ticket_id='$row_exc[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_card_charges = $sq_paid_amount['sumc'];
			
			if($sq_exc_entry != $sq_exc_cancel){
				$total_sale += $row_exc['ticket_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_card_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Ticket Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Ticket End
	///Train Start
	if($sale_type == 'Train Ticket'){
		//Sale
		$sq_exc = mysql_query("select * from train_ticket_master");
		while ($row_exc = mysql_fetch_assoc($sq_exc)) {
			$sq_exc_entry = mysql_num_rows(mysql_query("select * from train_ticket_master_entries where train_ticket_id='$row_exc[train_ticket_id]'"));
			$sq_exc_cancel = mysql_num_rows(mysql_query("select * from train_ticket_master_entries where train_ticket_id='$row_exc[train_ticket_id]' and status = 'Cancel'"));
			
			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$row_exc[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_card_charges = $sq_paid_amount['sumc'];
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_exc['service_tax_subtotal'] !== 0.00 && ($row_exc['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_exc['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			
			if($sq_exc_entry != $sq_exc_cancel){
				$total_sale += $row_exc['net_total'] - $service_tax_amount + $credit_card_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Train Ticket Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Train End

	///Miscellaneous Start
	if($sale_type == 'Miscellaneous'){
		//Sale
		$sq_visa = mysql_query("select * from miscellaneous_master");
		while ($row_visa = mysql_fetch_assoc($sq_visa)) {
			
			$sq_paid_amount1 = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_visa[misc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			$credit_card_charges = $sq_paid_amount1['sumc'];
			
			//Service Tax and Markup Tax
			$service_tax_amount = 0;
			if($row_visa['service_tax_subtotal'] !== 0.00 && ($row_visa['service_tax_subtotal']) !== ''){
				$service_tax_subtotal1 = explode(',',$row_visa['service_tax_subtotal']);
				for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				}
			}
			$markupservice_tax_amount = 0;
			if($row_visa['service_tax_markup'] !== 0.00 && $row_visa['service_tax_markup'] !== ""){
				$service_tax_markup1 = explode(',',$row_visa['service_tax_markup']);
				for($i=0;$i<sizeof($service_tax_markup1);$i++){
				$service_tax = explode(':',$service_tax_markup1[$i]);
				$markupservice_tax_amount += $service_tax[2];
				}
			}
			$sq_visa_entry = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]'"));
			$sq_visa_cancel = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]' and status = 'Cancel'"));
			if($sq_visa_entry != $sq_visa_cancel){
				$total_sale += $row_visa['misc_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_card_charges;
			}	
		}

		//Purchase
		$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Miscellaneous Booking' and status!='Cancel'");
		while($row_purchase = mysql_fetch_assoc($sq_purchase)){
			$total_purchase += $row_purchase['net_total'];
			$total_purchase -= $row_purchase['service_tax_subtotal'];
		}
	}///Miscellaneous End
	return array('total_sale'=>$total_sale,'total_purchase'=>$total_purchase);
}
?>