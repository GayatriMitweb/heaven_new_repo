<?php
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="train_ticket_payment_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Receipt</h4>
      </div>
      <div class="modal-body">

        <form id="frm_train_ticket_payment_save">
         <div class="row mg_bt_10">
            <div class="col-md-3">
              <select name="customer_id" id="customer_id" title="Customer Name" style="width:100%" onchange="train_ticket_id_dropdown_load('customer_id', 'train_ticket_id');">
                <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
              </select>
            </div>
            <div class="col-md-3">
              <select name="train_ticket_id" id="train_ticket_id" onchange="get_outstanding('train',this.id);" style="width:100%" title="Booking ID">
                <option value="">*Booking ID</option>
              </select>
            </div>           
          <div class="col-md-3">
            <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="*Date" title="Date" value="<?= date('d-m-Y') ?>" onchange="check_valid_date(this.id)">
          </div>  
          <div class="col-md-3">
            <select name="payment_mode" id="payment_mode" class="form-control" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id');get_identifier_block('identifier','payment_mode','credit_card_details','credit_charges');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges')">
                <?php get_payment_mode_dropdown(); ?>
            </select>
          </div>            
        </div>
        <div class="row mg_bt_10">
          <div class="col-md-3">
            <input type="text" id="payment_amount" name="payment_amount" class="form-control" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id');get_credit_card_charges('identifier','payment_mode','payment_amount','credit_card_details','credit_charges');">
          </div>
          <div class="col-md-3">
            <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
          </div>
          <div class="col-md-3">
            <input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id);" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
          </div>
          <div class="col-md-3">
            <select name="bank_id" id="bank_id" title="Select Bank" disabled>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
        </div>
        <div class="row mg_tp_10">
          <div class="col-md-3 col-sm-3">
            <input type="text" id="outstanding" name="outstanding" class="form-control" placeholder="Outstanding" title="Outstanding" readonly/>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','payment_mode','credit_card_details')" title="Identifier(4 digit)" required
            ><option value=''>Select Identifier</option></select>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
          </div>
        </div>
        <div class="row mg_tp_10">
          <div class="col-md-9 col-sm-9">
           <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
         </div>
        </div>

        <div class="row text-center">
            <div class="col-md-12">
              <button id="btn_save_patment" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
        </div>

        </form>
        
      </div>     
    </div>
  </div>
</div>

<script>
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#customer_id, #train_ticket_id').select2();

$(function(){

$('#frm_train_ticket_payment_save').validate({
  rules:{
    train_ticket_id : { required : true },
    payment_date : { required : true },
    payment_amount : { required : true, number: true },
    payment_mode : { required : true },
    bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
    transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
    bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
  },
  submitHandler:function(form){

    var train_ticket_id = $('#train_ticket_id').val();
    var payment_date = $('#payment_date').val();
    var payment_amount = $('#payment_amount').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();
    var branch_admin_id = $('#branch_admin_id1').val();
		var credit_charges = $('#credit_charges').val();
		var credit_card_details = $('#credit_card_details').val();


    var base_url = $('#base_url').val();
    //Validation for booking and payment date in login financial year
    var check_date1 = $('#payment_date').val();
    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: check_date1 }, function(data){
      if(data !== 'valid'){
        error_msg_alert("The Payment date does not match between selected Financial year.");
        return false;
      } else{
          $('#btn_save_patment').button('loading');
          if($('#whatsapp_switch').val() == "on") whatsapp_send_r(train_ticket_id, payment_amount, base_url);
          $.ajax({
            type: 'post',
            url: base_url+'controller/visa_passport_ticket/train_ticket/ticket_master_payment_save.php',
            data:{ train_ticket_id : train_ticket_id, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id , branch_admin_id : branch_admin_id,credit_charges:credit_charges,credit_card_details:credit_card_details },
            success: function(result){
              $('#btn_save_patment').button('reset');
              var msg = result.split('-');
              if(msg[0]=='error'){
                msg_alert(result);
              }
              else{
                msg_alert(result);
                reset_form('frm_train_ticket_payment_save');
                $('#train_ticket_payment_save_modal').modal('hide');  
                train_ticket_payment_list_reflect();
              }
              
            }
          });
      }
    });
  }
});

});
</script>