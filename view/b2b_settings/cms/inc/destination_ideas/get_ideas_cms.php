<?php
include '../../../../../model/model.php';
$ideas_count = $_POST['ideas_count'];
?>
<?php
for($i=1;$i<=$ideas_count;$i++){
    ?>
    <div class="row mg_bt_20">
        <div class="col-md-2">
            <input class="btn btn-sm btn-danger" style="padding-left: 10px !important;" type="button" value="Select Icon" id="select_image" onclick="get_icons('imagel<?=($i)?>');"/>
            <input type="hidden" id="imagel<?=($i)?>" title="Upload Icon"/>
        </div>
        <div class="col-md-3 col-sm-4">
            <input type="text" id="titlel<?=($i)?>" placeholder="Enter title" title="Enter title" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,20);" value="<?php echo $amazing_dest_ideas[0]->title; ?>"/>
        </div>
        <div class="col-md-7 col-sm-4">
            <textarea id="descriptionl<?=($i)?>" placeholder="Enter Description" title="Enter Description" data-toggle="tooltip" class="form-control" onchange="validate_char_size(this.id,60);" rows="1"><?php echo $amazing_dest_ideas[0]->description; ?></textarea>
        </div>
    </div>
    <?php } ?>
<script>
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>