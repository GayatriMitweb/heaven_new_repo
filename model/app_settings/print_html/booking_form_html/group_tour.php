<?php
include "../../../model.php"; 
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");
$branch_status = $_GET['branch_status'];
$tourwise_id=$_GET['booking_id'];
$role = $_SESSION['role'];
$year = $_GET['year'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_details = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_admin_id'"));
$total_days1= '';
$credit_card_charges = $_GET['credit_card_charges'];
$charge = ($credit_card_charges!='')?$credit_card_charges:0 ;

$sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Group Sale' and active_flag ='Active'"));

$tourwise_details = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id' "));
$row_booking = mysql_fetch_assoc(mysql_query( "select * from tourwise_traveler_details where id ='$tourwise_id' "));
$booking_date = $row_booking['form_date'];
$yr = explode("-", $booking_date);
$year =$yr[0];
$tour_id=$tourwise_details['tour_id'];
$tour_group_id=$tourwise_details['tour_group_id'];
$traveler_group_id=$tourwise_details['traveler_group_id'];

$tour_name1 = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id= '$tour_id'"));
$tour_name = $tour_name1['tour_name'];

$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id= '$tourwise_details[emp_id]'"));
$booker_name1 = $sq_emp['first_name'].' '.$sq_emp['last_name'];
if($tourwise_details['emp_id'] == '0'){
  $booker_name = 'Admin';
} 
else{ 
  $booker_name = $booker_name1;
}

$tour_group1 = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id= '$tour_group_id'"));
$from_date = date("d-m-Y",strtotime($tour_group1['from_date']));
$to_date = date("d-m-Y",strtotime($tour_group1['to_date']));

//Total days
$total_days1=strtotime($tour_group1['to_date']) - strtotime($tour_group1['from_date']);
$total_days = round($total_days1 / 86400);
$booking_date =  date("d-m-Y", strtotime($tourwise_details['form_date']));

$sq_total_mem = mysql_num_rows(mysql_query("select traveler_id from travelers_details where traveler_group_id='$tourwise_details[id]'"));

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$tourwise_details[customer_id]'"));
if($sq_customer['type']=='Corporate'){
    $customer_name = $sq_customer['company_name']; } 
else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'];
}
$visa_name= ($tourwise_details['visa_country_name']!="") ? $tourwise_details['visa_country_name']: NA;
$insuarance_name= ($tourwise_details['insuarance_company_name']!="") ? $tourwise_details['insuarance_company_name']: NA;

$tour_total_amount= ($tourwise_details['net_total']!="") ? $tourwise_details['net_total']: 0;

$roundoff = $tourwise_details['roundoff'];
$basic_cost1 = $tourwise_details['basic_amount'];
$service_charge = $tourwise_details['service_charge'];
$net_amount = $tourwise_details['net_total'];
$total_discount = $tourwise_details['total_discount'];
$bsmValues = json_decode($tourwise_details['bsm_values']);

