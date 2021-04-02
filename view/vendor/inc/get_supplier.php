<?php include "../../../model/model.php";
$supplier = $_POST['supplier'];
$type = $_POST['type'];

if($type == 'Hotel Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`hotel_name` FROM `hotel_master` WHERE `hotel_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['hotel_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Car Rental Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`vendor_name` FROM `car_rental_vendor` WHERE `vendor_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['vendor_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Cruise Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`company_name` FROM `cruise_master` WHERE `vendor_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['company_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'DMC Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`company_name` FROM `dmc_master` WHERE `dmc_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['company_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Excursion Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`vendor_name` FROM `site_seeing_vendor` WHERE `vendor_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['vendor_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Insurance Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `vendor_name` FROM `insuarance_vendor` WHERE `vendor_id` = '.$supplier));
    $splitString = $vendorInfo['vendor_name'];
}
else if($type == 'Other Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`vendor_name` FROM `other_vendors` WHERE `vendor_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['vendor_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Passport Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `vendor_name` FROM `passport_vendor` WHERE `vendor_id` = '.$supplier));
    $splitString = $vendorInfo['vendor_name'];
}
else if($type == 'Ticket Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `vendor_name` FROM `ticket_vendor` WHERE `vendor_id` = '.$supplier));
    $splitString = $vendorInfo['vendor_name'];
}
else if($type == 'Train Ticket Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `vendor_name` FROM `train_ticket_vendor` WHERE `vendor_id` = '.$supplier));
    $splitString = $vendorInfo['vendor_name'];
}
else if($type == 'Transport Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `city_id`,`transport_agency_name` FROM `transport_agency_master` WHERE `transport_agency_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['transport_agency_name'].' ('.$cityName['city_name'].')';
}
else if($type == 'Visa Vendor'){
    $vendorInfo = mysql_fetch_assoc(mysql_query('SELECT `vendor_name` , `city_id` FROM `visa_vendor` WHERE `vendor_id` = '.$supplier));
    $cityName = mysql_fetch_assoc(mysql_query('SELECT `city_name` FROM `city_master` WHERE `city_id` = '.$vendorInfo['city_id']));
    $splitString = $vendorInfo['vendor_name'].' ('.$cityName['city_name'].')';
}
else $splitString = '';

echo $splitString;
?>