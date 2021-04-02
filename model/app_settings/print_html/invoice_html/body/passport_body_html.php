<?php  
//Generic Files
include "../../../../model.php"; 
include "../../print_functions.php";
require("../../../../../classes/convert_amount_to_word.php"); 

//Parameters
$invoice_no = $_GET['invoice_no'];
$passport_id = $_GET['passport_id'];
$invoice_date = $_GET['invoice_date'];
$customer_id = $_GET['customer_id'];
$service_name = $_GET['service_name'];
$basic_cost1 = $_GET['basic_cost'];
$service_charge = $_GET['service_charge'];
$taxation_type = $_GET['taxation_type'];
$service_tax_per = $_GET['service_tax_per'];
$service_tax_subtotal = $_GET['service_tax'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$roundoff = $_GET['roundoff'];
$sac_code = $_GET['sac_code'];
$credit_card_charges = $_GET['credit_card_charges'];

$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;
$total_paid += $charge;
$bsmValues = mysql_fetch_assoc(mysql_query("select bsm_values from passport_master where passport_id = '$passport_id'"));
$bsmValues = json_decode($bsmValues['bsm_values']);
$tax_show = '';
$newBasic = 0;
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($service_tax_subtotal !== 0.00 && ($service_tax_subtotal) !== ''){
  $service_tax_subtotal1 = explode(',',$service_tax_subtotal);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;
}
else{ //exclusive
  $tax_show = $service_tax_subtotal;
  $newSC = $service_charge;
  $newBasic = $basic_cost1;
}

////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $basic_cost1 + $service_tax_amount;
  $tax_show = '';
}

$basic_cost = number_format($newBasic,2);
$net_amount1 = 0;
$net_amount1 =  $basic_cost1 + $service_charge  + $service_tax_amount + $roundoff;
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount1);

//Header
if($app_invoice_format == "Standard"){include "../headers/standard_header_html.php"; }
if($app_invoice_format == "Regular"){include "../headers/regular_header_html.php"; }
if($app_invoice_format == "Advance"){include "../headers/advance_header_html.php"; }
?>

<hr class="no-marg">

<div class="col-md-12 mg_tp_20"><p class="border_lt"><span class="font_5">PASSENGER :  </span><span><?= $sq_hotel['p_name'] ?></span></p></div>
<div class="main_block inv_rece_table main_block">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table table-bordered no-marg" id="tbl_emp_list" style="padding: 0 !important;">
          <thead>
            <tr class="table-heading-row">
              <th>SR.NO</th>
              <th>PASSENGER</th>              
              <th>Received_Documents</th>
            </tr>
          </thead>
          <tbody>   
          <?php 
          $count = 1;
          $sq_passenger = mysql_query("select * from passport_master_entries where passport_id = '$passport_id'");
          while($row_passenger = mysql_fetch_assoc($sq_passenger))
          {
            ?>
            <tr class="odd">
              <td><?php echo $count; ?></td>
              <td><?php echo $row_passenger['first_name'].' '.$row_passenger['last_name']; ?></td>
              <td><?php echo $row_passenger['received_documents']; ?></td>
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
        <div class="col-md-6"><p class="border_lt"><span class="font_5">AMOUNT </span><span class="float_r"><?= $currency_code." ".number_format($newBasic,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TOTAL </span><span class="font_5 float_r"><?= $currency_code." ".number_format($net_amount1,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">SERVICE CHARGE </span><span class="float_r"><?= $currency_code." ".number_format($newSC,2) ?></span></p></div> 
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CREDIT CARD CHARGE </span><span class="float_r"><?= $currency_code." ".number_format($charge,2)?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">TAX</span><span class="float_r"><?= $currency_code." ".$tax_show ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">ADVANCED PAID </span><span class="font_5 float_r"><?= $currency_code." ".number_format($total_paid,2) ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">Round Off</span><span class="float_r"><?= $currency_code." ".$roundoff ?></span></p></div>
        <div class="col-md-6"><p class="border_lt"><span class="font_5">CURRENT DUE </span><span class="font_5 float_r"><?= $currency_code." ".number_format(($net_amount1 + $charge) - $total_paid,2) ?></span></p></div>
      </div>
    </div>
  </div>

</section>
<?php 
//Footer
include "../generic_footer_html.php"; ?>