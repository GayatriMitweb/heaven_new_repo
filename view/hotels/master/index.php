<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Hotel Supplier Information',20) ?>
      <div class="header_bottom">
        <div class="row text-center">
            <label for="rd_hotel" class="app_dual_button active" data-id="1">
		        <input type="radio" id="rd_hotel" name="rd_hotel_tarrif" checked onchange="hotel_tarrif_reflect()">
		        &nbsp;&nbsp;Hotel
		    </label>   
		    <label for="rd_tarrifb2b" class="app_dual_button" data-id="3">
		        <input type="radio" id="rd_tarrifb2b" name="rd_hotel_tarrif" onchange="hotel_tarrif_reflect()">
		        &nbsp;&nbsp;Tariff
		    </label>
        </div>
      </div> 

  <!--=======Header panel end======-->
<div id="div_hotel_tarrif"></div>
<?= end_panel() ?>
<script>
function hotel_tarrif_reflect(){
	const urlParams = new URLSearchParams(window.location.search);
	const myParam = urlParams.get('activeid');
 
	if(myParam){
		const tab_index = $('.app_dual_button').each(function() {
			if($(this).data('id') === parseInt(myParam)){
				$(this).addClass('active').siblings().removeClass('active');
				$(this).find('input').attr('checked',true)
			}
		});
	}
	var id = $('input[name="rd_hotel_tarrif"]:checked').attr('id');
	if(id=="rd_hotel"){
		$.post('hotel/index.php', {}, function(data){
			$('#div_hotel_tarrif').html(data);
		});
	}
	if(id=="rd_tarrifb2b"){
		$.post('b2b_tarrif/index.php', {}, function(data){
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