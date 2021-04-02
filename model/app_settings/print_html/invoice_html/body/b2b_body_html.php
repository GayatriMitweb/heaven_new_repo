<?php  
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 

//Parameters
$invoice_no = $_GET['invoice_no'];
$booking_id = $_GET['booking_id'];
$invoice_date = $_GET['invoice_date'];
$customer_id = $_GET['customer_id'];
$service_name = $_GET['service_name'];

$query = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
$cart_checkout_data = json_decode($query['cart_checkout_data']);
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

//Get default currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">
<!-- <div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">BUS : </span><?= $sq_vehicle['p_name']; ?></p></div> -->
<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>Specifications</th>
              <th>Name</th>
              <th>From_Date</th>
              <th>To_Date</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php $count = 1;
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

              $tax_amount = 0;
              $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
              $room_cost = $room_types[2];
              $h_currency_id = $room_types[3];

              $tax_arr1 = explode('+',$tax_arr[0]);
              for($t=0;$t<sizeof($tax_arr1);$t++){
                if($tax_arr1[$t]!=''){
                $tax_arr2 = explode(':',$tax_arr1[$t]);
                if($tax_arr2[2] == "Percentage"){
                  $tax = $tax + ($room_cost * $tax_arr2[1] / 100);
                }else{
                  $tax = $tax + ($room_cost +$tax_arr2[1]);
                }
                }
              }
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
          ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?= 'Hotel' ?></td>
              <td><?= $hotel_list_arr[$i]->service->hotel_arr->hotel_name ?></td>
              <td><?php echo get_date_user($hotel_list_arr[$i]->service->check_in); ?></td>
              <td><?php echo get_date_user($hotel_list_arr[$i]->service->check_out); ?></td>
              <td><?php echo number_format($total_amount,2); ?></td>
            </tr>
            <?php
               $count++;
            } }
            if(sizeof($transfer_list_arr)>0){
            $trtax_total = 0;
            $transfer_total = 0;
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
                  
              for($j=0;$j<sizeof($transfer_list_arr[$i]->service);$j++){

                $tax_amount = 0;
                $tax_arr = explode(',',$transfer_list_arr[$i]->service->service_arr[$j]->taxation);
                $transfer_cost = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->transfer_cost);
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
              ?>
                <tr class="odd">
                  <td><?php echo $count; ?></td>
                  <td><?= 'Transfer('.ucfirst($transfer_list_arr[$i]->service->service_arr[$j]->trip_type).')' ?></td>
                  <td><?= $transfer_list_arr[$i]->service->service_arr[$j]->vehicle_name.'('.$transfer_list_arr[$i]->service->service_arr[$j]->no_of_vehicles.') '.$location ?></td>
                  <td><?php echo get_datetime_user($transfer_list_arr[$i]->service->service_arr[$j]->pickup_date); ?></td>
                  <td><?php echo ($transfer_list_arr[$i]->service->service_arr[$j]->trip_type == 'roundtrip') ?get_datetime_user($transfer_list_arr[$i]->service->service_arr[$j]->return_date) : 'NA'; ?></td>
                  <td><?php echo number_format($room_cost1,2); ?></td>
                </tr>
                <?php
                  $count++;
              } } }
              if(sizeof($activity_list_arr)>0){
              $acttax_total = 0;
              $activity_total = 0;
              for($i=0;$i<sizeof($activity_list_arr);$i++){
                $tax_amount = 0;
                //Applied Tax
                $room_cost = 0;
                $tax_amount = 0;
                $total_amount = 0;
                $tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[0]->taxation);
                $transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
                $transfer = $transfer_types[0];
                $room_cost = $transfer_types[1];
                $h_currency_id = $transfer_types[2];
                
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
                $room_cost = ($from_currency_rate / $to_currency_rate * $room_cost);
                $tax = ($from_currency_rate / $to_currency_rate * $tax_amount);

                $activity_total += $room_cost;
                $acttax_total += $tax;
              ?>
                <tr class="odd">
                  <td><?php echo $count; ?></td>
                  <td><?= 'Activity' ?></td>
                  <td><?= $activity_list_arr[$i]->service->service_arr[0]->act_name.'('.$transfer.')' ?></td>
                  <td><?php echo get_date_user($activity_list_arr[$i]->service->service_arr[0]->checkDate); ?></td>
                  <td><?php echo 'NA'; ?></td>
                  <td><?php echo number_format($total_amount,2); ?></td>
                </tr>
                <?php
                   $count++;
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
                $tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[0]->taxation);
                $room_cost = $tours_list_arr[$i]->service->service_arr[0]->total_cost;
                $h_currency_id = $tours_list_arr[$i]->service->service_arr[0]->currency_id;
                
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
                $room_cost = ($from_currency_rate / $to_currency_rate * $room_cost);
                $tax = ($from_currency_rate / $to_currency_rate * $tax_amount);

                $tours_total += $room_cost;
                $tourstax_total += $tax;
              ?>
                <tr class="odd">
                  <td><?php echo $count; ?></td>
                  <td><?= 'Combo Tours' ?></td>
                  <td><?= $tours_list_arr[$i]->service->service_arr[0]->package.'('.$tours_list_arr[$i]->service->service_arr[0]->package_code.')' ?></td>
                  <td><?php echo get_date_user($tours_list_arr[$i]->service->service_arr[0]->travel_date); ?></td>
                  <td><?php echo 'NA'; ?></td>
                  <td><?php echo number_format($total_amount,2); ?></td>
                </tr>
                <?php
                   $count++;
                }
              }
            
            $main_total += $hotel_total + $transfer_total + $activity_total + $tours_total;
            $main_tax_total += $tax_total + $trtax_total + $acttax_total + $tourstax_total;
            $final_total = $main_total + $main_tax_total;
            
            if($query['coupon_code'] != ''){
              $sq_hotel_count = mysql_num_rows(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
              if($sq_hotel_count > 0){
                $sq_coupon = mysql_fetch_assoc(mysql_query("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
              }else{
                $sq_coupon = mysql_fetch_assoc(mysql_query("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$query[coupon_code]'"));
              }
              if($sq_coupon['offer']=="Flat"){
                $coupon_amount = $sq_coupon['offer_amount'];
                $final_total1 = $final_total - $coupon_amount;
              }else{
                $coupon_amount = ($final_total*$sq_coupon['offer_amount']/100);
                $final_total1 = $final_total - $coupon_amount;
              }
            }else{
              $final_total1 = $final_total;
            }
            $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$booking_id' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
            $payment_amount = $sq_payment_info['sum'];
            $cur_due = $final_total1 - $payment_amount;
            ?>
          </tbody>
        </table>
       </div>
     </div>
    </div>
  </div>

<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->
  <div class="row">
    <div class="col-md-12 text-right">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">AMOUNT</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($main_total,2) ?></span></div></p>
        </div>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">TAX</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($main_tax_total,2) ?></span></div></p>
        </div>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">TOTAL</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($final_total,2) ?></span></div></p>
        </div>
        <?php if($query['coupon_code'] != ''){ ?>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">COUPON DISCOUNT</span></div>
          <div class="col-md-6 float_r"><span><?= '-'.number_format($coupon_amount,2) ?></span></div></p>
        </div>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">NET AMOUNT</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($final_total1,2) ?></span></div></p>
        </div>
        <?php } ?>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">PAID</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($payment_amount,2) ?></span></div></p>
        </div>
        <div class="col-md-12 border_lt"><p>
          <div class="col-md-6 text-left"><span class="font_5">CURRENT DUE</span></div>
          <div class="col-md-6 float_r"><span><?= number_format($cur_due,2) ?></span></div></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$amount_in_word = $amount_to_word->convert_number_to_words($final_total);
//Footer
include "../generic_footer_html.php"; ?>