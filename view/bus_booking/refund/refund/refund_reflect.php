<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];

$sq_booking = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));

if($booking_id==""){ exit; }
?>

<?php 
if($sq_booking['refund_net_total']!=""){
?>
<?php include_once('refund_sec.php'); ?>
<?php	
}
?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>