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

 
$asset_name = $_GET['asset_name'];
$asset_type = $_GET['asset_type'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_GET['branch_admin_id'];
$role = $_GET['role'];

if($asset_name != ''){
  $sq_asset_name = mysql_fetch_assoc(mysql_query("select * from fixed_asset_master where entry_id='$asset_name'"));
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Fixed Asset Register')

            ->setCellValue('B3', 'Asset Type')

            ->setCellValue('C3', $asset_type)

            ->setCellValue('B4', 'Asset Name')

            ->setCellValue('C4', $sq_asset_name['asset_name']);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);     

$row_count = 6;

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, 'SR.No')
        ->setCellValue('C'.$row_count, 'Asset Type')
        ->setCellValue('D'.$row_count, 'Asset Name')
        ->setCellValue('E'.$row_count, 'Asset Ledger name')
        ->setCellValue('F'.$row_count, 'Purchase Date')
        ->setCellValue('G'.$row_count, 'purchase Amount')
        ->setCellValue('H'.$row_count, 'Opening Carrying amount')
        ->setCellValue('I'.$row_count, 'Rate Of Depreciation')
        ->setCellValue('J'.$row_count, 'Depreciation')
        ->setCellValue('K'.$row_count, 'Accumulated Depreciation')
        ->setCellValue('L'.$row_count, 'Closing Carrying amount');

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($header_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':L'.$row_count)->applyFromArray($borderArray); 

$row_count++;

$count = 1;
$total_amount = 0;
$query = "SELECT * FROM `fixed_asset_entries` where 1 "; 
if($asset_type != ''){
  $query .= " and asset_id in(select entry_id from fixed_asset_master where asset_type ='$asset_type')";
}
if($asset_name != ''){
  $query .= " and asset_id in(select entry_id from fixed_asset_master where entry_id ='$asset_name')";
}
if($branch_admin_id != ''){
  $query .= " and branch_admin_id = '$branch_admin_id'";
}
if($branch_status == 'yes'){
  if($role == 'Branch Admin'){
    $query .= " and branch_admin_id='$branch_admin_id'";
  }
}
$query .= " group by asset_ledger";
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  $sq_asset = mysql_fetch_assoc(mysql_query("select * from fixed_asset_master where entry_id ='$row_query[asset_id]'"));
  $sq_depr = mysql_fetch_assoc(mysql_query("select sum(depr_till_date) as depr_till_date from fixed_asset_entries where asset_id ='$row_query[asset_id]' and asset_ledger ='$row_query[asset_ledger]'"));
  $closing_c_amount = $row_query['purchase_amount'] - $sq_depr['depr_till_date'];

  $sq_latest = mysql_fetch_assoc(mysql_query("select * from fixed_asset_entries where asset_id ='$row_query[asset_id]' and asset_ledger ='$row_query[asset_ledger]' order by entry_id desc"));
  $opening_c_amount = $closing_c_amount + $sq_latest['depr_till_date'];

  if($row_query['sold_amount'] != '0'){ $bg = 'danger'; }else{ $bg = ''; }
       
        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, $sq_asset['asset_type'])
        ->setCellValue('D'.$row_count, $sq_asset['asset_name'])
        ->setCellValue('E'.$row_count, $row_query['asset_ledger'])
        ->setCellValue('F'.$row_count, get_date_user($row_query['purchase_date']))
        ->setCellValue('G'.$row_count, $row_query['purchase_amount'])
        ->setCellValue('H'.$row_count, number_format($opening_c_amount,2))
        ->setCellValue('I'.$row_count, $row_query['rate_of_depr'])
        ->setCellValue('J'.$row_count, $row_query['depr_till_date'])
        ->setCellValue('K'.$row_count, $sq_depr['depr_till_date'])
        ->setCellValue('L'.$row_count, number_format($closing_c_amount,2));

  
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

header('Content-Disposition: attachment;filename="Fixed_Asset_Register('.date('d-m-Y H:i:s').').xls"');

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

