<?php
include "../../../../model/model.php";
require_once('../../layouts/admin_header.php');
$sq_app = mysql_fetch_assoc(mysql_query("select policy_url from app_settings where setting_id='1'"));
if($sq_app['policy_url']!=''){
	$newUrl1 = preg_replace('/(\/+)/','/',$sq_app['policy_url']); 
	$policy_url = BASE_URL.str_replace('../', '', $newUrl1);
}
else{
	$policy_url = '';
}
?>
<input type="hidden" value="<?= $policy_url ?>" id="policy_url1">
<script>
function backup_application()
{
	var policy_url1 = $('#policy_url1').val();
	if(policy_url1 == ''){
		alert("Sorry!Cancellation policy not uploaded.");
		return false;
	}
	else{
		var anchor = document.createElement('a');
		anchor.href = policy_url1;
		anchor.target = '_blank';
		anchor.download = policy_url1;
		anchor.click();
	}
}
backup_application();
</script>
<?php require_once('../../layouts/admin_footer.php'); ?>