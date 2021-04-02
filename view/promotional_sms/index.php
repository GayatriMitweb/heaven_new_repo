<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='promotional_sms/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Promotional SMS',99) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center mg_bt_20">
	<div class="col-md-12">  
	    <label for="rd_message_groups" class="app_dual_button active">
	        <input type="radio" id="rd_message_groups" name="rd_promotional_sms" checked onchange="promotional_sms_content_reflect()">
	        &nbsp;&nbsp;SMS Group
	    </label>
		<label for="rd_mobile_no" class="app_dual_button">
	        <input type="radio" id="rd_mobile_no" name="rd_promotional_sms" onchange="promotional_sms_content_reflect()">
	        &nbsp;&nbsp;Mobile No
	    </label>  
	    <label for="rd_messages" class="app_dual_button">
	        <input type="radio" id="rd_messages" name="rd_promotional_sms"onchange="promotional_sms_content_reflect()">
	        &nbsp;&nbsp;SMS Text
	    </label>
	</div>
</div>

<div id="div_promotional_sms_content"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function promotional_sms_content_reflect()
{	
	var branch_status = $('#branch_status').val();
	var id = $('input[name="rd_promotional_sms"]:checked').attr('id');
	if(id=="rd_mobile_no"){
		$.post('mobile_no/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_sms_content').html(data);
		});
	}
	if(id=="rd_message_groups"){
		$.post('sms_group/index.php', {branch_status : branch_status}, function(data){
			$('#div_promotional_sms_content').html(data);
		});
	}
	if(id=="rd_messages"){
		$.post('messages/index.php', { branch_status : branch_status}, function(data){
			$('#div_promotional_sms_content').html(data);
		});
	}
}
promotional_sms_content_reflect();
</script>
<script src="js/mobile_no.js"></script>
<script src="js/sms_group.js"></script>
<script src="js/messages.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>