<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Ledger</h4>
      </div>
      <div class="modal-body">
        
    		<div class="row">
    			<div class="col-sm-4 mg_bt_10_sm_xs">
    				<input type="text" id="ledger_name" name="ledger_name" placeholder="*Ledger Name" title="Ledger Name">
    			</div>
          <div class="col-sm-4 mg_bt_10_sm_xs">
            <input type="text" id="alias_name" name="alias_name" placeholder="Alias" title="Alias">
          </div>
          <div class="col-sm-4 mg_bt_10_sm_xs">
            <select id="group_id" name="group_id" title="Group" onchange="reflect_side(this.id,'dr_cr');" style="width:100%">
              <option value="">*Select Group</option>
              <?php 
              $sq_group = mysql_query("select * from subgroup_master where 1 ");
              while($row_group = mysql_fetch_assoc($sq_group)) { ?>
                  <option value="<?php echo $row_group['subgroup_id']; ?>"><?php echo $row_group['subgroup_name']; ?></option>
                  <?php } ?>
            </select>
          </div>
          <div class="col-sm-4 mg_tp_10 hidden">
            <input type="text" id="ledger_balance" name="ledger_balance" placeholder="Ledger Balance" title="Ledger Balance" value="0.00"  onchange="validate_balance(this.id)">
          </div> 
          <div class="col-sm-4 mg_tp_10">
            <select id="dr_cr" name="dr_cr" title="Dr/Cr">
              <option value="Cr">Cr</option>
              <option value="Dr">Dr</option>
            </select>
          </div> 
        </div>      

        <div class="row mg_tp_20 text-center">
          <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>  
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
$('#group_id').select2();

$(function(){
  $('#frm_save').validate({
    rules:{
          ledger_name : { required : true },
          group_id : { required : true },        
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var ledger_name = $('#ledger_name').val();
        var alias_name = $('#alias_name').val(); 
        var group_id = $('#group_id').val();
        var ledger_balance = $('#ledger_balance').val();
        var side = $('#dr_cr').val();

        $('#btn_save').button('loading');

        $.post(
              base_url+"controller/finance_master/ledger_master/ledger_master_save.php",
              { ledger_name : ledger_name, alias_name : alias_name, group_id : group_id, ledger_balance : ledger_balance, side : side },
              function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#save_modal').modal('hide');  
                    list_reflect();
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>