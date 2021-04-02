<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Vehicle Supplier Information',20) ?>
      <div class="header_bottom">
        <div class="row text-center">
            <label for="rd_car" class="app_dual_button active">
		        <input type="radio" id="rd_car" name="rd_car_tarrif" checked onchange="hotel_tarrif_reflect()">
		        &nbsp;&nbsp;Vehicle
		    </label>    
		    <label for="rd_tarrif" class="app_dual_button">
		        <input type="radio" id="rd_tarrif" name="rd_car_tarrif" onchange="hotel_tarrif_reflect()">
		        &nbsp;&nbsp;Tariff
		    </label>   
        </div>
      </div> 

  <!--=======Header panel end======-->
<!-- <div class="app_panel_content"> -->
<div id="div_hotel_tarrif"></div>
<!-- </div> -->
<?= end_panel() ?>
<script>
function hotel_tarrif_reflect(){
	var id = $('input[name="rd_car_tarrif"]:checked').attr('id');
	if(id=="rd_car"){
		$.post('vendor/index.php', {}, function(data){
			$('#div_hotel_tarrif').html(data);
		});
	}
	if(id=="rd_tarrif"){
		$.post('tariff/index.php', {}, function(data){
			$('#div_hotel_tarrif').html(data);
		});
	}
}
hotel_tarrif_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>