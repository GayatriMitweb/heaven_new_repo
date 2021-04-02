<?php
include "../../../../../model/model.php";
/*======******Header******=======*/
/* require_once('../../../../layouts/admin_header.php');*/
?>
<div class="text-center">
	<label for="rd_sales" class="app_dual_button active mg_bt_10">
        <input type="radio" id="rd_sales" name="rd_master" checked onchange="master_content_reflect()">
        &nbsp;&nbsp;Sales Projection
    </label>  
    <label for="rd_budget" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_budget" name="rd_master" onchange="master_content_reflect()">
        &nbsp;&nbsp;Budgeted Vs. Actuals
    </label>    
    <label for="rd_analysis" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_analysis" name="rd_master" onchange="master_content_reflect()">
        &nbsp;&nbsp;Root Cause Analysis
    </label>
</div>

<div id="div_master_content"></div>

 

<script>
function master_content_reflect()
{
	var id = $('input[name="rd_master"]:checked').attr('id');
	if(id=="rd_sales"){
		$.post('report_reflect/sales_projection/projection/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_budget"){
		$.post('report_reflect/sales_projection/budget/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_analysis"){
		$.post('report_reflect/sales_projection/analysis/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	
}
master_content_reflect();
</script>

<?php
/*======******Footer******=======*/
require_once('../../../../layouts/admin_footer.php'); 
?>