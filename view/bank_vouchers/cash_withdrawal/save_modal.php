<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id= $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cash Withdrawal</h4>
      </div>
      <div class="modal-body">            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="bank_id" name="bank_id" style="width:100%" title="Bank" class="form-control">
                    <?php get_bank_dropdown(); ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="*Date" title="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)">
              </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                  <div class="div-upload pull-left" id="div_upload_button">
                      <div id="payment_evidence_upload" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url" name="payment_evidence_url">
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-9">
                  <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= 'Please make sure Date, Amount, Creditor bank entered properly.' ?></span>
             </div>
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
$('#bank_id').select2();

payment_evidence_upload();
function payment_evidence_upload(offset='')
{
    var btnUpload=$('#payment_evidence_upload'+offset);
    var status=$('#payment_evidence_status'+offset);
    new AjaxUpload(btnUpload, {
      action: 'cash_deposit/upload_payment_evidence.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         var id_proof_url = $("#payment_evidence_url"+offset).val();
          
     
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG or GIF files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          $("#payment_evidence_url"+offset).val(response);
          msg_alert('File uploaded!');
        }
      }
    });

}
$('#frm_save').validate({
  rules:{
          bank_id : { required: true },
          payment_amount : { required: true, number: true },
          payment_date : { required: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var bank_id = $('#bank_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_evidence_url = $('#payment_evidence_url').val();
    var branch_admin_id = $('#branch_admin_id1').val();
    var emp_id = $('#emp_id').val();
    $.post(base_url+'view/load_data/finance_date_validation.php', { check_date: payment_date }, function(data){
    if(data !== 'valid'){
      error_msg_alert("The Date does not match between selected Financial year.");
      return false;
    }
    else{

        $('#btn_save').button('loading');

        $.ajax({
          type:'post',
          url:base_url+'controller/bank_vouchers/cash_withdrawal_save.php',
          data: { bank_id : bank_id, payment_amount : payment_amount, payment_date : payment_date,payment_evidence_url : payment_evidence_url, branch_admin_id : branch_admin_id,emp_id : emp_id },
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