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
$customer_id = $_GET['customer_id'];
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

// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Receivables Ageing')

            ->setCellValue('B3', 'Till Date')

            ->setCellValue('C3', $date_string)

            ->setCellValue('B4', 'Customer')

            ->setCellValue('C4', $customer_name);


$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);     

$row_count = 6;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Customer Name")
        ->setCellValue('D'.$row_count, "Booking Type")
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

//FIT
$query = "select * from package_tour_booking_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from package_tour_booking_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['total_travel_expense']+$row_package['actual_tour_expense'];
    $cancel_est1=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$row_package[booking_id]'"));
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
    $total_paid = $total_pay['sum'];
    $cancel_est = $cancel_est1['cancel_amount'];

    //Consider sale cancel amount
    if($cancel_est != ''){      
      if($cancel_est <= $total_paid){
        $pending_amt  = 0;
      }
      else{
        $pending_amt =  $cancel_est - $total_paid;
      }
    }
    else{
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
        if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['booking_id']);
    array_push($due_date_arr,$row_package['due_date']); } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Package Booking')
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

//Visa
$query = "select * from visa_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from visa_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['visa_total_cost'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from visa_payment_master where visa_id='$row_package[visa_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['visa_id']);  
    array_push($due_date_arr,$row_package['due_date']); } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Visa Booking')
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
//Miscellaneous
$query = "select * from miscellaneous_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from miscellaneous_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['misc_total_cost'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from miscellaneous_payment_master where misc_id='$row_package[misc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['misc_id']);  
    array_push($due_date_arr,$row_package['due_date']); } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Miscellaneous Booking')
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
//Flight Ticket
$query = "select * from ticket_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from ticket_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['ticket_total_cost'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from ticket_payment_master where ticket_id='$row_package[ticket_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>='0' && $total_days<='30') { $group1 += $pending_amt; } 
        if($total_days>'30' && $total_days<='60') { $group2 += $pending_amt; } 
        if($total_days>'60' && $total_days<='90') { $group3 += $pending_amt;} 
        if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
        if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
      array_push($booking_id_arr,$row_package['ticket_id']);   
      array_push($due_date_arr,$row_package['due_date']);
      } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Ticket Booking')
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

//Train
$query = "select * from train_ticket_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from train_ticket_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['net_total'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$row_package[train_ticket_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['payment_due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>='0' && $total_days<='30') { $group1 += $pending_amt; } 
        if($total_days>'30' && $total_days<='60') { $group2 += $pending_amt; } 
        if($total_days>'60' && $total_days<='90') { $group3 += $pending_amt;} 
        if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
        if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
      array_push($booking_id_arr,$row_package['train_ticket_id']);  
      array_push($due_date_arr,$row_package['payment_due_date']);
      } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Train Booking')
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

//Hotel
$query = "select * from hotel_booking_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from hotel_booking_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['total_fee'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['booking_id']); 
    array_push($due_date_arr,$row_package['due_date']);} 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Hotel Booking')
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

//Bus
$query = "select * from bus_booking_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from bus_booking_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['net_total'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['created_at']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['booking_id']); 
    array_push($due_date_arr,$row_package['created_at']); } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Bus Booking')
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
//Car Rental
$query = "select * from car_rental_booking where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from car_rental_booking where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['total_fees'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from car_rental_payment where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
      array_push($booking_id_arr,$row_package['booking_id']); 
      array_push($due_date_arr,$row_package['due_date']); 
      } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Car Rental Booking')
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

//Forex
$query = "select * from forex_booking_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from forex_booking_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['net_total'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from forex_booking_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
    $total_paid = $total_pay['sum'];
    $pending_amt=$booking_amt-$total_paid;
    
    $due_date = get_date_user($row_package['created_at']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['booking_id']);
    array_push($due_date_arr,$row_package['created_at']);  } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Forex Booking')
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

