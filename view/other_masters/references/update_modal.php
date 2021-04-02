  <?php
include "../../../model/model.php";

$reference_id = $_POST['reference_id'];

$sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$reference_id'"));
$field = ($sq_ref['reference_id'] == '1' ||$sq_ref['reference_id'] == '2') ? 'readonly' : '';
?>
<form id="frm_update">
<input type="hidden" id="reference_id" name="reference_id" value="<?= $reference_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Reference</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="reference2" name="reference2"  onchange="fname_validate(this.id);" placeholder="Reference" title="Reference" value="<?= $sq_ref['reference_name'] ?>" <?= $field ?>>
            </div>
            <div class="col-sm-6 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" style="width:100%">
                <?php if($sq_ref['active_flag'] != ''){ ?>
                <option value="<?= $sq_ref['active_flag'] ?>"><?= $sq_ref['active_flag'] ?></option>
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
            reference2 : { required : true }
    },
    submitHandler:function(form){

        var reference_id = $('#reference_id').val();
        var reference = $('#reference2').val();
        var status = $('#active_flag1').val();

        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/references/update_reference.php',
          data:{ reference_id : reference_id, reference : reference, status : status },
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              if(msg[0]!="error"){
                $('#update_modal').modal('hide');
                msg_alert(result);
                list_reflect();
              }
              else{
                error_msg_alert(msg[1]);
                $('#btn_update').button('reset');
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>