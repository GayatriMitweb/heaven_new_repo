<?php
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";

$booking_id = $_GET['booking_id'];

$sq_service_voucher = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
$cart_list_arr = json_decode($sq_service_voucher['cart_checkout_data']);
$traveller_details = json_decode($sq_service_voucher['traveller_details']);
$timing_slots = explode(',',$sq_service_voucher['timing_slots']);

$hotel_list_arr = array();
$transfer_list_arr = array();
$activity_list_arr = array();
$tours_list_arr = array();
for($i=0;$i<sizeof($cart_list_arr);$i++){
  if($cart_list_arr[$i]->service->name == 'Hotel'){
    array_push($hotel_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]->service->name == 'Transfer'){
    array_push($transfer_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]->service->name == 'Activity'){
    array_push($activity_list_arr,$cart_list_arr[$i]);
  }
  if($cart_list_arr[$i]->service->name == 'Combo Tours'){
    array_push($tours_list_arr,$cart_list_arr[$i]);
  }
}

$sq_reg = mysql_fetch_assoc(mysql_query("select * from b2b_registration where customer_id='$sq_service_voucher[customer_id]'"));
$emp_name = $sq_reg['company_name'];
$company_logo_url = $sq_reg['company_logo'];
$newUrl = preg_replace('/(\/+)/','/',$company_logo_url);
$newUrl = explode('uploads', $newUrl);
$company_logo_url = BASE_URL.'uploads'.$newUrl[1];

