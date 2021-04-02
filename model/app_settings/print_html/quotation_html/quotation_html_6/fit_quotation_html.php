<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$similar_text,$quot_note;

$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Package Quotation' and active_flag ='Active'")); 

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
$transport_agency_id = $sq_quotation['transport_agency_id'];
$sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
$sq_package_name = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
$sq_dest = mysql_fetch_assoc(mysql_query("select link from video_itinerary_master where dest_id = '$sq_package_name[dest_id]'"));

$sq_transport = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
$sq_costing = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id='$quotation_id'"));
$sq_package_program = mysql_query("select * from  package_quotation_program where quotation_id='$quotation_id'");

$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];
$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

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

?>

    <!-- landingPage -->
    <section class="landingSec main_block">

      <div class="landingPageTop main_block">
        
        <img src="<?= $app_quot_img?>" class="img-responsive">
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        <h1 class="landingpageTitle"><?= $sq_package_name['package_name']?><?=' ('.$sq_package_name['package_code'].')' ?></h1>

        
        <div class="packageDeatailPanel">
          <div class="landigPageCustomer">
            <h3 class="customerFrom">Prepare for :</h3>
            <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['customer_name'] ?></span><br>
            <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email_id'] ?></span><br>
            <span class="customerMobile"><em><i class="fa fa-phone"></i></em> : <?= $sq_quotation['mobile_no'] ?></span>
          </div>

          <div class="landingPageBlocks">
          
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-calendar"></i>
              </div>
              <div class="detailBlockContent">
                <p>QUOTATION DATE : <?= get_date_user($sq_quotation['quotation_date']) ?></p>
              </div>
            </div>
    
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-hourglass-half"></i>
              </div>
              <div class="detailBlockContent">
                <p>DURATION : <?php echo ($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D' ?></p>
              </div>
            </div>
    
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-users"></i>
              </div>
              <div class="detailBlockContent">
                <p>TOTAL GUEST : <?= $sq_quotation['total_passangers'] ?></p>
              </div>
            </div>
    
            <div class="detailBlock">
              <div class="detailBlockIcon">
                <i class="fa fa-tag"></i>
              </div>
              <div class="detailBlockContent">
                <p>PRICE : <?= number_format($quotation_cost,2) ?></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

 <!-- Count queries -->
 <?php
  $sq_package_count = mysql_num_rows(mysql_query("select * from  package_quotation_program where quotation_id='$quotation_id'"));
  $sq_hotel_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'"));
  $sq_transport_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_transport_entries2 where quotation_id='$quotation_id'"));
  $sq_train_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_train_entries where quotation_id='$quotation_id'"));
  $sq_plane_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_plane_entries where quotation_id='$quotation_id'"));
  $sq_cruise_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
  $sq_exc_count = mysql_num_rows(mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'"));

  $overall_count = 0;
  if($sq_train_count>0) $overall_count++; 
  if($sq_plane_count>0) $overall_count++; 
  if($sq_cruise_count>0) $overall_count++; 
  if($sq_hotel_count>0) $overall_count++; 
  if($sq_transport_count>0) $overall_count++; 
  if($sq_exc_count>0) $overall_count++; 
  
  if($overall_count <= 3){
    ?>
    <!-- traveling Information -->
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
      <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
      <?php
      traveling_info_first_page($sq_hotel_count, $sq_transport_count, $sq_plane_count,$quotation_id);
      traveling_info_second_page($sq_train_count, $sq_exc_count, $sq_cruise_count,$quotation_id);
      ?>
      </section>
    </section>
<?php
  }
  else {
?>
 <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
      <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
      <?= traveling_info_first_page($sq_hotel_count, $sq_transport_count, $sq_plane_count,$quotation_id); ?>
      </section>
    </section>
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
    <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
    <?= traveling_info_second_page($sq_train_count, $sq_exc_count, $sq_cruise_count,$quotation_id); ?>
    </section>
  </section>
  <?php }  ?>
    <!-- Itinerary -->
    <?php 
      $count = 1;
      $checkPageEnd = 0;
      while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
        
        $sq_day_image = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_images where quotation_id='$row_itinarary[quotation_id]'"));
        $day_url1 = explode(',',$sq_day_image['image_url']);
        $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
        for($count1 = 0; $count1<sizeof($day_url1);$count1++){
            $day_url2 = explode('=',$day_url1[$count1]);
            if($day_url2[1]==$row_itinarary['day_count'] && $day_url2[0]==$row_itinarary['package_id']){
              $daywise_image = $day_url2[2];
            }
        }
        if($checkPageEnd%3==0 || $checkPageEnd==0){
          $go = $checkPageEnd + 2;
          $flag = 0;
    ?>
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
    
      <section class="itinerarySec main_block side_pad mg_tp_30 pageSectionInner">
          <div class="mg-bt-30">
            <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive">
            &nbsp;VIDEO ITINERARY :&nbsp;<a href="<?=$sq_dest['link']?>" class="no-marg itinerary-link" target="_blank"> </a>
          </div>   
        <ul class="print_itinenary no-pad no-marg">
          <?php 
            }
          if($count%2!=0){
          ?>
          <li class="print_single_itinenary topItinerary">
              <div class="itineraryContent">
                <div class="itneraryImg">
                  <img src="<?= $daywise_image ?>" class="img-responsive">
                </div>
                <div class="itneraryText">
                  <div class="itneraryDayInfo">
                    <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                  </div>
                  <div class="itneraryDayPlan">
                    <p><?= $row_itinarary['day_wise_program'] ?></p>
                  </div>
                  <div class="itneraryDayAccomodation">
                    <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                    <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                  </div>
                </div>
              </div>
          </li>

          <?php }else{ ?>
            <li class="print_single_itinenary bottomItinerary">
              <div class="itineraryContent">
                <div class="itneraryText">
                  <div class="itneraryDayInfo">
                    <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                  </div>
                  <div class="itneraryDayPlan">
                    <p><?= $row_itinarary['day_wise_program'] ?></p>
                  </div>
                  <div class="itneraryDayAccomodation">
                    <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                    <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                  </div>
                </div>
                <div class="itneraryImg">
                  <img src="<?= $daywise_image ?>" class="img-responsive">
                </div>
              </div>
          </li>
          <?php 
          }if($go == $checkPageEnd){
            $flag = 1;
          ?>
        </ul>
      </section>
    </section>
    <?php 
      } $count++; $checkPageEnd++; } 
      if($flag == 0){
    ?>
        </ul>
      </section>
    </section>
    <?php  } ?>


    <!-- Inclusion -->
  <?php if($sq_quotation['inclusions']!=''){?>
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="incluExcluTerms main_block side_pad mg_tp_30 pageSectionInner">

        <!-- Inclusion -->
        <div class="row side_pad">
          <div class="col-md-12 mg_tp_30">
            <div class="incluExcluTermsTabPanel inclusions main_block">
                <h3 class="incexTitle">Inclusions</h3>
                <div class="tabContent">
                    <pre class="real_text"><?= $sq_quotation['inclusions'] ?></pre>
                </div>
            </div>
          </div>
        </div>
        <?php if($sq_quotation['exclusions']!=''){?>           
        <!-- Exclusion -->
        <div class="row side_pad">
          <div class="col-md-12 mg_tp_30">
            <div class="incluExcluTermsTabPanel exclusions main_block">
                <h3 class="incexTitle">Exclusions</h3>
                <div class="tabContent">
                    <pre class="real_text"><?= $sq_quotation['exclusions'] ?></pre>      
                </div>
            </div>
          </div>
        </div>  
      <?php } ?>
      </section>
    </section>
  <?php } ?>

  <!-- Terms and Conditions -->
<?php if($sq_terms_cond['terms_and_conditions']!=''){?>
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="incluExcluTerms main_block side_pad mg_tp_30 pageSectionInner">

        <!-- Inclusion Exclusion -->
        <div class="row side_pad">

        <!-- Terms and Conditions -->
          
          <div class="col-md-10 mg_tp_30">
            <div class="termsConditions main_block">
                <h3 class="termsConditionsTitle">Terms & Conditions</h3>
                <div class="tabContent">
                    <pre class="real_text"><?php echo $sq_terms_cond['terms_and_conditions']; ?></pre>    
                    <pre class="real_text"><?php echo $quot_note; ?></pre>  
                </div>
            </div>
          </div>
        </div>
                    
      </section>
    </section>
<?php } ?>



  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p6/pageBGF.jpg" class="img-responsive pageBGImg">
      <section class="endPageSection main_block mg_tp_30 pageSectionInner">

        <div class="row">
          
          <!-- Guest Detail -->
          <div class="col-md-4 passengerPanel endPagecenter mg_bt_30">
            <h3 class="endingPageTitle text-center">Total Guest</h3>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/adult.png" class="img-responsive">
              <h4 class="no-marg">Adult : <?= $sq_quotation['total_adult'] ?></h4>
              <i class="fa fa-plus"></i>
            </div>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
              <h4 class="no-marg">CWB/CWOB : <?= $sq_quotation['children_with_bed']+$sq_quotation['children_without_bed'] ?></h4>
              <i class="fa fa-plus"></i>
            </div>
            <div class="icon">
              <img src="<?= BASE_URL ?>images/quotation/p4/infant.png" class="img-responsive">
              <h4 class="no-marg">Infant : <?= $sq_quotation['total_infant'] ?></h4>
            </div>
          </div>
        <div class="col-md-8">
          <!-- Costing -->
          <div class="col-md-12 constingBankingPanel constingPanel">
                <h3 class="costBankTitle text-center">Costing Details</h3>
                <!-- Group costing -->
                <?php if($sq_quotation['costing_type'] == 1){ ?>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tourCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= round($newBasic) ?></h4>
                  <p>TOUR COST</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tax.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $tax_show ?></h4>
                  <p>TAX</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/travelCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= number_format($sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost']+ $sq_quotation['guide_cost']+ $sq_quotation['misc_cost'],2) ?></h4>
                  <p>TRAVEL COST</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30"></div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/quotationCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= round($quotation_cost) ?></h4>
                  <p>QUOTATION COST</p>
                </div>
              <?php }
              else{ ?>
                <!-- group Costing End -->
                <!-- Per person costing -->
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/adultCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"> <?= number_format($sq_costing['adult_cost'],2) ?></h4>
                  <p>ADULT COST</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/child-with-bed.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= number_format($sq_costing['child_with'],2) ?></h4>
                  <p>CWB</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/child-with-out-bed.png" class="img-responsive"></div>
                  <h4 class="no-marg"> <?= number_format($sq_costing['child_without'],2) ?></h4>
                  <p>CWOB</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/infantCost.png" class="img-responsive"></div>
                  <h4 class="no-marg"> <?= number_format($sq_costing['infant_cost'],2) ?></h4>
                  <p>INFANT COST</p>
                </div>
              <?php }?>
                <!-- Per person costing End -->
          </div>
          
        

          <!-- Bank Detail -->
          <div class="col-md-12 constingBankingPanel BankingPanel">
                <h3 class="costBankTitle text-center">Bank Details</h3>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/bankName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_name_setting ?></h4>
                  <p>BANK NAME</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/branchName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_branch_name ?></h4>
                  <p>BRANCH</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accName.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $acc_name ?></h4>
                  <p>A/C NAME</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accNumber.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_acc_no ?></h4>
                  <p>A/C NO</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_ifsc_code ?></h4>
                  <p>IFSC</p>
                </div>
                <div class="col-md-4 text-center mg_bt_30">
                  <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                  <h4 class="no-marg"><?= $bank_swift_code ?></h4>
                  <p>SWIFT CODE</p>
                </div>
          </div>

        </div>
          
        </div>

      </section>
    </section>

  <!-- Costing & Banking Page -->
  <section class="pageSection main_block">
    <!-- background Image -->
    <img src="<?= BASE_URL ?>images/quotation/p6/pageBG.jpg" class="img-responsive pageBGImg">
    <section class="contactSection main_block mg_tp_30 pageSectionInner">
       <div class="contactPanel">
       <div class="companyLogo">
          <img src="<?= $admin_logo_url ?>">
        </div>
        <div class="companyContactDetail">
            <?php if($app_address != ''){?>
            <div class="contactBlock">
              <i class="fa fa-map-marker"></i>
              <p><?php echo $app_address; ?></p>
            </div>
            <?php } ?>
            <?php if($app_contact_no != ''){?>
            <div class="contactBlock">
              <i class="fa fa-phone"></i>
              <p><?php echo $app_contact_no; ?></p>
            </div>
            <?php } ?>
            <?php if($app_email_id != ''){?>
            <div class="contactBlock">
              <i class="fa fa-envelope"></i>
              <p><?php echo $app_email_id; ?></p>
            </div>
            <?php } ?>
            <?php if($app_website != ''){?>
            <div class="contactBlock">
              <i class="fa fa-globe"></i>
              <p><?php echo $app_website; ?></p>
            </div>
            <?php } ?>
            <div class="contactBlock">
              <i class="fa fa-pencil-square-o"></i>
              <p>Prepare By : <?= $emp_name?></p>
            </div>
        </div>
       </div>
    </section>
  </section>

  </body>
</html>
<?php

function traveling_info_first_page($sq_hotel_count, $sq_transport_count, $sq_plane_count,$quotation_id){
 ?> <!-- Hotel -->
 <?php if($sq_hotel_count != 0){?>
  <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
    <div class="travsportInfoBlock">
      <div class="transportIcon">
        <img src="<?= BASE_URL ?>images/quotation/p4/TI_hotel.png" class="img-responsive">
      </div>
      <div class="transportDetails">
      <div class="col-md-12 no-pad">
          <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
            <table class="table tableTrnasp no-marg" id="tbl_emp_list">
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
    </div>
  </section>
  <?php } ?>
  <!-- Flight -->
  <?php
        if($sq_plane_count>0){ ?>
  <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_flight.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table tableTrnasp no-marg" id="tbl_emp_list">
                  <thead>
                    <tr class="table-heading-row">
                      <th>From</th>
                      <th>To</th>
                      <th>Airline</th>
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
                      <td><?= date('d-m-Y H:i:s', strtotime($row_plane['dapart_time'])) ?></td>
                      <td><?= date('d-m-Y H:i:s', strtotime($row_plane['arraval_time'])) ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>
        <?php
        if($sq_transport_count>0){ ?>
<!-- transport -->
<section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_car.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table no-marg tableTrnasp">
                  <thead>
                    <tr class="table-heading-row">
                      <th>VEHICLE</th>
                      <th>FROM DATE</th>
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
        </section>
        <?php } ?>
<?php 
}

function traveling_info_second_page($sq_train_count, $sq_exc_count, $sq_cruise_count,$quotation_id){
?>
<!-- Train -->
<?php if($sq_train_count>0){ ?>
<section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
        <div class="travsportInfoBlock">
          <div class="transportIcon">
            <img src="<?= BASE_URL ?>images/quotation/p4/TI_train.png" class="img-responsive">
          </div>
          <div class="transportDetails">
            <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
              <table class="table tableTrnasp no-marg" id="tbl_emp_list">
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
      </section>
      <?php } ?>
 <!-- excursion -->
 <?php
        if($sq_exc_count>0){ ?>
 <section class="transportDetailsPanel transportDetailsLeftPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_excursion.png" class="img-responsive">
            </div>

            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table no-marg tableTrnasp">
                  <thead>
                      <tr class="table-heading-row">
                        <th>City </th>
                        <th>Activity Date</th>
                        <th>Activity Name</th>
                        <th>Transfer Option</th>
                        <th>Cost</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $count = 0;
                      $sq_ex = mysql_query("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'");
                      while($row_ex = mysql_fetch_assoc($sq_ex)){
                        $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_ex[city_name]'"));
                        $sq_ex_name = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_ex[excursion_name]'"));
                        ?>
                        <tr>
                          <td><?= $sq_city['city_name'] ?></td>
                          <td><?= get_datetime_user($row_ex['exc_date']) ?></td>
                          <td><?= $sq_ex_name['excursion_name'] ?></td>
                          <td><?= $row_ex['transfer_option'] ?></td>
                          <td><?= $row_ex['excursion_amount'] ?></td>
                        </tr>
                        <?php }	?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <?php } ?>
<!-- Cruise -->
<?php
        if($sq_cruise_count>0){ ?>
<section class="transportDetailsPanel transportDetailsLeftPanel transportDetailsLastPanel main_block side_pad">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_cruise.png" class="img-responsive">
            </div>

            <div class="transportDetails">
              <div class="table-responsive" style="margin-top:1px;margin-right: 1px;">
                <table class="table tableTrnasp no-marg" id="tbl_emp_list">
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
        </section>
        <?php } ?>


<?php
}

?>