<?php 
include_once('../../../model/model.php');

$location_id = $_POST['location_id'];

$sq_location = mysql_fetch_assoc(mysql_query("select * from locations where location_id='$location_id'"));
?>

<form id="frm_location_update">

<input type="hidden" id="location_id" name="location_id" value="<?= $sq_location['location_id'] ?>">

<div class="modal fade" id="location_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Location</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="location_name1" name="location_name1" onchange="locationname_validate(this.id);" placeholder="*Location Name" title="Location Name" value="<?= $sq_location['location_name'] ?>" required>
            </div>
            <div class="col-sm-6 mg_bt_10">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="<?= $sq_location['active_flag'] ?>"><?= $sq_location['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>            
          </div>
          
          <div class="row text-center mg_tp_10"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="location_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>            
          </div> </div>
      </div>
    </div>
  </div>
</div>
</form>

<script>
  $('#location_update_modal').modal('show');
  $('#location_update_modal').on('shown.bs.modal', function () {  $('#location_name1').focus(); });
  $(function(){
    $('#frm_location_update').validate({
      rules:{
        location_name1:{ required:true, maxlength:200 },
        location_description:{ required:true },
        active_flag:{ required:true },
      },
      submitHandler:function(form){
        $('#location_update').button('loading');
        var base_url = $('#base_url').val();
        $.ajax({
          type:'post',
          url: base_url+'controller/branches_and_location/location_update.php',
          data: $('#frm_location_update').serialize(),
          success:function(result){
          var msg = result.split('--');				
          if(msg[0]=='error'){
            error_msg_alert(msg[1]);
            $('#location_update').button('reset');
            return false;
          }
          else{
            $('#location_update').button('reset');
            msg_alert(result);
            $('#location_update_modal').modal('hide');
            $('#location_update_modal').on('hidden.bs.modal', function () {
                locations_list_reflect();
            });
            setTimeout(function(){window.location.href = base_url+'view/branches_and_locations/index.php'}, 1200);  //temp solution
          }
            
          }
        });
      }
    });
  });
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>