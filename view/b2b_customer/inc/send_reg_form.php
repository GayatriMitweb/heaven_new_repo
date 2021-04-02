<?php include "../../../model/model.php";?>
<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send Registration Form</h4>
      </div>
      <div class="modal-body">
        <form id="frm_form_send">
          <div class="row mg_tp_10">
              <div class="col-md-6 col-sm-6 mg_bt_10">
                  <input type="email" name="email_id" class="form-control" title="Email ID" placeholder="*Email ID" id="email_id">
              </div>          
              <div class="col-md-6 col-sm-6 mg_bt_10">
                  <input type="number" name="mobile_no"  class="form-control" maxlength="20" minlength="10" title="Mobile No" placeholder="Mobile No" id="mobile_no">
              </div>
          </div>
          <div class="row mg_tp_10">
           <div class="col-md-12 col-sm-6 mg_bt_10">
              <h5>Registration Link : <u><?= BASE_URL ?>view/b2b_customer/registration/index.php</u></h5>
              <h5>Please provide this link to the B2B and get their complete details.</h5>
           </div>
          </div>
          <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button class="btn btn-success" id="btn_form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
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
            email_id : { required : true },
    },
    submitHandler:function(form){
      var base_url = $('#base_url').val();
      var email_id = $('#email_id').val();
      var mobile_no = $('#mobile_no').val();

      $('#btn_form_send').button('loading'); 
      $.ajax({
        type:'post',
        url: base_url+'controller/b2b_customer/form_email_send.php',
        data:{ email_id : email_id,mobile_no : mobile_no},
        success: function(message){
            msg_alert(message);
            $('#btn_form_send').button('reset'); 
            $('#send_modal').modal('hide');               
        }  
      });
      }
  });
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

