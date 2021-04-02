<?php
include_once('../../../../model/model.php');
$hotel_name = $_POST['hotel_name'];
if($hotel_name != ""){
$query = "select * from hotel_vendor_images_entries where 1 ";
	$query .= " and hotel_id='$hotel_name'";
}
$sq_hotel_image = mysql_query($query);
while($row_image = mysql_fetch_assoc($sq_hotel_image)){
	$newUrl = preg_replace('/(\/+)/','/',$row_image['hotel_pic_url']); 
    $download_url = BASE_URL.str_replace('../', '', $newUrl);
?>
<div class="col-md-2">
    <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
        <img src="<?php echo $download_url; ?>" id="<?php echo $row_image['id']; ?>" width="100%" height="100%">
        <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image(<?php echo $row_image['id']; ?>,'<?php echo $hotel_name; ?>')" title="Remove"><i class="fa fa-times" aria-hidden="true"></i></button></span>
    </div>
</div>
<?php } ?>