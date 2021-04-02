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
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$role = $_GET['role'];

$today_date = date('Y-m-d');
$from_date = get_date_user($from_date);
$to_date = get_date_user($to_date);

if($from_date != '' && $to_date != ''){
  $filter_date = $from_date.' To '.$to_date;
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Cash Book Register')

            ->setCellValue('B3', 'Date')

            ->setCellValue('C3', $filter_date);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);     

$count = 0; $total_debit_amount = 0; $total_credit_amount = 0;

$query = "select * from bank_cash_book_master where  clearance_status!='Cancelled' and payment_type='Cash'";

if($from_date!="" && $to_date!=""){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);

  $query .=" and payment_date between '$from_date' and '$to_date'";
}
if($branch_status == 'yes'){
  if($role == 'Branch Admin'){
    $query .= " and branch_admin_id='$branch_admin_id'";
  }
}

$closing_bal = 0;
$count = 0;

$row_count = 5;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking For")
        ->setCellValue('D'.$row_count, "Booking ID")
        ->setCellValue('E'.$row_count, "Collected By")
        ->setCellValue('F'.$row_count, "Amount")
        ->setCellValue('G'.$row_count, "Payment Date")
        ->setCellValue('H'.$row_count, "Particular")
        ->setCellValue('I'.$row_count, "Debit")
        ->setCellValue('J'.$row_count, "Credit")
        ->setCellValue('K'.$row_count, "Balance");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$sq = mysql_query($query);
while($row = mysql_fetch_assoc($sq)){

  if($row['payment_side']=="Credit"){
    $credit_amount = $row['payment_amount'];  
    $debit_amount = "";
    $closing_bal = $closing_bal - $credit_amount;
  }
  if($row['payment_side']=="Debit"){
    $credit_amount = "";  
    $debit_amount = $row['payment_amount'];
    $closing_bal = $closing_bal + $debit_amount;
  }
  if($row['payment_amount'] != 0){
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row[emp_id]'"));
  $emp_name = ($row['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name']: 'Admin';
        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, $row['module_name'])
        ->setCellValue('D'.$row_count, $row['module_entry_id'])
        ->setCellValue('E'.$row_count, $emp_name)
        ->setCellValue('F'.$row_count, number_format($row['payment_amount'],2))
        ->setCellValue('G'.$row_count, get_date_user($row['payment_date']))
        ->setCellValue('H'.$row_count, $row['particular'])
        ->setCellValue('I'.$row_count, $debit_amount)
        ->setCellValue('J'.$row_count, $credit_amount)
        ->setCellValue('K'.$row_count, number_format($closing_bal, 2));

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

  $row_count++;
}
}
  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('J'.$row_count, 'Closing Balance')
        ->setCellValue('K'.$row_count, number_format($closing_bal, 2));

  
  $objPHPExcel->getActiveSheet()->getStyle('I'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('I'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    
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

header('Content-Disposition: attachment;filename="Cash_Book_Register('.date('d-m-Y H:i:s').').xls"');

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

