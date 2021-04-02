<?php
include "../../../../../../model/model.php";

$tourwise_traveler_id = $_POST['tourwise_traveler_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from refund_tour_cancelation where tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id') ";
if($tourwise_traveler_id!=""){
    $query .=" and tourwise_traveler_id='$tourwise_traveler_id'";
}

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered table-hover bg_white cust_table" id="group_table1" style="margin:20px 0 !important">
    <thead>      
        <tr class="table-heading-row">
            <th>S_No.</th>
            <th>Booking_ID</th>
            <th>Refund_Date</th>
            <th>Bank_Name</th>
            <th>Refund_Mode</th>
            <th>Cheque_No/ID</th>
            <th class="text-right success">Amount</th>
        </tr>    
    </thead>
    <tbody>    
        <?php    
            $sr_no = 0;
            $bg;
            $sq_pending_amount=0;
            $sq_paid_amount=0;
            $sq = mysql_query($query);
            while($row = mysql_fetch_assoc($sq))
            {
                $sr_no++;
                $sq_booking = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_traveler_id'"));
                $date = $sq_booking['form_date'];
                $yr = explode("-", $date);
                $year =$yr[0];
                if($row['clearance_status']=="Pending"){ $bg='warning';
					$sq_pending_amount = $sq_pending_amount + $row['refund_amount'];
				}
				if($row['clearance_status']=="Cleared"){ $bg='success';
					$sq_paid_amount = $sq_paid_amount + $row['refund_amount'];
				}
                if($row_car_rental_refund['clearance_status']=="Cancelled"){ 
                $bg = "danger"; 
                $canceled_refund = $canceled_refund + $row['refund_amount'];
            }
            if($row['clearance_status']==""){ $bg='';
                $sq_paid_amount = $sq_paid_amount + $row['refund_amount'];
            }
            $paid_amt = $paid_amt + $row['refund_amount'];                
        ?>
            <tr class="<?= $bg;?>">
                <td><?php echo $sr_no ?></td>
                <td><?= get_group_booking_id($row['tourwise_traveler_id'],$year) ?></td>
                <td><?php echo date("d-m-Y", strtotime($row['refund_date'])) ?></td>
                <td><?php echo $row['bank_name'] ?></td>
                <td><?php echo $row['refund_mode'] ?></td>
                <td><?= $row['transaction_id'] ?></td>
                <td class="text-right success"><?php echo $row['refund_amount'] ?></td> 
            </tr> 
        <?php } ?>
    </tbody>
    <tfoot>
    	<tr class="active">
    		<th colspan="1" class="text-right info">Refund : <?= ($paid_amt=='')?number_format(0,2): number_format($paid_amt,2); ?></th>
            <th colspan="2" class="text-right warning">Pending : <?= ($sq_pending_amount=='')?number_format(0,2): number_format($sq_pending_amount,2);?></th>
            <th colspan="2" class="text-right danger">Cencelled : <?= ($canceled_refund=='')?number_format(0,2): number_format($canceled_refund,2); ?></th>
            <th colspan="2" class="text-right success">Total Refund : <?= number_format(($paid_amt-$sq_pending_amount- $canceled_refund),2);?></th>
    	</tr>
    </tfoot>
</table>
</div> </div> </div>
<script type="text/javascript">
$('#group_table1').dataTable({
    "pagingType": "full_numbers"
});
</script>
