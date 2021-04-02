<?php
include_once('../model.php');
global $model;
$today=date('Y-m-d');
$sq_booking = mysql_query("select * from b2b_booking_master where 1");
while($row_booking = mysql_fetch_assoc($sq_booking)){
    $sq_regs = mysql_fetch_assoc(mysql_query("select register_id,email_id,cp_first_name,cp_last_namefrom b2b_registration where customer_id='$row_booking[customer_id]' and approval_status='Approved'"));
    $sq_count = mysql_num_rows(mysql_query("select credit_amount from b2b_creditlimit_master where register_id='$sq_regs[register_id]' and approval_status='Approved'"));
    if($sq_count != 0){
        $hotel_total = 0;
        $cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
        for($i=0;$i<sizeof($cart_checkout_data);$i++){
            $tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
            for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
                $room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
                $room_cost = $room_types[2];
                
                $tax_amount = ($room_cost * $tax_arr[1] / 100);
                $total_amount = $room_cost + $tax_amount;
            
                $hotel_total += $total_amount;
            }
        }
        if($row_booking['coupon_code'] != ''){
            $sq_coupon = mysql_fetch_assoc(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
            if($sq_coupon['offer']=="Flat"){
                $hotel_total = $hotel_total - $sq_coupon['offer_amount'];
            }else{
                $hotel_total = $hotel_total - ($hotel_total*$sq_coupon['offer_amount']/100);
            }
            
        }
        //Paid Amount
        $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_booking[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
        $payment_amount = $sq_payment_info['sum'];
        $booking_outstanding = $hotel_total - $sq_payment_info['sum'];
        if($booking_outstanding>0){
            // Get Approved Credit Limit Amount
            $sq_credit = mysql_fetch_assoc(mysql_query("select credit_amount,payment_days from b2b_creditlimit_master where register_id='$sq_regs[register_id]' and approval_status='Approved' order by entry_id desc"));
            //Overdue checking
            $booking_date = get_date_db($row_booking['created_at']);
            $payment_date = date('Y-m-d', strtotime("+".$sq_credit['payment_days']." days",strtotime($booking_date)));
            //Date comparison
            if($today>$payment_date && $booking_outstanding>0){
                $yr = explode("-", $booking_date);
                $invoice_no = get_b2b_booking_id($row_booking['booking_id'],$yr[0]);
                email($invoice_no,$sq_regs['cp_first_name'].' '.$sq_regs['cp_last_name'],$booking_outstanding,$sq_regs['email_id']);
            }
        }
    }
}
function email($invoice_no,$name,$booking_outstanding,$email_id){
    
    $content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Booking ID </td>   <td style="text-align:left;border: 1px solid #888888;">'.$invoice_no.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Outstanding Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.number_format($booking_outstanding,2).'</td></tr>
              
            </table>
          </tr>';
    global $model;
    $subject = 'Credit Payment Overdue Reminder : '.$app_name;
    $model->app_email_send('115',$name,$email_id, $content, $subject);
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','b2b_credit_payment_overdue','$today','Done')");
?>