<?php
include "../../../model/model.php";

$ledger_id = $_POST['ledger_id'];

$sq_gl = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$ledger_id'"));
?>
<form id="frm_update">
<input type="hidden" id="ledger_id" name="ledger_id" value="<?= $ledger_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Ledger</h4>
      </div>
      <div class="modal-body">
        
    		<div class="row">
          <div class="col-sm-4 mg_bt_10_sm_xs">
            <input type="text" id="ledger_name" name="ledger_name" placeholder="*Ledger Name" title="Ledger Name" value="<?= $sq_gl['ledger_name'] ?>" readonly>
          </div>
          <div class="col-sm-4 mg_bt_10_sm_xs">
            <input type="text" id="alias_name" name="alias_name" placeholder="Alias" title="Alias"  value="<?= $sq_gl['alias'] ?>">
          </div>
          <div class="col-sm-4 mg_bt_10_sm_xs">
            <select id="group_id1" name="group_id1" title="Group" onchange="reflect_side(this.id,'dr_cr');" style="width:100%">
            <?php $sq_group1 = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$sq_gl[group_sub_id]'")); ?>
              <option value="<?php echo $sq_group1['subgroup_id']; ?>"><?php echo $sq_group1['subgroup_name']; ?></option>
              <option value="">*Select Group</option>
              <?php 
              $sq_group = mysql_query("select * from subgroup_master where 1 ");
              while($row_group = mysql_fetch_assoc($sq_group)) { ?>
                  <option value="<?php echo $row_group['subgroup_id']; ?>"><?php echo $row_group['subgroup_name']; ?></option>
                  <?php } ?>
            </select>
          </div>
          <div class="col-sm-4 mg_tp_10 hidden">
            <input type="text" id="ledger_balance" name="ledger_balance" placeholder="Ledger Balance" title="Ledger Balance" value="<?= $sq_gl['balance'] ?>"  onchange="validate_balance(this.id)">
          </div> 
          <div class="col-sm-4 mg_tp_10">
            <select id="dr_cr" name="dr_cr" title="Dr/Cr" disabled>
              <option value="<?= $sq_gl['dr_cr'] ?>"><?= $sq_gl['dr_cr'] ?></option>
              <option value="Dr">Dr</option>
              <option value="Cr">Cr</option>
            </select>
          </div> 
          <div class="col-sm-4 mg_tp_10">
            <select id="status" name="status" title="Active Status">
              <option value="<?= $sq_gl['status'] ?>"><?= $sq_gl['status'] ?></option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div> 
        </div>  

          <div class="row mg_tp_20 text-center">
          <div class="col-md-12">
              <button class="btn btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#update_modal').modal('show');
$('#group_id1').select2();

$(function(){
  $('#frm_update').validate({
    rules:{
          gl_name : { required : true },
          group_id1 : { required : true },        
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var ledger_name = $('#ledger_name').val();
        var alias_name = $('#alias_name').val(); 
        var group_id = $('#group_id1').val();
        var ledger_balance = $('#ledger_balance').val();
        var side = $('#dr_cr').val();
        var ledger_id = $('#ledger_id').val();
        var status = $('#status').val();

        $('#btn_update').button('loading');

        $.post(
               base_url+"controller/finance_master/ledger_master/ledger_master_update.php",
               { ledger_id : ledger_id,ledger_name : ledger_name, alias_name : alias_name, group_id : group_id, ledger_balance : ledger_balance, side : side,status:status },
               function(data) {
                  $('#btn_update').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#update_modal').modal('hide');  
                    list_reflect();
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>