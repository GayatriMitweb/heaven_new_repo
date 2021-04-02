<?php 
include_once('../../../model/model.php');
$entry_id = $_POST['entry_id'];
$sq_location = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$entry_id'"));
$vehicle_data = json_decode($sq_location['vehicle_data']);
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $sq_location['entry_id'] ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Vehicle</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-4">
              <select id="vehicle_type1" name="vehicle_type1" style="width:100%" title="Vehcile Type" data-toggle="tooltip" class="form-control" required>
                  <option value="<?= $sq_location['vehicle_type'] ?>"><?= $sq_location['vehicle_type'] ?></option>
                  <?php get_vehicle_types(); ?>
              </select>
            </div>
            <div class="col-sm-4">
              <input type="text" id="vehicle_name1" name="vehicle_name1" onchange="locationname_validate(this.id);" placeholder="*Vehicle Name" title="Vehicle Name" value="<?= $sq_location['vehicle_name'] ?>" required>
            </div>
            <div class="col-sm-4">
              <input type="number" id="seating_capacity1" name="seating_capacity1" max_length="20" placeholder="*Seating Capacity" title="Seating Capacity" value="<?= $sq_location['seating_capacity'] ?>" required>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-sm-4">
              <div class="div-upload" role="button" title="Upload Vehicle Image" data-toggle="tooltip">
                <div id="image_upload_btn1" class="upload-button1"><span>Vehicle Image</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="image_upload_url1" name="image_upload_url1" value="<?= $sq_location['image_url'] ?>" required>
              </div>
            </div>
            <div class="col-sm-8">
              <div style="color: red;">Note : Upload Image size below 100KB, resolution : 900X450.</div>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-12">
              <h3 class="editor_title">Cancellation Policy</h3>
              <textarea class="feature_editor" name="canc_policy1" id="canc_policy1" style="width:100% !important" rows="2"><?= $sq_location['cancellation_policy'] ?></textarea>
            </div>
          </div>
          <div class="row mg_tp_20">
            <div class="col-sm-4">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="<?= $sq_location['status'] ?>"><?= $sq_location['status'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="row text-center mg_tp_30">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>            
            </div>
          </div>   
      </div>
    </div>
  </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
  $('#update_modal').modal('show');
  $('#vehicle_type1').select2();
  $('#update_modal').on('shown.bs.modal', function () {  $('#vehicle_name1').focus(); });
  upload_vehicle_image1();
  function upload_vehicle_image1(){

      var btnUpload=$('#image_upload_btn1');
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
        onComplete: function(file, response){
          if(response==="error"){          
            error_msg_alert("File is not uploaded.");           
            $(btnUpload).find('span').text('Upload Image');
          }
          else{ 
              if(response=="error1"){

                $(btnUpload).find('span').text('Upload Image');
                error_msg_alert('Maximum size exceeds');
                return false;
              }else{

                $(btnUpload).find('span').text('Uploaded');
                $("#image_upload_url1").val(response);
            }
          }
      }
    });
  }
  $(function(){
    $('#frm_update').validate({
      rules:{
      },
      submitHandler:function(form){
        var base_url = $('#base_url').val();
        var image_upload_url = $('#image_upload_url1').val();
        var entry_id = $('#entry_id').val();
        var vehicle_type = $('#vehicle_type1').val();
        var vehicle_name = $('#vehicle_name1').val();
        var seating_capacity = $('#seating_capacity1').val();
        var canc_policy = $('#canc_policy1').val();
        var active_flag = $('#active_flag').val();

        var vehicle_array = [];
        vehicle_array.push({
          'seating_capacity' : seating_capacity,
          'image':image_upload_url
        });

        $('#update').button('loading');
        $.ajax({
          type:'post',
				url: base_url+'controller/b2b_transfer/vehicle_update.php',
          data: {entry_id:entry_id,vehicle_array:JSON.stringify(vehicle_array),vehicle_type:vehicle_type,vehicle_name:vehicle_name,canc_policy:canc_policy,active_flag:active_flag},
          success:function(result){
          var msg = result.split('--');
            $('#update').button('reset');				
            if(msg[0]=='error'){
              error_msg_alert(msg[1]);
              return false;
            }
            else{
              msg_alert(result);
				      update_b2c_cache();
              $('#update_modal').modal('hide');
              $('#update_modal').on('hidden.bs.modal', function () {
                master_list_reflect();
              });
            }
            
          }
        });
      }
    });
  });
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>