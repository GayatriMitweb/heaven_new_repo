<?php

include_once("../../model/model.php");

 

 ?>

      <div>

          <img src="<?php echo $user_id; ?>" class="img-responsive">

      </div> 

      <div>          

        <div class="upload">

          <div id="photo_upload_btn1" class="upload-button1"><span><i class="fa fa-camera" aria-hidden="true"></i> Change</span></div>

          <span id="photo_status" ></span>

          <ul id="files" ></ul>

          <input type="hidden" id="photo_upload_url" name="photo_upload_url">

        </div>

      </div>

      <div class="close_profile_pic" onclick="close_button()"><i class="fa fa-times" aria-hidden="true"></i></div>     

 

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>

 

photo_upload();

function photo_upload()

{

  var type="user_photo";

  var btnUpload=$('#photo_upload_btn1');

  var status=$('#photo_status');

  new AjaxUpload(btnUpload, {

    action: '../layouts/upload_photo_file.php',

    name: 'uploadfile',

    onSubmit: function(file, ext){

 

      var adnary_url = $("#photo_upload_url").val();



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

        document.getElementById("photo_upload_url").value = response;

        upload_user_photo();

      }

    }

  });



}





///////////////////////***Upload Photo********/////////////



function upload_user_photo()

{

  var base_url = $("#base_url").val();

  var emp_id = $('#emp_id').val();

  var user_url = $("#photo_upload_url").val();

  

  $.post( 

               base_url+"controller/employee/upload_user_photo.php",

               { emp_id : emp_id, user_url : user_url },

               function(data) {  

                     msg_alert(data);                      
                     window.location.reload();
               });



} 



///////////////////////***Upload Photo*********//////////////



function close_button()

{

  $("#profile_pic_block_id").toggleClass('profile_pic_block_display');

}



</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>