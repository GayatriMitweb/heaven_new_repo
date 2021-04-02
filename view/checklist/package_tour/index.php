<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='checklist/index.php'"));
$branch_status = $sq['branch_status'];
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6">
            <input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
			<select id="booking_id" name="booking_id" title="Select booking id" style="width:100%"> 
                <option value="">Select booking ID</option>
                <?php 
                    $query ="select * from package_tour_booking_master where 1";
                    
                    if($role != 'Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                      $query .= " and emp_id='$emp_id'";
                    }
                    if($branch_status=='yes' && $role!='Admin'){
                        $query .= " and branch_admin_id = '$branch_admin_id'";
                    } 
                         
                    $query .= " order by booking_id desc";
                    $sq_booking = mysql_query($query);
                    while($row_booking = mysql_fetch_assoc($sq_booking))
                    {
                      $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));   
                    ?>
                     <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo "Booking ID-".$row_booking['booking_id']."-".$sq_customer['first_name'].' '.$sq_customer['last_name']; ?></option>
                     <?php    
                        
                    }    
                 ?>
            </select>
		</div>		

	</div>
</div>
<div id="div_checklist_reflect" class="main_block"></div>

<script>
$('#booking_id').select2();
$('#booking_id').change(function(){
	package_tour_checklist_reflect();
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>