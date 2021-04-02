<?php include "../../../model/model.php";?>
<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Forgot Password?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="frm_form_send">
           <div class="formField">
                <input
                type="text"
                class="input-txtbox"
                placeholder="Enter Ajent Code"
                title="Please Enter Ajent Code"
                id='fagent_code' name='agent_code' required
                />
            </div>
            <div class="formField">
                <input
                type="text"
                class="input-txtbox"
                placeholder="Enter User Name"
                title="Please Enter User Name"
                id='fuser_name' name='user_name' required
                />
            </div>
          <div class="formField st-error">
            <span class="error-msg">Please provide these details and we'll send you Reset password e-mail to your mailbox.</span>
          </div>
          <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button class="btn-submit" type='submit' id='send_reset'>Send</button>
              </div>
            </div>
        </form>
      </div>
    </div>
    </div>
</div></div>
<script>
$('#send_modal').modal('show');
$(function(){
  $('#frm_form_send').validate({
    rules:{
    },
    submitHandler:function(form){
        var base_url = $('#base_url').val();
        var agent_code = $('#fagent_code').val();
        var user_name = $('#fuser_name').val();

        $('#send_reset').button('loading'); 
        $.ajax({
            type:'post',
            url: '../controller/b2b_customer/login/forgot_password.php',
            data:{ agent_code : agent_code,user_name : user_name},
            success: function(message){
                if(message == 'Invalid Login Credentials!'){
                    $('#send_reset').button('reset');
                    error_msg_alert(message);
                    return false;
                }else{
                    success_msg_alert(message);
                    $('#send_reset').button('reset'); 
                    $('#send_modal').modal('hide');
                }
            }
        });
    }
  });
});
</script>

