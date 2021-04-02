<?php
include "../../../../../model/model.php";
$supplier_id = $_POST['id'];
$quotation_for = $_POST['quotation_for'];
$enquiry_id = $_POST['enquiry_id'];
?>
<div class="modal fade profile_box_modal" id="quotation_request_view" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Costing Information</a></li>
				<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			</ul>
			<div class="panel panel-default panel-body fieldset profile_background">
				<div role="tabpanel" class="tab-pane active" id="basic_information">
					<?php  include_once('hotel_tbl.php'); ?>
					<?php  include_once('dmc_tbl.php'); ?>
					<?php  include_once('transport_tbl.php'); ?>
				</div>
			</div>
		</div>
      </div>      
    </div>
  </div>
</div>
<script>
$('#quotation_request_view').modal('show');
</script>