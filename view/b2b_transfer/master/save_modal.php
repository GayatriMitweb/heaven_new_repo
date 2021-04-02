<form id="frm_master_save">
<div class="modal fade" id="master_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vehicle</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-4">
              <select id="vehicle_type" name="vehicle_type" style="width:100%" title="Vehcile Type" data-toggle="tooltip" class="form-control" required>
                  <?php get_vehicle_types(); ?>
              </select>
            </div>
            <div class="col-sm-4">
              <input type="text" id="vehicle_name" name="vehicle_name" onchange="locationname_validate(this.id);" placeholder="*Vehicle Name" title="Vehicle Name" required>
            </div>
            <div class="col-sm-4">
              <input type="number" id="seating_capacity" name="seating_capacity" max_length="20" placeholder="*Seating Capacity" title="Seating Capacity" required>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-sm-4">
              <div class="div-upload" role="button" title="Upload Vehicle Image" data-toggle="tooltip">
                <div id="image_upload_btn" class="upload-button1"><span>Vehicle Image</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="image_upload_url" name="image_upload_url" required>
              </div>
            </div>
            <div class="col-sm-8">
              <div style="color: red;">Note : Upload Image size below 100KB, resolution : 900X450.</div>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-12">
              <h3 class="editor_title">Cancellation Policy</h3>
              <textarea class="feature_editor" name="canc_policy" id="canc_policy" style="width:100% !important" rows="2"></textarea>
            </div>
          </div>
          <div class="row text-center mg_tp_30">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
            </div>
          </div>        
      </div>      
    </div>
  </div>
</div>
</form>
<script>
$('#vehicle_type').select2();
upload_vehicle_image();
function upload_vehicle_image(){

    var btnUpload=$('#image_upload_btn');
    $(btnUpload).find('span').text('Vehicle Image');
    new AjaxUpload(btnUpload, {

      action: 'master/upload_image.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response1){
        
        if(response1==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Vehicle Image');
        }
        else if(response1==="error1"){       
          error_msg_alert("Max Filesize limit exceeds!");           
          $(btnUpload).find('span').text('Vehicle Image');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#image_upload_url").val(response1);
        }
      }
    });
}
</script>
