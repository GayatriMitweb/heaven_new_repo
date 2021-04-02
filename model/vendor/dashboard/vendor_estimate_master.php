<?php
$flag = true;
class vendor_estimate_master{
public function vendor_estimate_save(){
    $row_spec = 'purchase';
    $estimate_type = $_POST['estimate_type'];
    $estimate_type_id = $_POST['estimate_type_id'];
    $vendor_type_arr = $_POST['vendor_type_arr'];
    $vendor_type_id_arr = $_POST['vendor_type_id_arr'];
    $basic_cost_arr = $_POST['basic_cost_arr'];
    $non_recoverable_taxes_arr = $_POST['non_recoverable_taxes_arr'];
    $service_charge_arr = $_POST['service_charge_arr'];
    $other_charges_arr = $_POST['other_charges_arr'];
    $service_tax_subtotal_arr = $_POST['service_tax_subtotal_arr'];
    $discount_arr = $_POST['discount_arr'];
    $our_commission_arr = $_POST['our_commission_arr'];
    $tds_arr = $_POST['tds_arr'];
    $net_total_arr = $_POST['net_total_arr'];
    $roundoff_arr = $_POST['roundoff_arr'];
    $remark_arr = $_POST['remark_arr'];
    $invoice_url_arr = $_POST['invoice_url_arr'];
    $invoice_id_arr = $_POST['invoice_id_arr'];
    $payment_due_date_arr = $_POST['payment_due_date_arr'];
    $purchase_date_arr = $_POST['purchase_date_arr'];
    $branch_admin_id = $_POST['branch_admin_id'];
    $emp_id = $_POST['emp_id'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $reflections1 = json_encode($reflections);
    $financial_year_id = $_SESSION['financial_year_id'];
    $created_at = date('Y-m-d H:i:s');
   
    begin_t();

    for($i=0; $i<sizeof($basic_cost_arr); $i++){
           

            $sq_max = mysql_fetch_assoc(mysql_query("select max(estimate_id) as max from vendor_estimate"));
            $estimate_id = $sq_max['max'] + 1;

            $payment_due_date_arr1[$i] = get_date_db($payment_due_date_arr[$i]);
            $purchase_date_arr1[$i] = get_date_db($purchase_date_arr[$i]);

            $remark_arr1 = addslashes($remark_arr[$i]);
            
            $sq_est = mysql_query("insert into vendor_estimate(estimate_id, estimate_type, estimate_type_id, branch_admin_id,financial_year_id, emp_id, vendor_type, vendor_type_id, basic_cost, non_recoverable_taxes, service_charge, other_charges, service_tax_subtotal, discount, our_commission, tds, net_total, roundoff,remark, created_at, invoice_proof_url, invoice_id, due_date, purchase_date, reflections) values('$estimate_id', '$estimate_type', '$estimate_type_id', '$branch_admin_id','$financial_year_id', '$emp_id', '$vendor_type_arr[$i]', '$vendor_type_id_arr[$i]', '$basic_cost_arr[$i]', '$non_recoverable_taxes_arr[$i]', '$service_charge_arr[$i]', '$other_charges_arr[$i]', '$service_tax_subtotal_arr[$i]', '$discount_arr[$i]', '$our_commission_arr[$i]', '$tds_arr[$i]', '$net_total_arr[$i]', '$roundoff_arr[$i]','$remark_arr1', '$created_at','$invoice_url_arr[$i]','$invoice_id_arr[$i]','$payment_due_date_arr1[$i]','$purchase_date_arr1[$i]','$reflections1')");
            if(!$sq_est){
                $GLOBALS['flag'] = false;
                echo "error--Supplier Cost not saved!";     
            }
            else{
                //Send Mail
                $booking_id = get_estimate_type_name($estimate_type, $estimate_type_id);
                $supplier_name = get_vendor_name($vendor_type_arr[$i], $vendor_type_id_arr[$i]);
                $supplier_email = get_vendor_email($vendor_type_arr[$i], $vendor_type_id_arr[$i]);
                $date = $purchase_date_arr1[$i];
                $yr = explode("-", $date);
                $year =$yr[0];
                $estimate_id1 = get_vendor_estimate_id($estimate_id,$year);
                $this->purchase_mail_send($estimate_id1,$booking_id,$supplier_name,$supplier_email,$estimate_type,$estimate_type_id);

                //Finance Save
                $this->finance_save($estimate_id, $vendor_type_arr[$i], $vendor_type_id_arr[$i], $basic_cost_arr[$i], $non_recoverable_taxes_arr[$i], $service_charge_arr[$i], $other_charges_arr[$i], $service_tax_subtotal_arr[$i], $discount_arr[$i], $our_commission_arr[$i], $tds_arr[$i], $net_total_arr[$i], $roundoff_arr[$i],$row_spec,$branch_admin_id,$purchase_date_arr1[$i], $reflections);
            }
    }
    if($GLOBALS['flag']){
        commit_t();
        echo "Purchase has been successfully saved." ;
        exit;
    }
    else{
        rollback_t();
        exit;
    }

}
public function purchase_mail_send($estimate_id,$booking_id,$supplier_name,$supplier_email,$estimate_type,$estimate_type_id){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
if($estimate_type == "Hotel Booking"){
    $booking_details = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id = ".$estimate_type_id));
    $booking_entries = mysql_query("select * from hotel_booking_entries where booking_id = ".$estimate_type_id);

    $content = '
    <tr>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Purchase Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$estimate_type.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Purchase ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$booking_id.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Guest Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$booking_details[pass_name].'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Total Adults</td>   <td style="text-align:left;border: 1px solid #888888;" >'.(($booking_details[adults] == '') ? 0 : $booking_details[adults]).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Total Child</td>   <td style="text-align:left;border: 1px solid #888888;" >'.(($booking_details[childrens] == '') ? 0 : $booking_details[childrens]).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Total Infant</td>   <td style="text-align:left;border: 1px solid #888888;" >'.(($booking_details[infants] == '') ? 0 : $booking_details[infants]).'</td></tr>
        </table>
    </tr>
  ';
  
    while($row_hotel = mysql_fetch_assoc($booking_entries)){
        $hotel_name = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id =".$row_hotel['hotel_id']));
        $content .= '
    <tr>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$hotel_name[hotel_name].'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Check In Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_datetime_user($row_hotel[check_in]).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Check Out Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_datetime_user($row_hotel[check_out]).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Total Rooms</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$row_hotel[rooms].'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Room Category</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$row_hotel[category].'</td></tr>   
            <tr><td style="text-align:left;border: 1px solid #888888;">Extra Bed</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$row_hotel[extra_beds].'</td></tr>
        </table>
    </tr>  
    ';    
    }
    
}
  
  $subject = 'Purchase Confirmation! (Purchase ID : '.$booking_id.' )';
  global $model;
  $model->app_email_send('25',$supplier_name,$supplier_email,$content, $subject);

}
 
public function finance_save($estimate_id, $vendor_type, $vendor_type_id, $basic_cost, $non_recoverable_taxes, $service_charge, $other_charges, $service_tax_subtotal, $discount, $our_commission, $tds, $net_total,$roundoff,$row_spec,$branch_admin_id,$purchase_date_arr1,$reflections){
    
    global $transaction_master;

    $purchase_gl = get_vendor_purchase_gl_id($vendor_type, $vendor_type_id);
    $created_at = get_date_db($purchase_date_arr1);
	$year1 = explode("-", $created_at);
    $yr1 =$year1[0];
    
    $supplier_amount = $basic_cost + $non_recoverable_taxes + $other_charges;
    $purchase_amount = $basic_cost + $non_recoverable_taxes + $other_charges;

    //Getting supplier Ledger
    $q = "select * from ledger_master where group_sub_id='105' and customer_id='$vendor_type_id' and user_type='$vendor_type'";
    $sq_sup = mysql_fetch_assoc(mysql_query($q));
    $supplier_gl = $sq_sup['ledger_id'];
    ////////////purchase/////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $purchase_amount;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $purchase_amount, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    //////service charge
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $service_charge, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->purchase_taxes);
    $total_tax = 0;
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];
      $total_tax += $tax_amount;
      $module_name = $vendor_type;
      $module_entry_id = $estimate_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $created_at;
      $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1),$created_at, $tax_amount, $vendor_type, $vendor_type_id);
      $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

      $module_name = $vendor_type;
      $module_entry_id = $estimate_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $created_at;
      $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1),$created_at, $tax_amount, $vendor_type, $vendor_type_id);
      $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
      $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');
    }
    //////Supplier Credit 
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $total_tax;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $total_tax, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '3',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    ////// Discount ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $discount;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $discount, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = 37;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    ////// Commision ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $our_commission;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $our_commission, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = ($reflections[0]->purchase_commission != '') ? $reflections[0]->purchase_commission : 25;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    ////// Tds Payable Credit////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $tds, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = ($reflections[0]->purchase_tds != '') ? $reflections[0]->purchase_tds : 126;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    ////// Tds Payable Debit////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $tds, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = ($reflections[0]->purchase_tds != '') ? $reflections[0]->purchase_tds : 126;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    //////Supplier Credit 
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $tds, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '4',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    ////Roundoff Value
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $created_at, $roundoff, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');

    //Supplier
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $net_total;
    $payment_date = $created_at;
    $payment_particular = get_purchase_partucular(get_vendor_payment_id($estimate_id,$yr1), $created_at, $net_total, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $purchase_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'PURCHASE');
}

