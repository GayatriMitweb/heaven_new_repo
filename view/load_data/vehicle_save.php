<?php
include "../../model/model.php";
$vehicle_name_id = $_POST['vehicle_name_id'];
echo $vehicle_name_id;
?>
<form id="frm_vehcile_master_save">
<div class="modal fade" id="vehcile_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vehicle</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4">
                    <select id="vehicle_types" name="vehicle_types" style="width:100%" title="Vehcile Type" data-toggle="tooltip" class="form-control" required>
                        <?php get_vehicle_types(); ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <input type="text" id="vehicle_names" name="vehicle_names" onchange="locationname_validate(this.id);" placeholder="*Vehicle Name" title="Vehicle Name" class="form-control" required>
                </div>
                <div class="col-sm-4">
                    <input type="number" id="seating_cs" name="seating_cs" placeholder="*Seating Capacity" title="Seating Capacity" class="form-control" required>
                </div>
            </div>
            <div class="row mg_tp_10">
                <div class="col-xs-12 text-center">
                <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-plus"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<input type="hidden" id="vehicle_name_id" value="<?=$vehicle_name_id?>"/>
</form>
<script>
$('#vehcile_save_modal').modal('show');
$('#vehicle_types').select2();
$('#frm_vehcile_master_save').validate({
    rules:{
        dest_names1 : {required:true}
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();
        var vehicle_name_id = $('#vehicle_name_id').val();
        var vehicle_type = $('#vehicle_types').val();
        var vehicle_name = $('#vehicle_names').val();
        var seating_c = $('#seating_cs').val();

        $.ajax({
            type    : 'post',
            url     : base_url + 'controller/generic_vehicle_save.php',
            data    : {
                vehicle_type: vehicle_type,
                vehicle_name: vehicle_name,
                seating_c: seating_c
            },
            success : function (result) {
                var msg = result.split('--');
                $('#save').button('reset');
                if (msg[0] == 'error') {
                    error_msg_alert(msg[1]);
                    return false;
                }
                else {
                    reset_form('frm_vehcile_master_save');
                    $('#vehcile_save_modal').modal('hide');
                    var vehicle_name_ids = vehicle_name_id.split(',');
                    for(i=0;i<vehicle_name_ids.length;i++){
                        $('#'+vehicle_name_ids[i]).append(result);
                    }
                }
            }
        });
        
    }
});
</script>