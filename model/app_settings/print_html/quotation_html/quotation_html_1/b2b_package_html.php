<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img;

$package_id=$_GET['package_id'];
$sq_pckg = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$package_id'"));
$sq_dest = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id='$sq_pckg[dest_id]'"));
?>

<section class="headerPanel main_block">
  <div class="headerImage">
    <img src="<?= $app_quot_img?>" class="img-responsive" style="height:180px !important;">
    <div class="headerImageOverLay"></div>
  </div>

  <!-- header -->
  <section class="print_header main_block side_pad mg_tp_30">
    <div class="col-md-4 no-pad">
      <div class="print_header_logo">
        <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
      </div>
    </div>
    <div class="col-md-4 no-pad text-center mg_tp_30">
      <span class="title"><i class="fa fa-pencil-square-o"></i> PACKAGE TOUR</span>
    </div>

    <?php 
    include "standard_header_html.php";
    ?>

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
              <ul class="main_block">
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>DESTINATION :</span> <?= $sq_dest['dest_name'] ?></li>
              </ul>
              <ul class="main_block">
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>PACKAGE NAME :</span> <?= $sq_pckg['package_name'] ?></li>
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>PACKAGE CODE :</span> <?=  $sq_pckg['package_code'] ?></li>
              </ul>
              <ul class="main_block">
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOTAL DAYS :</span> <?= $sq_pckg['total_days'] ?></li>
                <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOTAL NIGHTS :</span> <?= $sq_pckg['total_nights'] ?></li>
              </ul>
            </div>
          </div>
        </div>
    <!-- Tour Itinenary -->
    
    <!-- SIGHTSEEING -->
    <!-- <?php 
     $sq_img = mysql_query("select * from custom_package_images where package_id='$package_id'");
    ?>
      <div class="section_heding mg_tp_30">
        <h2>SIGHTSEEING</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row print_sigthseing_images">
      <?php while ($row_img = mysql_fetch_assoc($sq_img) ) 
         {
           $count_i++;
           $url = $row_img['image_url'];
            $pos = strstr($url,'uploads');
            if ($pos != false)   {
                $newUrl = preg_replace('/(\/+)/','/',$row_img['image_url']); 
                $newUrl1 = BASE_URL.str_replace('../', '', $newUrl);
            }
            else{
                $newUrl1 =  $row_img['image_url']; 
            }
         ?>
        <div class="col-md-6 no-pad">
          <img src="<?= $newUrl1 ?>" class="img-responsive">
        </div>
        <?php 
        }?>
      </div> -->
  
    </section>  
  <!-- SIGHTSEEING -->

    <!-- Tour Itinenary -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>TOUR ITINERARY</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_itinenary main_block no-pad no-marg">          
          <?php 
          $count = 1;
          $sq_package_program = mysql_query("select * from custom_package_program where package_id = '$package_id'");
          while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
          ?>
            <section class="print_single_itinenary main_block">
              <div class="print_itinenary_count print_info_block">DAY - <?php echo $count++; ?></div>
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
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-bed"></i> : </span><?= $row_itinarary['stay'] ?></li>
                    <li class="col-md-12 mg_tp_10 mg_bt_10"><span><i class="fa fa-cutlery"></i> : </span><?= $row_itinarary['meal_plan'] ?></li>
                  </ul>
                </div>
              </div>
            </section>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  
    <!-- Hotel -->
    <?php
    $sq_hotelc = mysql_num_rows(mysql_query("select * from custom_package_hotels where package_id='$package_id'"));
    if($sq_hotelc!=0){?>
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>HOTEL DETAILS</h2>
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
                <th>Total Nights</th>
              </tr>
            </thead>
            <tbody> 
            <?php $sq_hotel = mysql_query("select * from custom_package_hotels where package_id='$package_id'");
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
                <td><?php echo $row_hotel['total_days']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php } ?>

<!-- Transport -->
<?php
    $sq_hotelc = mysql_num_rows(mysql_query("select * from custom_package_transport where package_id='$package_id'"));
    if($sq_hotelc!=0){?>
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>Transport DETAILS</h2>
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
                    <th>VEHICLE</th>
                    <th>Pickup</th>
                    <th>Drop</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $count = 0;
                  $sq_hotel = mysql_query("select * from custom_package_transport where package_id='$package_id'");
                  while($row_hotel = mysql_fetch_assoc($sq_hotel)){
                    $transport_name = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id ='$row_hotel[vehicle_name]'"));
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
                      $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                    }
                    // Drop
                    if($row_hotel['drop_type'] == 'city'){
                      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
                      $drop = $row['city_name'];
                    }
                    else if($row_hotel['pickup_type'] == 'hotel'){
                      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
                      $drop = $row['hotel_name'];
                    }
                    else{
                      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
                      $airport_nam = clean($row['airport_name']);
                      $airport_code = clean($row['airport_code']);
                      $drop = $airport_nam." (".$airport_code.")";
                      $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                    }
                    ?>
                    <tr>
                      <td><?= $transport_name['vehicle_name'].$similar_text ?></td>
                      <td><?= $pickup ?></td>
                      <td><?= $drop ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php } ?>

    <!-- Inclusion -->
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="row">
      <?php if($sq_pckg['inclusions']!= ' '){?>
        <div class="col-md-6">
          <div class="section_heding">
            <h2>Inclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_pckg['inclusions'] ?>
          </div>
        </div>
      <?php } ?> 


    <!-- Exclusion -->
      <?php if($sq_pckg['exclusions']!= ' '){?>
        <div class="col-md-6">
          <div class="section_heding">
            <h2>Exclusions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?= $sq_pckg['exclusions'] ?>
          </div>
        </div>
      <?php } ?> 
      </div>
    </section>
  </body>
</html>