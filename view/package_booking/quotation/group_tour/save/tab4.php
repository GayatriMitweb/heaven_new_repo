<form id="frm_tab4">

<div class="row mg_bt_10">

	<div class="col-md-2">
	<small>&nbsp;</small>
  		<input type="text" id="adult_cost" name="adult_cost" placeholder="Adult Cost" title="Adult Cost" onchange="group_quotation_cost_calculate(this.id);validate_balance(this.id)" value="0" >  

  		<input type="hidden" id="total_adult1" name="total_adult1" value="0">  

  	</div>
	<div class="col-md-2">
	<small>&nbsp;</small>
		<input type="text" id="with_bed_cost" name="with_bed_cost" placeholder="Child With Bed Cost" title="Child With Bed Cost" value="0" onchange="group_quotation_cost_calculate(this.id);validate_balance(this.id);"> 

	</div>
  	<div class="col-md-2">
	  <small>&nbsp;</small>
  		<input type="text" id="children_cost" name="children_cost" placeholder="Child Without Bed Cost" title="Child Without Bed Cost" value="0" onchange="group_quotation_cost_calculate(this.id); validate_balance(this.id);"> 

  		<input type="hidden" id="total_child1" name="total_child1" value="0">  

	</div>
	

	<div class="col-md-2"> 
	<small>&nbsp;</small>
	 	<input type="text" id="infant_cost" name="infant_cost" placeholder="Infant Cost" title="Infant Cost" value="0" onchange="group_quotation_cost_calculate(this.id);validate_balance(this.id);">  

	 	<input type="hidden" id="total_infant1" name="total_infant1" value="0">  

	</div>

    

	<div class="col-md-2">
	    <small id="basic_show" style="color:#000000">&nbsp;</small>
	    <input type="text" id="tour_cost" name="tour_cost" placeholder="Total Tour Cost" title="Total Tour Cost" value="0" onchange="get_auto_values('quotation_date','tour_cost','payment_mode','service_charge','markup','save','true','basic','basic');group_quotation_cost_calculate(this.id);validate_balance(this.id);" readonly>

	</div>
 </div>

 <div class="row mg_bt_10">
	<div class="col-md-2">
        <small id="service_show" style="color:#000000">&nbsp;</small> 
   		<input type="text" id="service_charge" name="service_charge" onchange="group_quotation_cost_calculate(this.id); validate_balance(this.id)"  placeholder="Service charge " title="Service charge ">

	</div>

	<input type="hidden" id="service_tax" name="service_tax" value="0">

	<div class="col-md-2">
	<small>&nbsp;</small>
		<input type="text" id="service_tax_subtotal" name="service_tax_subtotal" readonly placeholder="Tax Amount" title="Tax Amount" onchange="validate_balance(this.id)">

	</div>

	<div class="col-md-2">
	<small>&nbsp;</small>
		<input type="text" id="total_tour_cost" class="amount_feild_highlight text-right" name="total_tour_cost" placeholder="Quotation Cost" title="Quotation Cost" value="0"  readonly>

	</div>

 </div>
	<div class="row mg_tp_20">

		<div class="col-sm-6 col-xs-12 mg_bt_10">
		<h3 class="editor_title">Inclusions</h3>
		 	<TEXTAREA class="feature_editor"  id="incl" name="incl" placeholder="Inclusions" rows="3"></TEXTAREA> 
		</div>

		<div class="col-sm-6 mg_bt_10">
		<h3 class="editor_title">Exclusions</h3>
		 	<TEXTAREA class="feature_editor"  id="excl" name="excl" placeholder="Exclusions" rows="3"></TEXTAREA> 
		</div>
		<?php
		$sq_terms = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Group Quotation' and active_flag='Active'"));
		?>
		<div class="col-sm-4 mg_bt_10 hidden">
		<h3 class="editor_title">Terms & Conditions</h3>
		 	<TEXTAREA class="feature_editor"  id="terms" name="terms" placeholder="Terms & Conditions" rows="3"><?= $sq_terms['terms_and_conditions'] ?></TEXTAREA> 
		</div>
	</div>

	<div class="row mg_tp_20 text-center">

		<div class="col-md-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
			&nbsp;&nbsp;
			<button class="btn btn-sm btn-success" id="btn_quotation_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

		</div>

	</div>

