<?php
include "../../../model/model.php";
$booking_id = $_POST['booking_id'];
$sq_b2b_info = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
$sq_ref_pay_total = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_pay = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id'"));
$sq_ref_pen_total = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status='Pending'"));
$sq_ref_can_total = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status='Cancelled'"));


    $hotel_list_arr = array();
    $transfer_list_arr = array();
    $activity_list_arr = array();
    $tours_list_arr = array();

    $cart_checkout_data = json_decode($sq_b2b_info['cart_checkout_data']);

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



$toal_refund_sum=$sq_pay['sum'] - $sq_ref_can_total['sum'];
$paid_amount = $sq_payment_info['sum'];
$sale_amount = $final_total;
$cancel_amount = $sq_b2b_info['cancel_amount'];
$refund_amount = $sq_b2b_info['total_refund_amount'];

$remaining_pay=$refund_amount-$toal_refund_sum;
?>
<input type="hidden" id="refund_amount_tobe" name="refund_amount_tobe" value="<?php echo $refund_amount ?>">
<div class="row mg_tp_20 mg_bt_10">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12 mg_bt_10_xs">
		<div class="widget_parent-bg-img bg-green">
			<div class="widget_parent">
				<div class="stat_content main_block">
			        <span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Sale</span>
						<span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sale_amount=='')?'0.00': number_format($sale_amount,2) ?></span>
			        </span>
			        <span class="main_block content_span" data-original-title="" title="">
			         	<span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
			        	<span class="stat_content-amount pull-right" data-original-title="" title=""> <?= ($paid_amount=='')?'0.00': number_format($paid_amount,2)?></span>
			        </span>	
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?= number_format($cancel_amount, 2); ?></span>
			        </span>	        
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($refund_amount, 2); ?></span>
			        </span>
			    </div>	 
			</div>
		</div>		
	</div>
</div>

<hr>

