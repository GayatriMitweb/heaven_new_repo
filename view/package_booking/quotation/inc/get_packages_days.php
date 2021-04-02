<?php
include "../../../../model/model.php";
$img_count = 0;
$dest_id = $_POST['dest_id'];
$day_count_arr = $_POST['day_count_arr'];
$package_id_arr = $_POST['package_id_arr'];
$sq_tours = mysql_query("select * from custom_package_master where dest_id = '$dest_id' and status!='Inactive'");
?>
<div class="col-md-12 app_accordion mg_tp_10">
  <div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
      <?php
      for($count = 0; $count < sizeof($package_id_arr); $count++){
        $row_tours = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id_arr[$count]'"));
      ?>
        <div class="accordion_content package_content mg_bt_10">
          <div class="panel panel-default main_block">
              <div class="panel-heading main_block" role="tab" id="headingn_<?= $count ?>">
                  <div class="Normal main_block collapsedn" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsen_<?= $count; ?>" aria-expanded="false" aria-controls="collapsen_<?= $count; ?>" id="collapsedn_<?= $count?>">
                    <div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo $row_tours['package_name']; ?></em></span></div>
                  </div>
              </div>
              <div id="collapsen_<?= $count?>" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="headingn_<?= $count?>">
                <div class="panel-body">
                  <div class="col-md-2 no-pad" id="div_list1">
                    <select name="day_names<?= $count ?>" id="day_names<?= $count ?>" class="form-control">
                    <?php 
                    $day_length = $day_count_arr[$count];
                    for($day_count = 1; $day_count <= $day_length; $day_count++){
                      ?>
                      <option value="<?= $day_count ?>"><?= 'Day-'.$day_count?></option>
                    <?php } ?>
                    </select>
                  </div><div class="col-md-2">
                        <input type="button" class="btn btn-sm btnType" id="btn_image_save" onclick="daywise_image_prepare('<?= $package_id_arr[$count] ?>','day_names<?= $count ?>','image_check<?= $count?>')" autocomplete="off" data-original-title="save" title="save" value="Save">
                  </div>
                  <div class="col-md-12 no-pad mg_tp_20">
                  <?php
                  $sq_gallary = mysql_query("select * from gallary_master where dest_id = '$dest_id'");
                        while($row_gallary = mysql_fetch_assoc($sq_gallary)){
                          $img_count++;
                          $url = $row_gallary['image_url'];
                          $pos = strstr($url,'uploads');
                          if ($pos != false){
                              $newUrl1 = preg_replace('/(\/+)/','/',$row_gallary['image_url']);
                              $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
                          }
                          else{
                              $newUrl =  $row_gallary['image_url'];
                          }
                  ?>
                  <div class="col-md-3 col-sm-4">
                    <div class="table-single-image mg_bt_30 mg_bt_10_sm_xs" style="width:100%;">
                      <img src="<?php echo $newUrl; ?>" class="img-responsive" title="<?= $row_gallary['description']?>" style="cursor: pointer;">
                      <span class="img-check-btn">
                        <input type="radio" id="image_select1<?php echo $img_count; ?>" name="image_check<?= $count?>" value="<?php echo $newUrl ?>">
                      </span>
                    </div>
                  </div>
                  <?php }	?>
                  </div>
                </div>
            </div>
          </div>
        </div>
      <?php 
      } ?>
</div>
</div>

<script>
function daywise_image_prepare(package_id,day_name,image_id){

  $('#btn_image_save').button('loading');
  var day = $('#'+day_name).val();
  var pckg_daywise_url = $('#pckg_daywise_url').val();
  //var pckg_img_arr = new Array();

  
  var radioValue = $("input[name="+ image_id +"]:checked").val();
 if(typeof radioValue === 'undefined'){
   error_msg_alert("Select one daywise image!");
   $('#btn_image_save').button('reset');
   return false;
 }
 else{
  pckg_daywise_url += package_id+'='+day+'='+radioValue+',';
  $('#btn_image_save').button('reset');
  msg_alert("Image Saved");
 }
 $('#pckg_daywise_url').val(pckg_daywise_url);
return false;
}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>