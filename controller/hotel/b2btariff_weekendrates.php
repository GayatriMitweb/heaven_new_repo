<?php 
include_once('../../model/model.php');
include_once('../../model/vendor_login/hotel_pricing/vendor_price_save.php');

$vendor_price_save = new vendor_price_save;
$vendor_price_save->b2btariff_weekend_rates();
?>