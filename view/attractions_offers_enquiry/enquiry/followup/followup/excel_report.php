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
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$emp_id_filter = $_GET['emp_id_filter'];
$enquiry_type = $_GET['enquiry_type'];
$enquiry = $_GET['enquiry'];
$branch_status = $_GET['branch_status'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$enquiry_status = $_GET['enquiry_status'];
$reference_id = $_GET['reference_id'];

$frm = date('Y-m-d ',strtotime($from_date));
$to = date('Y-m-d ',strtotime($to_date));

$count = 0;
$query = "select en.enquiry_id , en.name , ef.followup_date ,ef.followup_status, ef.followup_type, ef.followup_reply , e.first_name , e.last_name from enquiry_master as en left join enquiry_master_entries as ef on en.enquiry_id=ef.enquiry_id left join emp_master as e on en.assigned_emp_id= e.emp_id where ef.followup_type!='' ";

if($branch_status=='yes' && $role=='Branch Admin'){
    $query .=" and en.branch_admin_id = '$branch_admin_id'";
}
if($from_date !="" && $to_date!=""){
  $query .="and  en.enquiry_date between '$frm' and '$to'";
}
if($emp_id_filter != '' && $emp_id_filter != 'undefined'){
  $query .="and en.assigned_emp_id= '$emp_id_filter'";
}
if($enquiry_status != ''){
  $query .="and  ef.followup_status= '$enquiry_status'";
}
if($reference_id != ''){
  $query .="and en.reference_id= '$reference_id' ";
}
if($enquiry != ''){
	$query .="and en.enquiry='$enquiry' ";
}
if($enquiry_type != ''){
	$query .="and en.enquiry_type='$enquiry_type' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}

$query .= " ORDER BY en.enquiry_id DESC ";

$sq_enquiries = mysql_query($query);

$row_count = 1;
$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, "SR.NO")
        ->setCellValue('B'.$row_count, "Allocate To")
        ->setCellValue('C'.$row_count, "Enquiry No")
        ->setCellValue('D'.$row_count, "Customer")
        ->setCellValue('E'.$row_count, "Enquiry For")
        ->setCellValue('F'.$row_count, "Followup Type");

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($borderArray);

while($row_followup = mysql_fetch_assoc($sq_enquiries)){

    $sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row_followup[enquiry_id]'"));
    $assigned_emp_id = $sq_enq['assigned_emp_id'];
    $enquiry_date = $sq_enq['enquiry_date'];
    $yr = explode("-", $enquiry_date);
    $year =$yr[0];
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
    
    $count++;
    $row_count++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row_count, $count)
            ->setCellValue('B'.$row_count, $sq_emp['first_name'].' '.$sq_emp['last_name'])
            ->setCellValue('C'.$row_count, get_enquiry_id($row_followup['enquiry_id'],$year))
            ->setCellValue('D'.$row_count, $sq_enq['name'])
            ->setCellValue('E'.$row_count, $sq_enq['enquiry_type'])
            ->setCellValue('F'.$row_count, date('d-m-Y H:i ',strtotime($row_followup['followup_date'])).'/'.$row_followup['followup_type'].'/'.$row_followup['followup_reply']);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($borderArray);
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
header('Content-Disposition: attachment;filename="Enquiry_Followup('.date('d-m-Y H:i:s').').xls"');
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