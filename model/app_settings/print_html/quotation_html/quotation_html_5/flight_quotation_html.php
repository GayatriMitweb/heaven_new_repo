<?php 
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";

global $app_quot_img;
$quotation_id = $_GET['quotation_id'];

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Flight Quotation' and active_flag ='Active'"));

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from flight_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));
$sq_plane = mysql_fetch_assoc(mysql_query("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];

if($sq_emp_info['first_name']==''){
  $emp_name = 'Admin';
}
else{
  $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}


$tax_show = '';
$newBasic = $basic_cost1 = $sq_quotation['subtotal'] ;
$service_charge = $sq_quotation['service_charge'];
$bsmValues = json_decode($sq_quotation['bsm_values']);
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($sq_quotation['service_tax'] !== 0.00 && ($sq_quotation['service_tax']) !== ''){
  $service_tax_subtotal1 = explode(',',$sq_quotation['service_tax']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $percent = $service_tax[1];
  }
}
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($sq_quotation['markup_cost_subtotal'] !== 0.00 && $sq_quotation['markup_cost_subtotal'] !== ""){
  $service_tax_markup1 = explode(',',$sq_quotation['markup_cost_subtotal']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}

if(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '')  && $bsmValues[0]->markup != ''){
  $tax_show = '';
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $markupservice_tax_amount + $service_charge + $service_tax_amount;
}
elseif(($bsmValues[0]->service == '' || $bsmValues[0]->basic == '')  && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount + $service_tax_amount);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge;
}
elseif(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '') && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge + $service_tax_amount;
}
else{
  $tax_show = $percent.' '. ($service_tax_amount);
  $newBasic = $basic_cost1 + $sq_quotation['markup_cost'] + $service_charge + $markupservice_tax_amount;
}
?>

    <!-- landingPage -->
    <section class="landingSec main_block">
      <div class="col-md-8 no-pad">
        <img src="<?= $app_quot_img ?>" class="img-responsive">
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
      </div>
      <div class="col-md-4 no-pad">
      </div>
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
              <i class="fa fa-users"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= $sq_plane['total_adult'] + $sq_plane['total_child'] ?></h3>
              <span class="contentLabel">TOTAL SEATS</span>
            </div>
          </div>
  
          <div class="detailBlock">
            <div class="detailBlockIcon">
              <i class="fa fa-tag"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= number_format($sq_quotation['quotation_cost'],2) ?></h3>
              <span class="contentLabel">PRICE</span>
            </div>
          </div>
        </div>
        <div class="landigPageCustomer">
          <h3 class="customerFrom">Prepare for</h3>
          <span class="customerName"><em><i class="fa fa-user"></i></em> : <?= $sq_quotation['customer_name'] ?></span><br>
          <span class="customerMail"><em><i class="fa fa-envelope"></i></em> : <?= $sq_quotation['email_id'] ?></span><br>
          <span class="customerMobile"><em><i class="fa fa-phone"></i></em> : <?= $sq_quotation['mobile_no'] ?></span>
        </div>
      </div>
    </section>

    <!-- traveling Information -->
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBG.png" class="img-responsive pageBGImg">

      <section class="travelingDetails main_block mg_tp_30 pageSectionInner">

      <?php 
        $count = 1;
        $sq_plane = mysql_query("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'");
        while($row_plane = mysql_fetch_assoc($sq_plane)){
        $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane[airline_name]'")); 
        $itinerarySide= ($count%2!=0)?"transportDetailsleft":"transportDetailsright";
        ?> 
        <!-- Flight -->
        <section class="transportDetailsPanel <?= $itinerarySide ;?> main_block">
          <div class="travsportInfoBlock">
            <div class="transportIcon">
              <div class="transportIcomImg">
                  <img src="<?= BASE_URL ?>images/quotation/p4/TI_flight.png" class="img-responsive">
              </div>
            </div>
            <div class="transportDetails">

              <div class="table-responsive">
                <table class="table tableTrnasp no-marg">
                  <thead>
                    <tr class="table-heading-row">
                      <th>SECTOR FROM</th>
                      <th>SECTOR TO</th>
                      <th>Airline</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?= $row_plane['from_location'] ?></td>
                      <td><?= $row_plane['to_location'] ?></td>
                      <td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="table-responsive mg_tp_30">
                <table class="table tableTrnasp no-marg">
                  <thead>
                    <tr class="table-heading-row">
                      <th>Class</th>
                      <th>Departure</th>
                      <th>Arrival</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?= $row_plane['class'] ?></td>
                      <td><?= date('d-m-Y H:i:s', strtotime($row_plane['dapart_time'])) ?></td>
                      <td><?= date('d-m-Y H:i:s', strtotime($row_plane['arraval_time'])) ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </section>

        <?php $count++; } ?>

      </section>
    </section>

    <!-- Terms and Conditions -->
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){?>
    <section class="pageSection main_block">
      <!-- background Image -->
      <img src="<?= BASE_URL ?>images/quotation/p5/pageBG.png" class="img-responsive pageBGImg">

        <section class="incluExcluTerms main_block mg_tp_30 pageSectionInner">

          <!-- Terms and Conditions -->
          <div class="row">
            
            <div class="col-md-12">
              <div class="termsPanel">
                  <h3 class="incexTitleTwo">Terms & Conditions</h3>
                  <div class="tncContent">
                      <pre class="real_text"><?= $sq_terms_cond['terms_and_conditions'] ?></pre>      
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
      <!-- <div class="col-md-12 passengerPanel endPagecenter mg_bt_30">
            <h3 class="endingPageTitle text-center">Guest</h3>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="images/quotation/p4/adult.png" class="img-responsive">
                  <h4 class="no-marg">Adult</h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
              </div>
            </div>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="images/quotation/p4/child.png" class="img-responsive">
                  <h4 class="no-marg">Children</h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
                <i class="fa fa-plus"></i>
              </div>
            </div>
            <div class="col-md-4 text-center mg_bt_30">
              <div class="iconPassengerBlock">
                <div class="iconPassengerSide leftSide"></div>
                <div class="iconPassenger">
                  <img src="images/quotation/p4/infant.png" class="img-responsive">
                  <h4 class="no-marg">Infant</h4>
                </div>
                <div class="iconPassengerSide rightSide"></div>
                <i class="fa fa-plus"></i>
              </div>
            </div>
      </div>
       -->
    </div>
      
    <div class="row constingBankingPanelRow">
      <!-- Costing -->
      <div class="col-md-12 constingBankingPanel constingPanel mg_bt_30">
            <h3 class="costBankTitle text-center">Costing Details</h3>
            <div class="col-md-4 text-center no-pad constingBankingwhite">
              <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p5/subtotal.png" class="img-responsive"></div>
              <h4 class="no-marg"><?= number_format($newBasic+ $sq_quotation['roundoff'],2) ?></h4>
              <p>TOTAL FARE</p>
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
              <h4 class="no-marg"><?= $bank_swift_code ?></h4>
              <p>Swift Code</p>
            </div>
      </div>
      
    
    </div>

  </section>

  <!-- Contact Page -->
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
              <?php }?>
              <?php if($app_contact_no != ''){?>
              <div class="contactBlock">
                <i class="fa fa-phone"></i>
                <p><?php echo $app_contact_no; ?></p>
              </div>
              <?php }?>
              <?php if($app_email_id != ''){?>
              <div class="contactBlock">
                <i class="fa fa-envelope"></i>
                <p><?php echo $app_email_id; ?></p>
              </div>
              <?php }?>
              <?php if($app_website != ''){?>
              <div class="contactBlock">
                <i class="fa fa-globe"></i>
                <p><?php echo $app_website; ?></p>
              </div>
              <?php }?>
              <div class="contactBlock">
                <i class="fa fa-pencil-square-o"></i>
                <p>Prepare By : <?= $emp_name?></p>
              </div>
          </div>
      </section>
   </section>

  </body>

</html>