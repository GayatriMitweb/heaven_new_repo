<?php 
class city_master{

///////////////////////***City Master save start*********//////////////
function city_master_save($city_name, $active_flag_arr){
  for($i=0; $i<sizeof($city_name); $i++){
    $city_name1 = ltrim($city_name[$i]);
    $city_count = mysql_num_rows(mysql_query("select city_name from city_master where city_name='$city_name1'"));
    if($city_count>0){
      echo "error--".$city_name1." already exist!";
      exit;
    }
  }  

  for($i=0; $i<sizeof($city_name); $i++)
  {
      $max_id1 = mysql_fetch_assoc(mysql_query("select max(city_id) as max from city_master"));
      $max_id = $max_id1['max']+1;

      $sq = mysql_query("insert into city_master (city_id, city_name, active_flag) values ('$max_id', '$city_name[$i]', '$active_flag_arr[$i]') ");
      if(!$sq)
      {
        echo "error--".$city_name[$i]." not saved!";
        exit;
      }
  } 
  echo "City has been successfully saved.";
}
///////////////////////***City Master save end*********//////////////


///////////////////////***City Master Update start*********//////////////
function city_master_update($city_id, $city_name, $active_flag){
  $city_name1 = ltrim($city_name);
  $city_count = mysql_num_rows(mysql_query("select city_name from city_master where city_name='$city_name1' and city_id!='$city_id'"));
  if($city_count>0)
  {
    echo "error--".$city_name1." already exit!";
    exit;
  } 

  $sq = mysql_query("update city_master set city_name='$city_name', active_flag='$active_flag' where city_id='$city_id' ");
  if(!$sq)
  {
    echo "error--City name not updated!";
    exit;
  }  
  else
  {
    echo "City has been successfully updated.";
    return true;
  }  
}
///////////////////////***City Master Update end*********//////////////

}
?>