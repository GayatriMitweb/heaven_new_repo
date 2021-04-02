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
$branch_admin_id = $_SESSION['branch_admin_id'];

$objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, "Sr. No")

        ->setCellValue('B'.$row_count, "Group_Name")

        ->setCellValue('C'.$row_count, "Group/Subgroup_Name")

        ->setCellValue('D'.$row_count, "Head_Name");



$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':D'.$row_count)->applyFromArray($header_style_Array);

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':D'.$row_count)->applyFromArray($borderArray);    



$row_count++;
 
$count = 0;
$sq_group = mysql_query("select * from subgroup_master where 1");
while($row_gr = mysql_fetch_assoc($sq_group)){
    $count++;
    if($count <= '111'){ 
        $sq_group1 = mysql_fetch_assoc(mysql_query("select * from group_master where group_id='$row_gr[group_id]'"));
        $sq_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='$sq_group1[head_id]'"));
        $group_name = $sq_group1['group_name'];
    }
    else{
        $sq_group1 = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$row_gr[group_id]'"));
        $sq_group2 = mysql_fetch_assoc(mysql_query("select * from group_master where group_id='$sq_group1[group_id]'"));
        $sq_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='$sq_group2[head_id]'"));
        $group_name = $sq_group1['subgroup_name'];
    }

    $objPHPExcel->setActiveSheetIndex(0)

        ->setCellValue('A'.$row_count, $count)

        ->setCellValue('B'.$row_count, $row_gr['subgroup_name'])

        ->setCellValue('C'.$row_count, $group_name)

        ->setCellValue('D'.$row_count, $sq_head['head_name']);


	



    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':D'.$row_count)->applyFromArray($content_style_Array);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':D'.$row_count)->applyFromArray($borderArray);    



		$row_count++;



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

header('Content-Disposition: attachment;filename="Account Group Report('.date('d-m-Y H:i:s').').xls"');

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

