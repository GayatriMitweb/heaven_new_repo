<?php

include "../../../../model/model.php";
include "../print_functions.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$branch_id = $_POST['branch_id_filter']; 
$customer_id = $_GET['customer_id'];
$from_date1 = $_GET['from_date'];
$to_date1 = $_GET['to_date'];

$from_date = get_date_db($from_date1);
$to_date = get_date_db($to_date1);
$count = 0;
?>

<!-- header -->
    <section class="print_header main_block">
      <div class="col-md-8 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> Outstanding Summary Report</span>
        <div class="print_header_logo">
          <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-4 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? 
           $branch_details['contact_no'] : $app_contact_no ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>

        </div>
      </div>

    <!-- Package -->
      <div class="row">
	      <div class="col-xs-12">
	        <div class="print_info_block">
	            <ul class="main_block noType">
	            	<?php $cust_name=mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'")); ?>
	               <li class="col-md-12"><span>CUSTOMER NAME : </span><?= $cust_name['first_name'].' '.$cust_name['last_name'] ?></li>
	               <li class="col-md-6"><span>FROM DATE : </span> <?= $from_date1 ?></li>
	               <li class="col-md-6"><span>TO DATE : </span> <?= $to_date1 ?></li>
	            </ul>
	        </div>
	      </div>
      </div>

    <!-- print-detail -->
		<div class="row"> <div class="col-md-12"> <div class="table-responsive">

			

		<table class="table table-bordered cust_table" id="tbl_list" style="padding: 0 !important; background: #fff;">

			<thead>

				<tr class="table-heading-row">

					<th>S_No.</th>
					<th>Service</th>
					<th>Invoice_ID</th>
					<th>Date</th>
					<th class="text-right info">sale_Amount</th>
					<th class="text-right success">Paid_Amount</th>
					<th class="text-right danger">Cncl_Amount</th>
					<th class="text-right warning">Balance</th>
				</tr>
			</thead>
			<tbody>
			<?php
			//FIT
			if($customer_id!="" || $from_date!='' && $to_date!=''){
				$query = "select * from package_tour_booking_master where 1 ";

				if($customer_id!=""){
				  $query .=" and customer_id='$customer_id'";
				}
				if($from_date!='' || $to_date!=''){
				  $query .=" and booking_date between '$from_date' and '$to_date'";
				}
				

			$sq_booking = mysql_query($query);
			while($row_booking = mysql_fetch_assoc($sq_booking)){
				$sale_total_amount=$row_booking['net_total'];
				if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

				$query = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
				$paid_amount = $query['sum'];
				$paid_amount = ($paid_amount == '')?'0':$paid_amount;

				$cancel_est=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
				$cancel_amount=$cancel_est['cancel_amount'];
				if($cancel_amount != ''){ 			
					if($cancel_amount <= $paid_amount){
						$balance_amount = 0;
					}
					else{
						$balance_amount =  $cancel_amount - $paid_amount;
					}
				}
				else{
					$balance_amount=$sale_total_amount-$paid_amount;
				}
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= "Package Booking" ?></td>
					<td><?= get_package_booking_id($row_booking['booking_id']) ?></td>
					<td><?= get_date_user($row_booking['booking_date']) ?></td>
					<td class="info text-right"><?= number_format($sale_total_amount,2)?></td>
					<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
					<td class="danger text-right"><?= number_format($cancel_amount,2)?></td>
					<td class="warning text-right"><?= number_format($balance_amount,2)?></td>
				</tr>
				<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
			}

			//visa
			$query = "select * from visa_master where 1 ";
			if($customer_id!=""){
			  $query .=" and customer_id='$customer_id'";
			}
			if($from_date!='' || $to_date!=''){
			  $query .=" and created_at between '$from_date' and '$to_date'";
			}
					 
			$sq_visa = mysql_query($query);
			while($row_visa = mysql_fetch_assoc($sq_visa)){
			
			//Sale
			$sale_total_amount=$row_visa['visa_total_cost'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//Cancel
			$cancel_amount=$row_visa['cancel_amount'];
			$pass_count = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]' and status='Cancel'"));

			//Paid
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from visa_payment_master where visa_id='$row_visa[visa_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];

			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($pass_count == $cancel_count){
						if($paid_amount > 0){
							if($cancel_amount >0){
								if($paid_amount > $cancel_amount){
									$balance_amount = 0;
								}else{
									$balance_amount = $cancel_amount - $paid_amount;
								}
							}else{
							   $balance_amount = 0;
							}
						}
						else{
							$balance_amount = $cancel_amount;
						}
					}
					else{
						$balance_amount = $sale_total_amount - $paid_amount;
					}
					
				?>	
				<tr>
					<td><?= ++$count ?></td>
					<td><?= "Visa Booking"?></td>
					<td><?= get_visa_booking_id($row_visa['visa_id']) ?></td>
					<td><?= get_date_user($row_visa['created_at']) ?></td>
					<td class="info text-right"><?= number_format($sale_total_amount,2) ?></td>
					<td class="success text-right"><?= number_format($paid_amount,2) ?></td>
					<td class="danger text-right"><?= number_format($cancel_amount,2) ?></td>
					<td class="warning text-right"><?= number_format($balance_amount,2) ?></td>
				</tr>
				<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
			}

			//Air Ticket
			$query = "select * from ticket_master where 1 ";
			if($customer_id!=""){
			  $query .=" and customer_id='$customer_id'";
			}
			if($from_date!='' || $to_date!=''){
			  $query .=" and created_at between '$from_date' and '$to_date'";
			}
			
			$sq_ticket = mysql_query($query);
			while($row_ticket = mysql_fetch_assoc($sq_ticket)){

			//Sale
			 $sale_total_amount=$row_ticket['ticket_total_cost'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//Cancel
			$cancel_amount=$row_ticket['cancel_amount'];
			$pass_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]' and status='Cancel'"));

			//Paid
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from ticket_payment_master where ticket_id='$row_ticket[ticket_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($pass_count == $cancel_count){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
						}else{
						   $balance_amount = 0;
						}
					}
					else{
						$balance_amount = $cancel_amount;
					}
				}
				else{
					$balance_amount = $sale_total_amount - $paid_amount;
				}

			?>	
			<tr>
				<td><?= ++$count ?></td>
				<td><?= "Flight Ticket" ?></td>
				<td><?= get_ticket_booking_id($row_ticket['ticket_id']) ?></td>
				<td><?= get_date_user($row_ticket['created_at']) ?></td>
				<td class="info text-right"><?= number_format($sale_total_amount,2) ?></td>
				<td class="text-right success"><?= ($paid_amount=="") ? number_format(0,2) : number_format($paid_amount,2) ?></td>
				<td class="danger text-right"><?= number_format($cancel_amount,2) ?></td>
				<td class="warning text-right"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}


		//Train ticket
		$query = "select * from train_ticket_master where 1";
		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
		  $query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_ticket = mysql_query($query);

		while($row_ticket = mysql_fetch_assoc($sq_ticket)){

			//sale
			$sale_total_amount=$row_ticket['net_total'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }
			//Cancel
			$cancel_amount=$row_ticket['cancel_amount'];
			$pass_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]' and status='Cancel'"));


			//Paid
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$row_ticket[train_ticket_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($pass_count == $cancel_count){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
					}else{
					   $balance_amount = 0;
					}
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}
			else{
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			?>	
			
			<tr>

				<td><?= ++$count ?></td>
					<td><?= "Train Ticket Booking" ?></td>
				<td><?= get_train_ticket_booking_id($row_ticket['train_ticket_id']) ?></td>
				<td><?= get_date_user($row_ticket['created_at']) ?></td>
				<td class="text-right info"><?= number_format($sale_total_amount,2) ?></td>
				<td  class="text-right success"><?= ($paid_amount=="") ? number_format(0,2) : number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2) ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2)?></td>
			</tr>

			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
			
		}
		//Hotel 
		$query = "select * from hotel_booking_master where 1 ";
		$query .=" and customer_id='$customer_id'";

		if($from_date!='' || $to_date!=''){
		  $query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){

			//sale 
		 $sale_total_amount=$row_booking['total_fee'];
		if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

		//Cancel
		$cancel_amount=$row_booking['cancel_amount'];
		$pass_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_booking[booking_id]'"));
		$cancel_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_booking[booking_id]' and status='Cancel'"));

		//Paid
		$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from hotel_booking_payment where booking_id='$row_booking[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
		$paid_amount = $query['sum'];
		$paid_amount = ($paid_amount == '')?'0':$paid_amount;

		if($pass_count == $cancel_count){
			if($paid_amount > 0){
				if($cancel_amount >0){
					if($paid_amount > $cancel_amount){
						$balance_amount = 0;
					}else{
						$balance_amount = $cancel_amount - $paid_amount;
					}
				}else{
				   $balance_amount = 0;
				}
			}
			else{
				$balance_amount = $cancel_amount;
			}
		}
		else{
			$balance_amount = $sale_total_amount - $paid_amount;
		}

			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= "Hotel Booking" ?></td>
				<td><?= get_hotel_booking_id($row_booking['booking_id']) ?></td>
				<td><?= get_date_user($row_booking['created_at']) ?></td>
				<td class="text-right  info"><?= number_format($sale_total_amount,2) ?></td>
				<td class="text-right  success"><?= number_format($paid_amount,2)?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2) ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2) ?></td>	
			</tr>
			<?php
			$total_amount +=$sale_total_amount;
			$total_paid   +=$paid_amount;
			$total_balance+=$balance_amount;
			$total_cancel +=$cancel_amount;
			
		}
		//Bus
		$query = "select * from bus_booking_master where 1 ";

		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
		  $query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){
			//sale 
			$sale_total_amount=$row_booking['net_total'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//paid
			$cancel_amount=$row_booking['cancel_amount'];
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			//Cancel
			$cancel_amount=$row_booking['cancel_amount'];
			$pass_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_booking[booking_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_booking[booking_id]' and status='Cancel'"));

			if($pass_count == $cancel_count){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
					}else{
					   $balance_amount = 0;
					}
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}
			else{
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= "Bus Booking" ?></td>
				<td><?= get_bus_booking_id($row_booking['booking_id']) ?></td>
				<td><?= get_date_user($row_booking['created_at']) ?></td>
				<td class="text-right info"><?= number_format($sale_total_amount,2) ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2) ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}
		//Car Rental
		
		$query = "select * from car_rental_booking where 1 ";

		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
		  $query .=" and created_at between '$from_date' and '$to_date'";
		}
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking))
		{
			$count++;
			//Sale
			$sale_total_amount=$row_booking['total_fees'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//Cacnel
			$cancel_amount=$row_booking['cancel_amount'];

			//Paid
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from car_rental_payment where booking_id='$row_booking[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($row_booking['status'] == 'Cancel'){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
					}else{
					   $balance_amount = 0;
					}
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}
			else{
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			
			?>
			<tr>
				<td><?= $count ?></td>
				<td><?= "Car Rental" ?></td>
				<td><?= get_car_rental_booking_id($row_booking['booking_id']) ?></td>
				<td><?= get_date_user($row_booking['created_at']) ?></td>
				<td class="text-right info"><?= number_format($sale_total_amount, 2) ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2)?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2)?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2);?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}
		//Forex
		$query = "select * from forex_booking_master where booking_type!='Buy' ";
		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
		  $query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){

			$sale_total_amount=$row_booking['net_total'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			$cancel_amount=0;
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from forex_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($paid_amount > $cancel_amount && $cancel_amount == '0'){
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			else if($paid_amount > $cancel_amount && $cancel_amount != '0'){
				$balance_amount = 0;
			}
			else{
				$balance_amount = $cancel_amount - $paid_amount;
			}
			$bg = ($row_booking['booking_status']=="Cancel") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= "Forex Booking" ?></td>
				<td><?= get_forex_booking_id($row_booking['booking_id']) ?></td>
				<td><?= get_date_user($row_booking['created_at']) ?></td>
				<td class="text-right info"><?= number_format($sale_total_amount,2) ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= number_format(0,2) ?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;

		}

		//Group
		$query = "select * from tourwise_traveler_details where 1 ";
		 if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
		  $query .=" and form_date between '$from_date' and '$to_date'";
		}
		
		$sq1 =mysql_query($query);
		while($row1 = mysql_fetch_assoc($sq1))
		{
			$sale_total_amount=$row1['net_total'];
				if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

				//paid
				$query = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id='$row1[id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
				$paid_amount = $query['sum'];
				$paid_amount = ($paid_amount == '')?'0':$paid_amount;


				if($row1['tour_group_status'] == 'Cancel'){
					//Group Tour cancel
					$cancel_tour_count2=mysql_num_rows(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row1[id]'"));
					if($cancel_tour_count2 >= '1'){
						$cancel_tour=mysql_fetch_assoc(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row1[id]'"));
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
					$cancel_esti_count1=mysql_num_rows(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row1[id]'"));
					if($cancel_esti_count1 >= '1'){
						$cancel_esti1=mysql_fetch_assoc(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row1[id]'"));
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
				}else{
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
		  	$count++;
			?>
			  <tr>
			  	<td><?php echo $count ?></td>
					<td><?= "Group Booking" ?></td>
			  	<td><?= get_group_booking_id($row1['id']) ?></td>
				<td><?= get_date_user($row1['form_date']) ?></td>
			  	<td class="text-right info"><?= number_format($sale_total_amount,2) ?></td>
			  	<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
			  	<td class="text-right danger"><?=  number_format($cancel_amount,2)?></td>
			  	<td class="text-right warning"><?= number_format($balance_amount,2) ?></td>
			  </tr>	
			<?php	
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}
		//Passport
		$query = "select * from passport_master where 1 ";

		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
			$query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_passport = mysql_query($query);
		while($row_passport = mysql_fetch_assoc($sq_passport)){
		//sale
		$sale_total_amount=$row_passport['passport_total_cost'];
		if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

		//Cancel
		$cancel_amount=$row_passport['cancel_amount'];
		$pass_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]'"));
		$cancel_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]' and status='Cancel'"));

		//Paid
		$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
		$paid_amount = $query['sum'];
		$paid_amount = ($paid_amount == '')?'0':$paid_amount;

		if($pass_count == $cancel_count){
			if($paid_amount > 0){
				if($cancel_amount >0){
					if($paid_amount > $cancel_amount){
						$balance_amount = 0;
					}else{
						$balance_amount = $cancel_amount - $paid_amount;
					}
				}else{
				   $balance_amount = 0;
				}
			}
			else{
				$balance_amount = $cancel_amount;
			}
		}
		else{
			$balance_amount = $sale_total_amount - $paid_amount;
		}

			
			?>	
			<tr>
				<td><?= ++$count ?></td>
				<td><?= "Passport Booking" ?></td>
				<td><?= get_passport_booking_id($row_passport['passport_id']) ?></td>
				<td><?= get_date_user($row_passport['created_at']) ?></td>
				<td class="text-right info"><?= number_format($sale_total_amount,2) ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="text-right danger"><?= number_format($cancel_amount,2)?></td>
				<td class="text-right warning"><?= number_format($balance_amount,2)?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}
		//Excursion
		$query = "select * from excursion_master where 1 ";
		if($customer_id!=""){
		  $query .=" and customer_id='$customer_id'";
		}
		if($from_date!='' || $to_date!=''){
			$query .=" and created_at between '$from_date' and '$to_date'";
		}
		
		$sq_ex = mysql_query($query);
		while($row_ex= mysql_fetch_assoc($sq_ex)){
		       // sale
			$sale_total_amount=$row_ex['exc_total_cost'];
			if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

			//Cancel
			$cancel_amount=$row_ex['cancel_amount'];
			$pass_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_ex[exc_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_ex[exc_id]' and status='Cancel'"));

			// Paid
			$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from exc_payment_master where exc_id='$row_ex[exc_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
			$paid_amount = $query['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($pass_count == $cancel_count){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
					}else{
					   $balance_amount = 0;
					}
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}
			else{
				$balance_amount = $sale_total_amount - $paid_amount;
			}

			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= "Excursion Booking"?></td>
				<td><?= get_exc_booking_id($row_ex['exc_id']) ?></td>
				<td><?= get_date_user($row_ex['created_at']) ?></td>
				<td class="info text-right"><?= number_format($sale_total_amount,2) ?></td>
				<td class="success text-right"><?= number_format($paid_amount,2) ?></td>
				<td class="danger text-right"><?= number_format($cancel_amount,2) ?></td>
				<td class="warning text-right"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
				$total_amount +=$sale_total_amount;
				$total_paid   +=$paid_amount;
				$total_balance+=$balance_amount;
				$total_cancel +=$cancel_amount;
		}
	//Miscellaneous
	$query = "select * from miscellaneous_master where 1 ";
	if($customer_id!=""){
		$query .=" and customer_id='$customer_id'";
	}
	if($from_date!='' || $to_date!=''){
		$query .=" and created_at between '$from_date' and '$to_date'";
	}
			 
	$sq_visa = mysql_query($query);
	while($row_visa = mysql_fetch_assoc($sq_visa)){
				 
	
	//Sale
	$sale_total_amount=$row_visa['misc_total_cost'];
	if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

	//Cancel
	$cancel_amount=$row_visa['cancel_amount'];
	$pass_count = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]'"));
	$cancel_count = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]' and status='Cancel'"));

	//Paid
	$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from miscellaneous_payment_master where misc_id='$row_visa[misc_id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
	$paid_amount = $query['sum'];

	$paid_amount = ($paid_amount == '')?'0':$paid_amount;

	if($pass_count == $cancel_count){
				if($paid_amount > 0){
					if($cancel_amount >0){
						if($paid_amount > $cancel_amount){
							$balance_amount = 0;
						}else{
							$balance_amount = $cancel_amount - $paid_amount;
						}
					}else{
						 $balance_amount = 0;
					}
				}
				else{
					$balance_amount = $cancel_amount;
				}
			}
			else{
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			
		?>	
		<tr>
			<td><?= ++$count ?></td>
			<td><?= "Miscellaneous Booking"?></td>
			<td><?= get_misc_booking_id($row_visa['misc_id']) ?></td>
				<td><?= get_date_user($row_visa['created_at']) ?></td>
			<td class="info text-right"><?= number_format($sale_total_amount,2) ?></td>
			<td class="success text-right"><?= number_format($paid_amount,2) ?></td>
			<td class="danger text-right"><?= number_format($cancel_amount,2) ?></td>
			<td class="warning text-right"><?= number_format($balance_amount,2) ?></td>
		</tr>
		<?php
		$total_amount +=$sale_total_amount;
		$total_paid   +=$paid_amount;
		$total_balance+=$balance_amount;
		$total_cancel +=$cancel_amount;
	}

		?>
    <tr class="active">
	<th colspan="4" class="text-right info">Total</th>
<th colspan="1" class="text-right info"><?= number_format($total_amount,2) ?></th>

<th colspan="1" class="text-right success"><?= number_format($total_paid,2) ?></th>

<th class="text-right danger"><?= ($total_cancel=='')?number_format(0,2): number_format($total_cancel,2); ?></th>

<th colspan="1" class="text-right warning"><?= number_format($total_balance,2);?></th>

</tr>

		</tbody>

		</table>



		</div> </div> </div>
	</section>
<?php } ?>

