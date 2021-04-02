<?php
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";
?>
<?php
$hotel_accomodation_id = $_GET['hotel_accomodation_id'];

$sq_service_voucher1 =mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Hotel Service Voucher' and active_flag ='Active'"));
$sq_accomodation1 =  mysql_query("select * from hotel_booking_entries where booking_id='$hotel_accomodation_id'") ;
while($sq_accomodation = mysql_fetch_assoc( $sq_accomodation1)){


$hotel_id = $sq_accomodation['hotel_id'];

$sq_hotel = mysql_fetch_assoc( mysql_query("select * from hotel_master where hotel_id='$hotel_id'") );
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
$email_id1 = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);

$booking_id = $sq_accomodation['booking_id'];
$sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));

$total_pax = $sq_booking['adults'] + $sq_booking['childrens'] + $sq_booking['infants'] ;

//Total days
$total_days1=strtotime($sq_accomodation['check_out']) - strtotime($sq_accomodation['check_in']);
$total_days = round($total_days1 / 86400);

$sq_customer_name = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
$name = $sq_customer_name['first_name'].' '.$sq_customer_name['last_name'];
$contact_no = $sq_customer_name['contact_no'];
$email_id = $sq_customer_name['email_id'];

$emp_id = $_SESSION['emp_id'];
$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
?>
 <div class="repeat_section main_block">
    <!-- header -->
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> HOTEL SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div><div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $sq_hotel['hotel_name']; ?></span><br>
          <p><?php echo $sq_hotel['hotel_address']; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $mobile_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $email_id1; ?></p>
        </div>
      </div>
    </section>

    <!-- print-detail -->
    <section class="print_sec main_block">
    <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                  <span>DURATION</span><br>
                  <?= ($total_days).'N' ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                  <span>TOTAL GUEST(s)</span><br>
                  <?= $sq_booking['adults'] ?> A, <?= $sq_booking['childrens'] ?> C, <?= $sq_booking['infants'] ?> I<br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-home" aria-hidden="true"></i><br>
                  <span>TOTAL ROOM(s)</span><br>
                  <?= $sq_accomodation['rooms'] ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-university" aria-hidden="true"></i><br>
                  <span>ROOM CATEGORY</span><br>
                  <?= $sq_accomodation['category'] ?><br>
                </div>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- BOOKING -->
    <section class="print_sec main_block">
      <div class="row">
        
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>GUEST NAME :</span> <?= $name ?></li>
          </ul>
        </div>
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CONFIRMATION ID :</span> <?= $sq_accomodation['conf_no'] ?></li>
          </ul>
        </div>
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CHECK-IN  :</span> <?= date('d-m-Y H:i',strtotime($sq_accomodation['check_in'])) ?></li>
          </ul>
        </div>
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CHECK-OUT :</span> <?= date('d-m-Y H:i',strtotime($sq_accomodation['check_out'])) ?></li>
          </ul>
        </div>
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>MEAL PLAN :</span> <?= $sq_accomodation['meal_plan'] ?></li>
          </ul>
        </div>
        <div class="col-md-6 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CONTACT :</span> <?= $sq_hotel['immergency_contact_no'] ?></li>
          </ul>
        </div>
      </div>
    </section>

    
    <!-- Terms and Conditions -->
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
            <?= $sq_service_voucher1['terms_and_conditions']; ?>
          </div>
        </div>
      </div>
    </section>

    <p style="float: left;width: 100%;"><b>Note: Please present this service voucher to service provider (Hotel/Transport) upon arrival</b></p>

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
    </div>
  </body>
</html>
<?php } ?>