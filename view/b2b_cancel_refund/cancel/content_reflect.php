<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
?>
<input type="hidden" id="b_id" value="<?= $booking_id ?>">
<div class="row mg_tp_20">	
	<div class="col-md-10  col-md-offset-1 col-sm-12 col-xs-12">
		<div class="widget_parent-bg-img bg-img-red">
			<?php     
        $sq_b2b_info = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
        $cart_checkout_data = json_decode($sq_b2b_info['cart_checkout_data']);
        $hotel_list_arr = array();
        $transfer_list_arr = array();
        $activity_list_arr = array();
        $tours_list_arr = array();

        for($i=0;$i<sizeof($cart_checkout_data);$i++){
            if($cart_checkout_data[$i]->service->name == 'Hotel'){
              array_push($hotel_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Transfer'){
              array_push($transfer_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Activity'){
              array_push($activity_list_arr,$cart_checkout_data[$i]);
            }
            if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
              array_push($tours_list_arr,$cart_checkout_data[$i]);
            }
        }

        global $currency;
        $sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
        $to_currency_rate = $sq_to['currency_rate'];
                
        if(sizeof($hotel_list_arr)>0){
        $tax_total = 0;
        $hotel_total = 0;
        for($i=0;$i<sizeof($hotel_list_arr);$i++){
                //Applied Tax
                $room_cost = 0;
                $tax_amount = 0;
                $total_amount = 0;
                $tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
                for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
                $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
                $room_cost = $room_types[2];
                $h_currency_id = $room_types[3];
                
                $tax = ($room_cost * $tax_arr[1] / 100);
                //Convert into default currency
                $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                $from_currency_rate = $sq_from['currency_rate'];
                $room_cost = ($from_currency_rate / $to_currency_rate * $room_cost);
                $tax = ($from_currency_rate / $to_currency_rate * $tax);

                $tax_amount += $tax;
                $total_amount = $total_amount + $room_cost;
                }
                $hotel_total += $total_amount;
                $tax_total += $tax_amount;
            } }

            if(sizeof($transfer_list_arr)>0){
                $trtax_total = 0;
                $transfer_total = 0;
                for($i=0;$i<sizeof($transfer_list_arr);$i++){
                              
                  for($j=0;$j<sizeof($transfer_list_arr[$i]->service);$j++){
                    $tax_arr = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->transfer_cost);
                    $room_cost = $transfer_cost[0];
                    $h_currency_id = $transfer_cost[1];
                    $tax_amount = ($room_cost * $tax_arr[1] / 100);
                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                            
                            $trprice_total += $room_cost1;
                            $trtax_total += $tax_amount1;
                            $transfer_total += $room_cost1;
                            //Pickup n drop location
                            $pickup_id = $transfer_list_arr[$i]->service->service_arr[$j]->pickup_from;
                            if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'city'){
                              $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$pickup_id'"));
                              $pickup = $row['city_name'];
                            }
                            else if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'hotel'){
                              $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
                              $pickup = $row['hotel_name'];
                            }
                            else{
                              $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
                              $airport_nam = clean($row['airport_name']);
                              $airport_code = clean($row['airport_code']);
                              $pickup = $airport_nam." (".$airport_code.")";
                            }
                            //Drop-off
                            $drop_id = $transfer_list_arr[$i]->service->service_arr[$j]->drop_to;
                            if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'city'){
                              $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$drop_id'"));
                              $drop = $row['city_name'];
                            }
                            else if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'hotel'){
                              $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
                              $drop = $row['hotel_name'];
                            }
                            else{
                              $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
                              $airport_nam = clean($row['airport_name']);
                              $airport_code = clean($row['airport_code']);
                              $drop = $airport_nam." (".$airport_code.")";
                            }
                            $location = '('.$pickup.'-'.$drop.')';
                          } } }


                          if(sizeof($activity_list_arr)>0){
                            $acttax_total = 0;
                            $activity_total = 0;
                            for($i=0;$i<sizeof($activity_list_arr);$i++){
                              //Applied Tax
                              $room_cost = 0;
                              $tax_amount = 0;
                              $total_amount = 0;
                              $tax_arr = explode('-',$activity_list_arr[$i]->service->service_arr[0]->taxation);
                              $transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
                              $transfer = $transfer_types[0];
                              $room_cost = $transfer_types[1];
                              $h_currency_id = $transfer_types[2];
                              
                              $tax_amount = ($room_cost * $tax_arr[1] / 100);
                              $total_amount = $room_cost + $tax_amount;
                              //Convert into default currency
                              $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                              $from_currency_rate = $sq_from['currency_rate'];
                              $room_cost = ($from_currency_rate / $to_currency_rate * $room_cost);
                              $tax = ($from_currency_rate / $to_currency_rate * $tax_amount);
              
                              $activity_total += $room_cost;
                              $acttax_total += $tax;
                            
                              }
                            }


                            if(sizeof($tours_list_arr)>0){
                                $tourstax_total = 0;
                                $tours_total = 0;
                                for($i=0;$i<sizeof($tours_list_arr);$i++){
                                  //Applied Tax
                                  $room_cost = 0;
                                  $tax_amount = 0;
                                  $total_amount = 0;
                                  $tax_arr = explode('-',$tours_list_arr[$i]->service->service_arr[0]->taxation);
                                  $room_cost = $tours_list_arr[$i]->service->service_arr[0]->total_cost;
                                  $h_currency_id = $tours_list_arr[$i]->service->service_arr[0]->currency_id;
                                  
                                  $tax_amount = ($room_cost * $tax_arr[1] / 100);
                                  $total_amount = $room_cost + $tax_amount;
                                  //Convert into default currency
                                  $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                                  $from_currency_rate = $sq_from['currency_rate'];
                                  $room_cost = ($from_currency_rate / $to_currency_rate * $room_cost);
                                  $tax = ($from_currency_rate / $to_currency_rate * $tax_amount);
                  
                                  $tours_total += $room_cost;
                                  $tourstax_total += $tax;
                                
                                  }
                                }

                                $main_total += $hotel_total + $transfer_total + $activity_total + $tours_total;
                                $main_tax_total += $tax_total + $trtax_total + $acttax_total + $tourstax_total;
                                $final_total = $main_total + $main_tax_total;


                                $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$booking_id' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));

	            begin_widget();
	                $title_arr = array("Booking Amount", "Tax","Total Amount");
	                $content_arr = array( round($main_total,2), round($main_tax_total,2), round($final_total,2));
                  $percent = ($sq_payment_info['sum']/$final_total)*100;            
	                $percent = round($percent, 2);
	                $label = "B2B Fee Paid In Percent";
	                widget_element($title_arr, $content_arr, $percent, $label, $head_title);
	            end_widget();
	        ?>
	            <input type="hidden" id="total_sale" name="total_sale" value="<?= $final_total ?>">	        
	            <input type="hidden" id="total_paid" name="total_paid" value="<?= $sq_payment_info['sum']?>">
              <input type="hidden" id="total_tax" name="total_tax" value="<?= $main_tax_total ?>">
              <input type="hidden" id="total_booking" value="<?= $main_total ?>" >
		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_0">
			<thead>
				<tr class="table-heading-row">
					<th>S_No.</th>
					<th>Type</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 0;
      $disabled_count= 0;
      $sq_b2b_entries = mysql_query("select * from b2b_booking_master where booking_id='$booking_id'");
      $tax_type = "";
			while($row = mysql_fetch_assoc($sq_b2b_entries)){

				if($row['status']=="Cancel"){
					$bg = "danger";
					$checked = "checked disabled";
					++$disabled_count;
        }
        $cart_checkout_data = json_decode($row['cart_checkout_data']);

        for($i=0;$i<sizeof($cart_checkout_data);$i++){
          if($cart_checkout_data[$i]->service->name == 'Hotel'){
            $tax_type = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax)[0];
        ?>
            <tr class="<?= $bg ?>">
					    <td><?= ++$count ?></td>
              <td>Hotel Booking</td>
					    <td><?= $cart_checkout_data[$i]->service->hotel_arr->hotel_name ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Transfer'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					    <td><?= ++$count ?></td>
              <td>Transfer Booking</td>
					    <td><?= $cart_checkout_data[$i]->service->service_arr[0]->vehicle_name.'('.$cart_checkout_data[$i]->service->service_arr[0]->vehicle_type.')' ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Activity'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					      <td><?= ++$count ?></td>
                <td>Activity Booking</td>
					      <td><?= $cart_checkout_data[$i]->service->service_arr[0]->act_name ?></td>
				    </tr>
        <?php
          }
          if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
            $tax_type = explode('-',$cart_checkout_data[$i]->service->service_arr[0]->taxation)[0];
        ?>
            <tr class="<?= $bg ?>">
					      <td><?= ++$count ?></td>
                <td>Combo Tours</td>
					      <td><?= $cart_checkout_data[$i]->service->service_arr[0]->package ?></td>
				    </tr>
        <?php
          }
        }
			}
			?>
			</tbody>
		</table> 
    <div class="panel panel-default panel-body text-center">
				<button class="btn btn-danger btn-sm ico_left" onclick="cancel_booking()"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Booking</button>
			</div>
		</div> </div> 
    <input type="hidden" name="tax_type" id="tax_type" value="<?= $tax_type ?>">
