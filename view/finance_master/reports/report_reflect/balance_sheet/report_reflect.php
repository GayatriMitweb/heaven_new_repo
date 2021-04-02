<?php
include "../../../../../model/model.php";
?>
<script type="text/javascript">
function cal_amount(total_subgroup_amount){

	return parseFloat(total_subgroup_amount).toFixed(2);
}
//Get difference in opening balance
function get_diff(){
	var asset_total = $('#span_total_sales').html();
	var liab_total = $('#span_total_sales_d1').html();
	var new_total = 0;
	var diff_amount = 0;

	if(parseFloat(asset_total) > parseFloat(liab_total)){
		diff_amount = parseFloat(asset_total) - parseFloat(liab_total);
		document.getElementById('liab_diff_div').style.display = 'block';
		document.getElementById('asset_diff_div').style.display = 'none';
		$('#liab_difference').html(diff_amount.toFixed(2));
		new_total = parseFloat(liab_total) + parseFloat(diff_amount);
		$('#span_total_sales_d1').html(new_total.toFixed(2));
	}
	else if(parseFloat(asset_total) < parseFloat(liab_total)){
		diff_amount = parseFloat(liab_total) - parseFloat(asset_total);
		document.getElementById('liab_diff_div').style.display = 'none';
		document.getElementById('asset_diff_div').style.display = 'block';
		$('#asset_difference').html(diff_amount.toFixed(2));
		new_total = parseFloat(asset_total) + parseFloat(diff_amount);
		$('#span_total_sales').html(new_total.toFixed(2));
	}
	else{
		document.getElementById('asset_diff_div').style.display = 'none';
		document.getElementById('liab_diff_div').style.display = 'none';
	}
}
</script>
<?php
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];
$sfinancial_year_id = $_SESSION['financial_year_id'];
$sbranch_admin_id = $_SESSION['branch_admin_id'];
?>

