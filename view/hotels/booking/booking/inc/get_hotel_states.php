<?php include '../../../../../model/model.php';
$hotel_ids = $_POST['hotel_ids'];
$count = 1;
$result = '';
$sq = mysql_query("select state_id from hotel_master where hotel_id in($hotel_ids)");
while($row = mysql_fetch_assoc($sq)){
    if($row['state_id'] !== '0'){
        if($count == 1){
            if($row['state_id'] === '1') $result .= 'International';
            else $result = 'Domestic';
        }else{
            if($row['state_id'] === '1') $result .= ',International';
            else $result = ',Domestic';
        }
    }else{
        if($count == 1)
            $result = 'No';
        else
            $result .= ',No';
    }
    $count++;
}
echo $result;
?>