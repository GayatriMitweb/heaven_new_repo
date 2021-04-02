<?php include "../../../model/model.php"; ?>
<?php
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];
$traveler_group_id = $_GET['traveler_group_id'];

$sq = mysql_query("select id from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and traveler_group_id = '$traveler_group_id' ");
if($row = mysql_fetch_assoc($sq))
{
    $tourwise_id = $row['id'];
}

$sql = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_id' and payment_for = 'Travelling' ");
$row = mysql_fetch_array($sql);
$traveling_amount_paid = $row['total'];

$sql = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_id' and payment_for = 'Tour' ");
$row = mysql_fetch_array($sql);
$tour_amount_paid = $row['total'];
$total_amount = $traveling_amount_paid + $tour_amount_paid;


?>
<input type="hidden" id="txt_tour_id" name="txt_tour_id" value="<?php echo $tour_id ?>">
<input type="hidden" id="txt_tour_group_id" name="txt_tour_group_id" value="<?php echo $tour_group_id ?>">
<input type="hidden" id="txt_traveler_group_id" name="txt_traveler_group_id" value="<?php echo $traveler_group_id ?>">
<input type="hidden" id="txt_tourwise_traveler_id" name="txt_tourwise_traveler_id" value="<?php echo $tourwise_id ?>">


<hr>

<div class="row table-responsive">
    <div class="col-md-12">
        <table class="table table-bordered">            
            <tr>
                <td><strong>Booking Id</strong></td>
                <td><strong>Travel Fees Paid</strong></td>
                <td><strong>Tour Fees Paid</strong></td>
                <td><strong>Total</strong> </td>
            </tr>
            <tr>
                <td><?php echo get_group_booking_id($tourwise_id) ?></td>
                <td><?php echo $traveling_amount_paid ?></td> 
                <td><?php echo $tour_amount_paid ?></td> 
                <td><?php echo $total_amount ?></td> 
            </tr>
        </table>
    </div>
</div>

<?php include_once('refund_estimate_update.php'); ?>   

<div class="row"> 


<div class="col-md-6 col-sm-6">

<div class="table-responsive">

<form id="frm_refund">
<table id="tbl_canceled_tour_details" class="table table-bordered table-hover"> 
        <tr class="text-center">
            <td colspan="2"><strong>Refund Tour</strong></td>
        </tr>       
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
            <td><input class="form-control" type="text" id="txt_refund_amount" name="txt_refund_amount" onchange="number_validate(this.id); payment_amount_validate(this.id,'cmb_refund_mode','transaction_id','bank_name');" placeholder="Refund Amount"></td>
        </tr>
        <tr>
            <td class="text-right"><strong>Refund Date</strong></td>
            <td>
                <input type="text" id="refund_date" name="refund_date" placeholder="Date" title="Date">
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Refund Mode</strong></td>
            <td>
                <select id="cmb_refund_mode" name="cmb_refund_mode" class="form-control" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                    <option value="">Refund Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="NEFT">NEFT</option>
                    <option value="credit note">Credit Note</option>
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
                <input type="text" id="transaction_id" name="transaction_id" placeholder="Cheque No / ID" title="Cheque No / ID" disabled>
            </td>
        </tr>
        <tr>
            <td class="text-right"><strong>Bank</strong></td>
            <td>
                <select name="bank_id" id="bank_id" title="Bank" disabled>
                    <?php get_bank_dropdown()  ?>
                </select>
            </td>
        </tr>
        <tr class="text-center">
           <td colspan="2">
               <button id="btn_refund_tour_fee" class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
           </td>
        </tr>
        

</table>
</form>    
</div>

</div> 


<div class="col-md-6 col-sm-6">
    <?php
    $count = mysql_num_rows(mysql_query("select * from refund_tour_cancelation where tourwise_traveler_id='$tourwise_id' "));
    if($count>0)
    {
    ?>
       <div class="table-responsive">
        <table class="table table-bordered table-hover">
        <thead>
            <tr class="text-center">
                <td colspan="7"><strong>Refund History</strong></td>
            </tr>
            <tr>
                <td>Sr. No</td>
                <td>Amount</td>
                <td>Refund_Date</td>
                <td>Mode</td>
                <th>Bank_Name</th>
                <th>Cheque_NO/ID</th>
                <td>Voucher</td>
            </tr>    
        </thead>
                <tbody>    
            <?php    
            $sr_no = 0;
            $sq = mysql_query("select * from refund_tour_cancelation where tourwise_traveler_id='$tourwise_id' and refund_amount!=0 ");
            while($row = mysql_fetch_assoc($sq)){
                    $sr_no++;
            ?>
                   <tr>
                        <td><?php echo $sr_no ?></td>
                        <td><?php echo number_format($row['refund_amount'],2) ?></td>
                        <td><?php echo date("d-m-Y", strtotime($row['refund_date'])) ?></td>
                        <td><?php echo $row['refund_mode'] ?></td>
                        <td><?php echo $row['bank_name'] ?></td>
                        <td><?php echo $row['transaction_id'] ?></td>   
                        <td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="generate_voucher_for_cancelled_tour(<?= $row['refund_id'] ?>)" target="_BLANK"><i class="fa fa-file-pdf-o"></i></a></td>                    
                   </tr> 
            <?php        
                }  

            ?>
        </tbody>
    </table>
    </div>
    <?php      
    }    
    ?>
</div>

</div>


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

            $('#btn_refund_tour_fee').button('loading');

             $('#vi_confirm_box').vi_confirm_box({
             callback: function(data1){
                    if(data1=="yes"){

                        $.post( 
                               base_url+"controller/group_tour/tour_cancelation_and_refund/refund_tour_group_fee_save.php",
                               { tourwise_id : tourwise_id, traveler_id : traveler_id, refund_amount : refund_amount, refund_date : refund_date, refund_mode : refund_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
                               function(data) {
                                  msg_alert(data);  
                                  refund_cancelled_tour_group_reflect();          
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

