<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from package_payment_master where booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id') and amount!=0 ";
if($booking_id!=""){
	$query .=" and booking_id = '$booking_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered table-hover bg_white cust_table" id="package_table1" style="margin: 20px 0 !important">     
  <thead> 
      <tr class="table-heading-row">
           <th>S_No.</th>
           <th>Booking_ID</th>
           <th>Payment_Date</th>
           <th>Mode</th>
           <th>Bank_Name</th>
           <th>Cheque_No/ID</th>
           <th class="text-right success">Amount</th>
           <th>Receipt</th>
      </tr>   
  </thead>
  <tbody>   
  <?php
  $count = 0;
  $bg;

  $sq_pending_amount=0;
  $sq_cancel_amount=0;
  $sq_paid_amount=0;
  $Total_payment=0;

  $sq = mysql_query($query);
  while($row = mysql_fetch_assoc($sq))
  {
   
      $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row[booking_id]'"));			
      $sq_pay = mysql_fetch_assoc(mysql_query("select sum(amount) as sum ,sum(credit_charges) as sumc from package_payment_master where clearance_status!='Cancelled' and booking_id='$row[booking_id]'"));

      $total_sale = $sq_booking['net_total']+$sq_pay['sumc'];
      $total_pay_amt = $sq_pay['sum']+$sq_pay['sumc'];;
      $outstanding =  $total_sale - $total_pay_amt;
      $date = $sq_booking['booking_date'];
      $yr = explode("-", $date);
      $year =$yr[0];
      if($row['clearance_status']=="Pending"){ $bg='warning';
        $sq_pending_amount = $sq_pending_amount + $row['amount']+$row['credit_charges'];
      }

      if($row['clearance_status']=="Cancelled"){ $bg='danger';
        $sq_cancel_amount = $sq_cancel_amount + $row['amount']+$row['credit_charges'];
      }

      if($row['clearance_status']=="Cleared"){ $bg='success';}
      $sq_paid_amount = $sq_paid_amount + $row['amount']+$row['credit_charges'];

      $payment_id_name = "Package Payment ID";
      $date = $row['date'];
      $yr = explode("-", $date);
      $year1 =$yr[0];
      $payment_id = get_package_booking_payment_id($row['payment_id'],$year1);
      $receipt_date = date('d-m-Y');
      $booking_id = get_package_booking_id($row['booking_id'],$year);
      $customer_id = $sq_booking['customer_id'];
      $booking_name = "Package Booking";
      $travel_date = date('d-m-Y',strtotime($sq_booking['tour_from_date']));
      $payment_amount = $row['amount']+$row['credit_charges'];
      $payment_mode1 = $row['payment_mode'];
      $transaction_id = $row['transaction_id'];
      $payment_date = $row['date'];
      $bank_name = $row['bank_name'];
      $receipt_type = ($row['payment_for']=='Travelling') ? "Travel Receipt" : "Tour Receipt";

      $url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&tour=$tour&table_name=package_payment_master&customer_field=booking_id&in_customer_id=$row[booking_id]";
     ?>         
       <tr class="<?= $bg;?>">
         <td><?= ++$count ?></td>
         <td><?= get_package_booking_id($row['booking_id'],$year) ?></td>
         <td> <?php echo date("d-m-Y", strtotime($row['date'])); ?> </td>
         <td> <?php echo $row['payment_mode'] ?> </td>
         <td> <?php echo $row['bank_name'] ?> </td>
         <td> <?php echo $row['transaction_id'] ?> </td>
         <td class="text-right success"> <?php echo number_format($row['amount']+$row['credit_charges'],2) ?> </td>
         <td>
            <a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
         </td>
       </tr>     
     <?php 
  }    
  $total=$sq_paid_amount+$sq_pending_amount+$sq_cancel_amount;
  $total_payment=$total-$sq_pending_amount-$sq_cancel_amount;
  ?>    
  </tbody>
  <tfoot>
    <tr class="active">
      <th colspan="2" class="info text-right">Paid Amount  : <?= number_format($total,2) ?></th>
      <th colspan="2" class="warning text-right">Pending Clearance  : <?= number_format($sq_pending_amount,2)?></th>
      <th colspan="2" class="danger text-right">Cancellation Charges : <?= number_format($sq_cancel_amount,2) ?></th>
      <th colspan="2" class="success text-right">Payment Amount  : <?= number_format($total_payment,2) ?></th>
    </tr>
  </tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#package_table1').dataTable({
  "pagingType": "full_numbers"
});
  
</script>