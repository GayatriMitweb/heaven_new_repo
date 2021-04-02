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



$ledger_name = $_GET['ledger_name'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$role = $_GET['role'];

if($ledger_name != ''){
  $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$ledger_name'"));
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

           ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Negative Ledgers')

            ->setCellValue('B3', 'Ledger Name')

            ->setCellValue('C3', $sq_ledger['ledger_name']);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$count = 0;
$row_count = 5;   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")

        ->setCellValue('C'.$row_count, "Ledger")

        ->setCellValue('D'.$row_count, "Date")

        ->setCellValue('E'.$row_count, "Balance")

        ->setCellValue('F'.$row_count, "DR/CR");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$count = 1;
$query = "select * from ledger_master where 1 ";
if($ledger_name != ''){
  $query .= " and ledger_id='$ledger_name'";
}

$sq_ledger_info = mysql_query($query);
while($row_ledger = mysql_fetch_assoc($sq_ledger_info))
{
  $total_debit = ($sq_ledger_info['dr_cr']=='Dr') ? $sq_ledger_info['balance'] : '0';
  $total_credit = ($sq_ledger_info['dr_cr']=='Cr') ? $sq_ledger_info['balance'] : '0';
  $balance = 0;
  $payment_date = '';
  $query1 = "select * from finance_transaction_master where gl_id='$row_ledger[ledger_id]' and financial_year_id='$financial_year_id'";
  if($branch_status=='yes'){
    if($role=='Branch Admin'){
    $query1 .= " and branch_admin_id = '$branch_admin_id'";
    } 
    elseif($role!='Admin' && $role!='Branch Admin'){
      $query1 .= " and emp_id='$emp_id'";
      }
  }   
  $sq_le_name = mysql_query($query1);  
  while($row_finance = mysql_fetch_assoc($sq_le_name))
  {
    $payment_date = get_date_user($row_finance['payment_date']);
    if($row_finance['payment_side'] == 'Debit'){
      $total_debit += $row_finance['payment_amount'];
    } 
    else{
      $total_credit += $row_finance['payment_amount'];
    }
  }//while close
  if($total_debit>$total_credit && $row_ledger['dr_cr'] == 'Cr'){
        $balance =  $total_debit - $total_credit;

        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, $row_ledger['ledger_name'])

        ->setCellValue('D'.$row_count, $payment_date)

        ->setCellValue('E'.$row_count, number_format($balance,2))

        ->setCellValue('F'.$row_count, 'DR');

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);  
  $row_count++;

  }
  if($total_debit<$total_credit && $row_ledger['dr_cr'] == 'Dr'){
        $balance =  $total_credit - $total_debit;

        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, $row_ledger['ledger_name'])

        ->setCellValue('D'.$row_count, $payment_date)

        ->setCellValue('E'.$row_count, number_format($balance,2))

        ->setCellValue('F'.$row_count, 'CR');

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);  
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

header('Content-Disposition: attachment;filename="Negative Ledgers Report('.date('d-m-Y H:i:s').').xls"');

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

