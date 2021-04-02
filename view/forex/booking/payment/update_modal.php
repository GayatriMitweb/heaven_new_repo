<?php
include "../../../../model/model.php";

$payment_id = $_POST['payment_id'];

$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from forex_booking_payment_master where payment_id='$payment_id'"));

$sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$sq_payment_info[booking_id]'"));
$date = $sq_booking['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$enable = ($sq_payment_info['payment_mode'] == "Cash" || $sq_payment_info['payment_mode'] == "Credit Note" || $sq_payment_info['payment_mode'] == 'Credit Card') ? "disabled" : "";
?>

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>
      </div>
      <div class="modal-body">

        <form id="frm_update">

			   <input type="hidden" id="payment_id_update" name="payment_id_update" value="<?= $payment_id ?>">
         <input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment_info['payment_amount'] ?>">

          <div class="row mg_bt_10">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select name="customer_id" id="customer_id" title="Customer Name" style="width:100%" onchange="booking_id_dropdown_load('customer_id', 'booking_id');" disabled>
                    <?php 
                    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
                    if($sq_customer['type']=='Corporate'){
                    ?>
                      <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                    <?php }  else{ ?>
                      <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                    <?php } ?>
                    <?php
                    $sq_customer = mysql_query("select * from customer_master");
                    while($row_customer = mysql_fetch_assoc($sq_customer)){
                      ?>
                      <option value="<?= $row_customer['customer_id'] ?>"><?= $row_customer['first_name'].' '.$row_customer['middle_name'].' '.$row_customer['last_name'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <select name="booking_id" id="booking_id" style="width:100%" disabled>              
                  <option value="<?= $sq_booking['booking_id'] ?>"><?= get_forex_booking_id($sq_booking['booking_id'],$year) ?></option>
                  <?php
                  $sq_booking = mysql_query("select * from forex_booking_master where customer_id='$sq_booking[customer_id]'");
                  while($row_booking = mysql_fetch_assoc($sq_booking)){
                    ?>
                    <option value="<?= $row_booking['booking_id'] ?>"><?= get_forex_booking_id($row_booking['booking_id'],$year) ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="payment_date" name="payment_date" readonly placeholder="Date" title="Date" value="<?= date('d-m-Y', strtotime($sq_payment_info['payment_date'])) ?>">
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <select name="payment_mode" id="payment_mode" title="Mode" disabled onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                    <option value="<?= $sq_payment_info['payment_mode'] ?>"><?= $sq_payment_info['payment_mode'] ?></option>
                    <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
          </div>
          <div class="row mg_bt_10">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="Amount" title="Amount" value="<?= $sq_payment_info['payment_amount'] ?>" onchange="validate_balance(this.id);get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details1','credit_charges1');">
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment_info['bank_name'] ?>" <?= $enable ?> />
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_payment_info['transaction_id'] ?>" <?= $enable ?>>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <select name="bank_id" id="bank_id" title="Select Bank" <?= $enable ?> disabled>
                  <?php 
                  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment_info[bank_id]'"));
                  if($sq_bank['bank_id'] !=''){
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option> <?php } ?>
                  <?php get_bank_dropdown(); ?>
                </select>
              </div>
          </div>
          <?php if($sq_payment_info['payment_mode'] == 'Credit Card'){?>
          <div class="row mg_tp_10">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="credit_charges1" name="credit_charges1" title="Credit card charges" value="<?=$sq_payment_info['credit_charges']?>" disabled>
              <input type="hidden" id="credit_charges_old" name="credit_charges_old" title="Credit card charges" value="<?=$sq_payment_info['credit_charges']?>" disabled>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input class="text" type="text" id="credit_card_details1" name="credit_card_details1" title="Credit card details"  value="<?= $sq_payment_info['credit_card_details'] ?>" disabled>
            </div>
          </div>
          <?php } ?>

          <div class="row mg_tp_10 text-center">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="pay_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
              </div>
          </div>

        </form>
        
      </div>     
    </div>
  </div>
</div>

<script>
$('#customer_id, #booking_id').select2();
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#update_modal').modal('show');  
$(function(){

$('#frm_update').validate({
  rules:{
    booking_id : { required : true },
    payment_date : { required : true },
    payment_amount : { required : true, number: true },
    payment_mode : { required : true },
    bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
    transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
    bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
  },
  submitHandler:function(form){

    var payment_id = $('#payment_id_update').val();
    var booking_id = $('#booking_id').val();
    var payment_date = $('#payment_date').val();
    var payment_amount = $('#payment_amount').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();  
    var bank_id = $('#bank_id').val();
    var payment_old_value = $('#payment_old_value').val();
    var credit_charges = $('#credit_charges1').val();
    var credit_card_details = $('#credit_card_details1').val();
    var credit_charges_old = $('#credit_charges_old').val();

    if(!check_updated_amount(payment_old_value,payment_amount)){
      error_msg_alert("You can update receipt to 0 only!");
      return false;
    }
    $('#pay_update').button('loading');
      $.ajax({
        type: 'post',
        url: base_url()+'controller/forex/payment/payment_update.php',
        data:{ payment_id : payment_id, booking_id : booking_id, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_old_value : payment_old_value,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old },
        success: function(result){
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
            $('#pay_update').button('reset');
          }
          else{
            msg_alert(result);
            reset_form('frm_update');
            $('#update_modal').modal('hide');  
            $('#pay_update').button('reset');
            list_reflect();
          }
          
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>