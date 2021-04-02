
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
$taxation_type = $_GET['taxation_type'];
$bank_name = $_GET['bank_name'];
$train_expense = $_GET['train_expense'];
$plane_expense = $_GET['plane_expense'];
$cruise_expense = $_GET['cruise_expense'];
$visa_amount = $_GET['visa_amount'];
$insuarance_amount = $_GET['insuarance_amount'];
$tour_subtotal = $_GET['tour_subtotal'];
$tour_date = $_GET['tour_date'];
$train_service_charge = $_GET['train_service_charge'];
$plane_service_charge = $_GET['plane_service_charge'];
$cruise_service_charge = $_GET['cruise_service_charge'];
$visa_service_charge = $_GET['visa_service_charge'];
$insuarance_service_charge = $_GET['insuarance_service_charge'];
$destination_city = $_GET['destination_city'];
$train_service_tax = $_GET['train_service_tax'];
$plane_service_tax = $_GET['plane_service_tax'];
$cruise_service_tax = $_GET['cruise_service_tax'];
$visa_service_tax = $_GET['visa_service_tax'];
$insuarance_service_tax = $_GET['insuarance_service_tax'];
$tour_service_tax = $_GET['tour_service_tax'];
$state = $_GET['state'];
$train_service_tax_subtotal = $_GET['train_service_tax_subtotal'];
$plane_service_tax_subtotal = $_GET['plane_service_tax_subtotal'];
$cruise_service_tax_subtotal = $_GET['cruise_service_tax_subtotal'];
$visa_service_tax_subtotal = $_GET['visa_service_tax_subtotal'];
$insuarance_service_tax_subtotal = $_GET['insuarance_service_tax_subtotal'];
$tour_service_tax_subtotal = $_GET['tour_service_tax_subtotal'];
$sac_code = $_GET['sac_code'];

$net_amount = $_GET['net_amount'];
($_GET['total_paid']=="")?$total_paid = 0:$total_paid = $_GET['total_paid'];
$total_balance = $net_amount - $total_paid;
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
        <ul class="no-pad no-marg font_s_12"> 
          <li style="list-style-type:none;"><h3 class=" font_5 font_s_16 no-marg no-pad caps_text"><?php echo $app_name; ?></h3></li> 
          <li style="list-style-type:none;"><p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p></li>  
          <li style="list-style-type:none;"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ?   
           $branch_details['contact_no'] : $app_contact_no ?></li>  
          <li style="list-style-type:none;"><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></li> 
          <li style="list-style-type:none;"><span class="font_5">TAX NO : </span><?php echo $service_tax_no; ?></li>  
        </ul> 
      </div>  
    </div>  
  </div>  
