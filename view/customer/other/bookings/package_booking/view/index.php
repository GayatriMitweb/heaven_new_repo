<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];

$sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
$date = $sq_package_info['booking_date'];
$yr = explode("-", $date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="package_display_modal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-body profile_box_padding">
		
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#basic_information" aria-controls="basic_information" role="tab" data-toggle="tab" class="tab_name">General</a></li>
					<?php $sq_t_count = mysql_num_rows(mysql_query("select * from package_train_master where booking_id='$booking_id' ")); 
						$sq_f_count = mysql_num_rows(mysql_query("select * from package_plane_master where booking_id='$booking_id' ")); 
						$sq_c_count = mysql_num_rows(mysql_query("select * from package_cruise_master where booking_id='$booking_id' ")); 
						if($sq_t_count != '0' || $sq_f_count != '0' || $sq_c_count != '0'){?> 
						<li role="presentation"><a href="#travelling_information" aria-controls="travelling_information" role="tab" data-toggle="tab" class="tab_name">Travelling Information</a></li>
						<?php } ?>
					<?php 
					$sq_c_hotel = mysql_num_rows(mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'"));
					$sq_c_package = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
					if($sq_c_hotel != '0' || $sq_c_package['transport_bus_id'] !=''){ ?>
					<li role="presentation"><a href="#hotel_transport_information" aria-controls="hotel_transport_information" role="tab" data-toggle="tab" class="tab_name">Hotel & Transport</a></li>
					<?php } ?>
					<li role="presentation"><a href="#booking_costing" aria-controls="booking_costing" role="tab" data-toggle="tab" class="tab_name">Costing Information</a></li>
					<li role="presentation"><a href="#payment_information" aria-controls="payment_information" role="tab" data-toggle="tab" class="tab_name">Receipt Information</a></li>
					<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				</ul>

				<div class="panel panel-default panel-body fieldset profile_background">

						<!-- Tab panes1 -->
					<div class="tab-content">

						<!-- *****TAb1 start -->
						<div role="tabpanel" class="tab-pane active" id="basic_information">
							<?php include "tab1.php"; ?>
						</div>
						<!-- ********Tab1 End******** --> 
						<div role="tabpanel" class="tab-pane" id="travelling_information">
							<?php include "tab2.php"; ?>
						</div>
						<div role="tabpanel" class="tab-pane" id="hotel_transport_information">
							<?php include "tab3.php"; ?>
						</div>
						<!-- ***Tab2 Start*** -->
						<div role="tabpanel" class="tab-pane" id="booking_costing">
							<?php include "tab4.php"; ?>
						</div>
						<!-- ***Tab2 End*** -->
						<div role="tabpanel" class="tab-pane" id="payment_information">
							<?php include "tab5.php"; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#package_display_modal').modal('show');
</script>