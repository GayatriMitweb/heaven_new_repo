<?php
include '../../../../../model/model.php';
$sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings"));
if($sq_settings != 0){
    $query = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_settings`"));
    $images = json_decode($query['why_choose_us']);
?>
    <div class="container-fluid">
        <div class="row mg_bt_20">
        <?php for($i=0;$i<5;$i++){
                $url = $images[$i]->image_url;
                $pos = strstr($url,'uploads');
                if ($pos != false){
                    $newUrl1 = preg_replace('/(\/+)/','/',$images[$i]->image_url); 
                    $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                }else{
                    $newUrl =  $images[$i]->image_url; 
                }
                $button_text = ($newUrl!='')?'Image Uploaded':'Select Image';
                $button_class = ($newUrl!='')?'btn-warning':'btn-danger';
                ?>
                <div class="row mg_bt_20">
                    <div class="col-md-2">
                        <input class="btn btn-sm <?= $button_class?>" style="padding-left: 10px !important;" type="button" value="<?= $button_text?>" id="select_image" onclick="get_why_choose_images('imagel<?=$i?>');" title="<?=$button_text?>" data-toggle="tooltip"/>
                        <input type="hidden" value="<?= $newUrl ?>" id="imagel<?=$i?>"/>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <input type="text" id="titlel<?=$i?>" placeholder="Enter Title" title="Enter Title" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,40);" value="<?php echo $images[$i]->title; ?>"/>
                    </div>
                    <div class="col-md-6 col-sm-4">
                        <textarea id="descriptionl<?=$i?>" placeholder="Enter Descriprion" title="Enter Description" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,85);"><?php echo $images[$i]->description; ?></textarea>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="image_modal"></div>
<?php } ?>
<script src="cms/inc/why_choose_us/index.js"></script>
<script>
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
