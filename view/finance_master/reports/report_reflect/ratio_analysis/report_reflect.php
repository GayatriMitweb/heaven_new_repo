<?php
include "../../../../../model/model.php";

//Get Gross / Net amount from Profit and loss account
include "get_gross_net_amount.php";

$from_date = $_POST['from_date']; 
$financial_year_id = $_POST['financial_year_id']; 
$branch_admin_id = $_POST['branch_admin_id']; 

//Working Capital = Current Assets - Current Liabilities
$working_capital = 0;
//Get Current Assets Total
$row_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='2'"));
$total_head_amount_a = 0;
$sq_group = mysql_query("select * from group_master where head_id='$row_head[head_id]' order by group_id desc");
 //Groups
while($row_group = mysql_fetch_assoc($sq_group))
  { 		
  	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
     //Sub groups
  	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
     { 	
     	$total_sub_group_amount = 0;
	    $sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'"; 
	    $q = mysql_query($sq_finance);
        while($row_q = mysql_fetch_assoc($q))
        {
        	$total_amount = 0;	
        	$q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
			if($from_date!=""){
				$from_date = get_date_db($from_date);
				$q2 .=" and payment_date between <='$from_date'";	
			}
			if($financial_year_id!=""){
				$q2 .=" and financial_year_id = '$financial_year_id'";	
			}	
			if($branch_admin_id!=""){
				$q2 .=" and branch_admin_id = '$branch_admin_id'";	
			}		
        	$sq_opening_balance = mysql_query($q2);
        	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        		$total_amount += $row_balance['payment_amount'];
        	}
        	$total_sub_group_amount += $total_amount; 		
		}					
   	$total_head_amount_a += $total_sub_group_amount; 	 	
	  } 				    
}
//Get Current Liabilities Total
$row_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='3'"));
$total_head_amount_l = 0;
$sq_group = mysql_query("select * from group_master where head_id='$row_head[head_id]' order by group_id desc");
 //Groups
while($row_group = mysql_fetch_assoc($sq_group))
  { 		
  	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
     //Sub groups
  	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
     { 	
     	$total_sub_group_amount = 0;
	    $sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'"; 
	    $q = mysql_query($sq_finance);
        while($row_q = mysql_fetch_assoc($q))
        {
        	$total_amount = 0;	
        	$q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
			if($from_date!=""){
				$from_date = get_date_db($from_date);
				$q2 .=" and payment_date between <='$from_date'";	
			}	
			if($financial_year_id!=""){
				$q2 .=" and financial_year_id = '$financial_year_id'";	
			}	
			if($branch_admin_id!=""){
				$q2 .=" and branch_admin_id = '$branch_admin_id'";	
			}	
        	$sq_opening_balance = mysql_query($q2);
        	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        		$total_amount += $row_balance['payment_amount'];
        	}
        	$total_sub_group_amount += $total_amount; 		
		}					
   	$total_head_amount_l += $total_sub_group_amount; 	 	
	  } 				    
}
$working_capital = $total_head_amount_a - $total_head_amount_l;

//Debt/Equity Ratio = loans liabilities : capital 
//Get Capital Total
$row_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='1'"));
$total_capital_amount = 0;
$sq_group = mysql_query("select * from group_master where head_id='$row_head[head_id]' order by group_id desc");
 //Groups
while($row_group = mysql_fetch_assoc($sq_group))
  { 		
  	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
     //Sub groups
  	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
     { 	
     	$total_sub_group_amount = 0;
	    $sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'"; 
	    $q = mysql_query($sq_finance);
        while($row_q = mysql_fetch_assoc($q))
        {
        	$total_amount = 0;	
        	$q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
			if($from_date!=""){
				$from_date = get_date_db($from_date);
				$q2 .=" and payment_date between <='$from_date'";	
			}	
        	$sq_opening_balance = mysql_query($q2);
        	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        		$total_amount += $row_balance['payment_amount'];
        	}
        	$total_sub_group_amount += $total_amount; 		
		}					
   	$total_capital_amount += $total_sub_group_amount; 	 	
	  } 				    
}
//Loans liabilities
$sq_group = mysql_query("select * from group_master where group_id in('16','10','21')");
$total_loan_amount = 0;
 //Groups
