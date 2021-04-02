<?php 
class transport_service_voucher{

public function transport_service_voucher_save()
{
	$booking_id = $_POST['booking_id'];
	$vehicle_name_array = $_POST['vehicle_name_array'];
	$driver_name_array = $_POST['driver_name_array'];
	$driver_contact_array = $_POST['driver_contact_array'];
	$confirm_by_array = $_POST['confirm_by_array'];

	$special_arrangments = $_POST['special_arrangments'];
	$inclusions = $_POST['inclusions'];

	$confirm_date = date('Y-m-d', strtotime($confirm_date));

	$sq_service_voucher_count = mysql_num_rows( mysql_query("select * from package_tour_transport_service_voucher where booking_id='$booking_id'") );

	$special_arrangments = addslashes($special_arrangments);
	$inclusions = addslashes($inclusions);
	
	if($sq_service_voucher_count==0){

		$id = mysql_fetch_assoc( mysql_query("select max(id) as max from package_tour_transport_service_voucher") );
		$id = $id['max'] + 1;

		$sq = mysql_query("insert into package_tour_transport_service_voucher (id, booking_id, special_arrangments, inclusions)  values ('$id', '$booking_id', '$special_arrangments', '$inclusions')");

		if($sq){
			for($i=0;$i<sizeof($vehicle_name_array);$i++){
				$entry_id = mysql_fetch_assoc( mysql_query("select max(entry_id) as max from package_tour_transport_voucher_entries") );
				$entry_id1 = $entry_id['max'] + 1;

				$sq11 = mysql_query("INSERT INTO `package_tour_transport_voucher_entries`(`entry_id`, `booking_id`, `transport_bus_id`, `driver_name`, `driver_contact`,`confirm_by`) VALUES ('$entry_id1', '$booking_id','$vehicle_name_array[$i]', '$driver_name_array[$i]','$driver_contact_array[$i]','$confirm_by_array[$i]')");
			}
			if($sq11){
				echo "Service voucher information saved successfully.";
				exit;
			}
			else{
				echo "error--Service voucher can not be generated.";
				exit;
			}
		}
		else{
			echo "error--Service voucher can not be generated.";
			exit;
		}
	}
	else{
		$sq = mysql_query("update package_tour_transport_service_voucher set special_arrangments='$special_arrangments', inclusions='$inclusions' where booking_id='$booking_id'");
		for($i=0;$i<sizeof($vehicle_name_array);$i++){
			$sq = mysql_query("update package_tour_transport_voucher_entries set driver_name='$driver_name_array[$i]',driver_contact='$driver_contact_array[$i]',confirm_by='$confirm_by_array[$i]' where booking_id='$booking_id' and transport_bus_id='$vehicle_name_array[$i]'");
		}
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