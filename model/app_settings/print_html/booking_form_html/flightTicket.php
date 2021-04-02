<?php
include "../../../model.php"; 
include "../print_functions.php";
require("../../../../classes/convert_amount_to_word.php");

$ticket_id = $_GET['ticket_id'];
$invoice_date = $_GET['invoice_date'];

$sq_visa_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));

?>

    <!-- header -->
    <section class="print_header main_block">
      <div class="col-md-4 no-pad">
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

    <!-- Package -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-xs-12 mg_bt_20">
          <ul class="print_info_list no-pad noType">
            <li><span>CUSTOMER NAME :</span> <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'; ?></li>
            <!-- <li><span>BOOKING REFERENCE :</span> <?= "Pending" ?> </li> -->
            <li><span>BOOKING DATE :</span> <?= $invoice_date ?></li>
          </ul>
        </div>
      </div>
    </section>

    <?php 
     $sq_trip = mysql_query("SELECT * FROM ticket_trip_entries WHERE ticket_id='$ticket_id'");
     while($row_trip = mysql_fetch_assoc($sq_trip))
     { ?> 
    <!-- Passenger -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th colspan="6"><?php echo "From ".$row_trip['departure_city']." To ".$row_trip['arrival_city'] ; ?> </th>
              </tr>
              <tr class="table-heading-row">
                <th>Airline</th>
                <th>Departure Datetime</th>
                <th>Arrival Datetime</th>
                <th>Class</th>
                <th>Flight No.</th>
                <th>Airline PNR</th>
              </tr>
            </thead>
            <tbody>  
                  <tr>
                    <td><?php echo $row_trip['airlines_name']; ?></td>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($row_trip['departure_datetime'])); ?></td>
                    <td><?php echo date("d-m-Y H:i:s", strtotime($row_trip['arrival_datetime'])); ?></td>
                    <td><?php echo $row_trip['class']; ?></td>
                    <td><?php echo $row_trip['flight_no']; ?></td>
                    <td><?php echo $row_trip['airlin_pnr']; ?></td>
                  </tr>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
    <?php } ?>

    
    <!-- Passenger -->
    <section class="print_sec main_block">
      <div class="row">
        <div class="col-md-12">
         <div class="table-responsive">
          <table class="table table-bordered no-marg" id="tbl_emp_list">
            <thead>
              <tr class="table-heading-row">
                <th>Passengers</th>
                <th>Type</th>
                <th>Ticket Number</th>
                <th>Baggage</th>
              </tr>
            </thead>
            <tbody>
            <?php 
             $count = 1;
             $sq_passenger = mysql_query("select * from ticket_master_entries where ticket_id = '$ticket_id'");
             while($row_passenger = mysql_fetch_assoc($sq_passenger))
             { ?>   
                  <tr>
                    <td><?php echo $count.') '.$row_passenger['first_name'].' '.$row_passenger['last_name']; ?></td>
                    <td><?php echo $row_passenger['adolescence']; ?></td>
                    <td><?php echo $row_passenger['ticket_no']; if($row_passenger['main_ticket']) echo  '('.$row_passenger['main_ticket'].')';?></td>
                    <td><?php echo $row_passenger['baggage_info']; ?></td>
                  </tr>
             <?php 
             $count++;
             } ?>
            </tbody>
          </table>
         </div>
       </div>
      </div>
    </section>
   
  </body>
</html>