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

      <div class="landingPageTop main_block">
        <img src="<?= $app_quot_img ?>" class="img-responsive">
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        <div class="landingdetailBlock">
          <div class="detailBlock text-center" style="border-top:0px;">
            <div class="detailBlockIcon detailBlockBlue">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= get_date_user($sq_quotation['quotation_date']) ?></h3>
              <span class="contentLabel">QUOTATION DATE</span>
            </div>
          </div>
          <div class="detailBlock text-center">
            <div class="detailBlockIcon detailBlockYellow">
                <i class="fa fa-users"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= $sq_plane['total_adult'] + $sq_plane['total_child'] ?></h3>
              <span class="contentLabel">TOTAL SEATS</span>
            </div>
          </div>

          <div class="detailBlock text-center">
            <div class="detailBlockIcon detailBlockRed">
                <i class="fa fa-tag"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= number_format($sq_quotation['quotation_cost'],2) ?></h3>
              <span class="contentLabel">PRICE</span>
            </div>
          </div>
        </div>
      </div>

      <div class="ladingPageBottom main_block side_pad">

        <div class="row">
          <div class="col-md-4">
            <div class="landigPageCustomer mg_tp_20">
              <h3 class="customerFrom">Prepare for</h3>
              <span class="customerName mg_tp_10"><i class="fa fa-user"></i> :
                <?= $sq_quotation['customer_name'] ?></span><br>
              <span class="customerMail mg_tp_10"><i class="fa fa-envelope"></i> :
                <?= $sq_quotation['email_id'] ?></span><br>
              <span class="customerMobile mg_tp_10"><i class="fa fa-phone"></i> : <?= $sq_quotation['mobile_no'] ?></span><br>
              <span class="generatorName mg_tp_10">Prepare By <?= $emp_name?></span><br>
            </div>
          </div>
          <div class="col-md-8">
            <div class="print_header_logo main_block">
              <img src="<?= $admin_logo_url ?>" class="img-responsive">
            </div>
            <div class="print_header_contact text-right main_block">
              <span class="title"><?php echo $app_name; ?></span><br>
              <?php if($app_address != ''){?><p class="address no-marg"><?php echo $app_address; ?></p><?php } ?>
              <?php if($app_contact_no != ''){?><p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i><?php echo $app_contact_no; ?></p><?php } ?>
              <?php if($app_email_id != ''){?><p class="no-marg"><i class="fa fa-envelope" style="margin-right: 5px;"></i><?php echo $app_email_id; ?></p><?php } ?>
              <?php if($app_website != ''){?><p><i class="fa fa-globe" style="margin-right: 5px;"></i><?php echo $app_website; ?></p><?php } ?>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- traveling Information -->
    <section class="travelingDetails main_block">

      <!-- flight -->
      <section class="transportDetails main_block side_pad mg_tp_30">
        <div class="row mg_tp_20">
          <div class="col-md-6">
          </div>
          <div class="col-md-6">
            <div class="transportImg">
              <img src="<?= BASE_URL ?>images/quotation/flight.png" class="img-responsive">
            </div>
          </div>
        </div>
      </section>

    </section>

    <!-- traveling Information -->
    <section class="travelingDetails main_block">

      <!-- flight -->
      <section class="transportDetails main_block side_pad mg_tp_30">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive mg_tp_30">
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
                      $sq_plane = mysql_query("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'");
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
      </section>

    </section>


    <!-- Terms and Conditions -->
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){?>
    <section class="incluExcluTerms main_block fullHeightLand">

      <div class="row mg_tp_30">

        <div class="col-md-12 mg_tp_30">
          <div class="incluExcluTermsTabPanel main_block mg_tp_30">
            <h3 class="tncTitle">Terms &amp; Conditions</h3>
            <div class="tncContent">
              <pre class="real_text"><?= $sq_terms_cond['terms_and_conditions'] ?></pre>
            </div>
          </div>
        </div>
      </div>

    </section>
    <?php } ?>


    <!-- Ending Page -->
    <section class="endPageSection main_block">

      <div class="row">

        <!-- Costing -->
        <div class="col-md-4 constingBankingPanel endPageLeft fullHeightLand">
          <h3 class="costBankTitle text-right">COSTING Details</h3>
          <div class="col-md-12 text-right mg_bt_20">
            <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/subtotal.png" class="img-responsive">
            </div>
            <h4 class="no-marg"><?= number_format($newBasic + $sq_quotation['roundoff'],2) ?></h4>
            <p>TOTAL FARE</p>
          </div>
          <div class="col-md-12 text-right mg_bt_20">
            <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tax.png" class="img-responsive">
            </div>
            <h4 class="no-marg"><?= $tax_show ?></h4>
            <p>TAX</p>
          </div>
          <div class="col-md-12 text-right">
            <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/quotationCost.png" class="img-responsive"></div>
            <h4 class="no-marg"><?= number_format($sq_quotation['quotation_cost'],2) ?></h4>
            <p>QUOTATION COST</p>
          </div>
        </div>

        <!-- Guest Detail -->
        <!-- <div class="col-md-4 passengerPanel endPagecenter fullHeightLand">
          <h3 class="costBankTitle text-center">Guest</h3>
          <div class="col-md-12 text-center mg_bt_30">
            <div class="icon"><img src="images/quotation/Icon/adultIcon.png" class="img-responsive"></div>
            <p>Adult</p>
          </div>
          <div class="col-md-12 text-center mg_bt_30">
            <div class="icon"><img src="images/quotation/Icon/childIcon.png" class="img-responsive"></div>
            <p>Child</p>
          </div>
          <div class="col-md-12 text-center mg_bt_30">
            <div class="icon"><img src="images/quotation/Icon/infantIcon.png" class="img-responsive"></div>
            <p>Infant</p>
          </div>
        </div> -->

        <!-- Bank Detail -->
        <div class="col-md-4 constingBankingPanel endPageright fullHeightLand">
          <h3 class="costBankTitle text-left">BANK DETAILS</h3>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/bankName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $bank_name_setting ?></h4>
                <p>BANK NAME</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/branchName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $bank_branch_name ?></h4>
                <p>BRANCH</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $acc_name ?></h4>
                <p>A/C NAME</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accNumber.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $bank_acc_no ?></h4>
                <p>A/C NO</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $bank_ifsc_code ?></h4>
                <p>IFSC</p>
              </div>
              <div class="col-md-12 text-left">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $bank_swift_code ?></h4>
                <p>Swift Code</p>
              </div>
        </div>

      </div>

    </section>

  </body>

</html>