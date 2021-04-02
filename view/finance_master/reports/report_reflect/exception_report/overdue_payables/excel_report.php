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


$vendor_type = $_GET['party_name'];
$role = $_GET['role'];
$branch_admin_id = $_GET['branch_admin_id'];
$branch_status = $_GET['branch_status'];
// Add some data

$objPHPExcel->setActiveSheetIndex(0)

           ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Overdue Payables')
            ->setCellValue('B3', 'Supplier Type')
            ->setCellValue('C3', $vendor_type);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$count = 0;
$row_count = 5;   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Supplier Type")
        ->setCellValue('D'.$row_count, "Supplier Name")

        ->setCellValue('E'.$row_count, "Overdue Amount")

        ->setCellValue('F'.$row_count, "Overdue From");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    

$row_count++;

$till_date = date('Y-m-d');
$till_date1 = get_date_user($till_date);
$count = 1;
$q = "select * from vendor_estimate where 1 ";
if($vendor_type != ''){
  $q .= " and vendor_type = '$vendor_type' ";
}
if($vendor_type_id != ''){
  $q .= " and vendor_type_id='$vendor_type_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $q .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $q .= " and emp_id='$emp_id'";
    }
}
$q .= " group by vendor_type, vendor_type_id";
$sq_supplier = mysql_query($q);
while($row_supplier = mysql_fetch_assoc($sq_supplier))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
  $due_date_arr = array();

  $sq_pacakge = mysql_query("select * from vendor_estimate where vendor_type='$row_supplier[vendor_type]' and vendor_type_id ='$row_supplier[vendor_type_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt = $row_package['net_total'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$row_package[vendor_type]' and vendor_type_id ='$row_package[vendor_type_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
    $total_paid = $total_pay['sum'];
    $cancel_est = $row_package['cancel_amount'];

    //Consider sale cancel amount
    if($cancel_est != '0'){       
      if($cancel_est <= $total_paid){
        $pending_amt  = 0;
      }
      else{
        $pending_amt =  $cancel_est - $total_paid;
      }
    }
    else{
      $pending_amt = $booking_amt-$total_paid;
    }

    
    if($pending_amt>'0'){   
      $due_date = get_date_user($row_package['due_date']);
      array_push($due_date_arr, $due_date);
      if(strtotime($till_date1) >= strtotime($due_date)) {
        $total_due += $pending_amt;
      }
    }

  }
  $supplier_name = get_vendor_name_report($row_supplier['vendor_type'], $row_supplier['vendor_type_id']);

  if($total_due>'0'){

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, $row_supplier['vendor_type'])
        ->setCellValue('D'.$row_count, $supplier_name)
        ->setCellValue('E'.$row_count, number_format($total_due,2))
        ->setCellValue('F'.$row_count, max($due_date_arr));

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

header('Content-Disposition: attachment;filename="Overdue Payables Report('.date('d-m-Y H:i:s').').xls"');

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

