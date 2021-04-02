<?php 
include "../../../model/model.php"; 
  
$state_id = $_POST['id'];  
$sq = mysql_fetch_assoc(mysql_query("select * from state_master where id='$state_id'"));
?>

<form id="frm_city_master_update">
<input type="hidden" id="state_id" name="state_id" value="<?= $state_id ?>">

<div class="modal fade" id="state_master_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update State</h4>
      </div>
      <div class="modal-body text-center">

          <div class="row mg_bt_10">
            <div class="col-sm-6 mg_bt_10">
              <label for="txt_state_name">State Name</label>
              <input type="text" class="form-control" id="txt_state_name" onchange="validate_state(this.id)" name="txt_state_name" value="<?php echo $sq['state_name'] ?>" required>
            </div>
            <div class="col-sm-6 mg_bt_10">
              <label for="active_flag">Status</label>
              <select name="active_flag" id="active_flag" title="Status" class="form-control" required>
              <?php if($sq['active_flag'] != ''){ ?>
                <option value="<?= $sq['active_flag'] ?>"><?= $sq['active_flag'] ?></option>
                <?php } ?>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="row text-center">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="update_state"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>
        
      </div>      
    </div>
  </div>
</div>
</form>

<script>
  $('#state_master_update_modal').modal('show');  
  $('#frm_city_master_update').validate({
      submitHandler:function(form){

         var base_url = $('#base_url').val();
         var state_id = $("#state_id").val();
         var state_name = $("#txt_state_name").val();
         var active_flag = $('#active_flag').val();
         $('#update_state').button('loading');
          $.post( 
                 base_url+"controller/other_masters/states/update_states.php",
                 { state_id : state_id, state_name : state_name, active_flag : active_flag },
                 function(data) {   
                var msg = data.split('--');
                if(msg[0]=="error"){
                  error_msg_alert(msg[1]); 
                  $('#update_state').button('reset');
                }
                else{
                       msg_alert(data);
                       $('#state_master_update_modal').modal('hide');  
                       $('#update_state').button('reset');
                      list_reflect();
                }
                 });
      }
  });
</script>