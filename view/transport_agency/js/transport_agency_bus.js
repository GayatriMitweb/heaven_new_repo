///////////////////////*** Transport Agency Bus master save start*********//////////////
function transport_agency_bus_master_save()
{
  var base_url = $('#base_url').val();
  var bus_name = new Array();
  var bus_capacity = new Array();
  var per_day_cost = new Array();
  var active_flag_arr = new Array();

  var table = document.getElementById("tbl_dynamic_transport_agency_bus");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked)
    {  
      var bus_name1 = row.cells[2].childNodes[0].value;
      var bus_capacity1 = row.cells[3].childNodes[0].value;
      var cost = row.cells[4].childNodes[0].value;
      var active_flag1 = row.cells[5].childNodes[0].value;
      if(bus_name1=="")
      {
        error_msg_alert("Enter Vehicle name in row"+(i+1));
        return false;
      }
   

      for(var j=0; j<bus_name.length; j++)
      {
        if(bus_name[j]==bus_name1)
        {
          error_msg_alert(bus_name+" is repeated in row"+(j+1)+" and row"+(i+1));
          return false;
        }  
      }  

      bus_name.push(bus_name1);
      bus_capacity.push(bus_capacity1);
      active_flag_arr.push(active_flag1);
      per_day_cost.push(cost);
    }
    
  }

  if(bus_name.length==0)
  {
    error_msg_alert("Atleast one vehicle details required!");
    return false;
  }  


  $.post( 
         base_url+"controller/group_tour/transport_agency/transport_agency_bus_master_save_c.php",
         { bus_name : bus_name, bus_capacity : bus_capacity,per_day_cost : per_day_cost, active_flag_arr : active_flag_arr },
         function(data) {  
                msg_popup_reload(data);
         });


}
///////////////////////***Transport Agency Bus save end*********//////////////

//*******************transport agency bus Master update div reflect start******************/////////////////////
function transport_agency_bus_master_update_modal(bus_id)
{
  $('#div_transport_agency_bus_update_modal').load('transport_agency_bus_master_update_modal.php', { bus_id : bus_id }).hide().fadeIn(500);
  
}
//*******************transport agency bus Master update div reflect end******************/////////////////////