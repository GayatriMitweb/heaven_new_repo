<?php 
include "../../../../../model/model.php";

$passport_id = $_POST['passport_id'];
$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id = '$passport_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="passport_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_passport_booking_id($passport_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row mg_bt_20">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		           	<h3 class="editor_title">Passenger Information</h3>
		            <div class="table-responsive">
                    <table  class="table table-bordered no-marg">
	                    <thead>
                        <tr class="table-heading-row">
                          <th>S_No.</th>
                          <th>Passenger_Name</th>
                          <th>Birthdate</th>
                          <th>Adolescence</th>
                          <th>Received_documents</th>
                        </tr>
                      </thead>
                           <tbody>
                           <?php 
                           $offset = "_u";
                           $sq_entry_count = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$passport_id'"));
                           if($sq_entry_count==0){
                              include_once('passport_member_tbl.php');  
                           }
                           else{
                              $count = 0;
                              $sq_entry = mysql_query("select * from passport_master_entries where passport_id='$passport_id'");
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
                                  <?php echo $row_entry['received_documents'];  ?>
                                </td>
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
		</div>	

</div>

</div>
</div>
</div>
  
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#passport_display_modal').modal('show');
</script>