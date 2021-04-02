<?php
include "../../../../../model/model.php";
$image_url = $_POST['image_url'];
$cmp_image_url = $_POST['cmp_image_url'];
?>
<div class="modal fade" id="images_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Image</h4>
      </div>
      <div class="modal-body">    
            <div class="panel panel-default panel-body app_panel_style feildset-panel">
                <div class="row mg_bt_20">
                <?php
                $dir = 'https://itourscloud.com/destination_gallery/b2b_images/cms2/';
                for($i = 1; $i<=40; $i++){
                $image_path = $dir.$i.'.svg';
                $query = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_settings`"));
                $images = json_decode($query['why_choose_us']);
                
                if($cmp_image_url == $image_path){
                    $checked = 'checked';
                }else{
                    $checked = '';
                } ?>
                <div class="c-radioIcon type-image">
                    <input type="radio" id="image_select<?php echo $i; ?>" name="image_check" value="<?php echo $image_path ?>" class="css-checkbox" <?= $checked ?>>
                    <label for="image_select<?php echo $i; ?>" class="iconWrap" >
                        <img src="<?php echo $image_path; ?>" id="image<?php echo $i; ?>" alt="title">
                    </label>
                </div>
                <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn btn-sm btn-success" id="btn_image" onclick="save_image()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
<script>
$('#images_modal').modal('show');
function save_image(){
    var img_arr1 = (function() {  var a = ''; $("input[name='image_check']:checked").each(function() { a += this.value+','; });  return a; })();

    var gallary_arr1 = img_arr1.split(",");
    var length = gallary_arr1.length-1;
    if(length == 0 || length >1){
        error_msg_alert("Please select at least one image!");
        return false;
    }
    var image = gallary_arr1[0];
    $('#images_modal').modal('hide');
    $('#'+'<?= $image_url ?>').val(image);
}
</script>