<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$payment_id = $_POST['payment_id'];

$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_payment_master where payment_id='$payment_id'"));

$sq_ticket = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$sq_payment_info[train_ticket_id]'"));
$date = $sq_ticket['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$enable = ($sq_payment_info['payment_mode']=="Cash" || $sq_payment_info['payment_mode']=="Credit Note"|| $sq_payment_info['payment_mode']=="Credit Card") ? "disabled" : "";
?>

<div class="modal fade" id="train_ticket_payment_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>
      </div>
      <div class="modal-body">

        <form id="frm_train_ticket_payment_update">

			   <input type="hidden" id="payment_id_update" name="payment_id_update" value="<?= $payment_id ?>">
         <input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment_info['payment_amount'] ?>">

         <div class="row mg_bt_10">
          <div class="col-md-3">
              <select name="customer_id1" id="customer_id1" title="Customer Name" style="width:100%" onchange="train_ticket_id_dropdown_load('customer_id1', 'train_ticket_id1');" disabled>
                <?php 
                $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
                if($sq_customer['type']=='Corporate'){
                ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                <?php }  else{ ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                <?php } ?>
                  <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
              </select>
          </div>
          <div class="col-md-3">
            <select name="train_ticket_id1" id="train_ticket_id1" style="width:100%" title="Booking ID" disabled>              
			         <option value="<?= $sq_ticket['train_ticket_id'] ?>"><?= 'TTK/'.$year.'/'.$sq_ticket['train_ticket_id'] ?></option>
              <?php
              $sq_ticket = mysql_query("select * from train_ticket_master where customer_id='$sq_ticket[customer_id]'");
              while($row_ticket = mysql_fetch_assoc($sq_ticket)){
                ?>
                <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= 'TTK/'.$year.'/'.$row_ticket['train_ticket_id'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" id="payment_date1" name="payment_date1" class="form-control" placeholder="Date" title="Date" value="<?= date('d-m-Y', strtotime($sq_payment_info['payment_date'])) ?>" readonly>
          </div>
          <div class="col-md-3">
            <input type="text" id="payment_amount1" name="payment_amount1" class="form-control" placeholder="Amount" title="Amount" value="<?= $sq_payment_info['payment_amount'] ?>" onchange="number_validate(this.id);get_credit_card_charges('identifier','payment_mode1','payment_amount1','credit_card_details1','credit_charges1');">
          </div>          
        </div>
        <div class="row mg_bt_10">
          <div class="col-md-3">
            <select name="payment_mode1" id="payment_mode1" class="form-control" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')" disabled>
              		<option value="<?= $sq_payment_info['payment_mode'] ?>"><?= $sq_payment_info['payment_mode'] ?></option>
                  <?php get_payment_mode_dropdown(); ?>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" id="bank_name1" name="bank_name1" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment_info['bank_name'] ?>" <?= $enable ?>>
          </div>
          <div class="col-md-3">
            <input type="text" id="transaction_id1" onchange="validate_specialChar(this.id);" name="transaction_id1" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_payment_info['transaction_id'] ?>" <?= $enable ?>>
          </div>
          <div class="col-md-3">
            <select name="bank_id1" id="bank_id1" title="Creditor Bank" <?= $enable ?> disabled>
              <?php 
              $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment_info[bank_id]'"));
              if($sq_bank['bank_id'] != ''){
              ?>
              <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
              <?php } get_bank_dropdown(); ?>
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

        <div class="row text-center mg_tp_20">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="train_p_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
        </div>

        </form>
        
      </div>     
    </div>
  </div>
</div>

<script>
$('#customer_id1, #train_ticket_id1').select2();
$('#payment_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#train_ticket_payment_update_modal').modal('show');  
$(function(){

$('#frm_train_ticket_payment_update').validate({
  rules:{
    train_ticket_id1 : { required : true },
    payment_date1 : { required : true },
    payment_amount1 : { required : true, number: true },
    payment_mode1 : { required : true },
    bank_name1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },
    transaction_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
    bank_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
  },
  submitHandler:function(form){

    var payment_id = $('#payment_id_update').val();
    var train_ticket_id = $('#train_ticket_id1').val();
    var payment_date = $('#payment_date1').val();
    var payment_amount = $('#payment_amount1').val();
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
    $('#train_p_update').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/visa_passport_ticket/train_ticket/ticket_master_payment_update.php',
        data:{ payment_id : payment_id, train_ticket_id : train_ticket_id, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_old_value : payment_old_value,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old },
        success: function(result){
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
            $('#train_p_update').button('reset');
          }
          else{
            msg_alert(result);
            reset_form('frm_train_ticket_payment_update');
            $('#train_p_update').button('reset');
            $('#train_ticket_payment_update_modal').modal('hide');  
            train_ticket_payment_list_reflect();
          }
          
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>