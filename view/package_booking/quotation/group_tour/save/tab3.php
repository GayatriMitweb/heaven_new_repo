<form id="frm_tab3">
	

	<div class="row">
		<div class="col-md-12 app_accordion">
			<input type="hidden" value="" id="tour_group_id"/>
  			<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">

  				<!-- Train Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" id="collapsed1">       
					        	<div class="col-md-12"><span>Train Information</span></div>
					        </div>
					    </div>
					      <div id="collapse1" class="panel-collapse collapse in main_block" role="tabpanel" aria-labelledby="heading1">
					          <div class="panel-body">
					            <div class="row mg_tp_10 mg_bt_10">
								    <div class="col-xs-12 text-right text_center_xs">
								        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_train')"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_tour_quotation_dynamic_train')"><i class="fa fa-trash"></i></button>
								    </div>
								</div>
								
					            <div class="row">
									<div class="col-xs-12">
									    <div class="table-responsive">
										    <table id="tbl_package_tour_quotation_dynamic_train" name="tbl_package_tour_quotation_dynamic_train" class="table table-bordered no-marg pd_bt_51">
											<input type="hidden" id="train_dept_date_hidde">
										        <tr>
									                <td><input class="css-checkbox" id="chk_tour_group1" type="checkbox" checked><label class="css-label" for="chk_tour_group1"> <label></td>
									                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
									                <td class="col-md-3"><select id="train_from_location1" onchange="validate_location('train_to_location1','train_from_location1')" class="app_select2 form-control" name="train_from_location1" title="From Location" style="width: 100%;">
											                <option value="">*From</option>
											                <?php 
											                    $sq_city = mysql_query("select * from city_master");
											                    while($row_city = mysql_fetch_assoc($sq_city))
											                    {
											                     ?>
											                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
											                     <?php   
											                    }    
											                ?>

											            </select>

									                </td>
									                <td class="col-md-3"><select id="train_to_location1"  onchange="validate_location('train_from_location1','train_to_location1')" class="app_select2 form-control" title="To Location" name="train_to_location1" style="width: 100%;">
										                <option value="">*To</option>
										                <?php 
										                    $sq_city = mysql_query("select * from city_master");
										                    while($row_city = mysql_fetch_assoc($sq_city))
										                    {
										                     ?>
										                        <option value="<?php echo $row_city['city_name'] ?>"><?php echo $row_city['city_name'] ?></option>
										                     <?php   
										                    }    
										                ?>
										            </select></td>
										            <td class="col-md-2"><select name="train_class" id="train_class1" title="Class">
										            	<option value="">Class</option>
										            	<option value="1A">1A</option>
													    <option value="2A">2A</option>
													    <option value="3A">3A</option>
													    <option value="FC">FC</option>
													    <option value="CC">CC</option>
													    <option value="SL">SL</option>
													    <option value="2S">2S</option>
										            </select></td>
										            <td class="col-md-2"><input type="text" id="train_departure_date" name="train_departure_date" placeholder="Departure Date and time" title="Departure Date and time" class="app_datetimepicker" onchange="get_to_datetime(this.id,'train_arrival_date')" value="<?= date('d-m-Y H:i:s') ?>"></td>
										            <td class="col-md-2"><input type="text" id="train_arrival_date" name="train_arrival_date" placeholder="Arrival Date and time" title="Arrival Date and time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>"></td>
									            </tr>                   
									        </table>
										</div>
									</div>
								</div> 
						    </div>
						</div>
					</div>
				</div>
				
				<div class="accordion_content main_block mg_bt_10">
				  <div class="panel panel-default main_block">
				  	<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
				        <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2" id="collapsed2">                  
				          <div class="col-md-12"><span>Hotel Information</span></div>
				        </div>
				    </div>
				    <div id="collapse2" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading2">
				        <div class="panel-body">
				            <div class="row">
						    <div class="col-xs-12">
						        <div class="table-responsive">
							        <table id="tbl_package_hotel_master" name="tbl_package_hotel_master" class="table table-bordered no-marg pd_bt_51">
									
									<tr>
											<td><input class="css-checkbox" id="chk_dest1" type="checkbox" disabled checked><label class="css-label" for="chk_dest1" checked> <label></td>
											<td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled />
											</td>
											<td><input id="city_name" name="city_name1" class="form-control" style="width:100%" title="City Name" readonly> 
											</td>
											<td><input id="hotel_name" name="hotel_name1" style="width:100%" title="Hotel Name" class="form-control" readonly>
											</td>
											<td><input type="text" id="hotel_type" name="hotel_type1" placeholder="*Hotel Type" class="form-control" title="Hotel Type" readonly></td>
											<td><input type="text" id="hotel_tota_days1"  name="hotel_tota_days1" placeholder="*Total Night" class="form-control" title="Total Night" readonly></td></td>
                						</tr> 
							        </table>
						        </div>
						    </div>
						  </div>
				        </div>
				    </div>
				  </div>
				</div>
				<!-- Flight Information -->
				<div class="accordion_content main_block mg_bt_10">
				  <div class="panel panel-default main_block">
				  	<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
				        <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3" id="collapsed3">                  
				          <div class="col-md-12"><span>Flight Information</span></div>
				        </div>
				    </div>
				    <div id="collapse3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading3">
				        <div class="panel-body">
				          <div class="row mg_tp_10 mg_bt_10">
						    <div class="col-xs-12 text-right text_center_xs">
						        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_package_tour_quotation_dynamic_plane');event_airport('tbl_package_tour_quotation_dynamic_plane')"><i class="fa fa-plus"></i></button>
								<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_package_tour_quotation_dynamic_plane')"><i class="fa fa-trash"></i></button>
						    </div>
						   </div>

				          <div class="row">
						    <div class="col-xs-12">
						        <div class="table-responsive">
							        <table id="tbl_package_tour_quotation_dynamic_plane" name="tbl_package_tour_quotation_dynamic_plane" class="table table-bordered no-marg pd_bt_51">
									<input type="hidden" id="plane_dept_date_hidde">
							            <tr>
							                <td><input class="css-checkbox" id="chk_plan1" checked type="checkbox"><label class="css-label" for="chk_plan1"> <label></td>
							                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
											<td><input type="text" name="from_sector-1" id="from_sector-1" placeholder="From Sector" title="From Sector" style="width: 360px;">
											</td>
											<td><input type="text" name="to_sector-1" id="to_sector-1" placeholder="To Sector" title="To Sector" style="width: 360px;">
											</td>
								            <td><select id="airline_name1" class="app_select2 form-control"  title="Airline Name" name="airline_name1" style="width: 300px;">
								                    <option value="">Airline Name</option>
								                    <?php get_airline_name_dropdown(); ?>
								            </select></td>
								            <td><select name="plane_class" id="plane_class1" title="Class" style="width: 300px;">
								            	<option value="">Class</option>
								            	<option value="Economy">Economy</option>
							                    <option value="Premium Economy">Premium Economy</option>
							                    <option value="Business">Business</option>
							                    <option value="First Class">First Class</option>
								            </select></td>	            
								            <td><input type="text" id="txt_dapart1" name="txt_dapart" class="app_datetimepicker" placeholder="Departure Date and time" title="Departure Date and time" onchange="get_to_datetime(this.id,'txt_arrval1')" value="<?= date('d-m-Y H:i:s') ?>" style="width: 160px;" /></td>
								            <td><input type="text" id="txt_arrval1" name="txt_arrval" class="app_datetimepicker" placeholder="Arrival Date and time" title="Arrival Date and time" style="width: 160px;" value="<?= date('d-m-Y H:i:s') ?>"/></td>
											<td><input type="hidden" id="from_city-1"></td>								
											<td><input type="hidden" id="to_city-1"></td>
							            </tr>
							        </table>
						        </div>
						    </div>
						  </div>
				        </div>
				    </div>
				  </div>
				</div>

				<!-- Cruise Information -->
				<div class="accordion_content main_block">
				  <div class="panel panel-default main_block">
				  	<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
				        <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4" id="collapsed4">                  
				          <div class="col-md-12"><span>Cruise Information</span></div>
				        </div>
				    </div>
				    <div id="collapse3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading4">
				        <div class="panel-body">
				            <div class="row mg_bt_10">
							    <div class="col-md-12 text-right text_center_xs">
							        <button type="button" class="btn btn-excel btn-sm" onClick="addRow('tbl_dynamic_cruise_quotation')"><i class="fa fa-plus"></i></button>
									<button type="button" class="btn btn-pdf btn-sm" onClick="deleteRow('tbl_dynamic_cruise_quotation')"><i class="fa fa-trash"></i></button>
							    </div>
							</div>
					          <div class="row">
							    <div class="col-md-12">
							        <div class="table-responsive">
								        <table id="tbl_dynamic_cruise_quotation" name="tbl_dynamic_cruise_quotation" class="table table-bordered no-marg">
										<input type="hidden" id="cruise_dept_date_hidde">
								            <tr>
								                <td><input class="css-checkbox" id="chk_cruise1" type="checkbox" checked><label class="css-label" for="chk_cruise1"><label></td>
								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
									            <td><input type="text" id="cruise_departure_date" name="cruise_departure_date" placeholder="Departure Date and Time" title="Departure Date and Time" onchange="get_to_datetime(this.id,'cruise_arrival_date')" class="app_datetimepicker" onchange="get_to_datetime(this.id,'cruise_arrival_date')" value="<?= date('d-m-Y H:i:s') ?>"></td>
									            <td><input type="text" id="cruise_arrival_date" name="cruise_arrival_date" placeholder="Arrival Date and Time" title="Arrival Date and Time" class="app_datetimepicker" value="<?= date('d-m-Y H:i:s') ?>"></td>
									            <td><input type="text" id="route" name="route" onchange="validate_spaces(this.id)" placeholder="Route" title="Route"></td>
									            <td><input type="text" id="cabin" name="cabin" onchange="validate_spaces(this.id)" placeholder="Cabin" title="Cabin"></td>
									            <td><select id="sharing" name="sharing" style="width:100%;" title="Sharing">
									            		<option value="">Sharing</option>
									            		<option value="Single">Single</option>
									            		<option value="Double">Double</option>
									            		<option value="Triple Quad">Triple Quad</option>
									                </select></td>
								            </tr>                                
								        </table>
							        </div>
							    </div>
							</div>
				        </div>
				    </div>
				  </div>
				</div>
  			</div>
  		</div>
  	</div>
			
			
	<div class="row text-center mg_tp_20">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>

