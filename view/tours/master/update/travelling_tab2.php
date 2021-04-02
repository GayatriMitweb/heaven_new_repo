<form id="frm_tab2">
<div class="app_panel">
<!--=======Header panel======-->
	<div class="app_panel_head mg_bt_20">
		<div class="container">
			<h2 class="pull-left"></h2>
			<div class="pull-right header_btn">
			<button>
				<a>
					<i class="fa fa-arrow-right"></i>
				</a>
			</button>
			</div>
		</div>
	</div> 
    <div class="container">
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
									<?php include_once('train_tbl.php'); ?>	
								</div>
							</div>
						</div>
					</div>
					<!-- Hotel Information -->
					<div class="accordion_content main_block mg_bt_10">
						<div class="panel panel-default main_block">
							<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
								<div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2" id="collapsed2">                  
									<div class="col-md-12"><span>Hotel Information</span></div>
								</div>
							</div>
							<div id="collapse2" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading2">
								<div class="panel-body">
									<?php include_once('hotel_tbl.php'); ?>	
								</div>
							</div>
						</div>
					</div>
					<!-- Flight Information -->
					<div class="accordion_content main_block mg_bt_10">
						<div class="panel panel-default main_block">
							<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
								<div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3" id="collapsed3">                  
									<div class="col-md-12"><span>Flight Information</span></div>
								</div>
							</div>
							<div id="collapse3" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading3">
								<div class="panel-body">
									<?php include_once('plane_tbl.php'); ?>	
								</div>
							</div>
						</div>
					</div>

					<!-- Cruise Information -->
					<div class="accordion_content main_block mg_bt_10">
						<div class="panel panel-default main_block">
							<div class="panel-heading main_block" role="tab" id="heading_<?= $count ?>">
								<div class="Normal main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4" id="collapsed4">                  
									<div class="col-md-12"><span>Cruise Information</span></div>
								</div>
							</div>
							<div id="collapse4" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading4">
								<div class="panel-body">
									<?php include_once('cruise_tbl.php'); ?>	
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>	
		<div class="row text-center mg_tp_20">
			<div class="col-md-12">
				<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
				&nbsp;&nbsp;
				<button class="btn btn-sm btn-info ico_right" id="btn_quotation_update">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
		</div>
	</div>
</div>
</form>
<script> 
function switch_to_tab1(){
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
</script>
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
		
$('#frm_tab2').validate({
	rules:{
		
	},
	submitHandler:function(form){	
    //Train Information
	var train_from_location_arr = new Array();
		var train_to_location_arr = new Array();
		var train_class_arr = new Array();
		var train_id_arr = new Array();

			var table = document.getElementById("tbl_group_tour_save_dynamic_train_update");
		  	var rowCount = table.rows.length;
			  
			  for(var i=0; i<rowCount; i++)
			  {
			    var row = table.rows[i];
			     
			    if(row.cells[0].childNodes[0].checked)
			    {
			       var train_from_location1 = row.cells[2].childNodes[0].value;         
			       var train_to_location1 = row.cells[3].childNodes[0].value;   
			       var train_class = row.cells[4].childNodes[0].value;          
     
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
			       if(row.cells[5] && row.cells[5].childNodes[0]){
			       	var train_id = row.cells[5].childNodes[0].value;
			       }
			       else{
			       	var train_id = "";
			       }    
			       train_from_location_arr.push(train_from_location1);
			       train_to_location_arr.push(train_to_location1);
			       train_class_arr.push(train_class);
			       train_id_arr.push(train_id); 
			    }      
			  }
		//Plane Information  	
		var from_city_id_arr = new Array();
	    var to_city_id_arr = new Array();
		var plane_from_location_arr = new Array();
		var plane_to_location_arr = new Array();
		var airline_name_arr = new Array();
		var plane_class_arr = new Array();
		var plane_id_arr = new Array();

		var table = document.getElementById("tbl_group_tour_quotation_dynamic_plane_update");
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
			   var from_city_id1 = row.cells[6].childNodes[0].value;
			   var to_city_id1 = row.cells[7].childNodes[0].value; 
		

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
		       if(airline_name=="")
				{ 
					error_msg_alert('Airline Name is required in row:'+(i+1)); 
			  		  $('.accordion_content').removeClass("indicator");
	          		$('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator");
					return false;
				}
		       if(plane_class=="")
		       	{ 
		       		error_msg_alert("Class is required in row:"+(i+1)); 
			  		  $('.accordion_content').removeClass("indicator");
	          		$('#tbl_package_tour_quotation_dynamic_plane_update').parent('div').closest('.accordion_content').addClass("indicator");
		       		 return false;
		   		}
		       if(row.cells[8] && row.cells[8].childNodes[0]){
		       	var plane_id = row.cells[8].childNodes[0].value;
		       }
		       else{
		       	var plane_id = "";
		       }
		            
		       from_city_id_arr.push(from_city_id1);
			   to_city_id_arr.push(to_city_id1);
		       plane_from_location_arr.push(plane_from_location1);
		       plane_to_location_arr.push(plane_to_location1);
		       airline_name_arr.push(airline_name);
		       plane_class_arr.push(plane_class);
		       plane_id_arr.push(plane_id);
		    }      
		  }

		  //Cruise Information
		    var route_arr = new Array();
		    var cabin_arr = new Array();
		    var c_entry_id_arr = new Array();

		    var table = document.getElementById("tbl_dynamic_cruise_update");
		    var rowCount = table.rows.length;

		      for(var i=0; i<rowCount; i++)
		      {
		        var row = table.rows[i];   
		        if(row.cells[0].childNodes[0].checked)
		        { 
		           var route = row.cells[2].childNodes[0].value;    
		           var cabin = row.cells[3].childNodes[0].value;   
		           if(row.cells[4]){
		           	var entry_id = row.cells[4].childNodes[0].value;        
		           }
		           else{ 
		           	var entry_id = '';
		           }		                
		           if(route=="")
		           {
		              error_msg_alert('Enter route in row'+(i+1));
			  		  $('.accordion_content').removeClass("indicator");
	          		  $('#tbl_dynamic_cruise_update').parent('div').closest('.accordion_content').addClass("indicator");
		              return false;
		           }          
		           route_arr.push(route);
		           cabin_arr.push(cabin);
		           c_entry_id_arr.push(entry_id);

		        }      
		      }
		$('.accordion_content').removeClass("indicator");
		$('.collapse').removeClass("in");
		$('#collapse1').addClass("in");
    	$('#tab2_head').addClass('done');
        $('#tab3_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab3').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}  

});
</script>