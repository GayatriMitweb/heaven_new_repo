<?php 
include "../../../../../../model/model.php";
$quotation_id = $_POST['quotation_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from car_rental_quotation_master where quotation_id='$quotation_id'"));
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
			    <li role="presentation" class="active"><a href="#tab_1_c" aria-controls="tab_1_c" role="tab" data-toggle="tab">Select Enquiry</a></li>
			    <li role="presentation"><a href="#tab_2_c" aria-controls="tab_2_c" role="tab" data-toggle="tab">Costing</a></li>
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content" style="padding:20px 10px;">
			    <div role="tabpanel" class="tab-pane active" id="tab_1_c">
			    	<?php  include_once('tab1.php'); ?>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="tab_2_c">
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
$('#quotation_date, #traveling_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#from_date,#to_date').datetimepicker({ format:'d-m-Y' });
$('#quotation_update_modal').modal('show');
function reflect_feilds1(){
	
	var type = $('#travel_type').val();
	
	if(type=='Local'){
		$('#total_hr,#total_km,#local_places_to_visit').show();
		$('#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry,#other_charges,#places_to_visit,#traveling_date1').hide();
	}
	if(type=='Outstation'){
		$('#total_hr,#total_km,#local_places_to_visit').hide();
		$('#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry,#other_charges,#places_to_visit,#traveling_date1').show();
	}
}reflect_feilds1();
</script>
<script src="<?php echo BASE_URL ?>view/package_booking/quotation/car_flight/js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>