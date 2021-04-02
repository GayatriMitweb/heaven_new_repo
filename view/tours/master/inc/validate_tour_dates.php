<?php
include "../../../../model/model.php";
$from_date1 = $_POST['from_date1'];
$to_date1 = $_POST['to_date1'];
$i = $_POST['i'];
// $days = 0;
// $days1 = 0;
if($i!=0){
    $daysLeft = abs(strtotime($from_date1) - strtotime($to_date1));
    $days1 = $daysLeft/(60 * 60 * 24);
}
else{
    $daysLeft = abs(strtotime($from_date1) - strtotime($to_date1));
    $days = $daysLeft/(60 * 60 * 24);
}
if($days != $days1){
    echo "error--Select Proper Tour Dates from second row!";
} 
?>