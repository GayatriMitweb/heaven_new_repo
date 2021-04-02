<?php
global $app_version;
?>

<!--******Logo Wrap*****-->
<div class="logo_wrap hidden-xs">
    <img src="<?php echo $admin_logo_url ?>" />
</div>
<div class="small_logo_wrap visible-xs">
    <img src="<?php echo $small_logo_url ?>" />
</div>
<button class="btn btn-sm sidebar_toggle_btn app_btn_out"><i class="fa fa-bars" aria-hidden="true"></i></button>


<!--******Icon Wrap*****-->
<div class="ico_wrap hidden-xs">
    <ul class="customer_topar_icons">
        <?php topbar_icon_list() ?>        
    </ul>
</div>

<!--******Icon Mobile*****-->
<div class="dropdown ico_wrap_mobile pull-right visible-xs">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <i class="fa fa-cog" aria-hidden="true"></i>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <?php topbar_icon_list() ?>
    
  </ul>
</div>