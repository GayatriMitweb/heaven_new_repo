<!--////////////***************************************Actual Form content start**********************************************/////////////////-->
<?php
$tourwise_id = $_POST['tourwise_id'];
$sq_tourwise_det = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));

$tour_id = $sq_tourwise_det['tour_id'];
$tour_group_id = $sq_tourwise_det['tour_group_id'];
$traveler_group_id = $sq_tourwise_det['traveler_group_id'];


$sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$tour_id'");
$row_tour_name = mysql_fetch_assoc($sq_tour_name);
$tour_name = $row_tour_name['tour_name'];

$sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$tour_group_id'");
$row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
$tour_group = date("d-m-Y", strtotime($row_tour_group_name['from_date']))." to ".date("d-m-Y", strtotime($row_tour_group_name['to_date'])); 

?>
<div class="customer_tabs mg_tp_20">

<div class="tabs">
    <ul class="tab-links">
        <li class="active"><a href="#tab1" class="tab1">Personal Information</a></li>
        <li><a href="#tab2" class="tab2">Traveling Information</a></li>
        <li><a href="#tab3" class="tab3">Payment Information</a></li>
    </ul>
 
    <div class="tab-content">
        
        <!--Tab1 Starts Here-->
        <div id="tab1" class="tab active">
            <?php include "booking_information_tab1.php"; ?>
        </div>
        <!--Tab1 Ends Here-->
 
        <!--Tab1 Starts Here-->
        <div id="tab2" class="tab">
            <?php include "booking_information_tab2.php"; ?>
        </div>
        <!--Tab1 Ends Here-->
 
        <!--Tab1 Starts Here-->            
        <div id="tab3" class="tab">
            <?php include "booking_information_tab3.php"; ?>
        </div>
        <!--Tab1 Ends Here-->
        
    </div>
</div>   

</div>                   

<!--////////////***************************************Actual Form content end**********************************************/////////////////-->

<script>
    $('.customer_tabs .tab-links li').click(function(){
        $('.customer_tabs .tab-links li').removeClass('active');
        $(this).addClass('active');
        $('.customer_tabs .tab-content .tab').removeClass('active');
        var class_name = $(this).find('a').attr('class');
        $('.customer_tabs #'+class_name).addClass('active');
    });
</script>
