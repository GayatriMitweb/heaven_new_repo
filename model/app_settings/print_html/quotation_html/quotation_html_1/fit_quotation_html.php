<?php
//Generic Files
include "../../../../model.php";
include "printFunction.php";

global $app_quot_img,$similar_text,$quot_note;
$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Package Quotation' and active_flag ='Active'")); 

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year = $yr[0];

$transport_agency_id = $sq_quotation['transport_agency_id'];
$sq_transport1 = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
$sq_package_name = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
$sq_dest = mysql_fetch_assoc(mysql_query("select link from video_itinerary_master where dest_id = '$sq_package_name[dest_id]'"));

$sq_transport = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
$sq_costing = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id'"));
$sq_package_program = mysql_query("select * from  package_quotation_program where quotation_id='$quotation_id'");

$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
  $emp_name = 'Admin';
}
else{
  $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}

$basic_cost = $sq_costing['basic_amount'];
$service_charge = $sq_costing['service_charge'];
$tour_cost= $basic_cost +$service_charge;
    $service_tax_amount = 0;
    $tax_show = '';
    $bsmValues = json_decode($sq_costing['bsmValues']);
    // var_dump($bsmValues);
if($sq_costing['service_tax_subtotal'] !== 0.00 && ($sq_costing['service_tax_subtotal']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_costing['service_tax_subtotal']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $tour_cost + $service_tax_amount;
  $tax_show = '';
}
else{
  // $tax_show = $service_tax_amount;
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newBasic = $tour_cost;
}

////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive markup
  $newBasic = $tour_cost + $service_tax_amount;
  $tax_show = '';
}

