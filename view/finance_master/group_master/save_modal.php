<?php
include "../../../model/model.php";
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-grouper">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Account Group</h4>
      </div>
      <div class="modal-body">  
    		<div class="row">
    			<div class="col-sm-6 mg_bt_10">
    				<input type="text" id="group_name" name="group_name" placeholder="*Group Name" title="Group Name">
    			</div>
          <div class="col-sm-6 mg_bt_10">
            <select id="group_id" name="group_id" title="Subgroup" style="width:100%">
              <option value="">*Select Group</option>
              <?php 
              $sq_group = mysql_query("select * from subgroup_master where 1 ");
              while($row_group = mysql_fetch_assoc($sq_group)) { ?>
                  <option value="<?php echo $row_group['subgroup_id']; ?>"><?php echo $row_group['subgroup_name']; ?></option>
                  <?php } ?>
            </select>
          </div>
        </div>
        <div class="row mg_tp_10 text-center">
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
          group_name : { required : true },
          group_id : { required : true },
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var group_name = $('#group_name').val();
        var group_id = $('#group_id').val();
        $('#btn_save').button('loading');

        $.post(
               base_url+"controller/finance_master/group_master/group_master_save.php",
               { subgroup_name : group_name, group_id : group_id},
               function(data) {
                  $('#btn_save').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#save_modal').modal('hide');  
                    $('#save_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>