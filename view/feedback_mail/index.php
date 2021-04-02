<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Customer Feedback Request') ?>

<div class="text-center mg_bt_20">
	<label for="rd_group_tour" class="app_dual_button active">
        <input type="radio" id="rd_group_tour" name="rd_app_feedback" checked  onchange="feedback_content_reflect()">
        &nbsp;&nbsp;Group Tour
    </label>    
    <label for="rd_package_tour" class="app_dual_button">
        <input type="radio" id="rd_package_tour" name="rd_app_feedback" onchange="feedback_content_reflect()">
        &nbsp;&nbsp;Package Tour
    </label>
</div>

<div id="div_feedback_mail_content"></div>

<?= end_panel() ?>


<script>
	function feedback_content_reflect()
	{
		var id = $('input[name="rd_app_feedback"]:checked').attr('id');

		if(id=="rd_group_tour"){
			$.post('group_tour/index.php', {}, function(data){
				$('#div_feedback_mail_content').html(data);
			});
		}
		if(id=="rd_package_tour"){
			$.post('package_tour/index.php', {}, function(data){
				$('#div_feedback_mail_content').html(data);
			});
		}
	}
	feedback_content_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>