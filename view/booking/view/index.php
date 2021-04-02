<?php 

include "../../../model/model.php";



$id = $_POST['id'];

$query = mysql_query("select * from tourwise_traveler_details where id='$id'");

$sq_group_info = mysql_fetch_assoc($query);

$date = $sq_group_info['form_date'];
            $yr = explode("-", $date);
			   $year =$yr[0];
$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from payment_master where tourwise_traveler_id='$sq_group_info[id]'"));
$total_paid = $sq_paid_amount['sum'];  
$credit_card_charges = $sq_paid_amount['sumc'];
?>

<div class="modal fade profile_box_modal" id="group_display_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-body profile_box_padding">

      	

      	<div>

			  <!-- Nav tabs -->

			  <ul class="nav nav-tabs responsive" role="tablist">

			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">General Information</a></li>
				
				<?php
				$sq_train_count = mysql_num_rows(mysql_query("select * from train_master where tourwise_traveler_id='$id'")); 
				$sq_air_count = mysql_num_rows(mysql_query("select * from plane_master where tourwise_traveler_id='$id'"));
				$sq_cruise_count = mysql_num_rows(mysql_query("select * from group_cruise_master where booking_id='$id'"));
				if($sq_train_count!='0' || $sq_air_count != '0' || $sq_cruise_count != '0'){
				?>
			    <li role="presentation"><a href="#travelling_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Travelling Information</a></li>
				<?php } ?>
			    <li role="presentation"><a href="#payment_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Costing Information</a></li>

			    <li role="presentation"><a href="#booking_costing" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Receipt Information</a></li>

			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>

			  </ul>





				  <!-- Tab panes1 -->
				<div class="panel panel-default panel-body fieldset profile_background">
					<div class="tab-content responsive">



					    <!-- *****TAb1 start -->

					    <div role="tabpanel" class="tab-pane active" id="basic_information">

					     <?php include "tab1.php"; ?>

					    </div>

					    <!-- ********Tab1 End******** --> 
		                <div role="tabpanel" class="tab-pane" id="travelling_information">

					     <?php include "tab2.php"; ?>

					    </div>
		                <!-- ***Tab2 Start*** -->

					    <div role="tabpanel" class="tab-pane" id="payment_information">

					       <?php include "tab3.php"; ?>

					    </div>

		                <!-- ***Tab2 End*** -->



		                <div role="tabpanel" class="tab-pane" id="booking_costing">

					       <?php include "tab4.php"; ?>

					    </div>



					</div>
				</div>

				



        	</div>

		</div>

	</div>

</div>

  

</div>

<script>

$('#group_display_modal').modal('show');

$('#group_display_modal').on('shown.bs.modal', function () {

	fakewaffle.responsiveTabs(['xs', 'sm']);

});

</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>