<?php 
class feedback_master{

public function feedback_save()
{
	$booking_type = $_POST['booking_type'];
	$booking_id = $_POST['booking_id'];
	$customer_id = $_POST['customer_id'];
	$sales_team = $_POST['sales_team'];
	$travel_agencies = $_POST['travel_agencies'];
	$vehicles_requested = $_POST['vehicles_requested'];
	$pickup_time = $_POST['pickup_time'];
	$vehicles_condition = $_POST['vehicles_condition'];
	$driver_info = $_POST['driver_info'];
	$ticket_info = $_POST['ticket_info'];
	$hotel_request = $_POST['hotel_request'];
	$hotel_clean = $_POST['hotel_clean'];
	$hotel_quality = $_POST['hotel_quality'];
	$siteseen = $_POST['siteseen'];
	$siteseen_time = $_POST['siteseen_time'];
	$tour_guide = $_POST['tour_guide'];
	$booking_experience = $_POST['booking_experience'];
	$travel_again = $_POST['travel_again'];
	$hotel_recommend = $_POST['hotel_recommend'];
	$quality_service = $_POST['quality_service'];
	$trip_overall = $_POST['trip_overall'];
	$add_comment = $_POST['add_comment'];
	$sales_team_comment = $_POST['sales_team_comment'];


	$created_at = date('Y-m-d');

	$feedback_count = mysql_num_rows(mysql_query("select * from customer_feedback_master where customer_id='$customer_id' and booking_type='$booking_type' and booking_id='$booking_id'") );
	if($feedback_count>0){
		echo "error--Feedback Already Sent!!!";
	}
	else{
	$feedback_id = mysql_fetch_assoc( mysql_query('select max(feedback_id) as max from customer_feedback_master') );
	$feedback_id = $feedback_id['max']+1;

	$sq = mysql_query("insert into customer_feedback_master ( feedback_id,booking_type, booking_id, customer_id,sales_team, travel_agencies, vehicles_requested, pickup_time, vehicles_condition, driver_info, ticket_info, hotel_request, hotel_clean, hotel_quality, siteseen, siteseen_time, tour_guide, booking_experience, travel_again, hotel_recommend, quality_service, trip_overall, add_comment, sales_team_comment, created_at ) values ( '$feedback_id', '$booking_type', '$booking_id
		', '$customer_id', '$sales_team', '$travel_agencies', '$vehicles_requested', '$pickup_time', '$vehicles_condition', '$driver_info', '$ticket_info', '$hotel_request', '$hotel_clean', '$hotel_quality', '$siteseen', '$siteseen_time', '$tour_guide', '$booking_experience', '$travel_again', '$hotel_recommend', '$quality_service', '$trip_overall', '$add_comment', '$sales_team_comment', '$created_at' ) ");
	if($sq){
		echo "Feedback saved!";
		exit;
	}
	else{
		echo "error--Feedback not saved!";
		exit;
	}
  }
}

public function feedback_update()
{
	$feedback_id = $_POST['feedback_id'];
	$satisfaction_level = $_POST['satisfaction_level'];
	$knowledge_of_travel_products = $_POST['knowledge_of_travel_products'];
	$courtsey = $_POST['courtsey'];
	$communication_skills = $_POST['communication_skills'];
	$comments = $_POST['comments'];
	$satified_with_queries = $_POST['satified_with_queries'];
	$not_satisfied_reason = $_POST['not_satisfied_reason'];
	$comment_on_services = $_POST['comment_on_services'];

	
	$sq = mysql_query("update customer_feedback_master set satisfaction_level='$satisfaction_level', knowledge_of_travel_products='$knowledge_of_travel_products', courtsey='$courtsey', communication_skills='$communication_skills', comments='$comments', satified_with_queries='$satified_with_queries', not_satisfied_reason='$not_satisfied_reason', comment_on_services='$comment_on_services' where feedback_id='$feedback_id'  ");
	if($sq){
		echo "Feedback updated!";
		exit;
	}
	else{
		echo "error--Feedback not updated!";
		exit;
	}
}

}
?>