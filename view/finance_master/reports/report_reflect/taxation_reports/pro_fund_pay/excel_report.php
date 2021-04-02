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



$month = $_GET['month'];
$branch_status = $_GET['branch_status'];
$role = $_GET['role'];
$branch_admin_id = $_GET['branch_admin_id'];

if($month != ''){
  if($month == '01'){ $month_name = 'January'; }
  else if($month == '02'){ $month_name = 'February'; }
  else if($month == '03'){ $month_name = 'March'; }
  else if($month == '04'){ $month_name = 'April'; }
  else if($month == '05'){ $month_name = 'May'; }
  else if($month == '06'){ $month_name = 'June'; }
  else if($month == '07'){ $month_name = 'July'; }
  else if($month == '08'){ $month_name = 'August'; }
  else if($month == '09'){ $month_name = 'September'; }
  else if($month == '10'){ $month_name = 'October'; }
  else if($month == '11'){ $month_name = 'November'; }
  else { $month_name = 'December'; }
}
else { $month_name = ''; }

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

           ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Provident Fund Payable')

            ->setCellValue('B3', 'Month')

            ->setCellValue('C3', $month_name);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    



$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$count = 0;
$row_count = 6;   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")

        ->setCellValue('C'.$row_count, "User ID")

        ->setCellValue('D'.$row_count, "User Name")

        ->setCellValue('E'.$row_count, "UAN")

        ->setCellValue('F'.$row_count, "Employer Contribution")

        ->setCellValue('G'.$row_count, "User Contribution")

        ->setCellValue('H'.$row_count, "Total");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$query = "select * from employee_salary_master where 1 ";

if($month != ''){
  $query .= " and month='$month'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
    $query .= " and emp_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
  }
  elseif($role!='Admin' && $role!='Branch Admin'){
      $query .= " and emp_id='$emp_id'";
    }
}
$sq_query = mysql_query($query);

$count = 1;
while($row_query = mysql_fetch_assoc($sq_query))
{
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_query[emp_id]'"));


  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, $row_query['emp_id'])

        ->setCellValue('D'.$row_count, $sq_emp['first_name'].' '.$sq_emp['last_name'])

        ->setCellValue('E'.$row_count, ($sq_emp['uan_code'] == '') ? 'NA' : $sq_emp['uan_code'])

        ->setCellValue('F'.$row_count, $row_query['employer_pf'])

        ->setCellValue('G'.$row_count, $row_query['employee_pf'])

        ->setCellValue('H'.$row_count, number_format($row_query['employee_pf'] + $row_query['employer_pf'],2));



  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    



    $row_count++;



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

header('Content-Disposition: attachment;filename="Provident Fund Payable('.date('d-m-Y H:i:s').').xls"');

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

