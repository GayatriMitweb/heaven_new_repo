<?php
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$estimate_id = $_POST['estimate_id'];

$sq_est_info = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));
$vendor=$sq_est_info['vendor_type'];
$vendor_id=$sq_est_info['vendor_type_id'];
$estimate_type=$sq_est_info['estimate_type'];
$estimate_type_id=$sq_est_info['estimate_type_id'];

$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$vendor' and vendor_type_id='$vendor_id' and estimate_type='$estimate_type' and estimate_type_id='$estimate_type_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
?>
<form id="frm_estimate">
<input type="hidden" name="estimate_id" id="estimate_id" value="<?= $estimate_id ?>">

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Refund Estimate</h4>
      </div>
      <div class="modal-body">

          <div class="row mg_bt_10">
            <div class="col-md-12">
              <div class="simple_multiple_stat">

                <div class="row">
                  <div class="col-md-12">
                    <div class="col5">
                      Basic Cost<br>
                      <span><?= number_format($sq_est_info['basic_cost'],2) ?></span>
                    </div>
                    <div class="col5">
                      Non-Recoverable Taxes<br>
                      <span><?= number_format($sq_est_info['non_recoverable_taxes'],2) ?></span>
                    </div>
                    <div class="col5">
                      Service Charge<br>
                      <span><?= number_format($sq_est_info['service_charge'],2) ?></span>
                    </div>
                    <div class="col5">
                      Other Charges<br>
                      <span><?= number_format($sq_est_info['other_charges'],2) ?></span>
                    </div>
                    <div class="col5">
                       Tax<br>
                       <span><?= $sq_est_info['service_tax_subtotal'] ?></span>
                    </div>               
                  </div>
                </div>
                <hr class="mg_tp_10 mg_bt_10">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col5">
                      Discount<br>
                      <span><?= number_format($sq_est_info['discount'],2) ?></span>
                    </div>
                    <div class="col5">
                      Commission<br>
                      <span><?= number_format($sq_est_info['our_commission'],2) ?></span>
                    </div>
                    <div class="col5">
                      TDS<br>
                      <span><?= number_format($sq_est_info['tds'],2) ?></span>
                    </div>
                    <div class="col5">
                      Total<br>
                      <span><strong style="color:#fff;"><?= number_format($sq_est_info['net_total'],2) ?></strong></span>
                    </div>
                    <div class="col5">
                      Paid Amount<br>
                      <span><strong style="color:#fff;"><?= ($sq_payment_info['sum']=="") ? number_format(0,2)  : number_format($sq_payment_info['sum'],2) ?></strong></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </div>      
      <input type="hidden" id="total_sale" name="total_sale" value="<?= $sq_est_info['net_total']?>">          
      <input type="hidden" id="total_paid" name="total_paid" value="<?= $sq_payment_info['sum']?>">   
      <hr>
      <?php 
        $sq_cancel_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id' and status='Cancel'"));
        if($sq_cancel_count>0){
          $sq_est_info = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$estimate_id'"));
      ?>
      <div class="row text-center">
        <div class="col-md-3 col-md-offset-3 col-sm-6 col-xs-12 mg_bt_10_xs">
          <input type="text" name="cancel_amount" id="cancel_amount" class="text-right" placeholder="*Cancellation Charges" title="Cancellation Charges" onchange="validate_balance(this.id);calculate_total_refund()" value="<?= $sq_est_info['cancel_amount'] ?>">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
          <input type="text" name="total_refund_amount" id="total_refund_amount" class="amount_feild_highlight text-right" placeholder="Total Refund" title="Total Refund" readonly value="<?= $sq_est_info['total_refund_amount'] ?>">
        </div>
      </div>
      <?php if($sq_est_info['cancel_amount'] == "0.00"){ ?>
      <div class="row text-center mg_tp_20">
        <div class="col-md-12">
            <button id="btn_refund_save" class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
      </div>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
function calculate_total_refund(){
  var total_refund_amount = 0;
  var cancel_amount = $('#cancel_amount').val();
  var total_sale = $('#total_sale').val();
  var total_paid = $('#total_paid').val();

  if(cancel_amount==""){ cancel_amount = 0; }
  if(total_paid==""){ total_paid = 0; }

  if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale amount"); }
  var total_refund_amount = parseFloat(total_paid) - parseFloat(cancel_amount);
  
  if(parseFloat(total_refund_amount) < 0){ 
    total_refund_amount = 0;
  }
  $('#total_refund_amount').val(total_refund_amount.toFixed(2));
}

$(function(){
$('#frm_estimate').validate({
 rules:{
      cancel_amount : { required : true, number : true },
      total_refund_amount : { required : true, number : true },
  },
  submitHandler:function(form){

      var estimate_id = $('#estimate_id').val();
      var cancel_amount = $('#cancel_amount').val();
      var total_refund_amount = $('#total_refund_amount').val();
      var total_sale = $('#total_sale').val();
      var total_paid = $('#total_paid').val();

      if(parseFloat(cancel_amount) > parseFloat(total_sale)) { error_msg_alert("Cancel amount can not be greater than Sale Amount"); return false; }
      $('#btn_save').button('loading');

      $.ajax({
        type: 'post',
        url: base_url()+'controller/vendor/refund/estimate_update.php',
        data:{ estimate_id : estimate_id,cancel_amount : cancel_amount, total_refund_amount : total_refund_amount },
        success: function(result){
          $('#btn_save').button('reset');
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
          }
          else{
            msg_alert(result);
            $('#save_modal').modal('hide');
            $('#save_modal').on('hidden.bs.modal', function(){
              list_reflect();
            });
          }
        }
      });
  }
});
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>