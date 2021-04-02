<?php


include "../../model/model.php";



/** Error reporting */

error_reporting(E_ALL);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Europe/London');



if (PHP_SAPI == 'cli')

  die('This example should only be run from a Web Browser');



/** Include PHPExcel */

require_once '../../classes/PHPExcel-1.8/Classes/PHPExcel.php';



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
$approve_status = $_GET['approve_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$active_flag = $_GET['active_flag'];
$branch_status = $_GET['branch_status'];

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

                    ->setCellValue('B2', 'Report Name')

                    ->setCellValue('C2', 'B2B Customers')

                    ->setCellValue('B3', 'Approval Status')

                    ->setCellValue('C3', $approve_status)

                    ->setCellValue('B4', 'Status')

                    ->setCellValue('C4', $active_flag);



$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray); 


$query = "select * from b2b_registration where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($approve_status!=""){
	$query .=" and approval_status='$approve_status' ";
}
$count = 0;
$row_count = 9;
$sq_customer = mysql_query($query);

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Company Name")
        ->setCellValue('D'.$row_count, "Accounting Name")
        ->setCellValue('E'.$row_count, "IATA Status")
        ->setCellValue('F'.$row_count, "IATA Reg No.")
        ->setCellValue('G'.$row_count, "Currency")
        ->setCellValue('H'.$row_count, "Telephone")
        ->setCellValue('I'.$row_count, "Turnover Slab")
        ->setCellValue('J'.$row_count, "Skype Id")
        ->setCellValue('K'.$row_count, "Website")
        ->setCellValue('L'.$row_count, "Contact Person")
        ->setCellValue('M'.$row_count, "Mobile No")
        ->setCellValue('N'.$row_count, "Email Id") 
        ->setCellValue('O'.$row_count, "Designation")
        ->setCellValue('P'.$row_count, "Address") 
        ->setCellValue('Q'.$row_count, "City")
        ->setCellValue('R'.$row_count, "Country")
        ->setCellValue('S'.$row_count, "Credit Limit")
        ->setCellValue('T'.$row_count, "Deposit")
        ->setCellValue('U'.$row_count, "Approval Status");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($borderArray);    

$row_count++;
while($row_customer = mysql_fetch_assoc($sq_customer)){
    $sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$row_customer[currency]'"));
    $sq_country = mysql_fetch_assoc(mysql_query("select * from country_list_master where country_id='$row_customer[country]'"));

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, $row_customer['company_name'])
        ->setCellValue('D'.$row_count, $row_customer['accounting_name'])
        ->setCellValue('E'.$row_count, $row_customer['iata_status'])
        ->setCellValue('F'.$row_count, $row_customer['iata_reg_no'])
        ->setCellValue('G'.$row_count, $sq_currency['currency_name'])
        ->setCellValue('H'.$row_count, $row_customer['telephone'])
        ->setCellValue('I'.$row_count, $row_customer['turnover'])
        ->setCellValue('J'.$row_count, $row_customer['skype_id'])
        ->setCellValue('K'.$row_count, $row_customer['website'])
        ->setCellValue('L'.$row_count, $row_customer['cp_first_name'].' '.$row_customer['cp_last_name'])
        ->setCellValue('M'.$row_count, $row_customer['mobile_no'])
        ->setCellValue('N'.$row_count, $row_customer['email_id'])
        ->setCellValue('O'.$row_count, $row_customer['designation'])
        ->setCellValue('P'.$row_count, $row_customer['address1'])
        ->setCellValue('Q'.$row_count, $row_customer['city'])
        ->setCellValue('R'.$row_count, $sq_country['country_name'])
        ->setCellValue('S'.$row_count, $row_customer['credit_limit'])
        ->setCellValue('T'.$row_count, $row_customer['deposite'])
        ->setCellValue('U'.$row_count, $row_customer['approval_status']);
  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($borderArray);    

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
header('Content-Disposition: attachment;filename="B2B Customers Report('.date('d-m-Y H:i:s').').xls"');
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

