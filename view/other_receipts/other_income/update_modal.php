<?php
include "../../../model/model.php";

$payment_id = $_POST['payment_id'];
$sq_income_info = mysql_fetch_assoc(mysql_query("select * from other_income_payment_master where payment_id='$payment_id'"));
$sq_income_l = mysql_fetch_assoc(mysql_query("select * from other_income_master where income_id='$sq_income_info[income_type_id]'"));
$disabled = ($sq_income_info['payment_mode']=="Cash" ||$sq_income_info['payment_mode']=="" || $sq_income_info['payment_mode']=="Credit Note" ||$sq_income_info['payment_mode']=="Credit Card") ? "disabled" : "";
?>
<form id="frm_update">
<input type="hidden" name="payment_id" id="payment_id" value="<?= $payment_id ?>">
<input type="hidden" name="payment_old_value" id="payment_old_value" value="<?= $sq_income_info['payment_amount'] ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Income</h4>
      </div>
      <div class="modal-body">

            
            <div class="row">
              <div class="col-md-5 col-sm-6 col-xs-12 mg_bt_10">
                <select name="income_type_id" title="Income Type" id="income_type_id" disabled>
                  <?php 
                  $sq_income = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$sq_income_l[income_type_id]'"));
                  ?>
                  <option value="<?= $sq_income['ledger_id'] ?>"><?= $sq_income['ledger_name'] ?></option>
                  </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="Amount" title="Amount" value="<?= $sq_income_info['payment_amount'] ?>" onchange="validate_balance(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="Date" readonly title="Date" value="<?= get_date_user($sq_income_info['payment_date']) ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="payment_mode" id="payment_mode" class="form-control" title="Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')" disabled>
                  <?php if($sq_income_info['payment_mode'] != ''){?>
                  <option value="<?= $sq_income_info['payment_mode'] ?>"><?= $sq_income_info['payment_mode'] ?></option>
                  <?php } ?>
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" <?= $disabled ?> value="<?= $sq_income_info['bank_name'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id)" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" <?= $disabled ?> value="<?= $sq_income_info['transaction_id'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="bank_id" id="bank_id" title="Select Bank" <?= $disabled ?> disabled>
                <?php 
                if($sq_income_info['bank_id'] != '0'){
                  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_income_info[bank_id]'"));  
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                  <?php
                }
                ?>
                <?php get_bank_dropdown(); ?>
                </select>
              </div>
            </div>

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
              </div>
            </div>


        
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#update_modal').modal('show');
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#frm_update').validate({
  rules:{
          income_type_id : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          payment_mode :{ required : true },
          bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  }, 
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var payment_id = $('#payment_id').val();
    var income_type_id = $('#income_type_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();
    var payment_old_value = $('#payment_old_value').val();

    $('#btn_update').button('loading');
    $.ajax({
      type:'post',
      url:base_url+'controller/tour_estimate/other_income/income_update.php',
      data: { payment_id : payment_id, income_type_id : income_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id,payment_old_value : payment_old_value },
      success:function(result){        
        msg_alert(result);
        var msg = result.split('--');
        if(msg[0]!="error"){
          $('#update_modal').modal('hide');
          income_list_reflect();
        }
      }     
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>