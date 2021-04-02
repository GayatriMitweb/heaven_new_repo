<?php 
include_once('../../../../model/model.php');

$customer_id = $_SESSION['customer_id'];
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
    
    <table class="table table-hover mg_bt_0 cust_table" style="padding: 0 !important">
        <thead>
            <tr class="table-heading-row">
                <th>Sr. No</th>
                <th>Tour Name</th> 
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0; 
            $sq = mysql_query("select * from customer_feedback_master where customer_id='$customer_id'");
            while($row = mysql_fetch_assoc($sq)){
                $booking_type = $row['booking_type'];
                $booking_id = $row['booking_id'];
                if($booking_type=="Group Booking"){ 
                $query = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$booking_id'"));  
                    $sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$query[tour_id]'");
                    $row_tour_name = mysql_fetch_assoc($sq_tour_name);
                    $tour_name = $row_tour_name['tour_name'];

                }
                elseif($booking_type=="Package Booking"){
                $query = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
                          $tour_name = $query['tour_name'];
                     
                    } 
                ?>
                <tr>
                    <td><?= ++$count ?></td>
                    <td><?= $tour_name ?></td>
                    <td>
                    <button class="btn btn-info btn-sm" onclick="view_modal(<?= $row['feedback_id'] ?>)" title="View Information"><i class="fa fa-eye"></i></button>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

</div> </div> </div>