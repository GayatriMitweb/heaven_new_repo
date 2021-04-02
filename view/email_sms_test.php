<?php

 include "../model/model.php";

?>

<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-md" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Send Enquiry</h4>

      </div>

      <div class="modal-body">

        <form id="frm_form_send">

          <div class="row mg_tp_10">

              <div class="col-md-6 col-sm-6 mg_bt_10">

                  <input type="text" name="email_id"  class="form-control" title="Email ID" placeholder="Email ID" id="email_id">

              </div>          

              <div class="col-md-6 col-sm-6 mg_bt_10">

                  <input type="text" name="mobile_no"  class="form-control" title="Mobile No" placeholder="Mobile No" id="mobile_no">

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

</div>

</div>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<script>
$('document').ready(function() {
    $('#send_modal').modal('show');

});

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

        url: base_url+'controller/email_sms_test.php',

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

