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

										<button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_flight_quotation_dynamic_plane');event_airport('tbl_flight_quotation_dynamic_plane');"><i class="fa fa-plus"></i></button>
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
												
												<td><input type="text" name="from_sector" id="from_sector-1" placeholder="*From Sector" title="*From Sector" style="width: 350px;">
												</td>

												<td><input type="text" name="to_sector" id="to_sector-1" placeholder="*To Sector" title="*To Sector" style="width: 350px;">
												</td>
								                 
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
												<td><input type="text" id="adult-1" name="adult-1" placeholder="Total Adult(s)" title="Total Adult(s)" onchange="" style="width: 139px;" /></td>
												<td><input type="text" id="child-1" name="child-1"  placeholder="Total Child(ren)" title="Total Child(ren)"   style="width: 139px;" /></td>
												<td><input type="text" id="infant-1" name="infant-1"  placeholder="Total Infant(s)" title="Total Infant(s)" style="width: 139px;" /></td> 

									            <td><input type="text" id="txt_dapart-1" name="txt_dapart-1" class="app_datetimepicker" placeholder="*Departure Date & Time" title="Departure Date & Time" onchange="get_to_datetime(this.id,'txt_arrval-1')" value="<?= date('d-m-Y H:i:s') ?>" style="width: 139px;" /></td>

									            <td><input type="text" id="txt_arrval-1" name="txt_arrval-1" class="app_datetimepicker" placeholder="*Arrival Date & Time" onchange="validate_validDatetime('txt_dapart-1','txt_arrval-1')" title="Arrival Date & Time" value="<?= date('d-m-Y H:i:s') ?>" style="width: 139px;" /></td>
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
			</div>
		</div>
	</div>



	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right" onclick="get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','true','service_charge', true);">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

$('#plane_from_location-1,#plane_to_location-1,#airline_name-1').select2();
$('#txt_dapart-1,#txt_arrval-1').datetimepicker({format:'d-m-Y H:i:s' });
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

$(function(){

	$('#frm_tab2').validate({

		rules:{ 

		},

		submitHandler:function(form,e){
		e.preventDefault();
		var from_city_id_arr = new Array();
	    var to_city_id_arr = new Array();
		var from_sector_arr = new Array();

		var to_sector_arr = new Array();

		var airline_name_arr = new Array();

		var plane_class_arr = new Array();

		var arraval_arr = new Array();

		var dapart_arr = new Array();
		var total_adult_arr = new Array();
		var total_child_arr = new Array();
		var total_infant_arr = new Array();



		var table = document.getElementById("tbl_flight_quotation_dynamic_plane");

		var rowCount = table.rows.length;
		var selectedCount = 0;
		  

		  for(var i=0; i<rowCount; i++)

		  {

		    var row = table.rows[i];

		     

		    if(row.cells[0].childNodes[0].checked)

		    {

				
			   var from_sector = row.cells[2].childNodes[0].value;   
		       var to_sector = row.cells[3].childNodes[0].value;
		       var airline_name = row.cells[4].childNodes[0].value;  
			   var plane_class = row.cells[5].childNodes[0].value;  
			   var total_adult = row.cells[6].childNodes[0].value;
			   var total_child = row.cells[7].childNodes[0].value;
			   var total_infant = row.cells[8].childNodes[0].value;       
		       var arraval1 = row.cells[9].childNodes[0].value;
			   var dapart1 = row.cells[10].childNodes[0].value;
			   var from_city_id1 = row.cells[11].childNodes[0].value;
			   var to_city_id1 = row.cells[12].childNodes[0].value; 
			   selectedCount++;

		       if(from_sector=="")

		       {

		          error_msg_alert('Enter Departure Sector in row'+(i+1));
					  $('.accordion_content').removeClass("indicator");
	          	  	  $('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");

		          return false;

		       }


		       if(to_sector=="")

		       {

		          error_msg_alert('Enter Arrival Sector in row'+(i+1));
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
		       from_sector_arr.push(from_sector);

		       to_sector_arr.push(to_sector);

		       airline_name_arr.push(airline_name);
			   total_adult_arr.push(total_adult);
			   total_child_arr.push(total_child);
			   total_infant_arr.push(total_infant);
		       plane_class_arr.push(plane_class);

		       arraval_arr.push(arraval1);

		       dapart_arr.push(dapart1);



		    }      

		  }

		  if(!selectedCount){
			error_msg_alert("Please select atleast one flight entry"); 
			$('.accordion_content').removeClass("indicator");
			$('#tbl_flight_quotation_dynamic_plane').parent('div').closest('.accordion_content').addClass("indicator");
			return false;
		  }



		flight_quotation_cost_calculate();
		$('.accordion_content').removeClass("indicator");
		$('a[href="#tab3"]').tab('show');		

		}

	});

});
// function event_airport(){ //driver function
// 	var table1 = document.getElementById('tbl_flight_quotation_dynamic_plane');
// 	var rows = table1.rows;
// 	var rows =  rows[rows.length-1].cells[2].childNodes[0].getAttribute('id').split('-')[1];
// 	for(var i=0; i <= parseInt(rows); i++){
// 		id1 = 'from_sector-'+ (i);
// 		id2 = 'to_sector-' + (i);
// 		ids = [{"dep" : id1}, {"arr" : id2}];
// 		try{
// 			airport_load_main(ids);
// 		}
// 		catch(e){
// 			continue; //breaking loop if not try catch not used
// 		}
// 	}
// }
function airport_load_main(ids){
	ids.forEach(function (id){
		var object_id = Object.values(id)[0];
		$("#"+object_id).autocomplete({
			source: function(request, response){
				$.ajax({
					method:'get',
					url : '../../../../visa_passport_ticket/ticket/home/airport_list.php',
					dataType : 'json',
					data : {request : request.term},
					success : function(data){
						response(data);
					}
				});
			},
			select: function (event, ui) {
				// var substr_id =  object_id.substr(6);
				var substr_id =  object_id.split('-')[1];
				if(Object.keys(id)[0] == 'dep'){
					$('#from_city-'+substr_id).val(ui.item.city_id);
				}
				else{
					$('#to_city-'+substr_id).val(ui.item.city_id);
				}
			},
			open: function(event, ui) {
				$(this).autocomplete("widget").css({
					"width": document.getElementById(object_id).offsetWidth
				});
			},
			change: function(event,ui){
				var substr_id =  object_id.substr(6);
				if(!ui.item) {
					$(this).val('');
					$('#from_city-'+substr_id).val("");
					$('#to_city-'+substr_id).val("");
					error_msg_alert('Please select Airport from the list!!');
					$(this).css('border','1px solid red;');
					return;
				}
				if($('#'+ids[0].dep).val() == $("#"+ids[1].arr).val()){
					$(this).val('');
					$('#from_city-'+substr_id).val("");
					$('#to_city-'+substr_id).val("");
					$(this).css('border','1px solid red;');
					error_msg_alert('Same Arrival and Boarding Airport Not Allowed!!');
				}

			}
		}).data("ui-autocomplete")._renderItem = function(ul, item) {
				return $("<li disabled>")
				.append("<a>" + item.value.split(" -")[1] + "<br><b>" + item.value.split(" -")[0] + "<b></a>")
				.appendTo(ul);
			}
	});
}
function switch_to_tab2(){ $('a[href="#tab1"]').tab('show'); }

</script>

