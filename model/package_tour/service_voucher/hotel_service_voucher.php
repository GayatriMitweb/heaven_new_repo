<?php  

class hotel_service_voucher{



public function hotel_service_voucher_save()

{

	$hotel_accomodation_id = $_POST['hotel_accomodation_id'];

	$hotel_accomodation_count = mysql_num_rows( mysql_query("select hotel_accomodation_id from package_tour_hotel_service_voucher where hotel_accomodation_id='$hotel_accomodation_id'") );

	if($hotel_accomodation_count==0){



		$enquiry_id = mysql_fetch_assoc( mysql_query("select max(enquiry_id) as max from package_tour_hotel_service_voucher") );

		$enquiry_id = $enquiry_id['max'] + 1;



		$sq = mysql_query("insert into package_tour_hotel_service_voucher ( enquiry_id, hotel_accomodation_id) values ( '$enquiry_id', '$hotel_accomodation_id' ) ");

		if($sq){

			echo "Service voucher information saved successfully.";

			exit;

		}

		else{

			echo "error--Service voucher can not be generated.";

			exit;

		}



	}
}



public function package_service_voucher_save()

{

	$hotel_accomodation_id = $_POST['hotel_accomodation_id'];


	$hotel_accomodation_count = mysql_num_rows( mysql_query("select hotel_accomodation_id from package_tour_hotel_service_voucher1 where hotel_accomodation_id='$hotel_accomodation_id'") );

	if($hotel_accomodation_count==0){



		$enquiry_id = mysql_fetch_assoc( mysql_query("select max(enquiry_id) as max from package_tour_hotel_service_voucher1") );

		$enquiry_id = $enquiry_id['max'] + 1;



		$sq = mysql_query("insert into package_tour_hotel_service_voucher1 ( enquiry_id, hotel_accomodation_id) values ( '$enquiry_id', '$hotel_accomodation_id' ) ");

		if($sq){

			echo "Service voucher information saved successfully.";

			exit;

		}

		else{

			echo "error--Service voucher can not be generated.";

			exit;

		}



	}

	else{

		$sq = mysql_query("update package_tour_hotel_service_voucher1 set confirm_by='$confirm_by', terms_conditions = '$terms_conditions' where hotel_accomodation_id='$hotel_accomodation_id'");

		if($sq){

			echo "Service voucher information updated successfully.";

			exit;

		}

		else{

			echo "error--Service voucher can not be generated.";

			exit;

		}

	}

}

}

?>