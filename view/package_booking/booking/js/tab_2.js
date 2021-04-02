$('#txt_train_date1, #txt_plane_date1').datetimepicker({ format:'d-m-Y H:i:s' });
$('#txt_train_from_location1, #txt_train_to_location1, #txt_plane_company1').select2();
$('#txt_plane_from_location1, #txt_plane_to_location1').select2();
$('#frm_tab_2').validate({
	submitHandler:function(form){

    var valid_state = package_tour_booking_tab2_validate();
    if(valid_state==false){ return false; }

		$('#tab_2_head').addClass('done');
    $('#tab_3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_3').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

	}
});

function back_to_tab_1()
{
	$('#tab_2_head').removeClass('active');
	$('#tab_1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab_1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}
/////////////////////////////////////Package Tour Master Tab2 validate start/////////////////////////////////////
function package_tour_booking_tab2_validate(){
  g_validate_status = true;
  var validate_message = "";

  var count =0;
  //** Validation for train
  var table = document.getElementById("tbl_train_travel_details_dynamic_row");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

    if(row.cells[0].childNodes[0].checked){
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_select(row.cells[4].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);

      if(row.cells[2].childNodes[0].value==""){ validate_message += "Date in row-"+(i+1)+" is required<br>"; }
      if(row.cells[3].childNodes[0].value==""){ validate_message += "From location in row-"+(i+1)+" is required<br>"; }
      if(row.cells[4].childNodes[0].value==""){ validate_message += "To location in row-"+(i+1)+" is required<br>"; }
      if(row.cells[7].childNodes[0].value==""){ validate_message += "Amount in row-"+(i+1)+" is required<br>"; }
      count++;
    }
  } 

  //** Validation for plane
  var table = document.getElementById("tbl_plane_travel_details_dynamic_row") || document.getElementById("tbl_plane_travel_details_dynamic_row_update") ;
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

     if(row.cells[0].childNodes[0].checked){
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      //validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[5].childNodes[0]); //airline
      // validate_dynamic_empty_fields(row.cells[8].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[7].childNodes[0]);//amount
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);//date
      //var service_charge = row.cells[9].childNodes[0].value;

      if(row.cells[2].childNodes[0].value==""){ validate_message += "Date in row-"+(i+1)+" is required<br>"; }
      //if(row.cells[3].childNodes[0].value==""){ validate_message += "From City in row-"+(i+1)+" is required<br>"; }
      if(row.cells[3].childNodes[0].value==""){ validate_message += "From Sector in row-"+(i+1)+" is required<br>"; }
      //if(row.cells[5].childNodes[0].value==""){ validate_message += "To City in row-"+(i+1)+" is required<br>"; }
      if(row.cells[4].childNodes[0].value==""){ validate_message += "To Sector in row-"+(i+1)+" is required<br>"; }
      if(row.cells[5].childNodes[0].value==""){ validate_message += "Airline Name in row-"+(i+1)+" is required<br>"; }
      
      if(row.cells[7].childNodes[0].value==""){ validate_message += "Amount in row-"+(i+1)+" is required<br>"; }
      if(row.cells[8].childNodes[0].value==""){ validate_message += "Arrival Date and time in row-"+(i+1)+" is required<br>"; }
            
      count++; 
    }
  }  

  //** Validation for cruise
  var table = document.getElementById("tbl_dynamic_cruise_package_booking");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

    if(row.cells[0].childNodes[0].checked)
     {
      validate_dynamic_empty_date(row.cells[2].childNodes[0]);
      validate_dynamic_empty_select(row.cells[3].childNodes[0]);
      validate_dynamic_empty_select(row.cells[4].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[5].childNodes[0]);
      validate_dynamic_empty_fields(row.cells[8].childNodes[0]);

      if(row.cells[2].childNodes[0].value==""){ validate_message += "Departure datetime in row-"+(i+1)+" is required<br>"; }
      if(row.cells[3].childNodes[0].value==""){ validate_message += "Arrival datetime in row-"+(i+1)+" is required<br>"; }
      if(row.cells[4].childNodes[0].value==""){ validate_message += "Route in row-"+(i+1)+" is required<br>"; }
      if(row.cells[5].childNodes[0].value==""){ validate_message += "Cabin in row-"+(i+1)+" is required<br>"; }
      if(row.cells[8].childNodes[0].value==""){ validate_message += "Amount in row-"+(i+1)+" is required<br>"; }
      
      count++; 
    }
    
  } 


if(validate_message!=""){
  error_msg_alert(validate_message, 10000);
  return false;
}
if(g_validate_status == false) { return false; }  
}
/////////////////////////////////////Package Tour Master Tab2 validate end/////////////////////////////////////


//*******************Package tour train and plane and cruise ticket upload function start******************/////////////////////

function package_tour_train_ticket()
{  
    var type = "travel"; 
    var btnUpload=$('#package_train_upload');
    var status=$('#package_train_status');
    new AjaxUpload(btnUpload, {
      action: '../upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG or GIF files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_train_upload_dir").value = response;
          alert("File Uploaded Successfully.");  
        }
      }
    });
    
}
package_tour_train_ticket();

function package_tour_plane_ticket()
{
    var type = "travel";  
    var btnUpload=$('#package_plane_upload');
    var status=$('#package_plane_status');
    new AjaxUpload(btnUpload, {
      action: '../upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG or GIF files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_plane_upload_dir").value = response;
          alert("File Uploaded Successfully.");  
        }
      }
    });
    
}
package_tour_plane_ticket();

function package_tour_cruise_ticket()
{  
    var type = "travel"; 
    var btnUpload=$('#package_cruise_upload');
    var status=$('#package_cruise_status');
    new AjaxUpload(btnUpload, {
      action: '../upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG or GIF files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_cruise_upload_dir").value = response;
          alert("File Uploaded Successfully.");  
        }
      }
    });    
}
package_tour_cruise_ticket();
//*******************Package tour train and plane ticket upload function end******************/////////////////////