$quotation_cost = $basic_cost +$service_charge+ $service_tax_amount+ $sq_quotation['train_cost'] + $sq_quotation['cruise_cost']+ $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];

      ////////////Basic Amount Rules
      if($bsmValues[0]->basic != ''){ //inclusive markup
        $newBasic = $tour_cost + $service_tax_amount;
        $tax_show = '';
      }

      $quotation_cost = $basic_cost +$service_charge+ $service_tax_amount+ $sq_quotation['train_cost'] + $sq_quotation['cruise_cost']+ $sq_quotation['flight_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
?>

    <section class="headerPanel main_block">
        <div class="headerImage">
          <img src="<?= $app_quot_img?>" class="img-responsive">
          <div class="headerImageOverLay"></div>
        </div>
        <!-- Header -->
        <section class="print_header main_block side_pad mg_tp_30">
          <div class="col-md-4 no-pad">
            <div class="print_header_logo">
              <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
            </div>
          </div>
          <div class="col-md-4 no-pad text-center mg_tp_30">
            <span class="title"><i class="fa fa-pencil-square-o"></i> PACKAGE QUOTATION</span>
          </div>
        <?php
        include "standard_header_html.php";
        ?>
        <!-- print-detail -->
        <section class="print_sec main_block side_pad">
          <div class="row">
            <div class="col-md-12">
              <div class="print_info_block">
                <ul class="main_block">
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-calendar" aria-hidden="true"></i><br>
                      <span>QUOTATION DATE</span><br>
                      <?= get_date_user($sq_quotation['quotation_date']) ?><br>
                    </div>
                  </li>
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                      <span>DURATION</span><br>
                      <?php echo ($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D' ?><br>
                    </div>
                  </li>
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-users" aria-hidden="true"></i><br>
                      <span>TOTAL GUEST</span><br>
                      <?= $sq_quotation['total_passangers'] ?><br>
                    </div>
                  </li>
                  <li class="col-md-3 mg_tp_10 mg_bt_10">
                    <div class="print_quo_detail_block">
                      <i class="fa fa-tags" aria-hidden="true"></i><br>
                      <span>PRICE</span><br>
                      <?= number_format($quotation_cost,2) ?><br>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
    </section>

    <!-- Package -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>PACKAGE DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
          <ul class="print_info_list main_block">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>PACKAGE NAME :</span> <?= $sq_package_name['package_name'].'('.$sq_package_name['package_code'].')' ?> </li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CUSTOMER NAME :</span> <?= $sq_quotation['customer_name'] ?></li>
          </ul>
          <ul class="print_info_list main_block">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>QUOTATION ID :</span> <?= get_quotation_id($quotation_id,$year) ?></li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>E-MAIL ID :</span> <?= $sq_quotation['email_id'] ?></li>
          </ul>
          <hr class="main_block">
            <ul class="main_block">
              <li class="col-md-4 mg_tp_10 mg_bt_10"><span>ADULT : </span><?= $sq_quotation['total_adult'] ?></li>
              <li class="col-md-4 mg_tp_10 mg_bt_10"><span>CWB : </span><?= $sq_quotation['children_with_bed'] ?></li>
              <li class="col-md-4 mg_tp_10 mg_bt_10"><span>CWOB : </span><?= $sq_quotation['children_without_bed'] ?></li>
            </ul>
            <ul class="main_block">
              <li class="col-md-4 mg_tp_10 mg_bt_10"><span>INFANT : </span><?= $sq_quotation['total_infant'] ?></li>
              <li class="col-md-4 mg_tp_10 mg_bt_10"><span>TOTAL : </span><?= $sq_quotation['total_passangers'] ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Costing -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="row">
        <div class="col-md-6">
          <div class="section_heding">
            <h2>COSTING DETAILS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_info_block">
            <ul class="main_block">
            <?php if($sq_quotation['costing_type'] == 1){ ?>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TOUR COST : </span><?= round($newBasic) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TAX : </span><?= $tax_show ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TRAVEL COST : </span><?= number_format($sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost']+ $sq_quotation['guide_cost']+ $sq_quotation['misc_cost'],2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>QUOTATION COST : </span><?= number_format($quotation_cost,2) ?></li>
            <?php }
            else{?>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>ADULT COST : </span><?= number_format($sq_costing['adult_cost'],2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>CWB : </span><?= number_format($sq_costing['child_with'],2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>CWOB : </span><?= number_format($sq_costing['child_without'],2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>INFANT COST : </span><?= number_format($sq_costing['infant_cost'],2) ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <!-- Bank Detail -->
        <div class="col-md-6">
          <div class="section_heding">
            <h2>BANK DETAILS</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_info_block">
            <ul class="main_block">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>BANK NAME : </span><?= $bank_name_setting ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C TYPE : </span><?= $acc_name ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>BRANCH : </span><?= $bank_branch_name ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C NO : </span><?= $bank_acc_no ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>IFSC : </span><?= $bank_ifsc_code ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>SWIFT CODE : </span><?= $bank_swift_code ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

  <!-- Count queries -->
  <?php
  $sq_package_count = mysql_num_rows(mysql_query("select * from  package_quotation_program where quotation_id='$quotation_id'"));
  $sq_hotel_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'"));
  $sq_transport_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
  $sq_exc_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'"));

  $sq_train_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id'"));
  $sq_plane_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'"));
  $sq_cruise_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
  ?>
  <!-- print-detail -->    
    <!-- Tour Itinenary -->
    <?php if($sq_package_count != 0){ ?>
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
              <div class="print_quo_detail_block">
                <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive">
                &nbsp;VIDEO ITINERARY :&nbsp;<a href="<?=$sq_dest['link']?>" class="no-marg itinerary-link" target="_blank"> </a>
              </div>
          </div>
        </div>
      </div>

      <div class="section_heding mg_tp_20">
        <h2>TOUR ITINERARY</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="">
        <div class="col-md-12">
          <div class="print_itinenary main_block no-pad no-marg">
          <?php 
            $count = 1;
            while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
              $last_child = ($sq_package_count == $count) ? 'last-child' : '';
            ?>
            <section class="print_single_itinenary main_block <?= $last_child ?>">
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
                  <ul class="main_block no-pad">
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?=  $row_itinarary['stay'] ?></li>
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                  </ul>
                </div>
              </div>
            </section>
            <?php $count++; } ?>
            </div>
        </div>
      </div>
    </section>
    <?php } ?>
    


    <!-- Traveling Sections -->
    <section class="print_sec main_block">
        
          <!-- Accomodations -->
          <?php if($sq_hotel_count != 0){?>
          <section class="print_sec main_block side_pad mg_tp_30">
            <div class="section_heding">
              <h2>ACCOMMODATION</h2>
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
                      <th>City</th>
                      <th>Hotel Name</th>
                      <th>Check_IN</th>
                      <th>Check_OUT</th>
                    </tr>
                  </thead>
                  <tbody> 
                <?php $sq_hotel = mysql_query("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'");
                while($row_hotel = mysql_fetch_assoc($sq_hotel)){
                  $hotel_name = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                  $city_name = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_hotel[city_name]'"));
                ?>
                <tr>
                    <?php
                    $sq_count_h = mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id='$row_hotel[hotel_name]' "));
                    if($sq_count_h ==0){
                      $download_url =  BASE_URL.'images/dummy-image.jpg';
                    }
                    else{
                      $sq_hotel_image = mysql_query("select * from hotel_vendor_images_entries where hotel_id = '$row_hotel[hotel_name]'");
                      while($row_hotel_image = mysql_fetch_assoc($sq_hotel_image)){      
                          $image = $row_hotel_image['hotel_pic_url']; 
                          $newUrl = preg_replace('/(\/+)/','/',$image);
                          $newUrl = explode('uploads', $newUrl);
                          $download_url = BASE_URL.'uploads'.$newUrl[1];
                        }
                    }
                    ?>
                      <td><?php echo $city_name['city_name']; ?></td>
                      <td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
                      <td><?= get_date_user($row_hotel['check_in']) ?></td>
                      <td><?= get_date_user($row_hotel['check_out']) ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            </div>
          </section>
          <?php } ?>

          <?php if($sq_transport_count != 0 || $sq_train_count != 0 || $sq_plane_count != 0 || $sq_train_count != 0 || $sq_exc_count != 0){?>
          <section class="print_sec main_block side_pad mg_tp_30">
                <div class="section_heding">
                  <h2>Travelling Information</h2>
                  <div class="section_heding_img">
                    <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
                  </div>
                </div>

                <!-- Train -->
                <?php
                if($sq_train_count>0){ ?>
                  <div class="row mg_tp_30">
                    <div class="col-md-12 subTitle">
                      <h3>Train</h3>
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered no-marg" id="tbl_emp_list">
                        <thead>
                          <tr class="table-heading-row">
                            <th>From</th>
                            <th>To</th>
                            <th>Class</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sq_train = mysql_query("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id'");
                        while($row_train = mysql_fetch_assoc($sq_train)){  
                          ?>
                          <tr>
                            <td><?= $row_train['from_location'] ?></td>
                            <td><?= $row_train['to_location'] ?></td>
                            <td><?= $row_train['class'] ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row_train['departure_date'])) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row_train['arrival_date'])) ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>
                <?php } ?>
                <!-- Flight -->
                <?php
                if($sq_plane_count>0){ 
                ?>
                  <div class="row mg_tp_30">
                    <div class="col-md-12 subTitle">
                      <h3>Flight</h3>
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered no-marg" id="tbl_emp_list">
                        <thead>
                          <tr class="table-heading-row">
                            <th>From</th>
                            <th>To</th>
                            <th>Airline</th>
                            <th>Class</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $sq_plane = mysql_query("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'");
                            while($row_plane = mysql_fetch_assoc($sq_plane)){
                            $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane[airline_name]'"));
                          ?>   
                          <tr>
                            <td><?= $row_plane['from_location'] ?></td>
                            <td><?= $row_plane['to_location'] ?></td>
                            <td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
                            <td><?= $row_plane['class'] ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($row_plane['dapart_time'])) ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($row_plane['arraval_time'])) ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>
                <?php } ?>
                <!-- Cruise -->
                <?php
                if($sq_cruise_count>0){ ?>
                  <div class="row mg_tp_30">
                    <div class="col-md-12 subTitle">
                      <h3>Cruise</h3>
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered no-marg" id="tbl_emp_list">
                        <thead>
                          <tr class="table-heading-row">
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Route</th>
                            <th>Cabin</th>
                            <th>Sharing</th>
                          </tr>
                        </thead>
                        <tbody>  
                        <?php 
                        $sq_cruise = mysql_query("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
                        while($row_cruise = mysql_fetch_assoc($sq_cruise)){  
                          ?>
                          <tr>
                            <td><?= date('d-m-Y H:i', strtotime($row_cruise['dept_datetime'])) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($row_cruise['arrival_datetime'])) ?></td>
                            <td><?= $row_cruise['route'] ?></td>
                            <td><?= $row_cruise['cabin'] ?></td>
                            <td><?= $row_cruise['sharing'] ?></td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>  
                <?php } ?> 
          <!-- Transport -->
          <?php
          if($sq_transport_count>0){ ?>
            <div class="row mg_tp_30">
              <div class="col-md-12 subTitle">
                <h3>Transport</h3>
              </div>
              <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>VEHICLE</th>
                      <th>START DATE</th>
                      <th>PICKUP LOCATION</th>
                      <th>DROP LOCATION</th>
                      <th>TOTAL VEHICLES</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $count = 0;
                  $sq_hotel = mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'");
                  while($row_hotel = mysql_fetch_assoc($sq_hotel))
                  {
                    $transport_name = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_hotel[vehicle_name]'"));
                    // Pickup
                    if($row_hotel['pickup_type'] == 'city'){
                      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
                      $pickup = $row['city_name'];
                    }
                    else if($row_hotel['pickup_type'] == 'hotel'){
                      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
                      $pickup = $row['hotel_name'];
                    }
                    else{
                      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
                      $airport_nam = clean($row['airport_name']);
                      $airport_code = clean($row['airport_code']);
                      $pickup = $airport_nam." (".$airport_code.")";
                    }
                    //Drop-off
                    if($row_hotel['drop_type'] == 'city'){
                      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
                      $drop = $row['city_name'];
                    }
                    else if($row_hotel['drop_type'] == 'hotel'){
                      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
                      $drop = $row['hotel_name'];
                    }
                    else{
                      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
                      $airport_nam = clean($row['airport_name']);
                      $airport_code = clean($row['airport_code']);
                      $drop = $airport_nam." (".$airport_code.")";
                    }
                    ?>
                    <tr>
                      <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                      <td><?= date('d-m-Y', strtotime($row_hotel['start_date'])) ?></td>
                      <td><?= $pickup ?></td>
                      <td><?= $drop ?></td>
                      <td><?= $row_hotel['vehicle_count'] ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
              </div>  
            </div>
        <?php } ?>
        
          <!-- Activity -->
          <?php
          if($sq_exc_count>0){ ?>
            <div class="row mg_tp_30">
              <div class="col-md-12 subTitle">
                <h3>Activity</h3>
              </div>
              <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>Activity Date</th>
                      <th>City Name</th>
                      <th>Activity Name</th>
                      <th>Transfer Option</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $count = 0;
                  $sq_ex = mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'");
                  while($row_ex = mysql_fetch_assoc($sq_ex))
                  {
                    $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_ex[city_name]'"));
                    $sq_ex_name = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_ex[excursion_name]'"));
                    ?>
                    <tr>
                      <td><?= get_datetime_user($row_ex['exc_date']) ?></td>
                      <td><?= $sq_city['city_name'] ?></td>
                      <td><?= $sq_ex_name['excursion_name'] ?></td>
                      <td><?= $row_ex['transfer_option'] ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
              </div>  
            </div>
        <?php } ?>

    </section>
    <?php } ?>        

    <!-- Inclusion -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="row">
    <?php if($sq_quotation['inclusions'] != ''){ ?>
        <div class="col-md-6">
          <div class="section_heding">
            <h2>Inclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_quotation['inclusions'] ?>
          </div>
        </div>
    <?php } ?>

    <!-- Exclusion -->
    <?php if($sq_quotation['exclusions'] != ''){ ?>
        <div class="col-md-6">
          <div class="section_heding">
            <h2>Exclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_quotation['exclusions'] ?>
          </div>
        </div>
    <?php } ?>
      </div>
    </section>

    

    <!-- Terms and Conditions -->
    <section class="print_sec main_block side_pad mg_tp_30">
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){ ?>
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
           <?php echo $sq_terms_cond['terms_and_conditions']; ?>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="row mg_tp_10">
      <div class="col-md-12">
        <?php echo $quot_note; ?>
      </div>
    </div>

      <div class="row mg_tp_30">
        <div class="col-md-7"></div>
        <div class="col-md-5 mg_tp_30">
          <div class="print_quotation_creator text-center">
            <span>PREPARE BY </span><br><?= $emp_name?>
          </div>
        </div>
      </div>
    </section>


  </body>
</html>