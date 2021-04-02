<?php include "../../model/model.php"; ?>
<?php
  $payment_id = $_POST['payment_id'];  

  $sq_payment = mysql_fetch_assoc(mysql_query("select date from payment_master where payment_id='$payment_id'"));

  echo date('d-m-Y', strtotime($sq_payment['date']));
  
?>
