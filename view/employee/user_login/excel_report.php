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
$row_count = 1;
 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];

$login_id =$_GET['login_id'];
$from_date =$_GET['from_date'];
$to_date =$_GET['to_date'];
$branch_status =$_GET['branch_status'];

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, "Sr. No")

        ->setCellValue('B'.$row_count, "User_Name")

        ->setCellValue('C'.$row_count, "Login_Date/Time")

        ->setCellValue('D'.$row_count, "Logout_Date/Time")

        ->setCellValue('E'.$row_count, "IP_Address");



$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':E'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':E'.$row_count)->applyFromArray($borderArray);    



$row_count++;
$query = "select * from user_logs where 1 ";

if($login_id!=""){
  $query .= " and login_id='$login_id'";
}
if($from_date!='' && $to_date!=''){
  $from_date1 = date('Y-m-d', strtotime($from_date));
  $to_date1 = date('Y-m-d', strtotime($to_date));
  $query .=" and login_date between '$from_date1' and '$to_date1'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' ||$role=='Hr'){
		$query .= " and login_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Hr'){
		$query .= " and login_id in(select emp_id from emp_master where emp_id='$emp_id' and branch_id='$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr'){
	$query .= " and login_id in(select emp_id from emp_master where emp_id='$emp_id')";
}

$count = 0;
    $sq_log = mysql_query($query);
    while($row_log = mysql_fetch_assoc($sq_log)){

      if($row_log['login_time']!="00:00:00"){
      //$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$row_log[login_id]'"));
      $sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_log[login_id]'"));

      $login_time = $row_log['login_time'];
      if($login_time=="" || $login_time=="00:00:00"){
        $login_time = "N/A";
      }
      $logout_time = $row_log['logout_time'];
      if($logout_time=="" || $logout_time=="00:00:00" ){
        $logout_time = "";
      }
      $logout_date1 = $row_log['logout_date'];
      if($logout_date1=="" || $logout_date1=="0000-00-00"){
        $logout_date1 = "";
      }
      else
      {
        $logout_date1= date('d-m-Y', strtotime($logout_date1));
      }
       
    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, ++$count)

        ->setCellValue('B'.$row_count, ($sq_emp_info['first_name']=="") ? 'Admin' : $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'])

        ->setCellValue('C'.$row_count, date('d-m-Y', strtotime($row_log['login_date'])).' '.$login_time)

        ->setCellValue('D'.$row_count, $logout_date1.' '.$logout_time)

        ->setCellValue('E'.$row_count, $row_log['user_ip']);


	



    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':E'.$row_count)->applyFromArray($content_style_Array);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':E'.$row_count)->applyFromArray($borderArray);    



		$row_count++;



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

header('Content-Disposition: attachment;filename="User_Log('.date('d-m-Y H:i:s').').xls"');

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

