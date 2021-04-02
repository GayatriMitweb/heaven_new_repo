<?php
include_once('../../model/model.php');
include_once('../../model/b2b_transfer/transfer_tariff.php');

$transfer_tariff = new transfer_tariff;
$transfer_tariff->vehicle_save();
?>