<?php 
include "../../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];
$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
$date = $sql_booking_date['created_at'];
$yr = explode("-", $date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_ticket_booking_id($ticket_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		        <h3 class="editor_title">Passenger Information</h3>
            <?php   $query = "select * from ticket_master where 1 ";
            $query .=" and ticket_id='$ticket_id'";?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
          <thead>
            <tr class="table-heading-row">
              <th>S_No.</th>
              <th>Passenger_name</th>
              <th>Birth_Date</th>
              <th>Adolescence</th>
              <th>Ticket_No.</th>
              <th>Gds_Pnr</th>
            </tr>
            
          </thead>
          <tbody>
            <?php 
            $count = 0;
            $sq_ticket = mysql_query($query);
            while($row_ticket =mysql_fetch_assoc($sq_ticket)){

              $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

              $sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");

              $date = $row_ticket['created_at'];
              $yr = explode("-", $date);
              $year =$yr[0];
              while($row_entry = mysql_fetch_assoc($sq_entry)){


                $bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
                ?>
                <tr class="<?= $bg ?>">
                  <td><?= ++$count ?></td>
                  <td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
                  <td><?= get_date_user($row_entry['birth_date']) ?></td>
                  <td><?= $row_entry['adolescence'] ?></td>
                  <td><?= $row_entry['ticket_no'] ?></td>
                  <td><?= $row_entry['gds_pnr'] ?></td>
                </tr>
                <?php
              }

            }
            ?>
          </tbody>
        </table>
      </div>
      </div>
      </div>  
    </div>
    <div class="row">    
    <div class="col-xs-12">
      <div class="profile_box main_block" style="margin-top: 25px">
            <h3 class="editor_title">Trip Information</h3>
            <?php   $query = "select * from ticket_master where 1 ";
            $query .=" and ticket_id='$ticket_id'";
            $tickect_query="select * from ticket_trip_entries where 1 and ticket_id='$ticket_id' ";
            ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
          <thead>
            <tr class="table-heading-row">
              <th>S_No</th>
              <th>Departure_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th>Arrival_Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th>Airline</th>
              <th>Class</th>
              <th>Flight_No.</th>
              <th>Airline_PNR</th>
              <th>From_City</th>
              <th>Sector_From</th>
              <th>To_City</th>
              <th>Sector_To</th>
              <th>Meal_Plan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th>Luggage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th>Special_Note</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $count = 0;
            $sq_ticket = mysql_query($query);
            $sq_ticket1 = mysql_query($tickect_query);
            while($row_ticket =mysql_fetch_assoc($sq_ticket)){

              $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

              $sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
              
              while($row_entry = mysql_fetch_assoc($sq_entry)){
                       while($row_entry1 = mysql_fetch_assoc($sq_ticket1)) {
                         $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry1[from_city]'"));
                            $sq_city1 = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_entry1[to_city]'"));  
                $bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
                ?>
                <tr class="<?= $bg ?>">
                  <td><?= ++$count ?></td>
                  <td><?php echo date('d/m/Y H:i:s' , strtotime($row_entry1['departure_datetime'])); ?> </td>
                  <td><?php echo date('d/m/Y H:i:s' , strtotime($row_entry1['arrival_datetime'])); ?></td>
                  <td><?php echo $row_entry1['airlines_name']; ?></td>
                  <td><?php echo $row_entry1['class']; ?></td>
                  <td><?php echo $row_entry1['flight_no']; ?></td>
                  <td><?php echo $row_entry1['airlin_pnr']; ?></td>
                  <td><?php echo $sq_city['city_name']; ?></td>
                  <td><?php echo $row_entry1['departure_city']; ?></td>
                  <td><?php echo $sq_city1['city_name']; ?></td>
                  <td><?php echo $row_entry1['arrival_city']; ?></td>
                  <td><?php echo $row_entry1['meal_plan']; ?></td>
                  <td><?php echo $row_entry1['luggage']; ?></td>
                  <td><?php echo $row_entry1['special_note']; ?></td>
                </tr>
                <?php
              }

            }
          }
            ?>
          </tbody>
        </table>
            </div>
        </div>  
    </div>
</div> 
</div>	
</div>
</div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_display_modal').modal('show');
</script>