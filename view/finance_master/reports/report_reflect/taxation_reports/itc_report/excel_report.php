<?php
include "../../../../../../model/model.php";
include_once('../itc_report/vendor_generic_functions.php');
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
$branch_status = $_GET['branch_status'];
$role = $_GET['role'];
$branch_admin_id = $_GET['branch_admin_id'];

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'ITC Report')
            ->setCellValue('B3', 'From-To-Date')
            ->setCellValue('C3', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);


$query = "select * from vendor_estimate where status='' ";
$count=1;

$row_count = 7;
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and purchase_date between '$from_date' and '$to_date' ";
}
if($branch_status=='yes'){
  if($role=='Branch Admin'){
  $query .= " and branch_admin_id = '$branch_admin_id'";
  } 
  elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
}
$sq_setting = mysql_fetch_assoc(mysql_query("select * from app_settings where setting_id='1'"));

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Service Name")
        ->setCellValue('D'.$row_count, "SAC/HSN Code")
        ->setCellValue('E'.$row_count, "Supplier Name")
        ->setCellValue('F'.$row_count, "GSTIN/UIN")
        ->setCellValue('G'.$row_count, "Account State")
        ->setCellValue('H'.$row_count, "Purchase ID")
        ->setCellValue('I'.$row_count, "Purchase Date")
        ->setCellValue('J'.$row_count, "Type Of Supplies")
         ->setCellValue('K'.$row_count, "Place of Supply")
         ->setCellValue('L'.$row_count, "Net Amont")
        ->setCellValue('M'.$row_count, "Taxable Amount")
        ->setCellValue('N'.$row_count, "Tax_%")
        ->setCellValue('O'.$row_count, "Tax Amount")
        ->setCellValue('P'.$row_count, "Cess%")
        ->setCellValue('Q'.$row_count, "Cess Amount")
        ->setCellValue('R'.$row_count, "ITC Eligibility")
        ->setCellValue('S'.$row_count, "Reverse Charge");


$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$tax_total = 0;
$sq_sales = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_sales)){

    $vendor_name = get_vendor_name($row_query['vendor_type'],$row_query['vendor_type_id']);
    $vendor_info = get_vendor_info($row_query['vendor_type'], $row_query['vendor_type_id']);
    $hsn_code = get_service_info($row_query['estimate_type']);

    $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$vendor_info[state_id]'"));
    $sq_supply = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_setting[state_id]'"));
    
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
    //Taxable amount
    $taxable_amount = ($service_tax_amount / $tax_per) * 100;
    $tax_total += $service_tax_amount;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, $row_query['estimate_type'])
        ->setCellValue('D'.$row_count, $hsn_code)
        ->setCellValue('E'.$row_count, $vendor_name)
        ->setCellValue('F'.$row_count, ($vendor_info['service_tax'] == '') ? 'NA' : $vendor_info['service_tax'])
        ->setCellValue('G'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] )
        ->setCellValue('H'.$row_count, $row_query['estimate_id'])
        ->setCellValue('I'.$row_count, get_date_user($row_query['purchase_date']))
         ->setCellValue('J'.$row_count, ($vendor_info['service_tax'] == '') ? 'Unregistered' : 'Registered')
         ->setCellValue('K'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
         ->setCellValue('L'.$row_count, $row_query['net_total'])
         ->setCellValue('M'.$row_count, number_format($taxable_amount,2))
         ->setCellValue('N'.$row_count, $tax_name)
         ->setCellValue('O'.$row_count, number_format($service_tax_amount,2))
        ->setCellValue('P'.$row_count,'0.00')
        ->setCellValue('Q'.$row_count,'0.00')
        ->setCellValue('R'.$row_count, '')
        ->setCellValue('S'.$row_count, '');

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);

    $row_count++;
}
//Expense Booking
$query = "select * from other_expense_master where 1 ";
if($from_date !='' && $to_date != ''){
    $from_date = get_date_db($from_date);
    $to_date = get_date_db($to_date);
    $query .= " and expense_date between '$from_date' and '$to_date' ";
}
$sq_query = mysql_query($query);
while($row_query = mysql_fetch_assoc($sq_query))
{
    
	$tax_amount = 0;
	$taxable_amount = $row_query['amount'];
	$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_query[expense_type_id]'"));
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$row_query[supplier_id]'"));

	$sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_customer[state_id]'"));
	$sq_sac = get_service_info('Other Expense');

	$tax_amount = $row_query['service_tax_subtotal'];
	$ledgers = explode(',',$row_query['ledgers']);
	$sq_tax_name1 = mysql_fetch_assoc(mysql_query("select ledger_name from ledger_master where ledger_id ='$ledgers[0]'"));
	$ledger_name = $sq_tax_name1['ledger_name'];
	$tax_total += $tax_amount;
	//For second selected ledger
	if(sizeof($ledgers) >0 && $ledger_name!=''){
		$sq_tax_name2 = mysql_fetch_assoc(mysql_query("select ledger_name from ledger_master where ledger_id ='$ledgers[1]'"));
		$ledger_name .= ','.$sq_tax_name2['ledger_name'];
	}
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, $count++)
    ->setCellValue('C'.$row_count, $sq_income_type_info['ledger_name'] )
    ->setCellValue('D'.$row_count, $sq_sac)
    ->setCellValue('E'.$row_count, $sq_customer['vendor_name'])
    ->setCellValue('F'.$row_count, ($vendor_info['service_tax_no'] == '') ? 'NA' : $vendor_info['service_tax_no'])
    ->setCellValue('G'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] )
    ->setCellValue('H'.$row_count, $row_query['expense_id'])
    ->setCellValue('I'.$row_count, get_date_user($row_query['expense_date']))
    ->setCellValue('J'.$row_count, ($vendor_info['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
    ->setCellValue('K'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
    ->setCellValue('L'.$row_count, $row_query['total_fee'])
    ->setCellValue('M'.$row_count, number_format($taxable_amount,2) )
    ->setCellValue('N'.$row_count, $ledger_name)
    ->setCellValue('O'.$row_count, number_format($tax_amount,2))
    ->setCellValue('P'.$row_count, "0.00")
    ->setCellValue('Q'.$row_count,"0.00")
    ->setCellValue('R'.$row_count, "")
    ->setCellValue('S'.$row_count, "");

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);

    $row_count++;
}
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count,'')
        ->setCellValue('C'.$row_count,'')
        ->setCellValue('D'.$row_count,'')
        ->setCellValue('E'.$row_count,'')
        ->setCellValue('F'.$row_count,'')
        ->setCellValue('G'.$row_count,'')
        ->setCellValue('H'.$row_count,'')
        ->setCellValue('I'.$row_count,'')
        ->setCellValue('J'.$row_count,'')
        ->setCellValue('K'.$row_count,'')
        ->setCellValue('L'.$row_count,'')
        ->setCellValue('M'.$row_count,'')
        ->setCellValue('N'.$row_count,'')
        ->setCellValue('O'.$row_count,'Total Tax: '.number_format($tax_total,2))
        ->setCellValue('P'.$row_count,'')
        ->setCellValue('Q'.$row_count,'')
        ->setCellValue('R'.$row_count,'')
        ->setCellValue('S'.$row_count,'');

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);


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
header('Content-Disposition: attachment;filename="ITC Report('.date('d-m-Y H:i:s').').xls"');
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