//Group
$query = "select * from tourwise_traveler_details where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from tourwise_traveler_details where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_fee =0; $pending_amt=0; $total_paid = 0; $cancel_amount2 = 0; $cancel_amount = 0; $cancel_amount1 = 0; $total_outstanding = 0;
    $booking_fee=$row_package['total_travel_expense']+$row_package['total_tour_fee'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$row_package[id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
    $total_paid = $total_pay['sum'];
    // Group booking cancel
    $cancel_esti_count1=mysql_num_rows(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_package[id]'"));
    if($cancel_esti_count1 >= '1'){
      $cancel_esti1=mysql_fetch_assoc(mysql_query("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_package[id]'"));
      $cancel_amount1 = $cancel_esti1['cancel_amount'];
    }
    else{ $cancel_amount1 = 0; }
    
    //Group Tour cancel
    $cancel_tour_count2=mysql_num_rows(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_package[id]'"));
    if($cancel_tour_count2 >= '1'){
      $cancel_tour=mysql_fetch_assoc(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_package[id]'"));
      $cancel_amount2 = $cancel_tour['cancel_amount'];
    }
    else{ $cancel_amount2 = 0; }

    if($cancel_esti_count1 >= '1'){
      $cancel_amount = $cancel_amount1;
    }else{
      $cancel_amount = $cancel_amount2;
    }

    //Consider sale cancel amount
    if($cancel_amount != '0'){      
      if($cancel_est <= $total_paid){
        $pending_amt  = 0;
      }
      else{
        $pending_amt =  $cancel_amount - $total_paid;
      }
    }
    else{
      $pending_amt=$booking_fee-$total_paid;
    }

    $due_date = get_date_user($row_package['balance_due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
      array_push($booking_id_arr,$row_package['id']); 
      array_push($due_date_arr,$row_package['balance_due_date']); 
      } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Group Booking')
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

//Passport
$query = "select * from passport_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from passport_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['passport_total_cost'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from passport_payment_master where passport_id='$row_package[passport_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['passport_id']);
    array_push($due_date_arr,$row_package['due_date']); } 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Passport Booking')
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
//Excursion
$query = "select * from excursion_master where 1 ";
if($customer_id!=''){
  $query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$query .= ' group by customer_id';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking))
{ 
  $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
  $total_outstanding = 0; $not_due = 0; $total_due = 0;
  $group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

  $booking_id_arr = array();
  $pending_amt_arr = array();
  $total_days_arr = array();
  $not_due_arr = array();
  $due_date_arr = array();

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type'] == 'Corporate'){
    $customer_name = $sq_customer['company_name'];
  }
  else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];  
  }
  $sq_pacakge = mysql_query("select * from excursion_master where customer_id='$row_booking[customer_id]' ");
  while($row_package = mysql_fetch_assoc($sq_pacakge))
  {
    $booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
    $booking_amt=$row_package['exc_total_cost'];
    $total_pay=mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from exc_payment_master where exc_id='$row_package[exc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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
      $pending_amt=$booking_amt-$total_paid;
    }

    $due_date = get_date_user($row_package['due_date']);
    if(strtotime($till_date1) < strtotime($due_date)) {
      $not_due += $pending_amt;
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
        if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
        if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
        if($total_days>'360'){ $group7  = $pending_amt; } 
        
      if($pending_amt>'0'){ 
        array_push($pending_amt_arr,$pending_amt); 
        array_push($total_days_arr,$total_days); 
        array_push($not_due_arr,'0');
        }
    }

    $total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
    $total_outstanding += $total_due + $not_due;
    if($total_outstanding>'0'){ 
    array_push($booking_id_arr,$row_package['exc_id']); 
    array_push($due_date_arr,$row_package['due_date']);} 
  }

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
          ->setCellValue('C'.$row_count, $customer_name)
          ->setCellValue('D'.$row_count, 'Excursion Booking')
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

header('Content-Disposition: attachment;filename="Receivables Ageing Report('.date('d-m-Y H:i:s').').xls"');

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

