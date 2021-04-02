//*******************Bus set arrangment content reflect start******************/////////////////////
$(function(){
	$('#frm_bus_seating_arrangment_select').validate({
		submitHandler:function(form){
			var bus_id = $("#cmb_bus_id").val();
		    var tour_id = $("#cmb_tour_name").val();
		    var tour_group_id = $("#cmb_tour_group").val();

		    $('#bus_seat_arrangment_content').load('bus_seat_arrangement_master_reflect.php', { bus_id : bus_id, tour_id : tour_id, tour_group_id : tour_group_id }).hide().fadeIn(200); 
		}
	});
});
//*******************Bus set arrangment content reflect end******************/////////////////////

//*******************Bus set arrangment pdf report generate start******************/////////////////////
function bus_seating_arrangment_pdf()
{
  var bus_id = $("#cmb_bus_id").val();
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();

  url = 'bus_seating_arrangment_pdf.php?bus_id='+bus_id+'&tour_id='+tour_id+'&tour_group_id='+tour_group_id;
                window.open(url, '_blank');

}
//*******************Bus set arrangment pdf report generate end******************/////////////////////

///////////////////////***Bus seat arrangment master save start*********//////////////
function bus_seat_arrangement_master_save()
{
  var base_url = $('#base_url').val();	
  var bus_id = $("#cmb_bus_id").val();
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();
  var capacity = $("#txt_bus_capacity").val();
  var mem_count = $("#txt_mem_count").val();

  var traveler_id_arr = new Array();
  var seat_no_arr = new Array();

  for(i=0; i<mem_count; i++)
  {
    j= i+1;
    var seat_no = $("#txt_seat_no"+j).val();
    var traveler_id = $("#cmb_traveler_id"+j).val();
    if(parseInt(seat_no)>parseInt(capacity))
    {
      error_msg_alert("Seat number can not be greater than "+capacity+" a row "+j);
      return false;
    }  
    seat_no = seat_no.trim();
    if(seat_no!="")
    {
      var first_digit = seat_no.toString()[0];
      if(first_digit==0)
      {
        error_msg_alert("Do not preceed seat number with 0 at row "+j);
        return false;
      } 
      if(seat_no_arr.indexOf(seat_no)!=-1)
      {        
        error_msg_alert("Seat number "+seat_no+" occured more than once.");
        return false;
      }  
      traveler_id_arr.push(traveler_id);
      seat_no_arr.push(seat_no);
    }  
  } 


  $.post( 
               base_url+"controller/group_tour/bus/bus_seat_arrangement_master_save.php",
               { bus_id : bus_id, tour_id : tour_id, tour_group_id : tour_group_id, 'traveler_id[]' : traveler_id_arr, 'seat_no[]' : seat_no_arr },
               function(data) {  
                     msg_popup_reload(data);
               });


}
///////////////////////***Bus seat arrangment master save end*********//////////////