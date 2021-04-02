<?php
include "../../../../../model/model.php";
?>
<script type="text/javascript">
function cal_amount(total_head_amount){
	return parseFloat(total_head_amount).toFixed(2);
}
</script>
<?php
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];
?>
<div class="row mg_tp_20">
	<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">
	<!-- /////////////////////////DEBIT START////////////////////////// -->
		<!-- DEBIT -->
		<div class="col-md-6 pl_sheet">
			<div class="panel panel-default main_block">
				<div class="panel-heading main_block">
					<div class="col-md-10 no-pad">
						<strong>Particulars</strong>
					</div>
					<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
				</div>
				<div class="quadrant main_block">				
				<!-- List Heading -->
				<?php
				$count_d = 1;
				$head_count_d = 1;
				$sq_head = mysql_query("select * from head_master where head_id in('12','9')");			
				while($row_head = mysql_fetch_assoc($sq_head)){ //2 Heads(D2)
				?>
					<div class="list_heading main_block">
						<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
						<div class="col-md-4 no-pad text-right">
							<span class="list_heading_count" id="head_amount_d<?= $head_count_d ?>"><?= $total_head_amount_d ?></span>
						</div>
					</div>
					<?php
					$sq_group = mysql_query("select group_id from group_master where head_id='$row_head[head_id]' order by group_id desc");//Groups
					while($row_group = mysql_fetch_assoc($sq_group)){

						$total_head_amount_d = 0;
						$sq_subgroup = mysql_query("select subgroup_id,subgroup_name from subgroup_master where group_id='$row_group[group_id]'");

						while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups

							$total_sub_group_amount_d = 0; ?>
							<!-- Part Heading -->
							<div class="part_heading main_block">
								<h4 class="main_block"><div class="col-md-6"><?= $row_subgroup['subgroup_name'] ?></div>
								<div class="col-md-4 no-pad text-right">
									<span class="list_heading_count" id="subgroup_amount_d<?= $count_d ?>"><?= '0.00' ?></span>
								</div></h4>								
							</div>
							<?php
							$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
							while($row_q = mysql_fetch_assoc($q)){
	
								$total_amount = 0.00;
								$debit_amount = 0;
								$credit_amount = 0;
								if($row_q['balance_side'] == 'Debit'){ //ledger opening balances
									$debit_amount += $row_q['balance']; 
								}
								else{ 
									$credit_amount += $row_q['balance']; 
								}
	
								$sq_p3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
								if($from_date!="" && $to_date!=""){
									$from_date = get_date_db($from_date);
									$to_date = get_date_db($to_date);
									$sq_p3 .=" and payment_date between '$from_date' and '$to_date'";	
								}
								if($financial_year_id != ""){
									$sq_p3 .=" and financial_year_id='$financial_year_id'";		
								} 
								if($branch_admin_id != "0"){
									$sq_p3 .=" and branch_admin_id='$branch_admin_id'";		
								} 
								$sq_opening_balance = mysql_query($sq_p3);
								while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
									if($row_balance['payment_side'] == 'Debit'){
										$debit_amount += $row_balance['payment_amount'];
									}else{
										$credit_amount += $row_balance['payment_amount'];
									}
								}
								$total_amount = $debit_amount - $credit_amount;
								if($row_q['ledger_id'] != '' && $total_amount != 0){ ?>						         
									<div class="part_entry main_block">
										<div class="col-md-2 no-pad text-right"></div>
										<div class="col-md-8 no-pad">
											<span>
												<em style="width: 20px;display: inline-block;"></em>
											</span>
											<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
										</div>
										<div class="col-md-2 no-pad text-right">
											<span class="part_entry_m_count" id="subgroup_amount_d"><?= number_format($total_amount,2) ?></span>
										</div>
									</div>
									<?php
									$total_sub_group_amount_d += $total_amount;			
								}
							} ?>
							<script>
								var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d ?>');
								$('#subgroup_amount_d'+<?= $count_d ?>).html(subgroup_amount_d);
							</script>  
							<?php
							$count_d++;
							$total_head_amount_d += $total_sub_group_amount_d;
						}
					} ?>													
					<script>
						var head_amount_d = cal_amount('<?= $total_head_amount_d ?>');
						$('#head_amount_d'+<?= $head_count_d ?>).html(head_amount_d);	
						var tmp_head_amount_d1 = $('#span_total_sales_d1').html();   
						var tmp_head_amount_d = parseFloat(head_amount_d) + parseFloat(tmp_head_amount_d1);    	
						$('#span_total_sales_d1').html(tmp_head_amount_d.toFixed(2));
					</script>
					<?php
					$head_count_d++;
				} ?>
				</div>   <!-- quadrant end -->

				<div class="result_entry_block main_block">	  
					<!-- Profit Carried Down -->
					<div class="result_entry main_block" id="d2_block">
						<div class="col-md-8 no-pad">
							<span>
								<em style="width: 20px;display: inline-block;"></em>
							</span>
							<span class="result_entry_text">Gross Profit Carried Down</span>
						</div>
						<div class="col-md-2 no-pad text-right"></div>
						<div class="col-md-2 no-pad text-right">
							<span class="part_entry_m_count" id="d2_profit">0.00</span>
						</div>
					</div>
				</div>
				<!-- Total -->
				<div class="panel-footer main_block">
					<div class="row">
						<div class="col-md-8"><strong>Total :</strong></div>
						<div class="col-md-4 text-right"><strong id="span_total_sales_d1">0.00</strong></div>
					</div>
				</div>
				
				<div class="result_entry_block main_block">	  
					<!--Loss Brought Down -->
					<div class="result_entry main_block" id="id4_block">
						<div class="col-md-8 no-pad">
							<span>
								<em style="width: 20px;display: inline-block;"></em>
							</span>
							<span class="result_entry_text">Gross Loss Brought Down</span>
						</div>
						<div class="col-md-2 no-pad text-right"></div>
						<div class="col-md-2 no-pad text-right">
							<span class="part_entry_m_count" id="id4_loss">0.00</span>
						</div>
					</div>
				</div>
				<!-- ////////////Remaining 3 heads///////////////////////// -->
				
				<div class="quadrant main_block">
				<?php
				$count_d1 =1;
				$head_count_d1 =1;
				$sq_head = mysql_query("select head_name,head_id from head_master where head_id in('4','5','10')");
				while($row_head = mysql_fetch_assoc($sq_head)){ //Heads
				?>
					<!-- List Heading -->	
					<div class="list_heading main_block">
						<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
						<div class="col-md-4 no-pad text-right">
							<span class="list_heading_count" id="head_amount_d1<?= $head_count_d1 ?>"><?= $total_head_amount_d1 ?></span>
						</div>
					</div>

					<?php 
					$sq_group = mysql_query("select group_id from group_master where head_id='$row_head[head_id]' order by group_id desc");
					while($row_group = mysql_fetch_assoc($sq_group)){ //Groups

						$total_head_amount_d1 = 0;
						$sq_subgroup = mysql_query("select subgroup_name,subgroup_id from subgroup_master where group_id='$row_group[group_id]'");
						while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups

							$total_sub_group_amount_d1 = 0; ?>
							<!-- Part Heading -->
							<div class="part_heading main_block">
								<h4 class="main_block"><div class="col-md-6"><?= $row_subgroup['subgroup_name'] ?></div>
								<div class="col-md-4 no-pad text-right">
									<span class="list_heading_count" id="subgroup_amount_d_n<?= $count_d1 ?>"><?= '0.00' ?></span>
								</div></h4>								
							</div>
							<?php						 
							$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
							while($row_q = mysql_fetch_assoc($q)){
	
								$total_amount = 0.00;
								$debit_amount = 0;
								$credit_amount = 0;
								if($row_q['balance_side'] == 'Debit'){ //ledger opening balances
									$debit_amount += $row_q['balance']; 
								}
								else{ 
									$credit_amount += $row_q['balance']; 
								}
	
								$sq_p3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
								if($from_date!="" && $to_date!=""){
									$from_date = get_date_db($from_date);
									$to_date = get_date_db($to_date);
									$sq_p3 .=" and payment_date between '$from_date' and '$to_date'";	
								}
								if($financial_year_id != ""){
									$sq_p3 .=" and financial_year_id='$financial_year_id'";		
								} 
								if($branch_admin_id != "0"){
									$sq_p3 .=" and branch_admin_id='$branch_admin_id'";		
								} 
								$sq_opening_balance = mysql_query($sq_p3);
								while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
									if($row_balance['payment_side'] == 'Debit'){
										$debit_amount += $row_balance['payment_amount'];
									}else{
										$credit_amount += $row_balance['payment_amount'];
									}
								}
								$total_amount = $debit_amount - $credit_amount;
								if($row_q['ledger_id'] != '' && $total_amount != 0){
									?>						         
									<div class="part_entry main_block">
										<div class="col-md-2 no-pad text-right"></div>
										<div class="col-md-8 no-pad">
											<span>
												<em style="width: 20px;display: inline-block;"></em>
											</span>
											<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
										</div>
										<div class="col-md-2 no-pad text-right">
											<span class="part_entry_m_count" id="subgroup_amount_d"><?= number_format($total_amount,2) ?></span>
										</div>
									</div>
									<?php
									$total_sub_group_amount_d1 += $total_amount;
								}
							} ?>
							<script>
								var subgroup_amount_d = cal_amount('<?= $total_sub_group_amount_d1 ?>');
								$('#subgroup_amount_d_n'+<?= $count_d1 ?>).html(subgroup_amount_d);
							</script>  
							<?php
							$count_d1++; 
							$total_head_amount_d1 += $total_sub_group_amount_d1;
						}
					} ?>													
					<script>
						var head_amount_d1 = cal_amount('<?= $total_head_amount_d1 ?>');
						$('#head_amount_d1'+<?= $head_count_d1 ?>).html(head_amount_d1);	
						var tmp_head_amount_d2 = $('#span_total_sales_d2').html();   
						var tmp_head_amount_d1 = parseFloat(head_amount_d1) + parseFloat(tmp_head_amount_d2);  
						$('#span_total_sales_d2').html(tmp_head_amount_d1.toFixed(2));
					</script>
					<?php
					$head_count_d1++; 
				} ?>
				</div> <!-- Quadrant End -->
				<div class="result_entry_block main_block">
					<!--Net Profit Carried Down -->
					<div class="result_entry main_block" id="net_profit_block">
						<div class="col-md-8 no-pad">
							<span>
								<em style="width: 20px;display: inline-block;"></em>
							</span>
							<span class="result_entry_text">Net Profit Carried Down</span>
						</div>
						<div class="col-md-2 no-pad text-right"></div>
						<div class="col-md-2 no-pad text-right">
							<span class="part_entry_m_count" id="net_profit">0.00</span>
						</div>
					</div>
				</div>			    
				<!-- Total -->
				<div class="panel-footer main_block">
					<div class="row">
						<div class="col-md-8"><strong>Total :</strong></div>
						<div class="col-md-4 text-right"><strong id="span_total_sales_d2">0.00</strong></div>
					</div>
				</div>
			</div>
		</div>
	<!-- /////////////////////////DEBIT END//////////////////////////// -->

	<!-- ////////////////////CREDIT START///////////////////////////// -->
	<!-- CREDIT -->
	<div class="col-md-6 pl_sheet">
		<div class="panel panel-default main_block">
			<div class="panel-heading main_block">
				<div class="col-md-10 no-pad">
					<strong>Particulars</strong>
				</div>
				<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
			</div>
			<div class="quadrant main_block">
				<?php
				$count =1;
				$head_count =1;
				$row_head = mysql_fetch_assoc(mysql_query("select head_name from head_master where head_id='13'"));
				?>
				<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount<?= $head_count ?>"><?= $total_head_amount ?></span>
					</div>
				</div>
				<?php
				$sq_group = mysql_query("select group_id from group_master where head_id='13' order by group_id desc");
				while($row_group = mysql_fetch_assoc($sq_group)){ //Groups

					$total_head_amount = 0;
					$sq_subgroup = mysql_query("select subgroup_name,subgroup_id from subgroup_master where group_id='$row_group[group_id]'");
					while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups

						$total_sub_group_amount = 0;
						?>
						<!-- Part Heading -->
						<div class="part_heading main_block">
							<h4 class="main_block"><div class="col-md-6"><?= $row_subgroup['subgroup_name'] ?></div>
							<div class="col-md-4 no-pad text-right">
								<span class="list_heading_count" id="subgroup_amount<?= $count ?>"><?= '0.00' ?></span>
							</div></h4>								
						</div>
						<?php
						$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
						while($row_q = mysql_fetch_assoc($q)){

							$total_amount = 0.00;
							$debit_amount = 0;
							$credit_amount = 0;
							if($row_q['balance_side'] == 'Debit'){ //ledger opening balances
								$debit_amount += $row_q['balance']; 
							}
							else{ 
								$credit_amount += $row_q['balance']; 
							}

							$sq_p3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
							if($from_date!="" && $to_date!=""){
								$from_date = get_date_db($from_date);
								$to_date = get_date_db($to_date);
								$sq_p3 .=" and payment_date between '$from_date' and '$to_date'";	
							}
							if($financial_year_id != ""){
								$sq_p3 .=" and financial_year_id='$financial_year_id'";		
							} 
							if($branch_admin_id != "0"){
								$sq_p3 .=" and branch_admin_id='$branch_admin_id'";		
							} 
							$sq_opening_balance = mysql_query($sq_p3);
							while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
								if($row_balance['payment_side'] == 'Debit'){
									$debit_amount += $row_balance['payment_amount'];
								}else{
									$credit_amount += $row_balance['payment_amount'];
								}
							}
							$total_amount = $credit_amount - $debit_amount;
							if($row_q['ledger_id'] != '' && $total_amount != 0){
								?>
								<div class="part_entry main_block">
									<div class="col-md-2 no-pad text-right"></div>
									<div class="col-md-8 no-pad">
										<span>
											<em style="width: 20px;display: inline-block;"></em>
										</span>
										<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
									</div>
									<div class="col-md-2 no-pad text-right">
										<span class="part_entry_m_count" id="subgroup_amount"><?= number_format($total_amount,2) ?></span>
									</div>
								</div>
								<?php
								$total_sub_group_amount += $total_amount;
							}
						} ?>														
						<script>
							var subgroup_amount = cal_amount('<?= $total_sub_group_amount ?>');
							$('#subgroup_amount'+<?= $count ?>).html(subgroup_amount);
						</script>
						<?php
						$count++;
						$total_head_amount += $total_sub_group_amount; 
					}
				} ?>
				<script>
					var head_amount = cal_amount('<?= $total_head_amount ?>');
					$('#head_amount'+<?= $head_count ?>).html(head_amount);
					$('#span_total_sales').html(head_amount);
				</script>
				<?php
				$head_count++; 
				?>
			</div><!-- Quadrant End -->
			<div class="result_entry_block main_block">	 
				<!-- Loss Carried Down -->
				<div class="result_entry main_block" id="d1_block">
					<div class="col-md-8 no-pad">
						<span>
							<em style="width: 20px;display: inline-block;"></em>
						</span>
						<span class="result_entry_text">Gross Loss Carried Down</span>
					</div>
					<div class="col-md-2 no-pad text-right"></div>
					<div class="col-md-2 no-pad text-right">
						<span class="part_entry_m_count" id="d1_loss">0.00</span>
					</div>
				</div>
			</div>
			<!-- Total -->
			<div class="panel-footer main_block">
				<div class="row">
					<div class="col-md-8"><strong>Total :</strong></div>
					<div class="col-md-4 text-right"><strong id="span_total_sales">0.00</strong></div>
				</div>
			</div>

			<div class="result_entry_block main_block">	 
				<!--Profit Brought Down -->
				<div class="result_entry main_block" id="id3_block">
					<div class="col-md-8 no-pad">
						<span>
							<em style="width: 20px;display: inline-block;"></em>
						</span>
						<span class="result_entry_text">Gross Profit Brought Down</span>
					</div>
					<div class="col-md-2 no-pad text-right"></div>
					<div class="col-md-2 no-pad text-right">
						<span class="part_entry_m_count" id="id3_profit">0.00</span>
					</div>
				</div>
			</div>

		    <!-- second head (ID3) -->
		    <div class="quadrant main_block">
				<?php
				$count =1;
				$head_count =1;
				$row_head = mysql_fetch_assoc(mysql_query("select head_name from head_master where head_id ='11'"));			
				?>
				<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount_n<?= $head_count ?>"><?= $total_head_amount ?></span>
					</div>
				</div>
				<?php
				$sq_group = mysql_query("select group_id from group_master where head_id='11' order by group_id desc");				
				while($row_group = mysql_fetch_assoc($sq_group)){ //Groups

					$total_head_amount = 0;
					$sq_subgroup = mysql_query("select subgroup_id,subgroup_name from subgroup_master where group_id='$row_group[group_id]'");					
					while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups

						$total_sub_group_amount = 0;
						?>
						<!-- Part Heading -->
						<div class="part_heading main_block">
							<h4 class="main_block"><div class="col-md-6"><?= $row_subgroup['subgroup_name'] ?></div>
							<div class="col-md-4 no-pad text-right">
								<span class="list_heading_count" id="subgroup_amount_n<?= $count ?>"><?= '0.00' ?></span>
							</div></h4>								
						</div>
						<?php 
						$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
						while($row_q = mysql_fetch_assoc($q)){

							$total_amount = 0.00;
							$debit_amount = 0;
							$credit_amount = 0;
							if($row_q['balance_side'] == 'Debit'){ //ledger opening balances
								$debit_amount += $row_q['balance']; 
							}
							else{ 
								$credit_amount += $row_q['balance']; 
							}

							$sq_p3 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
							if($from_date!="" && $to_date!=""){
								$from_date = get_date_db($from_date);
								$to_date = get_date_db($to_date);
								$sq_p3 .=" and payment_date between '$from_date' and '$to_date'";	
							}
							if($financial_year_id != ""){
								$sq_p3 .=" and financial_year_id='$financial_year_id'";		
							} 
							if($branch_admin_id != "0"){
								$sq_p3 .=" and branch_admin_id='$branch_admin_id'";		
							} 
							$sq_opening_balance = mysql_query($sq_p3);
							while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
								if($row_balance['payment_side'] == 'Debit'){
									$debit_amount += $row_balance['payment_amount'];
								}else{
									$credit_amount += $row_balance['payment_amount'];
								}
							}
							$total_amount = $credit_amount - $debit_amount;
							if($row_q['ledger_id'] != '' && $total_amount != 0){
								?>
								<div class="part_entry main_block">
									<div class="col-md-2 no-pad text-right"></div>
									<div class="col-md-8 no-pad">
										<span>
											<em style="width: 20px;display: inline-block;"></em>
										</span>
										<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
									</div>
									<div class="col-md-2 no-pad text-right">
										<span class="part_entry_m_count" id="subgroup_amount"><?= number_format($total_amount,2) ?></span>
									</div>
								</div>
								<?php
								$total_sub_group_amount += $total_amount;
							}
						} ?>
						<script>
							var subgroup_amount = cal_amount('<?= $total_sub_group_amount ?>');
							$('#subgroup_amount_n'+<?= $count ?>).html(subgroup_amount);
						</script>  
						<?php
						$count++;
						$total_head_amount += $total_sub_group_amount;
					}
				} ?>													
				<script>
					var head_amount = cal_amount('<?= $total_head_amount ?>');
					$('#head_amount_n'+<?= $head_count ?>).html(head_amount);
					$('#span_total_sales2').html(head_amount);
				</script>
				<?php
				$head_count++;
				?>	
			</div>  <!-- Quadrant End -->
			<div class="result_entry_block main_block">	 
				<!--Net Loss Carried Down -->
				<div class="result_entry main_block" id="net_loss_block">
					<div class="col-md-8 no-pad">
						<span>
							<em style="width: 20px;display: inline-block;"></em>
						</span>
				        <span class="result_entry_text">Net Loss Carried Down</span>
					</div>
					<div class="col-md-2 no-pad text-right"></div>
					<div class="col-md-2 no-pad text-right">
						<span class="part_entry_m_count" id="net_loss">0.00</span>
					</div>
				</div>
			</div>
			<!-- Total -->
			<div class="panel-footer main_block">
				<div class="row">
					<div class="col-md-8"><strong>Total :</strong></div>
					<div class="col-md-4 text-right"><strong id="span_total_sales2">0.00</strong></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //////////////////////////////CREDIT END////////////////////////////////////-->
