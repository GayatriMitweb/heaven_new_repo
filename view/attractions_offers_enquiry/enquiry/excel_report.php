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
$enquiry_type = $_GET['enquiry_type'];
$enquiry = $_GET['enquiry'];
$enquiry_status_filter = $_GET['enquiry_status'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$emp_id_filter = $_GET['emp_id_filter'];
$reference_id = $_GET['reference_id'];
$branch_id= $_GET['branch_id'];
$branch_status = $_GET['branch_status'];
$emp_id = $_SESSION['emp_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];

if($from_date=='undefined')
{
    $from_date='';
}
if($to_date=='undefined')
{
    $to_date='';
}
if($from_date!="" && $to_date!=""){

    $date_str = $from_date.' to '.$to_date;

}
else{

    $date_str = "";

}
if($reference_id!=""){

    $sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$reference_id'"));

    $reference_name = $sq_ref['reference_name'];

}
else{

    $reference_name = "";
}
if($emp_id_filter!=""){

    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id_filter'"));

    $employee_name = $sq_emp['first_name'].' '.$sq_emp['last_name'];

}
else{

    $employee_name = "";

}
if($branch_id!=""){

    $sq_branch= mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_id'"));

    $branch_name = $sq_branch['branch_name'];

}
else{

    $branch_name = "";

}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B2', 'Report Name')

            ->setCellValue('C2', 'Enquiry Report')

            ->setCellValue('B3', 'Enquiry')

            ->setCellValue('C3', $enquiry_type)

            ->setCellValue('B4', 'Enquiry Status')

            ->setCellValue('C4', $enquiry_status_filter)

            ->setCellValue('B5', 'From-To Date')

            ->setCellValue('C5', $date_str)

            ->setCellValue('B6', 'Reference')

            ->setCellValue('C6', $reference_name)

            ->setCellValue('B7', 'User')

            ->setCellValue('C7', $employee_name)

            ->setCellValue('B8', 'Enquiry Type')

            ->setCellValue('C8', $enquiry);



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

$query = "SELECT * FROM `enquiry_master` left join enquiry_master_entries as ef on enquiry_master.entry_id=ef.entry_id where enquiry_master.status!='Disabled'";

if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
if($emp_id_filter!="" && $emp_id_filter!=='undefined'){
    $query .=" and assigned_emp_id='$emp_id_filter'";
}
elseif($branch_status=='yes' && $role=='Branch Admin'){
  $query .= " and branch_admin_id='$branch_admin_id'";
}
if($enquiry!="" && $enquiry!=='undefined'){
    $query .=" and enquiry='$enquiry' ";
}
if($branch_filter!=""){
    $query .=" and branch_admin_id='$branch_filter' ";
}
if($enquiry_type!=""){
    $query .=" and enquiry_type='$enquiry_type' ";
}
if($reference_id!=""){
    $query .=" and reference_id='$reference_id' ";
}
if($from_date!='' && $from_date!='undefined' && $to_date!="" && $to_date!='undefined'){
	$from_date = get_date_db($from_date);
    $to_date = get_date_db($to_date);
    $query .=" and (enquiry_date between '$from_date' and '$to_date')";

}
if($branch_status=='yes' && $role!='Admin'){
		$query .= " and branch_admin_id = '$branch_admin_id'";
}
if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
    $query .= " and assigned_emp_id='$emp_id' and enquiry_master.status!='Disabled' ";  
    if($enquiry_type!=""){
        $query .=" and enquiry_type='$enquiry_type' ";
    }
    if($reference_id!=""){
        $query .=" and reference_id='$reference_id' ";
    }
    if($from_date!='' && $from_date!='undefined' && $to_date!="" && $to_date!='undefined'){
        $from_date = get_date_db($from_date);
        $to_date = get_date_db($to_date);
        $query .=" and (enquiry_date between '$from_date' and '$to_date')";
    }
    if($enquiry!=""){
        $query .=" and enquiry='$enquiry' ";
    }
}


if($enquiry_status_filter!='')
{
	if($enquiry_status_filter=='Active'){
		$query .= " and ef.followup_status='Active'";
	}
	if($enquiry_status_filter=='In-Followup'){
		$query .= " and ef.followup_status='In-Followup' ";
	}
	if($enquiry_status_filter=='Converted'){
		$query .= " and ef.followup_status='$enquiry_status_filter'";
	}
	if($enquiry_status_filter=='Dropped'){
		$query .= " and ef.followup_status='$enquiry_status_filter'";
	}
}

$query .= " ORDER BY enquiry_master.enquiry_id DESC ";
$count = 0;
$row_count = 10;

$sq_enquiries = mysql_query($query);
$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('B'.$row_count, "SR.No")

        ->setCellValue('C'.$row_count, "Enquiry No")

        ->setCellValue('D'.$row_count, "Customer")

        ->setCellValue('E'.$row_count, "Tour")

        ->setCellValue('F'.$row_count, "Mobile")

        ->setCellValue('G'.$row_count, "Email")

        ->setCellValue('H'.$row_count, "Reference")

        ->setCellValue('I'.$row_count, "Status")

        ->setCellValue('J'.$row_count, "Enquiry Date")

        ->setCellValue('K'.$row_count, "Followup Date")

        ->setCellValue('L'.$row_count, "Enquiry Type")

        ->setCellValue('M'.$row_count, "Allocate To");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':M'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':M'.$row_count)->applyFromArray($borderArray);


while($row = mysql_fetch_assoc($sq_enquiries)){
	$date = $row['enquiry_date'];
	$yr = explode("-", $date);
	$year =$yr[0];

    $enquiry_id = $row['enquiry_id'];

	$assigned_emp_id = $row['assigned_emp_id'];
	$sq_emp = mysql_fetch_assoc(mysql_query("select first_name,last_name from emp_master where emp_id='$assigned_emp_id'"));

	$enquiry_content = $row['enquiry_content'];
	$enquiry_content_arr1 = json_decode($enquiry_content, true);

	$enquiry_status1 = mysql_fetch_assoc(mysql_query("select followup_date,followup_reply,followup_status from enquiry_master_entries where enquiry_id='$row[enquiry_id]' order by entry_id DESC"));
	$followup_date1 = $enquiry_status1['followup_date'];
	if($enquiry_status1['followup_status']=='Active')	{
		$followup_status='Active';
	}
	else{
		$followup_status=$enquiry_status1['followup_status'];
	}
     $sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$row[reference_id]'"));    
    $count++;

    $row_count++;

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, $count)

                ->setCellValue('C'.$row_count, get_enquiry_id($row['enquiry_id'],$year))

                ->setCellValue('D'.$row_count, $row['name'])

                ->setCellValue('E'.$row_count, $row['enquiry_type'])

                ->setCellValue('F'.$row_count, $row['mobile_no'])

                ->setCellValue('G'.$row_count, $row['email_id'])

                ->setCellValue('H'.$row_count, $sq_ref['reference_name']   )

                ->setCellValue('I'.$row_count, $followup_status)
                ->setCellValue('J'.$row_count, get_date_user($row['enquiry_date']))

                ->setCellValue('K'.$row_count, get_datetime_user($row['followup_date'])  )

                ->setCellValue('L'.$row_count, $row['enquiry']  )

                ->setCellValue('M'.$row_count, $sq_emp['first_name'].' '.$sq_emp['last_name'] );

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':M'.$row_count)->applyFromArray($content_style_Array);

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':M'.$row_count)->applyFromArray($borderArray);                    

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

header('Content-Disposition: attachment;filename="Enquiry('.date('d-m-Y H:i:s').').xls"');

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

