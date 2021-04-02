<?php 
include "../../../model/model.php";
$sq = mysql_query("delete from finance_transaction_master");
$sq = mysql_query("delete from bank_cash_book_master");

echo "Entries removed!";
?>