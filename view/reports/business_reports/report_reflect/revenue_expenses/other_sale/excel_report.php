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

$sale_type = $_GET['sale_type'];
include_once('sale_type_generic_function.php');

$sale_purchase_data = get_sale_purchase($sale_type);
$total_sale = $sale_purchase_data['total_sale'];
$total_purchase = $sale_purchase_data['total_purchase'];
$total_expense = $sale_purchase_data['total_expense'];

//Add other Expense
$total_purchase += $total_expense;

if($total_sale > $total_purchase){
  $var = 'Total Profit(%)';
}else{
  $var = 'Total Loss(%)';
}
$profit_loss = $total_sale - $total_purchase;

$profit_loss_per = 0;
$profit_amount = $total_sale - $total_purchase;
$profit_loss_per = ($profit_amount / $total_sale) * 100;
$profit_loss_per = round($profit_loss_per, 2);

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', $sale_type.' Revenue & Expense');

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$count = 0;
$row_count = 4;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Sale")
        ->setCellValue('C'.$row_count, number_format($total_sale,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Total Purchase")
        ->setCellValue('C'.$row_count, number_format($total_purchase,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);    
  

$row_count++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $var)
        ->setCellValue('C'.$row_count, number_format($profit_loss,2).'('.$profit_loss_per.'%)');

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);

///////////////Sale///////////////////////

$row_count++;
$row_count++;


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C'.$row_count, "Sale History");
$objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('C'.$row_count.':C'.$row_count)->applyFromArray($borderArray); 

$row_count++;
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Booking Date")
        ->setCellValue('E'.$row_count, "User Name")
        ->setCellValue('F'.$row_count, "Sale Amount")
        ->setCellValue('G'.$row_count, "Supplier Type")
        ->setCellValue('H'.$row_count, "Supplier Name")
        ->setCellValue('I'.$row_count, "Purchase Amount")
        ->setCellValue('J'.$row_count, "Profit/Loss(%)");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);                    

