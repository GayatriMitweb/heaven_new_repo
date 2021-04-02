<?php 
include_once('../../../model/model.php');
$payment_id = $_POST['payment_id'];
$sq_payment = mysql_fetch_assoc(mysql_query("select * from other_expense_payment_master where payment_id='$payment_id'"));

$sq_est = mysql_fetch_assoc(mysql_query("select sum(total_fee) as net_total from other_expense_master where expense_type_id='$sq_payment[expense_type_id]' and supplier_id='$sq_payment[supplier_id]'"));

$sq_paid = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from other_expense_payment_master where expense_type_id='$sq_payment[expense_type_id]' and supplier_id='$sq_payment[supplier_id]'"));
$balance_amount = $sq_est['net_total'] - $sq_paid['payment_amount'];
$enable = ($sq_payment['payment_mode']=="Cash") ? "disabled" : "";

$sq_expense = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$sq_payment[supplier_id]'"));
$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$sq_payment[expense_type_id]'"));

$sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_payment[bank_id]'"));

?>
<div class="modal fade" id="payment_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="margin-top:20px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Payment Update</h4>
      </div>
      <div class="modal-body">
        

        <form id="frm_vendor_payment_update">

        <input type="hidden" id="payment_id_update" name="payment_id_update" value="<?= $payment_id ?>">
        <input type="hidden" id="payment_old_value" name="payment_old_value" value="<?= $sq_payment['payment_amount'] ?>">
        <input type="hidden" id="payment_old_mode" name="payment_old_mode" value="<?= $sq_payment['payment_mode'] ?>">
        <input type="hidden" id="balance_amount" name="balance_amount" value="<?= $balance_amount ?>">
        <input type="hidden" id="old_bank_id" name="old_bank_id" value="<?= $sq_bank['bank_id'] ?>">
          <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
          <legend>Payment For</legend>

            <div class="row">
             <?php if($sq_payment['supplier_id'] != '0'){ ?>
              <div class="col-md-3">
                <select name="supplier_id1" id="supplier_id1" title="Supplier Type" disabled>
                  <option value="<?= $sq_expense['vendor_id'] ?>"><?= $sq_expense['vendor_name'] ?></option>
                </select>
              </div>
              <?php } ?>
              <?php if($sq_payment['expense_type_id'] != '0'){ ?>
               <div class="col-md-3">
                <select name="expense_type_p1" id="expense_type_p1" class="form-control" title="Expense Type" disabled>
                  <option value="<?= $sq_payment['expense_type_id'] ?>"><?= $sq_ledger['ledger_name'] ?></option>
                </select>
              </div>
              <?php } ?> 
            </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
          <legend>Update Payment</legend>

             <div class="row mg_bt_20">                      
              <div class="col-md-4">
                <input type="text" id="payment_date1" name="payment_date1" class="form-control" placeholder="Date" title="Payment Date" value="<?= date('d-m-Y', strtotime($sq_payment['payment_date'])) ?>" readonly>
              </div>  
              <div class="col-md-4">
                <input type="text" id="payment_amount1" name="payment_amount1" class="form-control" placeholder="Amount" title="Payment Amount" value="<?= $sq_payment['payment_amount'] ?>" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode12','transaction_id1','bank_name1')">
              </div>             
              <div class="col-md-4">
                <select name="payment_mode12" id="payment_mode12" class="form-control" title="Payment Mode" onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')" disabled>
                  <option value="<?= $sq_payment['payment_mode'] ?>"><?= $sq_payment['payment_mode'] ?></option>
                  <?php get_payment_mode_dropdown(); ?>
                </select>
              </div>
            </div>
            <div class="row mg_bt_10">
              <div class="col-md-4">
                <input type="text" id="bank_name1" name="bank_name1" class="form-control bank_suggest" placeholder="*Bank Name" title="Bank Name" value="<?= $sq_payment['bank_name'] ?>" <?= $enable ?>>
              </div>
              <div class="col-md-4">
                <input type="text" id="transaction_id1" name="transaction_id1" onchange="validate_balance(this.id);" class="form-control" placeholder="*Cheque No/ID" title="Cheque No/ID" value="<?= $sq_payment['transaction_id'] ?>" <?= $enable ?>>
              </div>
               <div class="col-md-4">
                <select name="bank_id1" id="bank_id1" title="Debitor Bank" <?= $enable ?> disabled>
                  <?php 
                  if($sq_bank['bank_id'] != ''){
                  ?>
                  <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                  <?php  } get_bank_dropdown('*Debitor Bank'); ?>
                </select>
              </div>
            </div>  
            <div class="row">
              <div class="col-md-3">
                  <div class="div-upload pull-left" id="div_upload_button1">
                      <div id="payment_evidence_upload2" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status1" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url2" name="payment_evidence_url1" value="<?= $sq_payment['evidance_url'] ?>">
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

$('#payment_update_modal').modal('show');

function payment_evidance_upload()
{ 
    var btnUpload=$('#payment_evidence_upload2');
    $(btnUpload).find('span').text('Payment Evidence');
   // $('#payment_evidence_url').val('');
    
    new AjaxUpload(btnUpload, {
      action: 'payment/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {  
        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF or pdf files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload Again');
        }else
        { 
          $(btnUpload).find('span').text('Uploaded');
          $('#payment_evidence_url2').val(response);
        }
      }
    });
}
payment_evidance_upload();
$(function(){
  $('#frm_vendor_payment_update').validate({
      rules:{
              payment_amount1 : { required: true, number:true },
              payment_date1 : { required: true },
              payment_mode12 : { required : true },
              bank_name1 : { required : function(){  if($('#payment_mode12').val()!="Cash"){ return true; }else{ return false; }  }  },
              transaction_id1 : { required : function(){  if($('#payment_mode12').val()!="Cash"){ return true; }else{ return false; }  }  },     
              bank_id1 : { required : function(){  if($('#payment_mode12').val()!="Cash"){ return true; }else{ return false; }  }  },     
      },
      submitHandler:function(form){

              var payment_id = $('#payment_id_update').val();
              var supplier_id = $('#supplier_id1').val();
              var expense_type_id = $('#expense_type_p1').val();
              var payment_amount = $('#payment_amount1').val();
              var payment_date = $('#payment_date1').val();
              var payment_mode = $('#payment_mode12').val();
              var bank_name = $('#bank_name1').val();
              var transaction_id = $('#transaction_id1').val();
              var bank_id = $('#bank_id1').val();
              var payment_evidence_url = $('#payment_evidence_url2').val();
              var payment_old_value = $('#payment_old_value').val();
              var payment_old_mode = $('#payment_old_mode').val();
              var balance_amount = $('#balance_amount').val();
              var old_bank_id = $('#old_bank_id').val();
      			  if(payment_amount > payment_old_value){
      				 var balance_paying = parseFloat(payment_amount) - parseFloat(payment_old_value);
      				 if(parseFloat(balance_paying) > parseFloat(balance_amount)) { error_msg_alert('Payment should not be more than expense amount!'); return false; }
      			  }              
              
              $.ajax({
                type:'post',
                url: base_url()+'controller/other_expense/expense_payment_update.php',
                data:{ payment_id : payment_id, supplier_id : supplier_id, expense_type_id : expense_type_id, payment_amount : payment_amount, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_evidence_url : payment_evidence_url,payment_old_value : payment_old_value,payment_old_mode : payment_old_mode, old_bank_id : old_bank_id },
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