<?php
if (!function_exists('begin_panel')) {
  function begin_panel($title,$entry_id) {
    if($entry_id!=''){
      return '<div class="app_panel"> <div class="app_panel_head"><h2 class="pull-left">'.$title.'</h2>
      <div class="pull-right header_btn"><button title="Play Video" data-toggle="tooltip" onclick="display_description(1,'.$entry_id.')"><a><i class="fa fa-play" aria-hidden="true"></i></a></button></div>
      </div> <div class="app_panel_content">';
    }
    else{
      return '<div class="app_panel"> <div class="app_panel_head"><h2 class="pull-left">'.$title.'</h2></div> <div class="app_panel_content">';
    }
  }
}
// <div class="pull-right header_btn"><button title="Info" onclick="display_description(2,'.$entry_id.')"><a><i class="fa fa-info" aria-hidden="true" title="Guidelins"></i></a></button></div>
if (!function_exists('end_panel')) {
  function end_panel() { return  '</div></div>'; }
}?>
<?php
//App Widget Fucntion start
function begin_widget() { ?> <div class="widget_parent"> <?php }
function end_widget() { ?> </div> <?php }
function widget_head($head_title){ ?> <div class="widget_head"><?= $head_title ?></div> <?php }
function widget_element($title_arr, $content_arr, $percent, $label){
    if(sizeof($title_arr)==1){ $col_cl = "12"; }
    if(sizeof($title_arr)==2){ $col_cl = "6"; }
    if(sizeof($title_arr)==3){ $col_cl = "4"; }
    if(sizeof($title_arr)==4){ $col_cl = "3"; }
    if(sizeof($title_arr)==5){ $col_cl = "2"; }
    if(sizeof($title_arr)==6){ $col_cl = "2"; }
    if(sizeof($title_arr) >= 7){ $col_cl = "2"; }
    ?>
    <div class="stat_content">
        <div class="row">
          <?php 
          for($i=0; $i<sizeof($title_arr); $i++){

           if($i==0){ $type="success"; }
           if($i==1){ $type="info"; }
           if($i==2){ $type="danger"; }
           ?>
           <div class="content_span col-sm-<?= $col_cl ?>">
              <div class="stat_content-tilte <?= $type ?>-col"><?= $title_arr[$i] ?></div>
              <div class="stat_content-amount"><?= $content_arr[$i] ?></div>
          </div>
           <?php } ?>
      </div>
    </div>
    <div class="row"><div class="col-md-12">
       <div class="widget-badge mg_tp_10">
            <div class="label label-warning">+ <?= $percent ?> %</div>&nbsp;&nbsp;
            <label><?= $label ?></label>
        </div> 
    </div></div>
    <div class="row"> <div class="col-md-12">
        <div class="progress mg_bt_0">
          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent ?>%"></div>
        </div>
    </div> </div>
    <?php
}

function get_date_user($date){
  if($date!="0000-00-00" && $date!="1970-01-01" && $date!=""){
    $date = date('d-m-Y', strtotime($date));
  }
  else{
    $date = "";
  }
  return $date;
}

function get_date_db($date){
  $date = date('Y-m-d', strtotime($date));
  return $date;
}

function get_datetime_user($date){
  if($date!="0000-00-00 00:00:00" && $date!="1970-01-01 00:00:00" && $date!=""){
    $date = date('d-m-Y H:i:s', strtotime($date));
  }
  else{
    $date = "";
  }
  return $date;
}
function get_datetime_db($date){
  $date = date('Y-m-d H:i:s', strtotime($date));
  return $date;
}

function begin_t(){
  mysql_query("START TRANSACTION");
}
function commit_t(){
  mysql_query("COMMIT");
}
function rollback_t(){
  mysql_query("ROLLBACK");
}

function get_vendor_requst_vendor_name($vendor_type, $vendor_type_id){

  if($vendor_type=="Hotel"){
    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
    $client_name = $sq_hotel['hotel_name'];
  }
  if($vendor_type=="Transport"){
    $sq_tr = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
    $client_name = $sq_tr['transport_agency_name'];
  }
  if($vendor_type=="DMC"){
    $sq_dmc = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
    $client_name = $sq_dmc['company_name'];
  }
  return $client_name;

}

