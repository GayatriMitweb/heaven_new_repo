<?php 
class andanry_and_gift{

///////////// Handover Traveler Details Start/////////////////////////////////////////////////////////////////////////////////////////

function adnary_handover_update($traveler_id)
{
  $sq = mysql_query("update travelers_details set handover_adnary='yes' where traveler_id='$traveler_id' ");
  if(!$sq)
  {
    echo "error";
  }  
}

function gift_handover_update($traveler_id)
{
  $sq = mysql_query("update travelers_details set handover_gift='yes' where traveler_id='$traveler_id' ");
  if(!$sq)
  {
    echo "error";
  }
}

///////////// Handover Traveler Details End/////////////////////////////////////////////////////////////////////////////////////////

}
?>