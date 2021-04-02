<?php 
include "../../../../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="car_sc" name="car_sc">
<input type="hidden" id="car_markup" name="car_markup">
<input type="hidden" id="car_taxes" name="car_taxes">
<input type="hidden" id="car_markup_taxes" name="car_markup_taxes">
<input type="hidden" id="car_tds" name="car_tds">
<div class="modal fade" id="quotation_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="width:96%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Quotation</h4>
      </div>
      <div class="modal-body">

      	<section id="sec_ticket_save" name="frm_ticket_save">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs text_left_sm_xs" role="tablist">
			    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Select Enquiry</a></li>
			    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Costing</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab1">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab2">
			    	<?php  include_once('tab2.php'); ?>
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
$('#quotation_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#traveling_date').datetimepicker({ format:'d-m-Y H:i' });

$('#quotation_save_modal').modal('show');
</script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/car_flight/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>