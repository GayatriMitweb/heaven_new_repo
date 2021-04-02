<?php include "../../../../model/model.php"; ?>
<?php
require("../../../../classes/convert_amount_to_word.php");
$today_date=$_GET['receipt_generate_date'];

$_SESSION['generated_by'] = "seperate_voucher";

$tourwise_id=$_GET['booking_id'];

$tourwise_details = mysql_fetch_assoc(mysql_query("select *  from tourwise_traveler_details where id='$tourwise_id' "));

$tour_id=$tourwise_details['tour_id'];
$tour_group_id=$tourwise_details['tour_group_id'];
$traveler_group_id=$tourwise_details['traveler_group_id'];

$tour_name1 = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id= '$tour_id'"));
$tour_name = $tour_name1['tour_name'];

$tour_group1 = mysql_fetch_assoc(mysql_query("select from_date, to_date from tour_groups where group_id= '$tour_group_id'"));
$from_date = date("d-m-Y", strtotime($tour_group1['from_date']));
$to_date = date("d-m-Y", strtotime($tour_group1['to_date']));

//$today_date = date('d-m-Y');

define('FPDF_FONTPATH','../../../../classes/fpdf/font/');
//require('../../classes/fpdf/fpdf.php');
require('../../../../classes/mc_table.php');

$pdf=new PDF_MC_Table();

$pdf->SetFont('Arial','',10);


include_once('train_voucher.php');
include_once('plane_voucher.php');



$pdf->Output();
?>