<?php include '../../../../../model/model.php';
$hotel_ids = $_POST['hotel_ids'];
$count = 1;
$result = '';
$sq = mysql_query("select hotel_name, city_id from hotel_master where hotel_id in($hotel_ids)");
while($row = mysql_fetch_assoc($sq)){
    $city_name = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id=".$row['city_id']));
    if($count == 1){
        $result .= $row['hotel_name']." (".$city_name['city_name'].")";
    }else{
        $result .= ','.$row['hotel_name']." (".$city_name['city_name'].")";
    }
    $count++;
}
echo $result;
?>