$row_count++;
$count = 1;
// Visa Start
if($sale_type == 'Visa'){
$sq_query = mysql_query("select * from visa_master order by visa_id desc");
      while ($row_visa = mysql_fetch_assoc($sq_query)) {
        $sq_visa_entry = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]'"));
        $sq_visa_cancel = mysql_num_rows(mysql_query("select * from visa_master_entries where visa_id='$row_visa[visa_id]' and status = 'Cancel'"));
        $date = $row_visa['created_at'];
        $yr = explode("-", $date);
        $year =$yr[0];
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_visa[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from visa_payment_master where visa_id='$row_visa[visa_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];

        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_visa['service_tax_subtotal'] !== 0.00 && ($row_visa['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_visa['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
        $markupservice_tax_amount = 0;
        if($row_visa['markup_tax'] !== 0.00 && $row_visa['markup_tax'] !== ""){
          $service_tax_markup1 = explode(',',$row_visa['markup_tax']);
          for($i=0;$i<sizeof($service_tax_markup1);$i++){
          $service_tax = explode(':',$service_tax_markup1[$i]);
          $markupservice_tax_amount += $service_tax[2];
        
          }
        }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Visa Booking' and estimate_type_id ='$row_visa[visa_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_visa['visa_total_cost'] - $service_tax_amount - $markupservice_tax_amount+ $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
				$var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        if($sq_visa_entry != $sq_visa_cancel){
          
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_visa_booking_id($row_visa['visa_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_visa['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);    
          $row_count++;
       }
      }

  }
// Miscellaneous Start
if($sale_type == 'Miscellaneous'){
$sq_query = mysql_query("select * from miscellaneous_master order by misc_id desc");
      while ($row_visa = mysql_fetch_assoc($sq_query)) {
        $sq_visa_entry = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]'"));
        $sq_visa_cancel = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$row_visa[misc_id]' and status = 'Cancel'"));
        $date = $row_visa['created_at'];
        $yr = explode("-", $date);
        $year =$yr[0];

				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_visa[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_visa['service_tax_subtotal'] !== 0.00 && ($row_visa['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_visa['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
        $markupservice_tax_amount = 0;
        if($row_visa['service_tax_markup'] !== 0.00 && $row_visa['service_tax_markup'] !== ""){
          $service_tax_markup1 = explode(',',$row_visa['service_tax_markup']);
          for($i=0;$i<sizeof($service_tax_markup1);$i++){
          $service_tax = explode(':',$service_tax_markup1[$i]);
          $markupservice_tax_amount += $service_tax[2];
          }
        }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Miscellaneous Booking' and estimate_type_id ='$row_visa[misc_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

        $sq_paid_amount1 = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_visa[misc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_card_charges = $sq_paid_amount1['sumc'];

				$total_sale = $row_visa['misc_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_card_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
        if($sq_visa_entry != $sq_visa_cancel){  
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_misc_booking_id($row_visa['misc_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_visa['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);     
          $row_count++;
       }
      }
    }
// Passport Start
if($sale_type == 'Passport'){
$sq_passport = mysql_query("select * from passport_master order by passport_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_passport_entry = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$row_passport[passport_id]'"));
        $sq_passport_cancel = mysql_num_rows(mysql_query("select * from passport_master_entries where passport_id='$row_passport[passport_id]' and status = 'Cancel'"));
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];
        
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }

				//Purchase
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Passport Booking' and estimate_type_id ='$row_passport[passport_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['passport_total_cost'] - $service_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
        if($sq_passport_entry != $sq_passport_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_passport_booking_id($row_passport['passport_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);     
          $row_count++;
       }
      }
    }
// Excursion Start
if($sale_type == 'Excursion'){
$sq_passport = mysql_query("select * from excursion_master order by exc_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_exc_entry = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_passport[exc_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$row_passport[exc_id]' and status = 'Cancel'"));

        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from exc_payment_master where exc_id='$row_passport[exc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];
        //// Calculate Service Tax//////
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
        $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
        for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }

        //// Calculate Markup Tax//////

        $markupservice_tax_amount = 0;
        if($row_passport['service_tax_markup'] !== 0.00 && $row_passport['service_tax_markup'] !== ""){
        $service_tax_markup1 = explode(',',$row_passport['service_tax_markup']);
        for($i=0;$i<sizeof($service_tax_markup1);$i++){
          $service_tax = explode(':',$service_tax_markup1[$i]);
          $markupservice_tax_amount += $service_tax[2];

          }
        }
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Excursion Booking' and estimate_type_id ='$row_passport[exc_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['exc_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
        if($sq_exc_entry != $sq_exc_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_exc_booking_id($row_passport['exc_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);   
          $row_count++;
       }
      }
    }

// Forex Start
if($sale_type == 'Forex'){
$sq_passport = mysql_query("select * from forex_booking_master order by booking_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from forex_booking_payment_master where booking_id='$row_passport[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];
    
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
        $year =$yr[0];
        
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 
        
        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Forex Booking' and estimate_type_id ='$row_passport[booking_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['net_total'] - $service_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_forex_booking_id($row_passport['booking_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);   
          $row_count++;
      }
    }
// Bus Start
if($sale_type == 'Bus'){
$sq_passport = mysql_query("select * from bus_booking_master order by booking_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_exc_entry = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_passport[booking_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$row_passport[booking_id]' and status = 'Cancel'"));
				
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from bus_booking_payment_master where booking_id='$row_passport[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];

        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
        $markupservice_tax_amount = 0;
        if($row_passport['markup_tax'] !== 0.00 && $row_passport['markup_tax'] !== ""){
          $service_tax_markup1 = explode(',',$row_passport['markup_tax']);
          for($i=0;$i<sizeof($service_tax_markup1);$i++){
          $service_tax = explode(':',$service_tax_markup1[$i]);
          $markupservice_tax_amount += $service_tax[2];
        
          }
        }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Bus Booking' and estimate_type_id ='$row_passport[booking_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['net_total'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
				$var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        if($sq_exc_entry != $sq_exc_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_bus_booking_id($row_passport['booking_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);    
          $row_count++;
       }
      }
    }
// Hotel Start
if($sale_type == 'Hotel'){
      $sq_passport = mysql_query("select * from hotel_booking_master order by booking_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_exc_entry = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_passport[booking_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_passport[booking_id]' and status = 'Cancel'"));

				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from hotel_booking_payment where booking_id='$row_passport[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
		$credit_charges = $sq_paid_amount['sumc'];
      //// Calculate Service Tax//////
      $service_tax_amount = 0;
      if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
      $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
      for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
        $service_tax = explode(':',$service_tax_subtotal1[$i]);
        $service_tax_amount +=  $service_tax[2];
        }
      }

      //// Calculate Markup Tax//////

      $markupservice_tax_amount = 0;
      if($row_passport['service_tax_markup'] !== 0.00 && $row_passport['service_tax_markup'] !== ""){
      $service_tax_markup1 = explode(',',$row_passport['service_tax_markup']);
      for($i=0;$i<sizeof($service_tax_markup1);$i++){
        $service_tax = explode(':',$service_tax_markup1[$i]);
        $markupservice_tax_amount += $service_tax[2];

        }
      }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Hotel Booking' and estimate_type_id ='$row_passport[booking_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['total_fee'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
				$var = ($total_sale > $total_purchase) ? 'Profit':'Loss';

				$sq_exc_entry = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_passport[booking_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$row_passport[booking_id]' and status = 'Cancel'"));
        
        if($sq_exc_entry != $sq_exc_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_hotel_booking_id($row_passport['booking_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);    
          $row_count++;
       }
      }
    }
// Car Rental Start
if($sale_type == 'Car Rental'){
      $sq_passport = mysql_query("select * from car_rental_booking where status != 'Cancel' order by booking_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) { 
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
        $year =$yr[0];
        
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum ,sum(`credit_charges`) as sumc from car_rental_payment where booking_id='$row_passport[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_charges = $sq_paid_amount['sumc'];

        //Service Tax and Markup Tax
          $service_tax_amount = 0;
          if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
              $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
              for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
              $service_tax = explode(':',$service_tax_subtotal1[$i]);
              $service_tax_amount +=  $service_tax[2];
              }
          }
          $markupservice_tax_amount = 0;
          if($row_passport['markup_cost_subtotal'] !== 0.00 && $row_passport['markup_cost_subtotal'] !== ""){
              $service_tax_markup1 = explode(',',$row_passport['markup_cost_subtotal']);
              for($i=0;$i<sizeof($service_tax_markup1);$i++){
              $service_tax = explode(':',$service_tax_markup1[$i]);
              $markupservice_tax_amount += $service_tax[2];

              }
          }
        
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Car Rental' and estimate_type_id ='$row_passport[booking_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['total_fees'] - $service_tax_amount - $markupservice_tax_amount + $credit_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_car_rental_booking_id($row_passport['booking_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);      
          $row_count++;
      }
    }
// Flight Ticket Start
if($sale_type == 'Flight Ticket'){
      $sq_passport = mysql_query("select * from ticket_master order by ticket_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_exc_entry = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_passport[ticket_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_passport[ticket_id]' and status = 'Cancel'"));
        
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
        $markupservice_tax_amount = 0;
        if($row_passport['markup_tax'] !== 0.00 && $row_passport['markup_tax'] !== ""){
          $service_tax_markup1 = explode(',',$row_passport['markup_tax']);
          for($i=0;$i<sizeof($service_tax_markup1);$i++){
          $service_tax = explode(':',$service_tax_markup1[$i]);
          $markupservice_tax_amount += $service_tax[2];
        
          }
        }
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from ticket_payment_master where ticket_id='$row_passport[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_card_charges = $sq_paid_amount['sumc'];
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id ='$row_passport[ticket_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['ticket_total_cost'] - $service_tax_amount - $markupservice_tax_amount + $credit_card_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
        if($sq_exc_entry != $sq_exc_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_ticket_booking_id($row_passport['ticket_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);     
          $row_count++;
        }
      }
    }

// Train Ticket Start
if($sale_type == 'Train Ticket'){
      $sq_passport = mysql_query("select * from train_ticket_master order by train_ticket_id desc");
      while ($row_passport = mysql_fetch_assoc($sq_passport)) {
        $date = $row_passport['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
        $sq_exc_entry = mysql_num_rows(mysql_query("select * from train_ticket_master_entries where train_ticket_id='$row_passport[train_ticket_id]'"));
        $sq_exc_cancel = mysql_num_rows(mysql_query("select * from train_ticket_master_entries where train_ticket_id='$row_passport[train_ticket_id]' and status = 'Cancel'"));

				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
				$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 
        
        $sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$row_passport[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $credit_card_charges = $sq_paid_amount['sumc'];
        
        //Service Tax and Markup Tax
        $service_tax_amount = 0;
        if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
          $service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
          for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
          $service_tax = explode(':',$service_tax_subtotal1[$i]);
          $service_tax_amount +=  $service_tax[2];
          }
        }
				//Purchase 
				$sq_pquery = mysql_fetch_assoc(mysql_query("select sum(net_total) as net_total,sum(service_tax_subtotal) as service_tax_subtotal from vendor_estimate where estimate_type='Train Ticket Booking' and estimate_type_id ='$row_passport[train_ticket_id]' and status!='Cancel'"));
				$vendor_name = get_vendor_name_report($sq_pquery['vendor_type'],$sq_pquery['vendor_type_id']);

				$total_sale = $row_passport['net_total']  - $service_tax_amount + $credit_card_charges;
				$total_purchase = $sq_pquery['net_total']-$sq_pquery['service_tax_subtotal'];
				$profit_amount = $total_sale - $total_purchase;
				$profit_loss_per = ($profit_amount / $total_sale) * 100;
				$profit_loss_per = round($profit_loss_per, 2);
        $var = ($total_sale > $total_purchase) ? 'Profit':'Loss';
        
        if($sq_exc_entry != $sq_exc_cancel){ 
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('B'.$row_count, $count++)
              ->setCellValue('C'.$row_count, get_train_ticket_booking_id($row_passport['train_ticket_id'],$year))
              ->setCellValue('D'.$row_count, get_date_user($row_passport['created_at']))
              ->setCellValue('E'.$row_count, $emp)
              ->setCellValue('F'.$row_count, number_format($total_sale,2))
              ->setCellValue('G'.$row_count, ($sq_pquery['vendor_type'] !='')?$sq_pquery['vendor_type']:'NA')
              ->setCellValue('H'.$row_count, ($vendor_name !='')?$vendor_name:'NA')
              ->setCellValue('I'.$row_count, number_format($total_purchase,2))
              ->setCellValue('J'.$row_count, $profit_loss_per.'%('.$var.')');

          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);  
          $row_count++;
        }
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
header('Content-Disposition: attachment;filename="'.$sale_type.' Revenue & Expense('.date('d-m-Y H:i:s').').xls"');
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