</div>
<hr>
	<?php 
	$sq_cancel_count = mysql_num_rows(mysql_query("select * from b2b_booking_master where booking_id='$booking_id' and status='Cancel'"));
	if($sq_cancel_count>0){
		$sq_b2b_info = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
	?>
	<form id="frm_refund" class="mg_bt_150">

		<div class="row text-center">
			<div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_b2b_info['cancel_amount'] ?>">
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
				<input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_b2b_info['total_refund_amount'] ?>">
			</div>
		</div>
		<?php if($sq_b2b_info['cancel_amount'] == "0.00"){ ?>
		<div class="row mg_tp_20">
		  <div class="col-md-4 col-md-offset-4 text-center">
		      <button id="btn_refund_save" id="cancel_booking" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
		  </div>
		</div>
		<?php } ?>

	</form>
	<?php 
	}
	?>
<script>
function cancel_booking(){
	//Validaion to select complete tour cancellation 
  var booking_id = $('#b_id').val();
	$('#vi_confirm_box').vi_confirm_box({
	    message: 'Are you sure?',
	    callback: function(data1){
        if(data1=="yes"){
          var base_url = $('#base_url').val();
          $('#cancel_booking').button('loading');
          $.post(base_url+'controller/b2b_customer/cancel/cancel_booking.php', {booking_id : booking_id}, function(data){
            msg_alert(data);
            $('#cancel_booking').button('reset');
            content_reflect();
          });
        }
	    }
	});
}

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

