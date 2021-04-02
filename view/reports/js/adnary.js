/////////////********** Handover Adnary and gift status start ***********************************
function hanover_adnary(id)
{
  var base_url = $('#base_url').val();
  var traveler_id = document.getElementById(id).value;
  var type = "adnary";

  var status = confirm("Do you want to handover adnary.");
  if(status==false)
  {
    return false;
  }  

  $.post( 
               base_url+"controller/andanry_and_gift/handover_traveler_update.php",
               { traveler_id : traveler_id, type : type},
               function(data) { 
                   data = data.trim();
                   if(data=="error")
                   {
                    alert("Data not saved.");
                   }
                   else
                   {
                   $( "#"+id ).removeClass( "btn-success" ).addClass( "table-danger-btn btn-danger" );  
                   document.getElementById(id).disabled= true;                     
                   }
               });
}

function hanover_gift(id)
{
  var base_url = $('#base_url').val();
  var traveler_id = document.getElementById(id).value;
  var type = "gift";

  var status = confirm("Do you want to handover gift.");
  if(status==false)
  {
    return false;
  }

  $.post( 
               base_url+"controller/andanry_and_gift/handover_traveler_update.php",
               { traveler_id : traveler_id, type : type},
               function(data) {   
                   data = data.trim();
                   if(data=="error")
                   {
                    alert("Data not saved.");
                   }
                   else
                   {  
                   $( "#"+id ).removeClass( "btn-success" ).addClass( "table-danger-btn btn-danger" ); 
                   document.getElementById(id).disabled= true;                     
                   }
               });
}
/////////////********** Handover Adnary and gift status end ***********************************