<div class="row mg_tp_20">
<!-- //////////////////////////////////////////////////////CREDIT START//////////////////////////////////////////////////////////////////////////////////////  -->
	<div class="col-md-6 pl_sheet">
		<div class="panel panel-default main_block">
			<div class="panel-heading main_block">
				<div class="col-md-10 no-pad">
					<strong>Liabilities</strong>
				</div>
				<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
			</div>
			<div class="quadrant main_block">
				<!-- List Heading -->
				<?php
				$count_d =1;
				$head_count_d =1;
				$sq_head = mysql_query("select head_id,head_name from head_master where head_id in('1','8','3','6')");			
				while($row_head = mysql_fetch_assoc($sq_head)){//2 Heads(D2)
					?>
					<div class="list_heading main_block">
						<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
						<div class="col-md-4 no-pad text-right">
							<span class="list_heading_count" id="head_amount_d<?= $head_count_d ?>"><?= $total_head_amount_d ?></span>
						</div>
					</div>
				<?php 
				$sq_group = mysql_query("select group_id from group_master where head_id='$row_head[head_id]' order by group_id desc");
				while($row_group = mysql_fetch_assoc($sq_group)){ //Groups
					
					$total_head_amount_d = 0;
					$sq_subgroup = mysql_query("select subgroup_name,subgroup_id from subgroup_master where group_id='$row_group[group_id]'");					
					while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups

						$total_sub_group_amount_d = 0;
						?>
						<!-- Part Heading -->
						<div class="part_heading main_block">
							<h4 class="main_block"><div class="col-md-6 col-md-offset-1 no-pad"><?= $row_subgroup['subgroup_name'] ?></div>
							<div class="col-md-4 no-pad text-right">
								<span class="list_heading_count" id="subgroup_amount_d<?= $count_d ?>"><?= '0.00' ?></span>
							</div></h4>
						</div>
						<?php
						$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
						while($row_q = mysql_fetch_assoc($q)){

							$total_amount = 0;
							$debit_amount = 0;	 $credit_amount = 0;
							$debit_amount = ($row_q['balance_side']=='Debit') ? $row_q['balance'] : '0';
							$credit_amount = ($row_q['balance_side']=='Credit') ? $row_q['balance'] : '0';						
							$q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
							if($from_date!="" && $to_date!=""){
								$from_date = get_date_db($from_date);
								$to_date = get_date_db($to_date);
								$q1 .=" and payment_date between '$from_date' and '$to_date'";	
							}
							if($financial_year_id != ""){
								$q1 .=" and financial_year_id<='$financial_year_id'";
							} 	
							if($branch_admin_id != "0"){
								$q1 .=" and branch_admin_id='$branch_admin_id'";
							}
							$sq_opening_balance = mysql_query($q1);	
							while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
								if($row_balance['payment_side'] == 'Debit'){
									$debit_amount += $row_balance['payment_amount'];
								}else{
									$credit_amount += $row_balance['payment_amount'];
								}
							}
							$total_amount = $credit_amount - $debit_amount;
							if($total_amount != ''){
							?>			
							<div class="part_entry main_block">
								<div class="col-md-2 no-pad text-right"></div>
								<div class="col-md-8 no-pad">
									<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
								</div>
								<div class="col-md-2 no-pad text-right">
									<span class="part_entry_m_count" id="subgroup_amount"><?= number_format($total_amount,2) ?></span>
								</div>
							</div>
							<?php
							if($row_q['ledger_id'] == '165'){
								$q1 = "select * from finance_transaction_master where gl_id='165'";
								if($from_date!="" && $to_date!=""){
									$from_date = get_date_db($from_date);
									$to_date = get_date_db($to_date);
									$q1 .=" and payment_date between '$from_date' and '$to_date'";	
								}
								$q1 .=" and financial_year_id='$sfinancial_year_id'";
								$q1 .=" and branch_admin_id='$sbranch_admin_id'";
								$sq_opening_balance = mysql_query($q1);	
								while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
									if($row_balance['payment_side'] == 'Debit'){ $total_sub_group_amount_d += $total_amount;  }
									if($row_balance['payment_side'] == 'Credit'){ $total_sub_group_amount_d += $total_amount;   } 
								}
							}
							else{ $total_sub_group_amount_d += $total_amount;  }
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
				<?php $head_count_d++; 
			} ?>
		</div>  <!-- quadrant end -->
					
			<!-- Liabilities Difference in opening balance -->
			<div class="result_entry_block main_block">
				<div class="result_entry main_block" id="liab_diff_div">
					<div class="col-md-8 no-pad">
						<span>
							<em style="width: 20px;display: inline-block;"></em>
						</span>
			        	<span class="result_entry_text">Difference in Opening Balance :</span>
					</div>
					<div class="col-md-2 no-pad text-right"></div>
					<div class="col-md-2 no-pad text-right">
						<span class="part_entry_m_count" id="liab_difference">0.00</span>
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
		</div>
	</div>
<!-- //////////////////////////////////////////////////////CREDIT END////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- ////////////////////////////////////////////////////DEBIT START////////////////////////////////////////////////////////////////////////////////////////// -->
	<div class="col-md-6 pl_sheet">
		<div class="panel panel-default main_block">
			<div class="panel-heading main_block">
				<div class="col-md-10 no-pad">
					<strong>ASSETS</strong>
				</div>
				<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
			</div>
			<div class="quadrant main_block">
			<?php
			$count =1;
			$head_count =1;
			$sq_head = mysql_query("select head_id,head_name from head_master where head_id in('2','7') order by head_id desc");
			
			while($row_head = mysql_fetch_assoc($sq_head)){ //1st Head(D1)
			?>
				<!-- List Heading -->
				<div class="list_heading main_block">
					<div class="col-md-8 no-pad"><h4><?= $row_head['head_name'] ?></h4></div>
					<div class="col-md-4 no-pad text-right">
						<span class="list_heading_count" id="head_amount<?= $head_count ?>"><?= $total_head_amount ?></span>
					</div>
				</div>
				<?php
				$sq_group = mysql_query("select group_id from group_master where head_id='$row_head[head_id]' order by group_id desc");
				$total_head_amount = 0;
				while($row_group = mysql_fetch_assoc($sq_group)){ //Groups

			    	$sq_subgroup = mysql_query("select subgroup_name,subgroup_id from subgroup_master where group_id='$row_group[group_id]'");
			      	while($row_subgroup = mysql_fetch_assoc($sq_subgroup)){ //Sub groups 	

			        	$total_sub_group_amount = 0;
			    		?>
						<!-- Part Heading -->
						<div class="part_heading main_block">
							<h4 class="main_block"><div class="col-md-6 col-md-offset-1 no-pad"><?= $row_subgroup['subgroup_name'] ?></div>
							<div class="col-md-4 no-pad text-right">
								<span class="list_heading_count" id="subgroup_amount<?= $count ?>"><?= '0.00' ?></span>
							</div></h4>
						</div>
						<?php
						$q = mysql_query("select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'");
						while($row_q = mysql_fetch_assoc($q))
						{
							$total_amount = 0;	
							$debit_amount = 0;	 $credit_amount = 0;
							$debit_amount = ($row_q['balance_side']=='Debit') ? $row_q['balance'] : '0';
							$credit_amount = ($row_q['balance_side']=='Credit') ? $row_q['balance'] : '0';
							$q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
							if($from_date!="" && $to_date!=""){
								$from_date = get_date_db($from_date);
								$to_date = get_date_db($to_date);
								$q1 .=" and payment_date between '$from_date' and '$to_date'";	
							}
							if($financial_year_id != ""){
								$q1 .=" and financial_year_id<='$financial_year_id'";
							} 	
							if($branch_admin_id != "0"){
								$q1 .=" and branch_admin_id='$branch_admin_id'";
							} 	

							$sq_opening_balance = mysql_query($q1);	
							while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
								if($row_balance['payment_side'] == 'Debit'){
									$debit_amount += $row_balance['payment_amount'];
								}else{
									$credit_amount += $row_balance['payment_amount'];
								}
							}
							$total_amount = $debit_amount - $credit_amount;
							if($total_amount != ''){
							?>
								<div class="part_entry main_block">
									<div class="col-md-2 no-pad text-right"></div>
									<div class="col-md-8 no-pad">
										<span class="part_entry_text"><?= $row_q['ledger_name'] ?></span>
									</div>
									<div class="col-md-2 no-pad text-right">
										<span class="part_entry_m_count" id="subgroup_amount"><?= number_format($total_amount,2) ?></span>
									</div>
								</div>
							<?php  $total_sub_group_amount += $total_amount; 
							}
						}
						$total_head_amount += $total_sub_group_amount;?>
						<script>
							var subgroup_amount = cal_amount('<?= $total_sub_group_amount ?>');
							$('#subgroup_amount'+<?= $count ?>).html(subgroup_amount);	
						</script>  
						<?php
						$count++;
					}
				} 	 ?>
				<script>
					var head_amount = cal_amount('<?= $total_head_amount ?>');
					$('#head_amount'+<?= $head_count ?>).html(head_amount);
					var tmp_head_amount_d2 = $('#span_total_sales').html();
					var tmp_head_amount_d = parseFloat(head_amount) + parseFloat(tmp_head_amount_d2);
					$('#span_total_sales').html(tmp_head_amount_d.toFixed(2));
				</script>
				<?php
				$head_count++; 
			} ?>
			</div>  <!-- Quadrant End -->
			
			<!-- Asset Difference in opening balance -->
			<div class="result_entry_block main_block">
				<div class="result_entry main_block" id="asset_diff_div">
					<div class="col-md-8 no-pad">
							<span>
								<em style="width: 20px;display: inline-block;"></em>
							</span>
			        <span class="result_entry_text">Difference in Opening Balance :</span>
					</div>
					<div class="col-md-2 no-pad text-right"></div>
					<div class="col-md-2 no-pad text-right">
						<span class="part_entry_m_count" id="asset_difference">0.00</span>
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
		</div>
	</div>
	<script>
		get_diff();
	</script>
<!-- //////////////////////////////////////////////////////DEBIT END////////////////////////////////////////////////////////////////////////-->
</div>

