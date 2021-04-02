<?php
include "../../../../model/model.php";
$estimate_id = $_POST['estimate_id'];

$sq_vendor_esti_info = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));

$purchase = $sq_vendor_esti_info['net_total'];
$estimate_type=$sq_vendor_esti_info['estimate_type'];
$estimate_type_id=$sq_vendor_esti_info['estimate_type_id'];
$vendor=$sq_vendor_esti_info['vendor_type'];
$vendor_id=$sq_vendor_esti_info['vendor_type_id'];

$sq_payment_info1 = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sumpay from vendor_payment_master where vendor_type='$vendor' and vendor_type_id='$vendor_id' and estimate_type='$estimate_type' and estimate_type_id='$estimate_type_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_refunded_info1 = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sumpay from vendor_refund_master where estimate_id='$estimate_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));


$refund_amount =$sq_payment_info1['sumpay']-$purchase;

$total_refund =$refund_amount - $sq_refunded_info1['sumpay'];

$refund_amount =$sq_payment_info1['sumpay']-$purchase;

$remaining=$sq_vendor_esti_info['total_refund_amount']-$sq_refunded_info1['sumpay'];
?>

<input type="hidden" name="estimate_type_id" id="estimate_type_id" value="<?= $estimate_type_id ?>">
<input type="hidden" name="vendor_type" id="vendor_type" value="<?= $vendor ?>">
<input type="hidden" name="vendor_type_id" id="vendor_type_id" value="<?= $vendor_id ?>">
<input type="hidden" name="remaining_amount" id="remaining_amount" value="<?= $remaining ?>">

<div class="col-md-12 mg_tp_10">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="widget_parent-bg-img bg-img-green">
             <div class="widget_parent">
                <div class="stat_content main_block">
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Purchase Amount </span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($purchase=="") ? number_format(0,2) : number_format($purchase,2) ?></span>
                    </span> 
                   <span class="main_block content_span" data-original-title="" title="">                    
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_payment_info1['sumpay']=="") ? number_format(0,2)  : number_format($sq_payment_info1['sumpay'],2) ?></span>
                    </span> 
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_vendor_esti_info['cancel_amount']=="") ? number_format(0,2)  : number_format($sq_vendor_esti_info['cancel_amount'],2) ?></span>
                    </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sq_vendor_esti_info['total_refund_amount']=="") ? number_format(0,2)  : number_format($sq_vendor_esti_info['total_refund_amount'],2) ?></span>
                    </span>
                </div> 
            </div>
         </div>

    </div>    
    </div>
  </div>

  