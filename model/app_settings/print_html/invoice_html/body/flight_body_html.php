<?php
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 

//Parameters
$invoice_no = $_GET['invoice_no'];
$ticket_id = $_GET['ticket_id'];
$invoice_date = $_GET['invoice_date'];
$customer_id = $_GET['customer_id'];
$service_name = $_GET['service_name'];
$basic_cost1 = $_GET['basic_cost'];
$taxation_type = $_GET['taxation_type'];
$service_tax_per = $_GET['service_tax_per'];
$service_tax = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$sac_code = $_GET['sac_code'];
$credit_card_charges = $_GET['credit_card_charges'];

$charge = ($credit_card_charges!='') ? $credit_card_charges : 0;
$total_paid += $charge;

$sq_passenger = mysql_query("select * from ticket_master_entries where ticket_id = '$ticket_id'");
$sq_passenger_count = mysql_fetch_assoc(mysql_query("select count(*) as cnt from ticket_master_entries where ticket_id = '$ticket_id'"));
$sq_fields = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id = '$ticket_id'"));
$bsmValues = json_decode($sq_fields['bsm_values']);

$other_tax = $sq_fields['other_taxes'];
$yq_tax = $sq_fields['yq_tax'];
$tax_show = '';
$newBasic = $basic_cost1;
$newSC = $sq_fields['service_charge'];
$service_charge = $sq_fields['service_charge'];
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_fields['service_tax_subtotal'] !== 0.00 && ($sq_fields['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_fields['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
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
if($sq_fields['service_tax_markup'] !== 0.00 && $sq_fields['service_tax_markup'] !== ""){
  $service_tax_markup1 = explode(',',$sq_fields['service_tax_markup']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $sq_fields['markup'] + $markupservice_tax_amount;
  $tax_show= '';
}
else{
  $newBasic = $basic_cost1;
  $newSC = $service_charge + $sq_fields['markup'];
  $tax_show = rtrim($name, ', ') .' : ' . ($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $service_tax_amount + $sq_fields['markup'] + $markupservice_tax_amount;
}

$word_amount =  $net_amount + $charge;
$amount_in_word = $amount_to_word->convert_number_to_words($word_amount);
//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>


<div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">PASSENGER (s):  <?= $sq_passenger_count['cnt'] ?></span></p></div>
<!-- invoice_receipt_body_table-->
   <div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th class="font_s_12">S.NO</th>
              <th class="font_s_12">NAME</th>
              <th class="font_s_12">SECTOR</th>
              <th class="font_s_12">Departure</th>
              <th class="font_s_12">PNR</th>
              <th class="font_s_12">FLIGHT_NO</th>
              <th class="font_s_12">Ticket_NO</th>
              <th class="font_s_12">Base_Fare</th>
              <th class="font_s_12">YQ</th>
              <th class="font_s_12">OTHER_TAX</th>   
            </tr>
          </thead>
          <tbody>   
          <?php 
          $count = 1;
          while($row_passenger = mysql_fetch_assoc($sq_passenger))
          {
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?php echo $row_passenger['first_name'].' '.$row_passenger['last_name']; ?></td>
            <?php
            $sq_dest1 = mysql_query("select * from ticket_trip_entries where ticket_id = '$row_passenger[ticket_id]'");
            $dep_final = '';
            $flight_no = '';
            $dep_time = '';
            $pnr = '';
            while($sq_dest = mysql_fetch_assoc($sq_dest1)){
              $sectors_dep = explode('(',$sq_dest['departure_city']);
              $sectors_dep = $sectors_dep[sizeof($sectors_dep)-1];
              $sectors_ar = explode('(',$sq_dest['arrival_city']);
              $sectors_ar = $sectors_ar[sizeof($sectors_ar)-1];
              $dep_time .= date("d-m-Y H:i:s", strtotime($sq_dest['departure_datetime'])).'<br>';
              $pnr .= $sq_dest['airlin_pnr'].'<br>';
              $flight_no .=  $sq_dest['flight_no'].'<br>';
              $dep_final .= $sectors_dep.' - '.$sectors_ar.' ,<br>';   
            }
            ?>
              <td><?php echo rtrim(str_replace(array( '(', ')' ), '', $dep_final),', <br>') ?></td>
              <td><?php echo $dep_time; ?></td>
              <td style="text-transform: uppercase;"><?php echo $pnr; ?></td>
              <td><?php echo $flight_no; ?></td>
              <td><?php echo $row_passenger['ticket_no'] ?></td>
            <?php 
              
              ?>         
              <td><?php echo $sq_fields['basic_cost'] ?></td>   
              <td><?php echo $yq_tax ?></td>
              <td><?php echo $other_tax ?></td>
              </tr>
          <?php $count++; } ?>
          </tbody>
        </table>
       </div>
     </div>
    </div>
  </div>

<?php $net_amount1 =  $basic_cost1 + $sq_fields['service_charge'] + $sq_fields['markup'] + $other_tax + $yq_tax + $markupservice_tax_amount + $service_tax_amount - $sq_fields['basic_cost_discount'] + $sq_fields['tds'] + $sq_fields['roundoff'];  ?>

 <!-- invoice_receipt_body_calculation -->
<section class="print_sec main_block">
  <div class="row">
    <div class="col-md-12">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?php echo $currency_code." ".number_format($newBasic,2); ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?php echo $currency_code." ".number_format($net_amount1,2); ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">OTHER TAX + YQ</span><span class="float_r"><?php echo $currency_code.' '.($sq_fields['other_taxes'] + $sq_fields['yq_tax']); ?></span></p></div>   
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGE </span><span class="float_r"><?= $currency_code." ".number_format($charge,2)?></span></p></div>  
        <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?php echo $currency_code." ".number_format($newSC,2); ?></span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCED PAID </span><span class="font_5 float_r"><?php echo $currency_code." ".number_format($total_paid,2); ?></span></p></div>  
        <div class="col-md-6"><p class="border_lt"><span class="font_5">DISCOUNT</span><span class="float_r"><?= $currency_code.' '.$sq_fields['basic_cost_discount'] ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?php echo $currency_code." ".number_format($balance_amount-$charge,2); ?></span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TDS</span><span class="float_r"><?= $currency_code.' '.$sq_fields['tds'] ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">&nbsp;</span><span class="float_r">&nbsp;</span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX</span><span class="float_r"><?= $currency_code.' '.$tax_show ?></span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">&nbsp;</span><span class="float_r">&nbsp;</span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ROUND OFF </span><span class="float_r"><?php echo $sq_fields['roundoff']; ?></span></p></div> 
      </div>
    </div>
  </div>
</section>

<?php 
//Footer
include "../generic_footer_html.php"; ?>