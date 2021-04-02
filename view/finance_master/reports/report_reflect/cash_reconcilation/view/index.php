<?php 
include "../../../../../../model/model.php";

$id = $_POST['id'];
$query = "select * from cash_reconcl_master where id='$id'";

?>
<form id="cash_display_save">
<input type="hidden" name="cash_id" id="cash_id" value="<?= $id ?>">
<input type="hidden" name="button_id" id='button_id'>
<div class="modal fade profile_box_modal" id="cash_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  	
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Cash Reconciliation Information</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

				 	 <!-- Tab panes1 -->
					  <div class="tab-content">

					    <!-- *****TAb1 start -->
					    <div role="tabpanel" class="tab-pane active" id="basic_information">
					     <div class="row mg_tp_20">
							<div class="col-md-12">
								<div class="profile_box main_block">
						        	 	<?php 
						                   
											$count = 0;
											$sq_cash = mysql_fetch_assoc(mysql_query($query));
						        	 	?>
						        	 	<div class="row">
							        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd;">
							                   <span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Date Of Reconciliation <em>:</em></label>".get_date_user($sq_cash['reconcl_date']) ?>
									            </span>
									        </div>
							        	 	<div class="col-md-6 right_border_none_sm">				
							        	 		<span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Cash as per System <em>:</em></label> <b>".$sq_cash['system_cash']."</b>" ?>
									            </span>
									        </div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12 right_border_none_sm">			
												<span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Cash as per Tills <em>:</em></label><b>".$sq_cash['till_cash']."</b>" ?>
								            	</span>
								            	<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
													<thead>
														<tr class="table-heading-row">
															<th>Denominations</th>
															<th>Numbers</th>
															<th>Amount</th>
														</tr>														
													</thead>
													<tbody>
													<?php
													$sq_denom = mysql_query("select * from cash_denomination_master where id='$id'");
													 while($row_denom = mysql_fetch_assoc($sq_denom)){ ?>
														<tr>
															<td><?= $row_denom['denomination'] ?></td>
															<td><?= $row_denom['numbers'] ?></td>
															<td><?= $row_denom['amount'] ?></td>
														</tr>
														<?php } ?>
													</tbody>
								            	</table>
											</div>
						    			</div>
						        	 	<div class="row">
							        	 	<div class="col-md-12">
							                   <span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Difference prior to Reconciliation <em>:</em></label><b>".$sq_cash['diff_prior']."</b>" ?>
									            </span>
									        </div>
										</div>
										<hr>
						        	 	<div class="row">
							        	 	<div class="col-md-12">
							                   <span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Reconciliation<em> : </em> </label>" ?>
									            </span>
									        </div>
										</div>
						        	 	<div class="row">
							        	 	<div class="col-md-12">
							                   <?php
												$sq_rec = mysql_query("select * from cash_reconcl_master_entries where id='$id'");
												 while($row_rec = mysql_fetch_assoc($sq_rec)){ ?>
								                    <div class="main_block">
								                    	<div class="col-md-6">
									                  		<?php echo "<p>".$row_rec['reason']."</p>" ?>
									                  	</div>
									                  	<div class="col-md-6 text-left">
									                  		<?php echo " : ".$row_rec['amount'] ?>
									                  	</div>
										            </div>
										        <?php } ?>
									        </div>
										</div>
						        	 	<div class="row mg_tp_10">
							        	 	<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd;">
							                   <span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Reconciliation Amount <em>:</em></label><b>".($sq_cash['reconcl_amount'])."</b>" ?>
									            </span>
									        </div>
							        	 	<div class="col-md-6 right_border_none_sm">				
							        	 		<span class="main_block">
								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
								                  <?php echo "<label>Difference after Reconciliation <em>:</em></label> <b>".$sq_cash['diff_reconcl']."</b>" ?>
									            </span>
									        </div>
										</div>    
										<?php if($sq_cash['approval_status'] == ''){ ?>
							            <div class="row text-center mg_tp_10">
							              <div class="col-md-6 text-right">
							               <button class="btn btn-info btn-sm ico_left" id="btn_approve" onclick="check_id(this.id)"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Approved</button>
							              </div>
							              <div class="col-md-6 text-left">
							               <button id="btn_not_approve" class="btn btn-danger btn-sm ico_left" onclick="check_id(this.id)"><i class="fa fa fa-times"></i>&nbsp;&nbsp;Not Approved</button>
							              </div>
							            </div>
							            <?php } ?>
						    	</div>
						</div>
				    </div>
				    <!-- ********Tab1 End******** --> 	                
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
$('#cash_display_modal').modal('show');

function check_id(button_id_temp){
   	$('#button_id').val(button_id_temp);
}

$('#cash_display_save').validate({
    submitHandler:function(){	
		var cash_id = $('#cash_id').val();

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
		        		url:base_url()+'controller/finance_master/reports/cash_reconciliation/recl_approval.php',
		        		data:{ approve_status : approve_status,cash_id : cash_id },
		        		success:function(result){
		        			msg_alert(result);
		        			$('#cash_display_modal').modal('hide');
		        			report_reflect();
		        		}
		        	});

		        }
		      }
		});
}
});
</script>