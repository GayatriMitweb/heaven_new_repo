<?php
include "../../../../../model/model.php";
$image_url = $_POST['image_url'];
$cmp_image_url = $_POST['cmp_image_url'];
$dest_ideas_icon = array('itours-climbing-sport','itours-sun-umbrella','itours-balloon','itours-love','itours-medicaltour','itours-pilgrimtours','itours-watersports','itours-foresttours','itours-educationtours','itours-cyclingtours','itours-binoculars','itours-agriculturetour','itours-adventuretours');
?>
<div class="modal fade" id="images_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Icon</h4>
      </div>
      <div class="modal-body">    
            <div class="panel panel-default panel-body app_panel_style feildset-panel">
                    <?php
                    for($i=0;$i<sizeof($dest_ideas_icon);$i++){
                        if($cmp_image_url == $dest_ideas_icon[$i]){
                            $checked = 'checked';
                        }else{
                            $checked = '';
                        }
                        ?>
                        <div class="c-radioIcon">
                            <input class="css-checkbox" name="image_check" id="image_select<?php echo $i; ?>" type="radio" value="<?php echo $dest_ideas_icon[$i]; ?>" <?= $checked ?>>
                            <label class="iconWrap" for="image_select<?php echo $i; ?>">
                                <i class="icon <?= $dest_ideas_icon[$i]?>"></i>
                            </label>
                        </div>
                    <?php } ?>   
                <div class="row mg_tp_20">
                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-sm btn-success" id="btn_image" onclick="save_image()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
                    </div>
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