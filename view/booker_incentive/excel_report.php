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

$role = $_SESSION['role'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_GET['emp_id'];



if($emp_id!=""){
  $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
  $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name'];
}else{
  $emp_name="";
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Sales Incentive Payment')
            ->setCellValue('B3', 'Sales Name')
            ->setCellValue('C3', $emp_name);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    



$query = "select * from booker_sales_incentive where 1 ";

if($emp_id!=""){

  $query .=" and emp_id='$emp_id'";

}
if($role=='Branch Admin' && $branch_status=='yes')
{
  $query .= " and branch_admin_id='$branch_admin_id'";
}
$query .=" order by payment_id desc";



$row_count = 6;



$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "Sr. No")

        ->setCellValue('C'.$row_count, "Sales Name")

        ->setCellValue('D'.$row_count, "Payment Date")

        ->setCellValue('E'.$row_count, "Mode")

        ->setCellValue('F'.$row_count, "Amount");

         

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    



$row_count++;



$count = 0;

$incentive_total = 0;



    $query1 = "select sum(incentive_amount) as incentive_amount from booker_incentive_group_tour where 1 ";
 
    if($role=='Branch Admin' && $branch_status=='yes')
    {
      $query1 .= " and emp_id in (select emp_id from emp_master where branch_id='$branch_admin_id')";
    }
   
    $sq_payment = mysql_query($query1);

      $sq_incentive1 = mysql_fetch_assoc($sq_payment);

    $query2 = "select sum(incentive_amount) as incentive_amount from booker_incentive_package_tour where 1 ";
 
    if($role=='Branch Admin' && $branch_status=='yes')
    {
      $query2 .= " and emp_id in (select emp_id from emp_master where branch_id='$branch_admin_id')";
    }
   
    $sq_pay = mysql_query($query2);

      $sq_incentive2 = mysql_fetch_assoc($sq_pay);

    $incentive_total = $sq_incentive1['incentive_amount'] + $sq_incentive2['incentive_amount'];

     
    $query3 = "select sum(payment_amount) as paid_amount , branch_admin_id from booker_incentive_payment_master where 1 and (clearance_status != 'Cancelled' and clearance_status != 'Pending')";
 
    if($role=='Branch Admin' && $branch_status=='yes')
    {
      $query3 .= " and branch_admin_id='$branch_admin_id'";
    }
 
    $sq_pay1 = mysql_query($query3);
      $sq_paid = mysql_fetch_assoc($sq_pay1);
    $paid_amount = $sq_paid['paid_amount'];

    if($emp_id != ''){
        $paid_amount = 0;
        $incentive_total = 0;

          $sq_in_g =  mysql_fetch_assoc(mysql_query("select * from booker_incentive_group_tour where emp_id='$emp_id'"));
          $incentive_git =  $incentive_git + $sq_in_g['incentive_amount'];

          $sq_in_f =  mysql_fetch_assoc(mysql_query("select * from booker_incentive_package_tour where emp_id='$emp_id'"));
          $incentive_fit =  $incentive_fit + $sq_in_f['incentive_amount'];

          $incentive_total = $incentive_git + $incentive_fit;
          
          $sq_query = "select sum(payment_amount) as paid_sum from booker_incentive_payment_master where emp_id='$emp_id' and (clearance_status != 'Cancelled' and clearance_status != 'Pending')";
          $sq_paid =  mysql_fetch_assoc(mysql_query($sq_query));
              $paid_amount =  $paid_amount + $sq_paid['paid_sum'];            
        }

    $sq_payment = mysql_query($query);

    while($row_payment = mysql_fetch_assoc($sq_payment))

    {

            $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_payment[emp_id]'"));

            if($sq_emp['first_name']==''){

        $emp_name = 'Admin';

      }

      else{

        $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name'];

      }

            if($row_payment['clearance_status']=="Pending"){ $bg='warning';

      }

      else if($row_payment['clearance_status']=="Cancelled"){ $bg='danger';

      }

      else{

        $bg='';

      }      

		  $balance_amount = $incentive_total - $paid_amount;



	$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, ++$count)

        ->setCellValue('C'.$row_count, $emp_name)

        ->setCellValue('D'.$row_count, date('d/m/Y', strtotime($row_payment['payment_date'])))

        ->setCellValue('E'.$row_count, $row_payment['payment_mode'])

        ->setCellValue('F'.$row_count, $row_payment['payment_amount'] );

         

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($content_style_Array);

	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);    



    $row_count++;



        $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "")

        ->setCellValue('C'.$row_count, "")

        ->setCellValue('D'.$row_count, 'Total Incentive : '.number_format($incentive_total,2))

        ->setCellValue('E'.$row_count, 'Paid Incentive : '.number_format($paid_amount,2))

        ->setCellValue('F'.$row_count, 'Balance Incentive : '.number_format($balance_amount,2));

         

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':F'.$row_count)->applyFromArray($borderArray);



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

header('Content-Disposition: attachment;filename="Sales_Incentive_Payment('.date('d-m-Y H:i:s').').xls"');

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

