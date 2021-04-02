<?php
include "../model/model.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Decryption</title>

  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">

  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>

 </head>
<body>
    <div class="container mg_tp_10">
        <form id="form_decrypt">
          <div class="row" style="margin-top: 30px">
              <div class="col-md-6 col-md-offset-3 col-sm-6 mg_bt_10">
                  <input type="text" name="tempString" class="form-control" title="Enter Encrypted Format String here.." placeholder="Enter Encrypted Format" data-toggle="tooltip" id="tempString" required>
                  <input type="hidden" name="secret_key" id="secret_key" value="<?= $secret_key ?>">
              </div>
          </div>
    
          <div class="row text-center mg_tp_20" style="margin-top: 30px">
              <div class="col-md-12">
                <button class="btn btn-success" id="btn_form_decrypt">Decrypt</button>
              </div>
            </div>
        </form>
         <div class="row" style="margin-top: 30px">
            <div class="col-md-6 col-md-offset-3 col-sm-6">
                <label>Decrypted String : </label>
                <span id="result"></span>
            </div>
        </div>
    </div>

<script>
$(function(){

  $('#form_decrypt').validate({
    rules:{
    },
    submitHandler:function(form){

      var tempString = $('#tempString').val();
      var secret_key = $('#secret_key').val();
      $('#btn_form_decrypt').button('loading'); 
      $.ajax({

        type:'post',
        url:'../controller/decrypt_data.php',
        data:{ tempString : tempString, secret_key :secret_key},
        success: function(message){
            $('#result').html(message);
            $('#btn_form_decrypt').button('reset'); 
        }
      });
      }
  });
});

</script>

</body>
</html>
