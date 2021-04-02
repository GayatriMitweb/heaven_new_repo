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
$basic_cost1 = $_GET['basic_cost'];
$service_charge = $_GET['service_charge'];
$taxation_type = $_GET['taxation_type'];
$service_tax_per = $_GET['service_tax_per'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$sac_code = $_GET['sac_code'];
$credit_card_charges = $_GET['credit_card_charges'];
$charge = ($credit_card_charges!='') ? $credit_card_charges : 0 ;


$amount_in_word = $amount_to_word->convert_number_to_words($net_amount);
$sq_car = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));
$sq_count = mysql_num_rows(mysql_query("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'"));
$total_paid = $total_paid + $charge;

$tax_show = '';
$newBasic = $basic_cost1;
$newSC = $sq_car['service_charge'];
$service_charge = $sq_car['service_charge'];
$bsmValues = json_decode($sq_car['bsm_values']);
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_car['service_tax_subtotal'] !== 0.00 && ($sq_car['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_car['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0] . ' ' .$service_tax[1].',';
  }
}
if($bsmValues[0]->service != ''){ //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;
}
else{
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newSC = $service_charge;
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_car['markup_cost_subtotal'] !== 0.00 && $sq_car['markup_cost_subtotal'] !== ""){
  $service_tax_markup1 = explode(',',$sq_car['markup_cost_subtotal']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $sq_car['markup_cost'] + $markupservice_tax_amount;
}
else{
  $newBasic = $basic_cost1;
  $newSC = $service_charge + $sq_car['markup_cost'];
  $tax_show = rtrim($name, ', ') .' : ' . ($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $service_tax_amount + $sq_car['markup_cost'] + $markupservice_tax_amount;
}


//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">
<!-- <div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">  PASSENGER  : <?= $sq_car['pass_name'] ?></span></p></div>
<?php if($sq_count != 0){?>
<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>Vehicle_name</th>
              <th>Vehicle_no</th>
              <th>Rate_PER_Km</th>
              <th>Extra_KM</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $count = 1;
          $sq_vehicle_entries = mysql_query("select * from car_rental_booking where booking_id='$booking_id'");
          while($row_vehicle = mysql_fetch_assoc($sq_vehicle_entries)){              
            $sq_vehicle1 = mysql_fetch_assoc(mysql_query("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'"));
            $sq_vehicle = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor_vehicle_entries where vehicle_id='$sq_vehicle1[vehicle_id]'"));
            if($sq_vehicle['vehicle_name']!=''){
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?php echo $sq_vehicle['vehicle_name']; ?></td>
              <td><?= $sq_vehicle['vehicle_no'] ?></td>
              <td><?php echo ($row_vehicle['rate_per_km']); ?></td>
              <td><?php echo $row_vehicle['extra_km']; ?></td>
            </tr>
            <?php }
               $count++;
             } ?>
          </tbody>
        </table>
       </div>
     </div>
    </div>
  </div> -->
<?php } ?>
<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->


<div class="row">
    <div class="col-md-12">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $currency_code." ".number_format($newBasic,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $currency_code." ".number_format($net_amount,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?php echo $currency_code." ".number_format($newSC,2); ?></span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGE </span><span class="float_r"><?= $currency_code." ".number_format($charge,2)?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX</span><span class="float_r"><?= $currency_code." ".$tax_show ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCED PAID </span><span class="font_5 float_r"><?= $currency_code." ".number_format($total_paid,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ROUND OFF</span><span class="float_r"><?= $sq_car['roundoff'] ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $currency_code." ".number_format($net_amount + $credit_card_charges - $total_paid,2) ?></span></p></div>
       
      </div>
    </div>
  </div>

</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>