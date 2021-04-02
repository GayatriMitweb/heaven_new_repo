<?php
include "../../../model/model.php";
$booking_id = $_POST['booking_id'];
$query = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
$cart_checkout_data = json_decode($query['cart_checkout_data']);
$traveller_details = json_decode($query['traveller_details']);

$hotel_list_arr = array();
$transfer_list_arr = array();
$activity_list_arr = array();
$tours_list_arr = array();
for($i=0;$i<sizeof($cart_checkout_data);$i++){
  if($cart_checkout_data[$i]->service->name == 'Hotel'){
    array_push($hotel_list_arr,$cart_checkout_data[$i]);
  }
  if($cart_checkout_data[$i]->service->name == 'Transfer'){
    array_push($transfer_list_arr,$cart_checkout_data[$i]);
  }
  if($cart_checkout_data[$i]->service->name == 'Activity'){
    array_push($activity_list_arr,$cart_checkout_data[$i]);
  }
  if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
    array_push($tours_list_arr,$cart_checkout_data[$i]);
  }
}
//Get default currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
?>
<div class="modal fade profile_box_modal c-bookingInfo" id="b2bsale_details" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="nav-item active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="nav-link active tab_name">Service Information</a></li>
			    <li role="presentation" class="nav-item"><a href="#trave_information" aria-controls="home" role="tab" data-toggle="tab" class="nav-link tab_name">Traveller Information</a></li>
			    <li role="presentation" class="nav-item"><a href="#cost_information" aria-controls="home" role="tab" data-toggle="tab" class="nav-link tab_name">Costing Information</a></li>
			    <li role="presentation" class="nav-item"><a href="#rece_information" aria-controls="home" role="tab" data-toggle="tab" class="nav-link tab_name">Receipt Information</a></li>
			    <li class="pull-right" class="nav-item"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

              <div class="panel panel-default panel-body fieldset profile_background">

				  <!-- Tab panes1 -->
				  <div class="tab-content">

				    <!-- *****TAb1 start -->
				    <div role="tabpanel" class="tab-pane active" id="basic_information">
				     <?php include "tab1.php"; ?>
				    </div>
				    <!-- ********Tab1 End******** --> 
				    <!-- *****TAb2 start -->
				    <div role="tabpanel" class="tab-pane" id="trave_information">
				     <?php include "tab2.php"; ?>
				    </div>
				    <!-- ********Tab2 End******** --> 
				    <!-- *****TAb3 start -->
				    <div role="tabpanel" class="tab-pane" id="cost_information">
				     <?php include "tab3.php"; ?>
				    </div>
				    <!-- ********Tab3 End******** --> 
				    <!-- *****TAb4 start -->
				    <div role="tabpanel" class="tab-pane" id="rece_information">
				     <?php include "tab4.php"; ?>
				    </div>
				    <!-- ********Tab4 End******** --> 
	                
				  </div>

			  </div>
        </div>
	   </div>
      </div>
    </div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#b2bsale_details').modal('show');
</script>