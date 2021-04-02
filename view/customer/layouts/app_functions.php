<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(!isset($_SESSION['login_type'])){
    header("location:".BASE_URL.'view/customer/');   
}
function topbar_icon_list()
{
    global $app_version;
    $customer_idd = $_SESSION['customer_id'];
    $sq_cust = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_idd'"));
    if($sq_cust['type'] == 'Corporate' || $sq_cust['type'] == 'B2B'){
        $cname = $sq_cust['company_name'];
    }else{
        $cname = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    }
    ?>
    <li><span class="logged_user_name" data-original-title="" title=""><?php echo $cname; ?></span></li>
    <li>
        <a class="btn app_btn_out" data-toggle="tooltip" data-placement="bottom" title="Sign Out" href="<?php echo BASE_URL ?>view/customer/index.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="hidden visible-xs">&nbsp;&nbsp;Sign Out</span></a>    
    </li>
    <?php
}
?>