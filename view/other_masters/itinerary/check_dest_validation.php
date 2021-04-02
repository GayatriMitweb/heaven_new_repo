<?php
include '../../../model/model.php';
$dest_id = $_POST['dest_id'];
$sq_repc = mysql_num_rows(mysql_query("select dest_id from itinerary_master where dest_id='$dest_id'"));
if($sq_repc > 0 ){
    echo "Itinerary already added for this destination.Please update the same!";
}
else{
    echo '';
}
?>