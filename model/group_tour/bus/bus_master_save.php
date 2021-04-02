<?php 
class bus_master_save{

///////////// Bus Master Save start/////////////////////////////////////////////////////////////////////////////////////////
function bus_master_save_c($bus_name, $bus_capacity)
{
  $bus_name = mysql_real_escape_string($bus_name);  
  $bus_capacity = mysql_real_escape_string($bus_capacity);  
  $bus_rows = mysql_real_escape_string($bus_rows);  
  $bus_cols = mysql_real_escape_string($bus_cols);  
  $bus_gap = mysql_real_escape_string($bus_gap);  
  $bus_blank_space = mysql_real_escape_string($bus_blank_space);  
  $bus_cabin_seat_status = mysql_real_escape_string($bus_cabin_seat_status);  
  $bus_combination_status = mysql_real_escape_string($bus_combination_status);  

  $sq_name_count = mysql_num_rows(mysql_query("select * from bus_master where bus_name='$bus_name'"));
  if($sq_name_count>0)
  {
    echo "error--Sorry This bus already exists.";
    exit;
  }  

   $sq = mysql_query("select max(bus_id) as max from bus_master");
   $value = mysql_fetch_assoc($sq);
   $max_id = $value['max'] + 1;

   $sq = mysql_query("insert into bus_master(bus_id, bus_name, capacity) values('$max_id', '$bus_name', '$bus_capacity')");

   if(!$sq)
   {
     echo "error--Error.";
   }
   else
   {
     echo "Bus Details saved successfully.";
   } 

}
///////////// Bus Master Save end/////////////////////////////////////////////////////////////////////////////////////////
	
}
?>