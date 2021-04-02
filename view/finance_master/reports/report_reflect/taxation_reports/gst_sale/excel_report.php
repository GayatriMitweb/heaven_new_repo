<?php
include "../../../../../../model/model.php";
include_once('../gst_sale/sale_generic_functions.php');
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
$taxation_id='';
$branch_status = $_GET['branch_status'];

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('B2', 'Report Name')
          ->setCellValue('C2', 'Tax On Sale')
          ->setCellValue('B3', 'From-To-Date')
          ->setCellValue('C3', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$row_count = 7;      

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Service Name")
        ->setCellValue('D'.$row_count, "SAC/HSN Code")
        ->setCellValue('E'.$row_count, "Customer Name")
        ->setCellValue('F'.$row_count, "GSTIN/UIN")
        ->setCellValue('G'.$row_count, "Account State")
        ->setCellValue('H'.$row_count, "Booking ID")
        ->setCellValue('I'.$row_count, "Booking Date")
        ->setCellValue('J'.$row_count, "Type Of Customer")
        ->setCellValue('K'.$row_count, "Place of Supply")
        ->setCellValue('L'.$row_count, "Net Amount")
        ->setCellValue('M'.$row_count, "Taxable Amount")
        ->setCellValue('N'.$row_count, "TAX%")
        ->setCellValue('O'.$row_count, "Tax Amount")
        ->setCellValue('P'.$row_count, "Markup")
        ->setCellValue('Q'.$row_count, "TAX%_On_Markup")
        ->setCellValue('R'.$row_count, "TAX_amount_On_Markup")
        ->setCellValue('S'.$row_count, "Cess%")
        ->setCellValue('T'.$row_count, "Cess Amount")
        ->setCellValue('U'.$row_count, "ITC Eligibility")
        ->setCellValue('V'.$row_count, "Reverse Charge");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 1;
$tax_total = 0;
$markup_tax_total = 0;
$sq_setting = mysql_fetch_assoc(mysql_query("select * from app_settings where setting_id='1'"));
$sq_supply = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_setting[state_id]'"));

//GIT Booking
$query = "select * from tourwise_traveler_details where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and form_date between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
	$sq_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as booking_count from travelers_details where traveler_group_id ='$row_query[id]'"));
	//Group cancel or not
	$sq_group = mysql_fetch_assoc(mysql_query("select status from tour_groups where group_id ='$row_query[tour_group_id]'"));

	//Cancelled count
	$sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as cancel_count from travelers_details where traveler_group_id ='$row_query[id]' and status ='Cancel'"));
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'] || $sq_group['status'] != 'Cancel')
	{
		$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		$hsn_code = get_service_info('Group Tour');

		//Service tax
		$tax_per = 0;
		$service_tax_amount = 0;
		$tax_name = 'NA';
		if($row_query['service_tax'] !== 0.00 && ($row_query['service_tax']) !== ''){
			$service_tax_subtotal1 = explode(',',$row_query['service_tax']);
			$tax_name = '';
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
				$tax_name .= $service_tax[0] . $service_tax[1].' ';
				$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
			}
		}
		//Markup Tax
		$markup_tax_amount = 0;
		$markup_tax_name = 'NA';
		$markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
		//Taxable amount
		$taxable_amount = ($service_tax_amount / $tax_per) * 100;
		$tax_total += $service_tax_amount;
		$markup_tax_total += $markup_tax_amount;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, "Group Booking")
        ->setCellValue('D'.$row_count, $hsn_code)
        ->setCellValue('E'.$row_count, $cust_name)
        ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
        ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
        ->setCellValue('H'.$row_count, get_group_booking_id($row_query['id']))
        ->setCellValue('I'.$row_count, get_date_user($row_query['form_date']))
        ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
        ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
        ->setCellValue('L'.$row_count, $row_query['net_total'])
        ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
        ->setCellValue('N'.$row_count, $tax_name)
        ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
        ->setCellValue('P'.$row_count, $markup)
        ->setCellValue('Q'.$row_count, $markup_tax_name)
        ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
        ->setCellValue('S'.$row_count,'0.00')
        ->setCellValue('T'.$row_count,'0.00')
        ->setCellValue('U'.$row_count, '')
        ->setCellValue('V'.$row_count, '');


    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);    
    $row_count++;
	}
}
//FIT Booking
$query = "select * from package_tour_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and booking_date between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
	
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as booking_count from package_travelers_details where booking_id ='$row_query[booking_id]'"));
  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(traveler_id) as cancel_count from package_travelers_details where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
  if($sq_cust['type'] == 'Corporate'){
    $cust_name = $sq_cust['company_name'];
  }else{
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  }

  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      $hsn_code = get_service_info('Package Tour');  	
    
    //Service tax
    $tax_per = 0;
    $service_tax_amount = 0;
    $tax_name = 'NA';
    if($row_query['tour_service_tax_subtotal'] !== 0.00 && ($row_query['tour_service_tax_subtotal']) !== ''){
      $service_tax_subtotal1 = explode(',',$row_query['tour_service_tax_subtotal']);
      $tax_name = '';
      for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
        $service_tax = explode(':',$service_tax_subtotal1[$i]);
        $service_tax_amount +=  $service_tax[2];
        $tax_name .= $service_tax[0] . $service_tax[1].' ';
        $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
      }
    }
    //Markup Tax
    $markup_tax_amount = 0;
    $markup_tax_name = 'NA';
    $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
    //Taxable amount
    $taxable_amount = ($service_tax_amount / $tax_per) * 100;
    $tax_total += $service_tax_amount;
    $markup_tax_total += $markup_tax_amount;

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('B'.$row_count, $count++)
      ->setCellValue('C'.$row_count, "Package Booking")
      ->setCellValue('D'.$row_count, $hsn_code)
      ->setCellValue('E'.$row_count, $cust_name)
      ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
      ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
      ->setCellValue('H'.$row_count, get_package_booking_id($row_query['booking_id']))
      ->setCellValue('I'.$row_count, get_date_user($row_query['booking_date']))
      ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
      ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
      ->setCellValue('L'.$row_count, $row_query['net_total'])
      ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
      ->setCellValue('N'.$row_count, $tax_name)
      ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
      ->setCellValue('P'.$row_count, $markup)
      ->setCellValue('Q'.$row_count, $markup_tax_name)
      ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
      ->setCellValue('S'.$row_count,'0.00')
      ->setCellValue('T'.$row_count,'0.00')
      ->setCellValue('U'.$row_count, '')
      ->setCellValue('V'.$row_count, '');

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);   
    $row_count++;
  }
}
//Passport Booking
$query = "select * from passport_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
  {
    //Total count
    $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from passport_master_entries where passport_id ='$row_query[passport_id]'"));

    //Cancelled count
    $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from passport_master_entries where passport_id ='$row_query[passport_id]' and status ='Cancel'"));
    if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
    {
        $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
        if($sq_cust['type'] == 'Corporate'){
          $cust_name = $sq_cust['company_name'];
        }else{
          $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
        }
        $hsn_code = get_service_info('Passport');
        $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
		
        //Service tax
        $tax_per = 0;
        $service_tax_amount = 0;
        $tax_name = 'NA';
        if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
          $tax_name = '';
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
            $service_tax = explode(':',$service_tax_subtotal1[$i]);
            $service_tax_amount +=  $service_tax[2];
            $tax_name .= $service_tax[0] . $service_tax[1].' ';
            $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
          }
        }
        //Markup Tax
        $markup_tax_amount = 0;
        $markup_tax_name = 'NA';
        $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
        //Taxable amount
        $taxable_amount = ($service_tax_amount / $tax_per) * 100;
        $tax_total += $service_tax_amount;
        $markup_tax_total += $markup_tax_amount;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Passport Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_passport_booking_id($row_query['passport_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['passport_total_cost'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);    

      $row_count++;   
     }
  }

