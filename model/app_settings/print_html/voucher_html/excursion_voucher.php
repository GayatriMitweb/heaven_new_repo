<?php
//Generic Files
include "../../../model.php"; 
include "../print_functions.php";

$booking_id = $_GET['booking_id'];
$booking_type = $_GET['booking_type'];
$emp_id = $_SESSION['emp_id'];

$sq_service_voucher = mysql_fetch_assoc(mysql_query("select * from excursion_service_voucher where booking_id='$booking_id' and booking_type='excursion'"));
$sq_excname = mysql_query("select * from excursion_master_entries where exc_id='$booking_id'");
$total_adl=0;
$total_child=0;
while($row=mysql_fetch_assoc($sq_excname))
{
  $total_adl=$total_adl+$row['total_adult'];
  $total_child=$total_child+$row['total_child'];
}

$sq_booking = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$booking_id'"));
$sq_traveler = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
$name = $sq_traveler['first_name'].' '.$sq_traveler['last_name'];


$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
if($emp_id == '0'){ $emp_name = 'Admin';}
else { $emp_name = $sq_emp['first_name'].' ' .$sq_emp['last_name']; }
?>
    <section class="print_header main_block">
      <div class="col-md-6 no-pad">
      <span class="title"><i class="fa fa-file-text"></i> ACTIVITY SERVICE VOUCHER</span>
        <div class="print_header_logo">
          <img src="<?= $admin_logo_url ?>" class="img-responsive mg_tp_10">
        </div>
      </div>
      <div class="col-md-6 no-pad">
        <div class="print_header_contact text-right">
          <span class="title"><?php echo $app_name; ?></span><br>
          <p><?php echo $app_address; ?></p>
          <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo $app_contact_no; ?></p>
          <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>
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
        <div class="col-md-7 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CUSTOMER NAME :</span> <?= $name ?></li>
          </ul>
        </div>
        <div class="col-md-5 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>TOTAL GUEST(s) :</span> <?= $total_adl+$total_child ;?></li>
          </ul>
        </div>
      </div>
    </section>

    <!-- EXC Detail -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>DATETIME</th>
                <th>CITY NAME</th>
                <th>Activity NAME</th>
                <th>TRANSFER OPTION</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sq_exc_acc = mysql_query("select * from excursion_master_entries where exc_id='$booking_id'");
              while($row_exc_acc=mysql_fetch_assoc($sq_exc_acc)){
                $sq_city_name = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_exc_acc[city_id]'"));
                $sq_exc_name = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id='$row_exc_acc[exc_name]'"));
              ?>
                <tr>
                  <td><?= get_datetime_user($row_exc_acc['exc_date']) ?></td>
                  <td><?= $sq_city_name['city_name'] ?></td>
                  <td><?= $sq_exc_name['excursion_name'] ?></td>
                  <td><?= $row_exc_acc['transfer_option'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <section class="print_sec main_block">
      <?php if($sq_service_voucher['note'] != ''){ ?>
      <div class="row">
        <div class="col-md-12">
          <div class="print_info_block">
            <ul class="main_block noType">
              <li class="col-md-12 mg_tp_10 mg_bt_10"><span>Note : </span><?= $sq_service_voucher['note'] ?></li>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
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
            $sq_terms_cond = mysql_fetch_assoc(mysql_query("select * from terms_and_conditions where type='Excursion Service Voucher' and active_flag ='Active'"));
            echo $sq_terms_cond['terms_and_conditions'];?>
          </div>
        </div>
      </div>
    </section>

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
  </body>
</html>