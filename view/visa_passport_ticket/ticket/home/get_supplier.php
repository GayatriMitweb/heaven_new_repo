<?php include "../../../../model/model.php";
$hotel_ids = $_POST['vendor_id'];
$result = '';
$sq = mysql_query("select  from hotel_master where hotel_id in($hotel_ids)");
while($row = mysql_fetch_assoc($sq)){
    if($count == 1){
        $result .= $row['hotel_name'];
    }else{
        $result .= ','.$row['hotel_name'];
    }
    $count++;
}
echo $result;
?>