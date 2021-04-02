<?php
include_once("../../../model/model.php");
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$array_s = array();
$temp_arr = array();
$footer_data = array();
$financial_year_id = $_SESSION['financial_year_id'];
$query = "select * from journal_entry_master where financial_year_id='$financial_year_id' ";
if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and entry_date between '$from_date' and '$to_date' ";
}
	$count = 0;
	$total_dr = 0; $total_cr = 0;

	$sq_journal = mysql_query($query);
	while($row_journal = mysql_fetch_assoc($sq_journal)){
		$date = $row_journal['entry_date'];
		$yr = explode("-", $date);
		$year =$yr[0];
		$sq_journal_entry = mysql_fetch_assoc(mysql_query("select * from journal_entry_accounts where entry_id='$row_journal[entry_id]' limit 1"));	
		$bg = " ";	
		$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$sq_journal_entry[ledger_id]'"));	
		$sq_journal_debit = mysql_fetch_assoc(mysql_query("select sum(amount) as amount from journal_entry_accounts where type = 'Debit' and entry_id='$row_journal[entry_id]'"));
		$total_cr += $sq_journal_debit['amount'];	
		$temp_arr = array (
			(int)(++$count),
			 get_jv_entry_id($row_journal['entry_id']),
			 get_date_user($row_journal['entry_date']),
			 $sq_ledger['ledger_name'],
			$sq_journal_entry['type'],
			$row_journal['narration'],
			number_format($sq_journal_debit['amount'],2),
			'<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="entry_display_modal('.$row_journal[entry_id].')" title="View Journal"><i class="fa fa-eye"></i></button>
			<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="update_modal('.$row_journal[entry_id] .')" title="Edit Journal"><i class="fa fa-pencil-square-o"></i></button>'
		);
		array_push($array_s,$temp_arr); 
}
$footer_data = array("footer_data" => array(
	'total_footers' => 2,
	'foot0' => "Total Debit : ".number_format($total_cr,2),
	'col0' => 7,
	'foot1' => "",
	'col1' => 1,
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>