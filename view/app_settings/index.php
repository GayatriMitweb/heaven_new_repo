<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');

$sq_settings = mysql_fetch_assoc(mysql_query("select * from app_settings"));
?>
<?= begin_panel('Company Profile',3) ?>
<div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<label for="rd_app_basic" class="app_dual_button active">
	        <input type="radio" id="rd_app_basic" name="rd_app" checked onchange="content_reflect()">
	        &nbsp;&nbsp;Profile
	    </label>
	    <label for="rd_fyear" class="app_dual_button">
	        <input type="radio" id="rd_fyear" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Financial Year
	    </label>
		<label for="rd_bank" class="app_dual_button">
	        <input type="radio" id="rd_bank" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Bank
	    </label>
	    <label for="rd_app_credentials" class="app_dual_button">
	        <input type="radio" id="rd_app_credentials" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Credentials
	    </label>
	    <label for="rd_app_formats" class="app_dual_button">
	        <input type="radio" id="rd_app_formats" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Format
	    </label>
	    <label for="rd_credit" class="app_dual_button">
	        <input type="radio" id="rd_credit" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Credit Card
	    </label>
	</div>   
</div>

<div id="div_app_setting_content"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>

<script>
function content_reflect()
{
	var base_url= $('#base_url').val();
	var id = $('input[name="rd_app"]:checked').attr('id');
	if(id=="rd_app_basic"){
		$.post('basic_info/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
	if(id=="rd_fyear"){
		$.post(base_url+'view/finance_master/financial_year/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
	if(id=="rd_bank"){
		$.post(base_url+'view/finance_master/bank_master/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
	if(id=="rd_app_credentials"){
		$.post('cred_info/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
	if(id=="rd_app_formats"){
		$.post('app_format/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
	if(id=="rd_credit"){
		$.post('credit_card_charges/index.php', {}, function(data){
			$('#div_app_setting_content').html(data);
		});
	}
}
content_reflect();
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>