<?php
include "../../../model/model.php";

$deposit_id = $_POST['deposit_id'];
$branch_status = $_POST['branch_status'];
$sq_bank_info = mysql_fetch_assoc(mysql_query("select * from cash_deposit_master where deposit_id='$deposit_id'"));
?>
<input type="hidden" name="payment_old_amount" id="payment_old_amount" value="<?= $sq_bank_info['amount'] ?>">
<input type="hidden" name="deposit_id" id="deposit_id" value="<?= $sq_bank_info['deposit_id'] ?>">
<form id="frm_update">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Deposit</h4>
      </div>
      <div class="modal-body">            
            <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <select id="bank_id1" name="bank_id1" style="width:100%" title="Bank" class="form-control" disabled>
                    <?php $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$sq_bank_info[bank_id]'"));  ?>
                    <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'].'('.$sq_bank['branch_name']; ?></option>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_amount" name="payment_amount" placeholder="*Amount" class="form-control" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'payment_mode','transaction_id','bank_name')" value="<?= $sq_bank_info['amount'] ?>">
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10">
                <input type="text" id="payment_date" name="payment_date" placeholder="Date" title="Date" class="form-control" value="<?= get_date_user($sq_bank_info['transaction_date'])?>" readonly>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                  <div class="div-upload pull-left" id="div_upload_button1">
                      <div id="payment_evidence_upload1" class="upload-button1"><span>Payment Evidence</span></div>
                      <span id="payment_evidence_status1" ></span>
                      <ul id="files" ></ul>
                      <input type="hidden" id="payment_evidence_url1" name="payment_evidence_url1" value="<?= $sq_bank_info['evidence_url'] ?>">
                  </div>
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
payment_evidence_upload('1');
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
$('#frm_update').validate({
  rules:{
          payment_amount : { required: true, number: true },
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();          

    var bank_id = $('#bank_id1').val();
    var deposit_id = $('#deposit_id').val();
    var payment_amount = $('#payment_amount').val();
    var payment_date = $('#payment_date').val();
    var payment_evidence_url = $('#payment_evidence_url1').val();
    var payment_old_amount =  $('#payment_old_amount').val();

    if((payment_amount!=0) && (payment_old_amount != payment_amount))
     { error_msg_alert("Can not update amount else make it 0"); return false;}

    $('#btn_update').button('loading');

    $.ajax({
      type:'post',
      url:base_url+'controller/bank_vouchers/cash_deposit_update.php',
      data: { deposit_id : deposit_id,bank_id : bank_id, payment_amount : payment_amount, payment_date : payment_date,payment_evidence_url : payment_evidence_url,payment_old_amount : payment_old_amount},
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