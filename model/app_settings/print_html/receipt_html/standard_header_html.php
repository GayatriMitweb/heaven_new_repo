<?php
$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_customer[state_id]'"));

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Receipt' and active_flag ='Active'")); 
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
if($branch_admin_id != 0){
  $branch_details = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_admin_id'"));
}
else{
  $branch_details = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='1'"));
}
$emp_id = $_SESSION['emp_id'];
$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0' || $emp_id == ''){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }
?>
<div class="repeat_section main_block">
<section class="print_sec_tp_s main_block ">
<!-- invloice_receipt_hedaer_top-->
<div class="main_block inv_rece_header_top header_seprator header_seprator_4 mg_bt_10">
  <div class="row">
    <div class="col-md-4">
      <div class="inv_rece_header_left">
        <div class="inv_rece_header_logo">
          <img src="<?php echo $admin_logo_url ?>" class="img-responsive">
        </div>
      </div>
    </div>
    <div class="col-md-4 text-center pd_tp_5">
      <div class="inv_rece_header_left">
        <div class="inv_rec_no_detail">
          <h2 class="inv_rec_no_title font_5 font_s_21 no-marg no-pad">RECEIPT</h2>
          <h4 class="inv_rec_no font_5 font_s_14 no-marg no-pad"><?php echo $payment_id; ?></h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 last_h_sep_border_lt">
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

<!-- invloice_receipt_bottom-->
<div class="main_block inv_rece_header_bottom mg_tp_10">
  <div class="row">
    <div class="col-md-7">
      <div class="inv_rece_header_left mg_bt_10">
        <ul class="no-marg no-pad noType">
          <li><h3 class="title font_5 font_s_16 no-marg no-pad">TO,</h3></li>
          <li><h3 class=" font_5 font_s_14 no-marg no-pad"><?php echo  $sq_customer['company_name']; ?></h3></li>
          <li><i class="fa fa-user"></i> : <?php if($customer_id != '') { echo  $sq_customer['first_name'].' '.$sq_customer['last_name']; }
          else { echo $booking_id; } ?></li>
          
        </ul>
      </div>
    </div>
    <div class="col-md-5">
      <div class="inv_rece_header_right">
        <ul class="no-marg no-pad noType">
          <li><span class="font_5">RECEIPT FOR </span>: <?php echo $receipt_type; ?></li>
          <?php if($payment_date!=''){?><li><span class="font_5">RECEIPT DATE </span>: <?php echo date('d-m-Y', strtotime($receipt_date)); ?></li><?php } ?>
          <li><span class="font_5">TAX NO : </span> <?php echo $sq_customer['service_tax_no']; ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</section>