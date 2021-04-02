<?php 
include "../../../../model/model.php";
$booking_id = $_POST['booking_id'];
$total_sale = 0; $total_purchase = 0;
$entity = array('FLIGHT','TRAIN','HOTEL','TRANSPORT','DMC');
$package_booking_info = mysql_fetch_assoc(mysql_query("select *  from package_tour_booking_master where booking_id='$booking_id' "));
//Tour Total
$tour_amount= ($package_booking_info['actual_tour_expense']!="") ? $package_booking_info['actual_tour_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_train_amount'] + $sq_tour_refund['total_plane_amount']);

$total_tour_amount = $tour_amount - $can_amount ;
//Travel Total 
$travel_amount= ($package_booking_info['total_travel_expense']!="") ? $package_booking_info['total_travel_expense']: 0;

$sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_visa_amount'] + $sq_tour_refund['total_insuarance_amount'] + $sq_tour_refund['total_tour_amount']);

$total_travel_amount = $travel_amount - $can_amount ;

$total_sale = $total_tour_amount + $total_travel_amount;

////// Purchase ///////
$sq_air_ticket = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and vendor_type='Ticket Vendor'");
while($row_air_ticket = mysql_fetch_assoc($sq_air_ticket)){
	$air_ticket_sum = $air_ticket_sum + $row_air_ticket['net_total'] - $row_air_ticket['refund_net_total'];
}

$sq_train_ticket = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and vendor_type='Train Ticket Vendor'");
while($row_train_ticket = mysql_fetch_assoc($sq_train_ticket)){
	$train_ticket_sum = $train_ticket_sum + $row_train_ticket['net_total'] - $row_train_ticket['refund_net_total'];
}

$sq_hotel = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and vendor_type='Hotel Vendor'");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
	$hotel_ticket_sum = $hotel_ticket_sum + $row_hotel['net_total'] - $row_hotel['refund_net_total'];
}

$sq_dmc = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and vendor_type='DMC Vendor'");
while($row_dmc = mysql_fetch_assoc($sq_dmc)){
	$dmc_ticket_sum = $dmc_ticket_sum + $row_dmc['net_total'] - $row_dmc['refund_net_total'];
}

$sq_trasnport = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and vendor_type='Transport Vendor'");
while($row_trasnport = mysql_fetch_assoc($sq_trasnport)){
	$transport_ticket_sum = $transport_ticket_sum + $row_trasnport['net_total'] - $row_trasnport['refund_net_total'];
}

$total_purchase = ($transport_ticket_sum + $dmc_ticket_sum + $hotel_ticket_sum + $air_ticket_sum + $train_ticket_sum);

if($air_ticket_sum == ''){ $air_ticket_sum = 0; }
if($train_ticket_sum == ''){ $train_ticket_sum = 0; }
if($hotel_ticket_sum == ''){ $hotel_ticket_sum = 0; }
if($transport_ticket_sum == ''){ $transport_ticket_sum = 0; }
if($dmc_ticket_sum == ''){ $dmc_ticket_sum = 0; }

$purchase_cost = array($air_ticket_sum,$train_ticket_sum,$hotel_ticket_sum,$transport_ticket_sum,$dmc_ticket_sum);

$result = $total_sale - $total_purchase;

if($result >= '0' ) { $var = "Profit"; }
else{ $var = "Loss";
	  $result = $total_purchase - $total_sale;	 }
?>
<div class="row mg_tp_20"> <div class="col-md-12"> 
	
	<div class="table-responsive">
	<table class="table table-hover mg_bt_10 no-marg" style="border: 1px solid #ddd;">
		<thead>
			<tr class="table-heading-row">
				<th>Sale_Cost</th>
				<th style="width:10%;"></th>
				<th>Purchase_Cost</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			for($i=0;$i<5;$i++){ ?>
				<tr>
					<td>
						<?php if($i == 0){ ?>
						<input type="text" class="form-control" id="estimate_cost_pc_<?= $count ?>" name="estimate_cost_pc" value="<?= number_format($total_sale,2) ?>" readonly>
						<?php } ?>
					</td>
					<td></td>
					<td>
						<input type="text" class="form-control" id="entity_cost_pc_<?= $count ?>" name="entity_cost_pc" value="<?= $entity[$i]." : ".number_format($purchase_cost[$i],2) ?>" readonly>
					</td>
				</tr>
				<?php } ?>
		</tbody>
	</table>
	<div class="row mg_tp_10">
		<div class="col-md-6">
			<h4>Total Sale Cost</h4><td><input class="form-control" type="text" id="total_sale1" name="total_sale1" value="<?= number_format($total_sale,2) ?>" disabled>
		</div>
		<div class="col-md-6">
			<h4>Total Purchase Cost</h4><input class="form-control" type="text" id="total_purchase1" name="total_purchase1" value="<?= number_format($total_purchase,2) ?>" disabled>
	    </div>
	</div>
	<div class="row">
	<div class="col-md-6 mg_tp_10 mg_bt_10">
		<h4>Total <?= $var ?></h4>
		<input type="text" class="form-control" id="result1" name="result1" value="<?= number_format($result,2); ?>" disabled>
	</div>	
	</div>
	</div>
	<input class="form-control" type="hidden" id="total_sale" name="total_sale" value="<?= $total_sale ?>">
	<input class="form-control" type="hidden" id="total_purchase" name="total_purchase" value="<?= $total_purchase ?>">
	<input class="form-control" type="hidden" id="result" name="result" value="<?= $result ?>">
    <input class="form-control" type="hidden" id="profit_loss" name="profit_loss" value="<?= $var ?>">

	<div class="row col-md-12 text-center mg_tp_20">
		<button class="btn btn-success" onclick="save_package_tour_estimate_expense()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	</div>

</div>

<script>
	function save_package_tour_estimate_expense()
	{
		var base_url = $('#base_url').val();
		var booking_id = $('#cmb_booking_id').val();
		var total_sale = $('#total_sale').val();
		var total_purchase = $('#total_purchase').val();
		var result = $('#result').val();
		var profit_loss = $('#profit_loss').val();

		if(booking_id==""){
			error_msg_alert("Select Booking ID.");
			return false;
		}

		$.ajax({
		type:'post',
		url: base_url+'controller/tour_estimate/package_tour_estimate_expense_save.php',
		data:{ booking_id : booking_id,total_sale : total_sale,total_purchase : total_purchase,result : result, profit_loss : profit_loss },
			success:function(data){
				msg_alert(data);
			}
		});
	}
</script>