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

$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$financial_year_id = $_SESSION['financial_year_id'];

if($from_date != '' && $to_date != ''){
  $date = $from_date.' To '.$to_date;
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Journal Entries')

            ->setCellValue('B3', 'From-To Date')

            ->setCellValue('C3', $date);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$row_count = 6;

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "JV ID")
        ->setCellValue('D'.$row_count, "Date")
        ->setCellValue('E'.$row_count, "Particulars")
        ->setCellValue('F'.$row_count, "Dr_Cr")
        ->setCellValue('G'.$row_count, "Narration")
        ->setCellValue('H'.$row_count, "Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    



$row_count++;

$query = "select * from journal_entry_master where financial_year_id='$financial_year_id' ";
if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and entry_date between '$from_date' and '$to_date' ";
}
$count = 0;
$total_dr = 0; $total_cr = 0;
$sq_journal = mysql_query($query);
while($row_journal = mysql_fetch_assoc($sq_journal)){
  $date = $row_journal['entry_date'];
  $yr = explode("-", $date);
  $year =$yr[0];
    $sq_journal_entry = mysql_fetch_assoc(mysql_query("select * from journal_entry_accounts where entry_id='$row_journal[entry_id]' limit 1"));		
    $sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$sq_journal_entry[ledger_id]'"));
        $sq_journal_debit = mysql_fetch_assoc(mysql_query("select sum(amount) as amount from journal_entry_accounts where type = 'Debit' and entry_id='$row_journal[entry_id]'"));
        $total_cr += $sq_journal_debit['amount'];
          $objPHPExcel->setActiveSheetIndex(0)

              ->setCellValue('B'.$row_count, ++$count)
              ->setCellValue('C'.$row_count, get_jv_entry_id($row_journal['entry_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_journal['entry_date']))
              ->setCellValue('E'.$row_count, $sq_ledger['ledger_name'])
              ->setCellValue('F'.$row_count, $sq_journal_entry['type'])
              ->setCellValue('G'.$row_count, $row_journal['narration'])
              ->setCellValue('H'.$row_count, number_format($sq_journal_debit['amount'],2));
        
        

        
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);    

        $row_count++;
    }
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, '')
        ->setCellValue('E'.$row_count, '')
        ->setCellValue('F'.$row_count, '')
        ->setCellValue('G'.$row_count, 'Total Debit '.number_format($total_cr,2))
        ->setCellValue('H'.$row_count, 'Total Credit '.number_format($total_cr,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':H'.$row_count)->applyFromArray($borderArray);

  



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

header('Content-Disposition: attachment;filename="Journal_Entries('.date('d-m-Y H:i:s').').xls"');

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

