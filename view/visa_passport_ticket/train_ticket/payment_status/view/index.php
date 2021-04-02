<?php 
include "../../../../../model/model.php";

$train_ticket_id = $_POST['train_ticket_id'];

$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id = '$train_ticket_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_train_ticket_booking_id($train_ticket_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Passenger Information</h3>
                  <div class="table-responsive">
                      <?php $offset = ""; ?>
                      <table id="tbl_dynamic_passport" name="tbl_dynamic_passport" class="table table-bordered no-marg">
                      <thead>
                    <tr class="table-heading-row">
                      <th>S_No.</th>
                      <th>Passenger_Name</th>
                      <th>Birthdate</th>
                      <th>Adolescence</th>
                      <th>Coach_Number</th>
                      <th>Seat_Number</th>
                      <th>Ticket_Number</th>
                    </tr>
                    </thead>
                         <tbody>
                         <?php 
                            $count = 0;
                            $sq_entry = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
                                $bg="";
                            while($row_entry = mysql_fetch_assoc($sq_entry)){
                              if($row_entry['status']=="Cancel")
                              {
                                $bg="danger";
                              }
                              else
                              {
                                $bg="#fff";
                              }
                              $count++;
                              ?>
                   <tr class="<?php echo $bg; ?>">
                      <td><?php echo $count; ?></td>
                      <td><?php echo $row_entry['first_name']." ".$row_entry['last_name']; ?></td>
                      <td><?= get_date_user($row_entry['birth_date']) ?></td>
                      <td><?php echo $row_entry['adolescence']; ?></td>
                      <td>
                        <?php echo $row_entry['coach_number']; ?>
                      </td>
                      <td>
                        <?php echo $row_entry['seat_number']; ?>
                      </td>
                      <td>
                        <?php echo $row_entry['ticket_number']; ?>
                      </td>
                  </tr>       
                              <?php }  ?>
                 </tbody>
                </table>
                </div>
		            </div>
		        </div>  
		    </div>
        <div class="row mg_tp_20">
    <div class="col-xs-12">
        <div class="profile_box main_block">
         <h3 class="editor_title">Trip Information</h3>
            <div class="table-responsive">
              <?php $offset = ""; ?>
              <table class="table table-bordered no-marg">
                <thead>
            <tr class="table-heading-row">
              <th>S_No.</th>
                  <th>Departure_Date/Time</th>
                  <th>Travel_From</th>
                  <th>Travel_To</th>
                  <th>Train_Name</th>
                  <th>Train_No.</th>
                  <th>Ticket_Status</th>
                  <th>Class</th>
                  <th>Booking_From</th>
                  <th>Booking_At</th>
                  <th>Arrival_Date/Time</th>
              </tr>
          </thead>
                  <tbody>
                  <?php
                    $count = 0;
                $sq_ticket= mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$train_ticket_id'"); 
                while($row_entry = mysql_fetch_assoc($sq_ticket)){
              $count++;             
              ?>
              <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo get_datetime_user($row_entry['travel_datetime']); ?></td>
                  <td><?= $row_entry['travel_from'] ?></td>
                  <td><?= $row_entry['travel_to'] ?></td>
                  <td>
                    <?php echo $row_entry['train_name']; ?>
                  </td>
                  <td>
                    <?php echo $row_entry['train_no']; ?>
                  </td>
                  <td><?= $row_entry['ticket_status']; ?></td>
                <td><?php echo $row_entry['class']; ?></td>
                  <td>
                    <?php echo $row_entry['booking_from']; ?>
                  </td>
                  <td>
                    <?php echo $row_entry['boarding_at']; ?>
                  </td>
                  <td>
                    <?php echo get_datetime_user($row_entry['arriving_datetime']); ?>
                  </td>
              </tr>  
                    <?php
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
</div>
  
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_display_modal').modal('show');
</script>