//*******************City Master update div reflect start******************/////////////////////

function city_master_update_modal(city_id)
{
  $('#div_city_list_update_modal').load('city_master_update_modal.php', { city_id : city_id }).hide().fadeIn(500);
}

//*******************Tour City update div reflect end******************/////////////////////