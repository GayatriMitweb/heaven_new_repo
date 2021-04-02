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

$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$active_flag = $_POST['active_flag'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$branch_status = $_POST['branch_status'];
$branch_id = $_POST['branch_id'];


if($company_name == 'undefined') { $company_name = ''; }
$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_id'"));

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Customer')

            ->setCellValue('B3', 'Customer Type')

            ->setCellValue('C3', $cust_type)

            ->setCellValue('B4', 'Company Name')

            ->setCellValue('C4', $company_name)

            ->setCellValue('B5', 'Branch')

            ->setCellValue('C5', $sq_branch['branch_name'])

            ->setCellValue('B6', 'Status')

            ->setCellValue('C6', $active_flag);



$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);   
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($borderArray);   



$query = "select * from customer_master where 1 ";

if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($cust_type != ""){
	$query .=" and type = '$cust_type' ";
}
if($company_name != ""){
	$query .=" and company_name='$company_name' ";
}
if($branch_status=='yes' && $role!='Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
if($branch_id!=""){
	$query .= " and branch_admin_id = '$branch_id'";
} 
 $count = 0;

 $row_count = 9;

 $sq_customer = mysql_query($query);



$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr. No")

        ->setCellValue('C'.$row_count, "Name")

        ->setCellValue('D'.$row_count, "Type")

        ->setCellValue('E'.$row_count, "Gender")

        ->setCellValue('F'.$row_count, "Birthdate")

        ->setCellValue('G'.$row_count, "Age")

        ->setCellValue('H'.$row_count, "Mobile No")
        ->setCellValue('I'.$row_count, "Email Id")
        ->setCellValue('J'.$row_count, "Address1")
        ->setCellValue('K'.$row_count, "Address2")
        ->setCellValue('L'.$row_count, "City")
        ->setCellValue('M'.$row_count, "State")
        ->setCellValue('N'.$row_count, "Company") 
        ->setCellValue('O'.$row_count, "Landline")
        ->setCellValue('P'.$row_count, "Alt Email") 
        ->setCellValue('Q'.$row_count, "Tax No")
        ->setCellValue('R'.$row_count, "PAN No/TAN No")
        ->setCellValue('S'.$row_count, "Status");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    

$row_count++;

while($row_customer = mysql_fetch_assoc($sq_customer)){
    $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$row_customer[state_id]'"));

    $birth_date =  ($row_customer['birth_date'] == '1970-01-01') ? 'NA': get_date_user($row_customer['birth_date']);
	$contact_no = $encrypt_decrypt->fnDecrypt($row_customer['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($row_customer['email_id'], $secret_key);
    $masked_email1 =  ($row_customer['email_id'] == "") ? 'NA' : $email_id;
    $contact_no1 =  ($row_customer['contact_no'] == "") ? 'NA' : $contact_no;

    
    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)

        ->setCellValue('C'.$row_count, $row_customer['first_name'].' '.$row_customer['last_name'])

        ->setCellValue('D'.$row_count, $row_customer['type'])

        ->setCellValue('E'.$row_count, $row_customer['gender'])

        ->setCellValue('F'.$row_count, $birth_date)

        ->setCellValue('G'.$row_count, $row_customer['age'])

        ->setCellValue('H'.$row_count, $contact_no)
        ->setCellValue('I'.$row_count, $masked_email1)
        ->setCellValue('J'.$row_count, $row_customer['address'])
        ->setCellValue('K'.$row_count, $row_customer['address2'])
        ->setCellValue('L'.$row_count, $row_customer['city'])
        ->setCellValue('M'.$row_count, $sq_state['state_name'])
        ->setCellValue('N'.$row_count, $row_customer['company_name'])
        ->setCellValue('O'.$row_count, $row_customer['landline_no'])
        ->setCellValue('P'.$row_count, $row_customer['alt_email'])
        ->setCellValue('Q'.$row_count, $row_customer['service_tax_no'])
        ->setCellValue('R'.$row_count, $row_customer['pan_no'])
        ->setCellValue('S'.$row_count, $row_customer['active_flag']);

  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="Customer_Report('.date('d-m-Y H:i:s').').xls"');

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

