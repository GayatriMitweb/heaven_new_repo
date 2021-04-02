<?php 

include "../../../../model/model.php";
$entry_id = $_POST['entry_id'];
$sq_vendor = mysql_fetch_assoc(mysql_query("select * from  car_rental_tariff_entries where entry_id='$entry_id'"));
?>

<div class="modal fade profile_box_modal" id="car_rental_view_modal" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-body profile_box_padding">

	      		<div>
				  <!-- Nav tabs -->
				  	<ul class="nav nav-tabs" role="tablist">
				    	<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Car Supplier Information</a></li>

				    	<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				  	</ul>

		            <div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
						<!-- Tab panes1 -->
						<div class="tab-content">
						    <!-- *****TAb1 start -->
						    <div role="tabpanel" class="tab-pane active" id="basic_information">
								
								<h3 class="editor_title">Tariff Information</h3>
						     	<div class="panel panel-default panel-body app_panel_style">
						     		<div class="row">
										<div class="col-md-12">
											<div class="profile_box main_block">
								        		<div class="row">
                                                <?php if($sq_vendor['tour_type']=='Local'){?>
	           										

								        				<span class="main_block"> 
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Vehicle Name <em>:</em></label> " .$sq_vendor['vehicle_name']; ?>
								        				</span>

								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Total Hrs <em>:</em></label> " .$sq_vendor['total_hrs']; ?> 
								        				</span>

								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Total Km<em>:</em></label> " .$sq_vendor['total_km']; ?>
								        				</span>

								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Extra Hrs Rate <em>:</em></label> " .$sq_vendor['extra_hrs_rate']; ?>
								        				</span>

								        				<span class="main_block"> 
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Extra Km Rate  <em>:</em></label> " .$sq_vendor['extra_km_rate']; ?>
								        				</span>

								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Rate <em>:</em></label> " .$sq_vendor['rate']; ?> 
								        				</span>

								        			
                                                <?php }else{ ?>
                                                    
								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								        				    <?php echo "<label>Vehicle Name <em>:</em></label> " .$sq_vendor['vehicle_name']; ?>
								        				</span>
                                                        <span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Extra Hrs Rate <em>:</em></label> " .$sq_vendor['extra_hrs_rate']; ?>
								        				</span>

								        				<span class="main_block"> 
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Extra Km Rate  <em>:</em></label> " .$sq_vendor['extra_km_rate']; ?>
								        				</span>
								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Route <em>:</em></label> " .$sq_vendor['route']; ?>
								        				</span>
										        		<span class="main_block">
								        				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> 
								        				    <?php echo "<label>Total Days <em>:</em></label> " .$sq_vendor['total_days']; ?>
								        				</span>
								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Total Max Km <em>:</em></label> " .$sq_vendor['total_max_km']; ?> 
								        				</span>

                                                        <span class="main_block"> 
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Rate  <em>:</em></label> " .$sq_vendor['rate']; ?>
								        				</span>
								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Driver Allowance <em>:</em></label> " .$sq_vendor['driver_allowance']; ?>
								        				</span>
										        		<span class="main_block">
								        				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> 
								        				    <?php echo "<label>Permit Charges <em>:</em></label> " .$sq_vendor['permit_charges']; ?>
								        				</span>
								        				<span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Toll Parking <em>:</em></label> " .$sq_vendor['toll_parking']; ?> 
								        				</span>
                                                        <span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>State Entry Tax <em>:</em></label> " .$sq_vendor['state_entry_pass']; ?> 
								        				</span>
                                                        <span class="main_block">
								        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								        				    <?php echo "<label>Other Charges<em>:</em></label> " .$sq_vendor['other_charges']; ?> 
								        				</span>
                                                
                                                <?php } ?>
									    		</div>
									    	</div>
									    </div>
									</div> 
						     	</div> 
						    </div>
						    <!-- ********Tab1 End******** --> 
						</div>
					</div>
		        </div>
    		</div>
    	</div>
	</div>

</div>



<!-- <script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script> -->

<script>

$('#car_rental_view_modal').modal('show');

</script>  

 

