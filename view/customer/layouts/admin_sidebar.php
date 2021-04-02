<?php
global $app_version; 
?>
<script src="<?php echo BASE_URL ?>js/script.js"></script>  

<div class="sidebar_inner main_block"> 
    <div id="cssmenu" style="width:100%"> 
        <ul>            	
            <li><a href='<?php echo BASE_URL ?>view/customer/other/dashboard_main.php'><span><i class="fa fa-tachometer"></i>&nbsp;&nbsp;Dashboard</span></a></li>
            <li><a href='<?php echo BASE_URL ?>view/customer/other/customer_feedback/customer_feedback.php'><i class="fa fa-comments-o"></i><span>&nbsp;&nbsp;Customer Feedback</span></a></li>   
            <li><a href='<?php echo BASE_URL ?>view/customer/other/fourth_coming_attractions/fourth_coming_attractions.php'><span><i class="fa fa-newspaper-o"></i>&nbsp;&nbsp;Sightseeing Attractions</span></a></li>
            <li><a href='<?php echo BASE_URL ?>view/customer/other/cancelation_policy/index.php'><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<span>Cancellation Policy</span></a></li>
        </ul>
    </div>
</div><!--/sidebar-wrap-close-->