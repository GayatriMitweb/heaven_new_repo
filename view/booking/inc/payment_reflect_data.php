<?php include "../../../model/model.php"; ?>
<?php

$type=$_GET['type'];

if($type=="Adult")
{
  $adult_seats=$_GET['adult_seats'];
  $tour_id=$_GET['tour_id'];
  $adult_cost=0;
  $sq=mysql_query("select adult_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
  	$adult_cost=$row['adult_cost'];   
  }
  $total_adult_cost=$adult_cost * $adult_seats;	
  
  echo $total_adult_cost;
}

if($type=="Child With Bed")
{
  $children_seats=$_GET['children_seats'];
  $tour_id=$_GET['tour_id'];
  $children_cost=0;
  $sq=mysql_query("select child_with_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
  	$children_cost=$row['child_with_cost'];
  }
  $total_children_cost=$children_cost * $children_seats;	
  
  echo $total_children_cost;
}
if($type=="Child Without Bed"){
  $children_seats=$_GET['children_seats'];
  $tour_id=$_GET['tour_id'];
  $children_cost=0;
  $sq=mysql_query("select child_without_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
  	$children_cost=$row['child_without_cost'];
  }
  $total_children_cost=$children_cost * $children_seats;	
  
  echo $total_children_cost;
}
if($type=="Infant")
{
  $infant_seats=$_GET['infant_seats'];
  $tour_id=$_GET['tour_id'];
  $infant_cost=0;
  $sq=mysql_query("select infant_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
    $infant_cost=$row['infant_cost'];
  }
  $total_infant_cost=$infant_cost * $infant_seats;  
  
  echo $total_infant_cost;
}

if($type=="total")
{
  $total_seats=$_GET['total_seats'];
  $children_seats=$_GET['children_seats'];
  $adult_seats=$_GET['adult_seats'];
  $infant_seats=$_GET['infant_seats'];

  $tour_id=$_GET['tour_id'];
  $adult_cost=0;
  $children_cost=0;
  $infant_cost=0;
  $total_cost=0;

  $sq=mysql_query("select children_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
  	$children_cost=$row['children_cost'];
  }

  $sq=mysql_query("select adult_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
  	$adult_cost=$row['adult_cost'];
  }

  $sq=mysql_query("select infant_cost from tour_master where tour_id='$tour_id'");
  if($row=mysql_fetch_assoc($sq))
  {
    $infant_cost=$row['infant_cost'];
  }

  $total_cost = ($children_cost*$children_seats) + ($adult_cost*$adult_seats) + ($infant_cost*$infant_seats);
  
  
  echo $total_cost;
}

?>