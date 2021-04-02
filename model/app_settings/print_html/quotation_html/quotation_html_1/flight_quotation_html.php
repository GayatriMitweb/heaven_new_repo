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

    <section class="headerPanel main_block">
        <div class="headerImage">
          <img src="<?= $app_quot_img ?>" class="img-responsive">
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
          <span class="title"><i class="fa fa-pencil-square-o"></i> FLIGHT QUOTATION</span>
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
                    <i class="fa fa-hashtag" aria-hidden="true"></i><br>
                    <span>QUOTATION ID</span><br>
                    <?= get_quotation_id($quotation_id,$year) ?><br>
                  </div>
                </li>
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-users" aria-hidden="true"></i><br>
                    <span>TOTAL SEATS</span><br>
                    <?= $sq_plane['total_adult'] + $sq_plane['total_child'] ?><br>
                  </div>
                </li>
                <li class="col-md-3 mg_tp_10 mg_bt_10">
                  <div class="print_quo_detail_block">
                    <i class="fa fa-tags" aria-hidden="true"></i><br>
                    <span>PRICE</span><br>
                    <?= number_format($sq_quotation['quotation_cost'],2) ?><br>
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
        <div class="col-md-7 mg_bt_20">
        </div>
        <div class="col-md-5 mg_bt_20">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
          <ul class="print_info_list">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>PREFERRED AIRLINE :</span><?= $sq_quotation['preffered_airline']; ?> </li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CUSTOMER NAME :</span><?= $sq_quotation['customer_name'] ?></li>
          </ul>
          <ul class="print_info_list">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CONTACT NUMBER :</span> <?= $sq_quotation['mobile_no'] ?></li>
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>E-MAIL ID :</span> <?= $sq_quotation['email_id'] ?></li>
          </ul>
          <hr class="main_block">
            <ul class="main_block">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>SECTOR FROM : </span><?= $sq_quotation['sector_from'] ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>SECTOR TO : </span><?= $sq_quotation['sector_to'] ?></li>
            </ul>
            <ul class="main_block">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CLASS TYPE : </span><?= $sq_quotation['class_type'] ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TRIP TYPE : </span><?= $sq_quotation['trip_type'] ?></li>
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
            <h2>COSTING</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_info_block">
            <ul class="main_block">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TOTAL FARE : </span><?= number_format($newBasic + $sq_quotation['roundoff'],2) ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>TAX : </span><?= $tax_show ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>QUOTATION COST : </span><?= number_format($sq_quotation['quotation_cost'],2) ?></li>
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
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C NAME : </span><?= $acc_name ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>BRANCH : </span><?= $bank_branch_name ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>A/C NO : </span><?= $bank_acc_no ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>IFSC : </span><?= $bank_ifsc_code ?></li>
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>Swift Code : </span><?= $bank_swift_code ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Flight -->
    <?php 
    $sq_plane_count = mysql_num_rows(mysql_query("select * from flight_quotation_plane_entries where quotation_id='$quotation_id'"));
    if($sq_plane_count>0){ 
    ?>
    <section class="print_sec main_block side_pad mg_tp_30">
      <div class="section_heding">
        <h2>Flight</h2>
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
             $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_plane[airline_name]'")); ?>   
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
    <?php } ?>

<!-- Terms and Conditions -->
    <section class="print_sec main_block side_pad mg_tp_30">
    <?php if($sq_terms_cond['terms_and_conditions']) {?>
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Terms and Conditions</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
           <?= $sq_terms_cond['terms_and_conditions'] ?>
          </div>
        </div>
      </div>
    <?php } ?>
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