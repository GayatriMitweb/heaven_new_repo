<?php
include "../../../model/model.php";

$airport_id = $_POST['airport_id'];

$sq_airport = mysql_fetch_assoc(mysql_query("select * from airport_master where airport_id='$airport_id'"));
$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_airport[city_id]'"));
?>
<form id="frm_update">
<input type="hidden" id="airport_id" name="airport_id" value="<?= $airport_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Airport</h4>
      </div>
      <div class="modal-body">

          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <select name="city_id" id="city_id" style="width: 100%" class="form-control">
                <option value="<?= $sq_city['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
              </select>
            </div>
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="airport_name" name="airport_name" placeholder="Airport Name" title="Airport Name" value="<?= $sq_airport['airport_name'] ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 mg_bt_10">
              <input type="text" id="airport_code" name="airport_code" onchange="validate_alphanumeric(this.id)" placeholder="Airport Code"  title="*Airport Code" value="<?= $sq_airport['airport_code'] ?>" style="text-transform: uppercase;">
            </div>
            <div class="col-sm-6 mg_bt_10">
              <select name="active_flag1" id="active_flag1" title="Status" style="width:100%">
                <option value="<?= $sq_airport['flag'] ?>"><?= $sq_airport['flag'] ?></option>
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
city_lzloading('#city_id');
$('#frm_update').validate({
    rules:{
            city_id : { required : true },
            airport_name : { required : true },
            airport_code : { required : true },

    },
    submitHandler:function(form){

        var airport_id = $('#airport_id').val();
        var city_id = $('#city_id').val();
        var airport_name = $('#airport_name').val();
        var airport_code = $('#airport_code').val();
        var active_flag = $('#active_flag1').val();
        

        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/airports/update_airport.php',
          data:{ airport_id : airport_id, city_id : city_id, airport_name : airport_name, airport_code : airport_code , active_flag : active_flag},
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              if(msg[0]!="error"){
                $('#update_modal').modal('hide');
                //SearchData();
                list_reflect();
                msg_alert(result);
              }
              else{
                error_msg_alert(msg[1]);
                $('#btn_update').button('reset');
                list_reflect();
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>