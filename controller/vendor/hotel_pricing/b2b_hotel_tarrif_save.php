<?php 
include_once('../../../model/model.php');
include_once('../../../model/vendor_login/hotel_pricing/b2b_hotel_tarrif.php');

$vendor_price_save = new vendor_price_save;
$vendor_price_save->hotel_tarrif_save();
?>