//Visa Booking
$query = "select * from visa_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from visa_master_entries where visa_id ='$row_query[visa_id]'"));

  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from visa_master_entries where visa_id ='$row_query[visa_id]' and status ='Cancel'"));
  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $hsn_code = get_service_info('Visa');
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      
      //Service tax
      $tax_per = 0;
      $service_tax_amount = 0;
      $tax_name = 'NA';
      if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
        $tax_name = '';
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          $tax_name .= $service_tax[0] . $service_tax[1].' ';
          $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
        }
      }
      //Markup Tax
      $markup_tax_amount = 0;
      $markup_tax_name = 'NA';
      $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
      if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
        $markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
        $markup_tax_name = '';
        for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
          $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
          $markup_tax_amount +=  $markup_tax[2];
          $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
        }
      }
      //Taxable amount
      $taxable_amount = ($service_tax_amount / $tax_per) * 100;
      $tax_total += $service_tax_amount;
      $markup_tax_total += $markup_tax_amount;

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Visa Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_visa_booking_id($row_query['visa_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['visa_total_cost'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);       
      
      $row_count++;   
    }
}

//Bus Booking
    $query = "select * from bus_booking_master where 1 ";
    if($from_date !='' && $to_date != ''){
      $from_date = get_date_db($from_date);
      $to_date = get_date_db($to_date);
      $query .= " and created_at between '$from_date' and '$to_date' ";
    }
    $sq_query = mysql_query($query);
      while($row_query = mysql_fetch_assoc($sq_query))
      {
        //Total count
      $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from bus_booking_entries where booking_id ='$row_query[booking_id]'"));

      //Cancelled count
      $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from bus_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));
      if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
      {
          $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
          if($sq_cust['type'] == 'Corporate'){
            $cust_name = $sq_cust['company_name'];
          }else{
            $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
          }
          $hsn_code = get_service_info('Bus');
          $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
          //Service tax
          $tax_per = 0;
          $service_tax_amount = 0;
          $tax_name = 'NA';
          if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
            $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
            $tax_name = '';
            for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
              $service_tax = explode(':',$service_tax_subtotal1[$i]);
              $service_tax_amount +=  $service_tax[2];
              $tax_name .= $service_tax[0] . $service_tax[1].' ';
              $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
            }
          }
          //Markup Tax
          $markup_tax_amount = 0;
          $markup_tax_name = 'NA';
          $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
          if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
            $markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
            $markup_tax_name = '';
            for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
              $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
              $markup_tax_amount +=  $markup_tax[2];
              $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
            }
          }
          //Taxable amount
          $taxable_amount = ($service_tax_amount / $tax_per) * 100;
          $tax_total += $service_tax_amount;
          $markup_tax_total += $markup_tax_amount;

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Bus Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_bus_booking_id($row_query['booking_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['net_total'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);         
      
      $row_count++;   
    }
}

