<?php
include "../../../model/model.php";

$group_id = $_POST['group_id'];

$sq_group = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$group_id'"));
?>
<form id="frm_update">
<input type="hidden" id="subgroup_id1" name="subgroup_id1" value="<?= $group_id ?>">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-subgrouper">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Group</h4>
      </div>
      <div class="modal-body">
        
    		<div class="row">
    			<div class="col-sm-6 mg_bt_10">
    				<input type="text" id="group_name" name="group_name" placeholder="Group Name" title="Group Name" value="<?= $sq_group['subgroup_name'] ?>">
    			</div>
          <div class="col-sm-6 mg_bt_10">
            <select id="group_id1" name="group_id1" title="Subgroup" style="width:100%">             
              <?php $sq_subgroup1 = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$sq_group[group_id]'")); ?>
              <option value="<?php echo $sq_subgroup1['subgroup_id']; ?>"><?php echo $sq_subgroup1['subgroup_name']; ?></option>
              <option value="">*Select Group</option>
              <?php 
              $sq_subgroup = mysql_query("select * from subgroup_master where 1 ");
              while($row_subgroup = mysql_fetch_assoc($sq_subgroup)) { ?>
                  <option value="<?php echo $row_subgroup['subgroup_id']; ?>"><?php echo $row_subgroup['subgroup_name']; ?></option>
                  <?php } ?>
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
$('#group_id1').select2();
$(function(){
  $('#frm_update').validate({
    rules:{
          group_name : { required : true },
          group_id1 : { required : true },
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var subgroup_name = $('#group_name').val();
        var group_id = $('#group_id1').val();
        var subgroup_id = $('#subgroup_id1').val();
        $('#btn_update').button('loading');

        $.post(
               base_url+"controller/finance_master/group_master/group_master_update.php",
               { subgroup_name : subgroup_name, group_id : group_id, subgroup_id : subgroup_id},
               function(data) {
                  $('#btn_update').button('reset');
                  var msg = data.split('--');
                  if(msg[0]=="error"){
                    error_msg_alert(msg[1]);
                  }else{
                    msg_alert(data);
                    $('#update_modal').modal('hide');  
                    $('#update_modal').on('hidden.bs.modal', function(){
                      list_reflect();
                    });
                  }
                  
        });  

    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>