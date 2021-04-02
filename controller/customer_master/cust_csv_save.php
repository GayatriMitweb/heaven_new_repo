<?php 
include_once('../../model/model.php');
include_once('../../model/customer_master.php');

$customer_master = new customer_master;
$customer_master->customer_master_csv_save();
?>