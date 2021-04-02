<?php 
$login_id = $_SESSION['login_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];

//**Enquiries
$assigned_enq_count = mysql_num_rows(mysql_query("select enquiry_id from enquiry_master where assigned_emp_id='$emp_id' and status!='Disabled' and financial_year_id='$financial_year_id'"));

$converted_count = 0;
$closed_count = 0;
$followup_count = 0;
$infollowup_count=0;

$sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$emp_id' and financial_year_id='$financial_year_id'");
	while($row_enq = mysql_fetch_assoc($sq_enquiry)){
		$sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
		if($sq_enquiry_entry['followup_status']=="Dropped"){
			$closed_count++;
		}
		if($sq_enquiry_entry['followup_status']=="Converted"){
			$converted_count++;
		}
		if($sq_enquiry_entry['followup_status']=="Active"){
			$followup_count++;
    }
		if($sq_enquiry_entry['followup_status']=="In-Followup"){
      $infollowup_count++;
    }
	}


?>
<div class="app_panel"> 
<div class="dashboard_panel panel-body">
      <div class="dashboard_widget_panel dashboard_widget_panel_first main_block mg_bt_25">
            <div class="row">
              <div class="col-md-6">
                <div class="dashboard_widget main_block mg_bt_10_xs">
                  <div class="dashboard_widget_title_panel main_block widget_red_title" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                    <div class="dashboard_widget_icon">
                      <i class="fa fa-bullseye" aria-hidden="true"></i>
                    </div>
                    <div class="dashboard_widget_title_text">
                      <h3>Leads</h3>
                      <p>Total Leads Summary</p>
                    </div>
                  </div>
                  <div class="dashboard_widget_conetent_panel main_block">
                  <div class="col-md-12">
                     
                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding: 0;">
                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $assigned_enq_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_blue_text">Total</span>
                        </div>
                      </div>

                      <div class="col-sm-2" style="border-right: 1px solid #e6e4e5;padding: 0;">
                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $followup_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_yellow_text">Active</span>
                        </div>
                      </div>
                      <div class="col-sm-3" style="border-right: 1px solid #e6e4e5;padding: 0;">
                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $infollowup_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_gray_text">In-Followup</span>
                        </div>
                      </div>
                      <div class="col-sm-3" style="border-right: 1px solid #e6e4e5;padding: 0;">
                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $converted_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_green_text">Converted</span>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="dashboard_widget_single_conetent">
                          <span class="dashboard_widget_conetent_amount"><?php echo $closed_count; ?></span>
                          <span class="dashboard_widget_conetent_text widget_red_text">Dropped</span>
                        </div>
                      </div>
                    </div>  
                    </div>
                    </div>  
              </div>
              <?php 
              $total_tour_fee = 0; $incentive_total = 0;
              $total_forex_cost = 0;  $total_visa_cost = 0;
              $total_train_cost = 0;  $total_ticket_cost = 0;
              $total_pass_cost = 0;   $total_misc_cost = 0;
              $total_hotel_cost = 0;  $total_car_cost = 0;
              $total_exc_cost = 0;    $total_bus_cost = 0;
              $package_tour_cost = 0; $grp_tour_cost = 0;
              $inc_amt=0;
              $a_date = date('Y-m-d');
             
              $last_day_this_month =  date("Y-m-t", strtotime($a_date));
              
              $first_day_this_month= date("Y-m-1", strtotime($a_date));
              
              $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$emp_id'"));
              $cur_date= date('Y/m/d H:i:s');
              $search_form = date('Y-m-01 H:i:s',strtotime($cur_date));
              $search_to =  date('Y-m-t H:i:s',strtotime($cur_date));
              
              //Completed Target                
              $sq_group_bookings = mysql_query("select * from tourwise_traveler_details where emp_id = '$emp_id' and financial_year_id='$financial_year_id' and (form_date between '$search_form' and '$search_to')");
              while($row_group_bookings = mysql_fetch_assoc($sq_group_bookings)){

                $pass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]'"));
                $cancelpass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_group_bookings[id]' and status='Cancel'"));
                if($row_group_bookings['tour_group_status']!="Cancel" && $pass_count!=$cancelpass_count){
                  $total_tour_fee = $total_tour_fee + $row_group_bookings['total_tour_fee'] + $row_group_bookings['total_travel_expense'];
                }
              }

              $sq_package_booking = mysql_query("select * from package_tour_booking_master where emp_id ='$emp_id' and financial_year_id='$financial_year_id' and (booking_date between '$search_form' and '$search_to')");
              while($row_package_booking = mysql_fetch_assoc($sq_package_booking)){
                $pass_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]'"));
			          $cancle_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_package_booking[booking_id]' and status='Cancel'"));
                if($pass_count!=$cancle_count){
                  $total_tour_fee = $total_tour_fee + $row_package_booking['actual_tour_expense'] + $row_package_booking['total_travel_expense'];
                }
              }

              // Incentive
                            
              $sql_inc =mysql_query("select * from booker_sales_incentive where emp_id='$emp_id' and financial_year_id='$financial_year_id' and booking_date<='$last_day_this_month' and booking_date>='$first_day_this_month' ");
              while($row =mysql_fetch_assoc($sql_inc)){
                  $inc_amt = $inc_amt + $row['incentive_amount'];
              }

              $sq= mysql_query("select * from package_tour_booking_master where emp_id='$emp_id' and booking_date<='$last_day_this_month' and booking_date>='$first_day_this_month' and tour_status != 'Cancel' and financial_year_id='$financial_year_id'");
                
                while($sq_package = mysql_fetch_assoc($sq)){
                    $tour_cost = $sq_package['total_travel_expense']+$sq_package['actual_tour_expense'];
                    $package_tour_cost = $package_tour_cost + $tour_cost;
                }
                $query1 = mysql_query("select * from tourwise_traveler_details where emp_id = '$emp_id' and tour_group_status != 'Cancel' and  from_date<='$last_day_this_month' and from_date>='$first_day_this_month' and financial_year_id='$financial_year_id'");
                while($row_group_bookings = mysql_fetch_assoc($query1)){
                    $booking_amount = $row_group_bookings['total_travel_expense'] + $row_group_bookings['total_tour_fee'];
                    $grp_tour_cost = $package_tour_cost + $booking_amount;
                }
               $sq_bus = mysql_query("select * from bus_booking_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'"); 
              //  echo $sq_bus;   
                while($sq_total_amount = mysql_fetch_assoc($sq_bus)){
                    $total_exp_amount = $sq_total_amount['net_total'];
                    $total_bus_cost = $total_bus_cost+$total_exp_amount;
                }
                $sq_exc=mysql_query("select * from excursion_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_exc)){
                    $total_exp_amount = $sq_total_amount['exc_total_cost'];
                    $total_exc_cost = $total_exc_cost+$total_exp_amount;
                }
                $sq_car = mysql_query("select * from car_rental_booking where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_car)){
                    $total_exp_amount = $sq_total_amount['total_fees'];
                    $total_car_cost = $total_car_cost +  $total_exp_amount;
                }
                $sq_hotel = mysql_query("select * from hotel_booking_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_hotel )){
                    $total_exp_amount = $sq_total_amount['total_fee'];
                    $total_hotel_cost = $total_hotel_cost +  $total_exp_amount;
                }
                $sq_misc = mysql_query("select * from miscellaneous_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while( $sq_total_amount = mysql_fetch_assoc($sq_misc)){
                    $total_exp_amount = $sq_total_amount['misc_total_cost'];
                    $total_misc_cost = $total_misc_cost +  $total_exp_amount;
                }
                $sq_pass = mysql_query("select * from passport_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_pass)){
                    $total_exp_amount = $sq_total_amount['passport_total_cost'];
                    $total_pass_cost = $total_pass_cost +  $total_exp_amount;
                }
                $sq_ticket = mysql_query("select * from ticket_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_ticket)){
                    $total_exp_amount = $sq_total_amount['ticket_total_cost'];
                    $total_ticket_cost = $total_ticket_cost +  $total_exp_amount;
                }
                $sq_train = mysql_query("select * from train_ticket_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_train)){
                    $total_exp_amount = $sq_total_amount['net_total'];
                    $total_train_cost = $total_train_cost +  $total_exp_amount;
                }
                $sq_visa = mysql_query("select * from visa_master where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                while($sq_total_amount = mysql_fetch_assoc($sq_visa)){
                    $total_exp_amount = $sq_total_amount['visa_total_cost'];
                    $total_visa_cost = $total_visa_cost +  $total_exp_amount;
                }
                $sq_forex = mysql_query("select * from forex_booking_master
                    where emp_id='$emp_id' and created_at<='$last_day_this_month' and created_at>='$first_day_this_month'  and financial_year_id='$financial_year_id'");
                    while($sq_total_amount = mysql_fetch_assoc($sq_forex)){
                        $total_exp_amount = $sq_total_amount['net_total'];
                        $total_forex_cost = $total_forex_cost +  $total_exp_amount;
                    }
                   
                $ince_amount= $total_forex_cost+$total_visa_cost+$total_train_cost+$total_ticket_cost+$total_pass_cost+$total_misc_cost+$total_hotel_cost+$total_car_cost+$total_exc_cost+$total_bus_cost+$package_tour_cost+$grp_tour_cost;
               $target = ($sq_emp['target']!='')?$sq_emp['target']:'0';
              
              
              ?>
              <div class="col-md-6">
                <div class="dashboard_widget main_block">
                  <div class="dashboard_widget_title_panel main_block widget_purp_title" onclick="window.open('<?= BASE_URL ?>view/booker_incentive/booker_incentive.php', 'My Window');">
                    <div class="dashboard_widget_icon">
                      <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    </div>
                    <div class="dashboard_widget_title_text">
                      <h3>achievements</h3>
                      <p>Total Achievements Summary</p>
                    </div>
                  </div>
                  <div class="dashboard_widget_conetent_panel main_block">
                    <div class="col-sm-4" style="border-right: 1px solid #e6e4e5">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($target,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_blue_text">Target</span>
                      </div>
                    </div>
                    <div class="col-sm-4" style="border-right: 1px solid #e6e4e5">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($ince_amount,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_green_text">Completed</span>
                      </div>
                    </div>
                    <div class="col-sm-4 last_block">
                      <div class="dashboard_widget_single_conetent">
                        <span class="dashboard_widget_conetent_amount"><?php echo number_format($inc_amt,2); ?></span>
                        <span class="dashboard_widget_conetent_text widget_yellow_text">Incentives</span>
                      </div>
                    </div>
                  </div>  
                </div>
              </div>
      </div>
   </div>

   <!-- dashboard_tab -->
   <div id="id_proof2"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_tab text-center main_block">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs responsive" role="tablist">
                  <li role="presentation" class="active"><a href="#enquiry_tab" aria-controls="enquiry_tab" role="tab" data-toggle="tab">Todays Followups</a>
                  <li role="presentation" ><a href="#oncoming_tab" aria-controls="oncoming_tab" role="tab" data-toggle="tab">Ongoing Tours</a></li>
                  <li role="presentation"><a href="#upcoming_tab" aria-controls="upcoming_tab" role="tab" data-toggle="tab">Upcoming Tours</a></li>
                  <li role="presentation"><a href="#task_tab" aria-controls="task_tab" role="tab" data-toggle="tab">Task</a></li>
                  <li role="presentation"><a href="#incentive_tab" aria-controls="incentive_tab" role="tab" data-toggle="tab">Incentive</a></li></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content responsive main_block">
                    <!-- Ongoing FIT Tours -->
                    <div role="tabpanel" class="tab-pane " id="oncoming_tab">
                    <?php 
                    $count = 1;
                    $today = date('Y-m-d');
                    $today1 = date('Y-m-d H:i:s');              
                    ?>
                    <div class="dashboard_table dashboard_table_panel main_block">
                      <div class="row text-left">
                        
                        <div class="col-md-12">
                          <div class="dashboard_table_body main_block">
                            <div class="col-md-12 no-pad table_verflow"> 
                              <div class="table-responsive">
                                <table class="table table-hover" style="margin: 0 !important;border: 0;">
                                  <thead>
                                    <tr class="table-heading-row">
                                      <th>S_No.</th>
                                      <th>Tour_Type</th>
                                      <th>Tour_Name</th>
                                      <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                      <th>Customer_Name</th>
                                      <th>Mobile</th>
                                      <th>Owned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                      <th>Client_Feedback</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                    $query1 = "select * from package_tour_booking_master where tour_status!='Disabled' and financial_year_id='$financial_year_id' and emp_id = '$emp_id' and tour_from_date <= '$today' and tour_to_date >= '$today'";
                                            
                                          $sq_query = mysql_query($query1);
                                          while($row_query=mysql_fetch_assoc($sq_query))
                                          {
                                            $sq_cancel_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]' and status='Cancel'"));
                                            $sq_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]'"));
                                            if($sq_cancel_count != $sq_count){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                          ?>
                      
                                            <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td>Package Booking</td>
                                            <td><?php echo $row_query['tour_name']; ?></td>
                                            <td><?= get_date_user($row_query['tour_from_date']).' To '.get_date_user($row_query['tour_to_date']); ?></td>
                                            <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                            <td><?php echo $row_query['mobile_no']; ?></td>
                                            <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                            <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query['booking_id'] ?>,'Package Booking',<?= $row_query['emp_id']?>,<?= $sq_cust['contact_no']?>)" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                          </tr>
                                    <?php } } ?>
                                    <?php
                                      // hotel Booking
                                        $query1 = "select *	from  hotel_booking_entries where status!='Cancel' and check_in<= '$today1' and check_out >= '$today1'	group by booking_id";
                                        $sq_query = mysql_query($query1);
                                        while($row_query=mysql_fetch_assoc($sq_query)){
                                          
                                        $sql_hotel = mysql_query("select * from hotel_booking_master where booking_id = '$row_query[booking_id]' and emp_id = '$emp_id'");
                                          while($sq_hotel = mysql_fetch_assoc($sql_hotel)){

                                          
                                          $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                          $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                          ?>
                                            <tr class="<?= $bg ?>">
                                            <td><?php echo $count++; ?></td>
                                            <td>Hotel Booking</td>
                                            <td><?php echo $row_query['tour_name']; ?></td>
                                            <td><?= get_date_user($row_query['check_in']).' To '.get_date_user($row_query['check_out']) ?></td>
                                            <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                            <td><?php echo $sq_cust['contact_no']; ?></td>
                                            <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                            <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Hotel Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>	
                                            </tr>
                                          <?php } } ?>
                                          <!-- flight Booking -->
                                          <?php
                                          $query_train = "select *	from  ticket_trip_entries where departure_datetime<= '$today1' and arrival_datetime>= '$today1'
                                          group by ticket_id";
                                          
                                          $sq_query1 = mysql_query($query_train);
                                          while($row_query1=mysql_fetch_assoc($sq_query1)){
                                            
                                          $sql_flight = mysql_query("select * from ticket_master where ticket_id = '$row_query1[ticket_id]' and emp_id = '$emp_id'");
                                            while($sq_hotel = mysql_fetch_assoc($sql_flight)){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Flight Booking</td>
                                              <td><?php echo $row_query1['tour_name']; ?></td>
                                              <td><?= get_date_user($row_query1['departure_datetime']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['ticket_id'] ?>,'Flight Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php } } ?>
                                          <!-- Train Booking -->
                                          <?php
                                          $query_train = "select *	from  train_ticket_master_trip_entries where travel_datetime<= '$today1' and arriving_datetime>= '$today1'
                                          group by train_ticket_id";
                                          $sq_query_train = mysql_query($query_train);
                                          while($row_query1=mysql_fetch_assoc($sq_query_train)){
                                            
                                            $sql_train = mysql_query("select * from train_ticket_master where train_ticket_id = '$row_query1[train_ticket_id]' and emp_id = '$emp_id'");
                                            while($sq_train = mysql_fetch_assoc($sql_train)){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_train[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Train Booking</td>
                                              <td><?php echo $row_query1['tour_name']; ?></td>
                                              <td><?= get_date_user($row_query1['travel_datetime'])?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_train['train_ticket_id'] ?>,'Train Booking',<?= $sq_train['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php } } ?>
                                          
                                          <!-- Bus Booking -->
                                          <?php
                                          $query_bus = "select *	from  bus_booking_entries where date_of_journey	= '$today'	group by booking_id";

                                            $sq_query_bus = mysql_query($query_bus);
                                            while($row_query1=mysql_fetch_assoc($sq_query_bus)){
                                            
                                            $sql_bus = mysql_query("select * from bus_booking_master where booking_id = '$row_query1[booking_id]' and emp_id = '$emp_id'");
                                            while($sq_hotel = mysql_fetch_assoc($sql_bus)){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Bus Booking</td>
                                              <td><?php echo $row_query1['tour_name']; ?></td>
                                              <td><?= get_date_user($row_query1['date_of_journey']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Bus Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php } }?>
                                          <!-- Excursion Booking -->
                                          <?php
                                          
                                          $add7days1 = date('Y-m-d', strtotime('+7 days'));
                                          $query_exc = "select *	from  excursion_master_entries where exc_date ='$today'	group by exc_id";
                                       
                                          $sq_query_exc = mysql_query($query_exc);
                                          while($row_query1=mysql_fetch_assoc($sq_query_exc)){
                                            
                                          $sql_exc = mysql_query("select * from 	excursion_master where exc_id = '$row_query1[exc_id]' and emp_id = '$emp_id'");

                                          while( $sq_hotel = mysql_fetch_assoc($sql_exc)){

                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Excursion Booking</td>
                                              <td><?php echo $row_query1['tour_name']; ?></td>
                                              <td><?= get_date_user($row_query1['exc_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['exc_id'] ?>,'Excursion Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php } }?>
                                            <?php
                                          $query_car = "select * from car_rental_booking  where traveling_date='$today' and travel_type ='Local'";
                                          
                                                $sq_query_car = mysql_query($query_car);
                                                while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                            
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Car Rental Booking</td>
                                              <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                              <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                          <?php } ?>
                                          <!-- Car Rental Booking -->
                                          <?php
                                          $query_car = "select * from car_rental_booking  where traveling_date='$today' and travel_type ='Outstation'";
                                          
                                                $sq_query_car = mysql_query($query_car);
                                                while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                            
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Car Rental Booking</td>
                                              <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                              <td><?= get_date_user($row_query1['traveling_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                          <?php } ?>
                                         <!-- Group Booking -->
                                          <?php
                                          $query_grp = "select * from tour_groups where from_date<='$today' and to_date>='$today'";

                                                $sq_query_grp = mysql_query($query_grp);
                                                while($row_query1=mysql_fetch_assoc($sq_query_grp)){

                                            $sq = mysql_query("select * from tourwise_traveler_details where tour_id='$row_query1[tour_id]' ");
                                                      
                                                            while($row_query = mysql_fetch_assoc($sq)){
                                            
                                            $sq_booking = mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id = '$row_query[tour_id]'"));
                                            $sq_booking1 = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id = '$row_query[tour_id]'"));
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Group Booking</td>
                                              <td><?php echo $sq_booking1['tour_name']; ?></td>
                                              <td><?= get_date_user($sq_booking['from_date']).' To '.get_date_user($sq_booking['to_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['id'] ?>,'Group Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                          <?php } }?>
                                          <!-- Visa Booking -->
                                          <?php
                                            $query_visa = "select *	from  visa_master_entries where appointment_date='$today'	group by visa_id";

                                          $sq_query_visa = mysql_query($query_visa);
                                          while($row_query_visa=mysql_fetch_assoc($sq_query_visa)){

                                          $sql_visa = mysql_query("select * from visa_master where visa_id = '$row_query_visa[visa_id]' and emp_id = '$emp_id'");

                                          while($sq_visa = mysql_fetch_assoc($sql_visa)){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Visa Booking</td>
                                              <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                              <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_visa['visa_id'] ?>,'Visa Booking',<?= $sq_visa['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php }}?>
                                            <!-- Passport Booking -->
                                          <?php
                                          $query_pass = "select *	from  passport_master_entries where appointment_date='$today'	group by passport_id";

                                          $sq_query_pass = mysql_query($query_pass);
                                          while($row_query_visa=mysql_fetch_assoc($sq_query_pass)){

                                          $sql_pass = mysql_query("select * from passport_master where passport_id = '$row_query_visa[passport_id]' and emp_id = '$emp_id'");
                                          while($sq_visa = mysql_fetch_assoc($sql_pass)){
                                            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                            ?>
                                              <tr class="<?= $bg ?>">
                                              <td><?php echo $count++; ?></td>
                                              <td>Passport Booking</td>
                                              <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                              <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                              <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                              <td><?php echo $sq_cust['contact_no']; ?></td>
                                              <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                              <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_visa['passport_id'] ?>,'Passport Booking',<?= $sq_visa['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                              </tr>
                                            <?php } }?>
                                  </tbody>
                                </table>
                              </div> 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                    <!-- Ongoing FIT Tour summary End -->
                  <!-- Upcoming FIT Tours -->
                  <div role="tabpanel" class="tab-pane" id="upcoming_tab">
                      <?php 
                      $count = 1;
                      $today = date('Y-m-d-h-i-s');
                      $add7days = date('Y-m-d-h-i-s', strtotime('+7 days'));
                      $today1 = date('Y-m-d');
                  	  $add7days1 = date('Y-m-d', strtotime('+7 days'));                        
                      ?>
                      <div class="dashboard_table dashboard_table_panel main_block">
                        <div class="row text-left">
                          
                          <div class="col-md-12">
                            <div class="dashboard_table_body main_block">
                              <div class="col-md-12 no-pad table_verflow"> 
                                <div class="table-responsive">
                                  <table class="table table-hover" style="margin: 0 !important;border: 0;">
                                    <thead>
                                      <tr class="table-heading-row">
                                        <th>S_No.</th>
											                  <th>Tour_Type</th>
                                        <th>Tour_Name</th>
                                        <th>Tour_Dates&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Customer_Name</th>
                                        <th>Mobile</th>
				                                <th>Owned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Checklist</th>
                                        <th>Send_Wishes</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $query = "select * from package_tour_booking_master where tour_status!='Disabled' and financial_year_id='$financial_year_id' and tour_from_date >= '$today1'";
                                          
                                          $sq_query = mysql_query($query);
                                          while($row_query=mysql_fetch_assoc($sq_query)){
                                      $sq_cancel_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]' and status='Cancel'"));
                                      $sq_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]'"));

                                      if($row_query['dest_id']=='0'){
                                        $sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id='$row_query[package_id]'"));
                                        $dest_id = $sq_package['dest_id'];
                                      }else{
                                        $dest_id = $row_query['dest_id'];
                                      }
                                      $sq_check = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Package Tour' and destination_name='$dest_id'"));

                                      $sq_task = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Package Tour' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Package Tour' and status='Completed'"));
                                      if($sq_task==$sq_complete_task && $sq_task!=0 && $sq_complete_task!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task==0 && $sq_complete_task==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                        
                                      if($sq_cancel_count != $sq_count){
                                        $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                        $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Package Tour</td>
                                        <td><?= ($row_query['tour_name']=='')?'NA':$row_query['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query['tour_from_date']).' To '.get_date_user($row_query['tour_to_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $row_query['mobile_no']; ?></td>
                                        <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['booking_id']; ?>','Package Tour');" data-toggle="tooltip" title="Update Enquiry" target="_blank"><i class="fa fa-plus"></i></button></td>
                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $row_query[mobile_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } } ?>
                                    <!-- Hotel Booking -->
                                    <?php
                                    $query1 = "select *
                                    from  hotel_booking_entries where status!='Cancel' and check_in >= '$today'
                                    group by booking_id";

                                          $sq_query = mysql_query($query1);
                                          while($row_query=mysql_fetch_assoc($sq_query)){
                                      
                                      $sq = mysql_query("select * from hotel_booking_master where booking_id = '$row_query[booking_id]'");
                                      while($sq_hotel = mysql_fetch_assoc($sq)){
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));

                                      $sq_check_hotel = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Hotel Booking' "));
                                      
                                      $sq_task_hotel = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Hotel Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_hotel = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[booking_id]' and tour_type='Hotel Booking' and status='Completed'"));
                                      if($sq_task_hotel==$sq_complete_task_hotel && $sq_task_hotel!=0 && $sq_complete_task_hotel!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_hotel==0 && $sq_complete_task_hotel==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_hotel>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Hotel Booking</td>
                                        <td><?= ($row_query['tour_name']=='')?'NA':$row_query['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query['check_in']).' To '.get_date_user($row_query['check_out']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['booking_id']; ?>','Hotel Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></i></button></td>
                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                      </tr>
                                      <?php } } ?>
                                    <!-- Flight Booking -->
                                    <?php
                                    $query_flight = "select *
                                    from  ticket_trip_entries where departure_datetime >= '$today'
                                    group by ticket_id";
                                          $sq_query1 = mysql_query($query_flight);
                                          while($row_query1=mysql_fetch_assoc($sq_query1)){
                                      
                                      $sq_hotel = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id = '$row_query1[ticket_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));

                                      $sq_check_flight = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Flight Booking' "));
                                      
                                      $sq_task_flight = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[ticket_id]' and tour_type='Flight Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_flight = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[ticket_id]' and tour_type='Flight Booking' and status='Completed'"));
                                      if($sq_task_flight==$sq_complete_task_flight && $sq_task_flight!=0 && $sq_complete_task_flight!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_flight==0 && $sq_complete_task_flight==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_flight>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Flight Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query1['departure_datetime']).' To '.get_date_user($row_query1['arrival_datetime']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['ticket_id']; ?>','Flight Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                    <!-- Train Booking -->
                                    <?php
                                    
                                    $query_train = "select *
                                    from  train_ticket_master_trip_entries where travel_datetime >= '$today'
                                    group by train_ticket_id";
                                          $sq_query_train = mysql_query($query_train);
                                          while($row_query1=mysql_fetch_assoc($sq_query_train)){
                                      
                                      $sq_train = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id = '$row_query1[train_ticket_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_train[emp_id]'"));

                                      $sq_check_train = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Train Booking'"));

                                      $sq_task_train = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[train_ticket_id]' and tour_type='Train Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_train = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[train_ticket_id]' and tour_type='Train Booking' and status='Completed'"));
                                      if($sq_task_train==$sq_complete_task_train && $sq_task_train!=0 && $sq_complete_task_train!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_train==0 && $sq_complete_task_train==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_train>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Train Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query1['travel_datetime'])?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['train_ticket_id']; ?>','Train Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                        
                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                    <!-- Bus Booking -->
                                    <?php
                                    
                                    $query_bus = "select * from bus_booking_entries where date_of_journey >= '$today' and status!='Cancel' group by booking_id";
                                          $sq_query_bus = mysql_query($query_bus);
                                          while($row_query1=mysql_fetch_assoc($sq_query_bus)){
                                      
                                      $sq_hotel = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id = '$row_query1[booking_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));


                                      $sq_check_bus = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Bus Booking'"));

                                      $sq_task_bus = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Bus Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Bus Booking' and status='Completed'"));
                                      if($sq_task_bus==$sq_complete_task_bus && $sq_task_bus!=0 && $sq_complete_task_bus!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus==0 && $sq_complete_task_bus==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Bus Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query1['date_of_journey']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Bus Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                    <!-- Excursion Booking -->
                                    <?php
                                    $today1 = date('Y-m-d');
                                    $add7days1 = date('Y-m-d', strtotime('+7 days'));

                                    $query_exc = "select *
                                    from  excursion_master_entries where exc_date >= '$today1' and status!='Cancel'
                                    group by exc_id";
                                          $sq_query_exc = mysql_query($query_exc);
                                          while($row_query1=mysql_fetch_assoc($sq_query_exc)){
                                      
                                      $sq_hotel = mysql_fetch_assoc(mysql_query("select * from 	excursion_master where exc_id = '$row_query1[exc_id]'"));
                                      $sq_city = mysql_fetch_assoc(mysql_query("select * from 	city_master where city_id = '$row_query1[city_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));


                                      $sq_check_bus1 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Excursion Booking'"));

                                      $sq_task_bus1 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[exc_id]' and tour_type='Excursion Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus1 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[exc_id]' and tour_type='Excursion Booking' and status='Completed'"));
                                      if($sq_task_bus1==$sq_complete_task_bus1 && $sq_task_bus1!=0 && $sq_complete_task_bus1!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus1==0 && $sq_complete_task_bus1==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus1>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Excursion Booking</td>
                                        <td><?php echo $sq_city['city_name']; ?></td>
                                        <td><?= get_date_user($row_query1['exc_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['exc_id']; ?>','Excursion Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                      <!-- Car Rental Booking -->
                                    <?php
                                    $query_car = "select * from car_rental_booking where from_date  >= '$today1' and travel_type ='Local'";

                                          $sq_query_car = mysql_query($query_car);
                                          while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                      
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));

                                      $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Car Rental Booking'"));

                                      $sq_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Completed'"));
                                      if($sq_task_bus2==$sq_complete_task_bus2 && $sq_task_bus2!=0 && $sq_complete_task_bus2!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus2==0 && $sq_complete_task_bus2==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus2>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Car Rental Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Car Rental Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                    $query_car = "select * from car_rental_booking where traveling_date  >= '$today1'  and travel_type ='Outstation'";

                                          $sq_query_car = mysql_query($query_car);
                                          while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                      
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));

                                      $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Car Rental Booking'"));

                                      $sq_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[booking_id]' and tour_type='Car Rental Booking' and status='Completed'"));
                                      if($sq_task_bus2==$sq_complete_task_bus2 && $sq_task_bus2!=0 && $sq_complete_task_bus2!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus2==0 && $sq_complete_task_bus2==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus2>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Car Rental Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query1['traveling_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Car Rental Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- Group Booking -->
                                    <?php
                                    $sq_query_grp = mysql_query("select *
                                    from tour_groups where from_date >= '$today'
                                    ");
                                          
                                          while($row_query1=mysql_fetch_assoc($sq_query_grp)){

                                      $sq = mysql_query("select * from tourwise_traveler_details where tour_id='$row_query1[tour_id]' ");
                                     
                                      while($row_query = mysql_fetch_assoc($sq)){
                                      
                                      $sq_booking1 = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id = '$row_query1[tour_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                      
                                      $tour_id = $sq_booking1['tour_id'];
                                      // $sq_tour = mysql_fetch_assoc(mysql_query("select * from  tour_master where tour_id='$tour_id'"));        
                                      $dest_id = $sq_booking1['dest_id'];
                                      $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Group Tour' and destination_name = '$dest_id'"));

                                      $sq_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[id]' and tour_type='Group tour' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query[id]' and tour_type='Group Tour' and status='Completed'"));
                                      if($sq_task_bus2==$sq_complete_task_bus2 && $sq_task_bus2!=0 && $sq_complete_task_bus2!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus2==0 && $sq_complete_task_bus2==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus2>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Group Booking</td>
                                        <td><?php echo $sq_booking1['tour_name']; ?></td>
                                        <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['id']; ?>','Group Tour');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                    <?php 
                                  }
                                  }?>
                                    <!-- Visa Booking -->
                                    <?php
                                    
                                    $query_visa = "select * from  visa_master_entries where appointment_date >= '$today1' and status!='Cancel'	group by visa_id";
                                          $sq_query_visa = mysql_query($query_visa);
                                          while($row_query_visa=mysql_fetch_assoc($sq_query_visa)){
                                      $sq_visa = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id = '$row_query_visa[visa_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));

                                      $sq_check_bus3 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Visa Booking'"));

                                      $sq_task_bus3 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query_visa[visa_id]' and tour_type='Visa Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus3 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query_visa[visa_id]' and tour_type='Visa Booking' and status='Completed'"));
                                      if($sq_task_bus3==$sq_complete_task_bus3 && $sq_task_bus3!=0 && $sq_complete_task_bus3!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus3==0 && $sq_complete_task_bus3==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus3>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Visa Booking</td>
                                        <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                        <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query_visa['visa_id']; ?>','Visa Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                      <!-- Passport Booking -->
                                    <?php
                                    
                                    $query_pass = "select * from  passport_master_entries where appointment_date >= '$today1'
                                    group by passport_id";
                                          $sq_query_pass = mysql_query($query_pass);
                                          while($row_query_visa=mysql_fetch_assoc($sq_query_pass)){
                                      $sq_visa = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id = '$row_query_visa[passport_id]'"));
                                      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));

                                      $sq_check_bus4 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Passport Booking'"));

                                      $sq_task_bus4 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query_visa[passport_id]' and tour_type='Passpport Booking' and assigned_emp_id='$emp_id'"));
                                                            
                                      $sq_complete_task_bus4 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query_visa[passport_id]' and tour_type='Passport Booking' and status='Completed'"));
                                      if($sq_task_bus4==$sq_complete_task_bus4 && $sq_task_bus4!=0 && $sq_complete_task_bus4!=0 ){
                                        $bg_color = 'rgba(52,195,143,.18);';
                                        $status = 'Completed';
                                        $text_color = '#34c38f;';
                                        }else if($sq_task_bus4==0 && $sq_complete_task_bus4==0){
                                          $bg_color = '';
                                          $status = '';
                                          $text_color = '';
                                        }
                                        else if($sq_complete_task_bus4>=1){
                                          $bg_color = 'rgba(241,180,76,.18)';
                                          $status = 'Ongoing';
                                          $text_color = '#f1b44c';
                                        }else{
                                          $bg_color = 'rgba(244,106,106,.18)';
                                          $status = 'Not Updated';
                                          $text_color = '#f46a6a';
                                        }
                                      ?>
                                        <tr class="<?= $bg ?>">
                                        <td><?php echo $count++; ?></td>
                                        <td>Passport Booking</td>
                                        <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                        <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                        <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                        <td><?php echo $sq_cust['contact_no']; ?></td>
                                        <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query_visa['passport_id']; ?>','Passport Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                        <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                        <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                </div> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
            <!-- Upcoming FIT Tour summary End -->

            <!-- Enquiry & Followup summary -->
                  <div role="tabpanel" class="tab-pane active" id="enquiry_tab">
                        <div class="dashboard_table dashboard_table_panel main_block mg_bt_25">
                          <div class="row text-left">
                            <div class="col-md-6">
                              <div class="dashboard_table_heading main_block">
                                <div class="col-md-10 no-pad">
                                  <h3>Followup Reminders</h3>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2 col-sm-6 mg_bt_10">
                              <input type="text" id="followup_from_date_filter" name="followup_from_date_filter" placeholder="Followup From D/T" title="Followup From D/T">
                            </div>
                            <div class="col-md-2 col-sm-6 mg_bt_10">
                              <input type="text" id="followup_to_date_filter" name="followup_to_date_filter" placeholder="Followup To D/T" title="Followup To D/T">
                            </div>
                            <div class="col-md-1 text-left col-sm-6 mg_bt_10">
                              <button class="btn btn-excel btn-sm" id="followup_reflect1" onclick="followup_reflect()" data-toggle="tooltip" title="" data-original-title="Proceed"><i class="fa fa-arrow-right"></i></button>
                            </div>
                            <div id='followup_data'></div>
                          </div>
                        </div>
                     <div id="history_data"></div>
                  </div>
            <!-- Enquiry & Followup summary End -->

                      <!-- Weekly Task -->
                  <div role="tabpanel" class="tab-pane" id="task_tab">
                    <?php
                    $assigned_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status!='Disabled'"));
                    $can_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status='Cancelled'"));
                    $completed_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status='Completed'"));
                    ?>
                    <div class="dashboard_table dashboard_table_panel main_block">
                      <div class="row text-left">
                          <div class="col-md-12">
                            <div class="dashboard_table_heading main_block">
                              <div class="col-md-12 no-pad">
                                <h3>Allocated Tasks</h3>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="dashboard_table_body main_block">
                              <div class="col-sm-9 no-pad table_verflow table_verflow_two"> 
                                <div class="table-responsive no-marg-sm">
                                  <table class="table table-hover" style="margin: 0 !important;border: 0;">
                                    <thead>
                                      <tr class="table-heading-row">
                                        <th>Task_Name</th>
                                        <th>Task_Type</th>
                                        <th>ID</th>
                                        <th>Assign_Date</th>
                                        <th>Due_Date&Time</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sq_task = mysql_query("select * from tasks_master where emp_id='$emp_id' and (task_status='Created' or task_status='Incomplete') order by task_id");
                                    while($row_task = mysql_fetch_assoc($sq_task)){ 
                                        $count++;
                                        if($row_task['task_status'] == 'Created'){
                                          $bg='warning';
                                        }
                                        elseif($row_task['task_status'] == 'Incomplete' ){
                                          $bg='danger';
                                        }
                                    ?>
                                        <tr class="odd">
                                          <td><?php echo $row_task['task_name']; ?></td>
                                          <td><?php echo $row_task['task_type']; ?></td>
                                          <td><?php echo ($row_task['task_type_field_id']!='')?$row_task['task_type_field_id']:'NA'; ?></td>
                                          <td><?php echo get_date_user($row_task['created_at']); ?></td>
                                          <td><?php echo get_datetime_user($row_task['due_date']); ?></td>
                                          <td><span class="<?= $bg ?>"><?php echo $row_task['task_status']; ?></span></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="col-sm-3 no-pad">
                                <div class="table_side_widget_panel main_block">
                                  <div class="table_side_widget_content main_block">
                                    <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                      <div class="table_side_widget">
                                        <div class="table_side_widget_amount"><?= $assigned_task_count ?></div>
                                        <div class="table_side_widget_text widget_blue_text">Total Task</div>
                                      </div>
                                    </div>
                                    <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                      <div class="table_side_widget">
                                        <div class="table_side_widget_amount"><?= $completed_task_count ?></div>
                                        <div class="table_side_widget_text widget_green_text">Task Completed</div>
                                      </div>
                                    </div>
                                    <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                      <div class="table_side_widget">
                                        <div class="table_side_widget_amount"><?= $can_task_count ?></div>
                                        <div class="table_side_widget_text widget_red_text">Task Cancelled</div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12">
                                      <div class="table_side_widget">
                                        <div class="table_side_widget_amount"><?= $assigned_task_count-$completed_task_count-$can_task_count ?></div>
                                        <div class="table_side_widget_text widget_yellow_text">Task Pending</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div> 
                  </div>
                <!-- Weekly Task  End-->
                <!-- Monthly Incentive -->
                  <div role="tabpanel" class="tab-pane" id="incentive_tab">
                      <div class="dashboard_table dashboard_table_panel main_block">
                        <div class="row text-left">
                          <div class="col-md-12">
                            <div class="dashboard_table_heading main_block">
                              <div class="col-md-8 no-pad">
                                <h3 style="cursor: pointer;" onclick="window.open('<?= BASE_URL ?>view/booker_incentive/booker_incentive.php', 'My Window');">Incentive/Commission</h3>
                              </div>
                              <div class="col-md-2 col-xs-12 no-pad-sm mg_bt_10_sm_xs">
                                  <input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date" onchange="booking_list_reflect()">
                              </div>
                              <div class="col-md-2 col-xs-12 no-pad-sm">
                                  <input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date" onchange="booking_list_reflect()">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="dashboard_table_body main_block">
                              <div class="col-md-12 no-pad  table_verflow"> 
                                  <div id="div_booker_incentive_reflect">
                                  </div>                     
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <!-- Incentive End --> 
                </div>
              </div>
            </div>
          </div>

     </div>
  </div>
<script type="text/javascript">
	$('#followup_from_date_filter, #followup_to_date_filter').datetimepicker({format:'d-m-Y H:i' });
  $('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
  
function send_sms(id,tour_type,emp_id,contact_no, name){
	$('#send_btn').button('loading')
	$.post('admin/send_sms.php', { id:id,tour_type:tour_type,emp_id:emp_id,contact_no:contact_no,name:name}, function(data){
		$('#id_proof2').html(data);
	});
  }
  function checklist_update(booking_id,tour_type){
	
	$.post('sales/update_checklist.php', { booking_id:booking_id,tour_type:tour_type}, function(data){
    // alert(data);
		$('#id_proof2').html(data);
	});
}
function whatsapp_wishes(number,name){
	var msg = encodeURI("Hello Dear "+ name +",\nMay this trip turns out to be a wonderful treat for you and may you create beautiful memories throughout this trip to cherish forever. Wish you a very happy and safe journey!!\nThank you.");
	window.open('https://web.whatsapp.com/send?phone='+number+'&text='+msg);
}
	function followup_reflect(){
		var from_date = $('#followup_from_date_filter').val();
		var to_date = $('#followup_to_date_filter').val();
		$.post('sales/followup_list_reflect.php', { from_date : from_date,to_date:to_date }, function(data){
			$('#followup_data').html(data);
		});
	}
  followup_reflect();
  function booking_list_reflect()
  {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    $.post('sales/incentive_list_reflect.php', { from_date : from_date, to_date : to_date }, function(data){
      $('#div_booker_incentive_reflect').html(data);
    });
  }
  booking_list_reflect();
	function display_history(enquiry_id)
	{
		$.post('admin/followup_history.php', { enquiry_id : enquiry_id }, function(data){
		$('#history_data').html(data);
		});
  }
  function Followup_update(enquiry_id)
  {
    $.post('admin/followup_update.php', { enquiry_id : enquiry_id }, function(data){
      $('#history_data').html(data);
    });
    
  }
function followup_type_reflect(followup_status){
	$.post('admin/followup_type_reflect.php', {followup_status : followup_status}, function(data){
		$('#followup_type').html(data);
	}); 
}
</script>
<script type="text/javascript">
    (function($) {
        fakewaffle.responsiveTabs(['xs', 'sm']);
    })(jQuery);
  </script>