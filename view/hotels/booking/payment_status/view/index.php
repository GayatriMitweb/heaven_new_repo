<?php 
include "../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id = '$booking_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_hotel_booking_id($booking_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row mg_bt_20">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Hotel Information</h3>
		            <div class="table-responsive">
                    <table  class="table table-bordered no-marg">
	                   <thead>
                         <tr class="table-heading-row">
                            <th>S_No.</th>
                            <th>City</th>
                            <th>Hotel</th>
                            <th>Check_In</th>
                            <th>Check_Out</th>
                            <th>Nights</th>
                            <th>Rooms</th>
                            <th>Room_Type</th>
                            <th>Category</th>
                            <th>Accommodation</th>
                            <th>Extra_Bed</th>
                            <th>Conf_No</th>
                         </tr>
                       </thead>
                       <tbody>
                       <?php 
                       $count = 0;
                       $sq_hotel_entry = mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'");

                       while($row_entry = mysql_fetch_assoc($sq_hotel_entry)){

                          $bg = ($row_entry['status']=="Cancel") ? "danger" : "";
                           
                           $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_entry[city_id]'"));

                           $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_id, hotel_name from hotel_master where hotel_id='$row_entry[hotel_id]'"));

                           $count++;
                            ?>
                           <tr class="<?= $bg ?>">
                              <td><?php echo $count; ?></td>
                              <td><?php echo $sq_city['city_name']; ?></td>
                            <td><?php echo $sq_hotel['hotel_name']; ?></td>
                              <td><?php echo date('d/m/Y H:i:s', strtotime($row_entry['check_in'])); ?></td>
                              <td><?php echo date('d/m/Y H:i:s', strtotime($row_entry['check_out'])); ?></td>
                              <td><?php echo $row_entry['no_of_nights']; ?></td>
                              <td><?php echo $row_entry['rooms'];  ?> </td>
                              <td><?php echo $row_entry['room_type']; ?></td>
                              <td><?php echo $row_entry['category']; ?></td>
                              <td><?php echo $row_entry['accomodation_type']; ?></td>
                              <td><?php echo $row_entry['extra_beds'];  ?></td>
                              <td><?php echo $row_entry['conf_no'];  ?></td>
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