function get_vendor_requst_vendor_email($vendor_type, $vendor_type_id){

  if($vendor_type=="Hotel"){
    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
    $vendor_email_id = $sq_hotel['email_id'];
  }
  if($vendor_type=="Transport"){
    $sq_tr = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
    $vendor_email_id = $sq_tr['email_id'];
  }
  if($vendor_type=="DMC"){
    $sq_dmc = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
    $vendor_email_id = $sq_dmc['email_id'];
  }
  return $client_name;

}

function get_vendor_purchase_gl_id($vendor_type, $vendor_type_id){

  if($vendor_type=="Hotel Vendor"){ $gl_id = 62; }
  if($vendor_type=="Car Rental Vendor"){ $gl_id = 16; }
  if($vendor_type=="Visa Vendor"){ $gl_id = 144; }
  if($vendor_type=="Passport Vendor"){ $gl_id = 143; }
  if($vendor_type=="Ticket Vendor"){ $gl_id = 48; }
  if($vendor_type=="Excursion Vendor"){ $gl_id = 46; }
  if($vendor_type=="Insurance Vendor"){ $gl_id = 142; }
  if($vendor_type=="Train Ticket Vendor"){ $gl_id = 132; }
  if($vendor_type=="Transport Vendor"){ $gl_id = 16; }
  if($vendor_type=="DMC Vendor"){ $gl_id = 39; }
  if($vendor_type=="Cruise Vendor"){ $gl_id = 29; }
  if($vendor_type=="Other Vendor"){ 
    $gl_id = '167';
  }
  return $gl_id;

}

function get_vendor_cancelation_gl_id($vendor_type, $vendor_type_id){
  if($vendor_type=="Hotel Vendor"){ $gl_id = 65; }
  if($vendor_type=="Car Rental Vendor"){ $gl_id = 17; }
  if($vendor_type=="Visa Vendor"){ $gl_id = 162; }
  if($vendor_type=="Passport Vendor"){ $gl_id = 163; }
  if($vendor_type=="Ticket Vendor"){ $gl_id = 49; }
  if($vendor_type=="Excursion Vendor"){ $gl_id = 43; }
  if($vendor_type=="Insurance Vendor"){ $gl_id = 142; }
  if($vendor_type=="Train Ticket Vendor"){ $gl_id = 131; }
  if($vendor_type=="Transport Vendor"){ $gl_id = 17; }
  if($vendor_type=="DMC Vendor"){ $gl_id = 40; }
  if($vendor_type=="Cruise Vendor"){ $gl_id = 30; }
  if($vendor_type=="Other Vendor"){
    $gl_id = '168';
  }

  return $gl_id;
}
function get_bank_book_opening_balance($bank_id='')
{
  $query = "select sum(opening_balance) as sum from bank_master where 1 ";
  if($bank_id!=''){
    $query .=" and bank_id='$bank_id'";
  }
  $query .=" and active_flag='Active'";
  $sq_bal = mysql_fetch_assoc(mysql_query($query));
  $opening_bal = $sq_bal['sum'];
  return $opening_bal;
}
function sundry_creditor_balance_update()
  {
  }

 function get_bank_balance_update()
 {
    //sum of opening balalnce of each bank
    $sq_bank_balance = mysql_fetch_assoc(mysql_query("select sum(opening_balance) as opening_balance from bank_master"));
     //update sundry creditor opening balance
    $sq_bank = mysql_query("update gl_master set  gl_balance='$sq_bank_balance[opening_balance]' where gl_id='15'");
 }

function bank_cash_balance_check($refund_mode, $bank_id, $refund_amount, $old_amount='')
{
    if($refund_mode=="Cash"){

        $sq_credit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_type='Cash' and payment_side='Credit' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

        $sq_debit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_type='Cash' and payment_side='Debit' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

        $transaction_bal = $sq_credit['sum'] - $sq_debit['sum'];

        $opening_bal = $transaction_bal;
    }
    else{

        $opening_bal = get_bank_book_opening_balance($bank_id);

        $sq_credit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_type='Bank' and payment_side='Credit' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

        $sq_debit = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bank_cash_book_master where payment_type='Bank' and payment_side='Debit' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

        $transaction_bal = $sq_credit['sum'] - $sq_debit['sum'];

        $opening_bal = $opening_bal+$transaction_bal;
        //echo $opening_bal; exit;
    }
    if($old_amount!=""){
        $opening_bal = $opening_bal+$old_amount;
    }

    //This is temporary comment for balance chack validation
    /*if($refund_amount>$opening_bal){
      return false;
    }
    else{
      return true;
    }*/

    return true;

}

