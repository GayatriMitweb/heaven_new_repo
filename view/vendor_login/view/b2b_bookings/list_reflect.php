<?php 
include_once('../../../../model/model.php');

$user_id = $_SESSION['user_id'];
$vendor_type = $_SESSION['vendor_type'];
$query = "select * from b2b_booking_master ORDER BY booking_id DESC";
?>
<div class="row mg_tp_20"> 
	<div class="col-md-12"> 
	 <div class="table-responsive">
			<table class="table table-hover" id="tbl_estimate_list" style="margin: 20px 0 !important;">
				<thead>
					<tr class="active table-heading-row">
						<th>S_No.</th>
						<th>Customer_Name</th>
						<th>Check-In_Date</th>
						<th>Check-Out_Date</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sq_booking = mysql_query($query);
					$hotel_flag = 0;
					while($row_booking = mysql_fetch_assoc($sq_booking)){
						$checkin = array();
						$checkout = array();
						$cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
						foreach($cart_checkout_data as $values){
							if($values->service->name == "Hotel"){
								if($values->service->id == $user_id ){
									$customer_det = mysql_fetch_assoc(mysql_query("select first_name,middle_name,last_name from customer_master where customer_id = ".$row_booking['customer_id']));
									array_push($checkin, get_date_user($values->service->check_in));
									array_push($checkout, get_date_user($values->service->check_out));
									$hotel_flag = 1;
									$booking_id = $row_booking['booking_id'];
								}
						}
					}
					if($hotel_flag){
					?>
					<tr class="<?= $bg ?>">
							<td><?= ++$count ?></td>
							<td><?= ucfirst($customer_det['first_name']).' '.$customer_det['middle_name'].' '.$customer_det['last_name'] ?></td>
							<td><?= implode(',',$checkin) ?></td>
							<td><?= implode(',',$checkout) ?></td>
							<td><button class="btn btn-info btn-sm" onclick="view_modal('<?= $booking_id ?>')" title="View Details"><i class="fa fa-eye"></i></button></td>		
					</tr>
					<?php
					}
						$hotel_flag = 0;
					}
					?>
				</tbody>	
			</table>
		</div>
		</div>
</div>
<script>
$('#tbl_estimate_list').dataTable({
		"pagingType": "full_numbers"
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>