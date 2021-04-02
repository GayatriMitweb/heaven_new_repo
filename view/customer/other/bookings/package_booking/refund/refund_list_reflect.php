<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from package_refund_traveler_cancelation where booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id')";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered table-hover mg_bt_0 cust_table" id="package_table3" style="margin:20px 0 !important">
    <thead>   
    <tr class="table-heading-row">
        <th>S_No.</th>
        <th>Booking_ID</th>
        <th>Tour_Type</th>
        <th>Refund_Date</th>  
        <th>Bank_Name</th>  
        <th>Refund_Mode</th>
        <th class="text-right success">Amount</th>  
    </tr>
    </thead>
    <tbody>
    <?php 
    $total_tour_refund = 0;
    $total_travel_refund = 0;
    $total_refund = 0;
    $count = 0;
    $date;

    $sq_pending_amount=0;
    $sq_cancel_amount=0;
    $sq_paid_amount=0.00;
    $Total_payment=0;

    $sq_refund = mysql_query($query);
    while($row_refund = mysql_fetch_assoc($sq_refund))
    {       

        $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row_refund[booking_id]'"));
        $date = $sq_booking['booking_date'];
        $yr = explode("-", $date);
        $year =$yr[0];
        $count++;
        $total_travel_refund = $total_travel_refund + $row_refund['total_travel_refund'];
        $total_tour_refund = $total_tour_refund + $row_refund['total_tour_refund'];
        $total_refund = $total_refund + $row_refund['total_refund'];

         if($row_refund['clearance_status']=="Pending"){ $bg='warning';
        $sq_pending_amount = $sq_pending_amount + $row_refund['total_refund'];
        }

        if($row_refund['clearance_status']=="Cleared"){ $bg='success';
            $sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
        }

        if($row_refund['clearance_status']=="Cancelled"){ $bg='danger';
            $sq_can_amount = $sq_can_amount + $row_refund['total_refund'];
        }

        if($row_refund['clearance_status']==""){ $bg='';
            $sq_paid_amount = $sq_paid_amount + $row_refund['total_refund'];
        }  

        $total_refund_amt += $row_refund['total_refund']; 
       $sq_refund_entry = mysql_query("select traveler_id from package_refund_traveler_cancalation_entries where refund_id='$row_refund[refund_id]'");
        while($row_refund_entry = mysql_fetch_assoc($sq_refund_entry) )
        {
            $sq_traveler = mysql_fetch_assoc( mysql_query( "select m_honorific, first_name, last_name from package_travelers_details where traveler_id='$row_refund_entry[traveler_id]'" ) );
        } 
    ?>
    <tr class="<?= $bg?> text-left">
        <td><?php echo $count; ?></td>
        <td><?php echo get_package_booking_id($row_refund['booking_id'],$year); ?></td> 
        <td><?= $sq_booking['tour_type'] ?></td>
        <td><?php echo date('d-m-Y', strtotime($row_refund['refund_date'])); ?></td>
        <td><?= $row_refund['bank_name'] ?></td>
        <td><?php echo $row_refund['refund_mode'] ?></td>
        <td class="text-right success"><?php echo $row_refund['total_refund'] ?></td>
    </tr>
    <?php    
    }    
    ?>
    </tbody>
    <tfoot>
        <tr class="active">
            <th colspan="1" class="text-right info">Refund: <?= ($total_refund_amt=='')?number_format(0,2):number_format($total_refund_amt,2); ?></th>
            <th colspan="2" class="text-right warning">Pending : <?= ($sq_pending_amount=='')?number_format(0,2):number_format($sq_pending_amount,2);?></th>
            <th colspan="2" class="text-right danger">Cancelled: <?= ($sq_can_amount=='')?number_format(0,2):number_format($sq_can_amount,2); ?></th>
            <th colspan="2" class="text-right success">Total Refund : <?= number_format(($total_refund_amt - $sq_pending_amount - $sq_can_amount),2);?></th>
        </tr>
    </tfoot>
</table>
</div> </div> </div>
<script type="text/javascript">
    
$('#package_table3').dataTable({
    "pagingType": "full_numbers"
});
</script>