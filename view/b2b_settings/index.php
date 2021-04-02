<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('B2B Settings','') ?>
<?php
if($setup_package == '4'){ ?>
<div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<label for="rd_app_basic" class="app_dual_button active">
	        <input type="radio" id="rd_app_basic" name="rd_app" checked onchange="content_reflect()">
	        &nbsp;&nbsp;Advance
	    </label>
	    <label for="rd_cms" class="app_dual_button">
	        <input type="radio" id="rd_cms" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;CMS
	    </label>
	</div>   
</div>

<div id="b2b_setting_content"></div>


<script>
function content_reflect()
{
	var base_url= $('#base_url').val();
	var id = $('input[name="rd_app"]:checked').attr('id');
	if(id=="rd_app_basic"){
		$.post('basic_info/index.php', {}, function(data){
			$('#b2b_setting_content').html(data);
		});
	}
	if(id=="rd_cms"){
		$.post('cms/index.php', {}, function(data){
			$('#b2b_setting_content').html(data);
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
<?php } else{ ?>
 <div class="alert alert-danger" role="alert">
   Please upgrade the subscription to use this feature.
 </div>
<?php }?>