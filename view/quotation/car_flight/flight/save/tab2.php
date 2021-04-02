<form id="frm_tab2">
 
	<div class="row">
		<div class="col-md-12 app_accordion">
  			<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">

  				<!-- Flight Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
						<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" id="collapsed1">       
					        	<div class="col-md-12"><span>Flight Information</span></div>
					        </div>
					    </div>
				      	<div id="collapse1" class="panel-collapse collapse in main_block" role="tabpanel" aria-labelledby="heading1">
				        	<div class="panel-body">
				        		<div class="row mg_tp_10 mg_bt_10">

								    <div class="col-xs-12 text-right text_center_xs">

										<button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_flight_quotation_dynamic_plane')"><i class="fa fa-plus"></i></button>
										<button type="button" class="btn btn-pdf btn-sm" onclick="deleteRow('tbl_flight_quotation_dynamic_plane')"><i class="fa fa-trash"></i></button>

								    </div>

								</div>

								<div class="row">

								    <div class="col-xs-12">

								        <div class="table-responsive">

								        <table id="tbl_flight_quotation_dynamic_plane" name="tbl_flight_quotation_dynamic_plane" class="table table-bordered no-marg pd_bt_51">

								            <tr>

								                <td><input class="css-checkbox" id="chk_plan-1" type="checkbox" checked><label class="css-label" for="chk_plan-1"> <label></td>

								                <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>

								                 <td><select id="from_city-1" name="from_city-1" style="width: 150px;" class="app_select2 form-control" title="Select City Name" onchange="airport_reflect(this.id)">
									                <?php get_cities_dropdown(); ?>
									            </select></td>
									            <td><select id="plane_from_location-1" class="app_select2 form-control" title="Sector From" name="plane_from_location-1" style="width: 200px;">
										            <option value="">*Sector From</option>
										        </select></td>
									        	<td><select id="to_city-1" name="to_city-1" style="width: 150px;" class="app_select2 form-control" title="Select City Name" onchange="airport_reflect1(this.id)">
								                <?php get_cities_dropdown(); ?>
								                </select></td>
								                <td><select id="plane_to_location-1" class="app_select2 form-control"  title="Sector To Location" name="plane_to_location-1" style="width: 200px;">
													<option value="">*Sector To</option>
												</select></td>
									            <td><select id="airline_name-1" class="app_select2 form-control"  title="Airline Name" name="airline_name-1" style="width: 200px;" >
									                    <option value="">Airline Name</option>
									                    <?php get_airline_name_dropdown(); ?>
									            </select></td>

									            <td><select name="plane_class-1" id="plane_class-1" title="Class" style="width: 150px;">

									            	<option value="">Class</option>

									            	<option value="Economy">Economy</option>

								                    <option value="Premium Economy">Premium Economy</option>

								                    <option value="Business">Business</option>

								                    <option value="First Class">First Class</option>

									            </select></td>    

									            <td><input type="text" id="txt_dapart-1" name="txt_dapart-1" class="app_datetimepicker" placeholder="Departure Date & Time" title="Departure Date & Time" onchange="get_to_datetime(this.id,'txt_arrval-1')" value="<?= date('d-m-Y H:i:s') ?>" style="width: 139px;" /></td>

									            <td><input type="text" id="txt_arrval-1" name="txt_arrval-1" class="app_datetimepicker" placeholder="Arrival Date & Time" title="Arrival Date & Time" value="<?= date('d-m-Y H:i:s') ?>" style="width: 139px;" /></td>

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



	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

$('#from_city-1,#to_city-1,#plane_from_location-1,#plane_to_location-1,#airline_name-1').select2();
$('#txt_dapart-1,#txt_arrval-1').datetimepicker({format:'d-m-Y H:i:s' });
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

$(function(){

	$('#frm_tab2').validate({

		rules:{ 

		},

		submitHandler:function(form){

		var from_city_id_arr = new Array();
	    var to_city_id_arr = new Array();
		var plane_from_location_arr = new Array();

		var plane_to_location_arr = new Array();

		var airline_name_arr = new Array();

		var plane_class_arr = new Array();

		var arraval_arr = new Array();

		var dapart_arr = new Array();



		var table = document.getElementById("tbl_flight_quotation_dynamic_plane");

		var rowCount = table.rows.length;

		  

		  for(var i=0; i<rowCount; i++)

		  {

		    var row = table.rows[i];

		     

		    if(row.cells[0].childNodes[0].checked)

		    {

		       var from_city_id1 = row.cells[2].childNodes[0].value;
		       var plane_from_location1 = row.cells[3].childNodes[0].value;   
		       var to_city_id1 = row.cells[4].childNodes[0].value;          

		       var plane_to_location1 = row.cells[5].childNodes[0].value;

		       var airline_name = row.cells[6].childNodes[0].value;  

		       var plane_class = row.cells[7].childNodes[0].value; 

		       var dapart1 = row.cells[8].childNodes[0].value;        

		       var arraval1 = row.cells[9].childNodes[0].value;

		       

		       if(from_city_id1=="")

			    {

			          error_msg_alert('Enter plane from city in row'+(i+1));
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

			          return false;

			    }

		       if(plane_from_location1=="")

		       {

		          error_msg_alert('Enter plane from location in row'+(i+1));
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		       }

		       if(to_city_id1=="")

			    {

			          error_msg_alert('Enter plane To city in row'+(i+1));
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

			          return false;

			    }


		       if(plane_to_location1=="")

		       {

		          error_msg_alert('Enter plane to location in row'+(i+1));
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		       }



			  



				if(dapart1=="")

				{ 

					error_msg_alert("Departure Date time is required in row:"+(i+1)); 
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

					return false;

				}

				if(arraval1=="")

				{ 

					error_msg_alert('Arrival Date time is required in row:'+(i+1)); 
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

					return false;

				}
				
			   from_city_id_arr.push(from_city_id1);
			   to_city_id_arr.push(to_city_id1);
		       plane_from_location_arr.push(plane_from_location1);

		       plane_to_location_arr.push(plane_to_location1);

		       airline_name_arr.push(airline_name);

		       plane_class_arr.push(plane_class);

		       arraval_arr.push(arraval1);

		       dapart_arr.push(dapart1);



		    }      

		  }





		flight_quotation_cost_calculate();
		$('.accordion_content').removeClass("indicator");
		$('a[href="#tab3"]').tab('show');		

		}

	});

});

function switch_to_tab2(){ $('a[href="#tab1"]').tab('show'); }

</script>

