<?php
 include "../../model/model.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>

 <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">

  

  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
  

 </head>
<body>
  <div class="container mg_tp_10">
        <form id="frm_form_send">

          <div class="row" style="margin-top: 30px">

              <div class="col-md-6 col-sm-6 mg_bt_10">

                  <input type="text" name="email_id"  class="form-control" title="Email ID" placeholder="Email ID" id="email_id">

              </div>          

              <div class="col-md-6 col-sm-6 mg_bt_10">

                  <input type="text" name="mobile_no"  class="form-control" title="Mobile No" placeholder="Mobile No" id="mobile_no">

              </div>

          </div>

       

          <div class="row text-center mg_tp_20" style="margin-top: 30px">

              <div class="col-md-12">

                <button class="btn btn-success" id="btn_form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>  

              </div>             

            </div>

        </form>

    </div>

 
 
<script>
$(function(){

  $('#frm_form_send').validate({

    rules:{

            email_id : { required : true },

    },

    submitHandler:function(form){

     

      var email_id = $('#email_id').val();

      var mobile_no = $('#mobile_no').val();


      $('#btn_form_send').button('loading'); 

      $.ajax({

        type:'post',

        url:'../../controller/email_sms_test/email_sms_test.php',

        data:{ email_id : email_id,mobile_no : mobile_no},

        success: function(message){

            alert(message);

            $('#btn_form_send').button('reset'); 

                        

        }  

      });

      }

  });

});

</script>

</body>
</html>