$tax_show = '';
$newBasic = $basic_cost1;
$name = '';
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($tourwise_details['service_tax'] !== 0.00 && ($tourwise_details['service_tax']) !== ''){
  $service_tax_subtotal1 = explode(',',$tourwise_details['service_tax']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
if($bsmValues[0]->service != ''){   //inclusive service charge
  $newBasic = $basic_cost1;
  $newSC = $service_tax_amount + $service_charge;
}
else{
  // $tax_show = $service_tax_amount;
  $tax_show =  rtrim($name, ', ').' : ' . ($service_tax_amount);
  $newSC = $service_charge;
  
}

////////////Basic Amount Rules
if($bsmValues[0]->basic != ''){ //inclusive basic
  
  $newBasic = $basic_cost1 + $service_tax_amount;
  $tax_show = '';
}else{

}
?>
    <!-- header -->
    <section class="print_header main_block">
      <div class="col-md-4 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> CONFIRMATION FORM</span>
        <div class="print_header_logo">
          <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-8 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? 
           $branch_details['contact_no'] : $app_contact_no ?></p>
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
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-calendar" aria-hidden="true"></i><br>
                  <span>BOOKING DATE</span><br>
                  <?php echo $booking_date; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-hourglass-half" aria-hidden="true"></i><br>
                  <span>DURATION</span><br>
                  <?php echo ($total_days).'N/'.($total_days+1).'D'; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-users" aria-hidden="true"></i><br>
                  <span>TOTAL GUEST (s)</span><br>
                  <?php echo $sq_total_mem; ?><br>
                </div>
              </li>
              <li class="col-md-3 mg_tp_10 mg_bt_10">
                <div class="print_quo_detail_block">
                  <i class="fa fa-tags" aria-hidden="true"></i><br>
                  <span>PRICE</span><br>
                  <?php echo number_format($tour_total_amount ,2); ?><br>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

	<!-- Package -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>BOOKING DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-7 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>TOUR NAME :</span> <?php echo $tour_name; ?> </li>
            <li><span>CUSTOMER NAME :</span> <?php echo $customer_name; ?></li>
          </ul>
        </div>
        <div class="col-md-5 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>BOOKING ID :</span> <?php echo get_group_booking_id($tourwise_id,$year); ?></li>
           <?php $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); ?>

            <li><span>CONTACT NUMBER :</span><?php echo  $contact_no; ?></li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOUR DATE : </span><?php echo $from_date.' To '.$to_date; ?></li>
            </ul>
            <ul class="main_block noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOTAL ROOMS : </span><?php echo $tourwise_details['s_double_bed_room']; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!--  -->
	<!-- Passenger -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>PASSENGERS</h2>
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
                <th>Full_Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Age</th>
              </tr>
            </thead>
            <tbody>
            <?php 
             $sq_members1 = mysql_query("select * from travelers_details where traveler_group_id = '$tourwise_id'");
             while($row_members1 = mysql_fetch_assoc($sq_members1))
             { ?>   
                  <tr>
                    <td><?php echo $row_members1['first_name'].' '.$row_members1['middle_name'].' '.$row_members1['last_name']; ?></td>
                    <td><?php echo $row_members1['gender']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row_members1['birth_date'])); ?></td>
                    <td><?php echo $row_members1['age']; ?></td>
                  </tr>
             <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <!-- ACCOMMODATION -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>ACCOMMODATION</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-3 mg_tp_10 mg_bt_10"><span>SINGLE BED: </span><?= $tourwise_details['s_single_bed_room'] ?></li>
              <li class="col-md-3 mg_tp_10 mg_bt_10"><span>DOUBLE BED : </span><?= $tourwise_details['s_double_bed_room'] ?></li>
              <li class="col-md-3 mg_tp_10 mg_bt_10"><span>EXTRA BED : </span><?= $tourwise_details['s_extra_bed'] ?></li>
              <li class="col-md-3 mg_tp_10 mg_bt_10"><span>ON FLOOR : </span><?= $tourwise_details['s_on_floor'] ?></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
	<?php
    //Train
  $sq_train = mysql_num_rows(mysql_query("select tourwise_traveler_id from train_master where tourwise_traveler_id='$tourwise_id'"));
  $train_count = 0;

  if($sq_train>0)
  { ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>Train</h2>
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
                <th>TRAIN</th>
                <th>SEATS</th>
                <th>CLASS</th>
                <th>PRIORITY</th>
                <th>DEPARTURE D/T</th>
              </tr>
            </thead>
            <tbody>  
            <?php $sq_train_details = mysql_query("select * from train_master where tourwise_traveler_id='$tourwise_id'");
          while($row_train_details = mysql_fetch_assoc($sq_train_details))
          { ?> 
                  <tr>
                    <td><?php echo $row_train_details['from_location']; ?></td>
                    <td><?php echo $row_train_details['to_location']; ?></td>
                    <td><?php echo $row_train_details['train_no']; ?></td>
                    <td><?php echo $row_train_details['seats']; ?></td>
                    <td><?php echo $row_train_details['train_class']; ?></td>
                    <td><?php echo $row_train_details['train_priority']; ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($row_train_details['date'])); ?></td>
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
    //Flight
  $sq_air = mysql_num_rows(mysql_query("select tourwise_traveler_id from plane_master where tourwise_traveler_id='$tourwise_id'"));
  $air_count = 0;

  if($sq_air>0)
  { ?>
    <section class="print_sec main_block">
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
                <th>SEATS</th>
                <th>DEPARTURE D/T</th>
                <th>ARRIVAL D/T</th>
              </tr>
            </thead>
            <tbody> 
            <?php $sq_air_details = mysql_query("select * from plane_master where tourwise_traveler_id='$tourwise_id'");
            while($row_air_details = mysql_fetch_assoc($sq_air_details))
            {
              $sq_airline = mysql_fetch_assoc(mysql_query("select * from airline_master where airline_id='$row_air_details[company]'")); ?> 
                  <tr>
                    <td><?php echo $row_air_details['from_location']; ?></td>
                    <td><?php echo $row_air_details['to_location']; ?></td>
                    <td><?php echo $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')'; ?></td>
                    <td><?php echo $row_air_details['seats']; ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($row_air_details['date'])); ?></td>
                    <td><?php echo date("d-m-Y H:i", strtotime($row_air_details['arraval_time'])); ?></td>
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
    //Cruise
  $sq_cruise = mysql_num_rows(mysql_query("select booking_id from group_cruise_master where booking_id='$tourwise_id'"));
  if($sq_cruise>0)
  { ?>
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>Cruise</h2>
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
                <th>DEPARTURE D/T</th>
                <th>ARRIVAL D/T</th>
                <th>ROUTE</th>
                <th>CABIN</th>
                <th>SHARING</th>
                <th>SEATS</th>                
              </tr>
            </thead>
            <tbody> 
            <?php $sq_cruise_details = mysql_query("select * from group_cruise_master where booking_id='$tourwise_id'");
            while($row_cruise_details = mysql_fetch_assoc($sq_cruise_details))
             { ?> 
                  <tr>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($row_cruise_details['dept_datetime'])); ?></td>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($row_cruise_details['arrival_datetime'])); ?></td>
                    <td><?php echo $row_cruise_details['route']; ?></td>
                    <td><?php echo $row_cruise_details['cabin']; ?></td>
                    <td><?php echo $row_cruise_details['sharing']; ?></td>
                    <td><?php echo $row_cruise_details['seats']; ?></td>
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
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Inclusion</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php echo $tour_name1['inclusions']; ?>
          </div>
        </div>
      </div>
    </section>


    <!-- Exclusion -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Exclusion</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="print_text_bolck">
            <?php echo $tour_name1['exclusions']; ?>
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
           <span><?= ($sq_terms_cond['terms_and_conditions']) ?><span>
          </div>
        </div>
      </div>
    </section>

    <!-- Booking Summary -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
          <div class="section_heding">
            <h2>Booking Summary</h2>
            <div class="section_heding_img">
              <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
            </div>
          </div>
          <div class="row">
        <div class="col-md-7 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>BOOKING DATE :</span> <?= get_date_user($tourwise_details['form_date']) ?> </li>
          </ul>
        </div>
        <div class="col-md-5 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>DUE DATE :</span> <?= get_date_user($tourwise_details['balance_due_date']) ?></li>
          </ul>
        </div>
      </div>
          <div class="row">
          <div class="col-md-12">
          <div class="print_text_bolck">
              <span><?= $tourwise_details['special_request'] ?></span>
          </div>
        </div>
      </div>
    </section>


    <!-- Payment Detail -->
    <section class="print_sec main_block">
      <div class="section_heding">
        <h2>PAYMENT DETAILS</h2>
        <div class="section_heding_img">
          <img src="<?php echo BASE_URL.'images/heading_border.png'; ?>" class="img-responsive">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="print_amount_block">
            <ul class="main_block no-pad text-right noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TOUR AMOUNT : </span><?php echo number_format($tourwise_details['tour_fee_subtotal_1'],2); ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>BASIC AMOUNT : </span><?php echo number_format(($newBasic+$total_discount),2); ?></li>
            </ul>
            <ul class="main_block no-pad text-right noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TRAIN AMOUNT : </span><?php echo number_format($tourwise_details['total_train_expense'],2); ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>DISCOUNT : </span><?php echo number_format($total_discount,2); ?></li>
             
            </ul>
            <ul class="main_block no-pad text-right noType">
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CRUISE AMOUNT : </span><?php echo number_format($tourwise_details['total_cruise_expense'],2); ?></li>
             
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>TAX AMOUNT : </span><?php echo $tax_show; ?></li>
            </ul>
            <ul class="main_block no-pad text-right noType">
            <li class="col-md-6 mg_tp_10 mg_bt_10"><span>FLIGHT AMOUNT : </span><?php echo number_format($tourwise_details['total_plane_expense'],2); ?></li>
             <li class="col-md-6 mg_tp_10 mg_bt_10"><span>NET AMOUNT : </span><?php echo number_format($net_amount,2); ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>DUE DATE : </span><?= get_date_user($tourwise_details['balance_due_date'])  ?></li>
              <li class="col-md-6 mg_tp_10 mg_bt_10"><span>CREDIT CARD CHARGE : </span><?= number_format($charge,2)?></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
          <div class="print_amount_block">
            <ul class="main_block no-pad text-right noType">
              <li class="col-md-12 mg_tp_10 mg_bt_10 font_5"><span>TOTAL AMOUNT : </span><?php echo number_format($tourwise_details['net_total']+$charge,2); ?></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-5 text-center">
          <div class="print_quotation_creator">
            <span>CUSTOMER'S SIGNATURE</span><br>
          </div>
        </div>
        <div class="col-md-7 text-right">
          <div class="print_quotation_creator text-center">
            <span>BOOKED BY </span><br><?php echo $booker_name; ?>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
