<?php 
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];

?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_car_rental_booking_id($booking_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
           	<h3 class="editor_title">Vehicle Information</h3>
            <div class="table-responsive">
                <table id="tbl_dynamic_visa_update" name="tbl_dynamic_visa_update" class="table table-bordered no-marg">
                 <thead>
                   <tr class="table-heading-row">
                    <th>S_No.</th>
                    <th>Vehicle_Name</th>
                    <th>Vehicle_No</th>
                    <th>Driver_Name</th>
                    <th>Mobile_No</th>
                    <th>Type</th>
                   </tr>
                   </thead>
                   <tbody>
                   <?php 
                    $count = 1;
                    $sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));

                   $sq_vehicle_entries = mysql_query("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'");
                 while($row_vehicle = mysql_fetch_assoc($sq_vehicle_entries)){            
                  
                $sq_vehicle = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor_vehicle_entries where vehicle_id='$row_vehicle[vehicle_id]'"));
                                ?>
                     <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo$sq_booking['vehicle_name']; ?></td>
                        <td><?= $sq_vehicle['vehicle_no'] ?></td>
                      <td><?php echo $sq_vehicle['vehicle_driver_name']; ?></td>
                        <td><?php echo $sq_vehicle['vehicle_mobile_no']; ?></td>
                        <td><?php echo $sq_vehicle['vehicle_type']; ?></td>
                    </tr>   
                                <?php
                                $count++;
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