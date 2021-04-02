<?php
include "../../../model/model.php";

$advance_id = $_POST['advance_id'];
$sq_income_info = mysql_fetch_assoc(mysql_query("select * from corporate_advance_master where advance_id='$advance_id'"));

$disabled = ($sq_income_info['payment_mode']=="Cash"||$sq_income_info['payment_mode']=="Credit Note"||$sq_income_info['payment_mode']=="Credit Card") ? "disabled" : "";
?>
<form id="frm_update">
<input type="hidden" name="advance_id" id="advance_id" value="<?= $advance_id ?>">
<input type="hidden" name="payment_amount_old" id="payment_amount_old" value="<?= $sq_income_info['payment_amount'] ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Advance</h4>
      </div>
      <div class="modal-body">

            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="cust_id" name="cust_id" style="width:100%" title="Customer" disabled>
                  <?php 
                  $cust_id = $sq_income_info['cust_id'];
                  $sq_income_type = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$cust_id'"));
                  if($sq_income_type['type'] == 'Corporate'){
                    $customer_name = $sq_income_type['company_name'];
                  }else{
                    $customer_name = $sq_income_type['first_name'].' '.$sq_cust['last_name'];
                  }
                  ?>
                  <option value="<?= $sq_income_type['customer_id'] ?>"><?= $customer_name ?></option>
                  <option value="">Select Customer</option>
                  <?php 
                  $sq_cust = mysql_query("select * from customer_master where type='Corporate' and active_flag='Active' ");
                  while($row_cust = mysql_fetch_assoc($sq_cust)){
                    ?>
                    <option value="<?= $row_cust['customer_id'] ?>"><?= $row_cust['first_name'].' '.$row_cust['last_name'] ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" value="<?= $sq_income_info['payment_amount'] ?>" onchange="validate_balance(this.id)">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" readonly placeholder="Date" title="Date" value="<?= get_date_user($sq_income_info['payment_date']) ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="payment_mode" id="payment_mode" class="form-control" title="Mode" disabled onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')">
                  <option value="<?= $sq_income_info['payment_mode'] ?>"><?= $sq_income_info['payment_mode'] ?></option>
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
                  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_income_info[bank_id]'"));
                  if($sq_income_info['payment_mode'] == 'Cash'||$sq_income_info['payment_mode'] == 'Credit Note')
                  {
                    get_bank_dropdown();
                  }
                  else
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                  <?php get_bank_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-8 col-sm-6 col-xs-12 mg_bt_10">
                <textarea name="particular" id="particular" rows="1" onchange="validate_address(this.id)" placeholder="*Particular" title="Particular"><?= $sq_income_info['particular'] ?></textarea>
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
$('#cust_id').select2();
$('#frm_update').validate({
  rules:{
          cust_id : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
          payment_mode :{ required : true },
          bank_name : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },
          transaction_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          bank_id : { required : function(){  if($('#payment_mode').val()!="Cash"){ return true; }else{ return false; }  }  },     
          particular : { required: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var advance_id = $('#advance_id').val();
    var cust_id = $('#cust_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();
    var particular = $('#particular').val();
    var payment_amount_old = $('#payment_amount_old').val();
    
    $('#btn_update').button('loading');
    $.ajax({
      type:'post',
      url:base_url+'controller/corporate_advance/corporate_update.php',
      data: { advance_id : advance_id, cust_id : cust_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, particular : particular,payment_amount_old : payment_amount_old },
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