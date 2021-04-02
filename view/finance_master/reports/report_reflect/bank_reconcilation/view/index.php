<?php 
include "../../../../../../model/model.php";
$id = $_POST['id'];
?>
<form id="bank_display_save">
<input type="hidden" name="button_id" id='button_id'>
<div class="modal fade profile_box_modal" id="bank_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#ch_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Cheque Information</a></li>
			    <li role="presentation"><a href="#bank_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Bank DR/CR Information</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

				 	 <!-- Tab panes1 -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="ch_information">
					    <?php
					    $count_query = mysql_num_rows(mysql_query("select * from bank_reconcl_receipt where id='$id'")); 
					    if($count_query > '0'){ ?>
					     <div class="row">
							<div class="col-md-12 mg_tp_20">
								<h3 class="editor_title">Cheque Deposited but not Cleared</h3>
								<div class="panel panel-default panel-body app_panel_style">
									<div class="row">
										<div class="col-md-12 right_border_none_sm">
							            	<table class="table table-bordered table-hover" id="tbl_list" style="margin: 20px 0 !important;">
												<thead>
													<tr class="table-heading-row">
														<th>Sr.No</th>
														<th>Date</th>
														<th>Cheque_No</th>
														<th>Sale</th>
														<th>Sale_Id</th>
														<th>Amount</th>
													</tr>														
												</thead>
												<tbody>
												<?php 				                 
												$count = 1;
												$query = "select * from bank_reconcl_receipt where id='$id'";	
												$sq_query = mysql_query($query);
												while($sq_bank_receipt = mysql_fetch_assoc($sq_query)){
								        	 	?>
													<tr>
														<td><?= $count++ ?></td>
														<td><?= get_date_user($sq_bank_receipt['date']) ?></td>
														<td><?= $sq_bank_receipt['cheque_no'] ?></td>
														<td><?= $sq_bank_receipt['sale'] ?></td>
														<td><?= $sq_bank_receipt['sale_id'] ?></td>
														<td><?= $sq_bank_receipt['amount'] ?></td>
													</tr>
												<?php } ?>
												</tbody>
							            	</table>
										</div>
					    			</div>
								</div>	
						    </div>
				        </div><?php } ?>
						<?php
					    $count_query = mysql_num_rows(mysql_query("select * from bank_reconcl_payment where id='$id'")); 
					    if($count_query > '0'){ ?>
					     <div class="row">
							<div class="col-md-12 mg_tp_20">
								<h3 class="editor_title">Cheque Issued but not Presented for Payment</h3>
								<div class="panel panel-default panel-body app_panel_style">
									<div class="row">
										<div class="col-md-12 right_border_none_sm">
							            	<table class="table table-bordered table-hover" id="tbl_list" style="margin: 20px 0 !important;">
												<thead>
													<tr class="table-heading-row">
														<th>Sr.No</th>
														<th>Date</th>
														<th>Cheque_No</th>
														<th>Sale</th>
														<th>Sale_Id</th>
														<th>Amount</th>
													</tr>														
												</thead>
												<tbody>
												<?php 				                 
												$count = 1;
												$query = "select * from bank_reconcl_payment where id='$id'";	
												$sq_query = mysql_query($query);
												while($sq_bank_receipt = mysql_fetch_assoc($sq_query)){
								        	 	?>
													<tr>
														<td><?= $count++ ?></td>
														<td><?= get_date_user($sq_bank_receipt['date']) ?></td>
														<td><?= $sq_bank_receipt['cheque_no'] ?></td>
														<td><?= $sq_bank_receipt['purchase'] ?></td>
														<td><?= $sq_bank_receipt['purchase_id'] ?></td>
														<td><?= $sq_bank_receipt['amount'] ?></td>
													</tr>
												<?php } ?>
												</tbody>
							            	</table>
										</div>
					    			</div>
					    		</div>
						    </div>
				        </div><?php } ?>

				    </div>
				    <!-- ********Tab1 End******** --> 	    
				    <!-- *** Tab 2*** -->            
				    <div role="tabpanel" class="tab-pane" id="bank_information">
					    <?php
					    $count_query = mysql_num_rows(mysql_query("select * from bank_reconcl_debit_for where id='$id'")); 
					    if($count_query > '0'){ ?>
					     <div class="row">
							<div class="col-md-12 mg_tp_20">
								<h3 class="editor_title">Bank Debits</h3>
								<div class="panel panel-default panel-body app_panel_style">
									<div class="row">
										<div class="col-md-12 right_border_none_sm">
							            	<table class="table table-bordered table-hover" id="tbl_list" style="margin: 20px 0 !important;">
												<thead>
													<tr class="table-heading-row">
														<th>Sr.No</th>
														<th>Date</th>
														<th>Debit_For</th>
														<th>Amount</th>
													</tr>														
												</thead>
												<tbody>
												<?php 				                 
												$count = 1;
												$query = "select * from bank_reconcl_debit_for where id='$id'";	
												$sq_query = mysql_query($query);
												while($sq_bank_receipt = mysql_fetch_assoc($sq_query)){
								        	 	?>
													<tr>
														<td><?= $count++ ?></td>
														<td><?= get_date_user($sq_bank_receipt['date']) ?></td>
														<td><?= $sq_bank_receipt['debit_for'] ?></td>
														<td><?= $sq_bank_receipt['amount'] ?></td>
													</tr>
												<?php } ?>
												</tbody>
							            	</table>
										</div>
									</div>
				    			</div>
						    </div>
				        </div><?php } ?>
						<?php
					    $count_query = mysql_num_rows(mysql_query("select * from bank_reconcl_credit_for where id='$id'")); 
					    if($count_query > '0'){ ?>
					     <div class="row">
							<div class="col-md-12 mg_tp_20">
								<h3 class="editor_title">Bank Credits</h3>
								<div class="panel panel-default panel-body app_panel_style">						
									<div class="row">
										<div class="col-md-12 right_border_none_sm">
							            	<table class="table table-bordered table-hover" id="tbl_list" style="margin: 20px 0 !important;">
												<thead>
													<tr class="table-heading-row">
														<th>Sr.No</th>
														<th>Date</th>
														<th>Credit_For</th>
														<th>Amount</th>
													</tr>														
												</thead>
												<tbody>
												<?php 				                 
												$count = 1;
												$query = "select * from bank_reconcl_credit_for where id='$id'";	
												$sq_query = mysql_query($query);
												while($sq_bank_receipt = mysql_fetch_assoc($sq_query)){
								        	 	?>
													<tr>
														<td><?= $count++ ?></td>
														<td><?= get_date_user($sq_bank_receipt['date']) ?></td>
														<td><?= $sq_bank_receipt['credit_for'] ?></td>
														<td><?= $sq_bank_receipt['amount'] ?></td>
													</tr>
												<?php } ?>
												</tbody>
							            	</table>
										</div>
									</div>
				    			</div>
						    </div>
				        </div><?php } ?>

				    </div>
				    <!-- ***Tab2 End -->
				    </div>
				    </div>
				 </div>
	   </div>
      </div>
    </div>
  
</div>
</div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#bank_display_modal').modal('show');

function check_id(button_id_temp){
   	$('#button_id').val(button_id_temp);
}

$('#bank_display_save').validate({
    submitHandler:function(){	
		var bank_id = $('#bank_id').val();

	    var approve_status = '';
	    var button_id = $('#button_id').val();

	    if(button_id == 'btn_approve'){
	    	approve_status = 'true';
	    }else{
	    	approve_status = 'false';
	    }
	    $('#vi_confirm_box').vi_confirm_box({
		    callback: function(data1){
		        if(data1=="yes"){
		          
		        	$(button_id).button('loading');

		        	$.ajax({
		        		type:'post',
		        		url:base_url()+'controller/finance_master/reports/bank_reconciliation/recl_approval.php',
		        		data:{ approve_status : approve_status,bank_id : bank_id },
		        		success:function(result){
		        			msg_alert(result);
		        			$('#bank_display_modal').modal('hide');
		        			report_reflect();
		        		}
		        	});

		        }
		      }
		});
}
});
</script>