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
$booker_id = $_GET['booker_id'];
$branch_id = $_GET['branch_id'];
$id = $_GET['id'];
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

$invoice_id = ($id!="") ? get_group_booking_id($id): "";

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
            ->setCellValue('C2', 'Group Tour Summary')
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

        $query = "select * from tourwise_traveler_details where 1 ";
        if($customer_id!=""){
            $query .= " and customer_id='$customer_id'";
        }
        if($id!=""){
            $query .= " and id='$id'";
        }
        if($from_date!="" && $to_date!=""){
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));
            $query .= " and form_date between '$from_date' and '$to_date'";
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
        $query .= " order by id desc";

        $row_count = 11;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, "Sr. No")
                ->setCellValue('C'.$row_count, "Booking ID")
                ->setCellValue('D'.$row_count, "Customer Name")
                ->setCellValue('E'.$row_count, "Contact")
                ->setCellValue('F'.$row_count, "EMAIL ID")
                ->setCellValue('G'.$row_count, "Total Guest")
                ->setCellValue('H'.$row_count, "Booking Date")
                ->setCellValue('I'.$row_count, "Tour Name")
                ->setCellValue('J'.$row_count, "Tour Date")
                ->setCellValue('K'.$row_count, "Basic Amount")
                ->setCellValue('L'.$row_count, "Tax")
                ->setCellValue('M'.$row_count, "Credit card Charges")
                ->setCellValue('N'.$row_count, "Sale")
                ->setCellValue('O'.$row_count, "Cancel")
                ->setCellValue('P'.$row_count, "Total")
                ->setCellValue('Q'.$row_count, "Paid")
                ->setCellValue('R'.$row_count, "Outstanding Balance")
                ->setCellValue('S'.$row_count, "Due Date")
                ->setCellValue('T'.$row_count, "Purchase")
                ->setCellValue('U'.$row_count, "Purchased From")
                ->setCellValue('V'.$row_count, "Branch")
                ->setCellValue('W'.$row_count, "Booked By")
                ->setCellValue('X'.$row_count, "Incentive");


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($borderArray);    

        $row_count++;

        $count = 0;
        $total_balance=0;
        $total_refund=0;        
        $cancel_total =0;
        $sale_total = 0;
        $paid_total = 0;
        $balance_total = 0;

        $sq_package = mysql_query($query);
        while($row_booking = mysql_fetch_assoc($sq_package))
        {
            
            $pass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
            $cancelpass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));    
            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_booking[emp_id]'"));
            if($sq_emp['first_name'] == '') { $emp_name='Admin';}
            else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

            $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
            $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
            
            $sq_total_member = mysql_num_rows(mysql_query("select traveler_group_id from travelers_details where traveler_group_id = '$row_booking[id]' AND status!='Cancel'"));
            $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
            $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
            $email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
            if($sq_customer_info['type'] == 'Corporate'){
                $customer_name = $sq_customer_info['company_name'];
            }else{
                $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
            }

            $sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum,sum(credit_charges) as sumc from payment_master where tourwise_traveler_id='$row_booking[id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
            $paid_amount = $sq_paid_amount['sum'];
            $credit_card_charges = $sq_paid_amount['sumc'];

            //sale amount
	        $tour_fee = $row_booking['net_total'] + $credit_card_charges;

            //cancel amount
            $sq_est_count = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
            if($sq_est_count!='0'){
                $sq_est_info= mysql_fetch_assoc(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
                $tour_esti=$sq_est_info['cancel_amount'];
            }
            else{
                $sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row_booking[id]'"));
                $tour_esti=$sq_est_info['cancel_amount'];
            }
            //total amount
            $total_amount = $tour_fee - $tour_esti;

            //balance
            if($paid_amount > 0){
                if($pass_count==$cancelpass_count){
                    $total_balance = 0;
                }else{
                    $total_balance = $total_amount - $paid_amount + $credit_card_charges;
                }
            }else{
                $total_balance = $cancel_amount;
            }  
            
           //Footer
            $cancel_total = $cancel_total + $tour_esti;
            $sale_total = $sale_total + $total_amount+$tour_esti;
            $paid_total = $paid_total + $sq_paid_amount['sum']+$credit_card_charges;
            $balance_total = $balance_total + $total_balance;

            /////// Purchase ////////
            $total_purchase = 0;
            $purchase_amt = 0;
            $i=0;
            $sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'"));
            if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
            $sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'");
            while($row_purchase = mysql_fetch_assoc($sq_purchase)){
                $p_due_date = get_date_user($row_purchase['due_date']);             
                $purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
                $total_purchase = $total_purchase + $purchase_amt;
            }
            $sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'"));        
            $vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
            if($vendor_name == ''){ $vendor_name1 = 'NA';  }
            else{ $vendor_name1 = $vendor_name; }

            /////// Incetive ////////
            $sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_incentive_group_tour where tourwise_traveler_id='$row_booking[id]'"));

            ///Tour
            $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$row_booking[tour_id]'"));

            $sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$row_booking[tour_group_id]'"));
            $tour = $sq_tour['tour_name'];

            $group = get_date_user($sq_group['from_date']).' To '.get_date_user($sq_group['to_date']);   
            //Service Tax and Markup Tax
            $service_tax_amount = 0;
            if($row_booking['service_tax'] !== 0.00 && ($row_booking['service_tax']) !== ''){
                $service_tax_subtotal1 = explode(',',$row_booking['service_tax']);
                for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
                $service_tax = explode(':',$service_tax_subtotal1[$i]);
                $service_tax_amount +=  $service_tax[2];
                }
            }
    	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, get_group_booking_id($row_booking['id']))
            ->setCellValue('D'.$row_count, $customer_name)
            ->setCellValue('E'.$row_count, $contact_no)
            ->setCellValue('F'.$row_count, $email_id)
            ->setCellValue('G'.$row_count, $sq_total_member)
            ->setCellValue('H'.$row_count, get_date_user($row_booking['form_date']))
            ->setCellValue('I'.$row_count, $tour)
            ->setCellValue('J'.$row_count, $group)
            ->setCellValue('K'.$row_count, number_format($row_booking['basic_amount'],2))
            ->setCellValue('L'.$row_count, number_format($service_tax_amount,2))
            ->setCellValue('M'.$row_count, number_format($credit_card_charges,2))
            ->setCellValue('N'.$row_count, number_format($tour_fee,2))
            ->setCellValue('O'.$row_count, number_format($tour_esti,2))
            ->setCellValue('P'.$row_count, number_format($total_amount,2))
            ->setCellValue('Q'.$row_count, number_format($sq_paid_amount['sum']+ $credit_card_charges,2))
            ->setCellValue('R'.$row_count, number_format($total_balance,2))
            ->setCellValue('S'.$row_count, get_date_user($row_booking['balance_due_date']))
            ->setCellValue('T'.$row_count, number_format($total_purchase,2))
            ->setCellValue('U'.$row_count, $vendor_name1)
            ->setCellValue('V'.$row_count, $branch_name)
            ->setCellValue('W'.$row_count, $emp_name)
            ->setCellValue('X'.$row_count, number_format($sq_incentive['incentive_amount'],2));

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($content_style_Array);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':X'.$row_count)->applyFromArray($borderArray);    

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
        ->setCellValue('M'.$row_count, 'TOTAL CANCEL : '.number_format($cancel_total,2))
        ->setCellValue('L'.$row_count, 'TOTAL SALE :'.number_format($sale_total,2))
        ->setCellValue('N'.$row_count, 'TOTAL PAID : '.number_format($paid_total,2))
        ->setCellValue('O'.$row_count, 'TOTAL BALANCE :'.number_format($balance_total,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="GroupTourSummary('.date('d-m-Y H:i:s').').xls"');
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
