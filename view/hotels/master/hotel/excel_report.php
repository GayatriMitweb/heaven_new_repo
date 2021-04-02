<?php

include "../../../../model/model.php";



/** Error reporting */

error_reporting(E_ALL);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Europe/London');



if (PHP_SAPI == 'cli')

  die('This example should only be run from a Web Browser');



/** Include PHPExcel */

require_once '../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';



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

$active_flag = $_GET['active_flag'];
$city_id = $_GET['city_id'];

if($city_id!=""){
  $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$city_id'"));
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Hotel Supplier')

            ->setCellValue('B3', 'City Name')

            ->setCellValue('C3', $sq_city['city_name'])

            ->setCellValue('B4', 'Status')

            ->setCellValue('C4', $active_flag);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);    

$query = "select * from hotel_master where 1 ";

if($active_flag!=""){
  $query .=" and active_flag='$active_flag' ";
}

if($city_id!=""){
  $query .=" and city_id='$city_id' ";
}

 $count = 0;

 $row_count = 9;

 $sq_hotel = mysql_query($query);



$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr. No")

        ->setCellValue('C'.$row_count, "City Name")

        ->setCellValue('D'.$row_count, "Hotel Name")
        ->setCellValue('E'.$row_count, "Mobile No")
        ->setCellValue('F'.$row_count, "Landline")
        ->setCellValue('G'.$row_count, "Email ID")
        ->setCellValue('H'.$row_count, "Contact Person")
        ->setCellValue('I'.$row_count, "Emergency Contact")
        ->setCellValue('J'.$row_count, "Address")
        ->setCellValue('K'.$row_count, "State")
        ->setCellValue('L'.$row_count, "Country") 
        ->setCellValue('M'.$row_count, "Website")
        ->setCellValue('N'.$row_count, "Bank Name")
        ->setCellValue('O'.$row_count, "Account Name")
        ->setCellValue('P'.$row_count, "Account No")
        ->setCellValue('Q'.$row_count, "Branch")
        ->setCellValue('R'.$row_count, "IFSC/Swift Code")
        ->setCellValue('S'.$row_count, "PAN/TAN No")
        ->setCellValue('T'.$row_count, "Tax NO")
        ->setCellValue('U'.$row_count, "Hotel Type")
        ->setCellValue('V'.$row_count, "Child Without Bed From-To Age")
        ->setCellValue('W'.$row_count, "Child With Bed From-To Age")
        ->setCellValue('X'.$row_count, "Status");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($borderArray);    

$row_count++;

while($row_hotel = mysql_fetch_assoc($sq_hotel)){
	  $mobile_no = $encrypt_decrypt->fnDecrypt($row_hotel['mobile_no'], $secret_key);
      $email_id = $encrypt_decrypt->fnDecrypt($row_hotel['email_id'], $secret_key);
      $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_hotel[city_id]'"));
      $sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_hotel[gl_id]'"));
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$row_hotel[state_id]'"));
    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, $sq_city['city_name'])
        ->setCellValue('D'.$row_count, $row_hotel['hotel_name'])
        ->setCellValue('E'.$row_count, $mobile_no)
        ->setCellValue('F'.$row_count, $row_hotel['landline_no'])
        ->setCellValue('G'.$row_count, $email_id)
        ->setCellValue('H'.$row_count, $row_hotel['contact_person_name'])
        ->setCellValue('I'.$row_count, $row_hotel['immergency_contact_no'])
        ->setCellValue('J'.$row_count, $row_hotel['hotel_address'])
        ->setCellValue('K'.$row_count, $sq_state['state_name'])
        ->setCellValue('L'.$row_count, $row_hotel['country'])
        ->setCellValue('M'.$row_count, $row_hotel['website'])
        ->setCellValue('N'.$row_count, $row_hotel['bank_name'])
        ->setCellValue('O'.$row_count, $row_hotel['account_name'])
        ->setCellValue('P'.$row_count, $row_hotel['account_no'])
        ->setCellValue('Q'.$row_count, $row_hotel['branch'])
        ->setCellValue('R'.$row_count, $row_hotel['ifsc_code'])
        ->setCellValue('S'.$row_count, $row_hotel['pan_no'])
        ->setCellValue('T'.$row_count, $row_hotel['service_tax_no'])
        ->setCellValue('U'.$row_count, $row_hotel['rating_star'])
        ->setCellValue('V'.$row_count, $row_hotel['cwob_from'].'-'.$row_hotel['cwob_to'])
        ->setCellValue('W'.$row_count, $row_hotel['cwb_from'].'-'.$row_hotel['cwb_to'])
        ->setCellValue('X'.$row_count, $row_hotel['active_flag']);

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="Hotel_Supplier('.date('d-m-Y H:i:s').').xls"');

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

