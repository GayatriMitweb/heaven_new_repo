<?php
include "../../../model/model.php";

$airline_id = $_POST['airline_id'];

$sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$airline_id'"));
?>
<form id="frm_update">
<input type="hidden" id="airline_id" name="airline_id" value="<?= $airline_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Airline</h4>
      </div>
      <div class="modal-body">

          <div class="row">
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="airline_name" name="airline_name" placeholder="Airline Name" title="Airline Name" value="<?= $sq_airline['airline_name'] ?>">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <input type="text" id="airline_code" name="airline_code" placeholder="Airline Code" onchange="validate_alphanumeric(this.id)" title="Airline Code" value="<?= $sq_airline['airline_code'] ?>" style="text-transform: uppercase;">
            </div>
            <div class="col-sm-4 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" style="width:100%">
                <option value="<?= $sq_airline['active_flag'] ?>"><?= $sq_airline['active_flag'] ?></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div class="row mg_tp_10 text-center">
              <div class="col-md-12">
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
            airline_name : { required : true },
            airline_code : { required : true },
    },
    submitHandler:function(form){
        var airline_id = $('#airline_id').val();
        var airline_name = $('#airline_name').val();
        var airline_code = $('#airline_code').val();
        var airline_status = $('#active_flag1').val();        

        $('#btn_update').button('loading');
        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/airlines/update_airline.php',
          data:{ airline_id : airline_id, airline_name : airline_name, airline_code : airline_code, airline_status : airline_status },
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              if(msg[0]!="error"){
                $('#update_modal').modal('hide');
                list_reflect();
                msg_alert(result);
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