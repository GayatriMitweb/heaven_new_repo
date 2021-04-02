<?php
include "../../../../../model/model.php";
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];


$today_date1 = date('Y-m-d 00:00');
$today_date2 = date('Y-m-d 23:00');

if($emp_id!=""){   
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'")); 
}

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = get_datetime_user($today_date1).' to '.get_datetime_user($today_date2);
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Followup Update Report')
            ->setCellValue('B3', 'From-To-Date')
            ->setCellValue('C3', $date_str);
             
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);


$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from enquiry_master_entries where 1 ";
if($from_date!="" && $to_date !=''){
  $from_date = date('Y-m-d H:i',strtotime($from_date));
  $to_date = date('Y-m-d H:i',strtotime($to_date));
  $query .=" and followup_date between '$from_date' and '$to_date'  ";
}else{
  $query .=" and followup_date between '$today_date1' and '$today_date2'  ";
}
if($branch_status=='yes' && $role!='Admin'){
    $query .=" and enquiry_id in(select enquiry_id from enquiry_master where branch_admin_id='$branch_admin_id')";
}

$count = 0;
$row_count = 6;
   
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Customer Name")
        ->setCellValue('D'.$row_count, "Assigned To")
        ->setCellValue('E'.$row_count, "Followup Date")
        ->setCellValue('F'.$row_count, "Followup Type")
        ->setCellValue('G'.$row_count, "Followup Description");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq))
{
  if($row['followup_type']!=''){
    $count++;
    $sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row[enquiry_id]'"));
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_enq[assigned_emp_id]'"));

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count)
            ->setCellValue('C'.$row_count, $sq_enq['name'])
            ->setCellValue('D'.$row_count, $sq_emp['first_name'].' '.$sq_emp['last_name'])
            ->setCellValue('E'.$row_count, get_datetime_user($row['followup_date']))
            ->setCellValue('F'.$row_count, $row['followup_type'])
            ->setCellValue('G'.$row_count,  $row['followup_reply']);

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);

    $row_count++;
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
header('Content-Disposition: attachment;filename="Followup Update Report('.date('d-m-Y H:i:s').').xls"');
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
