<?php

include "../../../../../model/model.php";

/** Error reporting */

error_reporting(E_ALL);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

date_default_timezone_set('Europe/London');



if (PHP_SAPI == 'cli')

	die('This example should only be run from a Web Browser');



/** Include PHPExcel */

require_once '../../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';



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
$branch_admin_id = $_SESSION['branch_admin_id'];
$year =$_GET['year'];

$month =$_GET['month'];

$emp_id =$_GET['emp_id'];


$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, "Sr. No")

        ->setCellValue('B'.$row_count, "User_ID")

        ->setCellValue('C'.$row_count, "User_Name")

        ->setCellValue('D'.$row_count, "Days_Worked")

        ->setCellValue('E'.$row_count, "Gross_Salary")

        ->setCellValue('F'.$row_count, "salary_advance")

        ->setCellValue('G'.$row_count, "Employer_PF")

        ->setCellValue('H'.$row_count, "Employee_PF")

        ->setCellValue('I'.$row_count, "ESIC_Deduction")

        ->setCellValue('J'.$row_count, "PT_Deduction")

        ->setCellValue('K'.$row_count, "LWF_Deduction")

        ->setCellValue('L'.$row_count, "TDS_deduction")

        ->setCellValue('M'.$row_count, "Surcharge_deduction")

        ->setCellValue('N'.$row_count, "Cess_deduction")

        ->setCellValue('O'.$row_count, "leave_deduction")

        ->setCellValue('P'.$row_count, "Total_Deduction")

        ->setCellValue('Q'.$row_count, "Net_Salary");



$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':Q'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':Q'.$row_count)->applyFromArray($borderArray);    



$row_count++;
if($emp_id != '' || $year != '' || $month !=''){

$query = "select * from emp_master where 1 and active_flag!='Inactive'";
if($emp_id!=''){
  $query .= " and emp_id = '$emp_id'";
} 

 $count = 1;
    $sq_a = mysql_query($query);
    while($row_emp = mysql_fetch_assoc($sq_a)){ 
        $p_count =mysql_num_rows(mysql_query( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Present'"));

        $sq_salary = "select * from employee_salary_master where emp_id='$row_emp[emp_id]' ";
        if($year!=''){
          $sq_salary .= " and year = '$year'";
        } 
        if($month!=''){
          $sq_salary .= " and month = '$month'";
        }        
        $sq_sal1 =mysql_query($sq_salary);
        while($sq_sal = mysql_fetch_assoc($sq_sal1)){ 
       
    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, $count++)

        ->setCellValue('B'.$row_count, $row_emp['emp_id'])

        ->setCellValue('C'.$row_count, $row_emp['first_name'].' '.$row_emp['last_name'])

        ->setCellValue('D'.$row_count, $p_count)

        ->setCellValue('E'.$row_count, ($sq_sal['gross_salary']!="") ? $sq_sal['gross_salary'] : number_format(0,2))
        ->setCellValue('F'.$row_count, ($sq_sal['salary_advance']!="") ? $sq_sal['salary_advance'] : number_format(0,2))
        ->setCellValue('G'.$row_count, ($sq_sal['employer_pf']!="") ? $sq_sal['employer_pf'] : number_format(0,2))
        ->setCellValue('H'.$row_count, ($sq_sal['employee_pf']!="") ? $sq_sal['employee_pf'] : number_format(0,2))
        ->setCellValue('I'.$row_count, ($sq_sal['esic']!="") ? $sq_sal['esic'] : number_format(0,2))
        ->setCellValue('J'.$row_count, ($sq_sal['pt']!="") ? $sq_sal['pt']  : number_format(0,2))
        ->setCellValue('K'.$row_count, ($sq_sal['labour_all']!="") ?$sq_sal['labour_all'] : number_format(0,2))
        ->setCellValue('L'.$row_count, ($sq_sal['tds']!="") ? $sq_sal['tds'] : number_format(0,2))
        ->setCellValue('M'.$row_count, ($sq_sal['surcharge_deduction']!="") ? $sq_sal['surcharge_deduction'] : number_format(0,2))
        ->setCellValue('N'.$row_count, ($sq_sal['cess_deduction']!="") ? $sq_sal['cess_deduction'] : number_format(0,2))
        ->setCellValue('O'.$row_count, ($sq_sal['leave_deduction']!="") ? $sq_sal['leave_deduction'] : number_format(0,2))
        ->setCellValue('P'.$row_count, ($sq_sal['deduction']!="") ? $sq_sal['deduction'] : number_format(0,2))
        ->setCellValue('Q'.$row_count, ($sq_sal['net_salary']!="") ? $sq_sal['net_salary'] : number_format(0,2));


    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':Q'.$row_count)->applyFromArray($content_style_Array);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':Q'.$row_count)->applyFromArray($borderArray);    



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

header('Content-Disposition: attachment;filename="User_Salary('.date('d-m-Y H:i:s').').xls"');

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

