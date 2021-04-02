<?php
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

//This function generates the background color
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

//This array sets the font atrributes
$header_style_Array = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 12,
        'name'  => 'Verdana'
    ));
$table_header_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 11,
        'name'  => 'Verdana'
    ));
$content_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 9,
        'name'  => 'Verdana'
    ));

//This is border array
$borderArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

//////////////////////////****************Content start**************////////////////////////////////

$estimate_id = $_GET['estimate_id'];
$from_date = $_GET['payment_from_date'];
$to_date = $_GET['payment_to_date'];

$invoice_id = ($estimate_id!="") ? get_vendor_estimate_id($estimate_id): "";

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Supplier Refund')
            ->setCellValue('B3', 'Supplier Estimate ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'From-To-Date')
            ->setCellValue('C4', $date_str);
             
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);   

$query = "select * from vendor_refund_master where 1 ";
if($estimate_id!="")
{
  $query .= " and estimate_id='$estimate_id'";
}
if($from_date!='' && $to_date!=''){
      $from_date = get_date_db($from_date);
      $to_date = get_date_db($to_date);
      $query .=" and payment_date between '$from_date' and '$to_date'";
}
$query .= 'order by refund_id desc';

$count = 0;
$total_estimate_amt = 0;
$cancelled_amount=0;
$pending_amount=0;
$total_amount=0;
$sq_estimate = mysql_query($query);

$row_count = 6;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Purchase ID")
        ->setCellValue('D'.$row_count, "Date")
        ->setCellValue('E'.$row_count, "Mode")
        ->setCellValue('F'.$row_count, "Bank Name")
        ->setCellValue('G'.$row_count, "cheque No/ID")
        ->setCellValue('H'.$row_count, "Refund Amount");
         
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    

$row_count++;

    $sq_estimate = mysql_query($query);
    while($row_refund = mysql_fetch_assoc($sq_estimate)){

        $query = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$row_refund[estimate_id]'"));
        $date = $query['purchase_date'];
        $yr = explode("-", $date);
        $year =$yr[0];
      $estimate_type_val = get_estimate_type_name($row_refund['estimate_type'], $row_refund['estimate_type_id']);
      $vendor_type_val = get_vendor_name($row_refund['vendor_type'], $row_refund['vendor_type_id']);

      $total_amount=$total_amount+$row_refund['payment_amount'];
      if($row_refund['clearance_status']=="Pending"){ 
        $pending_amount = $pending_amount + $row_refund['payment_amount'];
      }
      else if($row_refund['clearance_status']=="Cancelled"){
        $cancelled_amount = $cancelled_amount + $row_refund['payment_amount'];
      }

      $total_amount = ($total_amount=="") ? 0 : $total_amount;
      $pending_amount =  ($pending_amount=="") ? 0 : $pending_amount;
      $cancelled_amount = ($cancelled_amount=="") ? 0 : $cancelled_amount;
      
	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, get_vendor_estimate_id($row_refund['estimate_id'],$year))
        ->setCellValue('D'.$row_count, date('d-m-Y', strtotime($row_refund['payment_date'])))
        ->setCellValue('E'.$row_count, $row_refund['payment_mode'])
        ->setCellValue('F'.$row_count, $row_refund['bank_name'])
        ->setCellValue('G'.$row_count, $row_refund['transaction_id'])
        ->setCellValue('H'.$row_count, $row_refund['payment_amount']);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "Refund : ".(number_format($total_amount,2)))
        ->setCellValue('F'.$row_count, "Pending : ".(number_format($pending_amount,2)))
        ->setCellValue('G'.$row_count, "Cancelled : ".(number_format($cancelled_amount,2)))
        ->setCellValue('H'.$row_count, "Total : ".(number_format(($total_amount - $pending_amount - $cancelled_amount),2)));

       $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($header_style_Array);
       $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);
}

//////////////////////////****************Content End**************////////////////////////////////
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Supplier Estimate Refund('.date('d-m-Y H:i:s').').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
