  <?php
include "../../../model/model.php";

$entry_id = $_POST['entry_id'];

$sq_ref = mysql_fetch_assoc(mysql_query("select * from room_category_master where entry_id='$entry_id'"));
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $entry_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Room Category</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="room_category" name="room_category"  onchange="fname_validate(this.id);" placeholder="Reference" title="Reference" value="<?= $sq_ref['room_category'] ?>" />
            </div>
            <div class="col-sm-6 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" style="width:100%">
                <?php if($sq_ref['active_status'] != ''){ ?>
                <option value="<?= $sq_ref['active_status'] ?>"><?= $sq_ref['active_status'] ?></option>
                <?php } ?>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-xs-12 text-center">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
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
            room_category : { required : true }
    },
    submitHandler:function(form){

        var entry_id = $('#entry_id').val();
        var room_category = $('#room_category').val();
        var status = $('#active_flag1').val();

        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/room_category/update_room_category.php',
          data:{ entry_id : entry_id, room_category : room_category, status : status },
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              msg_alert(result);
              if(msg[0]!="error"){
                $('#update_modal').modal('hide');
                list_reflect();
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>