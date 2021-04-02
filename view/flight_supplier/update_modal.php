<?php
include "../../model/model.php";

$id = $_POST['id'];
$sq_payment = mysql_fetch_assoc(mysql_query("select * from flight_supplier_payment where id='$id'"));

$disabled = ($sq_payment['payment_mode']=="Cash") ? "disabled" : "";
?>
<form id="frm_update">
<input type="hidden" name="pay_id" id="pay_id1" value="<?= $id ?>">
<input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment['payment_amount'] ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Payment</h4>
      </div>
      <div class="modal-body">

            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">                
                <select id="sup_id1" name="sup_id" style="width:100%" title="Supplier" disabled>
                  <?php  if($sq_payment['supplier_id']!='0'){ 
                  $supplier_id = $sq_payment['supplier_id'];
                  $sq_sup1 = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$sq_payment[supplier_id]'"));
                  ?>
                  <option value="<?= $sq_sup1['vendor_id'] ?>"><?= $sq_sup1['vendor_name'] ?></option>
                  <option value="">Select Supplier</option>
                  <?php 
                  $sq_sup = mysql_query("select * from ticket_vendor where active_flag='Active' ");
                  while($row_sup = mysql_fetch_assoc($sq_sup)){
                    ?>
                    <option value="<?= $row_sup['vendor_id'] ?>"><?= $row_sup['vendor_name'] ?></option>
                    <?php
                  }
                }else{
                  ?>
                   <option value="">Select Supplier</option>
                  <?php 
                  $sq_sup = mysql_query("select * from ticket_vendor where active_flag='Active' ");
                  while($row_sup = mysql_fetch_assoc($sq_sup)){
                    ?>
                    <option value="<?= $row_sup['vendor_id'] ?>"><?= $row_sup['vendor_name'] ?></option>
                <?php  }
                } ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount1" name="payment_amount" placeholder="Topup Amount" title="Topup Amount" value="<?= $sq_payment['payment_amount'] ?>" onchange="validate_balance(this.id);">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date1" name="payment_date" placeholder="Payment Date" title="Payment Date" value="<?= get_date_user($sq_payment['payment_date']) ?>" readonly>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="payment_mode" id="payment_mode1" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')" disabled>
                  <option value="<?= $sq_payment['payment_mode'] ?>"><?= $sq_payment['payment_mode'] ?></option>
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="bank_name1" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" <?= $disabled ?> value="<?= $sq_payment['bank_name'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="transaction_id1" name="transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" <?= $disabled ?> onchange="validate_balance(this.id); " value="<?= $sq_payment['transaction_id'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="bank_id" id="bank_id1" title="Select Bank" <?= $disabled ?> disabled>
                  <?php 
                  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));
                  if($sq_payment['payment_mode'] == 'Cash')
                  {
                    get_bank_dropdown();
                  }
                  else{
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                  <?php get_bank_dropdown(); }?>
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
$('#payment_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#sup_id1').select2();
$('#frm_update').validate({
  rules:{
          sup_id : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          payment_mode :{ required : true },
          bank_name : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
          bank_id : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },               
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var pay_id = $('#pay_id1').val();
    var sup_id = $('#sup_id1').val();
    var payment_amount = $('#payment_amount1').val();
    var payment_date = $('#payment_date1').val();
    var payment_mode = $('#payment_mode1').val();
    var bank_name = $('#bank_name1').val();
    var transaction_id = $('#transaction_id1').val();
    var bank_id = $('#bank_id1').val();
    var payment_old_value = $('#payment_old_value').val();

    $('#btn_update').button('loading');
    $.ajax({
      type:'post',
      url:base_url+'controller/flight_supplier/payment_update.php',
      data: { pay_id : pay_id, sup_id : sup_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_old_value : payment_old_value },
      success:function(result){        
        msg_alert(result);
        var msg = result.split('--');
        if(msg[0]!="error"){
          $('#update_modal').modal('hide');
          list_reflect();
        }
      }     
    });
  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>