<?php 
class daily_activity{


function activity_save()
{

$emp_id = $_POST["emp_id"];
$activity_date_arr = $_POST["activity_date_arr"];
$activity_type_arr = $_POST["activity_type_arr"];
$time_taken_arr = $_POST['time_taken_arr'];
$description_arr = $_POST['description_arr'];

 
  for($i=0; $i<sizeof($activity_date_arr); $i++)
  {
    $max_id1 = mysql_fetch_assoc(mysql_query("select max(id) as max from daily_activity"));
    $max_id = $max_id1['max']+1;

    $activity_date_arr1 = date('Y-m-d',strtotime($activity_date_arr[$i]));
    
    $description1 = addslashes($description_arr[$i]); 
    $sq = mysql_query("insert into daily_activity (id,emp_id, activity_date, activity_type,time_taken, description ) values ('$max_id','$emp_id', '$activity_date_arr1', '$activity_type_arr[$i]', '$time_taken_arr[$i]', '$description1') ");
    if(!$sq)
    {
      echo "error--".$activity_type_arr[$i]." not saved!";
      exit;
    }  
  }  
  echo "Activities has been successfully saved.";
}


}
?>