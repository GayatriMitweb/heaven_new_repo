<?php include "../../../../model/model.php"; ?>
<?php
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];
$traveler_group_id = $_GET['traveler_group_id'];
if($traveler_group_id!='' && $tour_id!='' && $tour_group_id!=''){

$sq = mysql_query("select * from tourwise_traveler_details where tour_id = '$tour_id' and tour_group_id = '$tour_group_id' and id = '$traveler_group_id'");
$row1 = mysql_fetch_assoc($sq);
$tourwise_id = $row1['id'];

$sql = mysql_query("SELECT SUM(amount) as total FROM payment_master where tourwise_traveler_id ='$tourwise_id'  ");
$row = mysql_fetch_array($sql);
$traveling_amount_paid = $row['total'];


$total_amount = $traveling_amount_paid ;
?>
<input type="hidden" id="txt_tour_id" name="txt_tour_id" value="<?php echo $tour_id ?>">
<input type="hidden" id="txt_tour_group_id" name="txt_tour_group_id" value="<?php echo $tour_group_id ?>">
<input type="hidden" id="txt_traveler_group_id" name="txt_traveler_group_id" value="<?php echo $traveler_group_id ?>">
<input type="hidden" id="txt_tourwise_traveler_id" name="txt_tourwise_traveler_id" value="<?php echo $tourwise_id ?>">

<?php include_once('refund_estimate_update.php'); ?>  
<?php } ?>
<script>
$('#refund_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

