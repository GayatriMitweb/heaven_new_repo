<?php 

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(!isset($_SESSION['vendor_login'])){
    header("location:".BASE_URL.'view/vendor_login/');   
}
function topbar_icon_list()
{
    $username = $_SESSION['username'];
    global $app_version;
    ?>
    <li><span><?php echo $username; ?></span></li>
    <li style="line-height: 56px;">
        <a class="btn app_btn_out" href="<?php echo BASE_URL ?>view/vendor_login/index.php" data-toggle="tooltip" style="padding-top: 7px;" title="Sign out" data-placement="bottom"><i class="fa fa-power-off"></i><pre class="xs_show">Sign Out</pre></a>
        <input type="hidden" id="login_id1" name="login_id1" value="<?= $login_id ?>">   
    </li> 
    <?php
}
?>
