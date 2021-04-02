<form id="frm_tab3">

<div class="row mg_tp_10">

	<div class="col-md-2">
		<small id="basic_show">&nbsp;</small>
	    <input type="text" id="subtotal" name="subtotal" placeholder="Total Fare" title="Total Fare" value="0.00" onchange="flight_quotation_cost_calculate();get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','true','service_charge', true);">

	</div>
	<div class="col-md-2">
		<small id="service_show">&nbsp;</small>
  		<input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="flight_quotation_cost_calculate();validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','false','service_charge');" value="0.00">  
  	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
  		<input type="text" id="service_tax" name="service_tax" placeholder="Tax Amount" title="Tax Amount" onchange="flight_quotation_cost_calculate();validate_balance(this.id)" value="0.00" readonly>  
  	</div>
	<div class="col-md-2">
		<small id="markup_show">&nbsp;</small>
  		<input type="text" id="markup_cost" name="markup_cost" placeholder="Markup Cost" title="Markup Cost" onchange="flight_quotation_cost_calculate();validate_balance(this.id);get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','save','false','service_charge');" value="0.00">  
  	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
  		<input type="text" id="markup_cost_subtotal" name="markup_cost_subtotal" placeholder="Tax on Markup" title="Tax on Markup" onchange="flight_quotation_cost_calculate();" value="0.00" readonly>  
  	</div>
	  <div class="col-md-2">
		<small>&nbsp;</small>
  		<input type="text" id="roundoff" name="roundoff" placeholder="Round Off" title="Round Off" onchange="flight_quotation_cost_calculate();" value="0.00" readonly>  
  	</div>
	<div class="col-md-2">
		<small>&nbsp;</small>
		<input type="text" id="total_tour_cost" class="amount_feild_highlight text-right" name="total_tour_cost" placeholder="Quotation Cost" title="Quotation Cost" value="0"  readonly>

	</div>

 </div>

	<div class="row mg_tp_20 text-center">

		<div class="col-md-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-sm btn-success" id="btn_quotation_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

		</div>

	</div>

</form>



<script>

function switch_to_tab2(){ $('a[href="#tab2"]').tab('show'); }

$('#frm_tab3').validate({

	rules:{

	},

	submitHandler:function(form,e){
		e.preventDefault();
		var enquiry_id = $("#enquiry_id").val();

		var login_id = $("#login_id").val();

		var emp_id = $("#emp_id").val();

		var customer_name = $("#customer_name").val();

		var email_id = $('#email_id').val();

		var mobile_no = $('#mobile_no').val();

		var quotation_date = $('#quotation_date').val();

		var subtotal = $('#subtotal').val();
		var markup_cost = $('#markup_cost').val();
		var markup_cost_subtotal = $('#markup_cost_subtotal').val();

		var service_tax = $('#service_tax').val();
		var service_charge = $('#service_charge').val();

		var total_tour_cost = $('#total_tour_cost').val();
		var branch_admin_id = $('#branch_admin_id1').val();
		var financial_year_id = $('#financial_year_id').val();
		var bsmValues = [];
		bsmValues.push({
			"basic" : $('#basic_show').find('span').text(),
			"service" : $('#service_show').find('span').text(),
			"markup" : $('#markup_show').find('span').text()
		});
		var roundoff = $('#roundoff').val();

		if(enquiry_id == 0){
			var table = document.getElementById("tbl_flight_quotation_dynamic_plane");
			var rowCount = table.rows.length;
			var enquiry_content = Array();
			for(var i=0; i<rowCount; i++){
			var row = table.rows[i];
				if(row.cells[0].childNodes[0].checked){
					var obj = {
						// travel_datetime : row.cells[2].childNodes[0].value,
							sector_from : row.cells[2].childNodes[0].value,
							sector_to : row.cells[3].childNodes[0].value,
							preffered_airline : row.cells[4].childNodes[0].value,
							class_type : row.cells[5].childNodes[0].value,
							total_adults_flight : row.cells[6].childNodes[0].value,
							total_child_flight : row.cells[7].childNodes[0].value,
							total_infant_flight : row.cells[8].childNodes[0].value,
							travel_datetime : row.cells[9].childNodes[0].value,
							from_city_id_flight : row.cells[11].childNodes[0].value,
							to_city_id_flight : row.cells[12].childNodes[0].value,
							budget : 0
						}
						enquiry_content.push(obj); 
					}
			}
				console.log(enquiry_content);
		}
		//Plane Information  
		var from_city_id_arr = new Array();
	    var to_city_id_arr = new Array();
		var from_sector_arr = new Array();

		var to_sector_arr = new Array();

		var airline_name_arr = new Array();

		var plane_class_arr = new Array();
		var total_adult_arr = new Array();
		var total_child_arr = new Array();
		var total_infant_arr = new Array();

		var arraval_arr = new Array();

		var dapart_arr = new Array();



		var table = document.getElementById("tbl_flight_quotation_dynamic_plane");

		  var rowCount = table.rows.length;
		  for(var i=0; i<rowCount; i++){
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
		       if(from_sector=="")

		       {

		          error_msg_alert('Enter Departure Sector in row'+(i+1));

		          return false;

		       }
		       if(to_sector=="")

		       {

		          error_msg_alert('Enter Arrival Sector in row'+(i+1));

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

				from_sector_arr.push(from_sector);
				to_sector_arr.push(to_sector);
		       airline_name_arr.push(airline_name);

		       plane_class_arr.push(plane_class);

		       arraval_arr.push(arraval1);

		       dapart_arr.push(dapart1);
			   total_adult_arr.push(total_adult);
			   total_child_arr.push(total_child);
			   total_infant_arr.push(total_infant);
			   arraval_arr.push(arraval1);
				dapart_arr.push(dapart1);
				from_city_id_arr.push(from_city_id1);
				to_city_id_arr.push(to_city_id1);

		    }      

		  }



		var base_url = $('#base_url').val();

		$('#btn_quotation_save').button('loading');

		$.ajax({

			type:'post',

			url: base_url+'controller/package_tour/quotation/flight/quotation_save.php',

			data:{ enquiry_id : enquiry_id , login_id : login_id, emp_id : emp_id, customer_name : customer_name, email_id : email_id, mobile_no : mobile_no , quotation_date : quotation_date, subtotal : subtotal,markup_cost:markup_cost,markup_cost_subtotal : markup_cost_subtotal, service_tax : service_tax ,service_charge : service_charge ,total_tour_cost : total_tour_cost, from_sector_arr : from_sector_arr, to_sector_arr : to_sector_arr,airline_name_arr : airline_name_arr , plane_class_arr : plane_class_arr, arraval_arr : arraval_arr, dapart_arr : dapart_arr, from_city_id_arr : from_city_id_arr , to_city_id_arr : to_city_id_arr, branch_admin_id : branch_admin_id,financial_year_id :financial_year_id, bsmValues : bsmValues, roundoff : roundoff, enquiry_content : enquiry_content, total_adult_arr : total_adult_arr, total_child_arr : total_child_arr, total_infant_arr : total_infant_arr},

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

						        	//document.location.reload();

						        }

						      }

						});

					}



                }  



                

		});

	}  



});



        	 

</script>