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
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$role = $_GET['role'];
$role_id = $_POST['role_id'];

$today_date = date('Y-m-d');
$filter_date = get_date_user($from_date);

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Day Book Register')

            ->setCellValue('B3', 'Date')

            ->setCellValue('C3', $filter_date);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);

$count = 0; $total_debit_amount = 0; $total_credit_amount = 0;
$query = "select * from finance_transaction_master where 1 and gl_id != '165' and gl_id != '0'";
if($from_date != ''){
  $from_date = get_date_db($from_date);
  $query .= " and payment_date='$from_date'";
}
else{
  $query .= " and payment_date='$today_date'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$sq_query = mysql_query($query);

$row_count = 5;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Particulars")
        ->setCellValue('D'.$row_count, "Description")
        ->setCellValue('E'.$row_count, "Debit")
        ->setCellValue('F'.$row_count, "Credit");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    

$row_count++;

while($row_query = mysql_fetch_assoc($sq_query))
{
        $debit_amount = 0; $credit_amount = 0;
        $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[gl_id]'"));
        if($row_query['payment_side'] == 'Debit'){ $debit_amount = $row_query['payment_amount']; }
        else{ $credit_amount = $row_query['payment_amount']; }
        $debit_amount = ($debit_amount == '0') ? '' : $debit_amount;
        $credit_amount = ($credit_amount == '0') ? '' : $credit_amount;
        $total_debit_amount += $debit_amount;
        $total_credit_amount += $credit_amount;
       
				if($row_query['payment_amount'] != '0'){
          $objPHPExcel->setActiveSheetIndex(0)

          ->setCellValue('B'.$row_count, ++$count)
          ->setCellValue('C'.$row_count, $sq_ledger['ledger_name'])
          ->setCellValue('D'.$row_count, $row_query['type'])
          ->setCellValue('E'.$row_count, $debit_amount)
          ->setCellValue('F'.$row_count, $credit_amount);  
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    

          $row_count++;
      }

}

  $row_count++;

  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, '')
        ->setCellValue('C'.$row_count, '')
        ->setCellValue('D'.$row_count, 'Total')
        ->setCellValue('E'.$row_count, number_format($total_debit_amount,2))
        ->setCellValue('F'.$row_count, number_format($total_credit_amount,2));

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    
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

header('Content-Disposition: attachment;filename="Day_Book_Register('.date('d-m-Y H:i:s').').xls"');

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

