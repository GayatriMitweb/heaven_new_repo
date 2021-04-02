<?php
include "../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Payment</h4>
      </div>
      <div class="modal-body">            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="sup_id" name="sup_id" style="width:100%" title="Supplier">
                  <option value="">Select Supplier</option>
                  <?php 
                  $sq_sup = mysql_query("select * from visa_vendor where active_flag='Active' ");
                  while($row_sup = mysql_fetch_assoc($sq_sup)){
                    ?>
                    <option value="<?= $row_sup['vendor_id'] ?>"><?= $row_sup['vendor_name'] ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Topup Amount" title="Topup Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="*Payment Date" title="Payment Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="payment_mode" id="payment_mode" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" disabled>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="transaction_id" name="transaction_id" onchange="validate_balance(this.id);" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="bank_id" id="bank_id" title="Select Bank" disabled>
                  <?php get_bank_dropdown('Debitor Bank'); ?>
                </select>
              </div>
            </div>
               <div class="col-md-9 col-sm-9 no-pad mg_bt_20">
                 <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
               </div>  

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
            </div>
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#save_modal').modal('show');
$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#sup_id').select2();

$('#frm_save').validate({
  rules:{
          sup_id : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          payment_mode :{ required : true },
          bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },               
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var sup_id = $('#sup_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();
    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
    if(data !== 'valid'){
      error_msg_alert("The Payment date does not match between selected Financial year.");
      return false;
    }
    else{
        $('#btn_save').button('loading');
        $.ajax({
          type:'post',
          url:base_url+'controller/visa_supplier/payment_save.php',
          data: { sup_id : sup_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id },
          success:function(result){        
            msg_alert(result);
            var msg = result.split('--');
            if(msg[0]!="error"){
              $('#save_modal').modal('hide');
              list_reflect();
            }
          }     
        });
    }
    });
  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>