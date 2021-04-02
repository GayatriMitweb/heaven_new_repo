<?php
include '../../../../../model/model.php';
$sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings"));
if($sq_settings != 0){
    $query = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_settings`"));
    $amazing_dest_ideas = json_decode($query['amazing_dest_ideas']);
    for($i=0;$i<sizeof($amazing_dest_ideas[0]->icon_list);$i++){ ?>
        <div class="row mg_bt_20">
            <div class="col-md-2">
                <input class="btn btn-sm btn-warning" style="padding-left: 10px !important;" type="button" value="Icon Uploaded" id="select_image<?=$i?>" onclick="get_icons('image<?=($i)?>');"/>
                <input type="hidden" title="Icon Uploaded" value="<?= $amazing_dest_ideas[0]->icon_list[$i]->icon ?>" id="image<?=($i)?>"/>
            </div>
            <div class="col-md-3 col-sm-4">
                <input type="text" id="title<?=$i?>" placeholder="Enter title" title="Enter title" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,20);" value="<?php echo $amazing_dest_ideas[0]->icon_list[$i]->title; ?>">
            </div>
            <div class="col-md-7 col-sm-4">
                <textarea id="description<?=$i?>" placeholder="Enter Description" title="Enter Description" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,60);" rows="1"><?php echo $amazing_dest_ideas[0]->icon_list[$i]->description; ?></textarea>
            </div>
        </div>
    <?php } ?>
    </div>
    <input type="hidden" value='<?=json_encode($amazing_dest_ideas[0])?>' id="uploaded_images"/>
    <input type="hidden" value="<?=sizeof($amazing_dest_ideas[0]->icon_list)?>" id="uploaded_count"/>
<?php 
}
else{?>
    <input type="hidden" value='0' id="uploaded_images"/>
    <input type="hidden" value="0" id="uploaded_count"/>
<?php } ?>
<script>
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
