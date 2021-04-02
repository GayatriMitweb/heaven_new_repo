<?php 
class upcoming_tour_offers_master{

///////////////////////***Upcoming Tour offers master save start*********//////////////

function upcoming_tour_offers_master_save($title, $description, $valid_date)
{
  $title = mysql_real_escape_string($title);
  $description = mysql_real_escape_string($description);
  $valid_date = mysql_real_escape_string($valid_date);

  $valid_date = date("Y-m-d", strtotime($valid_date));
  $entry_date = date("Y-m-d");
  
  $max_id = mysql_fetch_assoc(mysql_query("select max(offer_id) as max from upcoming_tour_offers_master"));
  $max_id = $max_id['max']+1;

  $sq_offers = mysql_query("insert into upcoming_tour_offers_master (offer_id, title, description, valid_date, entry_date) values ('$max_id', '$title', '$description', '$valid_date', '$entry_date')");
  if($sq_offers)
  {
    echo "Information saved successfully.";
  }  
  else
  {
    echo "error--Information not saved!";
    exit;
  }  


}

///////////////////////***Upcoming Tour offers master save end*********//////////////

///////////////////////***Upcoming Tour offers master update start*********//////////////

function upcoming_tour_offers_master_update($offer_id, $title, $description, $valid_date)
{
  $offer_id = mysql_real_escape_string($offer_id);
  $title = mysql_real_escape_string($title);
  $description = mysql_real_escape_string($description);
  $valid_date = mysql_real_escape_string($valid_date);

  $valid_date = date("Y-m-d", strtotime($valid_date));

  $sq_offers = mysql_query("update upcoming_tour_offers_master set title='$title', description='$description', valid_date='$valid_date' where offer_id='$offer_id'");
  if($sq_offers)
  {
    echo "Information updated successfully.";
  }  
  else
  {
    echo "Information not updated!";
    exit;
  }  


}

///////////////////////***Upcoming Tour offers master update end*********//////////////

///////////////////////***Upcoming Tour offer disable start*********//////////////

function upcoming_tour_offers_disable($offer_id)
{
  $offer_id = mysql_real_escape_string($offer_id);  

  $sq_offers = mysql_query("update upcoming_tour_offers_master set status='disabled' where offer_id='$offer_id'");
  if($sq_offers)
  {
    echo "Tour Offer disabled successfully.";
  }  
  else
  {
    echo "Tour Offer not disabled!";
    exit;
  }  
}

///////////////////////***Upcoming Tour offer disable end*********//////////////	

}
?>