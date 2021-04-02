<?php
include "../../../model/model.php";
$format = $_POST['format'];
if($format == 2){
  $count = 129;
  $dir = 'https://itourscloud.com/quotation_format_images/Landscape-Standard-Creative/';
}
else if($format == 3){ $count = 129; $dir = 'https://itourscloud.com/quotation_format_images/Landscape-Standard-Creative/';
}
else if($format == 1){ $count = 10; $dir = 'https://itourscloud.com/quotation_format_images/Portrait-Standard/';
}
else if($format == 5){ $count = 52; $dir = 'https://itourscloud.com/quotation_format_images/Portrait-Advanced/';
}
else if($format == 6){ $count = 98; $dir = 'https://itourscloud.com/quotation_format_images/Landscape-Advanced/';
}
else{
  $count = 65;
  $dir = 'https://itourscloud.com/quotation_format_images/Portrait-Creative/';
}
for($i = 1; $i<=$count; $i++){
  $image_path = $dir.$i.'.jpg';
  $sq_setting = mysql_num_rows(mysql_query("select * from app_settings where quot_format='$format' and quot_img_url='$image_path'"));
  if($sq_setting>0){
    $checked = 'checked';
  }else{
    $checked = '';
  }
?>
<div class="gallary-image">
    <div class="col-sm-3">
      <div class="gallary-single-image mg_bt_30 mg_bt_10_sm_xs" style="width: 100%;">
          <img src="<?php echo $dir.$i.'.jpg'; ?>" id="image<?php echo $i; ?>" alt="title" class="img-responsive">
          <span class="img-check-btn">
            <input type="radio" id="image_select<?php echo $i; ?>" name="image_check" value="<?php echo $dir.$i.'.jpg' ?>" <?= $checked ?>>
          </span>
          <div class="table-image-btns">
            <ul style="margin-left: -40%;">
              <span style="color: #fff; "><?php echo $sq_gal['description'];?></span>
            </ul>
          </div>
      </div>
    </div>
</div>
<?php } ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>