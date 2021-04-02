<?php
include "../../../../model/model.php";
 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id']; 
$branch_status = $_POST['branch_status'];
$payment_id = $_POST['payment_id'];
$sq_payment = mysql_fetch_assoc(mysql_query("select * from hotel_booking_payment where payment_id='$payment_id'"));

$enable = ($sq_payment['payment_mode']=="Cash" || $sq_payment['payment_mode']=="Credit Note" || $sq_payment['payment_mode']=="Credit Card") ? "disabled" : "";

?>
<form id="frm_payment_update">
<input type="hidden" id="payment_id" name="payment_id" value="<?= $payment_id ?>">
<input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment['payment_amount'] ?>">

<div class="modal fade" id="payment_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
              <select name="booking_id1" id="booking_id1" title="Booking" style="width:100%" disabled>
                <?php 
                $sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$sq_payment[booking_id]'"));
                $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
                if($sq_customer['type']=='Corporate'){
                ?>
                  <option value="<?= $sq_booking['booking_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                <?php }  else{ ?>
                    <option value="<?= $sq_booking['booking_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                  <?php } ?>
                  <?php   get_hotel_booking_dropdown($role, $branch_admin_id, $branch_status,$emp_id)  ?>
              </select>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <select id="payment_mode1" name="payment_mode1" class="form-control" required title="Payment Mode" disabled onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')">
              <?php if($sq_payment['payment_mode'] != ' '){?>
              <option value="<?= $sq_payment['payment_mode'] ?>"><?= $sq_payment['payment_mode'] ?></option>
              <?php } ?>
              <?php echo get_payment_mode_dropdown(); ?>
            </select>  
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_amount1" name="payment_amount1" placeholder="Amount" value="<?= $sq_payment['payment_amount'] ?>" onchange="validate_balance(this.id);get_credit_card_charges('identifier','payment_mode1','payment_amount1','credit_card_details1','credit_charges1');">
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_date1" name="payment_date1" placeholder="Date" readonly value="<?= date('d-m-Y', strtotime($sq_payment['payment_date'])) ?>">
          </div>
          
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="bank_name1" onchange="fname_validate(this.id)" name="bank_name1" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment['bank_name'] ?>" <?= $enable ?> />
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="transaction_id1" name="transaction_id1" onchange="validate_specialChar(this.id)" class="form-control" placeholder="Cheque No / ID" title="Cheque No / ID" value="<?= $sq_payment['transaction_id'] ?>" <?= $enable ?> />
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
            <select name="bank_id1" id="bank_id1" title="Creditor Bank" <?= $enable ?> disabled>
              <?php 
              if($sq_payment['bank_id'] != '0'){
                $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));  
                ?>
                <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                <?php
              }
              ?>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
        </div>
        <?php if($sq_payment['payment_mode'] == 'Credit Card'){?>
				<div class="row mg_tp_10">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input type="text" id="credit_charges1" name="credit_charges1" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
						<input type="hidden" id="credit_charges_old" name="credit_charges_old" title="Credit card charges" value="<?=$sq_payment['credit_charges']?>" disabled>
					</div>
					<!-- <div class="col-md-3 col-sm-6 col-xs-12">
						<select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
						><option value=''>Select Identifier</option></select>
					</div> -->
					<div class="col-md-4 col-sm-6 col-xs-12">
						<input class="text" type="text" id="credit_card_details1" name="credit_card_details1" title="Credit card details"  value="<?= $sq_payment['credit_card_details'] ?>" disabled>
					</div>
				</div>
        <?php } ?>

       
        <div class="row text-center mg_tp_20">
          <div class="col-xs-12">
              <button class="btn btn-sm btn-success" id="btn_update_hotel"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>
</form>
<script>
$('#payment_update_modal').modal('show');
$('#payment_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#booking_id1').select2();
$(function(){
  $('#frm_payment_update').validate({
      rules:{
              booking_id1 : { required: true },
              payment_amount1 : { required: true, number:true },
              payment_date1 : { required: true },
              payment_mode1 : { required : true },
              bank_name1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){

              var payment_id = $('#payment_id').val();
              var booking_id = $('#booking_id1').val();
              var payment_amount = $('#payment_amount1').val();
              var payment_date = $('#payment_date1').val();
              var payment_mode = $('#payment_mode1').val();
              var bank_name = $('#bank_name1').val();
              var transaction_id = $('#transaction_id1').val();
              var bank_id = $('#bank_id1').val();
              var payment_old_value = $('#payment_old_value').val();
              var credit_charges = $('#credit_charges1').val();
              var credit_card_details = $('#credit_card_details1').val();
              var credit_charges_old = $('#credit_charges_old').val();
              if(!check_updated_amount(payment_old_value,payment_amount)){
              error_msg_alert("You can update receipt to 0 only!");
              return false;
            }
              var base_url = $('#base_url').val();
              $('#btn_update_hotel').button('loading');

              $.ajax({
                type:'post',
                url: base_url+'controller/hotel/payment/payment_update.php',
                data:{ payment_id : payment_id, booking_id : booking_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id,payment_old_value : payment_old_value,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old  },
                success:function(result){
                  msg_popup_reload(result);
                  $('#btn_update_hotel').button('reset');
                },
                error:function(result){
                  console.log(result.responseText);
                  $('#btn_update_hotel').button('reset');
                }
              });


      }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>