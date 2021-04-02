<?php 
include_once ('../../../../model/model.php');

$booking_id = $_POST['booking_id'];
?>
<div class="row"><div class="table-responsive">
<h3 class="editor_title">Refund History</h3>
<table id="refund_history" class="table table-bordered table-hover no-marg">
    <thead>
    <tr class="table-heading-row">
        <th>S_No.</th>
        <th>Guest_Name</th>
        <th>Amount</th>
        <th>Refund_Date</th>
        <th>Mode</th>
        <th>Bank_name</th>
        <th>Cheque_NO/ID</th>
        <th>Voucher</th>
    </tr>
    </thead>
    <tbody>
    <?php     
    $count = 0;
    $bg;
    $sq_refund = mysql_query("select * from package_refund_traveler_cancelation where booking_id='$booking_id' and total_refund!= 0");
    while($row_refund = mysql_fetch_assoc($sq_refund)){
        $count++;
        if($row_refund['clearance_status']=="Pending"){ $bg = "warning"; }
        else if($row_refund['clearance_status']=="Cancelled"){ $bg = "danger"; }
        else{ $bg = ""; }

    ?>
    <tr class="<?= $bg ?>">
        <td><?php echo $count; ?></td>
        <td>
        <?php 
        $sq_refund_entry = mysql_query("select traveler_id from package_refund_traveler_cancalation_entries where refund_id='$row_refund[refund_id]'");
        $sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row_refund[booking_id]'"));
        $customer_id = $sq_package_info['customer_id'];
        $date = $row_refund['refund_date'];
        $yr = explode("-", $date);
        $year =$yr[0];

        while($row_refund_entry = mysql_fetch_assoc($sq_refund_entry) )
        {
            $sq_traveler = mysql_fetch_assoc( mysql_query( "select m_honorific, first_name, last_name from package_travelers_details where traveler_id='$row_refund_entry[traveler_id]'" ) );
             echo $sq_traveler['m_honorific'].' '.$sq_traveler['first_name'].' '.$sq_traveler_query['last_name']."<br>";
        }   
        $v_voucher_no = get_package_booking_refund_id($row_refund['refund_id'],$year);
        $v_refund_date = $row_refund['refund_date'];
        $v_refund_to = $sq_traveler['first_name']." ".$sq_traveler['last_name'];
        $v_service_name = "Package Booking";
        $v_refund_amount = $row_refund['total_refund'];
        $v_payment_mode = $row_refund['refund_mode'];
        $customer_id = $customer_id;
        $refund_id = $row_refund['refund_id'];
        $url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id"; 
        ?>
        </td>
        <td><?php echo number_format($row_refund['total_refund'],2) ?></td>
        <td><?php echo get_date_db($row_refund['refund_date']) ?></td>
        <td><?php echo $row_refund['refund_mode'] ?></td>
        <td><?php echo $row_refund['bank_name'] ?></td>
        <td><?php echo $row_refund['transaction_id'] ?></td>   
        <td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>    
    </tr>
    <?php    
    }    
    ?>   
    </tbody>
    <tfoot>
        <?php 
        $sq_refund = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id' "));
        $sq_pending = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id' and clearance_status='Pending' "));
        $sq_cancel = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id' and clearance_status='Cancelled' "));
        ?>
        <tr class="active">
            <th colspan="2" class="info">Refund : <?= ($sq_refund['sum']=="") ? number_format(0,2) : number_format($sq_refund['sum'],2) ?></th>
            <th colspan="2" class="warning">Pending : <?= ($sq_pending['sum']=="") ? number_format(0,2) : number_format($sq_pending['sum'],2) ?></th>
            <th colspan="2" class="danger">Cancelled : <?= ($sq_cancel['sum']=="") ? number_format(0,2) : number_format($sq_cancel['sum'],2) ?></th>
            <th colspan="2" class="success">Total : <?= number_format(($sq_refund['sum'] - $sq_pending['sum'] - $sq_cancel['sum']),2) ?></th>
        </tr>
    </tfoot>
</table>
<input type="hidden" id="ref_amt" value="<?= ($sq_refund['sum']=="") ? 0 : $sq_refund[sum] ?>">
</div></div>