<?php include "../../../model/model.php"; ?>
<?php

$tour_id = $_GET['tour_id'];
$tot_members = $_GET['tot_members'];
$extra_bed = $_GET['extra_bed'];
$on_floor = $_GET['on_floor'];
$child_b_seats=$_GET['child_b_seats'];
$child_wb_seats=$_GET['child_wb_seats'];
$adult_seats=$_GET['adult_seats'];
$infant_seats=$_GET['infant_seats'];
$double_bed_room=$_GET['double_bed_room'];


$child_b_cost = 0;
$child_wb_cost = 0;
$adult_cost = 0;
$infant_cost = 0;
$sq=mysql_query("select * from tour_master where tour_id='$tour_id'");
if($row=mysql_fetch_assoc($sq))
{
  $adult_cost=$row['adult_cost'];
  $child_b_cost=$row['child_with_cost'];
  $child_wb_cost = $_POST['child_wihtout_cost'];
  $infant_cost=$row['infant_cost'];

  $with_bed_cost = $row['with_bed_cost'];
 // $without_bed_cost = $row['without_bed_cost'];
}
$total_tour_fee = ($child_b_cost*$child_b_seats) + ($child_wb_cost*$child_wb_seats) + ($adult_cost*$adult_seats) + ($infant_cost*$infant_seats);


$sq = mysql_query("select adult_cost from tour_master where tour_id='$tour_id'");
if($row= mysql_fetch_assoc($sq))
{
	$actual_tour_cost  = $row['adult_cost'];
}
if($extra_bed!=0)
{
   //$total_tour_fee = $total_tour_fee - ($adult_cost*$extra_bed);
   $total_tour_fee = $total_tour_fee + ($with_bed_cost*$extra_bed);
}
/*if($on_floor!=0)
{
   $total_tour_fee = $total_tour_fee - ($adult_cost*$on_floor);
   //$total_tour_fee = $total_tour_fee + ($without_bed_cost*$on_floor);
}*/
echo $total_tour_fee;
?>