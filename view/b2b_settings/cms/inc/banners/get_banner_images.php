<?php
include '../../../../../model/model.php';
$banner_count = $_POST['banner_count'];
$banner_uploaded_count = $_POST['banner_uploaded_count'];
?>
<div class="row mg_bt_10">
  <div class="col-xs-12"> 
    <div style="color: red;">Note : Upload Image size below 1MB, resolution : 1800*400, Format : JPEG,JPG.</div>
  </div>
</div>
<div class="row mg_bt_20">
<?php
for($i=0;$i<$banner_count;$i++){
    ?>
    <div class="col-md-2 mg_bt_10 col-sm-6">          
    <div class="div-upload">
        <div id="id_upload_btn<?= $i?>" class="upload-button1"><span>Upload</span></div>
        <span id="id_proof_status" ></span>
        <ul id="files"></ul>
        <input type="hidden" id="image_upload_url<?= $i?>" name="image_upload_url<?= $i?>">
    </div>
    </div>
    <?php } ?>
</div>
<script type="text/javascript">
$( document ).ready(function() {

  for(var i=0;i<'<?php echo $banner_count; ?>';i++){
    upload_user_pic_attch(i);
    function upload_user_pic_attch(i){
        var btnUpload=$('#id_upload_btn'+i);
        $(btnUpload).find('span').text('Banner '+(i+1));

        new AjaxUpload(btnUpload, {
          action: 'cms/inc/banners/upload_banner_img.php',
          name: 'uploadfile',
          onSubmit: function(file, ext)
          {
            if (! (ext && /^(jpg|jpeg)$/.test(ext))){ 
            error_msg_alert('Only JPG and JPEG files are allowed');
            return false;
            }
            $(btnUpload).find('span').text('Uploading...');
          },
          onComplete: function(file, response){
              var response1 = response.split('--')
            if(response1[0]=="error"){
              error_msg_alert(response1[1]);           
              $(btnUpload).find('span').text('Banner '+i);
            }
            else{
              $(btnUpload).find('span').text('Uploaded');
              $("#image_upload_url"+i).val(response);
            }
          }
        });
    }
  }
});
</script>