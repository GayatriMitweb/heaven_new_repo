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

$till_date = $_GET['till_date'];
$vendor_type = $_GET['vendor_type'];
$vendor_type_id = $_GET['vendor_type_id'];
$branch_status = $_GET['branch_status'];
$role = $_GET['role'];
$branch_admin_id = $_GET['branch_admin_id'];
$till_date1 = get_date_user($till_date);

if($till_date != '' && $till_date != ''){
  $till_date = get_date_user($till_date);
  $date_string = $till_date; 
}else{
  $date_string = '';
}
if($customer_id != ''){
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $customer_name = ($sq_cust['type'] == 'Corporate') ? $sq_cust['company_name'] : $sq_cust['first_name'].' '.$sq_cust['last_name']; 
}
if($vendor_type_id != ''){
  $supplier_name = get_vendor_name_report($vendor_type, $vendor_type_id);
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Payables Ageing')

            ->setCellValue('B3', 'Till Date')

            ->setCellValue('C3', $date_string)

            ->setCellValue('B4', 'Supplier Type')

            ->setCellValue('C4', $vendor_type)

            ->setCellValue('B5', 'Supplier Type ID')
            ->setCellValue('C5', $supplier_name);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);     

$row_count = 7;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Supplier Type")
        ->setCellValue('D'.$row_count, "Supplier Name")
        ->setCellValue('E'.$row_count, "Total Outstanding")
        ->setCellValue('F'.$row_count, "Not Due")
        ->setCellValue('G'.$row_count, "Total Due")
        ->setCellValue('H'.$row_count, "0_To_30")
        ->setCellValue('I'.$row_count, "31_To_60")
        ->setCellValue('J'.$row_count, "61_To_90")
        ->setCellValue('K'.$row_count, "91_To_120")
        ->setCellValue('L'.$row_count, "121_To_180")
        ->setCellValue('M'.$row_count, "181_To_360")
        ->setCellValue('N'.$row_count, "361_&_above");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 1;
$total_outstanding_total = 0; $not_due_total = 0; $total_due_total = 0;
$group1_total = 0; $group2_total = 0; $group3_total=0; $group4_total=0; $group5_total=0; $group6_total=0; $group7_total=0;

$query = "select * from vendor_estimate where 1 ";
if($vendor_type != ''){
  $query .= " and vendor_type = '$vendor_type' ";
}
if($vendor_type_id != ''){
  $query .= " and vendor_type_id='$vendor_type_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}

$query .= " group by vendor_type, vendor_type_id";
$sq_supplier = mysql_query($query);
while($row_supplier = mysql_fetch_assoc($sq_supplier))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
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

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due = $pending_amt;
        $total_due = 0;   
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,'0'); 
        array_push($not_due_arr,$pending_amt);
        array_push($total_days_arr,'NA'); 
      }    
    }
    else{
      $not_due = 0;
        //////get total days count////
        $date1_ts = strtotime($till_date1);
      $date2_ts = strtotime($due_date);
      $diff = $date1_ts - $date2_ts;
      $total_days = round($diff / 86400);
        //////////////////////////////
        if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
        if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
        if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
        if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
        if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
        if($total_days>'360'){ $group7  += $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }
    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding = $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['estimate_id']); 
    array_push($due_date_arr,$row_package['due_date']);
  } 
  }
  $supplier_name = get_vendor_name_report($row_supplier['vendor_type'], $row_supplier['vendor_type_id']);
  
  if($total_outstanding>'0'){
    $total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
    $group7_total += $group7;
    
      $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('B'.$row_count, $count++)
          ->setCellValue('C'.$row_count, $row_supplier['vendor_type'])
          ->setCellValue('D'.$row_count, $supplier_name)
          ->setCellValue('E'.$row_count, number_format($total_outstanding,2))
          ->setCellValue('F'.$row_count, number_format($not_due,2))
          ->setCellValue('G'.$row_count, number_format($total_due,2))
          ->setCellValue('H'.$row_count, number_format($group1,2))
          ->setCellValue('I'.$row_count, number_format($group2,2))
          ->setCellValue('J'.$row_count, number_format($group3,2))
          ->setCellValue('K'.$row_count, number_format($group4,2))
          ->setCellValue('L'.$row_count, number_format($group5,2))
          ->setCellValue('M'.$row_count, number_format($group6,2))
          ->setCellValue('N'.$row_count, number_format($group7,2));

      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($content_style_Array);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);
    $row_count++; 
  }

}
$objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('B'.$row_count, '')
          ->setCellValue('C'.$row_count, '')
          ->setCellValue('D'.$row_count, 'Total')
          ->setCellValue('E'.$row_count, number_format($total_outstanding_total,2))
          ->setCellValue('F'.$row_count, number_format($not_due_total,2))
          ->setCellValue('G'.$row_count, number_format($total_due_total,2))
          ->setCellValue('H'.$row_count, number_format($group1_total,2))
          ->setCellValue('I'.$row_count, number_format($group2_total,2))
          ->setCellValue('J'.$row_count, number_format($group3_total,2))
          ->setCellValue('K'.$row_count, number_format($group4_total,2))
          ->setCellValue('L'.$row_count, number_format($group5_total,2))
          ->setCellValue('M'.$row_count, number_format($group6_total,2))
          ->setCellValue('N'.$row_count, number_format($group7_total,2));

      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($header_style_Array);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);
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

header('Content-Disposition: attachment;filename="Payables Ageing Report('.date('d-m-Y H:i:s').').xls"');

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

