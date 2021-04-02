<?php  
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 

//Parameters
$invoice_no = $_GET['invoice_no'];
$invoice_date = $_GET['invoice_date'];
$booking_id = $_GET['booking_id'];
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

$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;
$total_paid += $charge;

$basic_cost = number_format($basic_cost1,2);
$row_misc = mysql_fetch_assoc(mysql_query("select * from  miscellaneous_master where misc_id='$booking_id'"));

$roundoff = $row_misc['roundoff'];
$bsmValues = json_decode($row_misc['bsm_values']);

$tax_show = '';
$newBasic = $basic_cost1;
$name = ''; 
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($row_misc['service_tax_subtotal'] !== 0.00 && ($row_misc['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$row_misc['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;

}
else{
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newSC = $service_charge;
  
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($row_misc['service_tax_markup'] !== 0.00 && $row_misc['service_tax_markup'] !== ""){
  $service_tax_markup1 = explode(',',$row_misc['service_tax_markup']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];

  }
}

if($bsmValues[0]->markup != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $row_misc['markup'] + $markupservice_tax_amount;

}
else{
  $newBasic = $basic_cost1;
  $newSC = $service_charge + $row_misc['markup'];
  $tax_show = rtrim($name, ', ') .' : ' . ($markupservice_tax_amount + $service_tax_amount);
}
////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
 $newBasic = $basic_cost1 + $service_tax_amount + $row_misc['markup'] + $markupservice_tax_amount;
}

$net_amount1 = 0;
$net_amount1 =  ($basic_cost1 + $service_charge  + $row_misc['markup'] + $markupservice_tax_amount + $service_tax_amount) + $roundoff;
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount1);

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>
<?php

?>
<hr class="no-marg">
<div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">SERVICES : </span>
<?php echo $row_misc['service'];?></p></div>
<div class="col-md-12 mg_tp_10"><p class="border_lt"><span class="font_5">NARRATION : </span><?= $row_misc['narration']?></p></div>
<div class="col-md-12 mg_tp_10"><p class="border_lt"><span class="font_5">PASSENGER :  </span><span><?= $sq_hotel['p_name'] ?></span></p></div>
<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>Name</th>
              <th>Birthdate</th>
              <th>Passport No</th>
              <th>Issue Date</th>
              <th>Expiry Date</th>
            </tr>
          </thead>
          <tbody>   
          <?php 
          $count = 1;
          $sq_passenger = mysql_query("select * from miscellaneous_master_entries where misc_id = '$booking_id'");
          while($row_passenger = mysql_fetch_assoc($sq_passenger))
          {
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?php echo $row_passenger['first_name'].' '.$row_passenger['last_name']; ?></td>
              <td><?php echo get_date_user($row_passenger['birth_date']); ?></td>
              <td><?php echo ($row_passenger['passport_id']); ?></td>
              <td><?php echo get_date_user($row_passenger['issue_date']); ?></td>
              <td><?php echo get_date_user($row_passenger['expiry_date']); ?></td>
            </tr>
            <?php   
               $count++;
             } ?>
          </tbody>
        </table>
       </div>
     </div>
    </div>
  </div>
<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->
  <div class="row">
    <div class="col-md-12">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $currency_code." ".$newBasic ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $currency_code." ".number_format($net_amount1,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?= $currency_code." ".$newSC ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGE </span><span class="float_r"><?= $currency_code." ".number_format($charge,2)?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX </span><span class="float_r"><?= $currency_code." ".$tax_show ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCED PAID </span><span class="font_5 float_r"><?= $currency_code." ".number_format($total_paid,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ROUND OFF </span><span class="font_5 float_r"><?= $currency_code." ".number_format($row_misc['roundoff'],2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $currency_code." ".number_format($balance_amount,2) ?></span></p></div>
        
      </div>
    </div>
  </div>
</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>