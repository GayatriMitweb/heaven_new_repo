<?php 
include_once('../../../model/model.php');
include_once('../../../model/finance_master/reports/profit_loss_transfer.php');

$total_purchase1 = $_POST['total_purchase1'];
$profit_loss = $_POST['profit_loss'];
$today_date = $_POST['today_date'];
$branch_admin_id = $_POST['branch_admin_id'];

$save_master = new transaction_master;
$save_master->transaction_save('Profit & Loss A/c','1','',$total_purchase1,$today_date,'Being Profit Loss transferred to Capital','165',$profit_loss,'','',$branch_admin_id,'');
?>