<script type="text/javascript">
function profit_and_loss_total_reflect()
{
	var base_url = $('#base_url').val();
	var branch_admin_id = $('#branch_admin_id').val();

	var today_date = new Date();
	var month = today_date.getMonth()+1;
	var day = today_date.getDate();
	var year = today_date.getFullYear();
	today_date = year+'-'+month+'-'+day;

	///////////////////GROSS Profit/Loss///////////////////
	var total_sales = $('#span_total_sales').html();
	var total_purchase = $('#span_total_sales_d1').html();
	var id3_total = $('#span_total_sales2').html();
	var id4_total = $('#span_total_sales_d2').html();
	var g_loss_amount = 0; var g_profit_amount = 0;

	if(parseFloat(total_sales)>=parseFloat(total_purchase)){
		//Gross Profit Carried Down
		var profit = parseFloat(total_sales) - parseFloat(total_purchase);
		$('#d1_block').addClass('hidden');
		profit = profit.toFixed(2);
		$('#d2_profit').text(profit);

		total_purchase = parseFloat(total_purchase) + parseFloat(profit);
		g_profit_amount = parseFloat(profit) + parseFloat(id3_total);
		g_profit_amount1 = g_profit_amount.toFixed(2);
		total_purchase = total_purchase.toFixed(2);
		$('#span_total_sales_d1').text(total_purchase);

		//Gross Profit Brought Down
		$('#id4_block').addClass('hidden');
		$('#id3_profit').text(profit);
		$('#span_total_sales2').text(g_profit_amount1);
	}
	else {
		//Gross Loss Carried Down
		var loss = parseFloat(total_purchase)-parseFloat(total_sales);
		$('#d2_block').addClass('hidden');
		loss = loss.toFixed(2);
		$('#d1_loss').text(loss);

		total_sales = parseFloat(total_sales) + parseFloat(loss);
		g_loss_amount = parseFloat(loss) + parseFloat(id4_total);
		total_sales = total_sales.toFixed(2);
		g_loss_amount = g_loss_amount.toFixed(2);
		$('#span_total_sales').text(total_sales);

		//Gross Loss Brought Down
		$('#id3_block').addClass('hidden');
		$('#id4_profit').text(loss);
		$('#span_total_sales_d2').text(g_loss_amount);
	}

	////////////////////NET Profit/Loss//////////////////////////
	var id3_total = $('#span_total_sales2').html();
	var id4_total = $('#span_total_sales_d2').html();
	if(parseFloat(id3_total)>=parseFloat(id4_total)){
		//Net Profit Carried Down
		var profit1 = parseFloat(id3_total) - parseFloat(id4_total);
		$('#net_loss_block').addClass('hidden');
		profit1 = profit1.toFixed(2);
		$('#net_profit').text(profit1);
		var total_purchase1 = parseFloat(id4_total) + parseFloat(profit1);
		total_purchase1 = total_purchase1.toFixed(2);
		$('#span_total_sales_d2').text(total_purchase1);

		var profit_loss = 'Credit';
		$.ajax({
			type: 'post',
			url: base_url+'controller/finance_master/reports/profit_loss_transfer.php',
			data:{ total_purchase1 : profit1,profit_loss : profit_loss,today_date : today_date,branch_admin_id : branch_admin_id },
			success: function(result){	
			}
		});
	}
	else {
		//Net Loss Carried Down
		var loss1 = parseFloat(id4_total) - parseFloat(id3_total);
		$('#net_profit_block').addClass('hidden');
		loss1 = loss1.toFixed(2);
		$('#net_loss').text(loss1);

		var total_purchase2 = parseFloat(id3_total) + parseFloat(loss1);
		total_purchase2 = total_purchase2.toFixed(2);
		$('#span_total_sales2').text(total_purchase2);
		var profit_loss = 'Debit';

		$.ajax({
			type: 'post',
			url: base_url+'controller/finance_master/reports/profit_loss_transfer.php',
			data:{ total_purchase1 : loss1,profit_loss : profit_loss,today_date : today_date,branch_admin_id : branch_admin_id },
			success: function(result){	
			}
		});
	}
}
profit_and_loss_total_reflect();
</script>