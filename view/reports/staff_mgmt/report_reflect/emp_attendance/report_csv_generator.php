<?php 
$csv_report_title = $_POST['csv_report_title'];
$csv_table_title_row_arr = $_POST['csv_table_title_row_arr'];
$csv_table_row_arr = $_POST['csv_table_row_arr'];
$csv_table_footer_row_arr = $_POST['csv_table_footer_row_arr'];

$csv_table_title_row_arr = json_decode($csv_table_title_row_arr);
$csv_table_row_arr = json_decode($csv_table_row_arr);
$csv_table_footer_row_arr = json_decode($csv_table_footer_row_arr);

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$csv_report_title-Report(".date('d-m-Y').").csv");
$fp = fopen('php://output', 'w');

foreach($csv_table_title_row_arr as $row){
	fputcsv($fp, $row);
}
foreach($csv_table_row_arr as $row){
	fputcsv($fp, $row);
}
foreach($csv_table_footer_row_arr as $row){
	fputcsv($fp, $row);
}
fclose($fp);
exit;
?>