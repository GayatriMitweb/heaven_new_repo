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
$customer_id = $_GET['customer_id'];
$train_ticket_id = $_GET['train_ticket_id'];
$payment_from_date = $_GET['payment_from_date'];
$payment_to_date = $_GET['payment_to_date'];
$payment_mode = $_GET['payment_mode'];
$financial_year_id = $_SESSION['financial_year_id'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];

$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id = '$train_ticket_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year1 =$yr[0];

if($customer_id!=""){
    $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name'];
}
else{
    $cust_name = "";
}

if($payment_mode!=""){
    $payment_str = $payment_mode;
}
else{
    $payment_str = "";
}

if($financial_year_id != ""){ 
    $query_year = mysql_fetch_assoc(mysql_query("Select * from financial_year where financial_year_id='$financial_year_id'"));
    $year = get_date_user($query_year['from_date']).' to '.get_date_user($query_year['to_date']);   
}
else{
    $fin_year = "";
}
 
if($payment_from_date!="" && $payment_to_date!=""){
    $date_str = $payment_from_date.' to '.$payment_to_date;
}
else{
    $date_str = "";
}    
 
$invoice_id = ($train_ticket_id!="") ? get_train_ticket_booking_id($train_ticket_id,$year1): "";
if($company_name == 'undefined') { $company_name = ''; }
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Train Ticket Payment')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
            ->setCellValue('B5', 'From-To Date')
            ->setCellValue('C5', $date_str)
            ->setCellValue('B6', 'Payment Mode')
            ->setCellValue('B7', 'Customer Type')
            ->setCellValue('C7', $cust_type)
            ->setCellValue('B8', 'Company Name')
            ->setCellValue('C8', $company_name);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($borderArray);

$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($borderArray);

$query = "select * from train_ticket_payment_master where 1 and payment_amount!='0'";       
if($financial_year_id!=""){
    $query .= " and financial_year_id='$financial_year_id'";
}
if($train_ticket_id!=""){
    $query .= " and train_ticket_id='$train_ticket_id'";
}
if($payment_mode!=""){
    $query .= " and payment_mode='$payment_mode'";
}
if($customer_id!=""){
    $query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id='$customer_id')";
}
if($cust_type != ""){
    $query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($payment_from_date!='' && $payment_to_date!=''){
    $payment_from_date = get_date_db($payment_from_date);
    $payment_to_date = get_date_db($payment_to_date);
    $query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
}
if($branch_status=='yes'){
    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
        $query .= " and branch_admin_id = '$branch_admin_id'";
    }
    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
        $query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where emp_id ='$emp_id')  and branch_admin_id = '$branch_admin_id'";
    }
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
    $query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where emp_id ='$emp_id')";
}
$query .= " order by train_ticket_id desc";

$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;

$row_count = 11;
$count = 0;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('E'.$row_count, "Receipt Date")
        ->setCellValue('F'.$row_count, "Amount")
        ->setCellValue('G'.$row_count, "Mode");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$sq_train_ticket_payment = mysql_query($query);
while($row_train_ticket_payment = mysql_fetch_assoc($sq_train_ticket_payment)){
            
    $sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$row_train_ticket_payment[train_ticket_id]'"));
    $date = $sq_train_ticket_info['created_at'];
    $yr = explode("-", $date);
    $year = $yr[0];

    $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_train_ticket_info[customer_id]'"));
    if($sq_customer_info['type']=='Corporate'){
        $customer_name = $sq_customer_info['company_name'];
    }else{
        $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
    }
    
    if($row_train_ticket_payment['clearance_status']=="Pending"){ 
        $sq_pending_amount = $sq_pending_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
    }
    else if($row_train_ticket_payment['clearance_status']=="Cancelled"){ 
        $sq_cancel_amount = $sq_cancel_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
    }
    $sq_paid_amount = $sq_paid_amount + $row_train_ticket_payment['payment_amount'] + $row_train_ticket_payment['credit_charges'];
            

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, ++$count)
    ->setCellValue('C'.$row_count, get_train_ticket_booking_id($row_train_ticket_payment['train_ticket_id'],$year))
    ->setCellValue('D'.$row_count, $customer_name)
    ->setCellValue('E'.$row_count, date('d-m-Y', strtotime($row_train_ticket_payment['payment_date'])))
    ->setCellValue('F'.$row_count, number_format($row_train_ticket_payment['payment_amount']+ + $row_train_ticket_payment['credit_charges'],2))
    ->setCellValue('G'.$row_count, $row_train_ticket_payment['payment_mode']);
            
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

    $row_count++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, "")
    ->setCellValue('C'.$row_count, "")
    ->setCellValue('D'.$row_count, 'Paid Amount : '.number_format($sq_paid_amount,2))
    ->setCellValue('E'.$row_count, 'Pending Clearance Amount : '.number_format($sq_pending_amount,2))
    ->setCellValue('F'.$row_count, 'Cancellation Charges : '.number_format($sq_cancel_amount,2))
    ->setCellValue('G'.$row_count, 'Payment Amount :'.number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount),2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);
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
header('Content-Disposition: attachment;filename="Train Ticket Payment('.date('d-m-Y H:i:s').').xls"');
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
