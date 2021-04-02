<?php 
$bank_name_reciept = $_GET['bank_name_reciept']; 
global $bank_acc_no;
$acc_no_arr = str_split($bank_acc_no);

$acc_no_arr1 = array();
for($i=0; $i<16; $i++){
	$acc_no_arr1[$i] = "";	
}
$counter = sizeof($acc_no_arr);
for($i=16; $i>=0; $i--){
	if($counter>=0){
		$acc_no_arr1[$i] = $acc_no_arr[$counter];
		$counter--;	
	}	
}

require("../../../classes/convert_amount_to_word.php");

$amount_in_word = $amount_to_word->convert_number_to_words($total_amount);


define('FPDF_FONTPATH','../../../classes/fpdf/font/');
require('../../../classes/fpdf/fpdf.php');

$pdf=new FPDF('P','mm',array(450,420));
$pdf->addPage();

$pdf->Image('../../../images/bank-logos/'.$bank_name_reciept.'.jpg', 10, 10, 45, 10);
$pdf->Image('../../../images/bank-logos/'.$bank_name_reciept.'.jpg', 140, 10, 45, 10);

$pdf->SetFont('Arial','',10);

$pdf->SetXY(10,25);
$pdf->Cell(14,5,'Branch :',0,'L');
$pdf->SetXY(25,29);
$pdf->Cell(48,0,'',1,'L');

$pdf->SetXY(78,25);
$pdf->Cell(11,5,'Date :',0,'L');
$pdf->SetXY(89,29);
$pdf->Cell(46,0,'',1,'L');

$pdf->SetXY(10,35);
$pdf->Cell(31,5,'A/C Holder Name :',0,'L');
$pdf->SetXY(42,37);
$pdf->Cell(93,0,$app_name,0,'L');
$pdf->SetXY(42,39);
$pdf->Cell(93,0,'',1,'L');

$pdf->SetXY(10,45);
$pdf->Cell(16,5,'A/C No. ',0,'L');
$pdf->Cell(4,6,$acc_no_arr1[0],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[1],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[2],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[3],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[4],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[5],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[6],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[7],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[8],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[9],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[10],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[11],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[12],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[13],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[14],1,'L');
$pdf->Cell(4,6,$acc_no_arr1[15],1,'L');

$pdf->SetFont('Arial','',9);
$pdf->SetXY(10,55);
$pdf->Cell(125,35,'',1,'L');
$pdf->SetXY(10,55);
$pdf->Cell(85,6,'DETAILS OF CASH/CHEQUE',1,0,'C');
$pdf->Cell(20,6,'RUPEES(   )',1,0,'C');
$pdf->Cell(20,6,'PAISE',1,0,'C');
$pdf->SetXY(10,61);
$pdf->Cell(85,29,'',1,'L');
$pdf->Cell(20,29,$total_amount,1,0,'C');
$pdf->Cell(20,29,'00',1,0,'C');

$pdf->SetFont('Arial','',9);
$pdf->SetXY(10,95);
$pdf->Cell(18,5,'  (in words)',0,'L');
$pdf->SetXY(28,95);
$pdf->Cell(107,4,$amount_in_word,0,'L');
$pdf->SetXY(28,99);
$pdf->Cell(107,0,'',1,'L');
$pdf->SetXY(10,109);
$pdf->Cell(125,0,'',1,'L');


$pdf->SetFont('Arial','',9);
$pdf->SetXY(10,120);
$pdf->Cell(35,5,'Signature of the Depositor',0,'L');
$pdf->SetXY(50,124);
$pdf->Cell(22,0,'',1,'L');

$pdf->SetXY(75,120);
$pdf->Cell(37,5,"Bank Official's Signature",0,'L');
$pdf->SetXY(112,124);
$pdf->Cell(23,0,'',1,'L');


/////////Second region starts here
$pdf->SetFont('Arial','',10);
$pdf->SetXY(140,23);
$pdf->Cell(265,71,'',1,'L');

$pdf->SetXY(140,23);
$pdf->Cell(105,10,'',1,'L');
$pdf->Cell(105,10,'',1,'L');
$pdf->Cell(55,10,'',1,'L');

$pdf->SetXY(141,27);
$pdf->Cell(13,5,'Branch:',0,'L');
$pdf->SetXY(154,31);
$pdf->Cell(25,0,'',1,'L');
$pdf->SetXY(182,27);
$pdf->Cell(13,5,'PAN No. / GIR No.:',0,'L');
$pdf->SetXY(214,31);
$pdf->Cell(30,0,'',1,'L');

$pdf->SetXY(245,23);
$pdf->MultiCell(15,5,'Account Number',1,'L');

$pdf->SetXY(260,23);
$pdf->Cell(6,10,$acc_no_arr1[0],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[1],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[2],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[3],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[4],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[5],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[6],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[7],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[8],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[9],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[10],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[11],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[12],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[13],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[14],1,'L');
$pdf->Cell(6,10,$acc_no_arr1[15],1,'L');

$pdf->SetXY(358,26);
$pdf->Cell(10,6,'Date:',0,'L');

$pdf->SetXY(140,33);
$pdf->Cell(30,7,'A/C Holder Name',1,'L');
$pdf->Cell(235,7,$app_name,1,'L');

