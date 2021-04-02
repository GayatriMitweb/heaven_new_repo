<?php
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";

$quotation_id = $_GET['quotation_id'];
global $app_quot_img;

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Group Quotation' and active_flag ='Active'"));

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
$sq_package_program = mysql_query("select * from group_tour_program where tour_id ='$sq_quotation[tour_group_id]'");
$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_quotation[tour_group_id]'"));
$sq_dest = mysql_fetch_assoc(mysql_query("select link from video_itinerary_master where dest_id = '$sq_tour[dest_id]'"));
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
$tour_cost = $sq_quotation['tour_cost'] + $sq_quotation['markup_cost_subtotal'];
?>

    <!-- landingPage -->
    <section class="landingSec main_block">
      <div class="col-md-8 no-pad">
        <img src="<?= $app_quot_img ?>" class="img-responsive">
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
      </div>
      <div class="col-md-4 no-pad">
      </div>
      <h1 class="landingpageTitle"><?= $sq_quotation['tour_name'] ?></h1>
      <div class="packageDeatailPanel">
        <div class="landingPageBlocks">
        
          <div class="detailBlock">
            <div class="detailBlockIcon">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= get_date_user($sq_quotation['quotation_date']) ?></h3>
              <span class="contentLabel">QUOTATION DATE</span>
            </div>
          </div>
  
          <div class="detailBlock">
            <div class="detailBlockIcon">
              <i class="fa fa-hourglass-half"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?php echo ($sq_quotation['total_days']-1).'N/'.$sq_quotation['total_days'].'D' ?></h3>
              <span class="contentLabel">DURATION</span>
            </div>
          </div>
  
          <div class="detailBlock">
            <div class="detailBlockIcon">
              <i class="fa fa-users"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= $sq_quotation['total_passangers'] ?></h3>
              <span class="contentLabel">TOTAL GUEST</span>
            </div>
          </div>
  
          <div class="detailBlock">
            <div class="detailBlockIcon">
              <i class="fa fa-tag"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= number_format($sq_quotation['quotation_cost'] ,2) ?></h3>
              <span class="contentLabel">PRICE</span>
            </div>
          </div>
        </div>
        <div class="landigPageCustomer">
          <h3 class="customerFrom">Prepare for</h3>
          <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['customer_name'] ?></span><br>
          <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email_id'] ?></span><br>
        </div>
      </div>
    </section>


    <!-- Itinerary -->
    <?php 
      $count = 1;
      $checkPageEnd = 0;
      while($row_itinarary = mysql_fetch_assoc($sq_package_program)){
        if($checkPageEnd%3==0 || $checkPageEnd==0){
          $go = $checkPageEnd + 2;
          $flag = 0;
    ?>
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBG.png" class="img-responsive pageBGImg">
    
      <section class="itinerarySec pageSectionInner main_block mg_tp_30">

      <img src="<?php echo BASE_URL.'images/quotation/youtube-icon.png'; ?>" class="itinerary-img img-responsive">
                &nbsp;VIDEO ITINERARY :&nbsp;<a href="<?=$sq_dest['link']?>" class="no-marg itinerary-link" target="_blank"> </a>
          <?php 
            }
            $itinerarySide= ($count%2!=0)?"leftItinerary":"rightItinerary";
          ?>
          <section class="print_single_itinenary <?= $itinerarySide ?>">
              <div class="itneraryImg">
                <div class="itneraryImgblock">
                <?php
                  if($row_itinarary['daywise_images'] != ""){
                    $img = $row_itinarary['daywise_images'] ;
                  } 
                  else 
                   $img = "http://itourscloud.com/destination_gallery/asia/singapore/Asia_Singapore_Four.jpg";
                ?>
                  <img src="<?= $img ?>" class="img-responsive">
                </div>
                <div class="itneraryDayAccomodation">
                  <span><i class="fa fa-bed"></i> : <?=  $row_itinarary['stay'] ?></span>
                  <span><i class="fa fa-cutlery"></i> : <?= $row_itinarary['meal_plan'] ?></span>
                </div>
              </div>
              <div class="itneraryText">
                <div class="itneraryDayInfo">
                  <i class="fa fa-map-marker" aria-hidden="true"></i><span> Day <?= $count ?> : <?= $row_itinarary['attraction'] ?> </span>
                </div>
                <div class="itneraryDayPlan">
                  <p><?= $row_itinarary['day_wise_program'] ?></p>
                </div>
              </div>
          </section>

          <?php 
          if($go == $checkPageEnd){
            $flag = 1;
          ?>

      </section>
    </section>
    <?php 
      } $count++; $checkPageEnd++; } 
      if($flag == 0){
    ?>
      </section>
    </section>
    <?php  } ?>

    <!-- traveling Information -->
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBG.png" class="img-responsive pageBGImg">

      <section class="travelingDetails main_block mg_tp_30 pageSectionInner">
      <?php
      $sq_train_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_train_entries where quotation_id='$quotation_id'"));
      if($sq_train_count>0){ ?>
        <!-- Train -->
        <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_10">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_train.png" class="img-responsive">
            </div>
            <div class="transportDetails">
              <div class="table-responsive">
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
                    $sq_train = mysql_query("select * from group_tour_quotation_train_entries where quotation_id='$quotation_id'");
                    while($row_train = mysql_fetch_assoc($sq_train)){  
                      ?>
                      <tr>
                        <td><?= $row_train['from_location'] ?></td>
                        <td><?= $row_train['to_location'] ?></td>
                        <td><?= $row_train['class'] ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($row_train['departure_date'])) ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($row_train['arrival_date'])) ?></td>
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
        $sq_plane_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'"));
        if($sq_plane_count>0){ 
        ?>
        <!-- Flight -->
        <section class="transportDetailsPanel transportDetailsleft main_block">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <div class="transportIcomImg">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_flight.png" class="img-responsive">
              </div>
            </div>
            <div class="transportDetails">
              <div class="table-responsive">
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
                    $sq_plane = mysql_query("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'");
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
        $sq_cr_count = mysql_num_rows(mysql_query("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));
        if($sq_cr_count>0){ ?>
        <!-- Cruise -->
        <section class="transportDetailsPanel transportDetailsleft main_block mg_tp_10">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <img src="<?= BASE_URL ?>images/quotation/p4/TI_cruise.png" class="img-responsive">
            </div>

            <div class="transportDetails">
              <div class="table-responsive">
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
                    $sq_cruise = mysql_query("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
                    while($row_cruise = mysql_fetch_assoc($sq_cruise)){  
                      ?>
                      <tr>
                        <td><?= date('d-m-Y H:i:s', strtotime($row_cruise['dept_datetime'])) ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($row_cruise['arrival_datetime'])) ?></td>
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
      </section>
    </section>

    <!-- Inclusion -->
    <?php if($sq_quotation['incl'] != '' && $sq_quotation['incl'] != ' '){?>
    <section class="pageSection main_block">
      <!-- background Image -->
        <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

        <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

          <!-- Inclusion -->
          <div class="row">
            <?php if($sq_quotation['incl'] != ''){?>
            <div class="col-md-12 mg_tp_30 mg_bt_30">
              <div class="incluExcluTermsTabPanel inclusions main_block">
                  <h3 class="incexTitle">Inclusions</h3>
                  <div class="tabContent">
                      <pre class="real_text"><?= $sq_quotation['incl'] ?></pre>      
                  </div>
              </div>
            </div>
            <?php } ?>
          </div>
                      
        </section>
    </section>
    <?php } ?>

    <!--  Exclusion -->
    <?php if($sq_quotation['excl'] != '' && $sq_quotation['excl'] != ' '){?>
    <section class="pageSection main_block">
      <!-- background Image -->
        <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

        <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

          <!--  Exclusion -->
          <div class="row">
            <?php if($sq_quotation['excl'] != ''){?>
            <div class="col-md-12 mg_tp_30 mg_bt_30">
              <div class="incluExcluTermsTabPanel exclusions main_block">
                  <h3 class="incexTitle">Exclusions</h3>
                  <div class="tabContent">
                      <pre class="real_text"><?= $sq_quotation['excl'] ?></pre>
                  </div>
              </div>
            </div>
            <?php } ?>
          </div>
                      
        </section>
    </section>
    <?php } ?>


    <!-- Terms and Conditions -->
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){?>
    <section class="pageSection main_block">
      <!-- background Image -->
        <img src="<?= BASE_URL ?>images/quotation/p5/pageBGF.jpg" class="img-responsive pageBGImg">

        <section class="incluExcluTerms pageSectionInner main_block mg_tp_30">

          <!-- Terms and Conditions -->
          <div class="row">
            
            <div class="col-md-12">
              <div class="termsPanel">
                  <h3 class="incexTitleTwo">Terms & Conditions</h3>
                  <div class="tncContent">
                      <pre class="real_text"><?php echo $sq_terms_cond['terms_and_conditions']; ?></pre>      
                  </div>
              </div>
            </div>
          </div>
                      
        </section>
    </section>
    <?php } ?>



  <!-- Costing & Banking Page -->
  <section class="endPageSection main_block mg_tp_30">

    <div class="row">
      
      <!-- Guest Detail -->
      <div class="col-md-12 passengerPanel endPagecenter mg_bt_30">
            <h3 class="endingPageTitle text-center">Total Guest</h3>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="<?= BASE_URL ?>images/quotation/p4/adult.png" class="img-responsive">
                  <h4 class="no-marg">Adult : <?= $sq_quotation['total_adult'] ?></h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
              </div>
            </div>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="<?= BASE_URL ?>images/quotation/p4/child.png" class="img-responsive">
                  <h4 class="no-marg">Children : <?= $sq_quotation['total_children'] ?></h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
                <i class="fa fa-plus"></i>
              </div>
            </div>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="<?= BASE_URL ?>images/quotation/p4/infant.png" class="img-responsive">
                  <h4 class="no-marg">Infant : <?= $sq_quotation['total_infant'] ?></h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
                <i class="fa fa-plus"></i>
              </div>
            </div>
      </div>
      
    </div>
    <?php
        $tour_cost1 = $sq_quotation['tour_cost'];
        $service_charge = $sq_quotation['service_charge'];
        $tour_cost= $tour_cost1 +$service_charge;
        $service_tax_amount = 0;
        $tax_show = '';
        $bsmValues = json_decode($sq_quotation['bsm_values']);
            // var_dump($bsmValues);
        if($sq_quotation['service_tax_subtotal'] !== 0.00 && ($sq_quotation['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$sq_quotation['service_tax_subtotal']);
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
        ?>  
    <div class="row constingBankingPanelRow">
      <!-- Costing -->
      <div class="col-md-12 constingBankingPanel constingPanel mg_bt_30">
            <h3 class="costBankTitle text-center">Costing Details</h3>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p5/tourCost.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= round($newBasic) ?></h4>
              <p>TOUR COST</p>
            </div>
            <div class="col-md-4 text-center no-pad">
              <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tax.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $tax_show ?></h4>
              <p>TAX</p>
            </div>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p5/quotationCost.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= number_format($sq_quotation['quotation_cost'],2) ?></h4>
              <p>QUOTATION COST</p>
            </div>
      </div>
      
    

      <!-- Bank Detail -->
      <div class="col-md-12 constingBankingPanel BankingPanel">
            <h3 class="costBankTitle text-center">Bank Details</h3>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p5/bankName.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $bank_name_setting ?></h4>
              <p>BANK NAME</p>
            </div>
            <div class="col-md-4 text-center no-pad">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/branchName.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $bank_branch_name ?></h4>
              <p>BRANCH</p>
            </div>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p5/accName.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $acc_name ?></h4>
              <p>A/C NAME</p>
            </div>
            <div class="col-md-4 text-center no-pad">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accNumber.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $bank_acc_no ?></h4>
              <p>A/C NO</p>
            </div>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p5/code.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= $bank_ifsc_code ?></h4>
              <p>IFSC</p>
            </div>
            <div class="col-md-4 text-center no-pad">
              <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
              <h4 class="no-marg"><?=  $bank_swift_code ?></h4>
              <p>SWIFT CODE</p>
            </div>
      </div>
      
    
    </div>

  </section>

  <!--Contact Page -->
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBG.png" class="img-responsive pageBGImg">

      <section class="contactSection main_block mg_tp_30 text-center pageSectionInner">
          <div class="companyLogo">
            <img src="<?= $admin_logo_url ?>">
          </div>
          <div class="companyContactDetail">
              <h3><?= $app_name ?></h3>
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
      </section>
   </section>

</body>
</html>