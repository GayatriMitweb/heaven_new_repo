<?php
include '../../../../../model/model.php';
$image_url = $_POST['image_url'];
$package_id = $_POST['package_id'];
$quotation_id=$_POST['quotation_id'];
$id = $_POST['id'];

$day_url1 = explode(',',$image_url);
$sq_package_program = mysql_query("select * from  package_quotation_program where quotation_id='$quotation_id'");
?>
<h4>Uploaded Images</h4><hr>
<?php
while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
$sq_day_image = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]' and package_id='$package_id'"));
$day_url1 = explode(',',$sq_day_image['image_url']);
$daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
for($count1 = 0; $count1<sizeof($day_url1);$count1++){
    $day_url2 = explode('=',$day_url1[$count1]);
    if($day_url2[0]==$package_id && $day_url2[1]==$row_itinarary['day_count']){
        $daywise_image = $day_url2[2];
        $count = $day_url2[1]; 
        $package_id = $day_url2[0];
    }
}
        ?>
        <div class="col-md-2">
        <div class="gallary-single-image mg_bt_10" style="height:100px;max-height: 100px;overflow:hidden;">
            <img src="<?= $daywise_image ?>" id="<?= $count ?>" width="100%" height="100%">
            <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image(<?=$package_id ?>,<?=$count ?>,'<?=$daywise_image ?>',<?php echo $id; ?>)" title="Remove Image"><i class="fa fa-times" aria-hidden="true"></i></button></span>
        </div>
        <h5 class="text-center no-pad">Day-<?= $row_itinarary['day_count'] ?></h5>
        </div>
<?php  
} ?>