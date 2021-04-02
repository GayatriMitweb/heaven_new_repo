<?php
include "../../../../model/model.php";

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
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];

$total_sale = 0; $total_purchase = 0;
$entity = array('FLIGHT','TRAIN','HOTEL','TRANSPORT','DMC');
$tourwise_details = mysql_fetch_assoc(mysql_query("select *  from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id ='$tour_group_id' "));
//Travel Total
$actual_travel_expense = $tourwise_details['total_travel_expense'];
$actual_tour_expense = $tourwise_details['total_tour_fee'];
$sale = $actual_travel_expense + $actual_tour_expense;
 
$sq_refund_info1 = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_details[id]'"));

$total_sale = $sale - $sq_refund_info1['total_refund'];

////// Purchase ///
$sq_air_ticket = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and vendor_type='Ticket Vendor'");
while($row_air_ticket = mysql_fetch_assoc($sq_air_ticket)){
  $air_ticket_sum = $air_ticket_sum + $row_air_ticket['net_total'] - $row_air_ticket['refund_net_total'];
}

$sq_train_ticket = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and vendor_type='Train Ticket Vendor'");
while($row_train_ticket = mysql_fetch_assoc($sq_train_ticket)){
  $train_ticket_sum = $train_ticket_sum + $row_train_ticket['net_total'] - $row_train_ticket['refund_net_total'];
}

$sq_hotel = mysql_query("select *  from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and vendor_type='Hotel Vendor'");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
  $hotel_ticket_sum = $hotel_ticket_sum + $row_hotel['net_total'] - $row_hotel['refund_net_total'];
}

$sq_dmc = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and vendor_type='DMC Vendor'");
while($row_dmc = mysql_fetch_assoc($sq_dmc)){
  $dmc_ticket_sum = $dmc_ticket_sum + $row_dmc['net_total'] - $row_dmc['refund_net_total'];
}

$sq_trasnport = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and vendor_type='Transport Vendor'");
while($row_trasnport = mysql_fetch_assoc($sq_trasnport)){
  $transport_ticket_sum = $transport_ticket_sum + $row_trasnport['net_total'] - $row_trasnport['refund_net_total'];
}

$total_purchase = ($transport_ticket_sum + $dmc_ticket_sum + $hotel_ticket_sum + $air_ticket_sum + $train_ticket_sum);

if($air_ticket_sum == ''){ $air_ticket_sum = 0; }
if($train_ticket_sum == ''){ $train_ticket_sum = 0; }
if($hotel_ticket_sum == ''){ $hotel_ticket_sum = 0; }
if($transport_ticket_sum == ''){ $transport_ticket_sum = 0; }
if($dmc_ticket_sum == ''){ $dmc_ticket_sum = 0; }

$purchase_cost = array($air_ticket_sum,$train_ticket_sum,$hotel_ticket_sum,$transport_ticket_sum,$dmc_ticket_sum);

$result = $total_sale - $total_purchase;

if($result >= '0' ) { $var = "Profit"; }
else{ $var = "Loss";
    $result = $total_purchase - $total_sale;   }

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Group Tour Expense');

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$count = 0;
$row_count = 4;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sale Cost")
        ->setCellValue('C'.$row_count, number_format($total_sale,2));;

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  
$row_count++;
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Purchase Cost");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':B'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':B'.$row_count)->applyFromArray($borderArray);    
  

$row_count++;

for($i=0;$i<5;$i++){       
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, '')
        ->setCellValue('C'.$row_count, $entity[$i]." : ".number_format($purchase_cost[$i],2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);
$row_count ++;

}

$row_count ++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Sale")
        ->setCellValue('C'.$row_count, number_format($total_sale,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);

$row_count ++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Purchase")
        ->setCellValue('C'.$row_count, number_format($total_purchase,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);

$row_count ++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total ".$var)
        ->setCellValue('C'.$row_count, number_format($result,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);

/*

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Total Sale")
        ->setCellValue('E'.$row_count, "Total Purchase")
        ->setCellValue('F'.$row_count, "Total")
        ->setCellValue('G'.$row_count, "Type");
   
   $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
   $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    
  
*/
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
header('Content-Disposition: attachment;filename="Group Tour Expense('.date('d-m-Y H:i:s').').xls"');
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
