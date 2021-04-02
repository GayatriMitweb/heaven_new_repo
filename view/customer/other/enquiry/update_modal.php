<?php 
include_once('../../../../model/model.php');

$customer_id = $_SESSION['customer_id'];

$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from customer_enquiry_master where enquiry_id='$enquiry_id'"));
?>
<form id="frm_update">
<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>">
<input type="hidden" id="customer_id" name="customer_id" value="<?= $customer_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Enquiry</h4>
      </div>
      <div class="modal-body">
        
		  <div class="row mg_bt_10">
		  	<div class="col-md-12">
		  		<select name="service_name" id="service_name" title="Service Name">
					<option value="<?= $sq_enq['service_name'] ?>"><?= $sq_enq['service_name'] ?></option>
		  			<option value="">Service Name</option>
		  			<option value="Group Booking">Group Booking</option>
                    <option value="Package Booking">Package Booking</option>
                    <option value="Visa">Visa</option>
                    <option value="Passport">Passport</option>
                    <option value="Air Ticket">Air Ticket</option>
                    <option value="Train Ticket">Train Ticket</option>
                    <option value="Hotel">Hotel</option>
                    <option value="Car Rental">Car Rental</option>
                    <option value="Bus">Bus</option>
		  		</select>
		  	</div>
		  </div>	
		  <div class="row">
		  	<div class="col-md-12">
		  		<textarea name="enquiry_specification" id="enquiry_specification" placeholder="Enquiry Specification" title="Enquiry Specification"><?= $sq_enq['enquiry_specification'] ?></textarea>
		  	</div>
		  </div>
		  <div class="row text-center mg_tp_20">
		  	<div class="col-md-12">
		  		<button class="btn btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
		  	</div>
		  </div>


      </div>
    </div>
  </div>
</div>
</form>

<script>
$('#update_modal').modal('show');
$('#frm_update').validate({
	rules:{
			service_name : { required : true },
			enquiry_specification : { required : true },
	},
	submitHandler:function(){
			
			var enquiry_id = $('#enquiry_id').val();
			var service_name = $('#service_name').val();
			var enquiry_specification = $('#enquiry_specification').val();

			$('#btn_save').button('loading');

			$.ajax({
				type:'post',
				url:base_url()+'controller/customer/enquiry/enquiry_update.php',
				data:{ enquiry_id : enquiry_id, service_name : service_name, enquiry_specification : enquiry_specification },
				success:function(result){
					$('#btn_save').button('reset');
					msg_alert(result);
					$('#update_modal').modal('hide');
					list_reflect();
				}
			});
	}
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>