//Hotel service voucher
if(sizeof($hotel_list_arr) > 0){
  for($hi=0;$hi<sizeof($hotel_list_arr);$hi++){

    $hotel_traveller_arr = array();
    $hotel_id = $hotel_list_arr[$hi]->service->id;

    for($kk=0;$kk<sizeof($traveller_details);$kk++){
      if($traveller_details[$kk]->service->name == 'Hotel' && $traveller_details[$kk]->service->id == $hotel_id){
        array_push($hotel_traveller_arr,$traveller_details[$kk]);
      }
    }
    $tax_arr = explode(',',$hotel_list_arr[$hi]->service->hotel_arr->tax);
    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
    $mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
    $email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);
    $confirmation_number_db = mysql_fetch_assoc(mysql_query("SELECT confirmation_no_details FROM b2b_booking_master where booking_id = '$booking_id'"));
    $confirmation_number = json_decode($confirmation_number_db['confirmation_no_details']);
    ?>
    <div class="repeat_section main_block">
    
    <!-- header Start -->
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> HOTEL SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $company_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $sq_hotel['hotel_name']; ?></span><br>
          <p><?php echo $sq_hotel['hotel_address']; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $mobile_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $email_id; ?></p>
          <!-- <span>TAT LICENSE: 14/01963</span><br>
          <span>ATTA MEMBER: 04462</span> -->
        </div>
      </div>
    </section>

    <!-- print-detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="section_heding">
          <h2>BOOKING DETAILS</h2>
          <div class="section_heding_img">
            <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CUSTOMER NAME :</span> <?= $sq_service_voucher['fname'].' '.$sq_service_voucher['lname'] ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CONTACT NO :</span> <?= $sq_service_voucher['contact_no'] ?></li>
            </ul>
          </div>
        </div>
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
            <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <span>Confirmation Number</span><br>
                  <?= $confirmation_number->{$hotel_list_arr[$hi]->service->uuid} ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <span>CHECK-IN DATE</span><br>
                  <?= date('m-d-Y', strtotime($hotel_list_arr[$hi]->service->check_in)); ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <span>CHECK-OUT DATE</span><br>
                  <?= date('m-d-Y', strtotime($hotel_list_arr[$hi]->service->check_out)); ?><br>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- BOOKING -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <?php for($i=0;$i<sizeof($hotel_traveller_arr);$i++){
              if($hotel_id == $hotel_traveller_arr[$i]->service->id){
                $room_types = explode('-',$hotel_list_arr[$hi]->service->item_arr[$i]);
                $room_cat = $room_types[1]; ?>
                  <ul class="main_block noType">
                    <?php
                    for($j=0;$j<sizeof($hotel_traveller_arr[$i]->service->room_arr);$j++){ ?>
                      <h6><?= 'Room '.($j+1).' : '.$room_cat ?></h6>
                          <!-- Adults -->
                          <?php for($k=0;$k<sizeof($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr);$k++){
                                $pass_name =  $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->honorofic.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->fname.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->lname;
                          ?>
                            <li class="col-md-4 mg_tp_10 mg_bt_10"><?php echo $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->adult_arr[$k]->adult_count.' : '.$pass_name ?></li>
                            <?php } ?>
                            <!-- Children -->
                            <?php for($k=0;$k<sizeof($hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr);$k++){
                                $pass_name =  $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->chonorofic.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->cfname.' '.$hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->clname;
                            ?>
                            <li class="col-md-4 mg_tp_10 mg_bt_10"><?php echo $hotel_traveller_arr[$i]->service->room_arr[$j]->dummy_id->child_arr[$k]->child_count.' : '.$pass_name ?></li>
                          <?php } ?>
                    <?php } ?>
                  </ul>
            <?php }
            } ?>
            <?php if($sq_service_voucher['sp_request']!=''){ ?>
            <div class="row">
              <div class="col-md-12">
                  <ul class="main_block noType">
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SPECIAL REQUEST : </span><?= $sq_service_voucher['sp_request'] ?></li>
                  </ul>
              </div>
            </div>
            <?php } ?>
          </div>
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
            <?php 
            $sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Hotel Service Voucher' and active_flag ='Active'"));
            echo $sq_terms_cond['terms_and_conditions'];   ?> 
          </div>
        </div>
      </div>
    </section>
    
    <!-- ID Proof -->
    <?php     
    $sq_traveler_id = mysql_fetch_assoc(mysql_query("select * from package_travelers_details where booking_id='$hotel_accomodation_id'"));  
    $id_proof_image = $sq_traveler_id['id_proof_url'];
    if($id_proof_image != ''){
      $newUrl = preg_replace('/(\/+)/','/',$id_proof_image);
      $newUrl = explode('uploads', $newUrl);
      $newUrl = BASE_URL.'uploads'.$newUrl[1];
    ?>
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>ID PROOF</h2>
            <div class="section_heding_img">
              <img src="<?= $newUrl ?>" class="img-responsive">
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php } ?>
    

    <p style="float: left;width: 100%;">Note: Please present this confirmation to service provider (Hotel/Transport) upon arrival</p>

    <!-- Payment Detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5">
          <div class="print_quotation_creator text-center">
            <span>Generated By </span><br><?= $emp_name ?>
          </div>
        </div>
      </div>
    </section>
    </div>
  <?php }
}

