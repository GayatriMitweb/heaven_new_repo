<form id="frm_tab3_u">
	
	<div class="row">
		<div class="col-md-12 app_accordion">
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
						    	<?php include_once('train_tbl.php') ?>
						    </div>
					    </div>
					</div>
				</div>

				<!-- Hotel Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
		  				<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="true" aria-controls="collapse_2" id="collapsed_2">                  
					        	<div class="col-md-12"><span>Hotel Information</span></div>
					        </div>
					    </div>
				        <div id="collapse_2" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading_2">
						    <div class="panel-body">
						    	<?php include_once('hotel_tbl.php') ?>	
						    </div>
						</div>
					</div>
				</div>

				<!-- Flight Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
		  				<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="true" aria-controls="collapse_3" id="collapsed_3">                  
					        	<div class="col-md-12"><span>Flight Information</span></div>
					        </div>
					    </div>
				        <div id="collapse_3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading_3">
						    <div class="panel-body">
						    	<?php include_once('plane_tbl.php') ?>	
						    </div>
						</div>
					</div>
				</div>

				<!-- Cruise Information -->
				<div class="accordion_content main_block mg_bt_10">
					<div class="panel panel-default main_block">
		  				<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
					        <div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="true" aria-controls="collapse_4" id="collapsed_4">                  
					        	<div class="col-md-12"><span>Cruise Information</span></div>
					        </div>
					    </div>
				        <div id="collapse_4" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading_4">
						    <div class="panel-body">
						    	<?php include_once('cruise_tbl.php') ?>	
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

	$('#frm_tab3_u').validate({

		rules:{

				 

		},

		submitHandler:function(form,e){


			e.preventDefault();
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

				   var train_arrival_date = row.cells[6].childNodes[0].value;         

				   var train_departure_date = row.cells[5].childNodes[0].value;         	



			       if(row.cells[7] && row.cells[7].childNodes[0]){

			       	var train_id = row.cells[7].childNodes[0].value;

			       }

			       else{

			       	var train_id = "";

			       }      	



			       

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

			      

			    }      

			  }
 

			  var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane_update");
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

			       if(row.cells[10] && row.cells[10].childNodes[0]){
			       	var plane_id = row.cells[10].childNodes[0].value;
			       }
			       else{
			       	var plane_id = "";
			       }     
			    
				if(plane_from_location1=="")

			    {

			          error_msg_alert('Enter from sector in row'+(i+1));
	  				  $('.accordion_content').removeClass("indicator");
	          		  $('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator");

			          return false;

			    }

		       if(plane_to_location1=="")
		       {
		          	  error_msg_alert('Enter to sector in row'+(i+1));
	  				  $('.accordion_content').removeClass("indicator");
	          		  $('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }

					if(dapart1=="")

					{ 

						error_msg_alert("Departure Date time is required in row:"+(i+1));
	  				    $('.accordion_content').removeClass("indicator");
	          		  	$('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator"); 

						 return false;

					}


					if(arraval1=="")

					{ 

						error_msg_alert('Arrival Date time is required in row:'+(i+1));
	  				    $('.accordion_content').removeClass("indicator"); 
	          		  	$('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator");

						 return false;

					}



 

			    }      

			  }

		/* Cruise Info*/
		  var dept_datetime_arr = new Array();
		  var arrival_datetime_arr = new Array();
		  var route_arr = new Array();
		  var cabin_arr = new Array();
		  var sharing_arr = new Array();
		  var c_entry_id_arr= new Array();

		  var table = document.getElementById("tbl_dynamic_cruise_quotation_update");
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

		       if(row.cells[7]){
		       	 var c_entry_id = row.cells[7].childNodes[0].value; 
		       }
		       else{
		       	 var c_entry_id = '';
		       }
		       if(dept_datetime=="")
		       {
		          error_msg_alert('Enter cruise departure datetime in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation_update').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(arrival_datetime=="")
		       {
		          error_msg_alert('Enter cruise arrival datetime  in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation_update').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(route=="")
		       {
		          error_msg_alert('Enter cruise route in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation_update').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		       if(cabin=="")
		       {
		          error_msg_alert('Enter cruise cabin in row'+(i+1));
	  			  $('.accordion_content').removeClass("indicator");
	          	  $('#tbl_dynamic_cruise_quotation_update').parent('div').closest('.accordion_content').addClass("indicator");
		          return false;
		       }
		      		  
		       dept_datetime_arr.push(dept_datetime);
		       arrival_datetime_arr.push(arrival_datetime);
			   route_arr.push(route);
			   cabin_arr.push(cabin);
			   sharing_arr.push(sharing);
			   c_entry_id_arr.push(c_entry_id);
		    }      
		  }

	  $('.accordion_content').removeClass("indicator");

		$('a[href="#tab4_u"]').tab('show');		

		}

	});

});

function switch_to_tab2(){ $('a[href="#tab1_u"]').tab('show'); }

</script>



