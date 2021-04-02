<?php
include "../../model/model.php";

$task_id = $_POST['task_id'];

$sq_task = mysql_fetch_assoc(mysql_query("select * from tasks_master where task_id='$task_id'"));
?>
<div class="modal fade" id="task_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Task Status</h4>
      </div>
      <div class="modal-body">
        
		<form id="frm_task_status">

			<input type="hidden" id="task_id" name="task_id" value="<?= $task_id ?>">
			
			<div class="row text-center mg_bt_20">
				<div class="col-sm-8 mg_bt_10_sm_xs">
					<label for="extra_note">Add Note</label>
					<textarea name="extra_note" id="extra_note" title="Note" placeholder="*Note" rows="1"></textarea>
				</div>
				<div class="col-sm-4">
					<label for="extra_note">Status</label>
					<select name="task_status" id="task_status" title="Status">
						<option value="">Task Status</option>
						<option value="Completed">Completed</option>
						<option value="Incomplete">Incomplete</option>
						<option value="Cancelled">Cancelled</option>
					</select>
				</div>
			</div>
			<div class="row text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Ok</button>	&nbsp;&nbsp;
				</div>
			</div>

		</form>

      </div>     
    </div>
  </div>
</div>

<script>
$('#task_status_modal').modal('show');
$(function(){
	$('#frm_task_status').validate({
		rules:{
			extra_note: { required:true },
			task_status : { required : true}
		},
		submitHandler:function(form){
			var task_id = $('#task_id').val();
			var extra_note = $('#extra_note').val();
			var task_status = $('#task_status').val();

			var base_url = $('#base_url').val();

			$.ajax({
				type:'post',
				url:base_url+'controller/tasks/task_status_update.php',
				data:{ task_id : task_id, extra_note : extra_note , task_status : task_status},
				success:function(result){
					msg_alert(result);
					$('#task_status_modal').modal('hide');
					tasks_list_reflect();
				}
			});
		}
	});
});

function task_clone_modal(task_id){

	var extra_note = $('#extra_note').val();
	if(extra_note==""){
		error_msg_alert('Please enter Note!');
		return false;
	}

	$.post('task_clone_modal.php', { task_id : task_id, extra_note : extra_note }, function(data){
		$('#task_status_modal').modal('hide');
		$('#div_task_clone_modal').html(data);
	});

}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>