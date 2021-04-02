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

 
$filter_date = $_GET['filter_date'];
$branch_admin_id = $_GET['branch_admin_id'];
$bank_id = $_GET['bank_id'];

if($filter_date != ''){
  $filter_date1 = get_date_user($filter_date);
}
if($bank_id != ''){
  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$bank_id'"));
  $bank_name = $sq_bank['bank_name'].'('.$sq_bank['branch_name'].')';
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Bank Reconciliation')
            ->setCellValue('B3', 'Bank Name')

            ->setCellValue('C3', $bank_name)
            ->setCellValue('B4', 'Date')

            ->setCellValue('C4', $filter_date1);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);      

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);     

$row_count = 7;

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, 'SR.No')
        ->setCellValue('C'.$row_count, 'Bank_Name')
        ->setCellValue('D'.$row_count, 'Reconcl_Date')
        ->setCellValue('E'.$row_count, 'Balance_as_per Books')
        ->setCellValue('F'.$row_count, 'Cheque_Deposited but_not_Cleared')
        ->setCellValue('G'.$row_count, 'Cheque_Issued but not Presented_for_Payment')
        ->setCellValue('H'.$row_count, 'Bank_Debits')
        ->setCellValue('I'.$row_count, 'Bank_Credits')
        ->setCellValue('J'.$row_count, 'Reconciliation_Amount')
        ->setCellValue('K'.$row_count, 'Balance_as_per Bank_Books')
        ->setCellValue('L'.$row_count, 'Difference_after Reconciliation');

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($borderArray); 

$row_count++;
$query = "SELECT * FROM `bank_reconcl_master` where 1 ";
if($bank_id != ''){
  $query .= " and bank_id ='$bank_id'";
}
if($filter_date != ''){
  $filter_date = get_date_db($filter_date);
  $query .= " and reconcl_date <='$filter_date'";
}
$sq_query = mysql_query($query);
$count = 1;

while($row_query = mysql_fetch_assoc($sq_query)){
  $sq_bank = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$row_query[bank_id]'"));
       
        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, $sq_bank['bank_name'].'('.$sq_bank['branch_name'].')')
        ->setCellValue('D'.$row_count, get_date_user($row_query['reconcl_date']))
        ->setCellValue('E'.$row_count, number_format($row_query['book_balance'],2))
        ->setCellValue('F'.$row_count, number_format($row_query['cheque_deposit'],2))
        ->setCellValue('G'.$row_count, number_format($row_query['cheque_payment'],2))
        ->setCellValue('H'.$row_count, number_format($row_query['bank_debit_amount'],2))
        ->setCellValue('I'.$row_count, number_format($row_query['bank_credit_amount'],2))
        ->setCellValue('J'.$row_count, number_format($row_query['reconcl_amount'],2))
        ->setCellValue('K'.$row_count, number_format($row_query['bank_book_balance'],2))
        ->setCellValue('L'.$row_count, number_format($row_query['diff_amount'],2));

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($borderArray);    

  $row_count++;

}

  $row_count++;
    
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

header('Content-Disposition: attachment;filename="Bank_Reconciliation('.date('d-m-Y H:i:s').').xls"');

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

