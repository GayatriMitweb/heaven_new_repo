<?php
include "../../../../../model/model.php";
$dest_id = $_POST['dest_id'];
$image_url = $_POST['image_url'];
$cmp_image_url = $_POST['cmp_image_url'];
if($dest_id != '') { 
      $query = " select * from gallary_master where dest_id = '$dest_id'";
}
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
                <div class="row">
                <div class="col-md-12">
                    <?php
                    $count = 0;
                    $sq_gallary = mysql_query($query);
                    while($row_gallary = mysql_fetch_assoc($sq_gallary)){
                        $count++;
                            $url = $row_gallary['image_url'];
                            $pos = strstr($url,'uploads');
                            $entry_id =$row_gallary['entry_id'];
                            $sq_gal =  mysql_fetch_assoc(mysql_query("select * from gallary_master where entry_id = '$entry_id'"));
                            if ($pos != false)   {
                                $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']); 
                                $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                            }
                            else{
                                $newUrl =  $row_gallary['image_url']; 
                            }
                            if($cmp_image_url == $newUrl){
                                $checked = 'checked';
                            }else{
                                $checked = '';
                            }
                        ?>
                        <div class="c-radioIcon type-image">
                            <input class="css-checkbox" name="image_check" id="image_select<?php echo $count; ?>" type="radio" value="<?php echo $newUrl; ?>" <?= $checked ?>>
                            <label for="image_select<?php echo $count; ?>" class="iconWrap" >
                            <img src="<?php echo $newUrl; ?>" id="image<?php echo $count; ?>" alt="title">
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
  </div>
<script>
$('#images_modal').modal('show');
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
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