function bank_cash_balance_error_msg($refund_mode, $bank_id)
{
    if($refund_mode=="Cash"){
      return "error--Not enough cash available!";
    }
    else{
      return "error--Not enough cash available in selected bank!";
    }
}


function mail_login_box($username, $password, $link)
{
  global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$theme_color;
  global $theme_color;
  $content = '


  <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
      <tr>
          <td colspan=2><h3>Your Login Details!</h3></td>
      </tr>
      <tr><td style="text-align:left;border: 1px solid #888888;">Username</td>   <td style="text-align:left;border: 1px solid #888888;text-decoration:none !important;color:#888888 !important;">'.$username.'</td></tr>
      <tr><td style="text-align:left;border: 1px solid #888888;">Password</td>   <td style="text-decoration:none !important;text-align:left;border: 1px solid #888888;color:#888888 !important;">'.$password.'</td></tr>
      <tr><td style="text-align:left;border: 1px solid #888888;">Login</td>   <td style="text-align:left;border: 1px solid #888888;"><a href="'.$link.'" style="text-decoration: none !important;color: '.$theme_color.'!important;">Click For Login!</a></td></tr>
    </table>
  </tr>
  ';

  return $content;

}


function get_igst_cost($service_tax_subtotal, $taxation_type){
    if($taxation_type=="IGST"){
      return ($service_tax_subtotal);
    }
    else{
      return 0;
    }
}
function get_cgst_cost($service_tax_subtotal, $taxation_type){
    if($taxation_type=="SGST+CGST"){
      $per = 50;
      $amount = (($service_tax_subtotal/100)*$per);
      return $amount;
    }
    else{
      return 0;
    }
}
function get_sgst_cost($service_tax_subtotal, $taxation_type){
    if($taxation_type=="SGST+CGST"){
      $per = 50;
      $amount = (($service_tax_subtotal/100)*$per);
      return $amount;        
    }
    else{
      return 0;
    }
}
function get_ugst_cost($service_tax_subtotal, $taxation_type){
    if($taxation_type=="UGST"){
      return ($service_tax_subtotal);
    }
    else{
      return 0;
    }
}
function get_vat_cost($service_tax_subtotal, $taxation_type){
    if($taxation_type=="VAT"){
      return ($service_tax_subtotal);
    }
    else{
      return 0;
    }
}
////////////////////////////Sales TAX Reflection Generic Update//////////////////////////

function tax_reflection_update($serivcename,$service_tax_subtotal,$taxation_type,$visa_id1,$visa_id,$booking_date, $customer_id, $row_spec,$branch_admin_id)
{
  global $transaction_master;
  /////// TAX Amount ///////////.
  $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
  $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
  $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
  $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);
  $vgst = get_vat_cost($service_tax_subtotal, $taxation_type);

  $sq_count_c = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='21' and payment_side='Credit'"));
  $sq_count_s = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='119' and payment_side='Credit'"));
  $sq_count_i = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='67' and payment_side='Credit'"));
  $sq_count_u = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='138' and payment_side='Credit'"));
  $sq_count_v = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='150' and payment_side='Credit'"));

  if($taxation_type == 'SGST+CGST')
    {           
      //CGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $cgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $cgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 21;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_c == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }

      //SGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $sgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $sgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 119;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_s == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'IGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $igst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $igst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 67;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_i == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'119', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'21','21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'119', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'21','21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'UGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $ugst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $ugst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 138;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_u == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'119', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'21', '21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'119', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'21', '21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'150','150', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else{
      //VAT
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $vgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $vgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 150;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_v == '0'){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'119', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'67','67', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'138', '138', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'21','21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
}

////////////////////////////Sales TAX Reflection Generic Update End//////////////////////////