</form>



<script>

$('#plane_from_location1,#plane_to_location1,#train_from_location1,#train_to_location1').select2();
event_airport('tbl_package_tour_quotation_dynamic_plane');
// App_accordion
jQuery(document).ready(function() {			
			jQuery(".panel-heading").click(function(){ 
				jQuery('#accordion .panel-heading').not(this).removeClass('isOpen');
				jQuery(this).toggleClass('isOpen');
				jQuery(this).next(".panel-collapse").addClass('thePanel');
				jQuery('#accordion .panel-collapse').not('.thePanel').slideUp("slow"); 
		    	jQuery(".thePanel").slideToggle("slow").removeClass('thePanel'); 
			});
			
		});

$(function(){

	$('#frm_tab3').validate({

		rules:{ 

		},

		submitHandler:function(form,e){
			e.preventDefault();
		

		var train_from_location_arr = new Array();

		var train_to_location_arr = new Array();

		var train_class_arr = new Array();

		var train_arrival_date_arr = new Array();

		var train_departure_date_arr = new Array();




		//Train Info
		var table = document.getElementById("tbl_package_tour_quotation_dynamic_train");

		  var rowCount = table.rows.length;

		  

		  for(var i=0; i<rowCount; i++)

		  {

		    var row = table.rows[i];

		     

		    if(row.cells[0].childNodes[0].checked)

		    {

		       var train_from_location1 = row.cells[2].childNodes[0].value;         

		       var train_to_location1 = row.cells[3].childNodes[0].value;         

			   var train_class = row.cells[4].childNodes[0].value;         

			   var train_arrival_date = row.cells[5].childNodes[0].value;         

			   var train_departure_date = row.cells[6].childNodes[0].value;         



		       

		       if(train_from_location1=="")

		       {

		          error_msg_alert('Enter train from location in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		       }



		       if(train_to_location1=="")

		       {

		          error_msg_alert('Enter train to location in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_train').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		       }

		      

		   

		       train_from_location_arr.push(train_from_location1);

		       train_to_location_arr.push(train_to_location1);

			   train_class_arr.push(train_class);

			   train_arrival_date_arr.push(train_arrival_date);

			   train_departure_date_arr.push(train_departure_date);



		    }      

		  }


		//Flight Info
		var from_city_id_arr = new Array();
		var plane_from_location_arr = new Array();
		var to_city_id_arr = new Array();
		var plane_to_location_arr = new Array();
		var airline_name_arr = new Array();

		var plane_class_arr = new Array();

		var arraval_arr = new Array();

		var dapart_arr = new Array();



		var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane");

		  var rowCount = table.rows.length;

		  

		  for(var i=0; i<rowCount; i++)

		  {

		    var row = table.rows[i];

		     

		    if(row.cells[0].childNodes[0].checked)

		    {
		       
		       var plane_from_location1 = row.cells[2].childNodes[0].value;          
		       var plane_to_location1 = row.cells[3].childNodes[0].value;
		       var airline_name = row.cells[4].childNodes[0].value;  
		       var plane_class = row.cells[5].childNodes[0].value;  
		       var dapart1 = row.cells[6].childNodes[0].value;       
		       var arraval1 = row.cells[7].childNodes[0].value;
			   var from_city_id1 = row.cells[8].childNodes[0].value;
		       var to_city_id1 = row.cells[9].childNodes[0].value; 

		    if(plane_from_location1=="")

		    {

		          error_msg_alert('Enter from sector in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		    }

	       if(plane_to_location1=="")

	       {

	          error_msg_alert('Enter to sector in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

	          return false;

	       }


				if(dapart1=="")

				{ 

				error_msg_alert("Departure Date time is required in row:"+(i+1)); 
	  			  $('.accordion_content').removeClass("indicator");
	          	$('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

				return false;

				}


				if(arraval1=="")

				{ 

					error_msg_alert('Arrival Date time is required in row:'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_package_tour_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator"); 

					return false;

				}

		       plane_from_location_arr.push(plane_from_location1);

		       plane_to_location_arr.push(plane_to_location1);

		       airline_name_arr.push(airline_name);

		       plane_class_arr.push(plane_class);

		       arraval_arr.push(arraval1);

		       dapart_arr.push(dapart1);



		    }      

		  }

		  /* Cruise Info*/
		  var dept_datetime_arr = new Array();
		  var arrival_datetime_arr = new Array();
		  var route_arr = new Array();
		  var cabin_arr = new Array();
		  var sharing_arr = new Array();

		  var table = document.getElementById("tbl_dynamic_cruise_quotation");
		  var rowCount = table.rows.length;
		  
		  for(var i=0; i<rowCount; i++)
		  {
		    var row = table.rows[i];
		    
		    if(row.cells[0].childNodes[0].checked)
		    {
		       var dept_datetime = row.cells[2].childNodes[0].value;         
		       var arrival_datetime = row.cells[3].childNodes[0].value;         
			   var route = row.cells[4].childNodes[0].value;         
			   var cabin = row.cells[5].childNodes[0].value;         
			   var sharing = row.cells[6].childNodes[0].value;         
		       
		       if(dept_datetime=="")
		       {
		          error_msg_alert('Enter cruise departure datetime in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(arrival_datetime=="")
		       {
		          error_msg_alert('Enter cruise arrival datetime  in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(route=="")
		       {
		          error_msg_alert('Enter cruise route in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(cabin=="")
		       {
		          error_msg_alert('Enter cruise cabin in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		      		  
		       dept_datetime_arr.push(dept_datetime);
		       arrival_datetime_arr.push(arrival_datetime);
			   route_arr.push(route);
			   cabin_arr.push(cabin);
			   sharing_arr.push(sharing);
		    }      
		  }

		group_quotation_cost_calculate('');


	  $('.accordion_content').removeClass("indicator");


		$('a[href="#tab4"]').tab('show');		
		}
	});

});

function switch_to_tab2(){ $('a[href="#tab2"]').tab('show'); }

</script>