//Forex Booking
    $query = "select * from forex_booking_master where 1 ";
    if($from_date !='' && $to_date != ''){
      $from_date = get_date_db($from_date);
      $to_date = get_date_db($to_date);
      $query .= " and created_at between '$from_date' and '$to_date' ";
    }
    $sq_query = mysql_query($query);
      while($row_query = mysql_fetch_assoc($sq_query))
      {
        $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
        if($sq_cust['type'] == 'Corporate'){
          $cust_name = $sq_cust['company_name'];
        }else{
          $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
        }
        $hsn_code = get_service_info('Forex');
        $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
        //Service tax
        $tax_per = 0;
        $service_tax_amount = 0;
        $tax_name = 'NA';
        if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
          $tax_name = '';
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
            $service_tax = explode(':',$service_tax_subtotal1[$i]);
            $service_tax_amount +=  $service_tax[2];
            $tax_name .= $service_tax[0] . $service_tax[1].' ';
            $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
          }
        }
        //Markup Tax
        $markup_tax_amount = 0;
        $markup_tax_name = 'NA';
        $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
        //Taxable amount
        $taxable_amount = ($service_tax_amount / $tax_per) * 100;
        $tax_total += $service_tax_amount;
        $markup_tax_total += $markup_tax_amount;    

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Forex Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_forex_booking_id($row_query['booking_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['net_total'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);     

      $row_count++;   
}  

//Excursion Booking
$query = "select * from excursion_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from excursion_master_entries where exc_id ='$row_query[exc_id]'"));

  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from excursion_master_entries where exc_id ='$row_query[exc_id]' and status ='Cancel'"));
  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $taxable_amount = $row_query['exc_issue_amount'] + $row_query['service_charge'];
      $hsn_code = get_service_info('Excursion');
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      
      //Service tax
      $tax_per = 0;
      $service_tax_amount = 0;
      $tax_name = 'NA';
      if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
        $tax_name = '';
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          $tax_name .= $service_tax[0] . $service_tax[1].' ';
          $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
        }
      }
      //Markup Tax
      $markup_tax_amount = 0;
      $markup_tax_name = 'NA';
      $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
      if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
        $markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
        $markup_tax_name = '';
        for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
          $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
          $markup_tax_amount +=  $markup_tax[2];
          $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
        }
      }
      //Taxable amount
      $taxable_amount = ($service_tax_amount / $tax_per) * 100;
      $tax_total += $service_tax_amount;
      $markup_tax_total += $markup_tax_amount;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Activity Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_exc_booking_id($row_query['exc_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['exc_total_cost'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);     

      $row_count++;   
     }
  }