////////////////////////////Purchase TAX Reflection Generic Update//////////////////////////
function purchase_tax_reflection_update($serivcename,$service_tax_subtotal,$taxation_type,$visa_id1,$visa_id,$booking_date,$payment_mode, $row_spec,$branch_admin_id)
{
  global $transaction_master;
  /////// TAX Amount ///////////.
  $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
  $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
  $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
  $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);
  $vgst = get_vat_cost($service_tax_subtotal, $taxation_type);

  $sq_count_c = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='145' and payment_side='Debit'"));
  $sq_count_s = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='146' and payment_side='Debit'"));
  $sq_count_i = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='148' and payment_side='Debit'"));
  $sq_count_u = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='147' and payment_side='Debit'"));
  $sq_count_v = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='149' and payment_side='Debit'"));

  if($taxation_type == 'SGST+CGST')
    {           
      //CGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $cgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 145;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_c == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }

      //SGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $sgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 146;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_s == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'IGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $igst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 148;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_i == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'146', '146', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'145','145', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'146', '146', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'145','145', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'UGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $ugst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 147;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_u == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'146', '146', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'145', '145', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'146', '146', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'145', '145', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'149','149', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else{
      //VAT
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $vgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 149;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_v == '0'){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'146', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'148','148', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'147', '147', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'145','21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
}

////////////////////////////Purchase TAX Reflection Generic Update End//////////////////////////

////////////////////////////Sales Cancel TAX Reflection Generic Update//////////////////////////

function tax_cancel_reflection_update($serivcename,$service_tax_subtotal,$taxation_type,$visa_id1,$visa_id,$booking_date, $customer_id, $row_spec,$branch_admin_id)
{
  global $transaction_master;
  /////// TAX Amount ///////////.
  $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
  $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
  $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
  $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);
  $vgst = get_vat_cost($service_tax_subtotal, $taxation_type);

  $sq_count_c = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='156' and payment_side='Debit'"));
  $sq_count_s = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='154' and payment_side='Debit'"));
  $sq_count_i = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='152' and payment_side='Debit'"));
  $sq_count_u = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='158' and payment_side='Debit'"));
  $sq_count_v = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='159' and payment_side='Debit'"));

  if($taxation_type == 'SGST+CGST')
    {           
      //CGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $cgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $cgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 156;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_c == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }

      //SGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $sgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $sgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 154;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_s == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'IGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $igst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $igst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 152;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_i == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'154', '154', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'156','156', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'154', '154', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'156','156', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'UGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $ugst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $ugst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 158;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_u == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'154', '154', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'156', '156', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'154', '154', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'156', '156', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'159','159', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else{
      //VAT
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $vgst;
      $payment_date = $booking_date;
      $payment_particular = get_sales_particular($visa_id, $booking_date, $vgst, $customer_id);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $old_gl_id = $gl_id = 159;
      $payment_side = "Debit";
      $clearance_status = "";
      if($sq_count_v == '0'){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'154', '154', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'152','152', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'158', '158', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'156','156', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
}

////////////////////////////Sales Cancel TAX Reflection Generic Update End//////////////////////////

////////////////////////// Purchase Cancel TAX Reflection Generic update start////////////////////////////////
function purchase_tax_cancel_reflection_update($serivcename,$service_tax_subtotal,$taxation_type,$visa_id1,$visa_id,$booking_date,$payment_mode, $row_spec,$branch_admin_id)
{
  global $transaction_master;
  /////// TAX Amount ///////////.
  $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
  $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
  $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
  $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);
  $vgst = get_vat_cost($service_tax_subtotal, $taxation_type);

  $sq_count_c = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='155' and payment_side='Credit'"));
  $sq_count_s = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='153' and payment_side='Credit'"));
  $sq_count_i = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='151' and payment_side='Credit'"));
  $sq_count_u = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='157' and payment_side='Credit'"));
  $sq_count_v = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='$serivcename' and module_entry_id='$visa_id1' and gl_id ='160' and payment_side='Credit'"));

  if($taxation_type == 'SGST+CGST')
    {           
      //CGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $cgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = '';
      $old_gl_id = $gl_id = 155;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_c == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }

      //SGST
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $sgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = '';
      $old_gl_id = $gl_id = 153;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_s == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'IGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $igst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = '';
      $old_gl_id = $gl_id = 151;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_i == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'153', '153', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'155','155', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'153', '153', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'155','155', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else if($taxation_type == 'UGST')
    {
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $ugst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = '';
      $old_gl_id = $gl_id = 157;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_u == '0'){
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'153', '153', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'155', '155', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'153', '153', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'155', '155', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'160','160', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
    else{
      //VAT
      $module_name = $serivcename;
      $module_entry_id = $visa_id1;
      $transaction_id = "";
      $payment_amount = $vgst;
      $payment_date = $booking_date;
      $payment_particular = get_gst_paid_particular($visa_id, $booking_date, $cgst, $payment_mode);
      $ledger_particular = '';
      $old_gl_id = $gl_id = 160;
      $payment_side = "Credit";
      $clearance_status = "";
      if($sq_count_v == '0'){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
      }
      else{
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'153', '119', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id,'0', $payment_date, $payment_particular,'151','151', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'157', '157', $payment_side, $clearance_status, $row_spec,$ledger_particular);
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, '0', $payment_date, $payment_particular,'155','21', $payment_side, $clearance_status, $row_spec,$ledger_particular);
      }
    }
}
///////////////////////////Purchase Cancel TAX Reflection Generic update End ///////////////////////////////


