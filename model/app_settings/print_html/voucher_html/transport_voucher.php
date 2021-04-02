<?php  
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";

$booking_id = $_GET['booking_id'];

$sq_service_voucher = mysql_fetch_assoc(mysql_query("select * from package_tour_transport_service_voucher where booking_id='$booking_id'"));

$sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));

$row_transport =  mysql_fetch_assoc(mysql_query("select * from package_tour_transport_master where booking_id='$booking_id'")) ;

$sq_traveler = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
$name = $sq_traveler['first_name'].' '.$sq_traveler['last_name'];
$contact_no = $sq_traveler['contact_no'];
$email_id = $sq_traveler['email_id'];

$sq_hotel = mysql_fetch_assoc(mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'"));

//Total days
$total_days1=strtotime($sq_booking['tour_to_date']) - strtotime($sq_booking['tour_from_date']);
$total_days = round($total_days1 / 86400);

$total_pax = mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$booking_id' and status='Active'"));
if($sq_booking['quotation_id'] != 0){
  $sq_package_program = mysql_query("select * from package_quotation_program where quotation_id ='$sq_booking[quotation_id]'");
}
else{
  $sq_package_program = mysql_query("select * from package_tour_schedule_master where booking_id ='$sq_booking[booking_id]'");
}

$emp_id = $_SESSION['emp_id'];
$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
?>
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> TRANSPORT SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo $app_address; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $app_contact_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
        </div>
      </div>
    </section>

    <!-- print-detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-4 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-address-book" aria-hidden="true"></i><br>
                  <span>CONFIRMED BY</span><br>
                  <?= $sq_service_voucher['confirm_by'] ?><br>
                </div>
              </li>
              <li class="col-md-4 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                  <span>DURATION</span><br>
                  <?= $total_days+1 ?><br>
                </div>
              </li>
              <li class="col-md-4 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                  <span>TOTAL GUEST</span><br>
                  <?= $total_pax ?><br>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- BOOKING -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CUSTOMER NAME :</span> <?= $name ?></li>
          </ul>
        </div>
      </div>
    </section>
    
    <!-- Transport Details -->
    <?php
    $sq_count = mysql_num_rows(mysql_query("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'"));
    if($sq_count != 0){
    ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>TRANSPORT DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>Vehicle_name</th>
                <th>From_date</th>
                <th>Pick_Up_From</th>
                <th>Drop_To</th>
                <th>Driver_Name</th>
                <th>Driver_Contact</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $sq_tr_acc = mysql_query("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'");
            while($row_tr_acc=mysql_fetch_assoc($sq_tr_acc))
            {  
              $q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_tr_acc[transport_bus_id]'"));
              $q_transport_info = mysql_fetch_assoc(mysql_query("select * from package_tour_transport_master where booking_id='$row_tr_acc[booking_id]' and transport_bus_id='$row_tr_acc[transport_bus_id]'"));
            ?>
                <tr>
                  <td><?= $q_transport['vehicle_name'] ?></td>
                  <td><?= get_date_user($q_transport_info['transport_from_date']) ?></td>
                  <td><?= get_date_user($q_transport_info['transport_to_date']) ?></td>
                  <td><?= $row_tr_acc['pick_up_from'] ?></td>
                  <td><?= $row_tr_acc['drop_to'] ?></td>
                  <td><?= $row_tr_acc['driver_name'] ?></td>
                  <td><?= $row_tr_acc['driver_contact'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php }?>
    
    <!-- INCLUSIONS -->
    <?php if($sq_service_voucher['inclusions'] != ''){?> 
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>INCLUSIONS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_service_voucher['inclusions'] ?>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
    
    <section class="print_sec main_block">
    <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SPECIAL ARRANGEMENT : </span><?= $sq_service_voucher['special_arrangments'] ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- HOTEL Detail -->
    <?php
    $sq_count = mysql_num_rows(mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'"));
    if($sq_count != 0){
    ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>HOTEL DETAILs</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>DESTINATION</th>
                <th>HOTEL_NAME</th>
                <th>Check_In</th>
                <th>Check_Out</th>
              </tr>
            </thead>
            <tbody>   
            <?php             
            $sq_hotel_acc = mysql_query("select * from package_hotel_accomodation_master where booking_id='$booking_id'");
            while($row_hotel_acc=mysql_fetch_assoc($sq_hotel_acc))
            {  
              $sq_city_name = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_hotel_acc[city_id]'"));
              $sq_hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_hotel_acc[hotel_id]'"));
            ?>
                <tr>
                  <td><?= $sq_city_name['city_name'] ?></td>
                  <td><?= $sq_hotel_name['hotel_name'] ?></td>
                  <td><?= date('d-m-Y  H:i:s', strtotime($row_hotel_acc['from_date'])) ?></td>
                  <td><?= date('d-m-Y  H:i:s', strtotime($row_hotel_acc['to_date'])) ?></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php }?>

    <!-- Excursion Detail -->
    <?php
    $sq_count = mysql_num_rows(mysql_query("select * from package_tour_excursion_master where booking_id='$booking_id'"));
    if($sq_count != 0){
    ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>EXCURSION DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>City_Name</th>
                <th>Excursion_name</th>
              </tr>
            </thead>
            <tbody>
										<?php
										$sq_entry = mysql_query("select * from package_tour_excursion_master where booking_id='$booking_id'");
										while($row_entry = mysql_fetch_assoc($sq_entry)){
											$q_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));
											$q_transport = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_entry[exc_id]'"));
											?>
											<tr>
												<td><?= $q_city['city_name'] ?></td>
												<td><?= $q_transport['vehicle_name'] ?></td>
											</tr>
									<?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php }?>

    <!-- Tour Itinenary -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>TOUR ITINERARY</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul class="print_itinenary main_block no-pad no-marg noType">
          <?php
          $count = 1;
           while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
          ?>
            <li class="print_single_itinenary main_block">
              <div class="print_itinenary_count print_info_block">DAY - <?= $count ?></div>
              <div class="print_itinenary_desciption print_info_block">
                <div class="print_itinenary_attraction">
                  <span class="print_itinenary_attraction_icon"><i class="fa fa-map-marker"></i></span>
                  <samp class="print_itinenary_attraction_location"><?= $row_itinarary['attraction'] ?></samp>
                </div>
                <p><?= $row_itinarary['day_wise_program'] ?></p>
              </div>
              <div class="print_itinenary_details">
                <div class="print_info_block">
                  <ul class="main_block no-pad noType">
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?= $row_itinarary['stay'] ?></li>
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                  </ul>
                </div>
              </div>
            </li>
            <?php 
            $count ++; } ?>
          </ul>
        </div>
      </div>
    </section>

     <!-- Terms and Conditions -->
    <?php
    $sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Transport Service Voucher' and active_flag ='Active'"));
    if($sq_terms_cond['terms_and_conditions'] != ''){?> 
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php 
            echo $sq_terms_cond['terms_and_conditions'];   ?> 
          </div>
        </div>
      </div>
    </section>
    <?php } ?>

    <!-- Payment Detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5">
          <div class="print_quotation_creator text-center">
            <span>Generated BY </span><br><?= $emp_name ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>