<div class="row">

	<div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">

		<form id="frm_refund_save">
        <h3 class="editor_title">Refund Details</h3>
    	<div class="panel panel-default panel-body mg_bt_10">
			<div class="row text-center">    
			    <div class="col-sm-6 col-xs-12 mg_bt_10">
			    	<input type="hidden" name="remaining_fund" id="remaining_fund" value="<?php echo $remaining_pay;?>">
			      <input type="text" id="refund_amount" name="refund_amount" title="Refund Amount" placeholder="*Refund Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'refund_mode','transaction_id','bank_name')">
			    </div>
			    <div class="col-sm-6 col-xs-12 mg_bt_10">
			      <input type="text" id="refund_date" name="refund_date" title="Refund Date" placeholder="*Refund Date" value="<?= date('d-m-Y')?>">
			    </div>   			        
				<div class="col-sm-6 col-xs-12 mg_bt_10">
				    <select id="refund_mode" name="refund_mode" class="form-control" required title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						<?php get_payment_mode_dropdown(); ?>
				    </select>  
				</div>
				<div class="col-sm-6 col-xs-12 mg_bt_10">
				    <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled />
				</div>      
			    <div class="col-sm-6 col-xs-12 mg_bt_10">
			    	<input type="text" id="transaction_id" onchange="validate_balance(this.id);" name="transaction_id" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" disabled />
			  	</div>
			  	<div class="col-sm-6 col-xs-12 mg_bt_10">
			  		<select name="bank_id" id="bank_id" title="Debitor Bank" disabled>
	                    <?php get_bank_dropdown('Debitor Bank')  ?>
	                </select>
			  	</div>
			</div>
			<div class="row mg_bt_10">
				<div class="col-xs-12">
				  	<select name="entry_id" id="entry_id" multiple>
				  		<?php
								$sq_b2b_info1 = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_b2b_info[customer_id]'"));
								$customer_name = ($sq_b2b_info1['type'] == 'Corporate') ? $sq_b2b_info1['company_name'] : $sq_b2b_info1['first_name'].' '.$sq_b2b_info1['last_name'];
				  			?>
							<option value="<?= $sq_b2b_info1['customer_id'] ?>"><?= $customer_name ?></option>
				  		?>
				  	</select>
				 </div>
			</div>

			<div class="row text-center mg_tp_20">
			  <div class="col-xs-12">
			      <button id="btn_refund_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
			  </div>
			</div>

		</form>
		</div>
	</div>


	<div class="col-md-6 col-sm-12 col-xs-12"> 
	<h3 class="editor_title">Refund History</h3>
	<div class="panel panel-default panel-body no-pad"> 
		<div class="table-responsive">
			<table class="table table-bordered" id="tbl_refund_list" style="margin: 0 !important;">
				<thead>
					<tr class="table-heading-row">
						<th>S_No.</th>
						<th>Refund_To</th>
						<th>Refund_Date</th>
						<th>Amount</th>
						<th>Mode</th>
						<th>Bank_Name</th>
						<th>Cheque_No/ID</th>
						<th>Voucher</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total_refund = 0;
					$query = "select * from b2b_booking_refund_master where booking_id='$booking_id' and refund_amount!='0'";
					$count = 0;

					$sq_b2b_refund = mysql_query($query);
					while($row_b2b_refund = mysql_fetch_assoc($sq_b2b_refund)){

						$count++;
						$total_refund = $total_refund+$row_b2b_refund['refund_amount'];

						$sq_b2b_info1 = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$row_b2b_refund[booking_id]'"));
						$date = $sq_b2b_info1['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
						$hotel_name = "";
						$sq_refund_entries = mysql_query("select * from b2b_booking_refund_entries where refund_id='$row_b2b_refund[refund_id]'");
						while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
							$sq_b2b_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_refund_entry[entry_id]'"));
							$hotel_name = ($sq_b2b_info['type'] == 'Corporate') ? $sq_b2b_info['company_name'] : $sq_b2b_info['first_name'].' '.$sq_b2b_info['last_name'];
						}

						if($row_b2b_refund['clearance_status']=="Pending"){ $bg = "warning"; }
						else if($row_b2b_refund['clearance_status']=="Cancelled"){ $bg = "danger"; }
						else{ $bg = ""; }
						$date = $row_b2b_refund['refund_date'];
						$yr = explode("-", $date);
						$year1 =$yr[0];

						$v_voucher_no = get_b2b_booking_refund_id($row_b2b_refund['refund_id'],$year1);
						$v_refund_date = $row_b2b_refund['refund_date'];
						$v_refund_to = $hotel_name;
						$v_service_name = "B2B Booking";
						$v_refund_amount = $row_b2b_refund['refund_amount'];
						$v_payment_mode = $row_b2b_refund['refund_mode'];
						$customer_id = $sq_b2b_info1['customer_id'];
						$refund_id = $row_b2b_refund['refund_id'];
						$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id";
						?>
						<tr class="<?= $bg ?>">			
							<td><?= $count ?></td>
							<td><?= $hotel_name ?></td>
							<td><?= date('d/m/Y', strtotime($row_b2b_refund['refund_date'])) ?></td>
							<td><?= $row_b2b_refund['refund_amount'] ?></td>
							<td><?= $row_b2b_refund['refund_mode'] ?></td>
							<td><?= $row_b2b_refund['bank_name'] ?></td>
							<td><?= $row_b2b_refund['transaction_id'] ?></td>
							<td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank" title="Voucher"><i class="fa fa-file-pdf-o"></i></a></td>
						</tr>
						<?php
					}
					?>
				</tbody>
				<tfoot>
					<?php 
					?>
					<tr class="active">
						<th class="text-right info" colspan="2">Refund : <?= ($sq_pay['sum']=="") ? 0 : $sq_pay['sum'] ?></th>
						<th class="text-right warning" colspan="2">Pending : <?= ($sq_ref_pen_total['sum']=="") ? 0 : $sq_ref_pen_total['sum'] ?></th>
						<th class="text-right danger" colspan="2">Cancelled : <?= ($sq_ref_can_total['sum']=="") ? 0 : $sq_ref_can_total['sum'] ?></th>
						<th class="text-right success" colspan="2">Total Refund : <?= $sq_pay['sum'] - $sq_ref_pen_total['sum'] - $sq_ref_can_total['sum'] ?></th>
					</tr>
				</tfoot>
			</table>
			</div>
	</div> 
	</div>
	<input type="hidden" id="ref_amt" value="<?= ($sq_pay['sum']=="") ? 0 : $sq_pay['sum'] ?>">
</div>


<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$(function(){
  $('#frm_refund_save').validate({
      rules:{
              booking_id : { required: true }, 
              refund_amount : { required: true, number:true },
              refund_date : { required: true },
              refund_mode : { required : true },
              bank_name : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              bank_id : { required : function(){  if($('#refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
              entry_id: { required : true },    
      },
      submitHandler:function(form){

              var booking_id = $('#booking_id').val(); 
              var refund_amount = $('#refund_amount').val();
              var refund_date = $('#refund_date').val();
              var refund_mode = $('#refund_mode').val();
              var bank_name = $('#bank_name').val();
              var transaction_id = $('#transaction_id').val();
              var bank_id = $('#bank_id').val();
              var remaining_fund = $('#remaining_fund').val();
              var entry_id_arr = new Array();
              $('#entry_id option:selected').each(function(){
              	entry_id_arr.push($(this).val());
              });
              var base_url = $('#base_url').val();
			  if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount_tobe').val()))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
              else if(Number(refund_amount) > Number(remaining_fund))
              { error_msg_alert("Amount can not be greater than total refund amount"); return false; }
             
              $('#vi_confirm_box').vi_confirm_box({
                message: 'Are you sure?',
                callback: function(data1){
                    if(data1=="yes"){                       
                        $('#btn_refund_save').button('loading');
                        $.ajax({
                          type:'post',
                          url: base_url+'controller/b2b_customer/refund/refund_save.php',
                          data:{ booking_id : booking_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, entry_id_arr : entry_id_arr },
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