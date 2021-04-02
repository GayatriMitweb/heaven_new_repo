<?php
include "../../../model/model.php";
$entry_id = $_POST['entry_id'];

$sq_roe = mysql_fetch_assoc(mysql_query("select * from roe_master where entry_id='$entry_id'"));
$sq_cur = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$sq_roe[currency_id]'"));
?>
<form id="frm_update">
<input type="hidden" id="entry_id" name="entry_id" value="<?= $entry_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update ROE</h4>
      </div>
      <div class="modal-body">

          <div class="row mg_bt_10">
            <div class="col-md-12">
              <select name="currency_code1" id="currency_code1" style='width:100%;' class="app_select2" required>
                <option value="<?= $sq_cur['id'] ?>"><?= $sq_cur['currency_code'] ?></option>
                <option value="">Select Currency</option>
                  <?php
                  $sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");
                  while($row_currency = mysql_fetch_assoc($sq_currency)){
                  ?>
                    <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row mg_bt_10">
            <div class="col-md-12">
              <input type="number" id="currency_rate1" name="currency_rate1" placeholder="Currency Rate" title="Currency Rate" value="<?= $sq_roe['currency_rate'] ?>" required>
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
</form>
<script>
$('#update_modal').modal('show');
$('#currency_code1').select2();
$('#frm_update').validate({
    rules:{
          
    },
    submitHandler:function(form){
        var entry_id = $('#entry_id').val();
        var currency_code = $('#currency_code1').val();
        var currency_rate = $('#currency_rate1').val();  

        $('#btn_update').button('loading');
        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/roe/update_roe.php',
          data:{ entry_id : entry_id, currency_code : currency_code, currency_rate : currency_rate },
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