while($row_group = mysql_fetch_assoc($sq_group))
  { 		
  	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
     //Sub groups
  	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
     { 	
     	$total_sub_group_amount = 0;
	    $sq_finance = "select * from ledger_master where group_sub_id='$row_subgroup[subgroup_id]'"; 
	    $q = mysql_query($sq_finance);
        while($row_q = mysql_fetch_assoc($q))
        {
        	$total_amount = 0;	
        	$q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit'";
			if($from_date!=""){
				$from_date = get_date_db($from_date);
				$q2 .=" and payment_date between <='$from_date'";	
			}	
			if($financial_year_id!=""){
				$q2 .=" and financial_year_id = '$financial_year_id'";	
			}	
			if($branch_admin_id!=""){
				$q2 .=" and branch_admin_id = '$branch_admin_id'";	
			}	
        	$sq_opening_balance = mysql_query($q2);
        	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        		$total_amount += $row_balance['payment_amount'];
        	}
        	$total_sub_group_amount += $total_amount; 		
		}					
   	$total_loan_amount += $total_sub_group_amount; 	 	
	  } 				    
}
		
//Working Capital Turnover = Revenue from operations Total(sales) / working capital
//Get Revenue from operations Total
$sq_group = mysql_query("select * from group_master where head_id='13' order by group_id desc");
 //Groups
 while($row_group = mysql_fetch_assoc($sq_group))
      { 
      	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
         
        $total_sale_amount = 0;
         //Sub groups
      	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
         { 	

         	$total_sub_group_amount = 0;
      	   ?>
			<?php 		
			    $sq_finance1 = "select * from finance_transaction_master where module_name = 'Journal Entry'";				 
			    
			    if($from_date!=""){
					$from_date = get_date_db($from_date);
					$sq_finance1 .=" and payment_date <= '$from_date'";	
				}
				if($financial_year_id!=""){
					$sq_finance1 .=" and financial_year_id = '$financial_year_id'";	
				}	
				if($branch_admin_id!=""){
					$sq_finance1 .=" and branch_admin_id = '$branch_admin_id'";	
				}	
				$sq_finance1 .= ' group by gl_id';
				$q = mysql_query($sq_finance1);
	            while($row_q = mysql_fetch_assoc($q))
	            {		
	            	$total_amount = 0.00;			
		          	$q1 = "select * from ledger_master where ledger_id='$row_q[gl_id]' and group_sub_id='$row_subgroup[subgroup_id]'";
				    $sq_ledger = mysql_fetch_assoc(mysql_query($q1));
				    $sq_p1 = "select * from finance_transaction_master where gl_id='$sq_ledger[ledger_id]' and payment_side='Debit'";
					if($financial_year_id!=""){
						$sq_p1 .=" and financial_year_id = '$financial_year_id'";	
					}	
					if($branch_admin_id!=""){
						$sq_p1 .=" and branch_admin_id = '$branch_admin_id'";	
					}
				    $sq_opening_balance = mysql_query($sq_p1);
	            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
	            		$total_amount += $row_balance['payment_amount'];
	            	}
				   	if($sq_ledger['ledger_id'] != ''){
					  	
						if($row_subgroup['subgroup_id'] == '89'){
							$total_sub_group_amount -= $total_amount;	
						}else{
							$total_sub_group_amount += $total_amount;			
						}					
					}
				}  $total_sale_amount += $total_sub_group_amount; 
		    }	
		    }	
$working_tun_over =  $total_sale_amount / $working_capital;

