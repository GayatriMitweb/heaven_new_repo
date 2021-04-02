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
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];

$customer_id = $_GET['customer_id'];
$booking_id = $_GET['booking_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];
$booker_id = $_GET['booker_id'];
$branch_id = $_GET['branch_id'];

$branch_status = $_GET['branch_status'];
$customer_id = $_GET['customer_id'];
$b2b_booking_master = $_GET['b2b_booking_master'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if($customer_id!=""){
	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name'];
}
else{
	$cust_name = "";
}

$invoice_id = ($booking_id!="") ? get_b2b_booking_id($row_customer['booking_id']): "";

if($from_date!="" && $to_date!=""){
	$date_str = $from_date.' to '.$to_date;
}
else{
	$date_str = "";
}
if($company_name == 'undefined') { $company_name = ''; }

if($booker_id != '')
{
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$booker_id'"));
    if($sq_emp['first_name'] == '') { $emp_name='Admin';}
    else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }
}

if($branch_id != '') { 
    $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_id'"));
    $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
}
$sq_booking = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$b2b_booking_master'"));
$yr = explode("-", get_datetime_db($sq_booking['created_at']));
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Pacakge Tour Summary')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', get_b2b_booking_id($b2b_booking_master,$yr[0]))
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
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
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
$count = 0;
$total_balance=0;
$total_refund=0;	
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;
$outstanding = 0;
$net_total = 0;
$row_count = 11;

       $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, "Sr. No")
                ->setCellValue('C'.$row_count, "Booking ID")
                ->setCellValue('D'.$row_count, "Customer Name")
                ->setCellValue('E'.$row_count, "Contact")
                ->setCellValue('F'.$row_count, "EMAIL ID")
                ->setCellValue('G'.$row_count, "Booking Date")
                ->setCellValue('H'.$row_count, "Sale")
                ->setCellValue('I'.$row_count, "Cancel")
                ->setCellValue('J'.$row_count, "Total")
                ->setCellValue('K'.$row_count, "Paid")
                ->setCellValue('L'.$row_count, "Outstanding Balance")
                ->setCellValue('M'.$row_count, "Purchase")
                ->setCellValue('N'.$row_count, "Purchased From")
                ->setCellValue('O'.$row_count, "Booked By")
                ->setCellValue('P'.$row_count, "Incentive");


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($borderArray);    

        $row_count++;

        $count = 0;
        

        $sq_customer = mysql_query($query);
        while($row_customer = mysql_fetch_assoc($sq_customer)){

            $hotel_total = 0;
            $transfer_total = 0;
            $activity_total = 0;
            $tours_total = 0;
            $servie_total = 0;
            $yr = explode("-", get_datetime_db($row_customer['created_at']));
            $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_customer[customer_id]'"));
            $cart_checkout_data = json_decode($row_customer['cart_checkout_data']);

            // $pass_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_customer[booking_id]'"));
            // $cancle_count= mysql_num_rows(mysql_query("select * from package_travelers_details where booking_id='$row_customer[booking_id]' and status='Cancel'"));
            // if($pass_count==$cancle_count){
            // 		$bg="danger";
            // }else{
            // 		$bg="#fff";
            // }
            
            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_customer[emp_id]'"));
            if($sq_emp['first_name'] == '') { $emp_name='Admin';}
            else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

            $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
            $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
            
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

            $servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total;
            
            if($row_customer['coupon_code'] != ''){
                $sq_hotel_count = mysql_num_rows(mysql_query("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
                if($sq_hotel_count > 0){
                    $sq_coupon = mysql_fetch_assoc(mysql_query("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_customer[coupon_code]'"));
                }else{
                    $sq_coupon = mysql_fetch_assoc(mysql_query("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_customer[coupon_code]'"));
                }

                if($sq_coupon['offer']=="Flat"){
                    $servie_total = $servie_total - $sq_coupon['offer_amount'];
                }else{
                    $servie_total = $servie_total - ($servie_total*$sq_coupon['offer_amount']/100);
                }
            }
            
            $net_total += $servie_total;
            
            $sq_payment_info = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_customer[booking_id]' and (clearance_status!='Pending' or clearance_status!='Cancelled')"));
            $payment_amount = $sq_payment_info['sum'];
            $paid_amount +=$sq_payment_info['sum'];
            $outstanding = $net_total - $paid_amount;

            //Invoice
            $invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);
            $booking_id = $row_customer['booking_id'];
            $invoice_date = date('d-m-Y',strtotime($row_customer['created_at']));
            $customer_id = $row_customer['customer_id'];
            $service_name = "B2B Invoice";
            $sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Package Tour'"));
            $sac_code = $sq_sac['hsn_sac_code'];

            if($app_invoice_format == 4)
            $url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_tax_invoice.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";
            else
            $url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";

            //Receipt
            $payment_id_name = "Receipt ID";
            $booking_id = $row_customer['booking_id'];
            $customer_id = $row_customer['customer_id'];
            $receipt_type = "B2B Sale Receipt";

            /////// Purchase ////////
            $total_purchase = 0;
            $purchase_amt = 0;
            $i=0;
            $p_due_date = '';
            $sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));
            if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
            $sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'");
            while($row_purchase = mysql_fetch_assoc($sq_purchase)){			
                $purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
                $total_purchase = $total_purchase + $purchase_amt;
            }
            $sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));		
            $vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
            if($vendor_name == ''){ $vendor_name1 = 'NA';  }
            else{ $vendor_name1 = $vendor_name; }



            /////// Incetive ////////
            $sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_sales_incentive where booking_id='$row_customer[booking_id]'"));
            
            //////////Invoice//////////////
            $invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);
            $invoice_date = date('d-m-Y',strtotime($row_customer['booking_date']));
            $customer_id = $row_customer['customer_id'];
            $quotation_id = $row_customer['quotation_id'];
            $service_name = "Package Invoice";			
            
            //**Service Tax
            $taxation_type = $row_customer['taxation_type'];
            
            //basic amount
            $train_expense = $row_customer['train_expense'];
            $plane_expense = $row_customer['plane_expense'];
            $cruise_expense = $row_customer['cruise_expense'];
            $visa_amount = $row_customer['visa_amount'];
            $insuarance_amount = $row_customer['insuarance_amount'];
            $tour_subtotal = $row_customer['subtotal'] - $cancel_tour_amount;
            $basic_cost = $train_expense +$plane_expense +$cruise_expense +$visa_amount +$insuarance_amount +$tour_subtotal;

            //Service charge	
            $train_service_charge = $row_customer['train_service_charge'];
            $plane_service_charge = $row_customer['plane_service_charge'];
            $cruise_service_charge = $row_customer['cruise_service_charge'];
            $visa_service_charge = $row_customer['visa_service_charge'];
            $insuarance_service_charge = $row_customer['insuarance_service_charge'];
            $service_charge = $train_service_charge +$plane_service_charge +$cruise_service_charge +$visa_service_charge +$insuarance_service_charge +$tour_subtotal;

            //service tax
            $train_service_tax = $row_customer['train_service_tax'];
            $plane_service_tax = $row_customer['plane_service_tax'];
            $cruise_service_tax = $row_customer['cruise_service_tax'];
            $visa_service_tax = $row_customer['visa_service_tax'];
            $insuarance_service_tax = $row_customer['insuarance_service_tax'];
            $tour_service_tax = $row_customer['tour_service_tax'];
            
            //service tax subtotal	
            $train_service_tax_subtotal = $row_customer['train_service_tax_subtotal'];
            $plane_service_tax_subtotal = $row_customer['plane_service_tax_subtotal'];
            $cruise_service_tax_subtotal = $row_customer['cruise_service_tax_subtotal'];
            $visa_service_tax_subtotal = $row_customer['visa_service_tax_subtotal'];
            $insuarance_service_tax_subtotal = $row_customer['insuarance_service_tax_subtotal'];
            $tour_service_tax_subtotal = $row_customer['tour_service_tax_subtotal'];
            $service_tax_subtotal = $train_service_tax_subtotal +$plane_service_tax_subtotal +$cruise_service_tax_subtotal +$visa_service_tax_subtotal +$insuarance_service_tax_subtotal+$tour_service_tax_subtotal;

            // Net amount
            $net_amount = 0;
            $tour_total_amount= ($row_customer['actual_tour_expense']!="") ? $row_customer['actual_tour_expense']: 0;
            $net_amount  =  $tour_total_amount + $row_customer['total_travel_expense'] - $cancel_tour_amount;
            
            $sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Package Tour'"));   
            $sac_code = $sq_sac['hsn_sac_code'];
            $tour_date = get_date_user($row_customer['tour_from_date']);
            $destination_city = $row_customer['tour_name'];
   

    	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, $invoice_no)
            ->setCellValue('D'.$row_count, $sq_cust['company_name'])
            ->setCellValue('E'.$row_count, $row_customer['contact_no'])
            ->setCellValue('F'.$row_count, $row_customer['email_id'])
            ->setCellValue('G'.$row_count, get_date_user($row_customer['created_at']))
            ->setCellValue('H'.$row_count, number_format($servie_total,2))
            ->setCellValue('I'.$row_count, '0')
            ->setCellValue('J'.$row_count, number_format($servie_total,2))
            ->setCellValue('K'.$row_count, number_format($payment_amount,2))
            ->setCellValue('L'.$row_count, number_format($outstanding, 2))
            ->setCellValue('M'.$row_count, number_format($total_purchase,2))
            ->setCellValue('N'.$row_count, $vendor_name1)
            ->setCellValue('O'.$row_count, $emp_name)
            ->setCellValue('P'.$row_count, number_format($sq_incentive['incentive_amount'],2));

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($content_style_Array);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':U'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

       $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, "")
        ->setCellValue('G'.$row_count, "")
        ->setCellValue('H'.$row_count, 'TOTAL SALE :'.number_format($net_total,2))
        ->setCellValue('I'.$row_count, 'TOTAL CANCEL : '.number_format($cancel_total,2))
        ->setCellValue('K'.$row_count, 'TOTAL PAID : '.number_format($paid_amount,2))
        ->setCellValue('L'.$row_count, 'TOTAL BALANCE :'.number_format($outstanding,2))
        ->setCellValue('M'.$row_count, '')
        ->setCellValue('N'.$row_count, '')
        ->setCellValue('O'.$row_count, '')
        ->setCellValue('P'.$row_count, '');

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':P'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':P'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="B2BBookingSummary('.date('d-m-Y H:i:s').').xls"');
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
