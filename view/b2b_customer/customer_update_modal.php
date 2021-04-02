<?php
include "../../model/model.php";
$register_id = $_POST['register_id'];
$sq_customer = mysql_fetch_assoc(mysql_query("select * from b2b_registration where register_id='$register_id'"));
$sq_credit = mysql_fetch_assoc(mysql_query("select * from b2b_creditlimit_master where register_id='$register_id'"));
$status = ($sq_customer['approval_status'] == 'Approved') ? 'disabled checked' : '';
if($sq_customer['approval_status'] == 'Rejected'){ $status = 'disabled'; }
$payment_dates = ($sq_customer['payment_date'] == '0000-00-00' || $sq_customer['payment_date'] == '1970-01-01') ? '' : '';
$payment_modes = ($sq_customer['payment_mode'] == '') ? '' : 'disabled';
?>
<div class="modal fade" id="customer_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Status</h4>
      </div>
      <div class="modal-body">
        <form id="frm_customer_update">
        <input type="hidden" id="old_deposit" name="old_deposit" value="<?= $sq_customer['deposite'] ?>">
        <input type="hidden" id="register_id" name="register_id" value="<?= $register_id ?>">
          <div class="row mg_bt_10">
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <select name="approve_status1" id="approve_status1" title="Select Approval Status" onchange="change_fields_status(this.id)" required>
              <?php if($sq_customer['approval_status'] != ''){?>
                  <option value="<?= $sq_customer['approval_status'] ?>"><?= $sq_customer['approval_status'] ?></option>
              <?php } ?>
                  <option value="">Approval Status</option>
                  <option value="Approved">Approved</option>
                  <option value="Rejected">Rejected</option>
              </select>
            </div>
            <div class="col-sm-2 mg_bt_10_sm_xs">
              <input type="text" id="credit_limit" name="credit_limit" placeholder="Credit Limit" title="Credit Limit" value="<?= $sq_credit['credit_amount'] ?>" <?= $status ?> onchange="validate_balance(this.id);">
            </div>
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <select name="active_flag1" id="active_flag1" title="Status">
                <option value="<?= $sq_customer['active_flag'] ?>"><?= $sq_customer['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 text-left">          
              <div class="div-upload" title="Upload Agreement" data-toggle="tooltip">
                <div id="photo_upload_btn_p" class="upload-button1"><span>Agreement</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="agreement_upload_url" name="agreement_upload_url" value="<?= $sq_customer['agreement_url'] ?>">
              </div>
              <div style="color: red;">Note : Upload PDF upto 250KB.</div>
              </div>
            </div>
            <div class="row mg_tp_10">
                <div class="col-md-4">
                    <input id="reflect_details1" name="reflect_details1" type="checkbox" onClick="reflect_details(this.id);" <?= $status ?>>
                    &nbsp;&nbsp;<label for="reflect_details1">Deposit</label>
                </div>
            </div>
            <div class="row mg_tp_10">
              <div id="deposit_fields">
              <?php if($sq_customer['approval_status'] == 'Approved'){ ?>
                <div class="col-sm-3 mg_bt_10_sm_xs">
                  <input type="text" id="deposit" name="deposit" placeholder="*Deposit Amount" title="Deposit Amount" value="<?= $sq_customer['deposite'] ?>" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name','bank_id')" required>
                </div>
                <div class="col-md-3">
                  <input type="text" id="payment_date" name="payment_date" placeholder="*Payment Date" title="Payment Date" value="<?= (get_date_user($sq_customer['payment_date'])!='')?get_date_user($sq_customer['payment_date']):date('d-m-Y') ?>" <?= $payment_dates ?> required>
                </div>
                <div class="col-md-3">
                  <select name="payment_mode" id="payment_mode" title="Payment Mode" data-toggle="tooltip" onchange="payment_master_toggles(this.id, 'bank_name', 'transaction_id', 'bank_id')" <?= $payment_modes ?> disabled required>
                    <?php if($sq_customer['payment_mode'] != ''){ ?><option value="<?= $sq_customer['payment_mode'] ?>"><?= $sq_customer['payment_mode'] ?></option> <?php } ?>
                    <?php get_payment_mode_dropdown(); ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="text" id="bank_name" name="bank_name" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_customer['bank_name'] ?>" disabled>
                </div>
                <div class="col-md-3 mg_tp_10">
                  <input type="text" id="transaction_id" name="transaction_id" onchange="validate_specialChar(this.id)" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_customer['transaction_id'] ?>" disabled>
                </div>
                <div class="col-md-3 mg_tp_10">
                  <select name="bank_id" id="bank_id" title="Select Creditor Bank" data-toggle="tooltip" style="width:100%" class="form-control" disabled>
                    <?php
                    if($sq_customer['bank_id'] != '0'){
                    $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_customer[bank_id]'"));  
                    ?>
                    <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
                    <?php } ?>
                    <?php get_bank_dropdown(); ?>
                  </select>
                </div>
              <?php } ?>
              </div> 
            </div>
          <div class="row text-center">
            <div class="col-md-12 mg_tp_10">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>
        </form> 
    </div>
  </div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
	$('#payment_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
  $('#customer_update_modal').modal('show');
  $('#bank_id').select2();
upload_agreement();
function upload_agreement(){

    var btnUpload=$('#photo_upload_btn_p');
    $(btnUpload).find('span').text('Agreement');

    new AjaxUpload(btnUpload, {

      action: 'upload_agreement.php',
      name: 'uploadfile',
      onSubmit: function(file, ext)
      {
        var approve_status = $('#approve_status1').val(); 
        if(approve_status != 'Approved'){
          error_msg_alert("Please Approve status first!");
          return false;
        }
        if (! (ext && /^(pdf)$/.test(ext))){ 
         error_msg_alert('Only pdf files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },

      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Agreement');
        }
        else{ 
          $(btnUpload).find('span').text('Uploaded');
          $("#agreement_upload_url").val(response);
        }
      }
    });
}
function reflect_details(reflect_details){

	  var base_url = $('#base_url').val();
    var reflect_details1 = $('#'+reflect_details).val();
    var status = document.getElementById(reflect_details).checked;
    $.post('inc/deposit_fields_reflect.php',{ reflect_details : reflect_details1,status:status}, function(data){
      $('#deposit_fields').html(data);
    });
}
  $(function(){
	$('#frm_customer_update').validate({
	  rules:{
	  },
	  submitHandler:function(form){

	  	  var register_id = $('#register_id').val();
	      var credit_limit = $('#credit_limit').val();
	      var active_flag = $('#active_flag1').val();
        var agreement_url = $('#agreement_upload_url').val();
        var approve_status = $('#approve_status1').val();
        //Deposit
        var payment_date = $('#payment_date').val();
        var old_deposit = $('#old_deposit').val();
	      var deposit = $('#deposit').val();
        var payment_mode = $('#payment_mode').val();
        var bank_name = $('#bank_name').val();
        var transaction_id = $('#transaction_id').val();
        var bank_id = $('#bank_id').val();
        var base_url = $('#base_url').val();
        
        $("#vi_confirm_box").vi_confirm_box({
        callback: function(result){
          if(result=="yes")
          {
            $('#btn_update').button('loading');
            
            $.ajax({
              type: 'post',
              url: base_url+'controller/b2b_customer/customer_update.php',
              data:{ register_id : register_id, credit_limit : credit_limit,old_deposit:old_deposit, deposit : deposit,agreement_url:agreement_url,active_flag : active_flag,approve_status : approve_status, payment_date : payment_date, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id},
              success: function(result){
                msg_alert(result);
                $('#customer_update_modal').modal('hide');
                $('#btn_update').button('reset');
                $('#customer_update_modal').on('hidden.bs.modal', function(){
                  customer_list_reflect();
                });
              }
            });
          }
        }
      });
	  }
	});
  });
</script>