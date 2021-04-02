<?php
$login_id = $_SESSION['login_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
//**Enquiries
$assigned_enq_count = mysql_num_rows(mysql_query("select enquiry_id from enquiry_master where assigned_emp_id='$emp_id' and status!='Disabled' and financial_year_id='$financial_year_id'"));

$converted_count = 0;
$closed_count = 0;
$infollowup_count = 0;
$followup_count = 0;

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

	<div class="dashboard_enqury_widget_panel main_block mg_bt_25">
            <div class="row">
                <div class="col-sm-3 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block blue_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-cubes"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $assigned_enq_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount"> 
                      Total Enquiries 
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block yellow_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $followup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Active
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block gray_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-open-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $infollowup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      In-Followup
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block green_enquiry_widget">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-check-square-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $converted_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Converted
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block red_enquiry_widget">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-trash-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $closed_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Dropped Enquiries
                    </div>
                  </div>
                </div>
            </div>
    </div>

    <div class="row">
      <div class="col-md-12">
      <div id="id_proof2"></div>
        <div class="dashboard_tab text-center main_block">

          <!-- Nav tabs -->
          <ul class="nav nav-tabs responsive" role="tablist">
            <li role="presentation"  class="active"><a href="#week_fol_tab" aria-controls="week_fol_tab" role="tab" data-toggle="tab">Todays Followups</a></li>
            <li role="presentation"><a href="#oncoming_tab" aria-controls="oncoming_tab" role="tab" data-toggle="tab">Ongoing Tours</a></li>
            <li role="presentation" class=""><a href="#upcoming_tab" aria-controls="upcoming_tab" role="tab" data-toggle="tab">Upcoming Tours</a></li>
            <li role="presentation"><a href="#week_task_tab" aria-controls="week_task_tab" role="tab" data-toggle="tab">Tasks</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content responsive main_block">
            
            <!-- Ongoing FIT Tours -->
                <div role="tabpanel" class="tab-pane" id="oncoming_tab">
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
                        while($row_query=mysql_fetch_assoc($sq_query)){
                          $sq_cancel_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]' and status='Cancel'"));
                          $sq_count = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_query[booking_id]'"));
                          if($sq_cancel_count != $sq_count){
                          $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                          $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                        ?>
                              <tr class="<?= $bg ?>">
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row_query['tour_name']; ?></td>
                                <td><?= get_date_user($row_query['tour_from_date']).' To '.get_date_user($row_query['tour_to_date']); ?></td>
                                <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                <td><?php echo $row_query['mobile_no']; ?></td>
                                <td><?= ($row_query['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query['booking_id'] ?>,'Package Booking',<?= $row_query['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                              </tr>
                            <?php
                              } }
                            ?>
                             <!-- Hotel Booking -->
                            <?php
                            $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='hotels/booking/index.php'"));
                            $branch_status = $sq['branch_status'];
                            $query = "select *	from  hotel_booking_entries where status!='Cancel' and check_in<= '$today1' and check_out >= '$today1' group by booking_id";
                            
                            $sq_query = mysql_query($query);
                            while($row_query=mysql_fetch_assoc($sq_query)){
                              
                            
                            $query1 = "select * from hotel_booking_master where booking_id = '$row_query[booking_id]' and emp_id = '$emp_id'";
                            if($branch_status=='yes'){
                              if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                $query1 .= " and branch_admin_id = '$branch_admin_id'";
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                              }
                            }
                            elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                              $query1 .= " and emp_id='$emp_id'";
                            }
                            $sql_hotel = mysql_query($query1);
                              while($sq_hotel = mysql_fetch_assoc($sql_hotel)){

                              
                              $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                              $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                              $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                              ?>
                                <tr class="<?= $bg ?>">
                                <td><?php echo $count++; ?></td>
                                <td>Hotel Booking</td>
                                <td><?php echo $row_query['tour_name']; ?></td>
                                <td><?= get_date_user($row_query['check_in']).' To '.get_date_user($row_query['check_out']) ?></td>
                                <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Hotel Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>	
                                </tr>
                              <?php } } ?>
                              <!-- flight Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select *	from  ticket_trip_entries where departure_datetime<= '$today1' and arrival_datetime>= '$today1'
                              group by ticket_id";
                              
                              $sq_query1 = mysql_query($query_train);
                              while($row_query1=mysql_fetch_assoc($sq_query1)){
                                
                              
                              $query1 = "select * from ticket_master where ticket_id = '$row_query1[ticket_id]' and emp_id = '$emp_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_flight = mysql_query($query1);
                                while($sq_hotel = mysql_fetch_assoc($sql_flight)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Flight Booking</td>
                                  <td><?php echo $row_query1['tour_name']; ?></td>
                                  <td><?= get_date_user($row_query1['departure_datetime']) ?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['ticket_id'] ?>,'Flight Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } } ?>
                              <!-- Train Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select *	from  train_ticket_master_trip_entries where travel_datetime<= '$today1' and arriving_datetime>= '$today1'
                              group by train_ticket_id";
                              $sq_query_train = mysql_query($query_train);
                              while($row_query1=mysql_fetch_assoc($sq_query_train)){
                                
                                $query1 = "select * from train_ticket_master where train_ticket_id = '$row_query1[train_ticket_id]' and emp_id = '$emp_id'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sql_train = mysql_query($query1);
                                while($sq_train = mysql_fetch_assoc($sql_train)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_train[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Train Booking</td>
                                  <td><?php echo $row_query1['tour_name']; ?></td>
                                  <td><?= get_date_user($row_query1['travel_datetime'])?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_train['train_ticket_id'] ?>,'Train Booking',<?= $sq_train['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } } ?>
                              
                              <!-- Bus Booking -->
                              <?php
                              // $today1 = date('Y-m-d');
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='bus_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_bus = "select *	from  bus_booking_entries where date_of_journey	= '$today'	group by booking_id";

                                $sq_query_bus = mysql_query($query_bus);
                                while($row_query1=mysql_fetch_assoc($sq_query_bus)){
                                
                                $query1 = "select * from bus_booking_master where booking_id = '$row_query1[booking_id]' and emp_id = '$emp_id'";

                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sql_bus = mysql_query($query1);

                                while($sq_hotel = mysql_fetch_assoc($sql_bus)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Bus Booking</td>
                                  <td><?php echo $row_query1['tour_name']; ?></td>
                                  <td><?= get_date_user($row_query1['date_of_journey']) ?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['booking_id'] ?>,'Bus Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } }?>
                              <!-- Excursion Booking -->
                              <?php
                              
                              $add7days1 = date('Y-m-d', strtotime('+7 days'));
                              $query_exc = "select *	from  excursion_master_entries where exc_date ='$today'	group by exc_id";

                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='excursion/index.php'"));
                              $branch_status = $sq['branch_status'];
                            
                              $sq_query_exc = mysql_query($query_exc);
                              while($row_query1=mysql_fetch_assoc($sq_query_exc)){
                                
                              $query1 = "select * from 	excursion_master where exc_id = '$row_query1[exc_id]' and emp_id = '$emp_id'";

                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_exc = mysql_query($query1);
                              while( $sq_hotel = mysql_fetch_assoc($sql_exc)){

                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Excursion Booking</td>
                                  <td><?php echo $row_query1['tour_name']; ?></td>
                                  <td><?= get_date_user($row_query1['exc_date']) ?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_hotel['exc_id'] ?>,'Excursion Booking',<?= $sq_hotel['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php } }?>
                             <!-- Car Rental Booking -->
                                  <?php
                                  $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='car_rental/booking/index.php'"));
                                  $branch_status = $sq['branch_status'];
                                  $query_car = "select * from car_rental_booking  where traveling_date='$today' and travel_type ='Local'";

                                  if($branch_status=='yes'){
                                    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                      $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                    }
                                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                      $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                    }
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query_car .= " and emp_id='$emp_id'";
                                  }
                                  
                                $sq_query_car = mysql_query($query_car);
                                while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                    
                                    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Car Rental Booking</td>
                                      <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                      <td><?= get_date_user($row_query1['from_date']).' To '.get_date_user($row_query1['to_date']) ?></td>
                                      <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                      </tr>
                                  <?php } ?>
                                  <!-- Car Rental Booking -->
                                  <?php
                                  $query_car = "select * from car_rental_booking  where traveling_date='$today' and travel_type ='Outstation'";

                                  if($branch_status=='yes'){
                                    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                      $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                    }
                                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                      $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                    }
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query_car .= " and emp_id='$emp_id'";
                                  }
                                  
                                  $sq_query_car = mysql_query($query_car);
                                  while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                    
                                    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Car Rental Booking</td>
                                      <td><?= ($row_query1['tour_name']=='')?'NA':$row_query1['tour_name'] ?></td>
                                      <td><?= get_date_user($row_query1['traveling_date']) ?></td>
                                      <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['booking_id'] ?>,'Car Rental Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                      </tr>
                                  <?php } ?>
                              <!-- Group Booking -->
                                  <?php
                                  $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='booking/index.php'"));
                                  $branch_status = $sq['branch_status'];
                                  $query_grp = "select * from tour_groups where from_date<='$today' and to_date>='$today'";

                                        $sq_query_grp = mysql_query($query_grp);
                                        while($row_query1=mysql_fetch_assoc($sq_query_grp)){

                                    $query1 = "select * from tourwise_traveler_details where tour_id='$row_query1[tour_id]' ";

                                    if($branch_status=='yes'){
                                      if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                        $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                      }
                                      elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                        $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                      }
                                    }
                                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                      $query1 .= " and emp_id='$emp_id'";
                                    }
                                    $sq = mysql_query($query1);
                                    while($row_query = mysql_fetch_assoc($sq)){
                                    
                                    $sq_booking = mysql_fetch_assoc(mysql_query("select * from tour_groups where tour_id = '$row_query[tour_id]'"));
                                    $sq_booking1 = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id = '$row_query[tour_id]'"));
                                    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                    ?>
                                      <tr class="<?= $bg ?>">
                                      <td><?php echo $count++; ?></td>
                                      <td>Group Booking</td>
                                      <td><?php echo $sq_booking1['tour_name']; ?></td>
                                      <td><?= get_date_user($sq_booking['from_date']).' To '.get_date_user($sq_booking['to_date']) ?></td>
                                      <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                      <td><?php echo $contact_no; ?></td>
                                      <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                      <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $row_query1['id'] ?>,'Group Booking',<?= $row_query1['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                      </tr>
                                  <?php } }?>
                              <!-- Visa Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/visa/index.php'"));
                              $branch_status = $sq['branch_status'];
                              
                              $query_visa = "select *	from  visa_master_entries where appointment_date='$today'	group by visa_id";

                              $sq_query_visa = mysql_query($query_visa);
                              while($row_query_visa=mysql_fetch_assoc($sq_query_visa)){

                              $query1 = "select * from visa_master where visa_id = '$row_query_visa[visa_id]' and emp_id = '$emp_id'";

                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_visa = mysql_query($query1);

                              while($sq_visa = mysql_fetch_assoc($sql_visa)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Visa Booking</td>
                                  <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                  <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td><button class="btn btn-info btn-sm" onclick="send_sms(<?= $sq_visa['visa_id'] ?>,'Visa Booking',<?= $sq_visa['emp_id']?>,'<?= $sq_cust['contact_no']?>')" title="Send SMS"><i class="fa fa-paper-plane-o"></i></button></td>
                                  </tr>
                                <?php }}?>
                                <!-- Passport Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/passport/index.php'"));
                              $branch_status = $sq['branch_status'];

                              $query_pass = "select *	from  passport_master_entries where appointment_date='$today'	group by passport_id";

                              $sq_query_pass = mysql_query($query_pass);
                              while($row_query_visa=mysql_fetch_assoc($sq_query_pass)){

                              $query1 = "select * from passport_master where passport_id = '$row_query_visa[passport_id]' and emp_id = '$emp_id'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query1 .= " and emp_id='$emp_id'";
                              }
                              $sql_pass = mysql_query($query1);
                              while($sq_visa = mysql_fetch_assoc($sql_pass)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                ?>
                                  <tr class="<?= $bg ?>">
                                  <td><?php echo $count++; ?></td>
                                  <td>Passport Booking</td>
                                  <td><?php echo $row_query_visa['visa_country_name']; ?></td>
                                  <td><?= get_date_user($row_query_visa['appointment_date']) ?></td>
                                  <td><?php echo $sq_cust['first_name'].' '.$sq_cust['last_name']; ?></td>
                                  <td><?php echo $contact_no; ?></td>
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

            <!-- Upcoming  FIT Tours -->
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
                                  <th>Tour_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Customer_Name</th>
                                  <th>Mobile</th>
                                  <th>Owned&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                  <th>Checklist</th>
                                  <th>Checklist_Status</th>
                                  <th>Send_Wishes</th>
                                </tr>
                              </thead>
                              <tbody>
                             <!-- //package Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='package_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query = "select * from package_tour_booking_master where tour_status!='Disabled' and financial_year_id='$financial_year_id' and tour_from_date >= '$today1'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query .= " and emp_id='$emp_id'";
                              }
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

                                $sq_task = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check[entity_id]'"));
                                                      
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
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='hotels/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              
                              $query1 = "select * from  hotel_booking_entries where status!='Cancel' and check_in >= '$today' group by booking_id";                              
                              $sq_query = mysql_query($query1);
                            while($row_query=mysql_fetch_assoc($sq_query)){
                                $query = "select * from hotel_booking_master where booking_id = '$row_query[booking_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query);
                                while($sq_hotel = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));

                                $sq_check_hotel = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Hotel Booking' "));
                                
                                $sq_task_hotel = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_hotel[entity_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                                      
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
                                  <td><?php echo $contact_no ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query['booking_id']; ?>','Hotel Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></i></button></td>
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php } } ?>
                              <!-- Flight Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_flight = "select *
                              from  ticket_trip_entries where departure_datetime >= '$today'
                              group by ticket_id";
                            $sq_query1 = mysql_query($query_flight);
                            while($row_query1=mysql_fetch_assoc($sq_query1)){
                              
                                $query1 = "select * from ticket_master where ticket_id = '$row_query1[ticket_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($sq_hotel = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_check_flight = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Flight Booking' "));
                                
                                $sq_task_flight = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_flight[entity_id]'"));
                                                      
                                $sq_complete_task_flight = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[ticket_id]' and tour_type='Flight Booking' and status='Completed'"));
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['ticket_id']; ?>','Flight Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                              <!-- Train Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_train = "select *
                              from  train_ticket_master_trip_entries where travel_datetime >= '$today'
                              group by train_ticket_id";
                                    $sq_query_train = mysql_query($query_train);
                                    while($row_query1=mysql_fetch_assoc($sq_query_train)){
                                
                                $query1 = "SELECT * from `train_ticket_master` where `train_ticket_id` = '$row_query1[train_ticket_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($sq_train = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_train[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_train[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_check_train = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Train Booking'"));

                                $sq_task_train = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_train[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_train['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['train_ticket_id']; ?>','Train Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>
                                  
                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                              <!-- Bus Booking -->
                              <?php
                              $today1 = date('Y-m-d');
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='bus_booking/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_bus = "select * from bus_booking_entries where date_of_journey >= '$today1' and status!='Cancel' group by booking_id";
                                    $sq_query_bus = mysql_query($query_bus);
                                    while($row_query1=mysql_fetch_assoc($sq_query_bus)){
                                
                                $query1 = "select * from bus_booking_master where booking_id = '$row_query1[booking_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($sq_hotel = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);

                                $sq_check_bus = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Bus Booking'"));

                                $sq_task_bus = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Bus Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                              <!-- Excursion Booking -->
                              <?php
                              $today1 = date('Y-m-d');
                              $add7days1 = date('Y-m-d', strtotime('+7 days'));
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='excursion/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_exc = "select *
                              from  excursion_master_entries where exc_date >= '$today1' and status!='Cancel'
                              group by exc_id";
                                    $sq_query_exc = mysql_query($query_exc);
                            while($row_query1=mysql_fetch_assoc($sq_query_exc)){
                                
                                $query1 = "select * from 	excursion_master where exc_id = '$row_query1[exc_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($sq_hotel = mysql_fetch_assoc($sq)){
                                $sq_city = mysql_fetch_assoc(mysql_query("select * from 	city_master where city_id = '$row_query1[city_id]'"));
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_hotel[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_hotel[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);

                                $sq_check_bus1 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Excursion Booking'"));

                                $sq_task_bus1 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus1[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_hotel['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['exc_id']; ?>','Excursion Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                                <!-- Car Rental Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='car_rental/booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_car = "select * from car_rental_booking where from_date  >= '$today1' and travel_type ='Local'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query_car .= " and emp_id='$emp_id'";
                              }

                                    $sq_query_car = mysql_query($query_car);
                                    while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Car Rental Booking'"));

                                $sq_task_bus2 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus2[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($row_query1['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query1['booking_id']; ?>','Car Rental Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                              <?php } ?>
                              <?php
                              $query_car = "select * from car_rental_booking where traveling_date  >= '$today1'  and travel_type ='Outstation'";
                              if($branch_status=='yes'){
                                if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                  $query_car .= " and branch_admin_id = '$branch_admin_id'";
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query_car .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                }
                              }
                              elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                $query_car .= " and emp_id='$emp_id'";
                              }

                                    $sq_query_car = mysql_query($query_car);
                                    while($row_query1=mysql_fetch_assoc($sq_query_car)){
                                
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query1[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query1[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);$today1 = date('Y-m-d');
                                $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Car Rental Booking'"));

                                $sq_task_bus2 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus2[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
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
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='booking/index.php'"));
                              $branch_status = $sq['branch_status'];
                                while($row_query1=mysql_fetch_assoc($sq_query_grp)){

                                
                                $query1 = "select * from tourwise_traveler_details where tour_id='$row_query1[tour_id]' ";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($row_query = mysql_fetch_assoc($sq)){
                                
                                $sq_booking1 = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id = '$row_query1[tour_id]'"));
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_query[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_query[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $tour_id = $sq_booking1['tour_id'];
                                // $sq_tour = mysql_fetch_assoc(mysql_query("select * from  tour_master where tour_id='$tour_id'"));        
                                $dest_id = $sq_booking1['dest_id'];
                                $sq_check_bus2 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Group Tour' and destination_name = '$dest_id'"));

                                $sq_task_bus2 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus2[entity_id]'"));
                                                      
                                $sq_complete_task_bus2 = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$row_query1[id]' and tour_type='Group Tour' and status='Completed'"));
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
                                  <td><?php echo $contact_no; ?></td>
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
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/visa/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_visa = "select * from  visa_master_entries where appointment_date >= '$today1' and status!='Cancel'	group by visa_id";
                                    $sq_query_visa = mysql_query($query_visa);
                              while($row_query_visa=mysql_fetch_assoc($sq_query_visa)){
                                $query1 = "select * from visa_master where visa_id = '$row_query_visa[visa_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);
                                while($sq_visa = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_check_bus3 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Visa Booking'"));

                                $sq_task_bus3 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus3[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query_visa['visa_id']; ?>','Visa Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>
                                <!-- Passport Booking -->
                              <?php
                              $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/passport/index.php'"));
                              $branch_status = $sq['branch_status'];
                              $query_pass = "select * from  passport_master_entries where appointment_date >= '$today1'
                              group by passport_id";
                              

                              $sq_query_pass = mysql_query($query_pass);
                              while($row_query_visa=mysql_fetch_assoc($sq_query_pass)){
                                
                                $query1 = "select * from passport_master where passport_id = '$row_query_visa[passport_id]'";
                                if($branch_status=='yes'){
                                  if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                                    $query1 .= " and branch_admin_id = '$branch_admin_id'";
                                  }
                                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                    $query1 .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
                                  }
                                }
                                elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                                  $query1 .= " and emp_id='$emp_id'";
                                }
                                $sq = mysql_query($query1);

                                while($sq_visa = mysql_fetch_assoc($sq)){
                                $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$sq_visa[customer_id]'"));
                                $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$sq_visa[emp_id]'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_cust['contact_no'], $secret_key);
                                $sq_check_bus4 = mysql_fetch_assoc(mysql_query("select * from checklist_entities where entity_for='Passport Booking'"));

                                $sq_task_bus4 = mysql_num_rows(mysql_query("select * from  to_do_entries where entity_id='$sq_check_bus4[entity_id]'"));
                                                      
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
                                  <td><?php echo $contact_no; ?></td>
                                  <td><?= ($sq_visa['emp_id']=='0') ? "Admin" : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="checklist_update('<?php echo $row_query_visa['passport_id']; ?>','Passport Booking');" data-toggle="tooltip" title="Update Checklist" target="_blank"><i class="fa fa-plus"></i></button></td>

                                  <td class="text-center"><h6 style="width: 90px;height: 30px;border-radius: 20px;font-size: 12px;line-height: 21px;text-align: center;background:<?= $bg_color ?>;padding:5px;color:<?= $text_color?>"><?= $status ?></h6></td>

                                  <td class="text-center"><button class="btn btn-info btn-sm" onclick="whatsapp_wishes('<?= $sq_cust[contact_no] ?>','<?= $sq_cust['first_name']?>')" title="" data-toggle="tooltip" data-original-title="What'sApp wishes to customer"><i class="fa fa-whatsapp"></i></button></td>
                                  </tr>
                                <?php }} ?>                            </tbody>
                            </table>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- Upcoming FIT Tour summary End -->

            <!-- Weekly Followups -->
            <div role="tabpanel" class="tab-pane active" id="week_fol_tab">
              <div class="dashboard_table dashboard_table_panel main_block">
              <div class="row text-left">
                <div class="col-md-6">
                  <div class="dashboard_table_heading main_block">
                    <div class="col-md-12 no-pad">
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
            <!-- Weekly Followups end -->
            <!-- Weekly Task -->
            <div role="tabpanel" class="tab-pane" id="week_task_tab">
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
                                  <th>ID/Enq_No.</th>
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
            <!-- Weekly Task end -->
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<script type="text/javascript">
  $('#followup_from_date_filter, #followup_to_date_filter').datetimepicker({format:'d-m-Y H:i' });
  function send_sms(id,tour_type,emp_id,contact_no, name){
    $('#send_btn').button('loading')
    $.post('admin/send_sms.php', { id:id,tour_type:tour_type,emp_id:emp_id,contact_no:contact_no,name:name}, function(data){
      $('#id_proof2').html(data);
    });
  }
  function whatsapp_wishes(number,name){
	var msg = encodeURI("Hello Dear "+ name +",\nMay this trip turns out to be a wonderful treat for you and may you create beautiful memories throughout this trip to cherish forever. Wish you a very happy and safe journey!!\nThank you.");
	window.open('https://web.whatsapp.com/send?phone='+number+'&text='+msg);
}
  function checklist_update(booking_id,tour_type){
	
	$.post('backoffice/update_checklist.php', { booking_id:booking_id,tour_type:tour_type}, function(data){
		$('#id_proof2').html(data);
	});
}
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
	followup_reflect();
	function followup_reflect(){
		var from_date = $('#followup_from_date_filter').val();
		var to_date = $('#followup_to_date_filter').val();
		$.post('backoffice/followup_list_reflect.php', { from_date : from_date,to_date:to_date }, function(data){
			$('#followup_data').html(data);
		});
	}
</script>
<script type="text/javascript">
    (function($) {
        fakewaffle.responsiveTabs(['xs', 'sm']);
    })(jQuery);
  </script>