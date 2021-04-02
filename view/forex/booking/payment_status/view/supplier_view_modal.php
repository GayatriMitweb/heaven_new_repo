<?php 
include "../../../../../model/model.php";
$booking_id = $_POST['booking_id'];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Purchase History</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row mg_bt_20">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		            <div class="table-responsive">
                    <table  class="table table-bordered no-marg">
	                   <thead>
                         <tr class="table-heading-row">
                            <th>S_No.</th>
                            <th>Supplier_Type</th>
                            <th>Supplier Name</th>
                            <th>Amount</th>
                         </tr>
                     </thead>
                     <tbody>
                       <?php 
                       $count = 0;
                       $sq_query = mysql_query("SELECT * FROM vendor_estimate WHERE estimate_type = 'Forex Booking' AND estimate_type_id = '$booking_id'");

                       while($row_entry = mysql_fetch_assoc($sq_query))
                       {
                          $Supplier_name = get_vendor_name_report($row_entry['vendor_type'] ,$row_entry['vendor_type_id']);
                          $bg = ($row_entry['status']=="Cancel") ? "danger" : "";

                           $count++;
                            ?>
                           <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $row_entry['vendor_type'];; ?></td>
                              <td><?php echo $Supplier_name; ?></td>
                              <td><?php echo $row_entry['net_total']; ?></td>
                           
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