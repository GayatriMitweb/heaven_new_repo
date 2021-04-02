<?php
include "../../../../../model/model.php";
$pricing_id = $_POST['pricing_id'];
$sq_query = mysql_fetch_assoc(mysql_query("select * from hotel_vendor_price_master where pricing_id='$pricing_id'"));
$hotel_id = $sq_query['hotel_id'];
$row_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
?>
<div class="modal fade profile_box_modal" id="hotel_view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs responsive" role="tablist">
			<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Hotel Basics</a></li>
			<li role="presentation"><a href="#black-dated" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Black-Dated Rates</a></li>
			<li role="presentation"><a href="#weekend" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Weekend Rates</a></li>
			<li role="presentation"><a href="#offers" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Offers/Coupon</a></li>
			<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			</ul>
			<!-- Tab panes1 -->
			<div class="tab-content responsive">
				<!-- *****TAb1 start -->
				<div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
					<?php include "tab1.php"; ?>
				</div>
				<!-- ********Tab1 End******** -->
				<!-- ***Tab3 Start*** -->
				<div role="tabpanel" class="tab-pane no-pad-sm" id="black-dated">
					<?php include "tab3.php"; ?>
				</div>
				<!-- ***Tab3 End*** -->
				<!-- ***Tab4 Start*** -->
				<div role="tabpanel" class="tab-pane no-pad-sm" id="weekend">
					<?php include "tab4.php"; ?>
				</div>
				<!-- ***Tab4 End*** -->
				<!-- ***Tab5 Start*** -->
				<div role="tabpanel" class="tab-pane no-pad-sm" id="offers">
					<?php include "tab5.php"; ?>
				</div>
				<!-- ***Tab5 End*** -->
			</div>
        </div>
	   </div>
      </div>
    </div>
</div>

<script>
$('#hotel_view_modal').modal('show');
$('#hotel_view_modal').on('shown.bs.modal', function () {
	fakewaffle.responsiveTabs(['xs', 'sm']);
});
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>


 