</form>



<script>
$(document).ready(function(){
  $('#terms, #incl').wysiwyg({
    controls:"bold,italic,|,undo,redo,image",
    initialContent: '',
  });
});

function switch_to_tab3(){ $('a[href="#tab3"]').tab('show'); }

$('#frm_tab4').validate({

	rules:{

	},

	submitHandler:function(form){
		var enquiry_id = $("#enquiry_id").val();

		var login_id = $("#login_id").val();

		var emp_id = $("#emp_id").val();

		var tour_group_id = $("#tour_group_id").val();

		var tour_name = $('#tour_name').val();

		var tour_group = $('#cmb_tour_group').val();

		var from_date = $('#from_date').val();

		var to_date = $('#to_date').val();

		var total_days = $('#total_days').val();

		var customer_name = $('#customer_name').val();

		var email_id = $('#email_id').val();

		var total_adult = $('#total_adult').val();

		var total_children = parseFloat($('#children_without_bed').val())+parseFloat($('#children_with_bed').val());

		var total_infant = $('#total_infant').val();

		var total_passangers = $('#total_passangers').val();

		var children_without_bed = $('#children_without_bed').val();

		var children_with_bed = $('#children_with_bed').val();		

		var quotation_date = $('#quotation_date').val();

		var booking_type = $('#booking_type').val();

		var adult_cost = $('#adult_cost').val();

		var children_cost = $('#children_cost').val();

		var infant_cost = $('#infant_cost').val();

		var with_bed_cost = $('#with_bed_cost').val();

		var tour_cost = $('#tour_cost').val();

		var markup_cost = $('#markup_cost').val();

		var service_charge = $('#service_charge').val();

		var service_tax = $('#service_tax').val();

		var taxation_id = $('#taxation_id').val();
		
		var branch_admin_id = $('#branch_admin_id1').val();
		var financial_year_id = $('#financial_year_id').val();

		var service_tax_subtotal = $('#service_tax_subtotal').val();

		var total_tour_cost = $('#total_tour_cost').val();
		var iframe = document.getElementById("incl-wysiwyg-iframe");
		var incl = iframe.contentWindow.document.body.innerHTML;
		var iframe1 = document.getElementById("excl-wysiwyg-iframe");
		var excl = iframe1.contentWindow.document.body.innerHTML;
		//var incl = $('#incl').val();
		//var excl = $('#excl').val();
		var terms = $('#terms').val();

		 if(parseFloat(taxation_id) == "0"){ error_msg_alert("Please select Tax Percentage"); return false; } 

		//Train Information

 		var train_from_location_arr = new Array();

		var train_to_location_arr = new Array();

		var train_class_arr = new Array();

		var train_arrival_date_arr = new Array();

		var train_departure_date_arr = new Array();





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



		       

		       if(train_from_location1=="")

		       {

		          error_msg_alert('Enter train from location in row'+(i+1));

		          return false;

		       }



		       if(train_to_location1=="")

		       {

		          error_msg_alert('Enter train to location in row'+(i+1));

		          return false;

		       }

		      

		   

		       train_from_location_arr.push(train_from_location1);

		       train_to_location_arr.push(train_to_location1);

			   train_class_arr.push(train_class);

			   train_arrival_date_arr.push(train_arrival_date);

			   train_departure_date_arr.push(train_departure_date);



		    }      

		  }



		//Plane Information  

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

		          return false;

		       }



		       if(plane_to_location1=="")

		       {

		          error_msg_alert('Enter to sector in row'+(i+1));

		          return false;

		       }

		       



				if(arraval1=="")

				{ 

					error_msg_alert('Arraval Date time is required in row:'+(i+1)); 

					return false;

				}

				if(dapart1=="")

				{ 

					error_msg_alert("Daparture Date time is required in row:"+(i+1)); 

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
		          return false;
		       }
		       if(arrival_datetime=="")
		       {
		          error_msg_alert('Enter cruise arrival datetime  in row'+(i+1));
		          return false;
		       }
		       if(route=="")
		       {
		          error_msg_alert('Enter cruise route in row'+(i+1));
		          return false;
		       }
		       if(cabin=="")
		       {
		          error_msg_alert('Enter cruise cabin in row'+(i+1));
		          return false;
		       }
		      		  
		       dept_datetime_arr.push(dept_datetime);
		       arrival_datetime_arr.push(arrival_datetime);
			   route_arr.push(route);
			   cabin_arr.push(cabin);
			   sharing_arr.push(sharing);
		    }      
		  }  

		var base_url = $('#base_url').val();
		var country_code = $('#country_code').val();
		var mobile_no = $('#mobile_no').val();
		var bsmValues = [];
          bsmValues.push({
          "basic" : $('#basic_show').find('span').text(),
          "service" : $('#service_show').find('span').text(),
          "markup" : $('#markup_show').find('span').text(),
          "discount" : $('#discount_show').find('span').text()
          });
		$('#btn_quotation_save').button('loading');

		$.ajax({

			type:'post',

			url: base_url+'controller/package_tour/quotation/group_tour/quotation_save.php',

			data:{ tour_group_id : tour_group_id, tour_name : tour_name, from_date : from_date, to_date : to_date, total_days : total_days, customer_name : customer_name, email_id : email_id, total_adult : total_adult, total_children : total_children, total_infant : total_infant, total_passangers : total_passangers, children_without_bed : children_without_bed, children_with_bed : children_with_bed, quotation_date : quotation_date, booking_type : booking_type,adult_cost : adult_cost,children_cost : children_cost, infant_cost : infant_cost,with_bed_cost : with_bed_cost,tour_cost : tour_cost,markup_cost: markup_cost,service_charge : service_charge,taxation_id : taxation_id,service_tax : service_tax,service_tax_subtotal : service_tax_subtotal,total_tour_cost : total_tour_cost, train_from_location_arr : train_from_location_arr, train_to_location_arr : train_to_location_arr, train_class_arr : train_class_arr, train_arrival_date_arr : train_arrival_date_arr, train_departure_date_arr : train_departure_date_arr, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr,plane_from_location_arr : plane_from_location_arr, plane_to_location_arr : plane_to_location_arr,airline_name_arr : airline_name_arr , plane_class_arr : plane_class_arr, arraval_arr : arraval_arr, dapart_arr : dapart_arr,dept_datetime_arr : dept_datetime_arr,arrival_datetime_arr : arrival_datetime_arr,route_arr : route_arr,cabin_arr : cabin_arr,sharing_arr : sharing_arr, login_id : login_id , enquiry_id : enquiry_id, tour_group : tour_group,emp_id : emp_id,incl:incl,excl : excl,terms :terms, branch_admin_id : branch_admin_id,financial_year_id : financial_year_id , country_code:country_code, mobile_no:mobile_no,bsmValues:bsmValues},

			success: function(message){

					$('#btn_quotation_save').button('reset');

                	var msg = message.split('--');

					if(msg[0]=="error"){

						error_msg_alert(msg[1]);

					}

					else{

						$('#vi_confirm_box').vi_confirm_box({

						            false_btn: false,

						            message: message,

						            true_btn_text:'Ok',

						    callback: function(data1){

						        if(data1=="yes"){

						        	$('#btn_quotation_save').button('reset');

						        	$('#quotation_save_modal').modal('hide');

						        	quotation_list_reflect();

						        	document.location.reload();

						        }

						      }

						});

					}



                }  



                

		});

	}  



});



        	 

</script>