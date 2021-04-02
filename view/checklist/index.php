<!-- <?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');

?>
<?= begin_panel('Tour Task Checklist',44) ?>

<div class="text-center text_left_sm_xs mg_bt_20">
	<label for="rd_entities" class="app_dual_button active mg_bt_10">
        <input type="radio" id="rd_entities" name="rd_checklist" checked >
        &nbsp;&nbsp;Checklist
    </label>    
	<label for="rd_group_tour" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_group_tour" name="rd_checklist" >
        &nbsp;&nbsp;Group Tour
    </label>    
    <label for="rd_package_tour" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_package_tour" name="rd_checklist">
        &nbsp;&nbsp;Package Tour
    </label>
</div>
<div id="div_checklist_content"></div>
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>   
<script>
$('input[name="rd_checklist"]').change(function(){
    checklist_content_reflect();
});
function checklist_content_reflect()
{
	var id = $('input[name="rd_checklist"]:checked').attr('id');
	if(id=="rd_entities"){
		$.post('entities/index.php', {  }, function(data){
			$('#div_checklist_content').html(data);
		});
	}
    if(id=="rd_group_tour"){
        $.post('group_tour/index.php', {  }, function(data){
            $('#div_checklist_content').html(data);
        });
    }
    if(id=="rd_package_tour"){
        $.post('package_tour/index.php', {  }, function(data){
            $('#div_checklist_content').html(data);
        });
    }
}
checklist_content_reflect();
</script>
<script src="js/group_tour_checklist.js"></script>
<script src="js/package_tour_checklist.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?> -->
