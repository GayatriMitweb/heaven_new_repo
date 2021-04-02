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
$service_charge = $_GET['service_charge'];
$markup = $_GET['markup'];
$markup_tax = $_GET['markup_tax'];
$roundoff = $_GET['roundoff'];
$tds = $_GET['tds'];
$discount = $_GET['discount'];
$net_amount = $_GET['net_amount'];
$bank_name = $_GET['bank_name'];
$total_paid = $_GET['total_paid'];
$balance_amount = $_GET['balance_amount'];
$sac_code = $_GET['sac_code'];
$service_tax_subtotal = $_GET['service_tax'];
$pass_count=$_GET['pass_count'];
$tour_date=$_GET['tour_date'];
$destination_city = $_GET['destination_city'];
$cgst_sgst= ($service_tax_subtotal)/2;
$amount_in_word = $amount_to_word->convert_number_to_words($net_amount);

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_customer[state_id]'"));
$sq_app = mysql_fetch_assoc(mysql_query("select state_id from app_Settings where setting_id='1'"));
$sq_sup_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_app[state_id]'"));
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_details = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_admin_id'"));

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Invoice' and active_flag ='Active'")); 
$emp_id = $_SESSION['emp_id'];
$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }

$bsmValues = json_decode($_GET['bsmValues']);
$tax_show = '';
$tax_values = 0;
$newBasic = 0;
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($service_tax_subtotal !== 0.00 && ($service_tax_subtotal) !== ''){
  $service_tax_subtotal1 = explode(',',$service_tax_subtotal);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $perc_service += str_replace(array('(',')','%'),'',$service_tax[1]);
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;
}
else{ //exclusive
  $tax_values = $service_tax_amount;
  $tax_show = $service_tax_subtotal;
  $newSC = $service_charge;
  $newBasic = $basic_cost1;
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($markup_tax !== 0.00 && $markup_tax !== ""){
  $service_tax_markup1 = explode(',',$markup_tax);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
if(isset($bsmValues[0]->markup)){
  if($bsmValues[0]->markup != ''){ //inclusive markup
    $newBasic = $basic_cost1 + $markup + $markupservice_tax_amount;
  }
  else{
    $newBasic = $basic_cost1;
    $newSC = $service_charge + $markup;
    $tax_values = $markupservice_tax_amount + $service_tax_amount;
    $tax_show = $service_tax_subtotal;
  }
}

////////////Basic Amount Rules
if(isset($bsmValues[0]->basic)){
  if($bsmValues[0]->basic != ''){ //inclusive basic
    $newBasic = $basic_cost1 + $service_tax_amount;
    $tax_show = '';
  }
}

$basic_cost = $newBasic;
$net_amount1 = 0;
$net_amount1 = $_GET['net_amount1'] + $markupservice_tax_amount + $service_tax_amount;
?>
<section class="print_sec_tp_s main_block ">
<!-- invloice_receipt_hedaer_top-->
<div class="main_block inv_rece_header_top header_seprator_4 mg_bt_10">
  <div class="row">
    <div class="col-md-8 pd_tp_5">
      <div class="inv_rece_header_left">
        <div class="inv_rece_header_logo">
          <img src="<?php echo $admin_logo_url ?>" class="img-responsive">
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="inv_rece_header_right text-right">
        <ul class="no-pad no-marg font_s_12 noType">
          <li><h3 class=" font_5 font_s_16 no-marg no-pad caps_text"><?php echo $app_name; ?></h3></li>
          <li><p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p></li>
          <li><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? 
           $branch_details['contact_no'] : $app_contact_no ?></li>
          <li><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></li>
          <li><span class="font_5">TAX NO : </span><?php echo $service_tax_no; ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<hr class="no-marg">
</section>
<section class="no-pad main_block gst_invoice side_pad_10">  
  <!-- invoice_receipt_detail_table-->
  <div class="main_block inv_rece_table">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
          <tr>
            <td rowspan="3" class="text-center col-md-7"><h1 class="no-marg" style="font-size: 26px;">Tax Invoice</h1></td>
            <td class="col-md-1"> </td>
            <td class="col-md-4">Original For Receipient</td>
          </tr>
          <tr>
            <td class="col-md-1"></td>
            <td class="col-md-4">Duplicate for supplier/Transport</td>
          </tr>
          <tr>
            <td class="col-md-1"></td>
            <td class="col-md-4">Triplicate for Supplier</td>
          </tr>
        </table>
       </div>
     </div>
    </div>
  </div>



  
  <!-- invoice_receipt_detail_table-->
  <div class="main_block inv_rece_table">
    <div class="col-md-6 no-pad" style="padding-right: 0">
     <div class="table-responsive">
      <table class="table no-marg mg_tp_10 gst_invoice" style="padding: 0 !important;">
        <tr>
          <td class="text-right col-md-4">Reverse Charge :</td>
          <td class="col-md-8"></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">Invoice No. :</td>
          <td class="col-md-8"><?= $invoice_no ?></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">Invoice Date :</td>
          <td class="col-md-8"><?=$invoice_date ?></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">GSTIN :</td>
          <td class="col-md-8"><?= $service_tax_no; ?></td>
        </tr>
      </table>
     </div>
   </div>

   <div class="col-md-6 no-pad" style="padding-right: 0">
     <div class="table-responsive">
      <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
        <tr>
          <td class="text-right col-md-4">Transportation :</td>
          <td class="col-md-8"></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">Vehical No. :</td>
          <td class="col-md-8"></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">Date of Travelling :</td>
          <td class="col-md-8"><?= $tour_date ?></td>
        </tr>
        <tr>
          <td class="text-right col-md-4">Destination :</td>
          <td class="col-md-8"><?= $destination_city ?></td>
        </tr>
      </table>
     </div>
   </div>
  </div>
  <!-- invoice_receipt_detail_table-->
  <div class="main_block inv_rece_table">
    <div class="row">
      <div class="col-md-6" style="padding-right: 0">
       <div class="table-responsive">
        <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
          <tr>
            <td class="text-right col-md-3">State :</td>
            <td class="col-md-3"><?= $sq_sup_state['state_name'] ?></td>
            <td class="text-right col-md-3"></td>
            <td class="col-md-3"></td>
          </tr>
        </table>
       </div>
     </div>
    </div>
  </div>
  <!-- invoice_receipt_body_table-->
  <div class="main_block inv_rece_table">
      <div class="col-md-6 no-pad">
       <div class="table-responsive">
        <table class="table table-bordered no-marg mg_tp_5 gst_invoice" id="tbl_emp_list" style="padding: 0 !important;">
            <tr class="hightlited_row">
              <td colspan="4" class="text-center"><h5 class="no-marg" style="font-size:10px;">Details of Receiver / Billed to :</h5></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Name :</td>
              <td colspan="3"><?php echo $sq_customer['first_name'].''.$sq_customer['last_name']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Address :</td>
              <td colspan="3"><?php echo $sq_customer['address'].','.$sq_customer['address2'].','. $sq_customer['city']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">GSTIN :</td>
              <td colspan="3"><?php echo $sq_customer['service_tax_no']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">State :</td>
              <td><?= $sq_state['state_name'] ?></td>
              <td class="text-right"></td>
              <td></td>
            </tr>
        </table>
       </div>
     </div>
      <div class="col-md-6 no-pad">
       <div class="table-responsive">
        <table class="table table-bordered no-marg mg_tp_5 gst_invoice" id="tbl_emp_list" style="padding: 0 !important;">
            <tr class="hightlited_row">
              <td colspan="4" class="text-center"><h5 class="no-marg" style="font-size:10px;">Details of Consignee / Shipped to :</h5></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Name :</td>
              <td colspan="3"><?php echo $sq_customer['first_name'].''.$sq_customer['last_name']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Address :</td>
              <td colspan="3"><?php echo $sq_customer['address'].','.$sq_customer['address2'].','. $sq_customer['city']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">GSTIN :</td>
              <td colspan="3"><?php echo $sq_customer['service_tax_no']; ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">State :</td>
              <td><?= $sq_state['state_name'] ?></td>
              <td class="text-right"></td>
              <td></td>
            </tr>
        </table>
       </div>
     </div>
  </div>
  <!-- invoice_receipt_detail_table-->
  <div class="main_block inv_rece_table">
    <div class="row">
      <div class="col-md-12">
       <div class="table-responsive">
        <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
          <tr class="hightlited_row">
            <td class="text-center">S.No</td>
            <td class="text-center">Name Of Service</td>
            <td class="text-center">HSN / SAC</td>
            <td class="text-center">Qty</td>
            <td class="text-center">Rate / Per Pax</td>
            <td class="text-center">Amount</td>
            <td class="text-center">SC</td>
            <td class="text-center">Less : Dis.</td>
            <td class="text-center">TDS</td>
            <!-- <td class="text-center">Taxable Value</td> -->
            <td colspan="6" class="text-center">GST</td>
            <td class="text-center">Total</td>
          </tr>
          <tr>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <!-- <td class="text-center"></td> -->
            <td class="text-center">Name</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amt</td>
            <td class="text-center">Name</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amt</td>
            <td class="text-center"></td>
          </tr>
          <tr>
           <?php 
           $taxes = explode(',',$tax_show);
           $final_ar = array();
           foreach($taxes as $values){
            array_push($final_ar, explode(':',$values));
           }
         ?>  
            <tr>
              <td><?= '1'?></td>
              <td><strong class="font_5"></strong><?= $service_name ?></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"><?= $pass_count ?></td>
              <td class="text-right"></td>
              <td class="text-right"><?= number_format($basic_cost,2) ?></td>
              <td class="text-right"><?= number_format($newSC,2) ?></td>
              <td class="text-right"><?= number_format($discount,2) ?></td>
              <td class="text-right"><?= number_format($tds,2) ?></td>
              <td class="text-right"><?php echo $final_ar[0][0] ?></td>
              <td class="text-right"><?php echo number_format(str_replace(array('(',')','%'),'',$final_ar[0][1]),2) ?></td>
              <td class="text-right"><?php echo $newSC * $final_ar[0][2] ?></td>
              <td class="text-right"><?php echo $final_ar[1][0] ?></td>
              <td class="text-right"><?php echo number_format(str_replace(array('(',')','%'),'',$final_ar[1][1]),2) ?></td>
              <td class="text-right"><?php echo $final_ar[1][2] ?></td>
              <td class="text-right"><?php echo number_format($net_amount1 + $roundoff,2); ?></td>
            </tr>
            <?php 

            ?>
          </tr>
          <tfoot>
            <tr class="hightlited_row">
              <td colspan="3" class="text-center">Total</td>
              <td class="text-center"></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-center"></td>
              <td class="text-right"></td>
              <td class="text-center"></td>
              <td class="text-right"></td>
              <td class="text-center"></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
            <td class="text-center"><?php echo number_format($net_amount1 + $roundoff,2); ?></td>
            </tr>
          </tfoot>
        </table>
       </div>
     </div>
    </div>
  </div>

  <!-- invoice_receipt_detail_table-->
  <div class="main_block inv_rece_table">
    <div class="row">
      <div class="col-md-8">

       <div class="table-responsive">
        <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
          <tr>
            <td class="text-right col-md-4">Total Invoice Amount in Words :</td>
            <td class="col-md-8"><?php echo $amount_in_word; ?></td>
          </tr>
        </table>
       </div>

       <div class="col-md-9 no-pad mg_tp_10">
         <div class="table-responsive">
          <table class="table no-marg gst_invoice" style="padding: 0 !important;">
            <tr>
              <td class="text-right col-md-4">Bank Details :</td>
              <td class="col-md-8"><?=  ($branch_status=='yes' && $role!='Admin') ? $branch_details['bank_name'] : $bank_name_setting ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Bank A/C No. :</td>
              <td class="col-md-8"><?=  ($branch_status=='yes' && $role!='Admin') ? $branch_details['bank_acc_no'] : $bank_acc_no ?></td>
            </tr>
            <tr>
              <td class="text-right col-md-4">Branch IFSC Code :</td>
              <td class="col-md-8"><?= ($branch_status=='yes' && $role!='Admin') ? $branch_details['ifsc_code'] : $bank_ifsc_code ?></td>
            </tr>
          </table>
         </div>
       </div>

      <div class="col-md-9 no-pad mg_tp_10">
        <h5 class="no-marg" style="font-size:10px;">Terms And Condition :</h5>
        <p class="less_opact" style="font-size:8px;"><?= $sq_terms_cond['terms_and_conditions'] ?></p>
      </div>

     </div>

      <div class="col-md-4">
      <?php
         $total_amount_before_tax = $basic_cost+$newSC-$discount+$tds;          
      ?>
       <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
            <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
              <tr>
                <td class="text-right col-md-8">Total Amount Before Tax :</td>
                <td class="text-right col-md-4"><?= $currency_logo." ".number_format($total_amount_before_tax,2) ?></td>
              </tr>
              <?php
                // foreach($final_ar as $values){
                //   if($values[0] != ''){
              ?>
              <!-- <tr>
                <td class="text-right col-md-8">Add : <?= $values[0] ?> @<?= str_replace(array('(',')','%'),'',$values[1]) ?>% :</td>
                <td class="text-right col-md-4"><?php echo $currency_logo." ".$values[2]; ?></td>
              </tr> -->
              <?php //}
                  //} 
              ?>
              <tr>
                <td class="text-right col-md-8">Tax Amount : GST :</td>  
                <td class="text-right col-md-4"><?= $currency_logo." ".number_format($tax_values,2) ?></td>
              </tr>
              <tr class="hightlited_row">
                <td class="text-right col-md-8">Round Off :</td>
                <td class="text-right col-md-4"><?= $currency_logo." ".number_format($roundoff,2) ?></td>
              </tr>
              <tr class="hightlited_row">
                <td class="text-right col-md-8">Total Amount After Tax :</td>
                <td class="text-right col-md-4"><?= $currency_logo." ".number_format($net_amount1 + $roundoff,2) ?></td>
              </tr>
            </table>
           </div>
         </div>
       </div>

       <div class="row mg_tp_10">
         <div class="col-md-12">
           <div class="table-responsive">
            <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
              <tr>
                <td class="text-right col-md-8">GST Payable onReverse Charge :</td>
                <td class="text-right col-md-4"></td>
              </tr>
            </table>
           </div>
         </div>
         <div class="col-md-12 text-center">
           <small style="font-size: 6px;">Certified that the particulars given above are true & Correct</small>
         </div>
       </div>

      <div class="row mg_tp_10">

        <div class="col-md-3"></div>

        <div class="col-md-9">
          <h3 class="no-marg" style="font-size:12px;">For <?= $app_name?></h3>
          <div class="signature_block"></div>
          <h5 class="no-marg" style="font-size:10px;">Authorised Signatory</h5>
          <small style="font-size: 7px;">[E&OE] Sunbject to Pune Jurisdiction Only.</small>
        </div>

      </div>

     </div>

    </div>
  </div>

</section>

</body>
</html>