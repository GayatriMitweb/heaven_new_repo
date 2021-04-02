<?php
include "../../../model/model.php";
$login_id = $_SESSION['login_id'];
$emp_id = $_SESSION['emp_id'];

        $group_booking_arr = array();

        $from_date_filter = $_POST['from_date'];
        $to_date_filter = $_POST['to_date'];

        $query1 = "select * from tourwise_traveler_details where emp_id = '$emp_id'";

        if($from_date_filter!="" && $to_date_filter!=""){
          $from_date_filter = date('Y-m-d', strtotime($from_date_filter));
          $to_date_filter = date('Y-m-d', strtotime($to_date_filter));
          $query1 .= " and date(form_date) between '$from_date_filter' and '$to_date_filter' ";
        }

        $query1 .= " order by date(form_date) asc";
        $sq_group_bookings = mysql_query($query1);

        while($row_group_bookings = mysql_fetch_assoc($sq_group_bookings)){

          $pass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]'"));
          $cancelpass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]' and status='Cancel'"));
          $status="";
          if($row_group_bookings['tour_group_status']=="Cancel"){
            $status="Cancel";
          }
          else if($pass_count == $cancelpass_count){
              $status="Cancel";
          }
          else{ $status= ''; }

          $date = $row_group_bookings['form_date'];
          $yr = explode("-", $date);
          $year =$yr[0];

          $tourwise_traveler_id = $row_group_bookings['id'];      
          $emp_id = $row_group_bookings['emp_id'];      
          $tour_id = $row_group_bookings['tour_id'];

          $tour_group_id = $row_group_bookings['tour_group_id'];
          $booking_date = $row_group_bookings['form_date'];
          $tour_type = "Group Tour";
          $file_no = get_group_booking_id($row_group_bookings['id'],$year);
          $total_tour_fee = $row_group_bookings['total_tour_fee']+ $row_group_bookings['total_travel_expense'];
          $customer_id = $row_group_bookings['customer_id'];

          $sq_customer = mysql_fetch_assoc( mysql_query("select first_name, last_name from customer_master where customer_id='$customer_id'") );
          $booker_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];

          $sq_tour = mysql_fetch_assoc( mysql_query("select tour_name from tour_master where tour_id='$tour_id'") );
          $tour_name = $sq_tour['tour_name'];

          $sq_tour_group = mysql_fetch_assoc( mysql_query("select from_date, to_date from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'") );
          $tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date']));


          $array1 = array(

                  'booking_date' => $booking_date,

                  'other' => array(

                          'booking_id' => $tourwise_traveler_id,

                          'emp_id' => $emp_id,

                          'booker_name' => $booker_name,

                          'tour_type' => $tour_type,

                          'file_no' => $file_no,

                          'tour_name' => $tour_name,

                          'tour_date' => $tour_group,    

                          'tour_cost_total' => $total_tour_fee,
                          'status' => $status

                        )

                   );



          array_push($group_booking_arr, $array1);
        }

        $package_booking_arr = array();

        $from_date_filter = $_POST['from_date'];
        $to_date_filter = $_POST['to_date'];

        $query2 = "select * from package_tour_booking_master where emp_id ='$emp_id' ";
        if($from_date_filter!="" && $to_date_filter!=""){
          $from_date_filter = date('Y-m-d', strtotime($from_date_filter));
          $to_date_filter = date('Y-m-d', strtotime($to_date_filter));
          $query2 .= " and date(booking_date) between '$from_date_filter' and '$to_date_filter' ";
        }
        $query2 .= " order by date(booking_date) asc ";
        $sq_package_booking = mysql_query($query2);

        while($row_package_booking = mysql_fetch_assoc($sq_package_booking)){

          $booking_id = $row_package_booking['booking_id'];
          $emp_id = $row_package_booking['emp_id'];
          $tour_name = $row_package_booking['tour_name'];

          $pass_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]'"));
          $cancle_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]' and status='Cancel'"));
          if($pass_count==$cancle_count){
              $status="Cancel";
          }else{
              $status="";
          }

          $date = $row_package_booking['booking_date'];
          $yr = explode("-", $date);
          $year =$yr[0];

          $tour_date = date('d-m-Y', strtotime($row_package_booking['tour_from_date']));

          $booking_date = $row_package_booking['booking_date'];
          $tour_type = "Package Tour";

          $file_no = get_package_booking_id($row_package_booking['booking_id'],$year);
          $tour_cost_total = $row_package_booking['actual_tour_expense'] + $row_package_booking['total_travel_expense'];

          $customer_id = $row_package_booking['customer_id'];
          $sq_customer = mysql_fetch_assoc( mysql_query("select first_name, last_name from customer_master where customer_id='$customer_id'") );
          $booker_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];

          $array1 = array(
                  'booking_date' => $booking_date,
                  'other' => array(
                          'booking_id' => $booking_id,
                          'emp_id' => $emp_id,
                          'booker_name' => $booker_name,
                          'tour_type' => $tour_type,
                          'file_no' => $file_no,             
                          'tour_name' => $tour_name,
                          'tour_date' => $tour_date,   
                          'tour_cost_total' => $tour_cost_total,
                          'status' => $status
                        )
                   );
          array_push($package_booking_arr, $array1);  
        }
        if($tour_type_filter=="Group Tour"){
          $booking_array = $group_booking_arr;
        }
        if($tour_type_filter=="Package Tour"){
          $booking_array = $package_booking_arr;
        }
        if($tour_type_filter==""){
          $booking_array = array_merge($group_booking_arr,$package_booking_arr);
          usort($booking_array, 'dateSort');
        }
