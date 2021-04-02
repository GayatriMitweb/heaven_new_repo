<?php include "../../../../../model/model.php"; ?>
<?php
require("../../../../../classes/convert_amount_to_word.php");
$today_date=$_GET['receipt_generate_date'];

$_SESSION['generated_by'] = "seperate_voucher";

$booking_id=$_GET['booking_id'];

$booking_details = mysql_fetch_assoc(mysql_query("select *  from package_tour_booking_master where booking_id='$booking_id' "));

$from_date = date("d-m-Y", strtotime($booking_details['from_date']));
$to_date = date("d-m-Y", strtotime($booking_details['to_date']));

//$today_date = date('d-m-Y');

define('FPDF_FONTPATH','../../../../../classes/fpdf/font/');
//require('../../classes/fpdf/fpdf.php');
require('../../../../../classes/mc_table.php');

$pdf=new PDF_MC_Table();

$pdf->SetFont('Arial','',10);


include_once('train_voucher.php');
include_once('plane_voucher.php');





$pdf->Output();
?>