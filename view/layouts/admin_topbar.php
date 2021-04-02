<?php
global $app_version;
if(isset($_SESSION['username']) && isset($_SESSION['password']) )
{
    $username = $_SESSION['username'];    
}
?>

<!--******Logo Wrap*****-->
<div class="logo_wrap hidden-xs">
    <a href="<?php echo BASE_URL ?>view/dashboard/dashboard_main.php"><img src="<?php echo $admin_logo_url ?>" /></a>
</div>
<div class="small_logo_wrap visible-xs">
    <a href="<?php echo BASE_URL ?>view/dashboard/dashboard_main.php"><img src="<?php echo $circle_logo_url ?>" /></a>
</div>
<button class="btn btn-sm sidebar_toggle_btn app_btn_out"><i class="fa fa-bars" aria-hidden="true"></i></button>


<!--******Icon Wrap*****-->
<div class="ico_wrap hidden-xs">       
    <ul>
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
