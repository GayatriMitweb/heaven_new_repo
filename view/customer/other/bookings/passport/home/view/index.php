<?php 
include "../../../../../../../model/model.php";
 
$passport_id = $_POST['passport_id'];

$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
$date = $sq_passport_info['created_at'];
$yr = explode("-", $date);
$year =$yr[0];
$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from passport_payment_master where passport_id='$passport_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$paid_amount = $sq_paid_amount['sum'];
$sale_amount = $sq_passport_info['passport_issue_amount'] - $sq_passport_info['total_refund_amount'];
$balance_amount = $paid_amount - $sale_amount;
?>
<div class="modal fade profile_box_modal" id="passport_view_modal" role="dialog" aria-labelledby="myModalLabel">
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
$('#passport_view_modal').modal('show');
</script>  
 