//Operating cost % = ((Purchase head+Other direct expense head)/sales*100)
$tempq = "select * from head_master where head_id in('12','9')";
$sq_head = mysql_query($tempq);
while($row_head = mysql_fetch_assoc($sq_head))
{		
 $sq_group = mysql_query("select * from group_master where head_id='$row_head[head_id]' order by group_id desc");
 //Groups
 while($row_group = mysql_fetch_assoc($sq_group))
      { 
      	$sq_subgroup = mysql_query("select * from subgroup_master where group_id='$row_group[group_id]'");
         
        $total_operating_amount = 0;
         //Sub groups
      	 while($row_subgroup = mysql_fetch_assoc($sq_subgroup))
         { 	

         	$total_sub_group_amount_d = 0;			
			$sq_finance = "select * from finance_transaction_master where module_name = 'Journal Entry' ";

			if($from_date!="" && $to_date!=""){
				$from_date = get_date_db($from_date);
				$to_date = get_date_db($to_date);
				$sq_finance .=" and payment_date between '$from_date' and '$to_date'";	
			}
			if($financial_year_id != ""){
				$sq_finance .=" and financial_year_id='$financial_year_id'";		
			} 	
			if($branch_admin_id != ""){
				$sq_finance .=" and branch_admin_id='$branch_admin_id'";		
			} 
		  	$sq_finance .= ' group by gl_id';			 
		    $q = mysql_query($sq_finance);
            while($row_q = mysql_fetch_assoc($q))
            {					
		          	$total_amount = 0.00;			
		          	$q1 = "select * from ledger_master where ledger_id='$row_q[gl_id]' and group_sub_id='$row_subgroup[subgroup_id]'";
				    $sq_ledger = mysql_fetch_assoc(mysql_query($q1));
				    $sq_p2 = "select * from finance_transaction_master where gl_id='$sq_ledger[ledger_id]' and payment_side='Credit'";
					if($financial_year_id != ""){
						$sq_p2 .=" and financial_year_id='$financial_year_id'";		
					} 	
					if($branch_admin_id != ""){
						$sq_p2 .=" and branch_admin_id='$branch_admin_id'";		
					} 

				    $sq_opening_balance = mysql_query($sq_p2);
	            	while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
	            		$total_amount += $row_balance['payment_amount'];
	            	}
				   	if($sq_ledger['ledger_id'] != ''){					  	
						if($row_subgroup['subgroup_id'] == '79'){
							$total_sub_group_amount_d -= $total_amount;	
						}else{
							$total_sub_group_amount_d += $total_amount;			
						}					
					}
				} 
		   $total_operating_amount += $total_sub_group_amount_d; }		   
	    } 
	}
	 $operating_cost_per = ($total_operating_amount/$total_sale_amount)*100;

//Payment Performance of debotrs
$total_credit_sale = 0;
$opening_balance = 0; $payment_perfomance = 0;
$total_amount1 = 0;	
	
$sq_finance = "select * from ledger_master where group_sub_id='20'"; 
$q = mysql_query($sq_finance);
while($row_q = mysql_fetch_assoc($q))
{
	$debit_amount = 0;	 $credit_amount = 0;
	$q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]'";
	if($from_date!="" && $to_date!=""){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$q1 .=" and payment_date between '$from_date' and '$to_date'";	
	}
	if($financial_year_id != ""){
		$q1 .=" and financial_year_id='$financial_year_id'";		
	} 	
	if($branch_admin_id != ""){
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
	if($debit_amount > $credit_amount){
		$total_amount1 += $debit_amount - $credit_amount + $row_q['balance'];
	}else{
		$total_amount1 += $credit_amount - $debit_amount + $row_q['balance'];
	}

    $opening_balance += $row_q['balance']; 
	$total_credit_sale = $total_credit_sale + $debit_amount + $row_q['balance']; 	
	$average_debtor = ($opening_balance + $total_amount1)/2;
	$payment_perfomance = ($total_credit_sale / $average_debtor)*365;
}
?>
<span class="part_entry_m_count hidden" id="sales_turn_over"><?= $total_sale_amount ?></span>
<span class="part_entry_m_count hidden" id="capital_amount"><?= $total_capital_amount ?></span>
<span class="part_entry_m_count hidden" id="working_capital_amount"><?= $working_capital ?></span>
<span class="part_entry_m_count hidden" id="gross_amount">0.00</span>
<span class="part_entry_m_count hidden" id="net_amount">0.00</span>

