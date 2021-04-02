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
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$expense_type = $_GET['expense_type'];
$supplier_type = $_GET['supplier_type'];

if($supplier_type!=""){
    $sq_supp = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$supplier_type'"));   
}
if($expense_type!=""){
    $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$expense_type'"));
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Other Expense Payment')
            ->setCellValue('B3', 'Expense Type')
            ->setCellValue('C3', $sq_ledger['ledger_name'])
            ->setCellValue('B4', 'Supplier Name')
            ->setCellValue('C4', $sq_supp['vendor_name']);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);


$query = "select * from other_expense_payment_master where 1 ";
if($financial_year_id!=""){
    $query .= " and financial_year_id='$financial_year_id'";
}
if($supplier_type!=""){
    $query .= " and supplier_id='$supplier_type'";
}
if($expense_type!=""){
    $query .= " and expense_type_id='$expense_type'";
}

if($branch_status=='yes' && $role!='Admin'){
    $query .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query .= " and emp_id='$emp_id'";
}
$query .= " order by payment_id desc ";
$row_count = 8;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Payment ID")
        ->setCellValue('D'.$row_count, "Expense ID")
        ->setCellValue('E'.$row_count, "Payment Date")
        ->setCellValue('F'.$row_count, "Expense Type")
        ->setCellValue('F'.$row_count, "Supplier Name")
        ->setCellValue('H'.$row_count, "Amount")
        ->setCellValue('I'.$row_count, "Mode")
        ->setCellValue('J'.$row_count, "Bank Name")
        ->setCellValue('K'.$row_count, "Cheque No/ID");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 0;

    $count = 0;
    $sq_expense = mysql_query($query);
    while($row_expense = mysql_fetch_assoc($sq_expense)){

    $sq_supp = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$row_expense[supplier_id]'"));
    $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_expense[expense_type_id]'"));
    $other_expense = mysql_fetch_assoc(mysql_query("select * from other_expense_master where expense_type_id='$row_expense[expense_type_id]'"));
    $date = $other_expense['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];

    $date1 = $row_expense['payment_date'];
    $yr1 = explode("-", $date1);
    $year1 =$yr1[0];
            
    $total_paid_amt = $total_paid_amt + $row_expense['payment_amount'];
    
    $sq_paid = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from other_expense_payment_master where clearance_status!='Cancelled'"));
    $sq_canc = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as cancel from other_expense_payment_master where clearance_status='Cancelled'"));
    $sq_pend = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as pending from other_expense_payment_master where clearance_status='Pending'"));
    
    if($supplier_type!=""){
        $sq_paid = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from other_expense_payment_master where clearance_status!='Cancelled' and supplier_id='$supplier_type'"));
        $sq_canc = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as cancel from other_expense_payment_master where clearance_status='Cancelled' and supplier_id='$supplier_type'"));
        $sq_pend = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as pending from other_expense_payment_master where clearance_status='Pending' and supplier_id='$supplier_type'"));
    }
    if($expense_type!=""){
        $sq_paid = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from other_expense_payment_master where clearance_status!='Cancelled' and expense_type_id='$expense_type'"));
        $sq_canc = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as cancel from other_expense_payment_master where clearance_status='Cancelled' and expense_type_id='$expense_type'"));
        $sq_pend = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as pending from other_expense_payment_master where clearance_status='Pending' and expense_type_id='$expense_type'"));
    }

    if($row_expense['payment_amount'] != '0'){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count,  get_other_expense_payment_id($row_expense['payment_id'],$year1))
            ->setCellValue('D'.$row_count,  get_other_expense_booking_id($row_expense['expense_id'],$year))
            ->setCellValue('E'.$row_count, get_date_user($row_expense['payment_date']))
            ->setCellValue('F'.$row_count, $sq_ledger['ledger_name'])
            ->setCellValue('G'.$row_count, ($sq_supp['vendor_name'] == '') ? 'NA' : $sq_supp['vendor_name'])
            ->setCellValue('H'.$row_count, $row_expense['payment_amount'])
            ->setCellValue('I'.$row_count, $row_expense['payment_mode'])
            ->setCellValue('J'.$row_count, $row_expense['bank_name'])
            ->setCellValue('K'.$row_count, $row_expense['transaction_id']);

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($content_style_Array);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

		$row_count++;
        }
    }
    
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, "")
    ->setCellValue('C'.$row_count, "")
    ->setCellValue('D'.$row_count, "")
    ->setCellValue('E'.$row_count, "")
    ->setCellValue('E'.$row_count, "")
    ->setCellValue('G'.$row_count, "Paid Amount : ".number_format($total_paid_amt, 2))
    ->setCellValue('H'.$row_count, "Pending Clearance : ".number_format($sq_pend['pending'], 2))
    ->setCellValue('I'.$row_count, "Cancelled : ".number_format($sq_canc['cancel'], 2))
    ->setCellValue('J'.$row_count, "Total Paid : ".number_format($total_paid_amt-$sq_pend['pending']-$sq_canc['cancel'], 2))
    ->setCellValue('K'.$row_count, "");

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);
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
header('Content-Disposition: attachment;filename="Other Expense Payment('.date('d-m-Y H:i:s').').xls"');
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
