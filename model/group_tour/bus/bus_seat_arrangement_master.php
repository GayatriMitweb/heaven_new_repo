<?php 
class bus_seat_arrangement_master{

///////////////////////***Bus seat arrangment master save start*********//////////////

function bus_seat_arrangement_master_save($bus_id, $tour_id, $tour_group_id, $traveler_id, $seat_no)
{
  $sq_entry_count = mysql_num_rows(mysql_query("select * from bus_seat_arrangment_master where tour_id='$tour_id' and tour_group_id='$tour_group_id' and bus_id='$bus_id'"));

  if($sq_entry_count==0)
  {    
    $sq_bus_det = mysql_fetch_assoc(mysql_query("select capacity from bus_master where bus_id='$bus_id'")); 
    $bus_capacity = $sq_bus_det['capacity'];
    $seat_no_count=0;
    while($seat_no_count<$bus_capacity)
    {
      $sq_max_id = mysql_fetch_assoc(mysql_query("select max(id) as max from bus_seat_arrangment_master"));
      $max_id = $sq_max_id['max']+1;

      $seat_no_count++;

      $sq_buss_arrangment_save = mysql_query("insert into bus_seat_arrangment_master (id, tour_id, tour_group_id, bus_id, seat_no) values ('$max_id', '$tour_id', '$tour_group_id', '$bus_id', '$seat_no_count')");
      if(!$sq_buss_arrangment_save) 
      {
        echo "error--Error1";
        exit;
      }  
    }  
  } 

  if(sizeof($traveler_id)>0)
  {
    $sq_bus_arrangment_empty = mysql_query("update bus_seat_arrangment_master set traveler_id='' where tour_id='$tour_id' and tour_group_id='$tour_group_id' and bus_id='$bus_id'");
    if(!$sq_bus_arrangment_empty)
    {
      echo "error--Error2";
    }  
  }  

  for($i=0;$i<sizeof($traveler_id);$i++)
  {  
    $sq_buss_arrangment_update = mysql_query("update bus_seat_arrangment_master set traveler_id='$traveler_id[$i]' where tour_id='$tour_id' and tour_group_id='$tour_group_id' and bus_id='$bus_id' and seat_no='$seat_no[$i]'");
    if(!$sq_buss_arrangment_update)
    {
      echo "error--Error3";
      exit;
    }  
  } 

  echo "Information saved successfully.";

}

///////////////////////***Bus seat arrangment master save end*********//////////////


}
?>