<?php 
include "../../../../../../model/model.php";
$quotation_id = $_POST['quotation_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id']; 
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from flight_quotation_master where quotation_id='$quotation_id'"));
?>
<div class="modal fade" id="quotation_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" style="width:96%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Quotation Details</h4>
      </div>
      <div class="modal-body">

      	<section id="sec_ticket_save" name="frm_ticket_save">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs text_left_sm_xs" role="tablist">
			    <li role="presentation" class="active"><a href="#tab_1" aria-controls="tab_1" role="tab" data-toggle="tab">Select Enquiry</a></li>
			    <li role="presentation"><a href="#tab_2" aria-controls="tab_2" role="tab" data-toggle="tab">Travel Information</a></li>
			    <li role="presentation"><a href="#tab_3" aria-controls="tab_3" role="tab" data-toggle="tab">Costing</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab_1">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_2">
			    	<?php  include_once('tab2.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_3">
			    	<?php  include_once('tab3.php'); ?>
			    </div>
			  </div>
			</div>       
        </section>
      </div>  
    </div>
  </div>
</div>


<script>
$('#enquiry_id').select2();
$('#from_date1, #to_date1,#quotation_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#quotation_update_modal').modal('show');

</script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/car_flight/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>