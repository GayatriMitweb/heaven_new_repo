<?php
include "../../../model.php";
include "../print_functions.php";
?>
<script type="text/javascript">
function cal_amount(total_subgroup_amount)
{
	return parseFloat(total_subgroup_amount).toFixed(2);
}
</script>
<?php include "../../../../../model/model.php";  
$to_date = $_GET['from_date'];
$financial_year_id = $_GET['financial_year_id'];
$branch_admin_id = $_GET['branch_admin_id'];
if($to_date != ''){
	$to_date = get_date_user($to_date);
	$pnl_date = ' ('.$to_date.')';
}else{
	$pnl_date = ''; 
}
?>

<section class="print_header main_block mg_bt_20">
  <div class="col-md-8 no-pad">
  <span class="title"><i class="fa fa-file-text"></i> Cash Flow Projections<?= $pnl_date ?></span>
    <div class="print_header_logo">
      <img src="<?php echo $admin_logo_url; ?>" class="img-responsive mg_tp_10">
    </div>
  </div>
  <div class="col-md-4 no-pad">
    <div class="print_header_contact text-right">
      <span class="title"><?php echo $app_name; ?></span><br>
      <p><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address ?></p>
      <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i> <?php echo ($branch_status=='yes' && $role!='Admin') ? 
       $branch_details['contact_no'] : $app_contact_no ?></p>
      <p><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?php echo $app_email_id; ?></p>

    </div>
  </div>
