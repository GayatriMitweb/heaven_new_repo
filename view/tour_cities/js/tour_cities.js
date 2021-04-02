//*******************City Master list load start******************/////////////////////
function tour_city_list_load(id)
{
  var tour_id = $("#"+id).val();  

  $('#div_city_list').load('tour_cities_list_load.php', { tour_id : tour_id }).hide().fadeIn(500);
  $('#div_city_list_update').empty();

}
//*******************Tour City list load end******************/////////////////////

//*******************Tour City update div reflect start******************/////////////////////

function tour_city_update_modal(city_id, tour_id)
{
  $('#div_city_list_update').load('tour_city_update_modal.php', { city_id : city_id, tour_id : tour_id }).hide().fadeIn(500);
}

//*******************Tour City update div reflect end******************/////////////////////

///////////////////////***Tour Cities save start*********//////////////

function tour_cities_save()
{
  var base_url = $('#base_url').val();	
  var tour_id = $("#cmb_tour_id_s").val();

  if(tour_id=="select")
  {
    error_msg_alert("Please select tour name!");
    return false;
  }  

  var city_name = new Array();

  var table = document.getElementById("tbl_dynamic_city_name");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked)
    {  
      var city_name1 = row.cells[2].childNodes[0].value;

      if(city_name1=="select")
      {
        error_msg_alert("Enter city name in row"+(i+1));
        return false;
      }  

      for(var j=0; j<city_name.length; j++)
      {
        if(city_name[j]==city_name1)
        {
          error_msg_alert(city_name+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }  

      city_name.push(city_name1);
    }
    
  }

  if(city_name.length==0)
  {
    error_msg_alert("Select rows to save city names!");
    return false;
  }  


  $.post( 
               base_url+"controller/group_tour/tour_cities/tour_cities_save_c.php",
               { tour_id : tour_id, city_name : city_name },
               function(data) {  
                      msg_popup_reload(data);
                      //$('#div_city_list').load('tour_cities_list_load.php', { tour_id : tour_id }).hide().fadeIn(500);
               });



}

///////////////////////***Tour Cities save end*********//////////////
