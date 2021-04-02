<?php
include '../../../../../model/model.php';
$sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings"));
if($sq_settings != 0){
    $query = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_settings`"));
    $images = json_decode($query['banners']);
?>
    <div class="row mg_bt_20">
    <?php
    for($i=0;$i<sizeof($images);$i++){
        $url = $images[$i]->image_url;
        $pos = strstr($url,'uploads');
        if ($pos != false){
            $newUrl1 = preg_replace('/(\/+)/','/',$images[$i]->image_url); 
            $download_url = BASE_URL.str_replace('../', '', $newUrl1);
        }else{
            $download_url =  $images[$i]->image_url; 
        }
        ?>
        <div class="col-md-2">
            <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
            <input type="hidden" value="<?= $images[$i]->image_url ?>" id="imagel<?=$i?>"/>
                <img src="<?php echo $download_url; ?>" id="<?php echo $images[$i]->banner_count; ?>" width="100%" height="100%">
                <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image('<?php echo $images[$i]->banner_count; ?>')" title="Delete Image" data-toggle="tooltip"><i class="fa fa-times" aria-hidden="true"></i></button></span>
            </div>
        </div>
    <?php } ?>
    </div>
    <input type="hidden" value='<?=json_encode($images)?>' id="banner_uploaded_images"/>
    <input type="hidden" value="<?=sizeof($images)?>" id="banner_uploaded_count"/>
<?php 
}
else{?>
    <input type="hidden" value='' id="banner_uploaded_images"/>
    <input type="hidden" value="0" id="banner_uploaded_count"/>
<?php } ?>
