$('#transport_agency_id, #transport_bus_id,#city_name,#txt_catagory1,#hotel_name').select2();
$('#txt_tsp_from_date, #txt_tsp_to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_hotel_from_date1, #txt_hotel_to_date1,#exc_date-1').datetimepicker({  format:'d-m-Y H:i:s' });

function back_to_tab_2(){
	  $('#tab_3_head').removeClass('active');
    $('#tab_2_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_2').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

/**Hotel Name load start**/
function load_hotel_list(id){
  var city_id = $("#"+id).val();
  var count = id.substring(10);
  
  $.get( "../../booking/inc/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name1"+count).html( data ) ;                            
  } ) ;   
}
/////////////////////////////////////Package Tour hotel name list load end/////////////////////////////////////

$(function(){
	$('#frm_tab_3').validate({
    rules:{
            
    },
		submitHandler:function(form){

			var valid_state = package_tour_booking_tab3_validate();
			if(valid_state==false){ return false; }

      //** Validation for Transport
      var table = document.getElementById("tbl_package_transport_infomration");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];

        if(row.cells[0].childNodes[0].checked)
        {
          if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Transport Vehicle in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Transport Start Date in row-"+(i+1)+" is required<br>"); return false; }
          if($("option:selected", $("#"+row.cells[4].childNodes[0].id)).parent().attr('value')==""){ error_msg_alert("Transport Pickup location in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[5].childNodes[0].value==""){ error_msg_alert("Transport Drop location in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[6].childNodes[0].value==""){ error_msg_alert("Vehicle count in row-"+(i+1)+" is required<br>"); return false; }
          
          count++; 
        }
        
      }

      //** Validation for Activity
      var table = document.getElementById("tbl_package_exc_infomration");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
        if(row.cells[0].childNodes[0].checked)
        {
          if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Activity Date in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Activity City in row-"+(i+1)+" is required<br>"); return false; }
          if(row.cells[4].childNodes[0].value==""){ error_msg_alert("Activity in row-"+(i+1)+" is required<br>"); return false;}
          if(row.cells[5].childNodes[0].value==""){ error_msg_alert("Transfer option in row-"+(i+1)+" is required<br>"); return false; }

          count++; 
        }
      }

			$('#tab_3_head').addClass('done');
			$('#tab_4_head').addClass('active');
			$('.bk_tab').removeClass('active');
			$('#tab_4').addClass('active');
			$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

		}
	});
});


/////////////////////////////////////Package Tour Master Tab3 validate start/////////////////////////////////////
function package_tour_booking_tab3_validate()
{
  g_validate_status = true;
  var validate_message = "";

  var table = document.getElementById("tbl_package_hotel_infomration");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];

     if(row.cells[0].childNodes[0].checked)
     {
      validate_dynamic_empty_select(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[4].childNodes[0]);
      validate_dynamic_empty_date(row.cells[5].childNodes[0]);
      validate_dynamic_empty_date(row.cells[6].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[9].childNodes[0]); 

      if(row.cells[2].childNodes[0].value==""){ validate_message += "City in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[3].childNodes[0].value==""){ validate_message += "Hotel in row-"+(i+1)+" is required<br>"; }                
      if(row.cells[4].childNodes[0].value==""){ validate_message += "Check-In date in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[5].childNodes[0].value==""){ validate_message += "Check-Out date in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[6].childNodes[0].value==""){ validate_message += "Rooms in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[7].childNodes[0].value==""){ validate_message += "Category in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[8].childNodes[0].value==""){ validate_message += "Meal Plan in row-"+(i+1)+" is required<br>"; }               
      if(row.cells[9].childNodes[0].value==""){ validate_message += "Room type in row-"+(i+1)+" is required<br>"; }               
    }
  } 
  if(validate_message!=""){
            error_msg_alert(validate_message, 10000);
            return false;
          }

  if(g_validate_status == false) { return false; }  

}
/////////////////////////////////////Package Tour Master Tab3 validate end/////////////////////////////////////

