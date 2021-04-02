<?php 
$booking_id = $_POST['booking_id'];

$sq_est_info = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));

$query1 = "SELECT * from package_payment_master where booking_id='$booking_id'";
	
 $sq_tour_paid_amount=0;
 $tour_pending_cancel = 0;
		
$sq_package_tour_payment = mysql_query($query1);	
while($row_package_tour_payment = mysql_fetch_assoc($sq_package_tour_payment))
{
	if($row_package_tour_payment['clearance_status']=="Pending" || $row_package_tour_payment['clearance_status']=="Cancelled"){ 
		$tour_pending_cancel = $tour_pending_cancel + $row_package_tour_payment['amount'];
	}
$sq_tour_paid_amount = $sq_tour_paid_amount + $row_package_tour_payment['amount'];
}

$query = "SELECT * from package_payment_master where booking_id='$booking_id' AND payment_for='Travelling'";

$sq_paid_amount=0;
$pending_cancel = 0;
		
$sq_package_payment = mysql_query($query);	
while($row_package_payment = mysql_fetch_assoc($sq_package_payment)){

	if($row_package_payment['clearance_status']=="Pending" || $row_package_payment['clearance_status']=="Cancelled"){ 
		$pending_cancel = $pending_cancel +$row_package_payment['amount'];
	 }
	$sq_paid_amount = $sq_paid_amount + $row_package_payment['amount'];
}

$sq_pck_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));

$paid_amount = ($sq_paid_amount - $pending_cancel ) + ($sq_tour_paid_amount - $tour_pending_cancel );
?>
<hr>
<input type="hidden" id="total_sale" name="total_sale" value="<?= $sq_pck_info['net_total']  ?>">	        
<input type="hidden" id="total_paid" name="total_paid" value="<?= $paid_amount?>">	

<div class="row">
	<div class="col-sm-6 col-sm-offset-3 col-xs-12">
		<div class="widget_parent-bg-img bg-img-red">
			<div class="widget_parent">
				<div class="stat_content main_block">
					<!-- <span class="main_block content_span">
					  	<span class="stat_content-tilte pull-left">Total Travelling Paid </span>
						<span class="stat_content-amount pull-right"> <?php echo number_format(($sq_paid_amount - $pending_cancel ), 2); ?></span>
					</span> -->
					<span class="main_block content_span">
					 	<span class=" stat_content-tilte pull-left">Total Paid</span>
					 	<span class="stat_content-amount pull-right"><?php echo number_format(($sq_tour_paid_amount - $tour_pending_cancel ) ,2);?></span>
					</span>
				</div>
			</div>
		</div>
		
	</div>
</div> 
<hr>
<?php 
$sq_p_info = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$sq_c_info = mysql_num_rows(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));
$pass_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_booking[booking_id]'"));
$cancle_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_booking[booking_id]' and status='Cancel'"));
?>
<form id="frm_refund" class="mg_bt_30">

	<div class="row text-center">
		<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="cancel_amount" id="cancel_amount"  class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_p_info['cancel_amount'] ?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_p_info['total_refund_amount'] ?>">
		</div>
	</div>
	<?php if($pass_count!=$cancle_count || $sq_c_info =='0'){ ?>
	<div class="row mg_tp_20">
	  <div class="col-md-12 text-center">
	      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
	  </div>
	</div>
	<?php } ?>

</form>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

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
              refund_amount : { required : true, number : true },
              total_refund_amount : { required : true, number : true },
	},
	submitHandler:function(form){

			var booking_id = $('#booking_id').val();
              var cancel_amount = $('#cancel_amount').val();
              var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();

			  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }

			$.ajax({
				type:'post',
				url: base_url()+'controller/package_tour/cancel_and_refund/booking_refund_estimate.php',
				data: { booking_id : booking_id, cancel_amount : cancel_amount, total_refund_amount : total_refund_amount },
				success:function(result){
					msg_alert(result);			
					cancel_booking_reflect();
				}
				
			});

	}

});
</script>