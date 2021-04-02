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
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_GET['branch_status'];
$emp_id = $_SESSION['emp_id'];
$customer_id = $_GET['customer_id'];

$booking_id = $_GET['booking_id'];

$from_date = $_GET['from_date'];

$to_date = $_GET['to_date'];

$cust_type = $_GET['cust_type'];

$company_name = $_GET['company_name'];



if($customer_id!=""){

  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

  $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name'];

}

else{

  $cust_name = "";

}

if($booking_id!=""){
  $query = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $date = $query['booking_date'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $invoice_id =  get_package_booking_id($booking_id,$year);
}



if($from_date!="" && $to_date!=""){

    $date_str = $from_date.' to '.$to_date;

}

else{

    $date_str = "";

}

if($company_name == 'undefined') { $company_name = ''; }



// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Package Booking')

            ->setCellValue('B3', 'Customer Name')

            ->setCellValue('C3', $cust_name)

            ->setCellValue('B4', 'Booking ID')

            ->setCellValue('C4', $invoice_id)

            ->setCellValue('B5', 'From-To-Date')

            ->setCellValue('C5', $date_str)

            ->setCellValue('B6', 'Customer Type')

            ->setCellValue('C6', $cust_type)

            ->setCellValue('B7', 'Company Name')

            ->setCellValue('C7', $company_name);

             

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



$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($borderArray);



$query = "select * from package_tour_booking_master where financial_year_id='$financial_year_id'";

    if($customer_id!=""){

      $query .=" and customer_id='$customer_id'";

    }

    if($booking_id!=""){

      $query .=" and booking_id='$booking_id'";

    }

    if($from_date!="" && $to_date!=""){

      $from_date = get_date_db($from_date);

      $to_date = get_date_db($to_date);



      $query .= " and date(booking_date) between '$from_date' and '$to_date'";

    }

     if($cust_type != ""){

      $query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";

    }

    if($company_name != ""){

      $query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";

    }
    if($branch_status=='yes'){
      if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
        $query .= " and branch_admin_id = '$branch_admin_id'";
      }
      elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
        $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
      }
    }
    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
      $query .= " and emp_id='$emp_id'";
    }
   
    $query .= ' order by booking_id desc';

$count = 0;

$row_count = 9;

   

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Tour")
        ->setCellValue('E'.$row_count, "Group")
        ->setCellValue('F'.$row_count, "Customer Name")
        ->setCellValue('G'.$row_count, "Total PAX")
        ->setCellValue('H'.$row_count, "Train Amount")
        ->setCellValue('I'.$row_count, "Flight Amount")
        ->setCellValue('J'.$row_count, "Cruise Amount")
        ->setCellValue('K'.$row_count, "Basic Amount") 
        ->setCellValue('L'.$row_count, "Service Charge")
        ->setCellValue('M'.$row_count, "Credit chard Charges")
        ->setCellValue('N'.$row_count, "Tax Amount")
        ->setCellValue('O'.$row_count, "Total Amount")
        ->setCellValue('P'.$row_count, "Paid Amount")
        ->setCellValue('Q'.$row_count, "Balance Amount")
        ->setCellValue('R'.$row_count, "Due Date")
        ->setCellValue('S'.$row_count, "Created By");



$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($borderArray);    



$row_count++;

$sq_booking = mysql_query($query);

    while($row_booking = mysql_fetch_assoc($sq_booking)){
			$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_booking[emp_id]'"));
      $emp_name = ($row_booking['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

      $sq_total_members = mysql_num_rows(mysql_query("select traveler_id from package_travelers_details where booking_id='$row_booking[booking_id]'"));

      $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
      if($sq_customer['type']=='Corporate'){
        $customer_name = $sq_customer['company_name'];
      } else{
        $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
      }

      $total_rooms= ($row_booking['required_rooms']!="") ? $row_booking['required_rooms']: 0;
      $total_travel_amount = $row_booking['total_train_expense'] + $row_booking['total_plane_expense'];
      $visa_total_amount= ($row_booking['visa_total_amount']!="") ? $row_booking['visa_total_amount']: 0.00;
      $insuarance_total_amount= ($row_booking['insuarance_total_amount']!="") ? $row_booking['insuarance_total_amount']: 0.00;

      //Tour TOtal
      $tour_amount= ($row_booking['total_hotel_expense']!="") ? $row_booking['total_hotel_expense']: 0;

      $sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
      $can_amount = $sq_tour_refund['cancel_amount'];

      $total_tour_amount = $tour_amount - $can_amount ;
      //Travel Total 
      $travel_amount= ($row_booking['total_travel_expense']!="") ? $row_booking['total_travel_expense']: 0;

      $sq_tour_refund = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
      $can_amount = $sq_tour_refund['total_refund'] - ($sq_tour_refund['total_visa_amount'] + $sq_tour_refund['total_insuarance_amount'] + $sq_tour_refund['total_tour_amount']);

      $sq_credit = mysql_fetch_assoc(mysql_query("SELECT sum(`credit_charges`) as sumc FROM `package_payment_master` WHERE `booking_id`='$row_booking[booking_id]' and clearance_status != 'Pending' and `clearance_status`!='Cancelled'"));

      $total_travel_amount = $travel_amount - $can_amount;
      $total_tour_amount = $tour_amount - $can_amount;

      $total_booking_amt = $row_booking['net_total']  + $sq_credit['sumc'];
      //$total_tour_amount = $total_booking_amt - $cancel_amount;

      $sq_paid = mysql_fetch_assoc(mysql_query("select sum(amount) as paid_amount from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status !='Pending' and clearance_status !='Cancelled'"));
      $balance_amount = $total_booking_amt - $sq_paid['paid_amount'];



      $date = $row_booking['booking_date'];
      $yr = explode("-", $date);
      $year =$yr[0];

      
      $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)

        ->setCellValue('C'.$row_count, get_package_booking_id($row_booking['booking_id'],$year))

        ->setCellValue('D'.$row_count, $row_booking['tour_name'])

        ->setCellValue('E'.$row_count,get_date_user($row_booking['tour_from_date']).' to '.get_date_user($row_booking['tour_to_date']))

        ->setCellValue('F'.$row_count, $customer_name)
        ->setCellValue('G'.$row_count, $sq_total_members)
        ->setCellValue('H'.$row_count, number_format($row_booking['total_train_expense'],2))
        ->setCellValue('I'.$row_count, number_format($row_booking['total_plane_expense'],2))
        ->setCellValue('J'.$row_count, number_format($row_booking['total_cruise_expense'],2))
        ->setCellValue('K'.$row_count, number_format($row_booking['basic_amount'],2))
        ->setCellValue('L'.$row_count, number_format($row_booking['service_charge'], 2))
        ->setCellValue('M'.$row_count, number_format( $sq_credit['sumc'], 2))
        ->setCellValue('N'.$row_count, $row_booking['tour_service_tax_subtotal'])
        ->setCellValue('O'.$row_count, number_format($total_booking_amt, 2))
        ->setCellValue('P'.$row_count, number_format($sq_paid['paid_amount'], 2))
        ->setCellValue('Q'.$row_count, number_format($balance_amount, 2))
        ->setCellValue('R'.$row_count,  ($row_booking['due_date']=='1970-01-01') ? 'NA' : date('d-m-Y',strtotime($row_booking['due_date'])))
        ->setCellValue('S'.$row_count,$emp_name);




  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':T'.$row_count)->applyFromArray($content_style_Array);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':T'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="Package Booking('.date('d-m-Y H:i:s').').xls"');

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

