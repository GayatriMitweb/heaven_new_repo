<?php 
$flag = true;
class estimate_update_master{

public function estimate_update()
{
    $estimate_id = $_POST['estimate_id'];
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];
    $branch_admin_id = $_SESSION['branch_admin_id'];

    $sq_estimate = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));

    $vendor_type = $sq_estimate['vendor_type'];
    $vendor_type_id = $sq_estimate['vendor_type_id'];
    $taxation_type = $sq_estimate['taxation_type'];
    $service_tax_subtotal = $sq_estimate['service_tax_subtotal'];
    
    $sq_est = mysql_query("update vendor_estimate set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount' where estimate_id='$estimate_id'");

    if($sq_est){

    	//Finance Save
		$this->finance_save($vendor_type,$vendor_type_id,$taxation_type,$service_tax_subtotal,$branch_admin_id);

    	if($GLOBALS['flag']){
    		commit_t();
    		echo "Cancellation done!";
    		exit;
    	}
    	else{
    		rollback_t();
    		exit;
    	}

    }
    else{
    	rollback_t();
    	echo "error--Sorry, Cancellation not done!";
    	exit;
    }
}

public function finance_save($vendor_type,$vendor_type_id,$taxation_type,$service_tax_subtotal,$branch_admin_id)
{
    $row_spec = 'purchase';
    $estimate_id = $_POST['estimate_id'];
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];



    $purchase_gl = get_vendor_cancelation_gl_id($vendor_type, $vendor_type_id);   

    //Getting supplier Ledger
    $sq_sup = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type'"));
    $supplier_gl = $sq_sup['ledger_id'];

    $created_at = date('Y-m-d H:i:s');
	$year1 = explode("-", $created_at);
	$yr1 =$year1[0];

    global $transaction_master;

    $sq_supplier = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));
    $purchase_amount =  $sq_supplier['basic_cost'] + $sq_supplier['non_recoverable_taxes'] + $sq_supplier['service_charge'] + $sq_supplier['other_charges'];
    $reflections = json_decode($sq_supplier['reflections']);
    $service_tax_subtotal = $sq_supplier['service_tax_subtotal'];
    
    ////////////purchase return/////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $purchase_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1),$vendor_type_id);
    $ledger_particular = '';
    $gl_id = $purchase_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

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
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }

    ////// Discount ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $sq_supplier['discount'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1),  $vendor_type_id);
    $ledger_particular = '';
    $gl_id = 37;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////// Commision ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $sq_supplier['our_commission'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1),$vendor_type_id);
    $ledger_particular = '';
    $gl_id = 25;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////// Tds receivable ////////////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $sq_supplier['tds'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1), $vendor_type_id);
    $ledger_particular = '';
    $gl_id = 127;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////////supplier purchase Amount//////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $sq_supplier['net_total'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1), $vendor_type_id);
    $ledger_particular = '';
    $gl_id = $supplier_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1), $vendor_type_id);
    $ledger_particular = '';
    $gl_id = 89;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////supplier Cancel Amount//////
    $module_name = $vendor_type;
    $module_entry_id = $estimate_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_purchase_particular(get_vendor_estimate_id($estimate_id,$yr1), $vendor_type_id);
    $ledger_particular = '';
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND'); 
}

}
?>