<?php 
include_once('../../../../model/model.php');
$payment_id = $_POST['payment_id'];
$sq_payment = mysql_fetch_assoc(mysql_query("select * from vendor_advance_master where payment_id='$payment_id'"));

$enable = ($sq_payment['payment_mode']=="Cash" || $sq_payment['payment_mode']=="Credit Card") ? "disabled" : "";
?>
<div class="modal fade" id="payment_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Advance</h4>
      </div>
      <div class="modal-body">
        

        <form id="frm_vendor_payment_update">

        <input type="hidden" id="payment_id_update" name="payment_id_update" value="<?= $payment_id ?>">
        <input type="hidden" id="ledger_id" name="ledger_id" value="<?= $sq_payment['ledger_id'] ?>">
        <input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment['payment_amount'] ?>">

          <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
          <legend>Select Sale</legend>

            <div class="row">
              <div class="col-md-3">
                <select name="vendor_type1" id="vendor_type1" title="Supplier Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content1', '1')" disabled>
                  <option value="<?= $sq_payment['vendor_type'] ?>"><?= $sq_payment['vendor_type'] ?></option>
                  <?php 
                    $sq_vendor = mysql_query("select * from vendor_type_master order by vendor_type");
                    while($row_vendor = mysql_fetch_assoc($sq_vendor)){
                      ?>
                      <option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <div id="div_vendor_type_content1" style="pointer-events: none;">                
              </div>
              <script>
                vendor_type_data_load('<?= $sq_payment['vendor_type'] ?>', 'div_vendor_type_content1', '1', <?= $sq_payment['vendor_type_id'] ?>);
              </script>
            </div>

          </div>

          <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
          <legend>Update Payment</legend>

             <div class="row mg_bt_20">                      
              <div class="col-md-4">
                <input type="text" id="payment_date1" name="payment_date1" class="form-control" placeholder="Date" title="Payment Date" value="<?= date('d-m-Y', strtotime($sq_payment['payment_date'])) ?>" readonly>
              </div>  
              <div class="col-md-4">
                <input type="text" id="payment_amount1" name="payment_amount1" class="form-control" placeholder="Amount" title="Payment Amount" value="<?= $sq_payment['payment_amount'] ?>" onchange="validate_balance(this.id)">
              </div>             
              <div class="col-md-4">
                <select name="payment_mode1" id="payment_mode1" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')" disabled>
                  <option value="<?= $sq_payment['payment_mode'] ?>"><?= $sq_payment['payment_mode'] ?></option>
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
            </div>
            <div class="row mg_bt_10">
              <div class="col-md-4">
                <input type="text" id="bank_name1" name="bank_name1" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment['bank_name'] ?>" <?= $enable ?>>
              </div>
              <div class="col-md-4">
                <input type="text" id="transaction_id1" onchange="validate_balance(this.id)" name="transaction_id1" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_payment['transaction_id'] ?>" <?= $enable ?>>
              </div>
               <div class="col-md-4">
                <select name="bank_id1" id="bank_id1" title="Debitor Bank" <?= $enable ?> disabled>
                  <?php 
                  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));
                  if($sq_bank['bank_id'] != ''){
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                  <?php  } get_bank_dropdown('Debitor Bank'); ?>
                </select>
              </div>
            </div>  
            <div class="row">
              <div class="col-md-8">
                  <div class="div-upload pull-left" id="div_upload_button1">
                      <div id="payment_evidence_upload1" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status1" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url1" name="payment_evidence_url1" value="<?= $sq_payment['payment_evidence_url'] ?>">
                  </div>
                </div>
            </div>         

          </div>

          <div class="row text-center">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
              </div>
          </div>

        </form>



      </div>      
    </div>
  </div>
</div>
<script>
payment_evidence_upload(1);
$('#payment_update_modal').modal('show');

$('#payment_date1').datetimepicker({timepicker:false, format:'d-m-Y'});

$(function(){
  $('#frm_vendor_payment_update').validate({
      rules:{
              payment_amount1 : { required: true, number:true },
              payment_date1 : { required: true },
              payment_mode1 : { required : true },
              bank_name1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){

              var payment_id = $('#payment_id_update').val();

              var vendor_type = $('#vendor_type1').val();
              var vendor_type_id = get_vendor_type_id('vendor_type1', '1');

              var payment_amount = $('#payment_amount1').val();
              var payment_date = $('#payment_date1').val();
              var payment_mode = $('#payment_mode1').val();
              var bank_name = $('#bank_name1').val();
              var transaction_id = $('#transaction_id1').val();
              var bank_id = $('#bank_id1').val();
              var ledger_id = $('#ledger_id').val();
              var payment_old_value = $('#payment_old_value').val();
              var payment_evidence_url = $('#payment_evidence_url1').val();
             
              $.ajax({
                type:'post',
                url: base_url()+'controller/vendor/dashboard/advances/payment_update.php',
                data:{ payment_id : payment_id, vendor_type : vendor_type, vendor_type_id : vendor_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_evidence_url : payment_evidence_url,payment_old_value : payment_old_value,ledger_id : ledger_id },
                success:function(result){
                  msg_alert(result);
                  $('#payment_update_modal').modal('hide');
                  $('#payment_update_modal').on('hidden.bs.modal', function(){
                    payment_list_reflect();
                  });
                },
                error:function(result){
                  console.log(result.responseText);
                }
              });


      }
  });
});
</script>  
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>