<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/financial_year/financial_year.php');

$financial_year = new financial_year;
$financial_year->financial_year_update();
?>