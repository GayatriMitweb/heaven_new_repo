<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Customers Status') ?>

<div class="row mg_bt_20">
	<div class="col-md-12 text-center">
		<label for="rd_feedback" class="app_dual_button">
	        <input type="radio" id="rd_feedback" name="rd_cust" checked onchange="content_reflect()">
	        &nbsp;&nbsp;Feedback
	    </label>    
	</div>
</div>

<div id="div_cust_content"></div>

<?= end_panel() ?>

<script>
function content_reflect()
{
	var id = $('input[name="rd_cust"]:checked').attr('id');
	if(id=="rd_feedback"){
		$.post('feedback/index.php', {}, function(data){
			$('#div_cust_content').html(data);
		});
	}
	 
}
content_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>