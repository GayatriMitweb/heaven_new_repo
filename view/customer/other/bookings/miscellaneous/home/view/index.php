<?php 
include "../../../../../../../model/model.php";

$misc_id = $_POST['misc_id'];

$sq_visa_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$misc_id'"));
$date = $sq_visa_info['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$misc_service_arr = $sq_visa_info['service'];
$misc_service_arr1 = json_decode($misc_service_arr, true);
$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$sq_visa_info[misc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$credit_card_charges = $sq_paid_amount['sumc'];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">General Information</a></li>
			    <li role="presentation"><a href="#payment_information" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Receipt Information</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

              <div class="panel panel-default panel-body fieldset profile_background">

				  <!-- Tab panes1 -->
				  <div class="tab-content">

				    <!-- *****TAb1 start -->
				    <div role="tabpanel" class="tab-pane active" id="basic_information">
				     <?php include "tab1.php"; ?>
				    </div>
				    <!-- ********Tab1 End******** --> 
	                   
	                <!-- ***Tab2 Start*** -->
				    <div role="tabpanel" class="tab-pane" id="payment_information">
				       <?php include "tab2.php"; ?>
				    </div>
	                <!-- ***Tab2 End*** -->

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