$(function(){
  $('#frm_refund').validate({
      rules:{
        refund_amount : { required : true, number : true },
        total_refund_amount : { required : true, number : true },
      },
      submitHandler:function(form){

        var booking_id = $('#b_id').val();
        var cancel_amount = $('#cancel_amount').val();
        var total_refund_amount = $('#total_refund_amount').val();
			  var total_sale = $('#total_sale').val();
			  var total_paid = $('#total_paid').val();         
        var total_tax = $('#total_tax').val();    
        var tax_type = $('#tax_type').val();
        var total_booking = $('#total_booking').val();

			  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); return false; }
			  
              var base_url = $('#base_url').val();

              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){

                        $('#btn_refund_save').button('loading');

                        $.ajax({
                          type:'post',
                          url: base_url+'controller/b2b_customer/cancel/refund_estimate.php',
                          data:{ booking_id : booking_id, cancel_amount : cancel_amount, total_refund_amount : total_refund_amount, final_total : total_sale, main_tax_total : total_tax, taxation_type : tax_type, total_booking : total_booking },
                          success:function(result){
                            msg_alert(result);
                            content_reflect();
                            $('#btn_refund_save').button('reset');
                          },
                          error:function(result){
                            console.log(result.responseText);
                          }
                        });

                }
              }
            });

      }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>