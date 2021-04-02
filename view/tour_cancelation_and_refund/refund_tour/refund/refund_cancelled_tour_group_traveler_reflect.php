<?php include "../../../../model/model.php"; ?>
<?php
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];
$traveler_group_id = $_GET['traveler_group_id'];
if($traveler_group_id!='' && $tour_id!='' && $tour_group_id!=''){
$sq = mysql_query("select id from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and id = '$traveler_group_id' ");
if($row = mysql_fetch_assoc($sq))
{
    $tourwise_id = $row['id'];
}

$sql = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_id'  and clearance_status!='Pending' AND clearance_status!='Cancelled'");
$row = mysql_fetch_array($sql);
$traveling_amount_paid = $row['total'];

$sql1 = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_id'  and clearance_status!='Pending' AND clearance_status!='Cancelled' ");


$row1= mysql_fetch_array($sql1);
$tour_amount_paid = $row1['total'];
$total_amount = $traveling_amount_paid + $tour_amount_paid;

$tourwise_details1 = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id' "));

$sq_est_count = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
if($sq_est_count!='0')
{
    $sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
    $booking_fee=$tourwise_details1['net_total'];
    $sale_Amount = $booking_fee - $sq_est_info['total_refund'];
    $refund_amount = $total_amount - $sale_Amount;
}
$sq_ref_paid_amt = mysql_fetch_assoc(mysql_query("SELECT SUM(refund_amount) as total FROM refund_tour_cancelation where tourwise_traveler_id ='$tourwise_id'"));
$sq_ref_paid_amt1 = mysql_fetch_assoc(mysql_query("SELECT SUM(refund_amount) as total FROM refund_tour_cancelation where tourwise_traveler_id ='$tourwise_id' and clearance_status='Cancelled' "));
$paid_amount = $sq_ref_paid_amt['total'] - $sq_ref_paid_amt1['total'];
$remaining = $sq_est_info['total_refund_amount'] - $paid_amount;


?>
<input type="hidden" id="txt_tour_id" name="txt_tour_id" value="<?php echo $tour_id ?>">
<input type="hidden" id="txt_tour_group_id" name="txt_tour_group_id" value="<?php echo $tour_group_id ?>">
<input type="hidden" id="txt_traveler_group_id" name="txt_traveler_group_id" value="<?php echo $traveler_group_id ?>">
<input type="hidden" id="txt_tourwise_traveler_id" name="txt_tourwise_traveler_id" value="<?php echo $tourwise_id ?>">
<input type="hidden" id="remaining" name="remaining" value="<?php echo $remaining; ?>">


<div class="row mg_tp_20 mg_bt_10">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12 mg_bt_10_xs">
        <div class="widget_parent-bg-img bg-green">
            <div class="widget_parent">
                <div class="stat_content main_block">
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Sale</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($booking_fee=='')?'0.00': number_format($booking_fee,2) ?></span>
                    </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""> <?= ($total_amount=='')?'0.00': $total_amount?></span>
                    </span> 
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= number_format($sq_est_info['cancel_amount'], 2); ?></span>
                    </span>         
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($sq_est_info['total_refund_amount'], 2); ?></span>
                    </span>
                             
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Pending Refund Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($remaining, 2); ?></span>
                    </span>
                </div>   
            </div>
        </div>      
    </div>
</div>


<div class="row"> 
<div class="col-md-6 col-sm-12 col-xs-12 mg_tp_20 mg_bt_20_xs">
<div class="table-responsive">
<form id="frm_refund">
<h3 class="editor_title">Refund Details</h3>
<table id="tbl_canceled_tour_details" class="table table-bordered table-hover no-marg">      
        <tr>
           <td class="text-right"><strong>Passenger</strong></td>
           <td>
                <select id="txt_traveler_name"  class="form-control">
                    <?php
                        $sq_t = mysql_query("select * from travelers_details where traveler_group_id='$traveler_group_id'");
                        while($row_t = mysql_fetch_assoc($sq_t))
                        {
                        ?>
                            <option value="<?php echo $row_t['traveler_id'] ?>"><?php echo $row_t['first_name']." ".$row_t['last_name'] ?></option>
                        <?php        
                        }    
                    ?>
                </select>    
            </td>  
        </tr>  
        <tr>
            <td class="text-right"><strong>Refund Amount</strong></td>
            <td><input class="form-control" type="text" id="txt_refund_amount" title="Refund Amount" name="txt_refund_amount" placeholder="*Refund Amount" onchange="payment_amount_validate(this.id,'cmb_refund_mode','transaction_id','bank_name');validate_balance(this.id);"></td>
        </tr>
        <tr>
            <td class="text-right"><strong>Refund Date</strong></td>
            <td>
                <input type="text" id="refund_date" name="refund_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y')?>">
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Payment Mode</strong></td>
            <td>
                <select id="cmb_refund_mode" name="cmb_refund_mode" title="Payment Mode" class="form-control" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						<?php get_payment_mode_dropdown(); ?>
                </select>   
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Bank Name</strong></td>
            <td>
                <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" disabled>
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Cheque No / ID</strong></td>
            <td>
                <input type="text" id="transaction_id" onchange="validate_balance(this.id)" name="transaction_id" placeholder="Cheque No / ID" title="Cheque No / ID" disabled>
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Bank</strong></td>
            <td>
                <select name="bank_id" id="bank_id" title="Bank" disabled>
                    <?php get_bank_dropdown('Debited Bank')  ?>
                </select>
            </td>
        </tr>
        <tr class="text-center">
           <td colspan="2">
               <button id="btn_refund_tour_fee" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
           </td>
        </tr>
        

</table>
</form>    
</div>

</div> 


<div class="col-md-6 col-sm-12 col-xs-12 mg_tp_20">
    <?php
    $count = mysql_num_rows(mysql_query("select * from refund_tour_cancelation where tourwise_traveler_id='$tourwise_id' and refund_amount!=0  AND clearance_status!='Cancelled' "));
    if($count>0){
    ?>
       <div class="table-responsive">
        <h3 class="editor_title">Refund History</h3>
        <table class="table table-bordered table-hover no-marg">
        <thead>
            <tr class="table-heading-row">
                <th>S_No.</th>
                <th>Amount</th>
                <th>Refund_Date</th>
                <th>Mode</th>
                <th>Bank_Name</th>
                <th>Cheque_NO/ID</th>
                <th>Voucher</th>
            </tr>    
        </thead>
                <tbody>    
            <?php    
                $sr_no = 0;
                $bg;
                $paid_amt=0;
                $pending_amt=0;
                $cancel_amt=0;
                $sq = mysql_query("select * from refund_tour_cancelation where tourwise_traveler_id='$tourwise_id' and refund_amount!=0 ");
                while($row = mysql_fetch_assoc($sq))
                {
                    $date = $row['refund_date'];
                    $yr = explode("-", $date);
                    $year = $yr[0];
                    $sr_no++;
                    $paid_amt = $paid_amt + $row['refund_amount'];
                    if($row['clearance_status']=="Pending"){ 
                        $bg = "warning"; 
                        $pending_amt = $pending_amt + $row['refund_amount'];
                    }                    
                    else if($row['clearance_status']=="Cancelled"){ 
                        $bg = "danger"; 
                        $cancel_amt = $cancel_amt + $row['refund_amount'];
                    }
                    else{   $bg = "";    }

                    $sq_tname = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_id='$row[traveler_id]'"));
                    $sq_cust = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));

                    $v_voucher_no = get_group_booking_group_refund_id($row['refund_id'],$year);
                    $v_refund_date = $row['refund_date'];
                    $v_refund_to = $sq_tname['first_name']." ".$sq_tname['last_name'];
                    $v_service_name = "Group Booking";
                    $v_refund_amount = $row['refund_amount'];
                    $v_payment_mode = $row['refund_mode'];
                    $customer_id = $sq_cust['customer_id'];
                    $refund_id = $row['refund_id'];
                    $url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id";

            ?>
                   <tr class="<?= $bg;?>">
                    <td><?php echo $sr_no ?></td>
                    <td class="text-right"><?php echo number_format($row['refund_amount'],2) ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row['refund_date'])) ?></td>
                    <td><?php echo $row['refund_mode'] ?></td>
                    <td><?php echo $row['bank_name'] ?></td>
                    <td><?php echo $row['transaction_id'] ?></td>        
                    <td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>             
                   </tr> 
            <?php        
                }  

            ?>
        </tbody>
        <tfoot>
            <tr class="active">
                <th colspan="2" class="info">Refund : <?= ($paid_amt=="") ? number_format(0,2) : number_format($paid_amt,2) ?></th>
                <th colspan="2" class="warning">Pending : <?= ($pending_amt=="") ? number_format(0,2) : number_format($pending_amt,2) ?></th>
                <th colspan="2" class="danger">Cancel : <?= ($cancel_amt=="") ? number_format(0,2): number_format($cancel_amt,2) ?></th>
                <th colspan="2" class="success" colspan="2">Total : <?= number_format(($paid_amt - $pending_amt - $cancel_amt),2) ?></th>
            </tr>
        </tfoot>
    </table>
    </div>
    <?php      
    }    
    ?>
