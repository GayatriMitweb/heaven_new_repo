<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Quotation Request Information',61) ?>
      <div class="header_bottom">
        <div class="row text-center">
            <label for="rd_request" class="app_dual_button active">
		        <input type="radio" id="rd_request" name="rd_request_reply" checked onchange="tab_reflect()">
		        &nbsp;&nbsp;Supplier Quotation
		    </label>    
		    <label for="rd_reply" class="app_dual_button">
		        <input type="radio" id="rd_reply" name="rd_request_reply" onchange="tab_reflect()">
		        &nbsp;&nbsp;Quotation Amount
		    </label>
		      <label for="rd_best" class="app_dual_button">
		        <input type="radio" id="rd_best" name="rd_request_reply" onchange="tab_reflect()">
		        &nbsp;&nbsp;Best Supplier
		    </label>
        </div>
      </div> 

  <!--=======Header panel end======-->
<div class="app_panel_content">
<div id="div_request_reply"></div>

<?= end_panel() ?>
 <script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	function tab_reflect()
	{
		var id = $('input[name="rd_request_reply"]:checked').attr('id');
		if(id=="rd_request"){
			$.post('request/index.php', {}, function(data){
				$('#div_request_reply').html(data);
			});
		}
		if(id=="rd_reply"){
			$.post('reply/index.php', {}, function(data){
				$('#div_request_reply').html(data);
			});
		}
		if(id=="rd_best"){
			$.post('best_supplier/index.php', {}, function(data){
				$('#div_request_reply').html(data);
			});
		}
	}
	tab_reflect();
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>