//Hotel Booking
$query = "select * from hotel_booking_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $hsn_code = get_service_info('Hotel / Accommodation');
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      
      //Service tax
      $tax_per = 0;
      $service_tax_amount = 0;
      $tax_name = 'NA';
      if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
        $tax_name = '';
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          $tax_name .= $service_tax[0] . $service_tax[1].' ';
          $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
        }
      }
      //Markup Tax
      $markup_tax_amount = 0;
      $markup_tax_name = 'NA';
      $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
      if($row_query['markup_tax'] !== 0.00 && ($row_query['markup_tax']) !== ''){
        $markup_tax_subtotal1 = explode(',',$row_query['markup_tax']);
        $markup_tax_name = '';
        for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
          $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
          $markup_tax_amount +=  $markup_tax[2];
          $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
        }
      }
      //Taxable amount
      $taxable_amount = ($service_tax_amount / $tax_per) * 100;
      $tax_total += $service_tax_amount;
      $markup_tax_total += $markup_tax_amount;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Hotel Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_hotel_booking_id($row_query['booking_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['total_fee'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);

      $row_count++;   
    }
  }

//Car Rental Booking
$query = "select * from car_rental_booking where status != 'Cancel' ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
  if($sq_cust['type'] == 'Corporate'){
    $cust_name = $sq_cust['company_name'];
  }else{
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  }
  $hsn_code = get_service_info('Car Rental');
  $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
  
	//Service tax
	$tax_per = 0;
	$service_tax_amount = 0;
	$tax_name = 'NA';
	if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
		$tax_name = '';
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
			$service_tax = explode(':',$service_tax_subtotal1[$i]);
			$service_tax_amount +=  $service_tax[2];
			$tax_name .= $service_tax[0] . $service_tax[1].' ';
			$tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
		}
	}
	//Markup Tax
	$markup_tax_amount = 0;
	$markup_tax_name = 'NA';
	$markup = ($row_query['markup_cost'] == '' || $row_query['markup_cost'] == '0') ? 'NA' : number_format($row_query['markup_cost'],2);
	if($row_query['markup_cost_subtotal'] !== 0.00 && ($row_query['markup_cost_subtotal']) !== ''){
		$markup_tax_subtotal1 = explode(',',$row_query['markup_cost_subtotal']);
		$markup_tax_name = '';
		for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
			$markup_tax = explode(':',$markup_tax_subtotal1[$i]);
			$markup_tax_amount +=  $markup_tax[2];
			$markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
		}
	}
	//Taxable amount
	$taxable_amount = ($service_tax_amount / $tax_per) * 100;
	$tax_total += $service_tax_amount;
	$markup_tax_total += $markup_tax_amount;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Car Rental Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_car_rental_booking_id($row_query['booking_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['total_fees'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);    

      $row_count++;   
 }

//Flight Booking
$query = "select * from ticket_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]'"));

  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]' and status ='Cancel'"));
  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $hsn_code = get_service_info('Flight');
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      //Service tax
      $tax_per = 0;
      $service_tax_amount = 0;
      $tax_name = 'NA';
      if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
        $tax_name = '';
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          $tax_name .= $service_tax[0] . $service_tax[1].' ';
          $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
        }
      }
      //Markup Tax
      $markup_tax_amount = 0;
      $markup_tax_name = 'NA';
      $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
      if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
        $markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
        $markup_tax_name = '';
        for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
          $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
          $markup_tax_amount +=  $markup_tax[2];
          $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
        }
      }
      //Taxable amount
      $taxable_amount = ($service_tax_amount / $tax_per) * 100;
      $tax_total += $service_tax_amount;
      $markup_tax_total += $markup_tax_amount;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Ticket Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_ticket_booking_id($row_query['ticket_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['ticket_total_cost'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);    

      $row_count++;   
     }
  }
  
