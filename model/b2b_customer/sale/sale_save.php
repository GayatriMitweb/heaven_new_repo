<?php include "../../model.php";
class b2b_sale{
    function save(){
    
        $financial_year_id = $_SESSION['financial_year_id'];

        $payment_amount = $_POST['payment_amount'];
        $global_currency = $_POST['global_currency'];
        //Contact Person Details
        $customer_id = $_POST['customer_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email_id = $_POST['email_id'];
        $country_id = $_POST['country_id'];
        $country_code = $_POST['country_code'];
        $contact_no = $_POST['contact_no'];
        $sp_request = $_POST['sp_request'];
        $phone_contact = $country_code.$contact_no;

        //Cart and traveller details
        $cart_checkout_data = $_POST['cart_checkout_data'];
        $traveller_details = $_POST['traveller_details'];
        $timing_slots = $_POST['timing_slots'];
        $coupon_code = $_POST['coupon_code'];
        
        //PUT ALL IN SESSION
        $_SESSION['payment_amount'] = $payment_amount;
        $_SESSION['global_currency'] = $global_currency;
        //Contact Person Details
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['email_id'] = $email_id;
        $_SESSION['country_id'] = $country_id;
        $_SESSION['phone_contact'] = $phone_contact;
        $_SESSION['sp_request'] = $sp_request;

        $_SESSION['cart_checkout_data'] = $cart_checkout_data;
        $_SESSION['traveller_details'] = $traveller_details;
        $_SESSION['coupon_code'] = $coupon_code;
        $_SESSION['timing_slots'] = $timing_slots;
        
        $sq_settings = mysql_fetch_assoc(mysql_query("select payment_gateway from b2b_settings_second"));
        $payment_gateway = json_decode($sq_settings['payment_gateway']);
        echo $payment_gateway[0]->name;
    }
    
    function success_save(){
            
        //Get default currency rate
        global $currency;
        $sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
        $to_currency_rate = $sq_to['currency_rate'];
        
        $financial_year_id = $_SESSION['financial_year_id'];
        $register_id = $_SESSION['register_id'];
        
        //GET ALL IN SESSION
        $payment_amount = $_SESSION['payment_amount'];
        $global_currency = $_SESSION['global_currency'];
        //Contact Person Details
        $customer_id = $_SESSION['customer_id'];
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $email_id = $_SESSION['email_id'];
        $country_id = $_SESSION['country_id'];
        $phone_contact = $_SESSION['phone_contact'];
        $sp_request = $_SESSION['sp_request'];

        $cart_checkout_data = $_SESSION['cart_checkout_data'];
        $traveller_details = $_SESSION['traveller_details'];
        $coupon_code = $_SESSION['coupon_code'];
        $timing_slots = $_SESSION['timing_slots'];
        
        $cart_checkout_data = json_encode($cart_checkout_data,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        $traveller_details = json_encode($traveller_details,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

        $payment_details = $_SESSION['payment_details'];
        $payment_details = json_encode($payment_details);

        $used_at = date("Y-m-d H:i:s");
        //Sale save
        $sq_max = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from b2b_booking_master"));
        $booking_id = $sq_max['max'] + 1;
        $sq_save = mysql_query("INSERT INTO `b2b_booking_master`(`booking_id`, `customer_id`,`financial_year_id`, `fname`, `lname`, `email_id`, `country_id`, `contact_no`, `sp_request`, `cart_checkout_data`, `coupon_code`, `traveller_details`,`timing_slots`, `created_at`) VALUES ('$booking_id','$customer_id','$financial_year_id','$fname','$lname','$email_id','$country_id','$phone_contact','$sp_request','$cart_checkout_data','$coupon_code','$traveller_details','$timing_slots','$used_at')");

        if($sq_save){
            $sq_update = mysql_query("UPDATE `b2b_registration` SET `cart_data`='',`request_id`='0' WHERE register_id='$register_id'");
            //Coupon code applied
            if($coupon_code != ''){
                $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_coupons_applied"));
                $entry_id = $sq_max['max'] + 1;
                $sq_coupon = mysql_query("insert into b2b_coupons_applied (entry_id, customer_id, coupon_code, status, used_at) values ('$entry_id', '$customer_id','$coupon_code','used','$used_at')");
            }
            //Payment Details
            $sq_settings = mysql_fetch_assoc(mysql_query("select payment_gateway from b2b_settings_second"));
            $payment_gateway = json_decode($sq_settings['payment_gateway']);
            $bank_id = $payment_gateway[0]->bank_id;
            $payment_details = json_decode($payment_details);
            $payment_date = get_date_db($used_at);
            $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_payment_master"));
            $entry_id1 = $sq_max['max'] + 1;
            $sq_payment = mysql_query("insert into b2b_payment_master (`entry_id`, `payment_id`, `booking_id`, `branch_admin_id`, `financial_year_id`, `payment_date`, `payment_amount`, `payment_mode`,`bank_id`, `order_id`,`signature`) values ('$entry_id1','$payment_details->payment_id' ,'$booking_id', '1', '$financial_year_id', '$payment_date', '$payment_details->payment_amount', 'Online','$bank_id', '$payment_details->order_id', '$payment_details->signature') ");

            // ////////////// Accoutning Reflections///////////////////////////////////////////////
            $cart_checkout_data = json_decode($cart_checkout_data);
            $total_hotel_cost = 0;$total_transfer_cost = 0;$total_activity_cost = 0;$total_tour_cost = 0;
            $total_hotel_tax = 0; $total_transfer_tax = 0; $total_activity_tax = 0; $total_tour_tax = 0; 
            $total_cost = 0;
            $hotel_list_arr = array();
            $transfer_list_arr = array();
            $activity_list_arr = array();
            $tours_list_arr = array();
            for($i=0;$i<sizeof($cart_checkout_data);$i++){
                if($cart_checkout_data[$i]->service->name == 'Hotel'){
                    array_push($hotel_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Transfer'){
                    array_push($transfer_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Activity'){
                    array_push($activity_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
                    array_push($tours_list_arr,$cart_checkout_data[$i]);
                }
            }
            for($i=0;$i<sizeof($hotel_list_arr);$i++){
                $tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
                $tax_amount = 0;
                for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
                    $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
                    $room_cat = $room_types[1];
                    $room_cost = $room_types[2];
                    $h_currency_id = $room_types[3];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
                    $hotel_tax_ledger = $tax_arr[1];
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                    $total_hotel_cost += $room_cost1;
                    $total_hotel_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$transfer_list_arr[$i]->service->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->transfer_cost);
                    $room_cost = $transfer_cost[0];
                    $h_currency_id = $transfer_cost[1];

                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $transfer_tax_ledger = $tax_arr[1];
                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_transfer_cost += $room_cost1;
                    $total_transfer_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($activity_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$activity_list_arr[$i]->service->service_arr[$j]->transfer_type);
                    $room_cost = $transfer_cost[1];
                    $h_currency_id = $transfer_cost[2];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $activity_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_activity_cost += $room_cost1;
                    $total_activity_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($tours_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[$j]->taxation);
                    $room_cost = $tours_list_arr[$i]->service->service_arr[$j]->total_cost;
                    $h_currency_id = $tours_list_arr[$i]->service->service_arr[$j]->currency_id;
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $tour_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_tour_cost += $room_cost1;
                    $total_tour_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            if($coupon_code != ''){
                $sq_coupon = mysql_fetch_assoc(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$coupon_code'"));
                if($sq_coupon['offer']=="Flat"){
                    $total_cost = $total_cost - $sq_coupon['offer_amount'];
                }else{
                    $total_cost = $total_cost - ($total_cost*$sq_coupon['offer_amount']/100);
                }
                
            }
            ///////////////////////////////////////////////////////////////////////////////
            //Finance save
            $this->finance_save($booking_id,$total_cost,$used_at,'Online',$total_cost,$customer_id,$bank_id,$total_hotel_cost,$total_transfer_cost,$total_activity_cost,$total_tour_cost,$hotel_tax_ledger,$transfer_tax_ledger,$activity_tax_ledger,$tour_tax_ledger,$total_hotel_tax,$total_transfer_tax,$total_activity_tax,$total_tour_tax);
            //Bank and Cash Book Save
            $this->bank_cash_book_save($booking_id,$used_at,'Online',$payment_amount,$customer_id,$entry_id1,$bank_id);
            //Acnowledgement mail
            $sq_cust = mysql_fetch_assoc(mysql_query("select email_id,company_name from customer_master where customer_id='$customer_id'"));
            $this->send_ack_agent_mail($sq_cust['company_name'], $sq_cust['email_id'],$cart_checkout_data);
            //Redirection to index page
            // echo "Booking saved successfully!";
            header("Location: ".BASE_URL ."Tours_B2B/view/index.php");
        }
        else{
            echo 'error--Sale not saved!';
        }
    }

    public function finance_save($booking_id,$total_cost,$used_at,$payment_mode,$payment_amount1,$customer_id,$bank_id1,$total_hotel_cost,$total_transfer_cost,$total_activity_cost,$total_tour_cost,$hotel_tax_ledger,$transfer_tax_ledger,$activity_tax_ledger,$tour_tax_ledger,$total_hotel_tax,$total_transfer_tax,$total_activity_tax,$total_tour_tax)
    {
        $row_spec = 'sales';
        $branch_admin_id = 1;
        $booking_date = date("Y-m-d");
        $year1 = explode("-", $booking_date);
        $yr1 = $year1[0];
        
        //Getting customer Ledger
        $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
        $cust_gl = $sq_cust['ledger_id'];

        //Getting cash/Bank Ledger
        if($payment_mode == 'Cash') {  $pay_gl = 20; }
        else{ 
            $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
            $pay_gl = $sq_bank['ledger_id'];
        } 

        global $transaction_master;
        ////////Total Amount//////
        $module_name = "B2B Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $total_cost;
        $payment_date = $booking_date;
        $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_cost, $customer_id);
        $ledger_particular = get_ledger_particular('To','B2B Sales');
        $gl_id = $cust_gl;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

        ////////////Hotel Sales/////////////
        if($total_hotel_cost != 0){
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_hotel_cost;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_cost, $customer_id);
            $ledger_particular = get_ledger_particular('To','B2B Sales');
            $gl_id = 63;
            $payment_side = "Credit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
        }
        //Hotel Tax Amount
        if($total_hotel_tax != 0){
            $hotel_tax_ledgers = explode(',',$hotel_tax_ledger);
            $total_hotel_tax1 = $total_hotel_tax / 2;
            if(sizeof($hotel_tax_ledgers) == 1){
                // Credit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_hotel_tax;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_tax, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $hotel_tax_ledgers[0];
                $payment_side = "Credit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
            }
            else{
                for($i=0;$i<sizeof($hotel_tax_ledgers);$i++){
                    // Credit
                    $module_name = "B2B Booking";
                    $module_entry_id = $booking_id;
                    $transaction_id = "";
                    $payment_amount = $total_hotel_tax1;
                    $payment_date = $booking_date;
                    $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_hotel_tax1, $customer_id);    
                    $ledger_particular = get_ledger_particular('By','Cash/Bank');
                    $gl_id = $hotel_tax_ledgers[$i];
                    $payment_side = "Credit";
                    $clearance_status = "";
                    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                }
            }
        }

        ////////////Trasnfer Sale/////////////
        if($total_transfer_cost != 0){
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_transfer_cost;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_cost, $customer_id);
            $ledger_particular = get_ledger_particular('To','B2B Sales');
            $gl_id = 18;
            $payment_side = "Credit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
        }
        //Transfer Tax Amount
        if($total_transfer_tax != 0){
            $transfer_tax_ledgers = explode(',',$transfer_tax_ledger);
            $total_transfer_tax1 = $total_transfer_tax / 2;
            if(sizeof($transfer_tax_ledgers) == 1){
                // Credit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_transfer_tax;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_tax, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $transfer_tax_ledgers[0];
                $payment_side = "Credit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
            }
            else{
                for($i=0;$i<sizeof($transfer_tax_ledgers);$i++){
                    // Credit
                    $module_name = "B2B Booking";
                    $module_entry_id = $booking_id;
                    $transaction_id = "";
                    $payment_amount = $total_transfer_tax1;
                    $payment_date = $booking_date;
                    $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_transfer_tax1, $customer_id);    
                    $ledger_particular = get_ledger_particular('By','Cash/Bank');
                    $gl_id = $transfer_tax_ledgers[$i];
                    $payment_side = "Credit";
                    $clearance_status = "";
                    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                }
            }
        }

        ////////////Activity Sale/////////////
        if($total_activity_cost != 0){
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_activity_cost;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_cost, $customer_id);
            $ledger_particular = get_ledger_particular('To','B2B Sales');
            $gl_id = 44;
            $payment_side = "Credit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
        }
        //Activity Tax Amount
        if($total_activity_tax != 0){
            $activity_tax_ledgers = explode(',',$activity_tax_ledger);
            $total_activity_tax1 = $total_activity_tax / 2;
            if(sizeof($activity_tax_ledgers) == 1){
                // Credit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_activity_tax;
                $payment_date = $booking_date;
                $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_tax, $customer_id);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $activity_tax_ledgers[0];
                $payment_side = "Credit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
            }
            else{
                for($i=0;$i<sizeof($activity_tax_ledgers);$i++){
                    // Credit
                    $module_name = "B2B Booking";
                    $module_entry_id = $booking_id;
                    $transaction_id = "";
                    $payment_amount = $total_activity_tax1;
                    $payment_date = $booking_date;
                    $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_activity_tax1, $customer_id);    
                    $ledger_particular = get_ledger_particular('By','Cash/Bank');
                    $gl_id = $activity_tax_ledgers[$i];
                    $payment_side = "Credit";
                    $clearance_status = "";
                    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                }
            }
        }
        