//Transfer service voucher
if(sizeof($transfer_list_arr) > 0){
  for($i=0;$i<sizeof($transfer_list_arr);$i++){
    ?>
    <div class="repeat_section main_block">
      <section class="print_header main_block">
        <div class="col-md-6 no-pad">
        <span class="title"><i class="fa fa-file-text"></i> TRANSPORT SERVICE VOUCHER</span>
          <div class="print_header_logo">
            <img src="<?= $company_logo_url ?>" class="img-responsive mg_tp_10">
          </div>
        </div>
        <div class="col-md-6 no-pad">
          <div class="print_header_contact text-right">
            <span class="title"><?php echo $emp_name; ?></span><br>
            <p><?php echo $sq_reg['address1'].' '.$sq_reg['address2']; ?></p>
            <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $sq_reg['mobile_no']; ?></p>
            <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $sq_reg['email_id']; ?></p>
            <!-- <span>TAT LICENSE: 14/01963</span><br>
            <span>ATTA MEMBER: 04462</span> -->
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
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CUSTOMER NAME :</span> <?= $sq_service_voucher['fname'].' '.$sq_service_voucher['lname'] ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CONTACT NO :</span> <?= $sq_service_voucher['contact_no'] ?></li>
            </ul>
          </div>
        </div>
      </section>
      
      <!-- Transport Details -->
      <section class="print_sec main_block">
        <div class="row">
            <?php
              for($j=0;$j<sizeof($cart_list_arr[$i]->service);$j++){
              //Pickup n drop location
              $pickup_id = $transfer_list_arr[$i]->service->service_arr[$j]->pickup_from;
              if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'city'){
                $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$pickup_id'"));
                $pickup = $row['city_name'];
              }
              else if($transfer_list_arr[$i]->service->service_arr[$j]->pickup_type == 'hotel'){
                $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$pickup_id'"));
                $pickup = $row['hotel_name'];
              }
              else{
                $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$pickup_id'"));
                $airport_nam = clean($row['airport_name']);
                $airport_code = clean($row['airport_code']);
                $pickup = $airport_nam." (".$airport_code.")";
              }
              //Drop-off
              $drop_id = $transfer_list_arr[$i]->service->service_arr[$j]->drop_to;
              if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'city'){
                $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$drop_id'"));
                $drop = $row['city_name'];
              }
              else if($transfer_list_arr[$i]->service->service_arr[$j]->drop_type == 'hotel'){
                $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$drop_id'"));
                $drop = $row['hotel_name'];
              }
              else{
                $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$drop_id'"));
                $airport_nam = clean($row['airport_name']);
                $airport_code = clean($row['airport_code']);
                $drop = $airport_nam." (".$airport_code.")";
              }
              $vehicle_id = $transfer_list_arr[$i]->service->id;
              ?>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>VEHICLE NAME :</span> <?= $transfer_list_arr[$i]->service->service_arr[$j]->vehicle_name.'('.$transfer_list_arr[$i]->service->service_arr[$j]->vehicle_type.')' ?></li>
            </ul>
          </div>
          <div class="col-md-3 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TRIP TYPE :</span> <?= ucfirst($transfer_list_arr[$i]->service->service_arr[$j]->trip_type) ?></li>
            </ul>
          </div>
          <div class="col-md-3 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>NO OF VEHICLES :</span> <?= $transfer_list_arr[$i]->service->service_arr[$j]->no_of_vehicles ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>PICKUP LOCATION :</span> <?= $pickup ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>DROP LOCATION :</span> <?= $drop ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>PICKUP DATETIME :</span> <?= date('m-d-Y H:i:s', strtotime($transfer_list_arr[$i]->service->service_arr[$j]->pickup_date)) ?></li>
            </ul>
          </div>
          <?php if($transfer_list_arr[$i]->service->service_arr[$j]->trip_type == 'roundtrip'){ ?>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>RETURN DATETIME :</span> <?= date('m-d-Y H:i:s', strtotime($transfer_list_arr[$i]->service->service_arr[$j]->return_date)) ?></li>
            </ul>
          </div>
          <?php } ?>
        <?php } ?>
        </div>
      </section>
      <?php if($sq_service_voucher['sp_request']!=''){ ?>
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="print_info_block">
              <ul class="main_block noType">
                <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SPECIAL REQUEST : </span><?= $sq_service_voucher['sp_request'] ?></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Cancellation Policy -->
      <?php
      $sq_canc = mysql_fetch_assoc(mysql_query("select cancellation_policy from b2b_transfer_master where entry_id='$vehicle_id'"));
      if($sq_canc['cancellation_policy'] != ''){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Cancellation Policy</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_canc['cancellation_policy'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
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
              <span>Generated By </span><br><?= $emp_name ?>
            </div>
          </div>
        </div>
      </section>

    </div>
  <?php }
}
//Activity service voucher
if(sizeof($activity_list_arr) > 0){
  for($i=0;$i<sizeof($activity_list_arr);$i++){
    $transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
    $transfer = $transfer_types[0];
    $exc_id = $activity_list_arr[$i]->service->id;
    $sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$exc_id'"));
    ?>
    <div class="repeat_section main_block">
      <section class="print_header main_block">
        <div class="col-md-6 no-pad">
        <span class="title"><i class="fa fa-file-text"></i> ACTIVITY SERVICE VOUCHER</span>
          <div class="print_header_logo">
            <img src="<?= $company_logo_url ?>" class="img-responsive mg_tp_10">
          </div>
        </div>
        <div class="col-md-6 no-pad">
          <div class="print_header_contact text-right">
            <span class="title"><?php echo $emp_name; ?></span><br>
            <p><?php echo $sq_reg['address1'].' '.$sq_reg['address2']; ?></p>
            <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $sq_reg['mobile_no']; ?></p>
            <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $sq_reg['email_id']; ?></p>
            <!-- <span>TAT LICENSE: 14/01963</span><br>
            <span>ATTA MEMBER: 04462</span> -->
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
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CUSTOMER NAME :</span> <?= $sq_service_voucher['fname'].' '.$sq_service_voucher['lname'] ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CONTACT NO :</span> <?= $sq_service_voucher['contact_no'] ?></li>
            </ul>
          </div>
        </div>
      </section>
      
      <!-- Transport Details -->
      <section class="print_sec main_block">
        <div class="section_heding">
          <h2>ACTIVITY DETAILS</h2>
          <div class="section_heding_img">
            <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>ACTIVITY NAME :</span> <?= $activity_list_arr[$i]->service->service_arr[0]->act_name ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CHECK DATE :</span> <?= date('m-d-Y', strtotime($activity_list_arr[$i]->service->service_arr[0]->checkDate)) ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TOTAL GUEST :</span> <?= $activity_list_arr[$i]->service->service_arr[0]->total_pax ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TRANSFER TYPE :</span> <?= $transfer ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>REPORTING TIME :</span> <?= $activity_list_arr[$i]->service->service_arr[0]->rep_time ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>PICKUP POINT :</span> <?= $activity_list_arr[$i]->service->service_arr[0]->pick_point ?></li>
            </ul>
          </div>
          <?php if($timing_slots[$i] != ''){ ?>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TIMING SLOT :</span> <?= $timing_slots[$i] ?></li>
            </ul>
          </div>
          <?php } ?>
          </div>
        </div>
      </section>
      <?php if($sq_service_voucher['sp_request']!=''){ ?>
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="print_info_block">
              <ul class="main_block noType">
                <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SPECIAL REQUEST : </span><?= $sq_service_voucher['sp_request'] ?></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Incl -->
      <?php
      if($sq_exc['inclusions'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Inclusions</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_exc['inclusions'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Excl -->
      <?php
      if($sq_exc['exclusions'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Exclusions</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_exc['exclusions'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Terms and Conditions -->
      <?php
      if($sq_exc['terms_condition'] != ' '){?> 
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
              echo $sq_exc['terms_condition'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Booking Policy -->
      <?php
      if($sq_exc['booking_policy'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Booking Policy</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_exc['booking_policy'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Cancellation -->
      <?php
      if($sq_exc['canc_policy'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Cancellation Policy</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_exc['canc_policy'];   ?> 
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
              <span>Generated By </span><br><?= $emp_name ?>
            </div>
          </div>
        </div>
      </section>

    </div>
  <?php }
}
//Combo Tours service voucher
if(sizeof($tours_list_arr) > 0){
  for($i=0;$i<sizeof($tours_list_arr);$i++){
    $package_id = $tours_list_arr[$i]->service->id;
    $sq_pckg = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
    ?>
    <div class="repeat_section main_block">
      <section class="print_header main_block">
        <div class="col-md-6 no-pad">
        <span class="title"><i class="fa fa-file-text"></i> COMBO TOURS VOUCHER</span>
          <div class="print_header_logo">
            <img src="<?= $company_logo_url ?>" class="img-responsive mg_tp_10">
          </div>
        </div>
        <div class="col-md-6 no-pad">
          <div class="print_header_contact text-right">
            <span class="title"><?php echo $emp_name; ?></span><br>
            <p><?php echo $sq_reg['address1'].' '.$sq_reg['address2']; ?></p>
            <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $sq_reg['mobile_no']; ?></p>
            <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $sq_reg['email_id']; ?></p>
            <!-- <span>TAT LICENSE: 14/01963</span><br>
            <span>ATTA MEMBER: 04462</span> -->
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
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CUSTOMER NAME :</span> <?= $sq_service_voucher['fname'].' '.$sq_service_voucher['lname'] ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>CONTACT NO :</span> <?= $sq_service_voucher['contact_no'] ?></li>
            </ul>
          </div>
        </div>
      </section>
      
      <!-- Combo Tours Details -->
      <section class="print_sec main_block">
        <div class="section_heding">
          <h2>PACKAGE DETAILS</h2>
          <div class="section_heding_img">
            <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>PACKAGE NAME :</span> <?= $tours_list_arr[$i]->service->service_arr[0]->package.'('.$tours_list_arr[$i]->service->service_arr[0]->package_code.')' ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TOTAL STAY :</span> <?= $tours_list_arr[$i]->service->service_arr[0]->nights.'N/'.$tours_list_arr[$i]->service->service_arr[0]->days.'D' ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TRAVEL DATE :</span> <?= get_date_user($tours_list_arr[$i]->service->service_arr[0]->travel_date) ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>TOTAL GUEST :</span> <?= $tours_list_arr[$i]->service->service_arr[0]->adult+$tours_list_arr[$i]->service->service_arr[0]->childwo+$tours_list_arr[$i]->service->service_arr[0]->childwi+$tours_list_arr[$i]->service->service_arr[0]->infant ?></li>
            </ul>
          </div>
          <div class="col-md-6 mg_bt_20">
            <ul class="print_info_list no-pad noType">
              <li><span>EXTRA BED :</span> <?= $tours_list_arr[$i]->service->service_arr[0]->extra_bed ?></li>
            </ul>
          </div>
        </div>
      </section>
      
      <!-- Itinerary -->
      <section class="itinerarySec main_block side_pad mg_tp_30">
        <div class="section_heding">
          <h2>ITINERARY DETAILS</h2>
          <div class="section_heding_img">
            <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
          </div>
        </div>
        <ul class="print_itinenary main_block no-pad no-marg">
          <?php
          $count = 1;
          $sq_package_program = mysql_query("select * from custom_package_program where package_id = '$package_id'");
          while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
          ?>
          <li class="singleItinenrary leftItinerary col-md-12 no-pad mg_bt_20">
            <div class="dayCount">
              <h4>Day-<?= $count ?></h4>
            </div>
            <div class="itneraryContent col-md-12 no-pad mg_tp_10">
                <h5 class="specialAttraction no-marg">Special Attraction : <?= $row_itinarary['attraction'] ?></h5>
                <pre class="real_text"><?= $row_itinarary['day_wise_program'] ?></pre>
            </div>
            <ul class="no-marg no-pad">
              <li><span><i class="fa fa-bed"></i> : </span><?=  $row_itinarary['stay'] ?></li>
              <li><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
            </ul>
          </li>
          <?php $count++; } ?>
        </ul>
      </section>

      <?php if($sq_service_voucher['sp_request']!=''){ ?>
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="print_info_block">
              <ul class="main_block noType">
                <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SPECIAL REQUEST : </span><?= $sq_service_voucher['sp_request'] ?></li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
            
      <?php
      $sq_hotelc = mysql_num_rows(mysql_query("select * from custom_package_hotels where package_id='$package_id'"));
      if($sq_hotelc!=0){?>
      <!-- traveling Information -->
      <section class="travelingDetails main_block mg_tp_30">
            <!-- Hotel -->
            <section class="transportDetails main_block side_pad mg_tp_30">
              <div class="row mg_bt_20">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                  <div class="transportImg">
                    <img src="<?= BASE_URL ?>images/quotation/hotel.png" class="img-responsive">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="table-responsive mg_tp_30">
                    <table class="table table-bordered no-marg" id="tbl_emp_list">
                      <thead>
                        <tr class="table-heading-row">
                        <th>City</th>
                        <th>Hotel Name</th>
                        <th>Total Nights</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sq_hotel = mysql_query("select * from custom_package_hotels where package_id='$package_id'");
                        while($row_hotel = mysql_fetch_assoc($sq_hotel)){
                          $hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                          $city_name = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_hotel[city_name]'"));
                        ?>
                          
                        <tr>
                            <?php
                            $sql = mysql_fetch_assoc(mysql_query("select * from hotel_vendor_images_entries where hotel_id='$row_hotel[hotel_name]'"));
                            $sq_count_h = mysql_num_rows(mysql_query("select * from custom_package_hotels where package_id='$package_id' "));
                            if($sq_count_h ==0){
                              $download_url =  BASE_URL.'images/dummy-image.jpg';
                            }
                            else{
                              $image = $sql['hotel_pic_url']; 
                              $download_url = preg_replace('/(\/+)/','/',$image);
                            }
                            ?>
                            <td><?php echo $city_name['city_name']; ?></td>
                            <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                            <td></span><?php echo $row_hotel['total_days']; ?></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>  
              </div>
            </section>
      </section>
      <?php } ?>
      <!-- traveling Information -->
      <?php
      $sq_hotelc = mysql_num_rows(mysql_query("select * from custom_package_transport where package_id='$package_id'"));
      if($sq_hotelc!=0){?>
      <section class="travelingDetails main_block mg_tp_20">
            <!-- Transport -->
            <section class="transportDetails main_block side_pad mg_tp_30">
              <div class="row mg_bt_20">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                  <div class="transportImg">
                    <img src="<?= BASE_URL ?>images/quotation/car.png" class="img-responsive">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="table-responsive mg_tp_30">
                    <table class="table table-bordered no-marg" id="tbl_emp_list">
                      <thead>
                        <tr class="table-heading-row">
                          <th>VEHICLE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $count = 0;
                        $sq_hotel = mysql_query("select * from custom_package_transport where package_id='$package_id'");
                        while($row_hotel = mysql_fetch_assoc($sq_hotel)){
                          $transport_name = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_hotel[vehicle_name]'"));
                          ?>
                          <tr>
                            <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>  
              </div>
            </section>
      </section>
      <?php } ?>

      <!-- Incl -->
      <?php
      if($sq_pckg['inclusions'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Inclusions</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_pckg['inclusions'];   ?> 
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Excl -->
      <?php
      if($sq_pckg['exclusions'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Exclusions</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php 
              echo $sq_pckg['exclusions']; ?>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
      <!-- Terms -->
      <?php
      $sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Package Service Voucher' and active_flag ='Active'"));
      if($sq_terms_cond['terms_and_conditions'] != ' '){?> 
      <section class="print_sec main_block">
        <div class="row">
          <div class="col-md-12">
            <div class="section_heding">
              <h2>Terms & Condition</h2>
              <div class="section_heding_img">
                <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
              </div>
            </div>
            <div class="print_text_bolck">
              <?php
              echo $sq_terms_cond['terms_and_conditions']; ?>
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
              <span>Generated By </span><br><?= $emp_name ?>
            </div>
          </div>
        </div>
      </section>

    </div>
  <?php }
}
?>
</body>
</html>