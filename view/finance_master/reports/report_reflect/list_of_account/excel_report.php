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

$to_date = $_GET['from_date'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$financial_year_id = $_GET['financial_year_id'];
$role = $_GET['role'];

$filter_date = get_date_user($to_date);

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'List Of Accounts')

            ->setCellValue('B3', 'Date')

            ->setCellValue('C3', $filter_date);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);     

$row_count = 5;

//////////////////// DEBIT START /////////////////////////


$objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('B'.$row_count, "Debit");


$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':B'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':B'.$row_count)->applyFromArray($borderArray);    

$row_count++;


$sq_finance = "select * from ledger_master where dr_cr='Dr'"; 
$q = mysql_query($sq_finance);
while($row_q = mysql_fetch_assoc($q))
{
      $debit_amount = 0; $credit_amount = 0;
      $total_amount = $row_q['balance'];
      //Debit Total 
      $q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit' "; 
      if($to_date!=""){
        $to_date = get_date_db($to_date);
        $q1 .=" and payment_date <= '$to_date'";  
      }   
      if($branch_status == 'yes'){
        if($role == 'Branch Admin'){
          $q1 .= " and branch_admin_id='$branch_admin_id'";
        }
      }  
      if($financial_year_id != ""){
        $q1 .=" and financial_year_id='$financial_year_id'";    
      }                  
      $sq_opening_balance = mysql_query($q1);
      while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        $debit_amount += $row_balance['payment_amount'];
      }
      //Credit Total
      $q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit' ";
      if($to_date!=""){
        $to_date = get_date_db($to_date);
        $q2 .=" and payment_date <= '$to_date'";  
      }   
      if($branch_status == 'yes'){
        if($role == 'Branch Admin'){
          $q2 .= " and branch_admin_id='$branch_admin_id'";
        }
      }  
      if($financial_year_id != ""){
        $q2 .=" and financial_year_id='$financial_year_id'";    
      }  
      $sq_opening_balance = mysql_query($q2);
      while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        $credit_amount += $row_balance['payment_amount'];
      }
      $total_amount = $total_amount + $debit_amount - $credit_amount;

      $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('B'.$row_count, $row_q['ledger_name'])
       ->setCellValue('C'.$row_count, number_format($total_amount,2));

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    

        $total_sub_group_amount += $total_amount; 
        $row_count++;
}

$row_count++;

$objPHPExcel->setActiveSheetIndex(0)

      ->setCellValue('B'.$row_count, 'Total Debit')
      ->setCellValue('C'.$row_count, number_format($total_sub_group_amount,2));


$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);  
///////////////////// DEBIT END ////////////////////////////

$row_count = 5;
//////////////////// CREDIT START /////////////////////////

$objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('E'.$row_count, "Credit");


$objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':E'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':E'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$sq_finance = "select * from ledger_master where dr_cr='Cr' and ledger_id!='165'";
		 
$q = mysql_query($sq_finance);
    while($row_q = mysql_fetch_assoc($q))
    {
      $debit_amount = 0; $credit_amount = 0; $total_amount = 0;
      if($row_q['dr_cr']=='Dr'){
        $debit_amount = $row_q['balance'];
      }else{
        $credit_amount = $row_q['balance'];
      }
      //Debit Total 
      $q1 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Debit' ";	
if($to_date!=""){
  $to_date = get_date_db($to_date);
  $q1 .=" and payment_date <= '$to_date'";	
}
if($financial_year_id != ""){
  $q1 .=" and financial_year_id='$financial_year_id'";		
}	
if($branch_status == 'yes'){
  if($role == 'Branch Admin'){
    $q1 .= " and branch_admin_id='$branch_admin_id'";
  }
}				            	
      $sq_opening_balance = mysql_query($q1);
      while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        $debit_amount += $row_balance['payment_amount'];
      }
      //Credit Total
      $q2 = "select * from finance_transaction_master where gl_id='$row_q[ledger_id]' and payment_side='Credit' ";
if($to_date!=""){
  $to_date = get_date_db($to_date);
  $q2 .=" and payment_date <= '$to_date'";	
}	
if($branch_status == 'yes'){
  if($role == 'Branch Admin'){
    $q2 .= " and branch_admin_id='$branch_admin_id'";
  }
}
if($financial_year_id != ""){
  $q2 .=" and financial_year_id='$financial_year_id'";		
}		
      $sq_opening_balance = mysql_query($q2);
      while($row_balance = mysql_fetch_assoc($sq_opening_balance)){
        $credit_amount += $row_balance['payment_amount'];
      }
      $total_amount = $total_amount + $credit_amount - $debit_amount;

      $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('E'.$row_count, $row_q['ledger_name'])
       ->setCellValue('F'.$row_count, number_format($total_amount,2));

        $objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':F'.$row_count)->applyFromArray($borderArray);  

        $total_sub_group_amount_d += $total_amount;   
        $row_count++;
}

  $row_count++;

  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('E'.$row_count, 'Total Credit')
        ->setCellValue('F'.$row_count, number_format($total_sub_group_amount_d,2));

  
  $objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('E'.$row_count.':F'.$row_count)->applyFromArray($borderArray);  
//////////////////////// CREDIT END ///////////////////////////
  
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

header('Content-Disposition: attachment;filename="List_Of_Accounts('.date('d-m-Y H:i:s').').xls"');

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