        ////////////Package Sale/////////////
        if($total_tour_cost != 0){
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = "";
            $payment_amount = $total_tour_cost;
            $payment_date = $booking_date;
            $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_tour_cost, $customer_id);
            $ledger_particular = get_ledger_particular('To','B2B Sales');
            $gl_id = 91;
            $payment_side = "Credit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
        }
        //Transfer Tax Amount
        if($total_tour_tax != 0){
            $tour_tax_ledgers = explode(',',$tour_tax_ledger);
            $total_tour_tax1 = $total_tour_tax / 2;
            if(sizeof($tour_tax_ledgers) == 1){
                // Credit
                $module_name = "B2B Booking";
                $module_entry_id = $booking_id;
                $transaction_id = "";
                $payment_amount = $total_tour_tax;
                $payment_date = $booking_date;
                $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($booking_id), $expense_type, $booking_date, $total_tour_tax, $payment_mode);    
                $ledger_particular = get_ledger_particular('By','Cash/Bank');
                $gl_id = $tour_tax_ledgers[0];
                $payment_side = "Credit";
                $clearance_status = "";
                $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
            }
            else{
                for($i=0;$i<sizeof($tour_tax_ledgers);$i++){
                    // Credit
                    $module_name = "B2B Booking";
                    $module_entry_id = $booking_id;
                    $transaction_id = "";
                    $payment_amount = $total_tour_tax1;
                    $payment_date = $booking_date;
                    $payment_particular = get_sales_particular(get_b2b_booking_id($booking_id,$yr1), $booking_date, $total_tour_tax1, $customer_id);    
                    $ledger_particular = get_ledger_particular('By','Cash/Bank');
                    $gl_id = $tour_tax_ledgers[$i];
                    $payment_side = "Credit";
                    $clearance_status = "";
                    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
                }
            }
        }

        if($payment_amount1 != 0){
            //////Bank Payment Amount///////
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = '';
            $payment_amount = $payment_amount1;
            $payment_date = $booking_date;
            $payment_particular = get_sales_paid_particular('', $booking_date, $payment_amount1, $customer_id, '', get_b2b_booking_id($booking_id,$yr1),'',''); 
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $pay_gl;
            $payment_side = "Debit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK RECEIPT');

            //////Customer Payment Amount///////
            $module_name = "B2B Booking";
            $module_entry_id = $booking_id;
            $transaction_id = '';
            $payment_amount = $payment_amount1;
            $payment_date = $booking_date;
            $payment_particular = get_sales_paid_particular('', $booking_date, $payment_amount1, $customer_id, '', get_b2b_booking_id($booking_id,$yr1),'','');
            $ledger_particular = get_ledger_particular('By','Cash/Bank');
            $gl_id = $cust_gl;
            $payment_side = "Credit";
            $clearance_status = "";
            $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK RECEIPT');
        }

    }

    function credit_sale_save(){
        $financial_year_id = $_SESSION['financial_year_id'];
        $register_id = $_SESSION['register_id'];
        global $currency;
        $sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
        $to_currency_rate = $sq_to['currency_rate'];

        $global_currency = $_POST['global_currency'];
        //Contact Person Details
        $customer_id = $_POST['customer_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email_id = $_POST['email_id'];
        $country_id = $_POST['country_id'];
        $country_code = $_POST['country_code'];
        $contact_no = $_POST['contact_no'];
        $phone_contact = $country_code.$contact_no;
        $sp_request = $_POST['sp_request'];

        $cart_checkout_data = $_POST['cart_checkout_data'];
        $traveller_details = $_POST['traveller_details'];
        $coupon_code = $_POST['coupon_code'];
        $timing_slots = $_POST['timing_slots'];
        $cart_checkout_data = json_encode($cart_checkout_data,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        $traveller_details = json_encode($traveller_details,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

        $payment_details = '';
        $used_at = date("Y-m-d H:i:s");

        //Sale save
        $sq_max = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from b2b_booking_master"));
        $booking_id = $sq_max['max'] + 1;
        $sq_save = mysql_query("INSERT INTO `b2b_booking_master`(`booking_id`, `customer_id`,`financial_year_id`, `fname`, `lname`, `email_id`, `country_id`, `contact_no`, `sp_request`, `cart_checkout_data`, `coupon_code`, `traveller_details`,`timing_slots`, `created_at`) VALUES ('$booking_id','$customer_id','$financial_year_id','$fname','$lname','$email_id','$country_id','$phone_contact','$sp_request','$cart_checkout_data','$coupon_code','$traveller_details','$timing_slots','$used_at')");

        if($sq_save){
            $sq_update = mysql_query("UPDATE `b2b_registration` SET `cart_data`='',`request_id`='0' WHERE register_id='$register_id'");
            //Coupon code applied
            if($coupon_code != ''){
                $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_coupons_applied"));
                $entry_id = $sq_max['max'] + 1;
                $sq_coupon = mysql_query("insert into b2b_coupons_applied (entry_id, customer_id, coupon_code, status, used_at) values ('$entry_id', '$customer_id','$coupon_code','used','$used_at')");
            }

            // ////////////// Accoutning Reflections/////////////////
            $cart_checkout_data = json_decode($cart_checkout_data);
            $total_hotel_cost = 0;$total_transfer_cost = 0;$total_activity_cost = 0;$total_tour_cost = 0;
            $total_hotel_tax = 0; $total_transfer_tax = 0; $total_activity_tax = 0; $total_tour_tax = 0; 
            $total_cost = 0;
            $hotel_list_arr = array();
            $transfer_list_arr = array();
            $activity_list_arr = array();
            $tours_list_arr = array();
            for($i=0;$i<sizeof($cart_checkout_data);$i++){
                if($cart_checkout_data[$i]->service->name == 'Hotel'){
                    array_push($hotel_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Transfer'){
                    array_push($transfer_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Activity'){
                    array_push($activity_list_arr,$cart_checkout_data[$i]);
                }
                if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
                    array_push($tours_list_arr,$cart_checkout_data[$i]);
                }
            }
            for($i=0;$i<sizeof($hotel_list_arr);$i++){
                $tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
                $tax_amount = 0;
                for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
                    $room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
                    $room_cat = $room_types[1];
                    $room_cost = $room_types[2];
                    $h_currency_id = $room_types[3];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $total_amount = $room_cost + $tax_amount;
                    $hotel_tax_ledger = $tax_arr[1];
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                    $total_hotel_cost += $room_cost1;
                    $total_hotel_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$transfer_list_arr[$i]->service->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$transfer_list_arr[$i]->service->service_arr[$j]->transfer_cost);
                    $room_cost = $transfer_cost[0];
                    $h_currency_id = $transfer_cost[1];

                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $transfer_tax_ledger = $tax_arr[1];
                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_transfer_cost += $room_cost1;
                    $total_transfer_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($activity_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[$j]->taxation);
                    $transfer_cost = explode('-',$activity_list_arr[$i]->service->service_arr[$j]->transfer_type);
                    $room_cost = $transfer_cost[1];
                    $h_currency_id = $transfer_cost[2];
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $activity_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_activity_cost += $room_cost1;
                    $total_activity_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            for($i=0;$i<sizeof($tours_list_arr);$i++){
                //Applied Tax
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    $tax_amount = 0;
                    $tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[$j]->taxation);
                    $room_cost = $tours_list_arr[$i]->service->service_arr[$j]->total_cost;
                    $h_currency_id = $tours_list_arr[$i]->service->service_arr[$j]->currency_id;
                    
                    $tax_arr1 = explode('+',$tax_arr[0]);
                    for($t=0;$t<sizeof($tax_arr1);$t++){
                        if($tax_arr1[$t]!=''){
                            $tax_arr2 = explode(':',$tax_arr1[$t]);
                            if($tax_arr2[2] == "Percentage"){
                            $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                            }else{
                            $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                            }
                        }
                    }
                    $tour_tax_ledger = $tax_arr[1];

                    $total_amount = $room_cost + $tax_amount;
                    //Convert into default currency
                    $sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
                    $from_currency_rate = $sq_from['currency_rate'];
                    $room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
                    $tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
                    $total_amount1 = ($from_currency_rate / $to_currency_rate * $total_amount);

                    $total_tour_cost += $room_cost1;
                    $total_tour_tax += $tax_amount1;
                    $total_cost += $total_amount1;
                }
            }
            if($coupon_code != ''){
                $sq_coupon = mysql_fetch_assoc(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$coupon_code'"));
                if($sq_coupon['offer']=="Flat"){
                    $total_cost = $total_cost - $sq_coupon['offer_amount'];
                }else{
                    $total_cost = $total_cost - ($total_cost*$sq_coupon['offer_amount']/100);
                }
                
            }
            ///////////////////////////////////////////////////////////////////////////////
            //Finance save
            $this->finance_save($booking_id,$total_cost,$used_at,'Cash','0',$customer_id,$bank_id,$total_hotel_cost,$total_transfer_cost,$total_activity_cost,$total_tour_cost,$hotel_tax_ledger,$transfer_tax_ledger,$activity_tax_ledger,$tour_tax_ledger,$total_hotel_tax,$total_transfer_tax,$total_activity_tax,$total_tour_tax);

            //Acnowledgement mail
            $sq_cust = mysql_fetch_assoc(mysql_query("select email_id,company_name from customer_master where customer_id='$customer_id'"));
            $this->send_ack_agent_mail($sq_cust['company_name'], $sq_cust['email_id'],$cart_checkout_data);
            echo 'Booking saved successfully.Thank you so much!';
            header("Location: ".BASE_URL ."Tours_B2B/view/index.php");
        }
        else{
            echo 'error--Sale not saved!';
        }
    }
    public function bank_cash_book_save($booking_id,$used_at,$payment_mode,$payment_amount,$customer_id,$payment_id,$bank_id)
    {
        global $bank_cash_book_master;
        $payment_date = date("Y-m-d", strtotime($used_at));
        $year1 = explode("-", $payment_date);
        $yr1 =$year1[0];
        //Get Customer id
        if($customer_id == '0'){
            $sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
            $customer_id = $sq_max['max'];
        }
        $module_name = "B2B Booking";
        $module_entry_id = $payment_id;
        $payment_date = $payment_date;
        $payment_amount = $payment_amount;
        $payment_mode = $payment_mode;
        $bank_name = $bank_name;
        $transaction_id = $transaction_id;
        $bank_id = $bank_id;
        $particular = get_sales_paid_particular('', $payment_date, $payment_amount, $customer_id, '', get_b2b_booking_id($booking_id,$yr1),'','');
        $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
        $payment_side = "Debit";
        $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

        $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type,'1');
    }

    function send_ack_agent_mail($company_name,$email_id,$cart_checkout_data)
    {    
        global $model,$app_name,$b2b_index_url,$encrypt_decrypt, $secret_key;
        $email_id = $encrypt_decrypt->fnDecrypt($email_id, $secret_key);
        $hotel_list_arr = array();
        $transfer_list_arr = array();
        $activity_list_arr = array();
        $tours_list_arr = array();
        for($i=0;$i<sizeof($cart_checkout_data);$i++){
          if($cart_checkout_data[$i]->service->name == 'Hotel'){
            array_push($hotel_list_arr,$cart_checkout_data[$i]);
          }
          if($cart_checkout_data[$i]->service->name == 'Transfer'){
            array_push($transfer_list_arr,$cart_checkout_data[$i]);
          }
          if($cart_checkout_data[$i]->service->name == 'Activity'){
            array_push($activity_list_arr,$cart_checkout_data[$i]);
          }
          if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
            array_push($tours_list_arr,$cart_checkout_data[$i]);
          }
        }
        $content = '';
        $hotel_content ='';
        $transfer_content ='';
        $activity_content ='';
        $tours_content ='';
        //Hotel
        if(sizeof($hotel_list_arr)>0){
            $hotel_content .= '<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td colspan="2">Hotel Information</td></tr>
            </table>
            </tr>';
            for($i=0;$i<sizeof($hotel_list_arr);$i++){
            $hotel_content .= '
            <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$hotel_list_arr[$i]->service->hotel_arr->hotel_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckIn Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_date_user($hotel_list_arr[$i]->service->check_in).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckOut Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($hotel_list_arr[$i]->service->check_out).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Total Rooms</td>   <td style="text-align:left;border: 1px solid #888888;" >'.sizeof($hotel_list_arr[$i]->service->item_arr).'</td></tr>
            </table>
            </tr>';
            }
        }
        //Transfer
        if(sizeof($transfer_list_arr)>0){
            $transfer_content .= '<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td colspan="2">Transfer Information</td></tr>
            </table>
            </tr>';
            for($i=0;$i<sizeof($transfer_list_arr);$i++){
                for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
                    //Pickup n drop location
                    $pickup_id = $transfer_list_arr[$i]->service->service_arr[$j]->pickup_from;
                    if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'city'){
                      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$pickup_id'"));
                      $pickup = $row['city_name'];
                    }
                    else if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'hotel'){
                      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
                      $pickup = $row['hotel_name'];
                    }
                    else{
                      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
                      $airport_nam = clean($row['airport_name']);
                      $airport_code = clean($row['airport_code']);
                      $pickup = $airport_nam." (".$airport_code.")";
                    }
                    //Drop-off
                    $drop_id = $transfer_list_arr[$i]->service->service_arr[$j]->drop_to;
                    if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'city'){
                      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$drop_id'"));
                      $drop = $row['city_name'];
                    }
                    else if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'hotel'){
                      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
                      $drop = $row['hotel_name'];
                    }
                    else{
                      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
                      $airport_nam = clean($row['airport_name']);
                      $airport_code = clean($row['airport_code']);
                      $drop = $airport_nam." (".$airport_code.")";
                    }
                    $transfer_content .= '
                    <tr>
                        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Vehicle Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$transfer_list_arr[$i]->service->service_arr[$j]->vehicle_name.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Pickup Location</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$pickup.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Drop Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$drop.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Total Vehicles</td>   <td style="text-align:left;border: 1px solid #888888;" >'.sizeof($transfer_list_arr[$i]->service->service_arr[$j]->no_of_vehicles).'</td></tr>
                    </table>
                    </tr>';
                }
            }
        }

        //Activity
        if(sizeof($activity_list_arr)>0){
            $activity_content .= '<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td colspan="2">Activity Information</td></tr>
            </table>
            </tr>';
            for($i=0;$i<sizeof($activity_list_arr);$i++){
                $activity_content .= '
                    <tr>
                        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Activity Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$activity_list_arr[$i]->service->service_arr[0]->act_name.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Check-Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_date_user($activity_list_arr[$i]->service->service_arr[0]->checkDate).'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Pickup Point</td>   <td style="text-align:left;border: 1px solid #888888;">'.$activity_list_arr[$i]->service->service_arr[0]->pick_point.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Reporting Time</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$activity_list_arr[$i]->service->service_arr[0]->rep_time.'</td></tr>
                        </table>
                    </tr>';
            }
        }
        //Combo Tours
        if(sizeof($tours_list_arr)>0){
            $tours_content .= '<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td colspan="2">Combo Tours Information</td></tr>
            </table>
            </tr>';
            for($i=0;$i<sizeof($tours_list_arr);$i++){
                $tours_content .= '
                    <tr>
                        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tours_list_arr[$i]->service->service_arr[0]->package.'('.$tours_list_arr[$i]->service->service_arr[0]->package_code.')'.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Travel-Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_date_user($tours_list_arr[$i]->service->service_arr[0]->travel_date).'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Total Stay</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tours_list_arr[$i]->service->service_arr[0]->nights.'N/'.$tours_list_arr[$i]->service->service_arr[0]->days.'D'.'</td></tr>
                        </table>
                    </tr>';
            }
        }

        $content .= $hotel_content.$transfer_content.$activity_content.$tours_content;
        $subject = 'B2B Portal Booking Acknowledgement! : '.$app_name;
        $model->app_email_send('114',$company_name,$email_id,$content,$subject,'');   
    }
    function voucher_details_save(){
        $booking_id = $_POST['booking_id'];
        if($_POST['conf_numbers'] != ''){
            $confirmation_no_details = mysql_real_escape_string(json_encode($_POST['conf_numbers']));
            mysql_query("UPDATE `b2b_booking_master` SET `confirmation_no_details` = '$confirmation_no_details' WHERE `booking_id` = '$booking_id'");
        }
        if($_POST['activity_times'] != ''){
            $activity_timing = mysql_real_escape_string(implode(',',$_POST['activity_times']));
            mysql_query("UPDATE `b2b_booking_master` SET `timing_slots` = '$activity_timing' WHERE `booking_id` = '$booking_id'");
            echo "UPDATE `b2b_booking_master` SET `timing_slots` = '$activity_timing' WHERE `booking_id` = '$booking_id'";
        }
    }
}
?>