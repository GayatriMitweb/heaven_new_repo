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
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_GET['branch_status'];
$tour_id = $_GET['tour_id'];
$group_id = $_GET['group_id'];
$customer_id = $_GET['customer_id'];
$booking_id = $_GET['booking_id'];
$payment_mode = $_GET['payment_mode'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];

if($tour_id!=""){
	$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
  $tour_str = $sq_tour['tour_name'];
}
else{
	$tour_str = "";
}

if($group_id!=""){
  $sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));
  $group_str = get_date_user($sq_group['from_date']).' to '.get_date_user($sq_group['to_date']);
}
else{
  $group_str = "";
}

if($customer_id!=""){
  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name'];
}
else{
  $cust_name = "";
}

if($booking_id!=""){
  $sql_booking_date = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id = '$booking_id'")) ;
  $booking_date = $sql_booking_date['form_date'];
  $yr = explode("-", $booking_date);
  $year1 =$yr[0];
  $invoice_id = get_group_booking_id($booking_id,$year1);
}

if($company_name == 'undefined') { $company_name = ''; }

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
            ->setCellValue('C2', 'Group Payment')
            ->setCellValue('B3', 'Tour Name')
            ->setCellValue('C3', $tour_str)
            ->setCellValue('B4', 'Group')
            ->setCellValue('C4', $group_str)
            ->setCellValue('B5', 'Customer')
            ->setCellValue('C5', $cust_name)
            ->setCellValue('B6', 'Booking ID')
            ->setCellValue('C6', $invoice_id)
            ->setCellValue('B7', 'Payment Mode')
            ->setCellValue('C7', $pay_mode)
            ->setCellValue('B8', 'From-To-Date')
            ->setCellValue('C8', $date_str)
            ->setCellValue('B9', 'Customer Type')
            ->setCellValue('C9', $cust_type)
            ->setCellValue('B10', 'Company Name')
            ->setCellValue('C10', $company_name);

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

$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($borderArray);   

$objPHPExcel->getActiveSheet()->getStyle('B10:C10')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B10:C10')->applyFromArray($borderArray);  

$count = 0;
$total_pending = 0;
$total_cancelled = 0;
$total = 0;

$query = "select * from payment_master where amount !='0' ";
if($tour_id!=""){
  $query .=" and tourwise_traveler_id in (select id from tourwise_traveler_details where tour_id='$tour_id')";
}
if($group_id!=""){
  $query .=" and tourwise_traveler_id in (select id from tourwise_traveler_details where tour_group_id='$group_id')";
}
if($customer_id!=""){
  $query .=" and tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id')";
}
if($booking_id!=""){
  $query .=" and tourwise_traveler_id='$booking_id'";
}
if($payment_mode!=""){
  $query .=" and payment_mode='$payment_mode'";
}
if($from_date!="" && $to_date!=""){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .=" and date between '$from_date' and '$to_date'";
}
if($financial_year_id!=""){
  $query .=" and financial_year_id='$financial_year_id'";
}
if($cust_type != ""){
    $query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($company_name != ""){
    $query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
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
$sq_payment = mysql_query($query);
$row_count = 14;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('E'.$row_count, "Tour")
        ->setCellValue('F'.$row_count, "Tour Date")
        ->setCellValue('G'.$row_count, "Mode")
        ->setCellValue('H'.$row_count, "Receipt Date")
        ->setCellValue('I'.$row_count, "Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 0;
while($row_payment = mysql_fetch_assoc($sq_payment)){

      $sq_booking = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$row_payment[tourwise_traveler_id]'"));
      $date = $sq_booking['form_date'];
      $yr = explode("-", $date);
      $year =$yr[0];
      $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_booking[tour_id]'"));
      $sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$sq_booking[tour_group_id]'"));
      $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
      if($sq_customer['type'] == 'Corporate'){
        $customer_name = $sq_customer['company_name'];
      }else{
        $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
      }
      
      $tour = $sq_tour['tour_name'];
      $group = get_date_user($sq_group['from_date']).' to '.get_date_user($sq_group['to_date']);

      if($row_payment['clearance_status']=="Pending"){
        $total_pending = $total_pending+$row_payment['amount']+$row_payment['credit_charges'];
      }
      else if($row_payment['clearance_status']=="Cancelled"){
        $total_cancelled = $total_cancelled+$row_payment['amount']+$row_payment['credit_charges'];
      }
      $total = $total+$row_payment['amount']+$row_payment['credit_charges'];

	    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, get_group_booking_id($row_payment['tourwise_traveler_id'],$year))
        ->setCellValue('D'.$row_count, $customer_name)
        ->setCellValue('E'.$row_count, $tour)
        ->setCellValue('F'.$row_count, $group)
        ->setCellValue('G'.$row_count, $row_payment['payment_mode'])
        ->setCellValue('H'.$row_count, date('d-m-Y',strtotime($row_payment['date'])))
        ->setCellValue('I'.$row_count, number_format($row_payment['amount']+$row_payment['credit_charges'],2));

      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($content_style_Array);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    

		  $row_count++;

      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, 'Total : '.number_format($total, 2))
        ->setCellValue('G'.$row_count, 'Pending Clearance : '. number_format($total_pending, 2))
        ->setCellValue('H'.$row_count, 'Cancelled : '.number_format($total_cancelled, 2))
        ->setCellValue('I'.$row_count, 'Total Paid :'.number_format(($total-$total_pending-$total_cancelled)));

      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);
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
header('Content-Disposition: attachment;filename="Group Receipt('.date('d-m-Y H:i:s').').xls"');
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