</section>
<div class="row mg_tp_20">
<!-- ////////////////////////////////////CREDIT START/////////////////////////////  -->
	<div class="col-md-12 pl_sheet">
		<div class="panel panel-default main_block">
			<div class="panel-heading main_block">
				<div class="col-md-6 no-pad">
					<strong>Particulars</strong>
				</div>
				<div class="col-md-2 no-pad text-right"></div>
				<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
				<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
			</div>		
			<!-- A Part Start  -->
			<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4>Current Balance</h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount_d"><?= $total_head_amount_d ?></span>
					</div>
				</div>

				<div class="panel-group main_block no-marg" id="accordion" role="tablist" aria-multiselectable="true">
				<?php 
				$count_d =1;
				$head_count_d =1;
			 	$sq_group = mysql_query("select group_id from group_master where group_id='2' order by group_id desc");
				 //Groups
				 while($row_group = mysql_fetch_assoc($sq_group))
				      { 
				      	$sq_subgroup = mysql_query("select subgroup_id,subgroup_name from subgroup_master where group_id='$row_group[group_id]'");
				         
				        $total_head_amount_d = 0;
				         //Sub groups
				      	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
				         { 	
				         	$total_sub_group_amount_d = 0; ?>
							<!-- Accordian Start -->
							  <div class="panel panel-default main_block no-marg">
							    <div class="part_heading main_block" role="tab" id="heading1">
							      <h4 class="panel-title main_block">
							        <div class="col-md-8 no-pad">
							        	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $count_d ?>" aria-expanded="true" aria-controls="collapse<?= $count_d ?>">
								          <i class="fa fa-plus"></i>
								        </a>
							        	<?= $row_subgroup['subgroup_name'] ?> 
							        </div>
									<div class="col-md-2 no-pad text-right">
										<span class="list_heading_count" id="subgroup_amount_d<?= $count_d ?>"><?= '0.00' ?></span>
									</div>
									<div class="col-md-2 no-pad text-right"></div>
							      </h4>
							    </div>
							    <div id="collapse<?= $count_d ?>" class="panel-collapse collapse main_block in" role="tabpanel" aria-labelledby="heading<?= $count_d ?>">
							      <?php 			
									$sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'";			 
								    $q = mysql_query($sq_finance);
						            while($row_q = mysql_fetch_assoc($q))
						            {
						                $debit_amount = 0; $credit_amount = 0; $total_amount = 0;
						            	if($row_q['dr_cr']=='Dr'){
						            		$debit_amount = $row_q['balance'];
						            	}else{
						            		$credit_amount = $row_q['balance'];
						            	}
						            	//Debit Total 
						            	$q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit' ";	
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q1 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q1 .=" and financial_year_id='$financial_year_id'";		
										}		
										if($branch_admin_id != "0"){
											$q1 .=" and branch_admin_id='$branch_admin_id'";		
										}					            	
						            	$sq_opening_balance = mysql_query($q1);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$debit_amount += $row_balance['payment_amount'];
						            	}
						            	//Credit Total
						            	$q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit' ";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q2 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q2 .=" and financial_year_id='$financial_year_id'";		
										}		
										if($branch_admin_id != "0"){
											$q2 .=" and branch_admin_id='$branch_admin_id'";		
										}		
						            	$sq_opening_balance = mysql_query($q2);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$credit_amount += $row_balance['payment_amount'];
						            	}
						            	$total_amount = $total_amount + $debit_amount - $credit_amount;
						            	if($row_q['ledger_id'] != '' && $total_amount !='0'){	
							            ?>									      
										<!-- Ledgers Start -->
									      <div class="single_accordion_entry main_block">							      	
										        <div class="panel-body less_text main_block">
										        	<div class="col-md-6 no-pad">
											        	<span>
															<em style="width: 20px;display: inline-block;"></em>
														</span>
														<?= $row_q['ledger_name'] ?>
													</div>
													<div class="col-md-2 no-pad text-right">
														<span><?= number_format($total_amount,2) ?></span>
													</div>
													<div class="col-md-2 no-pad text-right"></div>
													<div class="col-md-2 no-pad text-right"></div>
										        </div>
									      </div>
										<!-- Ledgers End -->												
										<?php 
										 $total_sub_group_amount_d += $total_amount; 
										}
									} ?>									
					         		<script>
					         			var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
					         			$('#subgroup_amount_d'+<?= $count_d ?>).html(subgroup_amount_d);
					         		</script>  
							        <?php $count_d++; 						      
							        $total_head_amount_d += $total_sub_group_amount_d;					        
							   	 ?>													
			         		<script>
			         			var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
			         			$('#head_amount_d').html(head_amount_d);	
			         			var head_amount1 = $('#head_amount_d').html();   
			         			var head_amount2 = $('#head_amount_d1').html();
			         			var tmp_head_amount_d = parseFloat(head_amount1) + parseFloat(head_amount2);    	
			         			$('#span_total_sales_d1').html(tmp_head_amount_d.toFixed(2));
			         		</script>
						  <?php $head_count_d++;  ?>	
							    </div>		
							  </div>
							<!-- Accordian End -->	
				<?php } } ?>
				<!-- A Part End -->

				<!-- B Part Start -->
				<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4>Receivables</h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount_d1"><?= $total_head_amount_d ?></span>
					</div>
				</div>

				<?php 
				$count_d =1;
				$head_count_d =1;
			 	$sq_group = mysql_query("select group_id from group_master where group_id='20' order by group_id desc");
				 //Groups
				 while($row_group = mysql_fetch_assoc($sq_group))
				      { 
				      	$sq_subgroup = mysql_query("select subgroup_id,subgroup_name from subgroup_master where group_id='$row_group[group_id]'");
				         
				        $total_head_amount_d = 0;
				         //Sub groups
				      	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
				         { 	
				         	$total_sub_group_amount_d = 0; ?>
							<!-- Accordian Start -->
							  <div class="panel panel-default main_block no-marg">
							    <div class="part_heading main_block" role="tab" id="heading1">
							      <h4 class="panel-title main_block">
							        <div class="col-md-8 no-pad">
							        	<a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse1<?= $count_d ?>" aria-expanded="true" aria-controls="collapse<?= $count_d ?>">
								          <i class="fa fa-plus"></i>
								        </a>
							        	<?= 'Sales Receivables' ?> 
							        </div>
									<div class="col-md-2 no-pad text-right">
										<span class="list_heading_count" id="subgroup_amount_d1<?= $count_d ?>"><?= '0.00' ?></span>
									</div>
									<div class="col-md-2 no-pad text-right"></div>
							      </h4>
							    </div>
							    <div id="collapse1<?= $count_d ?>" class="panel-collapse collapse main_block in" role="tabpanel" aria-labelledby="heading1<?= $count_d ?>">
							      <?php 			
									$sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'";		
								    $q = mysql_query($sq_finance);
						            while($row_q = mysql_fetch_assoc($q))
						            {
						                $debit_amount = 0; $credit_amount = 0; $total_amount = 0;
						            	if($row_q['dr_cr']=='Dr'){
						            		$debit_amount = $row_q['balance'];
						            	}else{
						            		$credit_amount = $row_q['balance'];
						            	}
						            	$q3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q3 .=" and payment_date <= '$to_date'";	
										}		
										if($financial_year_id != ""){
											$q3 .=" and financial_year_id='$financial_year_id'";		
										} 		
										if($branch_admin_id != "0"){
											$q3 .=" and branch_admin_id='$branch_admin_id'";		
										}		           	
						            	$sq_opening_balance = mysql_query($q3);						
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$debit_amount += $row_balance['payment_amount'];
						            	}
						            	$q4 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q4 .=" and payment_date <= '$to_date'";	
										}
										if($financial_year_id != ""){
											$q4 .=" and financial_year_id='$financial_year_id'";		
										}			
										if($branch_admin_id != "0"){
											$q4 .=" and branch_admin_id='$branch_admin_id'";		
										}			 
						            	$sq_opening_balance = mysql_query($q4);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$credit_amount += $row_balance['payment_amount'];
						            	}
						            	$total_amount = $total_amount + $debit_amount - $credit_amount;
						            	
						            	if($row_q['ledger_id'] != '' && $total_amount !='0'){	
							            ?>									      
										  <!-- Ledgers Start -->
									      <div class="single_accordion_entry main_block">							      	
										        <div class="panel-body less_text main_block">
										        	<div class="col-md-6 no-pad">
											        	<span>
															<em style="width: 20px;display: inline-block;"></em>
														</span>
														<?= $row_q['ledger_name'] ?>
													</div>
													<div class="col-md-2 no-pad text-right">
														<span><?= number_format($total_amount,2) ?></span>
													</div>
													<div class="col-md-2 no-pad text-right"></div>
													<div class="col-md-2 no-pad text-right"></div>
										        </div>
									      </div>
										  <!-- Ledgers End -->												
										<?php 
										 $total_sub_group_amount_d += $total_amount; 
										}
									} ?>									
					         		<script>
					         			var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
					         			$('#subgroup_amount_d1'+<?= $count_d ?>).html(subgroup_amount_d);
					         		</script>  
							        <?php $count_d++; 						      
							        $total_head_amount_d += $total_sub_group_amount_d;					        
							   	 ?>													
			         		<script>
			         			var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
			         			$('#head_amount_d1').html(head_amount_d);	
			         			var head_amount1 = $('#head_amount_d').html();   
			         			var head_amount2 = $('#head_amount_d1').html();
			         			var tmp_head_amount_d = parseFloat(head_amount1) + parseFloat(head_amount2);    	
			         			$('#span_total_sales_d1').html(tmp_head_amount_d.toFixed(2));
			         		</script>
						    <?php $head_count_d++;  ?>	
							    </div>		
							  </div>
							<!-- Accordian End -->	


				<?php } } ?>
				<?php 
				$count_d =1;
				$head_count_d =1;
				         	$total_sub_group_amount_d = 0; ?>
							<!-- Accordian Start -->
							  <div class="panel panel-default main_block no-marg">
							    <div class="part_heading main_block" role="tab" id="heading1">
							      <h4 class="panel-title main_block">
							        <div class="col-md-8 no-pad">
							        	<a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse2<?= $count_d ?>" aria-expanded="true" aria-controls="collapse2<?= $count_d ?>">
								          <i class="fa fa-plus"></i>
								        </a>
							        	<?= 'Other Receivables' ?> 
							        </div>
									<div class="col-md-2 no-pad text-right">
										<span class="list_heading_count" id="subgroup_amount_d2<?= $count_d ?>"><?= '0.00' ?></span>
									</div>
									<div class="col-md-2 no-pad text-right"></div>
							      </h4>
							    </div>
							    <div id="collapse2<?= $count_d ?>" class="panel-collapse collapse main_block in" role="tabpanel" aria-labelledby="heading2<?= $count_d ?>">
							      <?php 			
									$sq_finance = "select * from ledger_master where group_sub_id in ('63','41','86','52','5','50','6','53','93')";			
								    $q = mysql_query($sq_finance);
						            while($row_q = mysql_fetch_assoc($q))
						            { 
						            	$debit_amount = 0; $credit_amount = 0; $total_amount = 0;
						            	if($row_q['dr_cr']=='Dr'){
						            		$debit_amount = $row_q['balance'];
						            	}else{
						            		$credit_amount = $row_q['balance'];
						            	}
						            	$q3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q3 .=" and payment_date <= '$to_date'";	
										}		
										if($financial_year_id != ""){
											$q3 .=" and financial_year_id='$financial_year_id'";		
										}   			
										if($branch_admin_id != "0"){
											$q3 .=" and branch_admin_id='$branch_admin_id'";		
										}        	
						            	$sq_opening_balance = mysql_query($q3);						
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$debit_amount += $row_balance['payment_amount'];
						            	}
						            	$q4 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q4 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q4 .=" and financial_year_id='$financial_year_id'";		
										}			
										if($branch_admin_id != "0"){
											$q4 .=" and branch_admin_id='$branch_admin_id'";		
										}		 
						            	$sq_opening_balance = mysql_query($q4);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$credit_amount += $row_balance['payment_amount'];
						            	}
						            		$total_amount = $total_amount + $credit_amount - $debit_amount;	
						            	
						            	if($row_q['ledger_id'] != '' && $total_amount !='0'){	
							            ?>									      
										  <!-- Ledgers Start -->
									      <div class="single_accordion_entry main_block">							      	
										        <div class="panel-body less_text main_block">
										        	<div class="col-md-6 no-pad">
											        	<span>
															<em style="width: 20px;display: inline-block;"></em>
														</span>
														<?= $row_q['ledger_name'] ?>
													</div>
													<div class="col-md-2 no-pad text-right">
														<span><?= number_format($total_amount,2) ?></span>
													</div>
													<div class="col-md-2 no-pad text-right"></div>
													<div class="col-md-2 no-pad text-right"></div>
										        </div>
									      </div>
										  <!-- Ledgers End -->												
										<?php 
										 $total_sub_group_amount_d += $total_amount; 
										}
									} ?>									
					         		<script>
					         			var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
					         			$('#subgroup_amount_d2'+<?= $count_d ?>).html(subgroup_amount_d);
					         		</script>  
							        <?php $count_d++; 						      
							        $total_head_amount_d += $total_sub_group_amount_d;					        
							   	 ?>													
			         		<script>
			         			var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
			         			$('#head_amount_d1').html(head_amount_d);	
			         			var head_amount1 = $('#head_amount_d').html();   
			         			var head_amount2 = $('#head_amount_d1').html();
			         			var tmp_head_amount_d = parseFloat(head_amount1) + parseFloat(head_amount2);    	
			         			$('#span_total_sales_d1').html(tmp_head_amount_d.toFixed(2));
			         		</script>
						    <?php $head_count_d++;  ?>	
							    </div>		
							  </div>
							<!-- Accordian End -->	

			<!-- Total -->
			<div class="panel-footer main_block">
				<div class="row">
					<div class="col-md-8"><strong>Sub Total :</strong></div>
					<div class="col-md-4 text-right"><strong id="span_total_sales_d1">0.00</strong></div>
				</div>
			</div>

     		<script>
     			var head_amount1 = $('#head_amount_d').html();   
     			var head_amount2 = $('#head_amount_d1').html();
     			var tmp_head_amount_d = parseFloat(head_amount1) + parseFloat(head_amount2);    	
     			$('#span_total_sales_d1').html(tmp_head_amount_d.toFixed(2));
     		</script>
			<!-- A Part Start -->		

			<!-- //////// C Part Start////////// -->
			<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4>Payables</h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount_d3"><?= $total_head_amount_d ?></span>
					</div>
				</div>

				<?php 
				$count_d =1;
				$head_count_d =1;
				      	$sq_subgroup = mysql_query("select subgroup_id,subgroup_name from subgroup_master where subgroup_id='105'");
				         
				        $total_head_amount_d = 0;
				         //Sub groups
				      	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
				         { 	
				         	$total_sub_group_amount_d = 0; ?>
							<!-- Accordian Start -->
							  <div class="panel panel-default main_block no-marg">
							    <div class="part_heading main_block" role="tab" id="heading1">
							      <h4 class="panel-title main_block">
							        <div class="col-md-8 no-pad">
							        	<a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapse3<?= $count_d ?>" aria-expanded="true" aria-controls="collapse3<?= $count_d ?>">
								          <i class="fa fa-plus"></i>
								        </a>
							        	<?= 'Purchase Payables' ?> 
							        </div>
									<div class="col-md-2 no-pad text-right">
										<span class="list_heading_count" id="subgroup_amount_d3<?= $count_d ?>"><?= '0.00' ?></span>
									</div>
									<div class="col-md-2 no-pad text-right"></div>
							      </h4>
							    </div>
							    <div id="collapse3<?= $count_d ?>" class="panel-collapse collapse main_block in" role="tabpanel" aria-labelledby="heading3<?= $count_d ?>">
							      <?php 			
									$sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'";		
								    $q = mysql_query($sq_finance);
						            while($row_q = mysql_fetch_assoc($q))
						            {
						                $debit_amount = 0; $credit_amount = 0; $total_amount = 0;
						            	if($row_q['dr_cr']=='Dr'){
						            		$debit_amount = $row_q['balance'];
						            	}else{
						            		$credit_amount = $row_q['balance'];
						            	}
						                $q6 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";			
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q6 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q6 .=" and financial_year_id='$financial_year_id'";		
										}			
										if($branch_admin_id != "0"){
											$q6 .=" and branch_admin_id='$branch_admin_id'";		
										}					            	
						            	$sq_opening_balance = mysql_query($q6);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$debit_amount += $row_balance['payment_amount'];
						            	}
						            	$q7 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit'";				
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q7 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q7 .=" and financial_year_id='$financial_year_id'";		
										}			
										if($branch_admin_id != "0"){
											$q7 .=" and branch_admin_id='$branch_admin_id'";		
										}						            	
						            	$sq_opening_balance = mysql_query($q7);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$credit_amount += $row_balance['payment_amount'];
						            	}
						            		$total_amount = $total_amount + $credit_amount - $debit_amount;	
						            	
						            	if($row_q['ledger_id'] != '' && $total_amount !='0'){	
							            ?>									      
										  <!-- Ledgers Start -->
									      <div class="single_accordion_entry main_block">							      	
										        <div class="panel-body less_text main_block">
										        	<div class="col-md-6 no-pad">
											        	<span>
															<em style="width: 20px;display: inline-block;"></em>
														</span>
														<?= $row_q['ledger_name'] ?>
													</div>
													<div class="col-md-2 no-pad text-right">
														<span><?= number_format($total_amount,2) ?></span>
													</div>
													<div class="col-md-2 no-pad text-right"></div>
													<div class="col-md-2 no-pad text-right"></div>
										        </div>
									      </div>
										  <!-- Ledgers End -->												
										<?php 
										 $total_sub_group_amount_d += $total_amount; 
										}
									} ?>									
					         		<script>
					         			var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
					         			$('#subgroup_amount_d3'+<?= $count_d ?>).html(subgroup_amount_d);
					         		</script>  
							        <?php $count_d++; 						      
							        $total_head_amount_d += $total_sub_group_amount_d;					        
							   	 ?>													
			         		<script>
			         			var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
			         			$('#head_amount_d3').html(head_amount_d);		
			         			var head_amount1 = $('#span_total_sales_d1').html();  
			         			var head_amount2 = $('#head_amount_d3').html();
			         			var tmp_head_amount_d = parseFloat(head_amount1) - parseFloat(head_amount2);    	
			         			$('#span_total_sales_d2').html(tmp_head_amount_d.toFixed(2));
			         		</script>
						    <?php $head_count_d++;  ?>	
							    </div>		
							  </div>
							<!-- Accordian End -->	


				<?php }  ?>
				
				<?php 
				$count_d =1;
				$head_count_d =1;
				$total_sub_group_amount_d = 0; ?>
							<!-- Accordian Start -->
							  <div class="panel panel-default main_block no-marg">
							    <div class="part_heading main_block" role="tab" id="heading1">
							      <h4 class="panel-title main_block">
							        <div class="col-md-8 no-pad">
							        	<a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapse4<?= $count_d ?>" aria-expanded="true" aria-controls="collapse4<?= $count_d ?>">
								          <i class="fa fa-plus"></i>
								        </a>
							        	<?= 'Other Payables' ?> 
							        </div>
									<div class="col-md-2 no-pad text-right">
										<span class="list_heading_count" id="subgroup_amount_d4<?= $count_d ?>"><?= '0.00' ?></span>
									</div>
									<div class="col-md-2 no-pad text-right"></div>
							      </h4>
							    </div>
							    <div id="collapse4<?= $count_d ?>" class="panel-collapse collapse main_block in" role="tabpanel" aria-labelledby="heading4<?= $count_d ?>">
							      <?php 			
									$sq_finance = "select * from ledger_master where group_sub_id in ('84','44','47','43','75','81','82','59','103','51','35','69','97','98','76','57','88','80','92','72','9','7','8')";
								    $q = mysql_query($sq_finance);
						            while($row_q = mysql_fetch_assoc($q))
						            {
						            	$debit_amount = 0; $credit_amount = 0; $total_amount = 0;
						            	if($row_q['dr_cr']=='Dr'){
						            		$debit_amount = $row_q['balance'];
						            	}else{
						            		$credit_amount = $row_q['balance'];
						            	}
						            	$q3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q3 .=" and payment_date <= '$to_date'";	
										}		
										if($financial_year_id != ""){
											$q3 .=" and financial_year_id='$financial_year_id'";		
										}  			
										if($branch_admin_id != "0"){
											$q3 .=" and branch_admin_id='$branch_admin_id'";		
										}         	
						            	$sq_opening_balance = mysql_query($q3);						
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$debit_amount += $row_balance['payment_amount'];
						            	}
						            	$q4 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit'";
										if($to_date!=""){
											$to_date = get_date_db($to_date);
											$q4 .=" and payment_date <= '$to_date'";	
										}	
										if($financial_year_id != ""){
											$q4 .=" and financial_year_id='$financial_year_id'";		
										}				
										if($branch_admin_id != "0"){
											$q4 .=" and branch_admin_id='$branch_admin_id'";		
										}	 
						            	$sq_opening_balance = mysql_query($q4);
						            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
						            		$credit_amount += $row_balance['payment_amount'];
						            	}
						            		$total_amount = $total_amount + $credit_amount - $debit_amount;	
						            	if($row_q['ledger_id'] != '' && $total_amount !='0'){	
							            ?>									      
										  <!-- Ledgers Start -->
									      <div class="single_accordion_entry main_block">							      	
										        <div class="panel-body less_text main_block">
										        	<div class="col-md-6 no-pad">
											        	<span>
															<em style="width: 20px;display: inline-block;"></em>
														</span>
														<?= $row_q['ledger_name'] ?>
													</div>
													<div class="col-md-2 no-pad text-right">
														<span><?= number_format($total_amount,2) ?></span>
													</div>
													<div class="col-md-2 no-pad text-right"></div>
													<div class="col-md-2 no-pad text-right"></div>
										        </div>
									      </div>
										  <!-- Ledgers End -->												
										<?php 
										 $total_sub_group_amount_d += $total_amount; 
										}
									} ?>									
					         		<script>
					         			var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
					         			$('#subgroup_amount_d4'+<?= $count_d ?>).html(subgroup_amount_d);
					         		</script>  
							        <?php $count_d++; 						      
							        $total_head_amount_d += $total_sub_group_amount_d;					        
							   	 ?>													
			         		<script>
			         			var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
			         			$('#head_amount_d3').html(head_amount_d);	
			         			var head_amount1 = $('#span_total_sales_d1').html();   
			         			var head_amount2 = $('#head_amount_d3').html();
			         			var tmp_head_amount_d = parseFloat(head_amount1) - parseFloat(head_amount2);    	
			         			$('#span_total_sales_d2').html(tmp_head_amount_d.toFixed(2));
			         		</script>
						    <?php $head_count_d++;  ?>	
							    </div>		
							  </div>
							<!-- Accordian End -->	
			<!-- Total -->
			<div class="panel-footer main_block">
				<div class="row">
					<div class="col-md-8"><strong>Net Balance :</strong></div>
					<div class="col-md-4 text-right"><strong id="span_total_sales_d2">0.00</strong></div>
				</div>
			</div>															
     		<script>	
     			var head_amount1 = $('#span_total_sales_d1').html();   
     			var head_amount2 = $('#head_amount_d3').html();
     			var tmp_head_amount_d = parseFloat(head_amount1) - parseFloat(head_amount2);    	
     			$('#span_total_sales_d2').html(tmp_head_amount_d.toFixed(2));
     		</script>
		</div>
		</div>
	</div>
<!-- //////////////////////////////////////////////////////CREDIT END////////////////////////////////////////////////////////////////////////////////////////// -->
</div>

<script type="text/javascript">
	// App_accordion
 jQuery(document).ready(function() {
   jQuery(".panel-heading").click(function(){ 
    jQuery('#accordion .panel-heading').not(this).removeClass('isOpen');
    jQuery(this).toggleClass('isOpen');
    jQuery(this).next(".panel-collapse").addClass('thePanel');
    jQuery('#accordion .panel-collapse').not('.thePanel').slideUp("slow"); 
       jQuery(".thePanel").slideToggle("slow").removeClass('thePanel'); 
   });
   
  });
</script>