<?php
include "../../../../model/model.php";
$tariff_id = $_POST['tariff_id'];
$sq_query = mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$tariff_id'");
?>
<div class="modal fade profile_box_modal" id="hotel_view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs responsive" role="tablist">
			<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Seasonal Tariff</a></li>
			<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			</ul>
			<!-- Tab panes1 -->
			<div class="tab-content responsive">
				<!-- *****TAb1 start -->
				<div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
					<?php include "tab1.php"; ?>
				</div>
				<!-- ********Tab1 End******** -->
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


 