</div>   
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
      <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">
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
            <td class="text-center">Less : Dis.</td>
            <td class="text-center">Taxable Value</td>
            <td colspan="2" class="text-center">CGST <?php if($taxation_type=="SGST CGST"){ ?>(<?= $service_tax_per/2 ?>%)<?php }?></td>
            <td colspan="2" class="text-center">SGST <?php if($taxation_type=="SGST CGST"){ ?>(<?= $service_tax_per/2 ?>%)<?php }?></td>
            <td colspan="2" class="text-center">IGST<?php if($taxation_type=="IGST"){ ?>(<?= $service_tax_per ?>%)<?php }?></td>  
            <td colspan="2" class="text-center">UGST<?php if($taxation_type=="UGST"){ ?>(<?= $service_tax_per ?>%)<?php }?></td>
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
            <td class="text-center">Rate</td>
            <td class="text-center">Amt</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amt</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amt</td>
            <td class="text-center">Rate</td> 
            <td class="text-center">Amt</td>
            <td class="text-center"></td>
          </tr>
          <tr>
           <?php  
           $count = 1;
          if($train_expense != '0'){ 
            $total_train = $train_expense+$train_service_charge+$train_service_tax_subtotal;
            $train_cgst_sgst= $train_service_tax_subtotal/2;
            ?>  
            <tr>
              <td><?= $count++ ?></td>
              <td><strong class="font_5">Train</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $train_expense ?></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $train_service_charge ?></td>
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $train_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $train_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $train_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $train_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $train_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $train_service_tax_subtotal; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $train_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $train_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($total_train,2); ?></td>
            </tr>
            <?php } 

            if($plane_expense != '0'){
              $total_plane = $plane_expense+$plane_service_charge+$plane_service_tax_subtotal;
              $plan_cgst_sgst= $plane_service_tax_subtotal/2;
              ?>
            <tr>
              <td><?= ++$count ?></td>
              <td><strong class="font_5">Plane</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $plane_expense ?></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $plane_service_charge ?></td>
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $plane_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $plane_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $plane_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $plane_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $plane_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $plane_service_tax_subtotal; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $plane_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $plane_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($total_plane,2); ?></td>
            </tr>
            <?php } 
            if($cruise_expense != '0'){
              $cruise_total_cruise = $cruise_expense+$cruise_service_charge+$cruise_service_tax_subtotal;
              $cruise_cgst_sgst= $cruise_service_tax_subtotal/2;
               ?>
              <td><?= $count++ ?></td>
              <td><strong class="font_5">Cruise</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $cruise_expense ?></td>
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $cruise_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $cruise_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $cruise_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $cruise_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $cruise_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $cruise_service_tax_subtotal; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $cruise_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $cruise_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($cruise_total_cruise,2); ?></td>
            </tr>
            <?php } 
            if($visa_amount != '0'){
            $total_visa = $visa_amount+$visa_service_charge+$visa_service_tax_subtotal; 
            $visa_cgst_sgst= $visa_service_tax_subtotal/2;
            ?> 
            <tr>
              <td><?= $count++ ?></td>
              <td><strong class="font_5">Visa</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $visa_amount ?></td> 
              <td class="text-right"></td>  
              <td class="text-right"><?= $visa_service_charge ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $visa_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $visa_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $visa_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $visa_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $visa_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $visa_service_tax_subtotal; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $visa_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $visa_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($total_visa,2); ?></td>
            </tr>
            <?php }  
             if($insuarance_amount != '0'){
            $total_ins = $insuarance_amount+$insuarance_service_charge+$insuarance_service_tax_subtotal; 
            $insurance_cgst_sgst= $insuarance_service_tax_subtotal/2;
            ?>  
            <tr>
              <td><?= $count++ ?></td>
              <td><strong class="font_5">Insurance</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $insuarance_amount ?></td> 
              <td class="text-right"></td>  
              <td class="text-right"><?= $insuarance_service_charge ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $insuarance_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $insurance_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $insuarance_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $insurance_cgst_sgst; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $insuarance_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $insuarance_service_tax_subtotal; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $insuarance_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $insuarance_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($total_ins,2); ?></td>
            </tr>
            <?php } 
            if($tour_subtotal != '0'){
            $total_tour = $tour_subtotal+$tour_service_tax_subtotal; 
            $tour_cgst_sgst= $tour_service_tax_subtotal/2;
            
            ?>  
            <tr>
              <td><?= $count++ ?></td>
              <td><strong class="font_5">Tour</strong></td>
              <td class="text-right"><?php echo $sac_code; ?></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $tour_subtotal ?></td>
              <td class="text-right"></td>
              <td class="text-right"><?= $tour_subtotal ?></td> 
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $tour_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $tour_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $tour_service_tax; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="SGST CGST"){echo $tour_cgst_sgst; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $tour_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="IGST"){echo $tour_service_tax_subtotal; } ?></td>  
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $tour_service_tax; } ?></td> 
              <td class="text-right"><?php if($taxation_type=="UGST"){echo $tour_service_tax_subtotal; } ?></td>
              <td class="text-right"><?php echo number_format($total_tour,2); ?></td>
            </tr>
           <?php } ?>

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
            <td class="text-center"><?php echo number_format($net_amount,2); ?></td>
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
            $total_amount_before_tax = $plane_expense+$insuarance_amount+$visa_amount+$cruise_expense+$plane_expense+$train_expense;
            // $total_cgst_sgst=$train_cgst_sgst+$plan_cgst_sgst+$cruise_cgst_sgst+$visa_cgst_sgst+$insurance_cgst_sgst+$tour_cgst_sgst;
            $total_service_tax_subtotal = $train_service_tax_subtotal+$plane_service_tax_subtotal+$cruise_service_tax_subtotal+$visa_service_tax_subtotal+$insuarance_service_tax_subtotal+$tour_service_tax_subtotal;
          //$cgst_plus_sgst= $total_service_tax_subtotal/2;
          $total_amt_before_tax=$train_expense+$train_service_charge+$plane_expense+ $plane_service_charge+$cruise_expense+$cruise_service_charge+$visa_amount+$visa_service_tax+$insuarance_amount+$insuarance_service_charge+$tour_subtotal;

        ?>
       <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
            <table class="table no-marg mg_tp_5 gst_invoice" style="padding: 0 !important;">  
              <tr>  
                <td class="text-right col-md-8">Total Amount Before Tax :</td>  
                <td class="text-right col-md-4"><?= $currency_logo." ".$total_amt_before_tax ?></td> 
              </tr> 
              <tr>  
                <td class="text-right col-md-8">Add : CGST <?php if($taxation_type=="SGST CGST"){ ?>@<?= $tour_service_tax/2 ?>%<?php } ?> :</td> 
                <td class="text-right col-md-4"><?php if($taxation_type=="SGST CGST"){ echo $currency_logo." ".$tour_cgst_sgst; } ?></td>  
              </tr> 
              <tr>  
                <td class="text-right col-md-8">Add : SGST <?php if($taxation_type=="SGST CGST"){ ?>@<?= $tour_service_tax/2 ?>%<?php } ?> :</td> 
                <td class="text-right col-md-4"><?php if($taxation_type=="SGST CGST"){ echo $currency_logo." ".$tour_cgst_sgst; } ?></td>  
              </tr> 
              <tr>  
                <td class="text-right col-md-8">Add : IGST <?php if($taxation_type=="IGST"){ ?>@<?= $tour_service_tax ?>%<?php } ?> :</td>  
                <td class="text-right col-md-4"><?php if($taxation_type=='IGST'){ echo $currency_logo." ".$total_service_tax_subtotal; } ?></td> 
              </tr> 
              <tr>  
                <td class="text-right col-md-8">Add : UGST <?php if($taxation_type=="UGST"){ ?>@<?= $tour_service_tax ?>%<?php } ?> :</td>  
                <td class="text-right col-md-4"><?php if($taxation_type=='UGST'){ echo $currency_logo." ".$total_service_tax_subtotal; } ?></td> 
              </tr> 
              <tr>  
                <td class="text-right col-md-8">Tax Amount : GST @<?= $tour_service_tax ?>% :</td>  
                <td class="text-right col-md-4"><?php echo $currency_logo." ".$total_service_tax_subtotal ?></td>  
              </tr> 
              <tr class="hightlited_row"> 
                <td class="text-right col-md-8">Total Amount After Tax :</td> 
                <td class="text-right col-md-4"><?php echo $currency_logo." ".number_format($net_amount,2); ?></td>  
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
          <h3 class="no-marg" style="font-size:12px;">For <?= $app_name ?></h3>
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