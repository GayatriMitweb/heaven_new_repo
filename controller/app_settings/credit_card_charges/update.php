<?php 
include_once('../../../model/model.php');
include_once('../../../model/app_settings/credit_card_master.php');

$credit_card = new credit_card;
$credit_card->update();
?>