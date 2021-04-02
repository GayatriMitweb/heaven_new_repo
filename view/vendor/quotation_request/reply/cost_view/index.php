<?php 
include "../../../../../model/model.php";
include_once('../../../inc/vendor_generic_functions.php');
$id = $_POST['id'];

$sq_req = mysql_fetch_assoc(mysql_query("select * from vendor_reply_master where id='$id'"));
$sq_currency1 = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id = '$sq_req[currency_code]'"));
$vendor_type_val = get_vendor_name($sq_req['quotation_for'], $sq_req['supplier_id']);
?>
<div class="modal fade profile_box_modal" id="quotation_request_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">

      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Supplier Quotation </a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

              	<div class="panel panel-default panel-body fieldset profile_background">

              		<div role="tabpanel" class="tab-pane active" id="basic_information">
						
					<div class="row">
							<div class="col-md-12">
								<div class="profile_box main_block">
									    <div class="row mg_bt_10">
											<div class="col-md-6">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>QUOTATION FOR<em>:</em></label> <?= $sq_req['quotation_for'] ?>
											</div>
											<div class="col-md-6">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>SUPPLIER NAME <em>:</em></label> <?= $vendor_type_val ?>
											</div>
						    	        </div>
						    	        <br>
										<div class="row mg_bt_20">
											<?php if($sq_req['quotation_for']!="Transport Vendor"){ ?>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>HOTEL COST <em>:</em></label> <?= $sq_req['hotel_cost'] ?>
											</div>
											<?php }  
											 if($sq_req['quotation_for']!="Hotel Vendor"){ ?>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>TRANSPORT COST <em>:</em></label> <?= $sq_req['transport_cost'] ?>
											</div>
											<?php } 
											if($sq_req['quotation_for']=="DMC Vendor"){ ?>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>EXCURSION COST <em>:</em></label> <?= $sq_req['excursion_cost'] ?>
											</div>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>VISA COST <em>:</em></label> <?=  $sq_req['visa_cost'] ?>
											</div>
											<?php }  ?>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>TOTAL COST <em>:</em></label> <?= $sq_req['total_cost'] ?>
											</div>
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>Currency <em>:</em></label> <?= $sq_currency1['currency_code'] ?>
											</div>
										</div>
										<div class="row mg_bt_10">
											<div class="col-md-12">
												<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<label>Created by <em>:</em></label> <?= $sq_req['created_by'] ?>
											</div>
										</div>
								   </div>
							</div>
						</div>
						
						<h3 class="editor_title">COMMENTS</h3>
						<div class="panel panel-default panel-body app_panel_style">
							<div class="row mg_bt_10">
								<div class="col-md-12">
									<?= $sq_req['enquiry_spec'] ?>
								</div>
							</div>
						</div>
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