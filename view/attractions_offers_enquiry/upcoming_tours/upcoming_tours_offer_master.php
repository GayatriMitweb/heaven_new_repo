<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
require_once('../../../classes/tour_booked_seats.php');

include_once('upcoming_tours_offer_save_modal.php');
?>

<?= begin_panel('Upcoming Offers',102) ?>

	<div class="row text-right">
		<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#upcoming_tours_save_modal"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New Upcoming Offer</button>
		</div>
	</div>	


	<div id="upcoming_tour_offsers_list_content"></div>

<?= end_panel() ?>


<!--Update Modal Div-->
<div id="div_upcoming_tours_update_modal"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script src="../js/upcoming_tours.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>