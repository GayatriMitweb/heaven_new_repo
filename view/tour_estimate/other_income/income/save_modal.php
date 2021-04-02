<?php
include "../../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Income</h4>
      </div>
      <div class="modal-body">

            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="income_type_id" id="income_type_id" title="Income Type">
                  <option value="">*Income Type</option>
                  <?php 
                  $sq_income_type = mysql_query("select * from other_income_type_master  order by income_type");
                  while($row_income_type = mysql_fetch_assoc($sq_income_type)){
                    ?>
                    <option value="<?= $row_income_type['income_type_id'] ?>"><?= $row_income_type['income_type'] ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Payment Amount" onchange="number_validate(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="Payment Date" title="Payment Date" value="<?= date('d-m-Y')?>">
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
                <input type="text" id="transaction_id" name="transaction_id" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" disabled>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select name="bank_id" id="bank_id" title="Select Bank" disabled>
                  <?php get_bank_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-8 col-sm-6 col-xs-12 mg_bt_10">
                <textarea name="particular" id="particular" rows="1" placeholder="*Expense Narration" title="Expense Narration"></textarea>
              </div>
            </div>

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
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

$('#frm_save').validate({
  rules:{
          income_type_id : { required: true },
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

    var income_type_id = $('#income_type_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_mode = $('#payment_mode').val();
    var bank_name = $('#bank_name').val();
    var transaction_id = $('#transaction_id').val();
    var bank_id = $('#bank_id').val();
    var particular = $('#particular').val();

    $('#btn_save').button('loading');

    $.ajax({
      type:'post',
      url:base_url+'controller/tour_estimate/other_income/income_save.php',
      data: { income_type_id : income_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, particular : particular },
      success:function(result){        
        msg_alert(result);
        $('#btn_save').button('reset');
        var msg = result.split('--');
        if(msg[0]!="error"){
          $('#save_modal').modal('hide');
          income_list_reflect();
        }
      }     
    });

  }
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>