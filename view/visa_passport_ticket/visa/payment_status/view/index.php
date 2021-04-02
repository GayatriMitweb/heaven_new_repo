<?php 
include "../../../../../model/model.php";

$visa_id = $_POST['visa_id'];

$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id = '$visa_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_visa_booking_id($visa_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row mg_bt_20">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Passenger Information</h3>
		            <div class="table-responsive">
                    <table class="table table-bordered no-marg">
	                    <thead>
                       <tr class="table-heading-row">
                       	<th>S_No.</th>
                       	<th>Passenger_Name</th>
                       	<th>Date_Of_Birth</th>
                       	<th>Adol</th>
                       	<th>Visa_country</th>
                       	<th>Visa_Type</th>
                       	<th>Passport_Id</th>
                       	<th>Issue_Date</th>
                       	<th>Expire_Date</th>
                       	<th>Nationality</th>
                       	<th>Documents</th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php 
                   		$sq_entry = mysql_query("select * from visa_master_entries where visa_id='$visa_id'");
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
							    <td><?php echo $row_entry['visa_country_name']; ?></td>
							    <td><?php echo $row_entry['visa_type']; ?></td>
							    <td><?php echo $row_entry['passport_id']; ?> </td>
							    <td><?php echo get_date_user($row_entry['issue_date']); ?></td>
							    <td><?php echo get_date_user($row_entry['expiry_date']); ?></td>
							    <td><?php echo $row_entry['nationality']; ?></td>
							    <td>
							    	<?php echo $row_entry['received_documents'];  ?>
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