function clean($string) {

   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

function get_customer_name($booking_type,$booking_id)
{
  $customer_id = ''; 

  if($booking_type == "Visa Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Passport Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Air Ticket Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Train Ticket Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Group Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Package Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Bus Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Forex Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Car Rental Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Excursion Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else if($booking_type == "Miscellaneous Booking"){
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }
  else {
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_booking['customer_id'];
  }

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  if($sq_customer['type'] == 'Corporate'){ $customer_name = $sq_customer['company_name']; }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name']; }
  return $customer_name;
}

function get_vendor_name_report($vendor_type,$vendor_type_id)
{
  if($vendor_type=="Hotel Vendor"){
    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
    $vendor_type_val = $sq_hotel['hotel_name'];
  } 
  if($vendor_type=="Transport Vendor"){
    $sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
    $vendor_type_val = $sq_transport['transport_agency_name'];
  } 
  if($vendor_type=="Car Rental Vendor"){
    $sq_cra_rental_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_cra_rental_vendor['vendor_name'];
  }
  if($vendor_type=="DMC Vendor"){
    $sq_dmc_vendor = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
    $vendor_type_val = $sq_dmc_vendor['company_name'];
  }
  if($vendor_type=="Visa Vendor"){
    $sq_visa_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_visa_vendor['vendor_name'];
  }
  if($vendor_type=="Passport Vendor"){
    $sq_passport_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_passport_vendor['vendor_name'];
  }
  if($vendor_type=="Ticket Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['vendor_name'];
  }
  if($vendor_type=="Train Ticket Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['vendor_name'];
  }
  if($vendor_type=="Excursion Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['vendor_name'];
  }
  if($vendor_type=="Insurance Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['vendor_name'];
  }
  if($vendor_type=="Other Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['vendor_name'];
  }
  if($vendor_type=="Cruise Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['company_name'];
  }

  return $vendor_type_val;
}

function get_vendor_pan_report($vendor_type,$vendor_type_id)
{
  if($vendor_type=="Hotel Vendor"){
    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
    $vendor_type_val = $sq_hotel['pan_no'];
  } 
  if($vendor_type=="Transport Vendor"){
    $sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
    $vendor_type_val = $sq_transport['pan_no'];
  } 
  if($vendor_type=="Car Rental Vendor"){
    $sq_cra_rental_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_cra_rental_vendor['pan_no'];
  }
  if($vendor_type=="DMC Vendor"){
    $sq_dmc_vendor = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
    $vendor_type_val = $sq_dmc_vendor['pan_no'];
  }
  if($vendor_type=="Visa Vendor"){
    $sq_visa_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_visa_vendor['pan_no'];
  }
  if($vendor_type=="Passport Vendor"){
    $sq_passport_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_passport_vendor['pan_no'];
  }
  if($vendor_type=="Ticket Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }
  if($vendor_type=="Train Ticket Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }
  if($vendor_type=="Excursion Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }
  if($vendor_type=="Insurance Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }
  if($vendor_type=="Other Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }
  if($vendor_type=="Cruise Vendor"){
    $sq_vendor = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$vendor_type_id'"));
    $vendor_type_val = $sq_vendor['pan_no'];
  }

  return $vendor_type_val;
}
function get_supplier_info($vendor_type,$estimate_id){
  
  $sq_supplier = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where vendor_type='$vendor_type' and estimate_id='$estimate_id'"));
  $arr = array(
    'vendor_type_id' => $sq_supplier['vendor_type_id'],
    'estimate_type' => $sq_supplier['estimate_type']
    );
  return $arr;
}
?>