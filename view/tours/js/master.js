$('#frm_tour_master_save').validate({

	rules:{

		txt_tour_cost : { required: true, number:true },

		txt_child_with_cost : { required: true, number:true },

        txt_infant_cost : { required: true, number:true },

        with_bed_cost : { required: true,  number:true   },

        inclusions : { required : true},

		exclusions : { required : true},
		
		dest_name_s : { required : true},

	},

	submitHandler:function(form){	

    var base_url = $('#base_url').val();

    var tour_type = $("#cmb_tour_type").val();
    var tour_name = $("#txt_tour_name").val();

    var adult_cost =  $("#txt_tour_cost").val();

	var child_with_cost = $("#txt_child_with_cost").val();
	
	var child_without_cost = $("#txt_child_without_cost").val();

    var infant_cost = $("#txt_infant_cost").val();

    var with_bed_cost = $("#with_bed_cost").val();

    var visa_country_name = $("#visa_country_name1").val();

    var company_name = $("#company_name1").val();

    var active_flag = $("#active_flag").val();  
	var dest_name = $("#dest_name_s").val();
	
	var iframe = document.getElementById("inclusions-wysiwyg-iframe");
	var inclusions = iframe.contentWindow.document.body.innerHTML;
	var iframe1 = document.getElementById("exclusions-wysiwyg-iframe");
	var exclusions = iframe1.contentWindow.document.body.innerHTML;
	var pdf_url = $("#photo_upload_url_i").val();
	
    //Tour group table

	var from_date = new Array();

	var to_date = new Array();

	var capacity = new Array();



	var table = document.getElementById("tbl_dynamic_tour_group");

	var rowCount = table.rows.length;

	var latest_date="";



	for(var i=0; i<rowCount; i++)

	{

	var row = table.rows[i];

	

	if(row.cells[0].childNodes[0].checked)

	{

		var from_date1 = row.cells[2].childNodes[0].value;         

		var to_date1 = row.cells[3].childNodes[0].value;         

		var capacity1 = row.cells[4].childNodes[0].value;   



		if(from_date1=="" || to_date1=="" ){  

			error_msg_alert('From date and To Date is required'+(i+1));

			return false; 

		}



		if(capacity1=="" ){  

			error_msg_alert('Seating Capacity is required'+(i+1));

			return false; 

		}



		var get_from = from_date1.split('-');

		var day=get_from[0];

		var month=get_from[1];

		var year=get_from[2];

		var dateOne = new Date(year, month, day);      



		var get_to = to_date1.split('-');

		var day=get_to[0];

		var month=get_to[1];

		var year=get_to[2];

		var dateTwo = new Date(year, month, day);





		if(dateOne>dateTwo)

		{

		error_msg_alert('From date is greater to date in row'+(i+1));

		return false;

		}

	

		var latest_date = dateTwo;



		from_date.push(from_date1);

		to_date.push(to_date1);

		capacity.push(capacity1);    

	}      

	} 



    //Daywise program 

    var day_program_arr = new Array();

    var special_attaraction_arr = new Array();

    var overnight_stay_arr = new Array();
    var meal_plan_arr = new Array();

    var table = document.getElementById("dynamic_table_list_group");

    var rowCount = table.rows.length;

        for(var i=0; i<rowCount; i++)

        {

			var row = table.rows[i];

			var special_attaraction = row.cells[1].childNodes[0].value;

			var day_program = row.cells[2].childNodes[0].value;

			var overnight_stay = row.cells[3].childNodes[0].value;
			var meal_plan = row.cells[4].childNodes[0].value;

			if(day_program=="") {error_msg_alert("Day-wise program important"); return false;}
			day_program_arr.push(day_program);

			special_attaraction_arr.push(special_attaraction);

			overnight_stay_arr.push(overnight_stay);                 
			meal_plan_arr.push(meal_plan);
        }




    //Train Information

	var train_from_location_arr = new Array();

	var train_to_location_arr = new Array();

	var train_class_arr = new Array();
	var table = document.getElementById("tbl_group_tour_save_dynamic_train");

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

	}      

	}



	//Plane Information  
	var from_city_id_arr = new Array();
	var plane_from_location_arr = new Array();
	var to_city_id_arr = new Array();
	var plane_to_location_arr = new Array();

	var airline_name_arr = new Array();

	var plane_class_arr = new Array();




	var table = document.getElementById("tbl_group_tour_quotation_dynamic_plane");
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++)

	{

	var row = table.rows[i];

		

	if(row.cells[0].childNodes[0].checked)

	{
		var from_sector1 = row.cells[2].childNodes[0].value;
		var to_sector1 = row.cells[3].childNodes[0].value;   

		var airline_name = row.cells[4].childNodes[0].value;  

		var plane_class = row.cells[5].childNodes[0].value;  
		var from_city1 = row.cells[6].childNodes[0].value;  
		var to_city1 = row.cells[7].childNodes[0].value;  

		if(from_sector1=="")

		{

				error_msg_alert('Enter from sector in row'+(i+1));

				return false;

		}

		if(to_sector1=="")

		{

			error_msg_alert('Enter to sector in row'+(i+1));

			return false;

		}


		if(airline_name=="")

		{ 

			error_msg_alert('Airline Name is required in row:'+(i+1)); 

			return false;

		}

		if(plane_class=="")

		{ 

			error_msg_alert("Class is required in row:"+(i+1)); 

				return false;

		}



		from_city_id_arr.push(from_city1);
		to_city_id_arr.push(to_city1);

		plane_from_location_arr.push(from_sector1);

		plane_to_location_arr.push(to_sector1);

		airline_name_arr.push(airline_name);

		plane_class_arr.push(plane_class);

	    }      

	}
	// Hotel Information
	var city_name_arr = new Array();
	
	var hotel_name_arr = new Array();

	var hotel_type_arr = new Array();

	var total_days_arr = new Array();

	var table = document.getElementById("tbl_package_hotel_master");

	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++)

	{

		var row = table.rows[i];

	if(row.cells[0].childNodes[0].checked)

	{  

		var city_name = row.cells[2].childNodes[0].value;

		var hotel_name = row.cells[3].childNodes[0].value;

		var hotel_type = row.cells[4].childNodes[0].value;

		var total_days = row.cells[5].childNodes[0].value;



		city_name_arr.push(city_name);

		hotel_name_arr.push(hotel_name);

		hotel_type_arr.push(hotel_type);  

		total_days_arr.push(total_days);  

	}

	}



	//Cruise Information

	var route_arr = new Array();
	var cabin_arr = new Array();

	var table = document.getElementById("tbl_dynamic_cruise");
	var rowCount = table.rows.length;

	for(var i=0; i<rowCount; i++){

		var row = table.rows[i];	 
		if(row.cells[0].childNodes[0].checked)
		{
			var route = row.cells[2].childNodes[0].value;    
			var cabin = row.cells[3].childNodes[0].value;        
			if(route=="")
			{
				error_msg_alert('Enter route in row'+(i+1));
				return false;
			}	      	 
			route_arr.push(route);
			cabin_arr.push(cabin);
		}
	}
	var daywise_url = $('#daywise_url').val();
    $('#btn_quotation_save').button('loading');
    $.ajax({
		type:'post',
		url:  base_url+'controller/group_tour/tours/tour_master_save.php',              
		data:   { tour_type : tour_type, tour_name : tour_name, adult_cost : adult_cost, child_with_cost : child_with_cost, child_without_cost : child_without_cost, infant_cost : infant_cost, with_bed_cost : with_bed_cost, 'from_date[]' : from_date, 'to_date[]' : to_date, 'capacity[]' : capacity,visa_country_name : visa_country_name,company_name : company_name ,active_flag : active_flag,day_program_arr : day_program_arr, special_attaraction_arr : special_attaraction_arr,overnight_stay_arr : overnight_stay_arr,meal_plan_arr : meal_plan_arr,train_from_location_arr : train_from_location_arr, train_to_location_arr : train_to_location_arr, train_class_arr : train_class_arr, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr, plane_from_location_arr : plane_from_location_arr, plane_to_location_arr : plane_to_location_arr,airline_name_arr : airline_name_arr , plane_class_arr : plane_class_arr,route_arr : route_arr,cabin_arr : cabin_arr, city_name_arr : city_name_arr ,hotel_name_arr : hotel_name_arr,hotel_type_arr : hotel_type_arr,total_days_arr : total_days_arr,inclusions : inclusions, exclusions : exclusions,pdf_url : pdf_url ,daywise_url:daywise_url,dest_name:dest_name},
		success: function(data){

			var msg = data.split('--');
			if(msg[0]=="error"){
					error_msg_alert(msg[1]);
					$('#btn_quotation_save').button('reset');
					return false;
			}
			else
			{
				$('#btn_quotation_save').button('reset');
				$('#vi_confirm_box').vi_confirm_box({
					false_btn: false,
					message: data,
					true_btn_text:'Ok',
					callback: function(data1){
						if(data1=="yes"){
							update_b2c_cache();
							window.location.href =  '../index.php';
						}
						}
				});
			}
		}
	});
}
});

function hotel_name_list_load(id){

	var base_url = $("#base_url").val();
	var city_id = $("#"+id).val();
	var count = id.substring(9);
	$.get( base_url+"view/custom_packages/master/package/hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
		$ ("#hotel_name"+count).html( data ) ;                            
	});   
}
function hotel_type_load(id){

	var base_url = $("#base_url").val();
	var hotel_id = $("#"+id).val();
	var count = id.substring(10);
	$.get( base_url+"view/custom_packages/master/package/hotel/hotel_type_load.php" , { hotel_id : hotel_id } , function ( data ) {
		$ ("#hotel_type"+count).val( data ) ;                            
	});
}