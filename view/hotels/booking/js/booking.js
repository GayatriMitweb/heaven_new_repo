//**Hotel Name load start**//
function hotel_name_list_load(id)
{
  var count = id.substring(7);
  var city_id = $("#"+id).val();
  $.get( "inc/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_id"+count).html( data ) ;                            
  } ) ;   
}
//**Hotel Name load end**//