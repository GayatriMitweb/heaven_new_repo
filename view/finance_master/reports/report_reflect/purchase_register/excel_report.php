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

$purchase_type = $_GET['purchase_type'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$role = $_GET['role'];


if($from_date != '' && $to_date != ''){
  $from_date1 = get_date_user($from_date);
  $to_date1 = get_date_user($to_date);
  $date_string = $from_date1.' To '.$to_date1; 
}else{
  $date_string = '';
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Purchase Register')

            ->setCellValue('B3', 'Purchase Type')

            ->setCellValue('C3', $purchase_type)

            ->setCellValue('B4', 'Date')

            ->setCellValue('C4', $date_string);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);     

$count = 0;
$total_amount = 0;
$query = "SELECT * FROM `ledger_master` WHERE `group_sub_id` = '87'"; 
$sq_query = mysql_query($query);

$row_count = 6;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Purchase Type")
        ->setCellValue('D'.$row_count, "Supplier type")
        ->setCellValue('E'.$row_count, "Supplier Name")
        ->setCellValue('F'.$row_count, "Purchase ID")
        ->setCellValue('G'.$row_count, "Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$count = 1;
  $total_amount = 0;
  $query = "SELECT * FROM `ledger_master` WHERE `group_sub_id` in(select subgroup_id from subgroup_master where group_id='3' and subgroup_id not in('27','32','37','45','49','56','73','79','95','101','108','109','110'))"; 
  $sq_query = mysql_query($query);
  while($row_query = mysql_fetch_assoc($sq_query))
  {
    $f_query = "select * from finance_transaction_master where gl_id='$row_query[ledger_id]' and row_specification = 'purchase' ";
    if($from_date != '' && $to_date != ''){
      $from_date = get_date_db($from_date);
      $to_date = get_date_db($to_date);
      $f_query .= " and payment_date between '$from_date' and '$to_date'";
    }
    if($purchase_type != ''){
      $f_query .= " and module_name = '$purchase_type'";
    }
    if($branch_status == 'yes'){
      if($role == 'Branch Admin'){
        $f_query .= " and branch_admin_id='$branch_admin_id'";
      }
    }
    $sq_finance = mysql_query($f_query);
    while($row_finance = mysql_fetch_assoc($sq_finance)){
      $total_amount += $row_finance['payment_amount'];
      $supplier_info_arr = get_supplier_info($row_finance['module_name'], $row_finance['module_entry_id']);     
      $supplier_name = get_vendor_name_report($row_finance['module_name'],$supplier_info_arr['vendor_type_id']);    
            
        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, ($supplier_info_arr['estimate_type'] == '') ? 'NA' : $supplier_info_arr['estimate_type'])
        ->setCellValue('D'.$row_count, $row_finance['module_name'])
        ->setCellValue('E'.$row_count, ($supplier_name == '') ? 'NA' : $supplier_name)
        ->setCellValue('F'.$row_count, $row_finance['module_entry_id'])
        ->setCellValue('G'.$row_count, number_format($row_finance['payment_amount'],2));

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

  $row_count++;
}
}

  $row_count++;

  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, '')
        ->setCellValue('C'.$row_count, '')
        ->setCellValue('D'.$row_count, '')
        ->setCellValue('E'.$row_count, '')
        ->setCellValue('F'.$row_count, 'Total')
        ->setCellValue('G'.$row_count, number_format($total_amount,2));

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    
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

header('Content-Disposition: attachment;filename="Purchase_Register('.date('d-m-Y H:i:s').').xls"');

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

