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

//////////////////****************Content start**************////////////
$row_count = 1;
 
$group_id =$_GET['group_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$active_filter = $_GET['active_filter'];
$chk_balance = $_GET['chk_balance'];
$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, "Sr. No")
        ->setCellValue('B'.$row_count, "Ledger_Name")
        ->setCellValue('C'.$row_count, "Opening_Bal")
        ->setCellValue('D'.$row_count, "Alias_Name")
        ->setCellValue('E'.$row_count, "Group_Name")
        ->setCellValue('F'.$row_count, "Closing_Bal");

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$query = "select * from ledger_master where 1 ";
if($group_id!=""){
    $query .= " and group_sub_id='$group_id'";	
}
if($active_filter!=""){
	$query .= " and status='$active_filter'";	
}
$count = 0;
$sq_gl = mysql_query($query);
while($row_gl = mysql_fetch_assoc($sq_gl)){

    $credit = 0;
    $debit = 0;
    $balance = 0;        
    $sq_sl = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$row_gl[group_sub_id]'"));
    $q1 = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Credit' and gl_id='$row_gl[ledger_id]'";
    if($branch_admin_id != '0'){
        $q1 .= " and branch_admin_id='$branch_admin_id'";
    }	

    $sq_trans_credit = mysql_fetch_assoc(mysql_query($q1));
    $credit += ($sq_trans_credit['sum']=="") ? 0 : $sq_trans_credit['sum'];
    
    $q2 = "select sum(payment_amount) as sum from finance_transaction_master where payment_side='Debit' and gl_id='$row_gl[ledger_id]'";
    if($branch_admin_id != '0'){
        $q2 .= " and branch_admin_id='$branch_admin_id'";
    }	

    $sq_trans_debit = mysql_fetch_assoc(mysql_query($q2));
    $debit += ($sq_trans_debit['sum']=="") ? 0 : $sq_trans_debit['sum'];			

    $balance = $balance + $row_gl['balance'];
    if($debit>$credit){
        $balance = $balance + $debit - $credit;
        $side_t1='(Dr)';
    }
    else{
        $balance = $balance + $credit - $debit;
        $side_t1='(Cr)';
    }
    if($row_gl['balance_side'] == 'Credit') $balance_side = '(Cr)';
    else if($row_gl['balance_side'] == 'Debit') $balance_side = '(Dr)';
    else $balance_side = '';

    if($chk_balance == 0){
        if($balance > 0){
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row_count, $row_gl['ledger_id'])
            ->setCellValue('B'.$row_count, $row_gl['ledger_name'])
            ->setCellValue('C'.$row_count, number_format($row_gl['balance'],2).$balance_side)
            ->setCellValue('D'.$row_count, $row_gl['alias'])
            ->setCellValue('E'.$row_count, $sq_sl['subgroup_name'])
            ->setCellValue('F'.$row_count, number_format($balance,2).$side_t1);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($borderArray);

            $row_count++;
        }
    }
    else{
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$row_count, $row_gl['ledger_id'])
        ->setCellValue('B'.$row_count, $row_gl['ledger_name'])
        ->setCellValue('C'.$row_count, number_format($row_gl['balance'],2).$balance_side)
        ->setCellValue('D'.$row_count, $row_gl['alias'])
        ->setCellValue('E'.$row_count, $sq_sl['subgroup_name'])
        ->setCellValue('F'.$row_count, number_format($balance,2).$side_t1);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':F'.$row_count)->applyFromArray($borderArray);
        $row_count++;
    }
}
////////////****************Content End**************////////////////////
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Account Ledger('.date('d-m-Y H:i:s').').xls"');
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