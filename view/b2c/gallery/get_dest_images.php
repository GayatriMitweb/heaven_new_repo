<?php
include '../../../model/model.php';
$dest_id= $_POST['dest_id'];
$gallery = json_decode($_POST['gallery']);

$dest_gallery = array();
$nodest_gallery = array();
foreach($gallery as $struct) {
    if ($dest_id == $struct->dest_id) {
        array_push($dest_gallery,$struct);
    }
    else
      array_push($nodest_gallery,$struct);
}
?>
<div class="row mg_bt_20">
  <input type="hidden" value="<?= sizeof($dest_gallery) ?>" id="gimages"/>
  <input type="hidden" value='<?php echo json_encode($nodest_gallery); ?>' id="nodest_gallery"/>
  <input type="hidden" value='<?php echo json_encode($dest_gallery); ?>' id="dest_gallery"/>
  <?php
  for($i=0;$i<sizeof($dest_gallery);$i++){
      $url = $dest_gallery[$i]->image_url;
      $pos = strstr($url,'uploads');
      if ($pos != false){
          $newUrl1 = preg_replace('/(\/+)/','/',$url);
          $download_url = BASE_URL.str_replace('../', '', $newUrl1);
      }else{
          $download_url =  $images[$i]->url;
      }
      ?>
      <div class="col-md-2">
          <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
          <input type="hidden" value="<?= $url ?>" id="imagel<?=$i?>"/>
              <img src="<?php echo $download_url; ?>" id="<?php echo $i; ?>" width="100%" height="100%">
              <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image('<?php echo $i; ?>')" title="Delete Image" data-toggle="tooltip"><i class="fa fa-times" aria-hidden="true"></i></button></span>
          </div>
      </div>
  <?php } ?>
</div>

<div class="row mg_bt_20">
  <div class="col-md-2 mg_bt_10 col-sm-6">
    <div class="div-upload">
        <div id="id_upload_btn1" class="upload-button1"><span>Upload</span></div>
        <span id="id_proof_status" ></span>
        <ul id="files"></ul>
        <input type="hidden" id="image_upload_url1" name="image_upload_url1">
    </div>
  </div>
  <div class="col-md-9"> 
      <div style="color: red;">Note : Upload Image size below 100KB, resolution : 600*300, Format : JPEG,JPG,PNG.</div>
  </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {

  for(var i=1;i<2;i++){
    upload_user_pic_attch(i);
    function upload_user_pic_attch(i){
        var btnUpload=$('#id_upload_btn'+i);
        $(btnUpload).find('span').text('Upload Image');

        new AjaxUpload(btnUpload, {
          action: 'gallery/upload_img.php',
          name: 'uploadfile',
          onSubmit: function(file, ext)
          {
            if (! (ext && /^(jpg|jpeg|png)$/.test(ext))){ 
            error_msg_alert('Only JPG and JPEG files are allowed');
            return false;
            }
            $(btnUpload).find('span').text('Uploading...');
          },
          onComplete: function(file, response){
              var response1 = response.split('--')
            if(response1[0]=="error"){
              error_msg_alert(response1[1]);           
              $(btnUpload).find('span').text('Upload Image');
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