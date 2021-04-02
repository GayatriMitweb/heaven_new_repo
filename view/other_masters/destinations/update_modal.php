<?php
include "../../../model/model.php";

$dest_id = $_POST['dest_id'];

$sq_dest = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id='$dest_id'"));
?>
<form id="frm_update">
<input type="hidden" id="dest_id" name="dest_id" value="<?= $dest_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Destination</h4>
      </div>
      <div class="modal-body">

          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="dest_name" name="dest_name"  onchange="fname_validate(this.id);" placeholder="Destination Name" title="Destination Name" value="<?= $sq_dest['dest_name'] ?>">
            </div>
            <div class="col-sm-6 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" style="width:100%">
                <option value="<?= $sq_dest['status'] ?>"><?= $sq_dest['status'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div class="row mg_tp_10">
            <div class="col-sm-12 text-center">
                <button class="btn btn-sm btn-success" id="btn_update_d"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#update_modal').modal('show');

$('#frm_update').validate({
    rules:{
            dest_name : { required : true },
    },
    submitHandler:function(form){

        var dest_id = $('#dest_id').val();
        var dest_name = $('#dest_name').val();
        var dest_status = $('#active_flag1').val();        

        $('#btn_update_d').button('loading');
        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/destination/update_destination.php',
          data:{ dest_id : dest_id, dest_name : dest_name, dest_status : dest_status },
          success:function(result){
              var msg = result.split('--');
              if(msg[0]!="error"){
              msg_alert(result);
                $('#btn_update_d').button('reset');
                $('#update_modal').modal('hide');
                list_reflect();
              }else{
              error_msg_alert(msg[1]);
                $('#btn_update_d').button('reset');
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>