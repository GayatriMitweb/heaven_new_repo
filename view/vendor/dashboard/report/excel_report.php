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
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role_id = $_SESSION['role_id'];
$branch_status = $_GET['branch_status']; 
$role = $_SESSION['role'];
$vendor_type_id = $_GET['vendor_type_id'];
$vendor_type = $_GET['vendor_type'];
$estimate_type_id = $_GET['estimate_type_id'];
$estimate_type = $_GET['estimate_type'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if($vendor_type!=""){
     $vendor_str=$vendor_type;
}
else{
    $vendor_str = "";
}

if($estimate_type!= ""){ 
    $esti = $estimate_type;
}
else{
    $esti = "";
}

if($estimate_type_id!=""){
    $est_str1 = get_estimate_type_name($estimate_type, $estimate_type_id);
}
else{
    $est_str1 = "";
}

if($vendor_type_id!=""){
    $vendor_str1 = get_vendor_name($vendor_type, $vendor_type_id);
}
else{
    $vendor_str1 = "";
}

if($from_date!="" && $to_date!=""){
    $from_date = get_date_db($from_date);
    $to_date = get_date_db($to_date);
    $filter_date = $from_date.' To '.$to_date;
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Supplier Report')
            ->setCellValue('B3', 'Supplier Type')
            ->setCellValue('C3', $vendor_str)
            ->setCellValue('B4', 'Purchase Type')
            ->setCellValue('C4', $esti)
            ->setCellValue('B5', 'Purchase ID')
            ->setCellValue('C5', $est_str1)
            ->setCellValue('B6', 'Supplier Name')
            ->setCellValue('C6', $vendor_str1)
            ->setCellValue('B7', 'From/To Date')
            ->setCellValue('C7', $filter_date);

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

$query = "select estimate_type, estimate_type_id, vendor_type, vendor_type_id, created_at as date, net_total as credit, '' as debit from vendor_estimate where 1 ";
if($estimate_type!=""){
    $query .= " and estimate_type='$estimate_type' ";
}
if($vendor_type!=""){
    $query .= " and vendor_type='$vendor_type' ";
}
if($estimate_type_id!=""){
    $query .= " and estimate_type_id='$estimate_type_id' ";
}
if($vendor_type_id!=""){
    $query .= " and vendor_type_id='$vendor_type_id' ";
}

if($vendor_type!="" && $vendor_type_id!=""){
    $data = get_opening_bal($vendor_type , $vendor_type_id);
    $opening_bal = $data['opening_balance'];
    $side = $data['side'];
} 

if($branch_status=='yes' && $role!='Admin'){
    $query .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query .= " and emp_id='$emp_id'";
} 
if($from_date!="" && $to_date!=""){
    $from_date = get_date_db($from_date);
    $to_date = get_date_db($to_date);
    $query .= " and purchase_date between '$from_date' and '$to_date'";
}
$query .= " union ";

$query .= "select '' as estimate_type, '' as estimate_type_id, vendor_type, vendor_type_id, payment_date as date1, '' as credit1, payment_amount as debit1 from vendor_payment_master where clearance_status!='Pending' AND clearance_status!='Cancelled' ";
if($vendor_type!=""){
    $query .= " and vendor_type='$vendor_type' ";
}
if($vendor_type_id!=""){
    $query .= " and vendor_type_id='$vendor_type_id' ";
} 
if($estimate_type!=""){
    $query .= " and estimate_type='$estimate_type' ";
}
if($estimate_type_id!=""){
    $query .= " and estimate_type_id='$estimate_type_id' ";
} 
if($branch_status=='yes' && $role!='Admin'){
    $query .= " and branch_admin_id = '$branch_admin_id'";
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
$query .= " and emp_id='$emp_id'";
}
if($from_date!="" && $to_date!=""){
    $from_date = get_date_db($from_date);
    $to_date = get_date_db($to_date);
    $query .= " and payment_date between '$from_date' and '$to_date'";
}

$query .=" order by date desc"; 

$sq_paid_amount_query = "select sum(payment_amount) as sum from vendor_payment_master where clearance_status!='Pending' AND clearance_status!='Cancelled'";
if($vendor_type!=""){
    $sq_paid_amount_query .= " and vendor_type='$vendor_type'";
}
if($vendor_type_id!=""){
    $sq_paid_amount_query .= " and vendor_type_id='$vendor_type_id'";
}
if($estimate_type!=""){
    $sq_paid_amount_query .= " and estimate_type='$estimate_type' ";
}
if($estimate_type_id!=""){
    $sq_paid_amount_query .= " and estimate_type_id='$estimate_type_id' ";
}


$row_count = 10;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('H'.$row_count, "Opening Balance".'('.$side.')')
        ->setCellValue('I'.$row_count, number_format($opening_bal, 2));

$objPHPExcel->getActiveSheet()->getStyle('H'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('H'.$row_count.':I'.$row_count)->applyFromArray($borderArray);  

$row_count = 11;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Purchase Type")
        ->setCellValue('D'.$row_count, "Purchase ID")
        ->setCellValue('E'.$row_count, "Supplier Type")
        ->setCellValue('F'.$row_count, "Supplier Name")
        ->setCellValue('G'.$row_count, "Date")
        ->setCellValue('H'.$row_count, "Credit")
        ->setCellValue('I'.$row_count, "Debit");
         
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$total_estimate_amt = 0;
$count = 0;
$sq_estimate = mysql_query($query);
while($row_report = mysql_fetch_assoc($sq_estimate)){

    $total_estimate_amt = $total_estimate_amt + $row_report['credit'];

    $vendor_type_val = get_vendor_name($row_report['vendor_type'], $row_report['vendor_type_id']);

    if($side == 'Cr'){
        $total_amount = ($total_estimate_amt);
    }else{
        $total_amount = ($total_estimate_amt);
    }
    if($row_report['debit'] != ''){
        $sq_pay1 = mysql_fetch_assoc(mysql_query("select * from vendor_payment_master where vendor_type='$row_report[vendor_type]' and vendor_type_id = '$row_report[vendor_type_id]'"));
        $estimate_type_val = get_estimate_type_name($sq_pay1['estimate_type'], $sq_pay1['estimate_type_id']);
        $estimate_type = $sq_pay1['estimate_type']; 
    }
    else{
        $estimate_type_val = get_estimate_type_name($row_report['estimate_type'], $row_report['estimate_type_id']);
        $estimate_type = $row_report['estimate_type'];
    }

    $total_paid_amt += $row_report['debit'];
    if($total_paid_amt==""){ $total_paid_amt = 0; }

    $objPHPExcel->getActiveSheet()
                ->getStyle('H'.$row_count)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()
                ->getStyle('I'.$row_count)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, ($estimate_type == '') ?'NA': $estimate_type)
        ->setCellValue('D'.$row_count, ($estimate_type_val == '') ? 'NA' : $estimate_type_val)
        ->setCellValue('E'.$row_count, $row_report['vendor_type'])
        ->setCellValue('F'.$row_count, $vendor_type_val)
        ->setCellValue('G'.$row_count, date('d-m-Y', strtotime($row_report['date'])))
        ->setCellValue('H'.$row_count, number_format($row_report['credit'],2))
        ->setCellValue('I'.$row_count, number_format($row_report['debit'],2));

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    

		$row_count++;
}
    //Footer
    if($total_estimate_amt >= $total_paid_amt){
        $side1='(Cr)';
    }
    else {	
        $side1='(Dr)';
    }
    if($side == 'Credit'){
        $total_amount = $total_amount + $opening_bal - $total_paid_amt;
    }else{
        $total_amount = $total_amount - $opening_bal - $total_paid_amt;
    }
    if($total_amount <= 0) {
        $total_amount = ($total_amount) - ($total_amount) - ($total_amount);
    }
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, "")
        ->setCellValue('G'.$row_count, "Total Costing : ".number_format($total_estimate_amt, 2))
        ->setCellValue('H'.$row_count, "Total Paid : ".number_format($total_paid_amt, 2))
        ->setCellValue('I'.$row_count, "Closing Balance : ".number_format($total_amount, 2).$side1);        

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);  

	

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
header('Content-Disposition: attachment;filename="Supplier Report('.date('d-m-Y H:i:s').').xls"');
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
