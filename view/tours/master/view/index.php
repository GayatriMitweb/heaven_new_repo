<?php 

include "../../../../model/model.php";



$tour_id = $_POST['tour_id'];



$query = "select * from tour_master where tour_id='$tour_id'";

?>

<div class="modal fade profile_box_modal" id="display_modal_tour" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document" style="width: 60%">

    <div class="modal-content">

      <div class="modal-body profile_box_padding">

      	

      	<div>

			  <!-- Nav tabs -->

			  <ul class="nav nav-tabs responsive" role="tablist">

			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">General Information</a></li>
				<?php 
				$sq_t_count = mysql_num_rows(mysql_query("Select * from group_train_entries where tour_id = '$tour_id'"));
				$sq_f_count = mysql_num_rows(mysql_query("Select * from group_tour_plane_entries where tour_id = '$tour_id'"));
				$sq_c_count = mysql_num_rows(mysql_query("Select * from group_cruise_entries where tour_id = '$tour_id'"));
				if($sq_t_count != '0' || $sq_f_count != '0' || $sq_c_count != '0'){ ?>
			    <li role="presentation"><a href="#travelling_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Travelling Information</a></li>
			    <?php } ?>
			    <li role="presentation"><a href="#costing_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Costing Information</a></li>

			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>

			  </ul>



			  <!-- Tab panes1 -->

			  <div class="tab-content responsive">


				    <!-- *****TAb1 start -->

				    <div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
				     <div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
				      <?php include "tab1.php"; ?>
					 </div>
				    </div>

				    <!-- ********Tab1 End******** --> 

	                <!-- *****TAb2 start -->

				    <div role="tabpanel" class="tab-pane no-pad-sm" id="travelling_information">
				     <div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
				     <?php include "tab2.php"; ?>
					 </div>
				    </div>

				    <!-- ********Tab2 End******** --> 



				     <!-- *****TAb2 start -->

				    <div role="tabpanel" class="tab-pane no-pad-sm" id="costing_information">
				     <div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
				     <?php include "tab3.php"; ?>
					 </div>
				    </div>

				    <!-- ********Tab2 End******** --> 
			  </div>

        </div>

        

	   </div>

     

      </div>

    </div>

  

</div>

<script>
$('#display_modal_tour').modal('show');
$('#display_modal_tour').on('shown.bs.modal', function () {
	fakewaffle.responsiveTabs(['xs', 'sm']);
});
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>

$('#display_modal_tour').modal('show');

</script>