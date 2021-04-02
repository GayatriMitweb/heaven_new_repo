<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from package_tour_booking_master where customer_id='$customer_id' ";
if($booking_id!=""){
	$query .=" and booking_id = '$booking_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
  
<table class="table table-bordered table-hover bg_white cust_table" id="package_table" style="margin: 20px 0 !important;">
  <thead>
    <tr class="table-heading-row">
      <th>S_No.</th>
      <th>Booking_ID</th>
      <th>Tour_Name</th>
      <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;</th>
      <th>View</th>
      <th class="text-right info">Total_Amount</th>
      <th class="text-right success">Paid_Amount</th>
      <th class="text-right danger">Cancel_Amount</th>
      <th class="text-right warning">Balance</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $count = 0;
    $sq_booking = mysql_query($query);

    while($row_booking = mysql_fetch_assoc($sq_booking)){

      $pass_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_booking[booking_id]'"));
      $cancle_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_booking[booking_id]' and status='Cancel'"));
      if($pass_count==$cancle_count){
          $bg="danger";
      }else{
          $bg="#fff";
      }
      $date = $row_booking['booking_date'];
      $yr = explode("-", $date);
      $year = $yr[0];
      $sale_total_amount=$row_booking['net_total'];
      $cancel_est=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));

      $total_paid=mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
      $paid_amount = $total_paid['sum'];
      $paid_amount = ($paid_amount == '')?'0':$paid_amount;

      $cancel_est=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
      $cancel_amount=$cancel_est['cancel_amount'];
      //balance
      if($paid_amount > 0){
        if($pass_count==$cancle_count){
          $balance_amount = 0;
        }
        else{
          $balance_amount = $sale_total_amount - $paid_amount;
        }
      }else{
        if($pass_count!=$cancle_count){
          $balance_amount = $sale_total_amount;
        }
        else{
          $balance_amount = $cancel_amount;
        }
      }

      //Total
      $total_amount += $row_booking['net_total'];
      $total_paid1 += $paid_amount;
      $total_cancel += $cancel_amount;
      $total_balance += $balance_amount;
      ?>
      <tr class="<?=$bg?>">
        <td><?= ++$count ?></td>
        <td><?= get_package_booking_id($row_booking['booking_id'],$year) ?></td>
        <td><?= $row_booking['tour_name'] ?></td>
        <td><?= date('d-m-Y', strtotime($row_booking['tour_from_date'])) ?></td>
        <td>
          <button class="btn btn-info btn-sm" onclick="package_view_modal(<?= $row_booking['booking_id'] ?>)" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </td>
        <td class="text-right info"><?= number_format($row_booking['net_total'],2) ?></td>
        <td class="text-right success"><?= number_format($paid_amount,2) ?></td>
        <td class="danger text-right"><?= number_format($cancel_amount,2)?></td>
        <td class="warning text-right"><?= number_format($balance_amount,2)?></td>
      </tr>
      <?php

    }
    ?>
  </tbody>
  <tfoot>
    <tr class="active">
      <th colspan="5" class="text-right">Total</th>
      <th class="info text-right"><?= number_format($total_amount,2) ?></th>
      <th class="success text-right"><?= number_format($total_paid1,2) ?></th>
      <th class="danger text-right"><?= number_format($total_cancel,2)?></th>
      <th class="warning text-right"><?= number_format(($total_balance),2) ?></th>
    </tr>
  </tfoot>
</table>

</div> </div> </div>
<div id="div_package_content_display"></div>
<script type="text/javascript">
$('#package_table').dataTable({
  "pagingType": "full_numbers"
});
  function package_view_modal(booking_id)
  {
    var base_url = $('#base_url').val();
    $.post(base_url+'view/customer/other/bookings/package_booking/view/index.php', { booking_id : booking_id }, function(data){
      $('#div_package_content_display').html(data);
    });
  }
</script>