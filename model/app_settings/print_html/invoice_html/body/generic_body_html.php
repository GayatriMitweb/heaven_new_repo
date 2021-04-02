<?php  
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 

//Parameters
$invoice_no = $_GET['invoice_no'];
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



$basic_cost = number_format($basic_cost1,2);
$net_amount1 = 0;
$net_amount1 =  $basic_cost1 + $service_charge  + $service_tax;
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount1);

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">

<section class="print_sec main_block">

<!-- invoice_receipt_body_calculation -->
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6">
      <div class="main_block inv_rece_calculation border_block">
        <div class="col-md-12"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $currency_logo." ".$basic_cost ?></span></p></div>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?= $currency_logo." ".$service_charge ?></span></p></div>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">TAX<?= '('.$service_tax_per.'%)' ?>[<?= $taxation_type ?>] </span><span class="float_r"><?= $currency_logo." ".number_format($service_tax,2) ?></span></p></div>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $currency_logo." ".number_format($net_amount1,2) ?></span></p></div>
        <div class="col-md-12"><p class="border_lt"><span class="font_5">ADVANCED PAID </span><span class="float_r"><?= $currency_logo." ".number_format($total_paid,2) ?></span></p></div>
        <div class="col-md-12"><p class="border_lt no-marg"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $currency_logo." ".number_format($balance_amount,2) ?></span></p></div>
      </div>
    </div>
  </div>

</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>