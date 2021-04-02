<?php
include "../../../model/model.php"; 
  
$city_id = $_POST['city_id'];  
$sq = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$city_id'"));
?>

<form id="frm_city_master_update">
<input type="hidden" id="city_id" name="city_id" value="<?= $city_id ?>">

<div class="modal fade" id="city_master_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update City</h4>
      </div>
      <div class="modal-body text-center">

          <div class="row mg_bt_10">
            <div class="col-sm-6 mg_bt_10">
              <label for="txt_city_name">City Name</label>
              <input type="text" class="form-control" id="txt_city_name"  name="txt_city_name" value="<?php echo $sq['city_name'] ?>" onchange="validate_city(this.id)" required>
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
              <button class="btn btn-sm btn-success" id="update_city"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>
        
      </div>      
    </div>
  </div>
</div>
<div id="div_city_list"></div>
</form>

<script>
  $('#city_master_update_modal').modal('show');  
  $('#frm_city_master_update').validate({
      submitHandler:function(form){
        var base_url = $('#base_url').val();
        var city_id = $("#city_id").val();
        var city_name = $("#txt_city_name").val();
        var active_flag = $('#active_flag').val();
        $('#update_city').button('loading');
        $.post(
          base_url+"controller/group_tour/tour_cities/city_master_update_c.php",
          { city_id : city_id, city_name : city_name, active_flag : active_flag },
          function(data) {  
            var msg = data.split('--');
            if(msg[0]=='error'){
              error_msg_alert(msg[1]);
              $('#update_city').button('reset');
              return false;
            }
            else{
              $('#update_city').button('reset');
              $('#city_master_update_modal').modal('hide');
              msg_alert(data);
              // window.location.reload();
              list_reflect();
            }
        });
      }
  });
</script>