public function vendor_estimate_update(){
    $row_spec ='purchase';
    $estimate_id = $_POST['estimate_id'];
    $estimate_type = $_POST['estimate_type'];
    $vendor_type = $_POST['vendor_type'];   
    $estimate_type_id = $_POST['estimate_type_id'];
    $vendor_type_id = $_POST['vendor_type_id'];

    $basic_cost = $_POST['basic_cost'];
    $non_recoverable_taxes = $_POST['non_recoverable_taxes'];
    $service_charge = $_POST['service_charge'];
    $other_charges = $_POST['other_charges'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $discount = $_POST['discount'];
    $our_commission = $_POST['our_commission'];
    $tds = $_POST['tds'];
    $net_total = $_POST['net_total'];
    $roundoff = $_POST['roundoff'];
    $remark = $_POST['remark'];
    $invoice_url = $_POST['invoice_url'];
    $invoice_id = $_POST['invoice_id'];
    $payment_due_date = $_POST['payment_due_date'];
    $purchase_date = $_POST['purchase_date'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $reflections1 = json_encode($reflections);

    $payment_due_date = get_date_db($payment_due_date);
    $purchase_date = get_date_db($purchase_date);

    $sq_estimate_info  = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));

    begin_t();
    $remark1 = addslashes($remark);
    $sq_est = mysql_query("update vendor_estimate set estimate_type='$estimate_type', estimate_type_id='$estimate_type_id', vendor_type='$vendor_type', vendor_type_id='$vendor_type_id', basic_cost='$basic_cost', non_recoverable_taxes='$non_recoverable_taxes', service_charge='$service_charge', other_charges='$other_charges', service_tax_subtotal='$service_tax_subtotal', discount='$discount', our_commission='$our_commission', tds='$tds', net_total='$net_total', roundoff='$roundoff',remark='$remark1',invoice_proof_url = '$invoice_url',invoice_id='$invoice_id', due_date='$payment_due_date',purchase_date ='$purchase_date',reflections='$reflections1' where estimate_id='$estimate_id'");
    if($sq_est){

        //Finance Update
        $this->finance_update($sq_estimate_info,$estimate_id, $vendor_type, $vendor_type_id, $basic_cost, $non_recoverable_taxes, $service_charge, $other_charges, $service_tax_subtotal, $discount, $our_commission, $tds, $net_total,$roundoff,$row_spec,$purchase_date,$reflections);

        if($GLOBALS['flag']){
            commit_t();
            echo "Purchase has been successfully updated.";
            exit;
        }
    }
    else{
        rollback_t();
        echo "error--Supplier Cost not updated!";
        exit;
    }

}