?>
<div class="table-responsive">

                      <table class="table table-hover" style="margin: 0 !important;border: 0;padding: 0 !important;">

                        <thead>

                          <tr class="table-heading-row">

                            <th>S_No.</th>

                            <th>Customer_Name</th>

                            <th>Booking_ID</th>

                            <th>Booking_Date</th>

                            <th>Selling_Amt.</th>

                            <th>Incentive_Amt.</th>

                          </tr>

                        </thead>

                        <tbody>

                        <?php 

                          foreach($booking_array as $booking_array_item){
                            $incentive_total = 0; 
                            $other_data_arr = $booking_array_item['other'];
                            $emp_id = $other_data_arr['emp_id'];

                            if($other_data_arr['tour_type']=="Group Tour"){ $row_bg = "warning"; }
                            else if($other_data_arr['tour_type']=="Package Tour"){ $row_bg = "info"; }
                            else if($other_data_arr['status']=='Cancel'){ $row_bg = "danger"; }
                            else{$row_bg = '';}

                            if($other_data_arr['tour_type']=="Group Tour"){
                              $tourwise_traveler_id = $other_data_arr['booking_id'];
                              $incentive_count = mysql_num_rows(mysql_query("select * from booker_incentive_group_tour where tourwise_traveler_id='$tourwise_traveler_id' and emp_id='$emp_id'"));
                              $sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_incentive_group_tour where tourwise_traveler_id='$tourwise_traveler_id' and emp_id='$emp_id'"));
                              $incentive_total = $incentive_total + $sq_incentive['basic_amount'];
                            }
                            if($other_data_arr['tour_type']=="Package Tour"){
                              $booking_id = $other_data_arr['booking_id'];
                              $incentive_count = mysql_num_rows(mysql_query("select * from booker_incentive_package_tour where booking_id='$booking_id' and emp_id='$emp_id'"));
                              $sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_incentive_package_tour where booking_id='$booking_id' and emp_id='$emp_id'"));

                              $incentive_total = $incentive_total + $sq_incentive['basic_amount'];
                            }

                        ?>

                            <tr class="<?= $row_bg ?>">

                              <td><?= ++$count ?></td>

                              <td><?= $other_data_arr['booker_name'] ?></td>

                              <td><?= $other_data_arr['file_no'] ?></td>

                              <td><?= date('d-m-Y', strtotime($booking_array_item['booking_date'])) ?></td>

                              <td><?php echo number_format($other_data_arr['tour_cost_total'],2); ?></td>

                              <td><?php echo number_format($incentive_total,2); ?></td>
                            </tr>

                            </tbody>

                            <?php } ?>

                      </table>

                    </div>