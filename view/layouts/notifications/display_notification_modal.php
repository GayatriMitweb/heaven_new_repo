<?php
include_once("../../../model/model.php");
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role']; 
$role_id = $_SESSION['role_id']; 
$login_id = $_SESSION['login_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$flag = true;
?>
<div class="notification_panel">
	<div class="close_notification_panel" onclick="display_notification()"><i class="fa fa-times" aria-hidden="true"></i></div>
	<div class="notification_panel_content mg_tp_20 text-center">
		<ul class="nav nav-tabs responsive" role="tablist">
			<?php if($role_id <= 5){
			$flag=false;
			?><li role="presentation" class="active"><a href="#enquiry_notification" aria-controls="home" role="tab" data-toggle="tab" class="tab_name" onclick="enquiry_count_update('enquiry')">Enquiry</a></li><?php }?>
			<?php $active_class = ($flag == false) ? '' : 'active'?>
			<li role="presentation" class="<?= $active_class?>"><a href="#task_notification" aria-controls="home" role="tab" data-toggle="tab" class="tab_name" onclick="enquiry_count_update('task')">Task</a></li>
			<li role="presentation"><a href="#leave_notification" aria-controls="home" role="tab" data-toggle="tab" class="tab_name" onclick="enquiry_count_update('leave')">Leave</a></li>
	    </ul>
	    <hr class="no-marg">
   		<!-- Tab panes1 -->
		<div class="tab-content responsive">
		    <!-- *****TAb1 start******* -->
			<?php if($role_id <= 5){
			$flag=false;
			?>
				<div role="tabpanel" class="tab-pane active" id="enquiry_notification">
				<?php include "tab1.php"; ?>
				</div>
			<?php }?>
		    <!-- ********TAb2 start******** --> 
			<?php $active_class = ($flag == false) ? '' : 'active'?>

        	<div role="tabpanel" class="tab-pane <?= $active_class?>" id="task_notification">
		     <?php include "tab2.php"; ?>
		    </div>
			<!-- ********TAb2 start******** --> 
		    <div role="tabpanel" class="tab-pane" id="leave_notification">
		     <?php include "tab3.php"; ?>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
function enquiry_count_update(type){
    var base_url = $('#base_url').val();
    $.post(base_url+'controller/login/notification/enquiry_count_update.php', { type : type }, function(data){
        $('#enquiry_count11').html(data);
    });
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>