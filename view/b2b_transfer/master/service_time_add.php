<?php
include_once('../../../model/model.php');
$sq_app = mysql_fetch_assoc(mysql_query("select setting_id,transfer_service_time from app_settings where setting_id =1"));
$transfer_service_time = json_decode($sq_app['transfer_service_time']);
?>
<form id="frm_time_save" class="servingTime">
<div class="modal fade" id="time_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Service Timing</h4>
      </div>
      <div class="modal-body">
        
        <div class='row'>
            <div class="col-md-12 col-sm-3 text-center"> 
                <div class="panel panel-default panel-body app_panel_style feildset-panel">
                <legend>Pickup</legend>
                <div class="col-md-2 col-sm-3 "></div>
                <div class="col-md-4 col-sm-3 "><label>From Time</label>
                    <input type="text" id="pickup_from_time" name="pickup_from_time" placeholder="*Pickup From Time" title="Pickup From Time" data-toggle="tooltip" value="<?= $transfer_service_time[0]->pick_from ?>" class="form-control" readonly required>
                </div>
                <div class="col-md-4 col-sm-3 "><label>To Time</label>
                    <input type="text" id="pickup_to_time" name="pickup_to_time" placeholder="*Pickup To Time" title="Pickup To Time" data-toggle="tooltip" value="<?= $transfer_service_time[0]->pick_to ?>" class="form-control" readonly required>
                </div>
                </div>
            </div>
            <div class="col-md-12 mg_tp_20 text-center col-sm-3 ">
                <div class="panel panel-default panel-body app_panel_style feildset-panel">
                <legend>Return</legend>        
                <div class="col-md-2 col-sm-3 "></div> 
                <div class="col-md-4 col-sm-3 "><label>From Time</label>
                    <input type="text" id="return_from_time" name="return_from_time" placeholder="*Return From Time" title="Return From Time" data-toggle="tooltip" value="<?= $transfer_service_time[0]->return_from ?>" class="form-control" readonly required>
                </div>
                <div class="col-md-4 col-sm-3 "><label>To Time</label>
                    <input type="text" id="return_to_time" name="return_to_time" placeholder="*Return To Time" title="Return To Time" data-toggle="tooltip" value="<?= $transfer_service_time[0]->return_to ?>" class="form-control" readonly required>                    
                </div>
                </div>
            </div>
        </div>

        <div class="row text-center mg_tp_30">
            <div class="col-12 text-center">
                <a class="btn btn-primary st-editProfile st-toggleProfile" id="save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Edit</a>
                <a class="btn btn-primary saveProfile" class="saveprofile" onclick="save_service_timing()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</a>
                <a class="btn btn-danger st-cancleEdit st-toggleProfile"><i class="fa fa-remove"></i>&nbsp;&nbsp;Cancel</a> 
            </div>
        </div> 

      </div>      
    </div>
  </div>
</div>
</form>
<script>
$('#time_save_modal').modal('show');
//**Site Tooltips
$(function () {
	$("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
	$("[data-toggle='tooltip']").click(function(){$('.tooltip').remove()})
});
</script>
