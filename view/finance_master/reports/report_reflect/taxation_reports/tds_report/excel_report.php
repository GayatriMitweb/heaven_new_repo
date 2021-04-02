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



$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$branch_status = $_GET['branch_status'];
$role = $_GET['role'];
$branch_admin_id = $_GET['branch_admin_id'];

if($from_date != '' || $to_date != ''){
  $date_str = $from_date.' To '.$to_date;
}

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

           ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'TDS Receivable')

            ->setCellValue('B3', 'Date')

            ->setCellValue('C3', $date_str);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    



$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$count = 0;
$row_count = 6;   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")

        ->setCellValue('C'.$row_count, "Booking_Date")

        ->setCellValue('D'.$row_count, "Customer_Name")

        ->setCellValue('E'.$row_count, "PAN_Number/TAN_Number")

        ->setCellValue('F'.$row_count, "TDS_deducted_on_amount")

        ->setCellValue('G'.$row_count, "TDS_Deducted");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 1;
 //Hotel
 $query = "select * from hotel_booking_master where 1 ";
 if($from_date != '' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date'";    
 }
 if($branch_status=='yes'){
    if($role=='Branch Admin'){
    $query .= " and branch_admin_id = '$branch_admin_id'";
    } 
    elseif($role!='Admin' && $role!='Branch Admin'){
      $query .= " and emp_id='$emp_id'";
      }
 }
 $sq_query = mysql_query($query);
 while($row_query = mysql_fetch_assoc($sq_query))
 {
  //Total hotels count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

  //Cancelled hotels count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
    if($sq_cust['type'] == 'Corporate'){
      $cust_name = $sq_cust['company_name'];
    }else{
      $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    }
    $tds_on_amount = $row_query['sub_total'] + $row_query['service_charge'];
    if($row_query['tds'] != '0'){   

  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, get_date_user($row_query['created_at']))

        ->setCellValue('D'.$row_count, $cust_name)

        ->setCellValue('E'.$row_count, ($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'])

        ->setCellValue('F'.$row_count, number_format($tds_on_amount,2))

        ->setCellValue('G'.$row_count, number_format($row_query['tds'],2));



  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    



    $row_count++;

  }
  }
}

//Flight
$tds_on_amount = 0;
$query = "select * from ticket_master where 1 ";
if($from_date != '' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date'";    
}

if($branch_status=='yes'){
    if($role=='Branch Admin'){
      $query .= " and branch_admin_id = '$branch_admin_id'";
    } 
    elseif($role!='Admin' && $role!='Branch Admin'){
      $query .= " and emp_id='$emp_id'";
    }
}

$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
//Total passenger count
$sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]'"));

//Cancelled passenger count
$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]' and status ='Cancel'"));
if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
{
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
  if($sq_cust['type'] == 'Corporate'){
    $cust_name = $sq_cust['company_name'];
  }else{
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  }
  $tds_on_amount = $row_query['basic_cost'] + $row_query['basic_cost_markup'] - $row_query['basic_cost_discount'] + $row_query['yq_tax']+ $row_query['yq_tax_markup'] - $row_query['yq_tax_discount'] + $row_query['g1_plus_f2_tax'] + $row_query['service_charge'];  
  if($row_query['tds'] != '0'){
 $objPHPExcel->setActiveSheetIndex(0)

  ->setCellValue('B'.$row_count, $count++)

  ->setCellValue('C'.$row_count, get_date_user($row_query['created_at']))

  ->setCellValue('D'.$row_count, $cust_name)

  ->setCellValue('E'.$row_count, ($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'])

  ->setCellValue('F'.$row_count, number_format($tds_on_amount,2))

  ->setCellValue('G'.$row_count, number_format($row_query['tds'],2));



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    



$row_count++;

}
}
}
//Other Income
$query = "select * from other_income_master where 1 ";
if($from_date != '' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date'";    
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{     
if($row_query['tds'] != '0'){
  $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, $count++)

        ->setCellValue('C'.$row_count, get_date_user($row_query['created_at']))

        ->setCellValue('D'.$row_count, $row_query['receipt_from'])

        ->setCellValue('E'.$row_count, ($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'])

        ->setCellValue('F'.$row_count, number_format($row_query['amount'],2))

        ->setCellValue('G'.$row_count, number_format($row_query['tds'],2));



  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="TDS Receivable('.date('d-m-Y H:i:s').').xls"');

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

