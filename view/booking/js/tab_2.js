$('#txt_train_date1, #txt_plane_date-1, #txt_arravl-1,#cruise_departure_date,#cruise_arrival_date').datetimepicker({ format:'d-m-Y H:i:s' });
$('#txt_train_from_location1, #txt_train_to_location1').select2();
$('#txt_plane_from_location1, #txt_plane_to_location1, #txt_plane_company1').select2();

function switch_to_tab_1()
{
  $('#tab_2_head').removeClass('active');
  $('#tab_1_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab_1').addClass('active');
  $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$(function(){  
    var type = "travel"; 
    var btnUpload=$('#train_upload');
    var status=$('#train_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
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

});


$(function(){
    var type = "travel";  
    var btnUpload=$('#plane_upload');
    var status=$('#plane_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
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

});

$(function(){  
    var type = "travel"; 
    var btnUpload=$('#cruise_upload');
    var status=$('#cruise_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
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

});



$(function(){

 $('#frm_tab_2').validate({
  rules:{
  },
  submitHandler:function(form){


  var table = document.getElementById("tbl_train_travel_details_dynamic_row");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

    var count = 0;

    if(row.cells[0].childNodes[0].checked)
     {
        var date1 = row.cells[2].childNodes[0];
        var date = $(date1).val();
        var from_location = row.cells[3].childNodes[0].value;
        var to_location = row.cells[4].childNodes[0].value;
        var train_no = row.cells[5].childNodes[0].value;
        var seats = row.cells[6].childNodes[0].value;
        var amount = row.cells[7].childNodes[0].value;
        var class_name = row.cells[8].childNodes[0].value;
        var priority = row.cells[9].childNodes[0].value;
        var service_charge = row.cells[9].childNodes[0].value;
        
        if(date == "")
        { error_msg_alert("Select date for train details at row"+current_row);
          row.cells[2].childNodes[0].focus();
          return false;
        }
        if(from_location == "")
        {
          error_msg_alert("Enter from location at row"+current_row);
          row.cells[3].childNodes[0].focus();
          return false;
        }
        if(to_location == "")
        {
          error_msg_alert("Enter to location at row"+current_row);
          row.cells[4].childNodes[0].focus();
          return false;
        }  
      
        if(amount == "")
        {
          error_msg_alert("Enter amount at row"+current_row);
          row.cells[7].childNodes[0].focus();
          return false;
        }
        
        count++; 
      }
      
    } 

    //** Validation for plane
    var table = document.getElementById("tbl_plane_travel_details_dynamic_row");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
      var row = table.rows[i];
      var current_row = parseInt(i)+1;

       if(row.cells[0].childNodes[0].checked)
       {
        var date1 = row.cells[2].childNodes[0];
        var date = $(date1).val(); 
        
        var plane_from_location1 = row.cells[3].childNodes[0].value;           
        var to_location1 = row.cells[4].childNodes[0].value;
        var company1 = row.cells[5].childNodes[0].value;
        var seats1 = row.cells[6].childNodes[0].value;
        var amount1 = row.cells[7].childNodes[0].value;
        var arravl1 = row.cells[8].childNodes[0].value;
        var from_city_id1 = row.cells[9].childNodes[0].value;
        var to_city_id1 = row.cells[10].childNodes[0].value;
        //var service_charge = row.cells[9].childNodes[0].value;
        
        if(date == "")
        {
          error_msg_alert("Select date for plane details at row "+current_row);
          row.cells[2].childNodes[0].focus();
          return false;
        }
       
           if(plane_from_location1=="")

           {

              error_msg_alert('Enter from sector at row '+current_row);
               row.cells[3].childNodes[0].focus();
              return false;

           }

        if(to_location1 == "")
        {
          error_msg_alert("Enter to sector at row "+current_row);
          row.cells[4].childNodes[0].focus();
          return false;
        }  
        if(company1 == "")
        {
          error_msg_alert("Enter company name for plane details at row "+current_row);
          row.cells[5].childNodes[0].focus();
          return false;
        }
       
        if(amount1 == "")
        {
          error_msg_alert("Enter amount for plane details at row "+current_row);
          row.cells[7].childNodes[0].focus();
          return false;
        }
         if(arravl1 == "")
        {
          error_msg_alert("Arrival date and time plane details at row "+current_row);
          row.cells[8].childNodes[0].focus();
          return false;
        }          
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

        if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Departure datetime in row-"+(i+1)+" is required<br>");
        row.cells[2].childNodes[0].focus();
          return false; }
        if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Arrival datetime in row-"+(i+1)+" is required<br>"); 
        row.cells[3].childNodes[0].focus();
            return false;}
        if(row.cells[4].childNodes[0].value==""){ error_msg_alert("Route in row-"+(i+1)+" is required<br>"); 
        row.cells[4].childNodes[0].focus();
          return false;}
        if(row.cells[5].childNodes[0].value==""){ error_msg_alert("Cabin in row-"+(i+1)+" is required<br>"); 
        row.cells[5].childNodes[0].focus();
          return false;}
        if(row.cells[8].childNodes[0].value==""){ error_msg_alert("Amount in row-"+(i+1)+" is required<br>");
        row.cells[8].childNodes[0].focus();
          return false; }
        
        count++; 
      }      
    } 
    $('#tab_2_head').addClass('done');
    $('#tab_3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_3').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

    return false;


  }
 }); 


});