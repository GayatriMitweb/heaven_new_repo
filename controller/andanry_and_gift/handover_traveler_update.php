<?php 
include "../../model/model.php"; 
include "../../model/andanry_and_gift.php"; 
?>
<?php
$traveler_id = $_POST['traveler_id'];
$type = $_POST['type'];

$andanry_and_gift = new andanry_and_gift();
if($type == "adnary")
{

	$andanry_and_gift->adnary_handover_update($traveler_id);

}
if($type == "gift")
{
	$andanry_and_gift->gift_handover_update($traveler_id);
}
?>