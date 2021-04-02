<?php
include "../../../../model/model.php";
$booking_id = $_POST['booking_id'];


$sq_booking = mysql_fetch_assoc( mysql_query("select * from package_tour_booking_master where booking_id = '$booking_id'  ") );
$date = $sq_booking['booking_date'];
$yr = explode("-", $date);
$year =$yr[0];

$sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id'  and clearance_status!='Pending' AND clearance_status!='Cancelled'"));


$sq_refund_estimate = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));

$sq_total_ref_paid_amount = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id'"));
$sq_cancelled = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id' and clearance_status='Cancelled' "));

$unique_timestamp =  md5(uniqid());
$sale_Amount=$sq_booking['net_total'];
$paid_amount =  $sq_total_tour_paid_amount['sum'];
$cancel_amount = $sq_refund_estimate['cancel_amount'];
$refund_amount = $sq_refund_estimate['total_refund_amount'];

$remaining = $refund_amount - $sq_total_ref_paid_amount['sum'] - $sq_cancelled['sum'];
?>




<input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id; ?>">
<input type="hidden" id="remaining" name="remaining" value="<?php echo $remaining; ?>">
<input type="hidden" id="refund_amount" name="refund_amount" value="<?php echo $refund_amount ?>">

<input type="hidden" id="txt_unique_timestamp" name="unique_timestamp" value="<?php echo $unique_timestamp; ?>">

<div class="row mg_bt_10">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12 mg_tp_20 mg_bt_10_xs">
        <div class="widget_parent-bg-img bg-green">
            <div class="widget_parent">
                <div class="stat_content main_block">
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Booking ID</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= get_package_booking_id($booking_id,$year) ?></span>
                    </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Sale</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($sale_Amount=='')?'0.00': number_format($sale_Amount,2) ?></span>
                    </span>
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""> <?= ($paid_amount=='')?'0.00': number_format($paid_amount,2) ?></span>
                    </span> 
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?= number_format($cancel_amount, 2); ?></span>
                    </span>         
                    <span class="main_block content_span" data-original-title="" title="">
                        <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
                        <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($refund_amount, 2); ?></span>
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

<div class="row mg_tp_20">     
    <div class="col-md-6 col-sm-12 col-xs-12 mg_tp_20">
        <form id="frm_traveler_refund">
            <h3 class="editor_title">Refund Details</h3>    
            <div class="panel panel-default panel-body mg_bt_10"> 
                <div class="row">
                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <input type="text" id="txt_total_refund_cost_c" name="txt_total_refund_cost_c" placeholder="*Refund Amount" title="Refund Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_refund_mode','transaction_id','bank_name')"  class="form-control" />
                    </div>             
                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <input type="text" id="refund_date" name="refund_date" placeholder="*Payment Date" title="Payment Date" value="<?= date('d-m-Y')?>" class="form-control">
                    </div>          
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <select id="cmb_refund_mode" name="cmb_refund_mode" title="Payment Mode" class="form-control" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
						<?php get_payment_mode_dropdown(); ?>
                        </select> 
                    </div>
                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <input type="text" id="bank_name" name="bank_name" placeholder="*Bank Name" title="Bank Name" class="bank_suggest form-control" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <input type="text" id="transaction_id" onchange="validate_balance(this.id)" name="transaction_id" class="form-control" placeholder="*Cheque No / ID" title="Cheque No / ID" disabled>
                    </div>

                    <div class="col-sm-6 col-xs-12 mg_bt_10">
                        <select name="bank_id" id="bank_id" title="Bank" class="form-control" style="width:100%" disabled>
                            <?php get_bank_dropdown('*Debitor bank')  ?>
                        </select>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-xs-12 mg_bt_10">
                        <select id="traveler_id" name="traveler_id" multiple style="height:70px;" class="form-control" >
                            <?php 
                            $sq_traveler_query = mysql_query("select * from package_travelers_details where booking_id='$booking_id' ");
                            while($row_traveler = mysql_fetch_assoc($sq_traveler_query))
                            {
                            ?>
                            <option value="<?php echo $row_traveler['traveler_id'] ?>"><?php echo $row_traveler['m_honorific'].' '.$row_traveler['first_name'].' '.$row_traveler['last_name']; ?></option>
                            <?php    
                            }    
                            ?>    
                        </select>
                    </div> 
                </div>     
                <div class="row col-xs-12 text-center mg_tp_20">
                    <button class="btn btn-sm btn-success" id="refund_btn"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Refund</button>
                </div>  
            </div> 
        </form>                              
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12 mg_tp_20">
        <div id="refund_canceled_traveler_summary_tbl">
            <?php include "refund_canceled_traveler_summary_tbl.php" ?>
        </div>
    </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>      
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>                  

<script>
////////////********** Refund Canceled traveler save ***********************//////////
$(function(){
    $('#frm_traveler_refund').validate({
        rules:{
                txt_unique_timestamp : { required: true },
                booking_id : { required: true },
                txt_total_refund_cost_c : { required: true, number:true },
                cmb_refund_mode : { required: true },
                refund_date : { required : true },
                bank_name : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
                transaction_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                bank_id : { required : function(){  if($('#cmb_refund_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
                traveler_id : { required: true },
        },
        submitHandler:function(form){

              var unique_timestamp = $('#txt_unique_timestamp').val();
              var base_url = $('#base_url').val();
              var booking_id = $('#booking_id').val();

              var total_refund = $("#txt_total_refund_cost_c").val();
              var refund_mode = $("#cmb_refund_mode").val();
              var refund_date = $('#refund_date').val();
              var transaction_id = $('#transaction_id').val();
              var bank_name = $('#bank_name').val();
              var bank_id = $('#bank_id').val();
              var remaining = $('#remaining').val();
              var traveler_id_arr = $("#traveler_id").val();
              var traveler_count = $("#traveler_id :selected").length;  
              if(traveler_count==0) { alert('Please select at least one traveler.'); return false; }  
              if(typeof($("#ref_amt")) != "undefined" && (Number($("#ref_amt").val()) ==  Number($('#refund_amount').val()))){
                error_msg_alert("Refund Already Fully Paid"); return false;
              }
              else if(Number(total_refund) > Number(remaining))
              { error_msg_alert("Amount can not be greater than total refund amount"); return false; }

              $('#refund_btn').button('loading');
              $.post(base_url+'controller/package_tour/cancel_and_refund/refund_booking_c.php', { unique_timestamp : unique_timestamp, booking_id : booking_id, total_refund : total_refund, refund_mode : refund_mode, refund_date : refund_date, transaction_id : transaction_id, bank_name : bank_name, bank_id : bank_id, 'traveler_id_arr[]' : traveler_id_arr }, function(data) {
                  msg_alert(data);
                  reset_form('frm_traveler_refund');
                  $.post('../refund/refund_canceled_traveler_summary_tbl.php', { booking_id : booking_id }, function(data) {
                      $('#refund_canceled_traveler_summary_tbl').html(data);
                      $('#refund_btn').button('reset');
                  });
              } );

        }

    });

});
/////////////********** Refund Canceled traveler save end**********************************************************************
</script>

<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' })
</script>