<?php 
$sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));

$query1 = "SELECT * from payment_master where tourwise_traveler_id='$tourwise_id' ";
	
 $sq_tour_paid_amount=0;
 $tour_pending_cancel = 0;
		
$sq_group_tour_payment = mysql_query($query1);	
while($row_group_tour_payment = mysql_fetch_assoc($sq_group_tour_payment)){

	if($row_group_tour_payment['clearance_status']=="Pending" || $row_group_tour_payment['clearance_status']=="Cancelled"){ 
		$tour_pending_cancel = $tour_pending_cancel + $row_group_tour_payment['amount'];
	}
	 	
	$sq_tour_paid_amount = $sq_tour_paid_amount + $row_group_tour_payment['amount'];
}
   

$sq_paid_amount=0;
$pending_cancel = 0;
		
// $query = "SELECT * from payment_master where tourwise_traveler_id='$tourwise_id' ";

// $sq_group_payment = mysql_query($query);	
// while($row_group_payment = mysql_fetch_assoc($sq_group_payment)){

// 	if($row_group_payment['clearance_status']=="Pending" || $row_group_payment['clearance_status']=="Cancelled"){ 
// 		$pending_cancel = $pending_cancel +$row_group_payment['amount'];
// 	 }
// 	$sq_paid_amount = $sq_paid_amount + $row_group_payment['amount'];
// }

$sq_group_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
$paid_amount =  ($sq_tour_paid_amount - $tour_pending_cancel );
?>

<input type="hidden" id="total_sale" name="total_sale" value="<?= $sq_group_info['total_tour_fee'] + $sq_group_info['total_travel_expense']?>">	        
<input type="hidden" id="total_paid" name="total_paid" value="<?= $paid_amount ?>">	

<div class="row mg_tp_20">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
		<div class="widget_parent-bg-img bg-green">
			<div class="widget_parent">
				<div class="stat_content main_block">
					<!-- <span class="main_block content_span">
					  	<span class="stat_content-tilte pull-left">Total Travelling Paid </span>
						<span class="stat_content-amount pull-right"> <?php echo number_format(($sq_paid_amount - $pending_cancel ), 2); ?></span>
					</span> -->
					<span class="main_block content_span">
					 	<span class="stat_content-tilte pull-left">Total Paid</span>
					 	<span class="stat_content-amount pull-right"><?php echo number_format(($sq_tour_paid_amount - $tour_pending_cancel ) ,2);?></span>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<hr>
<?php
	$sq_tour_info = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
	$sq_tour_count = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
?>
<form id="frm_refund">

	<div class="row text-center">
		<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_tour_info['cancel_amount'] ?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_tour_info['total_refund_amount'] ?>">
		</div>
	</div>
	<?php if($sq_tour_info['cancel_amount'] == "0.00" || $sq_tour_count =='0'){ ?>
	<div class="row mg_tp_20">
	  <div class="col-md-3 col-md-offset-5">
	      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
	  </div>
	</div>
	<?php } ?>
</form>

<hr>

<script>

function calculate_total_refund()
{
	var total_refund_amount = 0;
	var cancel_amount = $('#cancel_amount').val();
	var total_sale = $('#total_sale').val();
	var total_paid = $('#total_paid').val();

	if(cancel_amount==""){ cancel_amount = 0; }
	if(total_paid==""){ total_paid = 0; }

	if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); }
	var total_refund_amount = parseFloat(total_paid) - parseFloat(cancel_amount);
	
	if(parseFloat(total_refund_amount) < 0){ 
		total_refund_amount = 0;
	}
	$('#total_refund_amount').val(total_refund_amount.toFixed(2));
}


$('#frm_refund').validate({
	rules:{
			cancel_amount :{ required : true, number : true },
			total_refund_amount :{ required : true, number : true },	
	},
	submitHandler:function(form){

			  var tourwise_id = $('#txt_tourwise_traveler_id').val();
				var cancel_amount = $('#cancel_amount').val();
				var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();

			  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }


			$.ajax({
				type:'post',
				url: base_url()+'controller/group_tour/tour_cancelation_and_refund/booking_tour_refund_estimate.php',
				data: { tourwise_id : tourwise_id,cancel_amount : cancel_amount, total_refund_amount : total_refund_amount},
				success:function(result){
					msg_popup_reload(result);
				}
				
			});



	}

});
</script>