</div>

</div>

<?php }?>
<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#frm_refund').validate({
    rules:{
            txt_traveler_name : { required : true },
            txt_refund_amount : { required : true, number:true },
            refund_date : { required : true },
            cmb_refund_mode : { required : true },
            bank_name : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
            transaction_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
            bank_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
    },
    submitHandler:function(form){

            var base_url = $('#base_url').val();  
            var tourwise_id = $("#txt_tourwise_traveler_id").val();
  
            var traveler_id = $('#txt_traveler_name').val();
            var refund_amount = $('#txt_refund_amount').val();
            var refund_date = $('#refund_date').val();
            var refund_mode = $('#cmb_refund_mode').val();
            var bank_name = $('#bank_name').val();
            var transaction_id = $('#transaction_id').val();
            var bank_id = $('#bank_id').val();
            var remaining = $('#remaining').val();
            if(Number(refund_amount) > Number(remaining))
            { error_msg_alert("Amount can not be greater than total refund amount"); return false; }

            $('#btn_refund_tour_fee').button('loading');
             $('#vi_confirm_box').vi_confirm_box({
             callback: function(data1){
                    if(data1=="yes"){

                        $.post( 
                               base_url+"controller/group_tour/tour_cancelation_and_refund/refund_tour_group_fee_save.php",
                               { tourwise_id : tourwise_id, traveler_id : traveler_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
                               function(data) {
                                  msg_alert(data);  
                                  refund_cancelled_tour_group_traveler_reflect();   
                                  $('#btn_refund_tour_fee').button('reset');       
                               });
                      
                    }else{
                        $('#btn_refund_tour_fee').button('reset');
                    }
              }
            });

    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

