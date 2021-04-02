<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='promotional_email/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Promotional Email',100) ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center mg_bt_20">
	<div class="col-md-12">
	    <label for="rd_email_groups" class="app_dual_button active">
	        <input type="radio" id="rd_email_groups" name="rd_promotional_email" checked onchange="promotional_email_content_reflect()">
	        &nbsp;&nbsp;Email Group
	    </label>
	    <label for="rd_email_id" class="app_dual_button ">
	        <input type="radio" id="rd_email_id" name="rd_promotional_email"  onchange="promotional_email_content_reflect()">
	        &nbsp;&nbsp;Email ID
	    </label>
	    <label for="rd_templates" class="app_dual_button">
	        <input type="radio" id="rd_templates" name="rd_promotional_email"onchange="promotional_email_content_reflect()">
	        &nbsp;&nbsp;Templates
	    </label>
	    <label for="rd_send_mail" class="app_dual_button">
	        <input type="radio" id="rd_send_mail" name="rd_promotional_email"onchange="promotional_email_content_reflect()">
	        &nbsp;&nbsp;Email Send
	    </label>
	</div>
</div>

<div id="div_promotional_email_content"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function promotional_email_content_reflect()
{
	var branch_status = $('#branch_status').val();
	var id = $('input[name="rd_promotional_email"]:checked').attr('id');
	
	if(id=="rd_email_groups"){
		$.post('email_group/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_email_content').html(data);
		});
	}
	if(id=="rd_email_id"){
		$.post('email_id/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_email_content').html(data);
		});
	}
	if(id=="rd_templates"){
		$.post('templates/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_email_content').html(data);
		});
	}
	if(id=="rd_send_mail"){
		$.post('messages/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_email_content').html(data);
		});
	}
}
promotional_email_content_reflect();
</script>
<script src="js/email_id.js"></script>
<script src="js/email_group.js"></script>
<script src="js/messages.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>