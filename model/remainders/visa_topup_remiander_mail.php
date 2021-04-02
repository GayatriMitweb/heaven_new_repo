<?php 
include_once('../model.php');
$due_date=date('Y-m-d');

$topup_amount = 0;
$count = 0;
$total_balance_amount = 0;
$total_topup = 0;
$sq_query = mysql_query("select * from visa_vendor");
while($row_query = mysql_fetch_assoc($sq_query))
{
  $count++;          
    $sq_supplier = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as total_amount from visa_supplier_payment where supplier_id='$row_query[vendor_id]' and (clearance_status!='Pending' and clearance_status!='Cancelled')"));
    $sq_supplier1 = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as total_amount1 from vendor_advance_master where vendor_type_id='$row_query[vendor_id]' and vendor_type='Visa Vendor' and (clearance_status!='Pending' and clearance_status!='Cancelled')"));
    
    if ($sq_supplier['total_amount']!=0 || $sq_supplier1['total_amount1']!=0) {
        $topup_amount = $sq_supplier['total_amount'] + $sq_supplier1['total_amount1'];

        $sq_q1 = mysql_fetch_assoc(mysql_query("select sum(net_total) as total_booking from vendor_estimate where vendor_type_id='$row_query[vendor_id]' and vendor_type='Visa Vendor'"));

        $sq_q2 = mysql_fetch_assoc(mysql_query("select sum(refund_net_total) as cancel_booking from vendor_estimate where vendor_type_id='$row_query[vendor_id]' and vendor_type='Visa Vendor'"));

        $booking_amount = $sq_q1['total_booking'] - $sq_q2['cancel_booking'];
        $balance_amount = $topup_amount - $booking_amount;

        if($balance_amount<'50000'){

            $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'visa_topup_recharge_remainder' and date='$due_date' and status='Done'"));

            if($sq_count==0)
            {   
                         
                global $model;
                $row=mysql_query("SELECT max(id) as max from remainder_status");
                $value=mysql_fetch_assoc($row);
                $max=$value['max']+1;
                $sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','visa_topup_recharge_remainder','$due_date','Done')");
                $model->visa_topup_remainder_mail($balance_amount, $row_query['vendor_name'] );
            }
        }
    }
    
}
?>