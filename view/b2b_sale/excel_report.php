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
$booking_id = $_GET['b2b_booking_master'];
$customer_id = $_GET['customer_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if($customer_id != '') {
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
}
if($booking_id != '') {
    $sq_b2b = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
    $yr = explode("-", get_datetime_db($sq_b2b['created_at']));
    $invoice_no = get_b2b_booking_id($booking_id,$yr[0]);
}

if($from_date!="" && $to_date !=""){
	$from_date = get_datetime_user($from_date);
    $to_date = get_datetime_user($to_date);
    $date_str  = $from_date.' To '.$to_date;
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'B2B Sale Report')
            ->setCellValue('B3', 'Company Name')
            ->setCellValue('C3', $sq_cust['company_name'])
            ->setCellValue('B4', 'Booking ID')
            ->setCellValue('C4', $invoice_no)
            ->setCellValue('B5', 'From-To Date')
            ->setCellValue('C5', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray); 

global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$query = "select * from b2b_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id' ";
}
if($b2b_booking_master!=""){
	$query .=" and booking_id='$b2b_booking_master' ";
}
if($from_date!="" && $to_date !=""){
	$from_date = get_datetime_db($from_date);
	$to_date = get_datetime_db($to_date);
	$query .=" and (created_at>='$from_date' and created_at<='$to_date') ";
}
$query .= " order by booking_id desc";
$sq_customer = mysql_query($query);

$count = 0;
$net_total = 0;
$row_count = 8;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Company Name")
        ->setCellValue('E'.$row_count, "Booking Date")
        ->setCellValue('F'.$row_count, "Total Amount")
        ->setCellValue('G'.$row_count, "Cancel Amount")
        ->setCellValue('H'.$row_count, "Net Amount")
        ->setCellValue('I'.$row_count, "Paid Amount")
        ->setCellValue('J'.$row_count, "created_at");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);    

$row_count++;
while($row_customer = mysql_fetch_assoc($sq_customer)){
	$hotel_total = 0;
	$transfer_total = 0;
	$activity_total = 0;
	$tours_total = 0;
    $servie_total = 0;
    $yr = explode("-", get_datetime_db($row_customer['created_at']));
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_customer[customer_id]'"));
    $cart_checkout_data = json_decode($row_customer['cart_checkout_data']);
    for($i=0;$i<sizeof($cart_checkout_data);$i++){
		if($cart_checkout_data[$i]->service->name == 'Hotel'){
			$hotel_flag = 1;
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
			$tax_amount = 0;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
				$room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
				$room_cost = $room_types[2];
				$h_currency_id = $room_types[3];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] == "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$hotel_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Transfer'){
			$tax_amount = 0;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
			$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_cost);
				$room_cost = $transfer_cost[0];
				$h_currency_id = $transfer_cost[1];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
					if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
					}
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$transfer_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Activity'){
			$activity_flag = 1;
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			
				$tax_amount = 0;
				$tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$transfer_cost = explode('-',$cart_checkout_data[$i]->service->service_arr[$j]->transfer_type);
				$room_cost = $transfer_cost[1];
				$h_currency_id = $transfer_cost[2];
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] === "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$activity_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			for($j=0;$j<sizeof($cart_checkout_data[$i]->service);$j++){
			
				$tax_amount = 0;
			    $tax_arr = explode(',',$cart_checkout_data[$i]->service->service_arr[$j]->taxation);
				$room_cost = $cart_checkout_data[$i]->service->service_arr[$j]->total_cost;
				$h_currency_id = $cart_checkout_data[$i]->service->service_arr[$j]->currency_id;
				
				$tax_arr1 = explode('+',$tax_arr[0]);
				for($t=0;$t<sizeof($tax_arr1);$t++){
				  if($tax_arr1[$t]!=''){
					$tax_arr2 = explode(':',$tax_arr1[$t]);
					if($tax_arr2[2] == "Percentage"){
					  $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
					}else{
					  $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
					}
				  }
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$tours_total += $total_amount;
			}
		}
    }
    if($row_customer['coupon_code'] != ''){
        $sq_coupon = mysql_fetch_assoc(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_customer[coupon_code]'"));
        if($sq_coupon['offer']=="Flat"){
           $hotel_total = $hotel_total - $sq_coupon['offer_amount'];
        }else{
           $hotel_total = $hotel_total - ($hotel_total*$sq_coupon['offer_amount']/100);
        }
    }
	$servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total;
    $net_total += $servie_total;
    
    $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_customer[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
    $payment_amount = $sq_payment_info['sum'];
    $paid_amount +=$sq_payment_info['sum'];

    //Invoice
    $invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);

    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, $invoice_no)
        ->setCellValue('D'.$row_count, $sq_cust['company_name'])
        ->setCellValue('E'.$row_count, get_date_user($row_customer['created_at']))
        ->setCellValue('F'.$row_count, number_format($servie_total,2))
        ->setCellValue('G'.$row_count, number_format(0,2))
        ->setCellValue('H'.$row_count, number_format($servie_total,2))
        ->setCellValue('I'.$row_count, ($payment_amount!='')?number_format($payment_amount,2):number_format(0,2))
        ->setCellValue('J'.$row_count, get_datetime_user($row_customer['created_at']));
  
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);  
     

  $row_count++;
}
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('B'.$row_count, '')
->setCellValue('C'.$row_count, '')
->setCellValue('D'.$row_count, '')
->setCellValue('E'.$row_count, 'Total : ')
->setCellValue('F'.$row_count, number_format($net_total,2))
->setCellValue('G'.$row_count, number_format(0,2))
->setCellValue('H'.$row_count, number_format($net_total,2))
->setCellValue('I'.$row_count, number_format($paid_amount,2))
->setCellValue('J'.$row_count, number_format($net_total - $paid_amount,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray); 

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
header('Content-Disposition: attachment;filename="B2B Sale Report('.date('d-m-Y H:i:s').').xls"');
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