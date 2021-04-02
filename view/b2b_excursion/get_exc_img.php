<?php
include_once('../../model/model.php');
$entry_id = $_POST['entry_id'];
if($entry_id != ""){
$query = "select * from excursion_master_images where exc_id='$entry_id'";
$sq_exc_image = mysql_query($query);
while($row_image = mysql_fetch_assoc($sq_exc_image)){
	$newUrl = preg_replace('/(\/+)/','/',$row_image['image_url']); 
    $download_url = BASE_URL.str_replace('../', '', $newUrl);
?>
<div class="col-md-2">
    <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
    <img src="<?php echo $download_url; ?>" id="<?php echo $row_image['entry_id']; ?>" width="100%" height="100%">
    <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image(<?php echo $row_image['entry_id']; ?>,'<?php echo $entry_id; ?>')" title="Remove"><i class="fa fa-times" aria-hidden="true"></i></button></span>
    </div>
</div>
<?php } } ?>