//Train Booking
$query = "select * from train_ticket_master where 1 ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from train_ticket_master_entries where train_ticket_id ='$row_query[train_ticket_id]'"));

  //Cancelled count
  $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from train_ticket_master_entries where train_ticket_id ='$row_query[train_ticket_id]' and status ='Cancel'"));
  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $hsn_code = get_service_info('Train');
      $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
      
      //Service tax
      $tax_per = 0;
      $service_tax_amount = 0;
      $tax_name = 'NA';
      if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
        $tax_name = '';
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          $tax_name .= $service_tax[0] . $service_tax[1].' ';
          $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
        }
      }
      //Markup Tax
      $markup_tax_amount = 0;
      $markup_tax_name = 'NA';
      $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
      //Taxable amount
      $taxable_amount = ($service_tax_amount / $tax_per) * 100;
      $tax_total += $service_tax_amount;
      $markup_tax_total += $markup_tax_amount;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Train Ticket Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_train_ticket_booking_id($row_query['train_ticket_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['net_total'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);     

      $row_count++;   
     }
  }

    //Miscellaneous Booking
    $query = "select * from miscellaneous_master where 1 ";
    if($from_date !='' && $to_date != ''){
      $from_date = get_date_db($from_date);
      $to_date = get_date_db($to_date);
      $query .= " and created_at between '$from_date' and '$to_date' ";
    }
    $sq_query = mysql_query($query);
      while($row_query = mysql_fetch_assoc($sq_query))
      {
        //Total count
        $sq_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as booking_count from miscellaneous_master_entries where misc_id ='$row_query[misc_id]'"));
  
        //Cancelled count
        $sq_cancel_count = mysql_fetch_assoc(mysql_query("select count(entry_id) as cancel_count from miscellaneous_master_entries where misc_id	 ='$row_query[misc_id]' and status ='Cancel'"));
        if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
      {
          $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_query[customer_id]'"));
          if($sq_cust['type'] == 'Corporate'){
            $cust_name = $sq_cust['company_name'];
          }else{
            $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
          }
          $hsn_code = get_service_info('Miscellaneous');  
          $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_cust[state_id]'"));
  
          //Service tax
          $tax_per = 0;
          $service_tax_amount = 0;
          $tax_name = 'NA';
          if($row_query['service_tax_subtotal'] !== 0.00 && ($row_query['service_tax_subtotal']) !== ''){
            $service_tax_subtotal1 = explode(',',$row_query['service_tax_subtotal']);
            $tax_name = '';
            for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
              $service_tax = explode(':',$service_tax_subtotal1[$i]);
              $service_tax_amount +=  $service_tax[2];
              $tax_name .= $service_tax[0] . $service_tax[1].' ';
              $tax_per += str_replace( array('(',')', '%'),'', $service_tax[1]);
            }
          }
          //Markup Tax
          $markup_tax_amount = 0;
          $markup_tax_name = 'NA';
          $markup = ($row_query['markup'] == '' || $row_query['markup'] == '0') ? 'NA' : number_format($row_query['markup'],2);
          if($row_query['service_tax_markup'] !== 0.00 && ($row_query['service_tax_markup']) !== ''){
            $markup_tax_subtotal1 = explode(',',$row_query['service_tax_markup']);
            $markup_tax_name = '';
            for($i=0;$i<sizeof($markup_tax_subtotal1);$i++){
              $markup_tax = explode(':',$markup_tax_subtotal1[$i]);
              $markup_tax_amount +=  $markup_tax[2];
              $markup_tax_name .= $markup_tax[0] . $markup_tax[1].' ';
            }
          }
          //Taxable amount
          $taxable_amount = ($service_tax_amount / $tax_per) * 100;
          $tax_total += $service_tax_amount;
          $markup_tax_total += $markup_tax_amount;

          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('B'.$row_count, $count++)
          ->setCellValue('C'.$row_count, "Miscellaneous Booking")
          ->setCellValue('D'.$row_count, $hsn_code)
          ->setCellValue('E'.$row_count, $cust_name)
          ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
          ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
          ->setCellValue('H'.$row_count, get_misc_booking_id($row_query['misc_id']))
          ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
          ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
          ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
          ->setCellValue('L'.$row_count, $row_query['misc_total_cost'])
          ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
          ->setCellValue('N'.$row_count, $tax_name)
          ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
          ->setCellValue('P'.$row_count, $markup)
          ->setCellValue('Q'.$row_count, $markup_tax_name)
          ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
          ->setCellValue('S'.$row_count,'0.00')
          ->setCellValue('T'.$row_count,'0.00')
          ->setCellValue('U'.$row_count, '')
          ->setCellValue('V'.$row_count, '');


      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
      $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);     

    $row_count++;   
  }
}
//Income Booking
$query = "select * from other_income_master where 1 ";
        if($from_date !='' && $to_date != ''){
          $from_date = get_date_db($from_date);
          $to_date = get_date_db($to_date);
          $query .= " and receipt_date between '$from_date' and '$to_date' ";
        }
        $sq_query = mysql_query($query);
          while($row_query = mysql_fetch_assoc($sq_query))
          {
            $taxable_amount = $row_query['amount'];
            $sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[income_type_id]'"));
            $hsn_code = '9985';
            
            //Service tax
            $tax_per = 0;
            $service_tax_amount = 0;
            $tax_name = 'NA';
            //Markup Tax
            $markup_tax_amount = 0;
            $markup_tax_name = 'NA';
            $markup = number_format(0,2);
            //Taxable amount
            $tax_total += $row_query['service_tax_subtotal'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, $sq_income_type_info['ledger_name'])
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $row_query['receipt_from'])
            ->setCellValue('F'.$row_count, 'NA')
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_other_income_payment_id($row_query['income_id']))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, 'Unregistered')
            ->setCellValue('K'.$row_count, 'NA')
            ->setCellValue('L'.$row_count, $row_query['total_fee'])
            ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
            ->setCellValue('N'.$row_count, $tax_name)
            ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('P'.$row_count, $markup)
            ->setCellValue('Q'.$row_count, $markup_tax_name)
            ->setCellValue('R'.$row_count, number_format($markup_tax_amount,2))
            ->setCellValue('S'.$row_count,'0.00')
            ->setCellValue('T'.$row_count,'0.00')
            ->setCellValue('U'.$row_count, '')
            ->setCellValue('V'.$row_count, '');
  
  
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);       
      $row_count++;
}
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count,'' )
        ->setCellValue('C'.$row_count, '')
        ->setCellValue('D'.$row_count, '')
        ->setCellValue('E'.$row_count,'' )
        ->setCellValue('F'.$row_count, '')
        ->setCellValue('G'.$row_count,'' )
        ->setCellValue('H'.$row_count,'' )
        ->setCellValue('I'.$row_count,'' )
        ->setCellValue('J'.$row_count,'' )
        ->setCellValue('K'.$row_count,'' )
        ->setCellValue('L'.$row_count, '')
        ->setCellValue('M'.$row_count,'' )
        ->setCellValue('N'.$row_count,'' )
        ->setCellValue('O'.$row_count,'Total TAX :'.number_format($tax_total,2))
        ->setCellValue('P'.$row_count,'' )
        ->setCellValue('Q'.$row_count,'')
        ->setCellValue('R'.$row_count,'Total Markup TAX :'.number_format($markup_tax_total,2))
        ->setCellValue('S'.$row_count,'')
        ->setCellValue('T'.$row_count,'' )
        ->setCellValue('U'.$row_count,'')
        ->setCellValue('V'.$row_count, '');

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':V'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="Tax On Sale Report('.date('d-m-Y H:i:s').').xls"');
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
