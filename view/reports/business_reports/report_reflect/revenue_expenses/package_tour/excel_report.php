<?php
include "../../../../../../model/model.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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
$booking_id = $_GET['booking_id'];

$total_sale = 0; $total_purchase = 0;
//Sale
$tourwise_details = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
$date = $tourwise_details['booking_date'];
$yr = explode("-", $date);
$year =$yr[0];

//Incentive
$sq_sum = mysql_fetch_assoc(mysql_query("select sum(basic_amount) as incentive_amount from booker_incentive_package_tour where booking_id='$tourwise_details[booking_id]'"));
$incentive_amount = $sq_sum['incentive_amount'];
//Cancel consideration
$sq_tr_refund = mysql_num_rows(mysql_query("select * from package_refund_traveler_cancalation_entries where tourwise_traveler_id='$tourwise_details[booking_id]'"));
$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$credit_charges = $sq_paid_amount['sumc'];
$tax_amount1 = 0;
if($sq_tr_refund == ''){
	$actual_travel_expense = $tourwise_details['total_travel_expense'];
	$actual_tour_expense = $tourwise_details['actual_tour_expense'];
	$total_sale =  $tourwise_details['net_total'] - $incentive_amount;
	$tax_amount = $tourwise_details['tour_service_tax_subtotal'];
	$tax_amount = explode(":",$tax_amount);
	$tax_amount1 = $tax_amount1 + $tax_amount[2];

	$total_sale -= $tax_amount1;
}
$total_sale += $credit_charges;
// Purchase
$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'");
while($row_purchase = mysql_fetch_assoc($sq_purchase)){
  $total_purchase += $row_purchase['net_total'];
  $total_purchase -= $row_purchase['service_tax_subtotal'];
}

//Other Expense
$sq_other_purchase = mysql_fetch_assoc(mysql_query("select sum(amount) as amount_total from package_tour_estimate_expense where booking_id='$booking_id' "));
$total_purchase += $sq_other_purchase['amount_total'];

//Revenue & Expenses
$result = $total_sale - $total_purchase;

if($total_sale > $total_purchase){
  $var = 'Total Profit(%)';
}else{
  $var = 'Total Loss(%)';
}
$profit_loss = $total_sale - $total_purchase;

$profit_loss_per = 0;
$profit_amount = $total_sale - $total_purchase;
$profit_loss_per = ($profit_amount / $total_sale) * 100;
$profit_loss_per = round($profit_loss_per, 2);

$sq_count = mysql_num_rows(mysql_query("select * from package_tour_estimate_expense where booking_id='$booking_id' "));
$sq_pcount = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'"));

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Package Tour Expense');

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$count = 0;
$row_count = 4;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Booking ID")
        ->setCellValue('C'.$row_count, get_package_booking_id($booking_id,$year));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Sale")
        ->setCellValue('C'.$row_count, number_format($total_sale,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Purchase")
        ->setCellValue('C'.$row_count, number_format($total_purchase,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  

$row_count++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $var)
        ->setCellValue('C'.$row_count, number_format($profit_loss,2).'('.$profit_loss_per.'%)');

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);

$row_count++;
$row_count++;


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C'.$row_count, "Sale/Purchase History");
$objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($borderArray); 

$row_count++;

//////////Sale Start//////////////////   
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking Date")
        ->setCellValue('D'.$row_count, "Tour Name")
        ->setCellValue('E'.$row_count, "User Name");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($borderArray);
$row_count++;

$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$tourwise_details[emp_id]'"));
$emp = ($tourwise_details['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name'];
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, '1')
    ->setCellValue('C'.$row_count, get_date_user($tourwise_details['booking_date']))
    ->setCellValue('D'.$row_count, $tourwise_details['tour_name'])
    ->setCellValue('E'.$row_count, $emp);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($content_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($borderArray); 
//////////Sale End//////////////////   
          

//////////Purchase Details Start/////////////////
if($sq_pcount!=0){ 
    $row_count++;
    $row_count++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$row_count, "Purchase");
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($borderArray); 

    $row_count++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, "Sr. No")
            ->setCellValue('C'.$row_count, "Supplier Type")
            ->setCellValue('D'.$row_count, "Supplier Name")
            ->setCellValue('E'.$row_count, "Purchase Amount");

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($borderArray);          
    $count = 1;
    $sq_query = mysql_query("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'");
    while($row_query = mysql_fetch_assoc($sq_query))
    { 
        $vendor_name = get_vendor_name_report($row_query['vendor_type'],$row_query['vendor_type_id']);
        $row_count++;
        if($row_query['net_total'] != '0'){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, $count++)
                ->setCellValue('C'.$row_count, $row_query['vendor_type'])
                ->setCellValue('D'.$row_count, $vendor_name)
                ->setCellValue('E'.$row_count, number_format($row_query['net_total']-$row_query['service_tax_subtotal'],2));

            $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($content_style_Array);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':E'.$row_count)->applyFromArray($borderArray);    
        }
    } 
}
//////////Purchase Details End/////////////////

//////////Other Expense Start/////////////////
if($sq_count!=0){
    $row_count++;
    $row_count++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$row_count, "Other Expense");
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($borderArray); 

    $row_count++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, "Sr. No")
            ->setCellValue('C'.$row_count, "Expense Name")
            ->setCellValue('D'.$row_count, "Amount");

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':D'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':D'.$row_count)->applyFromArray($borderArray);          
    $count = 1;
    $sq_query = mysql_query("select * from package_tour_estimate_expense where booking_id='$booking_id'");
    while($sq_other_purchase = mysql_fetch_assoc($sq_query)){	
        if($sq_other_purchase['amount'] != '0'){
            $row_count++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, $count++)
                ->setCellValue('C'.$row_count, $sq_other_purchase['expense_name'])
                ->setCellValue('D'.$row_count, $sq_other_purchase['amount']);

            $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':D'.$row_count)->applyFromArray($content_style_Array);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':D'.$row_count)->applyFromArray($borderArray);    
        }
    }
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
header('Content-Disposition: attachment;filename="Package Tour Expense('.date('d-m-Y H:i:s').').xls"');
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