public function finance_update($sq_estimate_info,$estimate_id, $vendor_type, $vendor_type_id, $basic_cost, $non_recoverable_taxes, $service_charge, $other_charges, $service_tax_subtotal, $discount, $our_commission, $tds, $net_total,$roundoff,$row_spec,$purchase_date,$reflections)
{
    $old_purchase_gl = get_vendor_purchase_gl_id($sq_estimate_info['vendor_type'], $sq_estimate_info['vendor_type_id']);    
    $purchase_gl = get_vendor_purchase_gl_id($vendor_type, $vendor_type_id);  
    $purchase_amount =  $basic_cost + $non_recoverable_taxes + $other_charges;
	$year1 = explode("-", $purchase_date);
    $yr1 =$year1[0];
    
    global $transaction_master;
    //Getting supplier Ledger
    $q = "select * from ledger_master where group_sub_id='105' and customer_id='$vendor_type_id' and user_type='$vendor_type'";
    $sq_sup = mysql_fetch_assoc(mysql_query($q));
    $supplier_gl = $sq_sup['ledger_id'];

    ////////////purchase/////////////
    
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $purchase_amount;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $purchase_amount, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $old_gl_id = $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$ledger_particular);

     //////service charge
     $module_name = $vendor_type;
     $module_entry_id = $estimate_id;
     $transaction_id = "";
     $payment_amount = $service_charge;
     $payment_date = $purchase_date;
     $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $service_charge, $vendor_type, $vendor_type_id);
     $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
     $old_gl_id = $gl_id = $supplier_gl;
     $payment_side = "Credit";
     $clearance_status = "";
     $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$ledger_particular);

     /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->purchase_taxes);
    $total_tax = 0;
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];
      $total_tax += $tax_amount;
      $module_name = $vendor_type;
      $module_entry_id = $estimate_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $purchase_date;
      $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1),$purchase_date, $tax_amount, $vendor_type, $vendor_type_id);
      $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
      $old_gl_id = $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$ledger_particular);

      $module_name = $vendor_type;
      $module_entry_id = $estimate_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $purchase_date;
      $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1),$purchase_date, $tax_amount, $vendor_type, $vendor_type_id);
      $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
      $old_gl_id = $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$ledger_particular);
    }

    //////Supplier Credit 
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $total_tax;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $total_tax, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
    $old_gl_id = $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '3',$payment_side, $clearance_status, $row_spec,$ledger_particular);

    ////// Discount ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $discount;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $discount, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id = $gl_id = 37;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular);

    ////// Commision ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $our_commission;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $our_commission, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id = $gl_id = ($reflections[0]->purchase_commission != '') ? $reflections[0]->purchase_commission : 25;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular);

    ////// Tds Payable ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $tds, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id  = $gl_id = ($reflections[0]->purchase_tds != '') ? $reflections[0]->purchase_tds : 126;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$ledger_particular);

     ////// Tds Payable Debit////////////
     $module_name = $vendor_type;
     $module_entry_id = $estimate_id;
     $transaction_id = "";
     $payment_amount = $tds;
     $payment_date = $purchase_date;
     $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $tds, $vendor_type, $vendor_type_id);
     $ledger_particular = get_ledger_particular('By','Cash/Bank');
     $old_gl_id = $gl_id = ($reflections[0]->purchase_tds != '') ? $reflections[0]->purchase_tds : 126;
     $payment_side = "Debit";
     $clearance_status = "";
     $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '2',$payment_side, $clearance_status, $row_spec,$ledger_particular);
 
     //////Supplier Credit 
     $module_name = $vendor_type;
     $module_entry_id = $estimate_id;
     $transaction_id = "";
     $payment_amount = $tds;
     $payment_date = $purchase_date;
     $payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1), $purchase_date, $tds, $vendor_type, $vendor_type_id);
     $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
     $old_gl_id = $gl_id = $supplier_gl;
     $payment_side = "Credit";
     $clearance_status = "";
     $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '4',$payment_side, $clearance_status, $row_spec,$ledger_particular);
 

    /////////roundoff/////////
	$module_name = $vendor_type;
	$module_entry_id = $estimate_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $purchase_date;
	$payment_particular = get_purchase_partucular(get_vendor_estimate_id($estimate_id,$yr1),$purchase_date, $roundoff, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('For',$vendor_type.' Purchase');
	$old_gl_id = $gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular);

    //Supplier
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id ='';
    $payment_amount = $net_total;
    $payment_date = $purchase_date;
    $payment_particular = get_purchase_partucular(get_vendor_payment_id($estimate_id,$yr1), $purchase_date, $net_total, $vendor_type, $vendor_type_id);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id = $gl_id = $purchase_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular);

}
}
?>