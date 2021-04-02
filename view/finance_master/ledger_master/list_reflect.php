<?php
include "../../../model/model.php";

$group_id = $_POST['group_id'];
$financial_year_id = $_POST['financial_year_id'];
$branch_admin_id = $_POST['branch_admin_id'];
$active_filter = $_POST['active_filter'];
$chk_balance = $_POST['chk_balance'];

$array_s = array();
$temp_arr = array();

$query = "select * from ledger_master where 1 ";
if($group_id!=""){
	$query .= " and group_sub_id='$group_id'";	
}
if($active_filter!=""){
	$query .= " and status='$active_filter'";	
}
$count = 0;
$sq_gl = mysql_query($query);
while($row_gl = mysql_fetch_assoc($sq_gl)){
	$credit = 0;
	$debit = 0;
	$balance = 0;
	
	$sq_sl = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$row_gl[group_sub_id]'"));

	$q1 = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Credit' and gl_id='$row_gl[ledger_id]'";
	if($branch_admin_id != '0'){
		$q1 .= " and branch_admin_id='$branch_admin_id'";
	}	

	$sq_trans_credit = mysql_fetch_assoc(mysql_query($q1));
	$credit += ($sq_trans_credit['sum']=="") ? 0 : $sq_trans_credit['sum'];
	
	$q2 = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Debit' and gl_id='$row_gl[ledger_id]'";
	if($branch_admin_id != '0'){
		$q2 .= " and branch_admin_id='$branch_admin_id'";
	}	

	$sq_trans_debit = mysql_fetch_assoc(mysql_query($q2));
	$debit += ($sq_trans_debit['sum']=="") ? 0 : $sq_trans_debit['sum'];			

	$bg = ($row_gl['status'] != 'Active' && $row_gl['status'] != '') ? 'danger':'';
	$balance = $balance + $row_gl['balance'];
	if($debit>$credit){
		$balance = $balance + $debit - $credit;
		$side_t1='(Dr)';
	}
	else{
		$balance = $balance + $credit - $debit;
		$side_t1='(Cr)';
	}
	if($row_gl['balance_side'] == 'Credit') $balance_side = '(Cr)';
	else if($row_gl['balance_side'] == 'Debit') $balance_side = '(Dr)';
	else $balance_side = '';
	
	$alias_name = ($row_gl['alias'] != '') ? '('.$row_gl['alias'].')' :'';
	$temp_arr = array('data'=>array(
		$row_gl['ledger_id'],
		$row_gl['ledger_name'].$alias_name,
		number_format($row_gl['balance'],2).$balance_side,
		$sq_sl['subgroup_name'],
		number_format($balance,2).$side_t1,
		'<a href="../finance_master/ledger_master/view/index.php?ledger_id='.$row_gl['ledger_id'].'" target="_BLANK" class="btn btn-info btn-sm" title="View Ledger History"><i class="fa fa-eye"></i></a>
		<button class="btn btn-info btn-sm" onclick="update_modal('. $row_gl['ledger_id'] .')" title="Edit Details" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i></button>'),"bg"=>$bg
	);
	if($chk_balance == 0){
		if($balance > 0)
		array_push($array_s,$temp_arr);
	}else{
		array_push($array_s,$temp_arr);
	}
	
}
echo json_encode($array_s);
?>