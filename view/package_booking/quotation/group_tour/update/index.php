<?php 
include "../../../../../model/model.php";
$quotation_id = $_POST['quotation_id'];
$package_id = $_POST['package_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
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
			    <li role="presentation" class="active"><a href="#tab1_u" aria-controls="tab1_u" role="tab" data-toggle="tab">Select Enquiry</a></li>
			    <li role="presentation"><a href="#tab3_u" aria-controls="tab3_u" role="tab" data-toggle="tab">Travel Information</a></li>
			    <li role="presentation"><a href="#tab4_u" aria-controls="tab4_u" role="tab" data-toggle="tab">Costing</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab1_u">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab3_u">
			    	<?php  include_once('tab3.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab4_u">
			    	<?php  include_once('tab4.php'); ?>
			    </div>
			  </div>
			</div>       
        </section>
      </div>  
    </div>
  </div>
</div>


<script>
$('#quotation_update_modal').modal('show');
$('#enquiry_id, #currency_code').select2();
$('#from_date1, #to_date1, #quotation_date, #train_arrival_date,#train_departure_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#txt_arrval1,#txt_dapart1').datetimepicker({ format:'d-m-Y H:i:s' });

</script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/group_tour/js/calculation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>