<?php
include "../../../model/model.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$booking_id = $_GET['booking_id'];
$payment_mode = $_GET['payment_mode'];
$financial_year_id = $_SESSION['financial_year_id'];
$from_date = $_GET['payment_from_date'];
$to_date = $_GET['payment_to_date'];

if($booking_id!=""){
  $sql_booking_date = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id = '$booking_id'")) ;
  $booking_date = $sql_booking_date['created_at'];
  $yr = explode("-", $booking_date);
  $year =$yr[0];
  $invoice_id = get_car_rental_booking_id($booking_id,$year);
}

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}

if($payment_mode!= ""){
  $pay_mode = $payment_mode;
}
else{
  $pay_mode = "";
}

if($financial_year_id != ""){ 
    $query_year = mysql_fetch_assoc(mysql_query("Select * from financial_year where financial_year_id='$financial_year_id'")); 
    $fin_year = get_date_user($query_year['from_date']).' to '.get_date_user($query_year['to_date']);   
}
else{
    $fin_year = "";
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Car Rental Payment')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Payment Mode')
            ->setCellValue('C4', $pay_mode)
            ->setCellValue('B5', 'From-To-Date')
            ->setCellValue('C5', $date_str);
             
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);   

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);   
 

$count = 0;
    $query = "select * from car_rental_payment where 1";
if($financial_year_id!=""){
  $query .=" and financial_year_id='$financial_year_id'";
}
if($booking_id!=""){
  $query .=" and booking_id='$booking_id'";
}
if($payment_mode!=""){
  $query .=" and payment_mode='$payment_mode'";
}
if($from_date!='' && $to_date!=''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .=" and payment_date between '$from_date' and '$to_date'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
	    $query .= " and branch_admin_id = '$branch_admin_id'";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	    $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and emp_id='$emp_id'";
}
  $row_count = 8;
   
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('F'.$row_count, "Receipt Date")
        ->setCellValue('E'.$row_count, "Mode")
        ->setCellValue('G'.$row_count, "Amount");
         
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 0;
 
$sq_payment = mysql_query($query);
$total_paid_amt=0;
while($row_payment = mysql_fetch_assoc($sq_payment))
{
  if($row_payment['payment_amount']!=0){
    
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$row_payment[booking_id]'"));
    $date = $sq_booking['created_at'];
         $yr = explode("-", $date);
         $year =$yr[0];
    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
    if($sq_customer['type']=='Corporate'){
      $customer_name = $sq_customer['company_name'];
    }else{
      $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
    }

    $total_paid_amt = $total_paid_amt + $row_payment['payment_amount']+ $row_payment['credit_charges'];
    if($row_payment['clearance_status']=="Pending"){  
      $sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
    }
    else if($row_payment['clearance_status']=="Cancelled"){  
     $sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
    }

	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, get_car_rental_booking_id($row_payment['booking_id'],$year))
        ->setCellValue('D'.$row_count, $customer_name)
        ->setCellValue('F'.$row_count,  date('d-m-Y', strtotime($row_payment['payment_date'])))
        ->setCellValue('E'.$row_count, $row_payment['payment_mode'])
        ->setCellValue('G'.$row_count, number_format($row_payment['payment_amount'] + $row_payment['credit_charges'],2));

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, 'Paid Amount : '.number_format($total_paid_amt,2))
        ->setCellValue('E'.$row_count, 'Pending Amount : '.number_format($sq_pending_amount,2))
        ->setCellValue('F'.$row_count, 'Cancellation Charges : '.number_format($sq_cancel_amount,2))
        ->setCellValue('G'.$row_count, 'Payment Amount :'.number_format(($total_paid_amt - $sq_pending_amount - $sq_cancel_amount),2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="Car Rental Payment('.date('d-m-Y H:i:s').').xls"');
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
