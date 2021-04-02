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
$financial_year = $_GET['financial_year'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];
$booker_id = $_GET['booker_id'];
$branch_id = $_GET['branch_id'];

if($customer_id!=""){
	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['middle_name'].' '.$sq_customer_info['last_name'];
}
else{
	$cust_name = "";
}

$invoice_id = ($booking_id!="") ? get_car_rental_booking_id($booking_id): "";

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
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Car Rental Summary')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
            ->setCellValue('B5', 'From-To Date')
            ->setCellValue('C5', $date_str)
            ->setCellValue('B6', 'Customer Type')
            ->setCellValue('C6', $cust_type)
            ->setCellValue('B7', 'Company Name')
            ->setCellValue('C7', $company_name)
            ->setCellValue('B8', 'Booked By')
            ->setCellValue('C8', $emp_name)
            ->setCellValue('B9', 'Branch')
            ->setCellValue('C9', $branch_name);

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

$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($borderArray); 

$query = "select * from car_rental_booking where 1 ";
if($customer_id!=""){
    $query .= " and customer_id='$customer_id'";
}
if($booking_id!=""){
    $query .= " and booking_id='$booking_id'";
}
if($from_date!="" && $to_date!=""){
    $from_date = date('Y-m-d', strtotime($from_date));
    $to_date = date('Y-m-d', strtotime($to_date));
    $query .= " and created_at between '$from_date' and '$to_date'";
}
if($cust_type != ""){
    $query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
    $query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($booker_id!=""){
    $query .= " and emp_id='$booker_id'";
}
if($branch_id!=""){
    $query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_id')";
}
if($branch_status=='yes'){
    if($role=='Branch Admin'){
    $query .= " and branch_admin_id = '$branch_admin_id'";
    }   
    elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id ='$emp_id'";
    }
}
$query .= " order by booking_id desc";
$row_count =11;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, "Sr. No")
                ->setCellValue('C'.$row_count, "Booking ID")
                ->setCellValue('D'.$row_count, "Customer_Name")
                ->setCellValue('E'.$row_count, "Contact")
                ->setCellValue('F'.$row_count, "EMAIL_ID")
                ->setCellValue('G'.$row_count, "Total_Guest")
                ->setCellValue('H'.$row_count, "Reference")
                ->setCellValue('I'.$row_count, "Travel_type")
                ->setCellValue('J'.$row_count, "Booking_Date")
                ->setCellValue('K'.$row_count, "Basic_Amount") 
                ->setCellValue('L'.$row_count, "Tax")
                ->setCellValue('M'.$row_count, "Credit card charges")  
                ->setCellValue('N'.$row_count, "Other_Charges")  
                ->setCellValue('O'.$row_count, "Sale")
                ->setCellValue('P'.$row_count, "Cancel")
                ->setCellValue('Q'.$row_count, "Total")
                ->setCellValue('R'.$row_count, "Paid")
                ->setCellValue('S'.$row_count, "Outstanding Balance")
                ->setCellValue('T'.$row_count, "Due_Date")
                ->setCellValue('U'.$row_count, "Purchase")
                ->setCellValue('V'.$row_count, "Purchased_From")
                ->setCellValue('W'.$row_count, "Branch")
                ->setCellValue('X'.$row_count, "Booked_By")
                ->setCellValue('Y'.$row_count, "Quotation_no");


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Y'.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Y'.$row_count)->applyFromArray($borderArray);    

        $row_count++;

        $count = 0;
        $total_balance=0;
        $total_refund=0;        
        $cancel_total =0;
        $sale_total = 0;
        $paid_total = 0;
        $balance_total = 0;

        $sq_car = mysql_query($query);
        while($row_car = mysql_fetch_assoc($sq_car)){
            $date = $row_car['created_at'];
             $yr = explode("-", $date);
             $year =$yr[0];
            $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_car[customer_id]'"));
			$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
            if($sq_customer_info['type'] == 'Corporate'){
                $customer_name = $sq_customer_info['company_name'];
            }else{
                $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
            }

            $sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row_car[enquiry_id]'"));
            $sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$sq_enq[reference_id]'"));

            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_car[emp_id]'"));
            if($sq_emp['first_name'] == '') { $emp_name='Admin';}
            else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

            $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
            $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];

            $sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from car_rental_payment where booking_id='$row_car[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

            $total_sale=$row_car['total_fees'] + $sq_paid_amount['sumc'];
            $cancel_amount=$row_car['cancel_amount'];
            if($cancel_amount==""){ $cancel_amount=0.00; } 
            $paid_amount = $sq_paid_amount['sum']+$sq_paid_amount['sumc'];
            $total_bal = $total_sale - $cancel_amount;  
            //$bal = $total_bal - $paid_amount; 
            if($paid_amount > 0){
				if($row_car['status']=='Cancel'){
					$bal = 0;
				}else{
					$bal = $total_bal - $paid_amount;
				}
			}else{
				$bal = $cancel_amount;
			}

            $due_date= ($row_car['due_date'] == '1970-01-01') ? 'NA' : get_date_user($row_car['due_date']);
            if($paid_amount==""){  $paid_amount=0; } 

            if($bal>=0){
                $total_balance=$total_balance + $bal;
            }else{
                $total_refund =$total_refund+ abs($bal);
            }       
            $other_charges = $row_car['driver_allowance'] + $row_car['permit_charges'] + $row_car['toll_and_parking'] + $row_car['state_entry_tax'];

            //Footer
            $cancel_total = $cancel_total + $cancel_amount;
            $sale_total = $sale_total + $total_bal;
            $paid_total = $paid_total + $paid_amount;
            $balance_total = $balance_total + $bal;
 
            //Service Tax and Markup Tax
            $service_tax_amount = 0;
            if($row_car['service_tax_subtotal'] !== 0.00 && ($row_car['service_tax_subtotal']) !== ''){
                $service_tax_subtotal1 = explode(',',$row_car['service_tax_subtotal']);
                for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                $service_tax = explode(':',$service_tax_subtotal1[$i]);
                $service_tax_amount +=  $service_tax[2];
                }
            }
            $markupservice_tax_amount = 0;
            if($row_car['markup_cost_subtotal'] !== 0.00 && $row_car['markup_cost_subtotal'] !== ""){
                $service_tax_markup1 = explode(',',$row_car['markup_cost_subtotal']);
                for($i=0;$i<sizeof($service_tax_markup1);$i++){
                $service_tax = explode(':',$service_tax_markup1[$i]);
                $markupservice_tax_amount += $service_tax[2];
            
                }
            }

            /////// Purchase ////////
            $total_purchase = 0;
            $purchase_amt = 0;
            $i=0;
            $p_due_date = '';
            $sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'"));
            if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
            $sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'");
            while($row_purchase = mysql_fetch_assoc($sq_purchase)){     
                $purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
                $total_purchase = $total_purchase + $purchase_amt;
            }
            $sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'"));       
            $vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
            if($vendor_name == ''){ $vendor_name1 = 'NA';  }
            else{ $vendor_name1 = $vendor_name; }   

    	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, get_car_rental_booking_id($row_car['booking_id'],$year))
            ->setCellValue('D'.$row_count, $customer_name)
            ->setCellValue('E'.$row_count, $contact_no)
            ->setCellValue('F'.$row_count, $email_id)
            ->setCellValue('G'.$row_count, $row_car['total_pax'])    
            ->setCellValue('H'.$row_count, $sq_ref['reference_name'])
            ->setCellValue('I'.$row_count, $row_car['travel_type'])
            ->setCellValue('J'.$row_count, get_date_user($row_car['created_at']))
            ->setCellValue('K'.$row_count, number_format($row_car['basic_amount']+$row_car['service_charge'] + $row_car['markup_cost'],2))
            ->setCellValue('L'.$row_count, number_format($service_tax_amount+$markupservice_tax_amount,2))
            ->setCellValue('M'.$row_count, number_format($sq_paid_amount['sumc'],2))
            ->setCellValue('N'.$row_count, number_format($other_charges,2))
            ->setCellValue('O'.$row_count, number_format($total_sale,2))
            ->setCellValue('P'.$row_count, number_format($cancel_amount, 2))
            ->setCellValue('Q'.$row_count, number_format($total_bal, 2))
            ->setCellValue('R'.$row_count, number_format($paid_amount, 2))
            ->setCellValue('S'.$row_count, number_format($bal, 2))
            ->setCellValue('T'.$row_count, $due_date)
            ->setCellValue('U'.$row_count, number_format($total_purchase,2))
            ->setCellValue('V'.$row_count, $vendor_name1)
            ->setCellValue('W'.$row_count, $branch_name)
            ->setCellValue('X'.$row_count, $emp_name)
            ->setCellValue('Y'.$row_count, get_quotation_id($row_car['quotation_id']));

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Y'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Y'.$row_count)->applyFromArray($borderArray); 

		$row_count++;

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, "")
        ->setCellValue('G'.$row_count, "")
        ->setCellValue('H'.$row_count, "")
        ->setCellValue('J'.$row_count, "")
        ->setCellValue('K'.$row_count, "")
        ->setCellValue('L'.$row_count, "")
        ->setCellValue('M'.$row_count, "")
        ->setCellValue('N'.$row_count, "")
        ->setCellValue('O'.$row_count, 'TOTAL SALE :'.number_format($sale_total,2))
        ->setCellValue('P'.$row_count, 'TOTAL CANCEL : '.number_format($cancel_total,2))
        ->setCellValue('Q'.$row_count, 'TOTAL PAID : '.number_format($paid_total,2))
        ->setCellValue('R'.$row_count, 'TOTAL BALANCE :'.number_format($balance_total,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="CarRentalSummary('.date('d-m-Y H:i:s').').xls"');
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
