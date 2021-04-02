<?php 
include "../../../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" style="width:96%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Train Ticket</h4>
      </div>
      <div class="modal-body">
	    <input type="hidden" id="hotel_sc" name="hotel_sc">
		<input type="hidden" id="hotel_markup" name="hotel_markup">
		<input type="hidden" id="hotel_taxes" name="hotel_taxes">
		<input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes">
		<input type="hidden" id="hotel_tds" name="hotel_tds">
      	<section id="sec_ticket_save" name="frm_ticket_save">

      		<div>

			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Customer Details</a></li>
			    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Train Ticket</a></li>
			    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Receipt</a></li>
			    <li role="presentation"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Advance Receipt</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab1">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab2">
			    	<?php  include_once('tab2.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab3">
			    	<?php  include_once('tab3.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab4">
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
$('#save_modal').modal('show');

	function business_rule_load(){
		get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','false','service_charge','discount');
	}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>