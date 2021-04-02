/////// ready to adjust room reflect reflect start///////////////////////////////////////////////
function adjust_room_ready_traveler_groups()
{
  var tour_id = document.getElementById("cmb_tour_name").value;
  var tour_group_id = document.getElementById("cmb_tour_group").value;
  var adjust_room_with_other = $("#txt_adjust_room_with_other").val();  

  if(adjust_room_with_other=="yes"){
      $('#div_adjust_room_with').removeClass('hidden');  
  }else{
    $('#div_adjust_room_with').addClass('hidden');  
  }

  $.get( "../inc/adjust_room_ready_traveler_groups_load.php" , { tour_id : tour_id, tour_group_id : tour_group_id, adjust_room_with_other : adjust_room_with_other } , function ( data ) {
                document.getElementById("txt_adjust_room_with").disabled = false;
                $ ("#txt_adjust_room_with").html(data);                            
          } ) ; 

}
/////// ready to adjust room reflect reflect end///////////////////////////////////////////////