$pdf->SetXY(140,40);
$pdf->Cell(55,6,'DRAWEE BANK',1,0,'C');
$pdf->Cell(50,6,'BRANCH',1,0,'C');
$pdf->Cell(55,6,'CHEQUE/DRAFT No.',1,0,'C');
$pdf->Cell(56,6,'CASH DETAILS(Denomination)',1,0,'C');
$pdf->Cell(32,6,'RUPEES (   )',1,0,'C');
$pdf->Cell(17,6,'PAISE',1,0,'C');

$pdf->SetXY(140,46);
$pdf->Cell(5,6,'1',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[0],1,0,'L');
$pdf->Cell(50,6,$branch_name1[0],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[0],1,0,'L');
$pdf->Cell(56,6,'   1000        X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[0],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,52);
$pdf->Cell(5,6,'2',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[1],1,0,'L');
$pdf->Cell(50,6,$branch_name1[1],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[1],1,0,'L');
$pdf->Cell(56,6,'    500          X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[1],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,58);
$pdf->Cell(5,6,'3',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[2],1,0,'L');
$pdf->Cell(50,6,$branch_name1[2],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[2],1,0,'L');
$pdf->Cell(56,6,'    100          X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[2],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,64);
$pdf->Cell(5,6,'4',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[3],1,0,'L');
$pdf->Cell(50,6,$branch_name1[3],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[3],1,0,'L');
$pdf->Cell(56,6,'    50            X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[3],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,70);
$pdf->Cell(5,6,'5',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[4],1,0,'L');
$pdf->Cell(50,6,$branch_name1[4],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[4],1,0,'L');
$pdf->Cell(56,6,'    20            X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[4],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,76);
$pdf->Cell(5,6,'6',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[5],1,0,'L');
$pdf->Cell(50,6,$branch_name1[5],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[5],1,0,'L');
$pdf->Cell(56,6,'    10            X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[5],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,82);
$pdf->Cell(5,6,'7',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[6],1,0,'L');
$pdf->Cell(50,6,$branch_name1[6],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[6],1,0,'L');
$pdf->Cell(56,6,'    5              X              =',1,0,'L');
$pdf->Cell(32,6,$amount1[6],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');

$pdf->SetXY(140,88);
$pdf->Cell(5,6,'8',1,0,'L');
$pdf->Cell(50,6,$bank_name_arr1[7],1,0,'L');
$pdf->Cell(50,6,$branch_name1[7],1,0,'L');
$pdf->Cell(55,6,$cheque_no1[7],1,0,'L');
$pdf->Cell(56,6,'Coins',1,0,'L');
$pdf->Cell(32,6,$amount1[7],1,0,'L');
$pdf->Cell(17,6,'',1,0,'L');


$pdf->SetXY(140,97);
$pdf->Cell(20,6,' (in words)',0,0,'L');
$pdf->SetXY(160,99);
$pdf->Cell(138,0,$amount_in_word,0,0,'L');
$pdf->SetXY(160,101);
$pdf->Cell(138,0,'',1,0,'L');
$pdf->SetXY(140,107);
$pdf->Cell(158,0,'',1,0,'L');


$pdf->SetXY(300,94);
$pdf->Cell(56,6,'TOTAL',1,0,'C');
$pdf->Cell(32,6,$total_amount,1,0,'C');
$pdf->Cell(17,6,'00',1,0,'C');


$pdf->SetXY(140,112);
$pdf->Cell(20,6,'Mobile No.:',0,0,'L');
$pdf->SetXY(160,114);
$pdf->Cell(50,0,$app_contact_no,0,0,'L');
$pdf->SetXY(160,116);
$pdf->Cell(50,0,'',1,0,'L');

$pdf->SetXY(220,112);
$pdf->Cell(20,6,'E-mail ID.:',0,0,'L');
$pdf->SetXY(240,114);
$pdf->Cell(58,0,$app_email_id,0,0,'L');
$pdf->SetXY(240,116);
$pdf->Cell(58,0,'',1,0,'L');

$pdf->SetXY(315,112);
$pdf->Cell(20,6,'Signature of the Depositor ',0,0,'L');
$pdf->SetXY(360,116);
$pdf->Cell(45,0,'',1,0,'L');

$pdf->SetXY(315,120);
$pdf->Cell(20,6,"Bank Official's Signature",0,0,'L');
$pdf->SetXY(360,124);
$pdf->Cell(45,0,'',1,0,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(140,118);
$pdf->Cell(20,6,"For cash deposits above   10 lacs give details of cash transaction, includng source of the cash, overleaf(for RBI reporting)",0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(140,122);
$pdf->Cell(20,6,"(Please prepare seperate deposit slips for cash, local cheques and outstation cheques.)",0,0,'L');



$pdf->SetXY(10,55);
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",111,57,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",10,96,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",379,42,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,48,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,54,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,60,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,66,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,72,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,78,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",302,84,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",140,99,1.5), 0, 0, 'R', false );
$pdf->Cell( 10, 10, $pdf->Image("../../../images/rupee.png",175,120,1.5), 0, 0, 'R', false );


$pdf->Output();
?>