<?php 
$pdf->AddPage();

$pdf->Image($report_logo_small_url,68,5,65, 20);

$pdf->SetXY(10,30);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(190,10,'Air Booking',1,1,'C');

$pdf->SetFont('Arial','',11);

$y_pos = $pdf->getY()+3;

$pdf->rect(175, $y_pos, 25, 14);

$pdf->SetXY(120,$y_pos);
$pdf->Cell(51,7,'Booking ID :'.get_package_booking_id($booking_details['booking_id']),1,1,'L');

$y_pos = $pdf->getY();
$pdf->SetXY(120,$y_pos);
$pdf->Cell(51,7,'Date :'.date('d-m-Y'),1,1,'L');

$y_pos = $pdf->getY()+3;
$pdf->SetXY(10,$y_pos);
$pdf->Cell(45,7,'Date Of Journey :',0,1,'L');

$y_pos = $pdf->getY()+2;
$pdf->SetXY(10,$y_pos);
$pdf->Cell(45,7,'From :',0,1,'L');
$pdf->Line(23, $y_pos+5, 98, $y_pos+5);

$pdf->SetXY(100,$y_pos);
$pdf->Cell(45,7,'To :',0,1,'L');
$pdf->Line(109, $y_pos+5, 200, $y_pos+5);


$y_pos = $pdf->getY()+2;
$pdf->SetXY(10,$y_pos);
$pdf->Cell(45,7,'Flight Company :',0,1,'L');
$pdf->Line(41, $y_pos+5, 98, $y_pos+5);

$pdf->SetXY(100,$y_pos);
$pdf->Cell(45,7,'Flight Number :',0,1,'L');
$pdf->Line(128, $y_pos+5, 200, $y_pos+5);

$y_pos = $pdf->getY()+4;
$pdf->SetXY(10,$y_pos);
$pdf->Cell(45,7,'Name of Passangers :',0,1,'L');

$y_pos = $pdf->getY()+2;
$pdf->SetXY(10,$y_pos);
$pdf->Cell(15,8,'No',1,1,'C');
$pdf->SetXY(25,$y_pos);
$pdf->Cell(100,8,'Name',1,1,'C');
$pdf->SetXY(125,$y_pos);
$pdf->Cell(40,8,'M/F',1,1,'C');
$pdf->SetXY(165,$y_pos);
$pdf->Cell(25,8,'Age',1,1,'C');

$sq_members = mysql_query("select * from package_travelers_details where booking_id='$booking_id' and status='Active'"); 
$count = 0;
while($row_members = mysql_fetch_assoc($sq_members))
{	
	if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);

	if($row_members['gender']=='male')
	{
		$gender='Male';
	}	
	else
	{
		$gender='Female';
	}	

	$pdf->SetX(5);
	$y_pos = $pdf->GetY();
	$count++;

	$pdf->SetXY(10,$y_pos);
	$pdf->Cell(15,7,$count,1,1,'C');
	$pdf->SetXY(25,$y_pos);
	$pdf->Cell(100,7, $row_members['first_name'].' '.$row_members['middle_name'].' '.$row_members['last_name'],1,1,'C');
	$pdf->SetXY(125,$y_pos);
	$pdf->Cell(40,7,$gender,1,1,'C');
	$pdf->SetXY(165,$y_pos);
	$pdf->Cell(25,7, $row_members['age'],1,1,'C');
}


if($pdf->GetY()+20>$pdf->PageBreakTrigger)
    $pdf->AddPage($pdf->CurOrientation);

$y_pos = $pdf->getY()+5;

$pdf->SetXY(10, $y_pos);
$pdf->Cell(25,7,'For Office Use',0,1,'L');
$pdf->Line(38, $y_pos+5, 200, $y_pos+5);

$y_pos = $pdf->getY()+2;

$pdf->SetXY(10, $y_pos);
$pdf->Cell(25,7,'PNR No: ',0,1,'L');
$pdf->Line(28, $y_pos+5, 65, $y_pos+5);

$pdf->SetXY(70, $y_pos);
$pdf->Cell(25,7,'Ticket Amount: ',0,1,'L');
$pdf->Line(98, $y_pos+5, 138, $y_pos+5);

$pdf->SetXY(140, $y_pos);
$pdf->Cell(25,7,'Service Charge: ',0,1,'L');
$pdf->Line(170, $y_pos+5, 200, $y_pos+5);

$y_pos = $pdf->getY()+2;

$pdf->SetXY(10, $y_pos);
$pdf->Cell(25,7,'Date Of Booking: ',0,1,'L');
$pdf->Line(42, $y_pos+5, 90, $y_pos+5);

$y_pos = $pdf->getY()+8;
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(10,$y_pos,200,$y_pos);
?>