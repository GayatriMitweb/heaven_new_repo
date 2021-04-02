<?php
include "../../../../../model/model.php";
$entryidArray = $_REQUEST['entryidArray'];
// $entryidArray = array('1','2','3','4','5','6');
$reflectArray = array();
$passDetails = array();
$sectDetails = array();
$adultFare = 0;
$childFare = 0;
$infantFare = 0;
$yq_tax = 0;
$other_tax = 0;
$uniquePnr = array();
$ticketairfileID = array();
$addIterator = 0;
for($i = 0; $i < sizeof($entryidArray) + $addIterator; $i++){
    $passengers = mysql_fetch_assoc(mysql_query("SELECT * FROM `ticket_master_entries_airfile` WHERE `entry_id` = ".$entryidArray[$i]));
    $passDetails[$i]['first_name'] = $passengers['first_name'];
    $passDetails[$i]['middle_name'] = $passengers['middle_name'];
    $passDetails[$i]['last_name'] = $passengers['last_name'];
    $passDetails[$i]['adolescence'] = $passengers['adolescence'];
    $passDetails[$i]['ticket_no'] = $passengers['ticket_no'];
    $passDetails[$i]['gds_pnr'] = $passengers['gds_pnr'];
    $passDetails[$i]['conjunction'] = '';
    if($passengers['cticket_no'] != ''){
        $passDetails[++$i]['first_name'] = $passengers['first_name'];
        $passDetails[$i]['middle_name'] = $passengers['middle_name'];
        $passDetails[$i]['last_name'] = $passengers['last_name'];
        $passDetails[$i]['adolescence'] = $passengers['adolescence'];
        $passDetails[$i]['ticket_no'] = $passengers['cticket_no'];
        $passDetails[$i]['gds_pnr'] = $passengers['gds_pnr'];
        $passDetails[$i]['conjunction'] = 'conjunction';
        $addIterator++;
    }
    array_push($uniquePnr, $passengers['gds_pnr']);
    array_push($ticketairfileID, $passengers['ticket_airfile_id']);
} 
$ticketairfileID = array_unique($ticketairfileID);
foreach($ticketairfileID as $values){
    $sectInfo = mysql_query("SELECT * FROM `ticket_trip_entries_airfile` WHERE `ticket_airfile_id` = ".$values);
    while($rows = mysql_fetch_assoc($sectInfo)){
        $fromCity = mysql_fetch_assoc(mysql_query("SELECT `city_name` FROM `city_master` WHERE `city_id` =".$rows['from_city']));
        $rows['from_city_show'] = $fromCity['city_name'];
        $toCity = mysql_fetch_assoc(mysql_query("SELECT `city_name` FROM `city_master` WHERE `city_id` =".$rows['to_city']));
        $rows['to_city_show'] = $toCity['city_name'];
        $rows['departure_datetime'] = get_datetime_user($rows['departure_datetime']);
        $rows['arrival_datetime'] = get_datetime_user($rows['arrival_datetime']);
        array_push($sectDetails, $rows);
    }
}
$uniquePnr = array_unique($uniquePnr);
// echo "<pre>";
// var_dump($uniquePnr);
foreach($uniquePnr as $values){
    $ticketEntries = mysql_fetch_assoc(mysql_query("SELECT * FROM `ticket_master_entries_airfile` WHERE `gds_pnr` = '".$values."'"));
    $ticketMaster =  mysql_fetch_assoc(mysql_query("SELECT * FROM `ticket_master_airfile` WHERE `ticket_airfile_id` = ".$ticketEntries['ticket_airfile_id']));
    switch($ticketEntries['adolescence']){
        case 'Child' : $adultFare+= $ticketMaster['basic_cost']; break;
        case 'Adult' : $childFare+=$ticketMaster['basic_cost']; break;
        case 'Infant' : $infantFare+=$ticketMaster['basic_cost']; break;
    }
    $yq_tax += $ticketMaster['yq_tax'];
    $other_tax += $ticketMaster['other_taxes'];
} 
$reflectArray['PAX_INFO'] = $passDetails;
$reflectArray['SECTOR_INFO'] = $sectDetails;
$reflectArray['FARE_INFO'] = array(array('Child' => $adultFare, 'Adult' => $childFare, 'Infant' =>$infantFare, 'yq_tax' => $yq_tax, 'other_tax' =>$other_tax ));
echo json_encode($reflectArray);
?>