<?php 
$flag = true;
class booking_master{

public function booking_save()
{
    $customer_id = $_POST['customer_id'];
    $booking_type_id = $_POST['booking_type_id'];
    $booking_specification = $_POST['booking_specification'];
    $basic_cost = $_POST['basic_cost'];
    $service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
    $taxation_id = $_POST['taxation_id'];
    $service_tax = $_POST['service_tax'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $net_total = $_POST['net_total'];

    $payment_date = $_POST['payment_date'];
    $payment_amount = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $bank_name = $_POST['bank_name'];
    $transaction_id = $_POST['transaction_id'];
    $bank_id = $_POST['bank_id'];

    $payment_date = date('Y-m-d', strtotime($payment_date));
    $created_at = date('Y-m-d H:i:s');

    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

    $financial_year_id = $_SESSION['financial_year_id'];

    //**Begin transaction
    begin_t();

    $sq_max = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from miscellaneous_booking_master"));
    $booking_id = $sq_max['max'] + 1;

    $sq_booking = mysql_query("insert into miscellaneous_booking_master (booking_id, customer_id, booking_type_id, booking_specification, basic_cost, service_charge, taxation_type, taxation_id, service_tax, service_tax_subtotal, net_total, created_at) values ('$booking_id', '$customer_id', '$booking_type_id', '$booking_specification', '$basic_cost', '$service_charge', '$taxation_type', '$taxation_id', '$service_tax', '$service_tax_subtotal', '$net_total', '$created_at')");
    if(!$sq_booking){
        $GLOBALS['flag'] = false;
        echo "error--Sorry, Booking not saved!";
    }

    $sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from miscellaneous_payment_master"));
    $payment_id = $sq_max['max'] + 1;

    $sq_payment = mysql_query("insert into miscellaneous_payment_master (payment_id, booking_id, financial_year_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status) values ('$payment_id', '$booking_id', '$financial_year_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status') ");
    if(!$sq_payment){
        $GLOBALS['flag'] = false;
        echo "error--Sorry, Payment not saved!";
    }

    //Finance save
    $this->finance_save($booking_id, $payment_id);

    //Bank/Cash Book
    $this->bank_cash_book_save($booking_id, $payment_id);

    if($GLOBALS['flag']){
        commit_t();
        $this->booking_mail($booking_id, $customer_id);
        $this->booking_sms($booking_id, $customer_id, $created_at);
        echo "Booking saved!";
        exit;
    }
    else{
        rollback_t();
        exit;
    }

    
}

public function finance_save($booking_id, $payment_id)
{
    $customer_id = $_POST['customer_id'];
    $booking_type_id = $_POST['booking_type_id'];
    $booking_specification = $_POST['booking_specification'];
    $basic_cost = $_POST['basic_cost'];
    $service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
    $taxation_id = $_POST['taxation_id'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $net_total = $_POST['net_total'];

    $payment_date = $_POST['payment_date'];
    $payment_amount1 = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $bank_name = $_POST['bank_name'];
    $transaction_id1 = $_POST['transaction_id'];    
    $bank_id1 = $_POST['bank_id'];  

    $payment_date = date('Y-m-d', strtotime($payment_date));
    $created_at = date("Y-m-d");

    $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
    $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
    $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
    $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);

    global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received, $fiance_vars;

    //***========================Booking entries start=============================***//
    //***Sales***//
    $sq_booking_type = mysql_fetch_assoc(mysql_query("select gl_id from miscellaneous_booking_type where booking_type_id='$booking_type_id'"));
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $basic_cost;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $basic_cost, $customer_id);
    $gl_id = $sq_booking_type['gl_id'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**IGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $igst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $igst, $customer_id);
    $gl_id = $fiance_vars['igst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**CGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $cgst, $customer_id);
    $gl_id = $fiance_vars['cgst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**SGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $sgst, $customer_id);
    $gl_id = $fiance_vars['sgst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**UGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $ugst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $ugst, $customer_id);
    $gl_id = $fiance_vars['ugst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**Service charge**//
    $module_name="Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $service_charge, $customer_id);
    $gl_id = $service_charge_received;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //**Sundry debitor**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $net_total;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $net_total, $customer_id);
    $gl_id = $sundry_debitor;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);
    //***========================Booking entries end=============================***//

    //***========================Payment Start=============================***//
    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
    $payment_side = "Debit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = $sundry_debitor;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);
    //***========================Payment end=============================***//

}

public function bank_cash_book_save($booking_id, $payment_id)
{
    global $bank_cash_book_master;

    $customer_id = $_POST['customer_id'];
    $payment_date = $_POST['payment_date'];
    $payment_amount = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $bank_name = $_POST['bank_name'];
    $transaction_id = $_POST['transaction_id']; 
    $bank_id = $_POST['bank_id'];

    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $payment_date = $payment_date;
    $payment_amount = $payment_amount;
    $payment_mode = $payment_mode;
    $bank_name = $bank_name;
    $transaction_id = $transaction_id;
    $bank_id = $bank_id;
    $particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount, $customer_id, $payment_mode, get_miscellaneous_booking_id($visa_id));
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $payment_side = "Credit";
    $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

    $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}

public function booking_mail($booking_id, $customer_id)
{
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
    global $app_name;

    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $email_id = $sq_customer['email_id'];
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];

    $content = '
                <table style="padding:0 30px; width:100%">  
                    <tr>
                        <td colspan="2">
                            <p style="line-height: 23px;">Dear '.$customer_name.',</p>
                            <p style="line-height: 23px;">
                                We would like to Thank you for choosing '.$app_name.'.<br>
                                This is to confirm your booking. We would like to express our gratitude to you for choosing our services.<br>
                                Please find all the details regarding the confirmation of the booking.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <a href="'.BASE_URL.'view/customer/" style="text-decoration: none; background: #2fa6df; padding: 8px 25px; color: #fff; display:inline-block; margin:7px 0;">SIGN IN</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="padding: 5px 0; display: inline-block;border-bottom: 1px dotted #616161;"><strong>Username:</strong> '.$sq_customer['contact_no'].'</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="padding: 5px 0; display: inline-block;border-bottom: 1px dotted #616161;"><strong>Password:</strong> '.$email_id.'</span>
                                    </td>
                                </tr>                               
                            </table>
                        </td>
                        <td style="text-align:right">
                            <img src="'.BASE_URL.'images/email/vacation.png" style="width:175px; height:auto; margin-bottom: -10px;" alt="">
                        </td>
                    </tr>
                            
                    
                </table>
    ';

    $subject = "New Miscellaneous Booking";

    global $model,$backoffice_email_id;
    $model->app_email_master($email_id, $content, $subject);
}

public function booking_sms($booking_id, $customer_id, $created_at){

    $sq_customer_info = mysql_fetch_assoc(mysql_query("select contact_no from customer_master where customer_id='$customer_id'"));
    $mobile_no = $sq_customer_info['contact_no'];

    $message = 'Thank you for booking with '.$app_name.'. Booking No : '.get_miscellaneous_booking_id($booking_id).'  Date :'.$created_at;
    global $model, $app_name;  
    $model->send_message($mobile_no, $message);  
}


public function booking_update()
{
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];
    $booking_type_id = $_POST['booking_type_id'];
    $booking_specification = $_POST['booking_specification'];
    $basic_cost = $_POST['basic_cost'];
    $service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
    $taxation_id = $_POST['taxation_id'];
    $service_tax = $_POST['service_tax'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $net_total = $_POST['net_total'];

    //**Begin transaction
    begin_t();

    //Old Booking info
    $sq_booking_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_booking_master where booking_id='$booking_id'"));

    $sq_booking = mysql_query("update miscellaneous_booking_master set customer_id='$customer_id', booking_type_id='$booking_type_id', booking_specification='$booking_specification', basic_cost='$basic_cost', service_charge='$service_charge', taxation_type='$taxation_type', taxation_id='$taxation_id', service_tax='$service_tax', service_tax_subtotal='$service_tax_subtotal', net_total='$net_total' where booking_id='$booking_id'");

    if(!$sq_booking){
        $GLOBALS['flag'] = false;
        echo "error--Booking not updated!";     
    }

    //Finance update
    $this->finance_update($sq_booking_info);

    if($GLOBALS['flag']){
        commit_t();
        echo "Booking updated!";
        exit;
    }
    else{
        rollback_t();
        exit;
    }
}

public function finance_update($sq_booking_info)
{
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];
    $booking_type_id = $_POST['booking_type_id'];
    $basic_cost = $_POST['basic_cost'];
    $service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
    $taxation_id = $_POST['taxation_id'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $net_total = $_POST['net_total'];

    $created_at = $sq_booking_info['created_at'];

    $igst = get_igst_cost($service_tax_subtotal, $taxation_type);
    $cgst = get_cgst_cost($service_tax_subtotal, $taxation_type);
    $sgst = get_sgst_cost($service_tax_subtotal, $taxation_type);
    $ugst = get_ugst_cost($service_tax_subtotal, $taxation_type);

    global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received, $fiance_vars;

    //***Sales***//
    $sq_booking_type_old = mysql_fetch_assoc(mysql_query("select gl_id from miscellaneous_booking_type where booking_type_id='$sq_booking_info[booking_type_id]'"));
    $sq_booking_type = mysql_fetch_assoc(mysql_query("select gl_id from miscellaneous_booking_type where booking_type_id='$booking_type_id'"));
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $basic_cost;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $basic_cost, $customer_id);
    $old_gl_id = $sq_booking_type_old['gl_id'];
    $gl_id = $sq_booking_type['gl_id'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    if($sq_booking_info['refund_net_total']!=""){
        $sq_fianance = mysql_query("update finance_transaction_master set gl_id='$sq_booking_type[gl_id]' where module_name='Miscellaneous Booking' and module_entry_id='$booking_id' and gl_id='$sq_booking_type_old[gl_id]' and payment_side='Debit' ");
        if(!$sq_fianance){
            $GLOBALS['flag'] = false;
            echo "error--Error in fianance!";
        }
    }



    //**IGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $igst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $igst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['igst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    //**CGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $cgst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['cgst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    //**SGST*//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $sgst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['sgst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    //**UGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $ugst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $ugst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['ugst'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    //**Service charge**//
    $module_name="Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $service_charge, $customer_id);
    $old_gl_id = $gl_id = $service_charge_received;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $net_total;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $net_total, $customer_id);
    $old_gl_id = $gl_id = $sundry_debitor;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);


}

}
?>