<script type="text/javascript">
function get_gross_net_amount()
{
	var sales_turn_over = $('#sales_turn_over').html();
	var capital_amount = $('#capital_amount').html();
	var working_capital_amount = $('#working_capital_amount').html();
	var gross_profit = $('#d2_profit').html();
	var gross_loss = $('#d1_loss').html();
	var net_profit = $('#net_profit').html();
	var net_loss = $('#net_loss').html();
	//Gross Profit %
	if(parseFloat(gross_profit)>0){
		var gros_per = (parseFloat(gross_profit) / parseFloat(sales_turn_over)*100);
	}else{
		gross_loss =  parseFloat(0) - parseFloat(gross_loss);
		var gros_per = (parseFloat(gross_loss) / parseFloat(sales_turn_over)*100);
	}
	gros_per = parseFloat(gros_per);
	$('#gross_amount_new').html(gros_per.toFixed(2));

	//Net Profit %
	if(parseFloat(net_profit)>0){
		var net_per = (parseFloat(net_profit) / parseFloat(sales_turn_over)*100);
		var return_invest_amount = (parseFloat(net_profit) / parseFloat(capital_amount))+parseFloat(net_profit);
        var return_working_capital = (parseFloat(net_profit) / parseFloat(working_capital_amount));
	}else{
		net_loss =  parseFloat(0) - parseFloat(net_loss);
		var net_per = (parseFloat(net_loss) / parseFloat(sales_turn_over)*100);
		var return_invest_amount = (parseFloat(net_loss) / parseFloat(capital_amount))+parseFloat(net_loss);
        var return_working_capital = (parseFloat(net_loss) / parseFloat(working_capital_amount));
	}
	net_per = parseFloat(net_per);
	$('#subgroup_amount5').html(net_per.toFixed(2));
	$('#subgroup_amount8').html(return_invest_amount.toFixed(2));

	return_working_capital = parseFloat(return_working_capital);
	$('#subgroup_amount9').html(return_working_capital.toFixed(2));
}
get_gross_net_amount();
</script>

<div class="row mg_tp_20">
<div class="col-md-6 col-md-offset-3 pl_sheet">
	<div class="panel panel-default main_block">
		<div class="panel-heading main_block">
			<div class="col-md-10 no-pad">
				<strong>Particulars</strong>
			</div>
			<div class="col-md-2 no-pad text-right"><strong>Amount</strong></div>
		</div>
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Working Capital' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount1"><?= number_format($working_capital,2) ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
		<?php
		//Current Ratio = current_asset : cusrrent_liabilities
		if($total_head_amount_a > $total_head_amount_l){
			$current_asset = $total_head_amount_a / $total_head_amount_l;
			$current_liabilities = $total_head_amount_l / $total_head_amount_l;
		}
		else{
			$current_asset = $total_head_amount_l / $total_head_amount_a;
			$current_liabilities = $total_head_amount_a / $total_head_amount_l;
		}
		?>
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Current Ratio' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount2"><?= ceil($current_asset).' : '.ceil($current_liabilities)  ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
		<?php		
		if($total_loan_amount > $total_capital_amount){
			$current_laons = $total_loan_amount / $total_capital_amount;
			$current_capital = $total_capital_amount / $total_capital_amount;
		}
		else{
			$current_laons = $total_capital_amount / $total_loan_amount;
			$current_capital = $total_loan_amount / $total_capital_amount;
		} ?>
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Debt/Equity Ratio' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount3"><?= ceil($current_laons).' : '.ceil($current_capital)  ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Gross Profit %' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
				<span class="part_entry_m_count" id="gross_amount_new"></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Net Profit%' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount5"></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Operating Cost %' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount6"><?= number_format($operating_cost_per,2) ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Payment Performance of Debtors' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount7"><?= number_format($payment_perfomance,2) ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Return on Investment %' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount8"></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Return on Working Capital %' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount9"></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
	 	<div class="part_entry main_block">
			<div class="col-md-8 no-pad">
	        	<span class="part_entry_text"><?= 'Working Capital Turnover' ?></span>
	        </div>
	        <div class="col-md-2 no-pad text-right"></div>
	        <div class="col-md-2 no-pad text-right">
	        	<span class="part_entry_m_count" id="subgroup_amount10"><?= number_format($working_tun_over,2) ?></span>
	        </div>
		</div>
		<hr class="no-marg main_block">
    </div>
</div>
</div>