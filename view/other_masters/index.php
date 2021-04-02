<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Other Masters',12) ?>
<div class="text-center text_left_sm_xs">
	<label for="rd_city" class="app_dual_button active mg_bt_10">
        <input type="radio" id="rd_city" name="rd_master" checked onchange="master_content_reflect()">
        &nbsp;City
    </label>  
    <label for="rd_state" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_state" name="rd_master" onchange="master_content_reflect()">
        &nbsp;State
    </label>    
    <label for="rd_airport" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_airport" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Airport
    </label>
    <label for="rd_airline" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_airline" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Airline
    </label>
    <label for="rd_references" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_references" name="rd_master" onchange="master_content_reflect()">
        &nbsp;References
    </label>
    <label for="rd_roomc" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_roomc" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Room Category
    </label>
    <label for="rd_roe" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_roe" name="rd_master" onchange="master_content_reflect()">
        &nbsp;ROE
    </label>
    <label for="rd_inclusions" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_inclusions" name="rd_master" onchange="master_content_reflect()">
        &nbsp;INCL/EXCL
    </label>    
    <label for="rd_destination" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_destination" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Destination
    </label>
    <label for="rd_gallery" class="app_dual_button">
        <input type="radio" id="rd_gallery" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Gallery
    </label>
    <label for="rd_itinerary" class="app_dual_button">
        <input type="radio" id="rd_itinerary" name="rd_master" onchange="master_content_reflect()">
        &nbsp;Itinerary
    </label>
</div>

<div id="div_master_content"></div>

<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function master_content_reflect()
{
	var id = $('input[name="rd_master"]:checked').attr('id');
	if(id=="rd_city"){
		$.post('cities/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_state"){
		$.post('states/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_airport"){
		$.post('airports/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_airline"){
		$.post('airlines/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_references"){
		$.post('references/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_roomc"){
		$.post('room_category/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_roe"){
		$.post('roe/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_inclusions"){
		$.post('inclusions/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_destination"){
		$.post('destinations/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_gallery"){
		$.post('gallery/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
	if(id=="rd_itinerary"){
		$.post('itinerary/index.php', {}, function(data){
			$('#div_master_content').html(data);
		});
	}
}
master_content_reflect();
</script>

<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>