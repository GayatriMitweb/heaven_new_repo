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



$till_date = $_GET['till_date'];
if($till_date != ''){
  $till_date1 = get_date_user($till_date);
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)

           ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Other Compliances')

            ->setCellValue('B3', 'Date')

            ->setCellValue('C3', $till_date1);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    



$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$count = 0;
$row_count = 6;   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")

        ->setCellValue('C'.$row_count, "Compliance Name")

        ->setCellValue('D'.$row_count, "Statute Name")

        ->setCellValue('E'.$row_count, "Due Date")

        ->setCellValue('F'.$row_count, "Payment")

        ->setCellValue('G'.$row_count, "Responsible Person")

        ->setCellValue('H'.$row_count, "Description")
        ->setCellValue('I'.$row_count, "Date_Complied on");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$query = "select * from other_complaince_master where 1 ";
if($till_date != ''){
  $till_date = get_date_db($till_date);
  $query .= " and comp_date <= '$till_date'";
}
$sq_query = mysql_query($query);

$count = 1;
while($row_query = mysql_fetch_assoc($sq_query)){


  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, $row_query['comp_name'])

        ->setCellValue('D'.$row_count, $row_query['under_statue'])

        ->setCellValue('E'.$row_count, get_date_user($row_query['due_date']))

        ->setCellValue('F'.$row_count, $row_query['payment'])

        ->setCellValue('G'.$row_count, $row_query['resp_person'])

        ->setCellValue('H'.$row_count, $row_query['description'])
        ->setCellValue('I'.$row_count, ($row_query['comp_date'] == '0000-00-00') ? 'NA' : get_date_user($row_query['comp_date']));



  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':I'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="Other Compliances('.date('d-m-Y H:i:s').').xls"');

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

