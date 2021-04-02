<?php
 include "../../model/model.php";
 $entry_id = $_POST['entry_id'];
?>
<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Visa Information</h4>
      </div>
      <div class="modal-body text-center">
        <form id="frm_visa_send">
          <input type="hidden"  value="<?= $entry_id ?>" id="entry_id" name="entry_id">
          <div class="row">
              <div class="col-md-12 col-sm-12 mg_bt_10">
                  <input type="text" name="email_id"  class="form-control" title="Email ID" placeholder="*Email ID" id="email_id" data-role="tagsinput" onchange="validate_email(this.id)">
              </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
            <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note">Enter Multiple Email Id's with comma!</span>
            </div>
          </div>
          <div class="row text-center">
              <div class="col-md-12">
                <button class="btn btn-sm btn-success" id="btn_visa_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>  
              </div>
            </div>
        </form>
      </div>
</div>
</div>
</div>
</div>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#send_modal').modal('show');
$("#email_id").tagsinput('items');
$(function(){
  $('#frm_visa_send').validate({
    submitHandler:function(form){
      var base_url = $('#base_url').val();
      var entry_id = $('#entry_id').val();
      var email_id = $('#email_id').val();
      if(email_id == ''){
        error_msg_alert("Enter Email ID");
        return false;
      }
      $('#btn_visa_send').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/visa_master/visa_email_send.php',
        data:{ entry_id : entry_id, email_id : email_id},
        success: function(message){
            msg_alert(message);
            $('#btn_visa_send').button('reset'); 
            $('#send_modal').modal('hide');               
        }  
      });
      }
  });
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
