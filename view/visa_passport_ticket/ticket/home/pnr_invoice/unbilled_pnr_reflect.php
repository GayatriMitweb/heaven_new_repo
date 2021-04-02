<?php
include "../../../../../model/model.php";

$pnr = mysql_query("SELECT * FROM `ticket_master_entries_airfile` WHERE `status` = ''");
$count = 1;
$array_s = array();
$temp_arr = array();
// $unsavedAirp = '';
while($rows = mysql_fetch_assoc($pnr)){
    $masterTable = mysql_fetch_assoc(mysql_query("SELECT * FROM `ticket_master_airfile` WHERE `ticket_airfile_id` = ".$rows['ticket_airfile_id']));
    $couponTable = mysql_query("SELECT * FROM `ticket_trip_entries_airfile` WHERE `ticket_airfile_id` = ".$rows['ticket_airfile_id']);
    $trip = '';$travelDate = array();
    while($rowCoupontable = mysql_fetch_assoc($couponTable)){
        $trip .= str_replace(array('(',')'), '',explode('(',$rowCoupontable['departure_city'])[1].' - '.explode('(',$rowCoupontable['arrival_city'])[1].'<br>');
        array_push($travelDate, $rowCoupontable['departure_datetime']);
    }
    
    $temp_arr = array( "data" => array(
        (int)$count,
        '<input class="css-checkbox" id="chk_pnr'. $count .'" type="checkbox"><label class="css-label" for="chk_pnr'.$count++.'"> <label>',
        $rows['gds_pnr'],
        $rows['ticket_no'],
        $rows['first_name'].' '.$rows['middle_name'].' '.$rows['last_name'],
        get_date_user($masterTable['issue_date']),
        rtrim($trip, '<br>'),
        get_datetime_user($travelDate[0]),
        $masterTable['total_cost'],
        $rows['file_type'],
        '<input type="hidden" name="entryId" value="'.$rows['entry_id'].'">',
        ), $bg = "");
        array_push($array_s,$temp_arr); 
   
}
echo json_encode($array_s);	
?>