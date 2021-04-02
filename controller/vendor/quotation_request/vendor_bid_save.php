<?php 
include_once('../../../model/model.php');
include_once('../../../model/vendor/quotation_request/vendor_bid_master.php');

$vendor_bid_master = new vendor_bid_master;
$vendor_bid_master->vendor_bid_save();
?>