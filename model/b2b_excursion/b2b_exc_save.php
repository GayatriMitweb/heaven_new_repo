<?php
class b2b_exc_save_master{
public function service_save(){

	$city_id = $_POST['city_id'];	
	$service_name = $_POST['service_name'];
	$duration = $_POST['duration'];
	$dep_point = $_POST['dep_point'];
	$rep_time = $_POST['rep_time'];
	$description = $_POST['description'];
	$note = $_POST['note'];
	$off_days = $_POST['off_days'];
	$timing_slots = json_decode($_POST['timing_slots']);

	$inclusions = $_POST['inclusions'];
	$exclusions = $_POST['exclusions'];
	$terms = $_POST['terms'];
	$upolicy = $_POST['upolicy'];
	$bpolicy = $_POST['bpolicy'];
	$cpolicy = $_POST['cpolicy'];
	$currency_code = $_POST['currency_code'];
	$taxation = $_POST['taxation'];

	$active_flag = $_POST['active_flag'];
	$photo_upload_url = $_POST['photo_upload_url'];

	$transfer_option_array = $_POST['transfer_option_array'];
	$bfrom_date_array = $_POST['bfrom_date_array'];
	$bto_date_array = $_POST['bto_date_array'];
	$adult_cost_array = $_POST['adult_cost_array'];
	$child_cost_array = $_POST['child_cost_array'];
	$infant_cost_array = $_POST['infant_cost_array'];
	$markup_in_array = $_POST['markup_in_array'];
	$markup_cost_array = $_POST['markup_cost_array'];

	$type_array = $_POST['type_array'];
	$from_date_array = $_POST['from_date_array'];
	$to_date_array = $_POST['to_date_array'];
	$offer_in_array = $_POST['offer_in_array'];
	$coupon_code_array = $_POST['coupon_code_array'];
	$offer_array = $_POST['offer_array'];
	$agent_type_array = $_POST['agent_type_array'];

	$sq_count = mysql_num_rows(mysql_query("select entry_id from excursion_master_tariff where excursion_name='$service_name' and city_id='$city_id'"));
	if($sq_count>0){
		echo "error--Sorry, Excursion name already exists!";
		exit;
	}

	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_tariff"));
	$exc_id = $sq_max['max'] + 1;

	$service_name = addslashes($service_name);
	$description = addslashes($description);
	$note = addslashes($note);
	$inclusions = addslashes($inclusions);
	$exclusions = addslashes($exclusions);
	$terms = addslashes($terms);
	$upolicy = addslashes($upolicy);
	$bpolicy = addslashes($bpolicy);
	$cpolicy = addslashes($cpolicy);

	$sq_service = mysql_query("INSERT INTO `excursion_master_tariff`(`entry_id`, `city_id`, `excursion_name`, `duration`, `departure_point`, `rep_time`, `description`, `note`, `inclusions`, `exclusions`, `terms_condition`, `useful_info`, `booking_policy`, `canc_policy`, `currency_code`,`taxation`, `active_flag`,`off_days`,`timing_slots`) VALUES ('$exc_id', '$city_id', '$service_name','$duration','$dep_point','$rep_time','$description','$note','$inclusions','$exclusions','$terms','$upolicy','$bpolicy','$cpolicy','$currency_code','$taxation','$active_flag','$off_days','$timing_slots')");

	if($sq_service){
		//Excursion Images
		if($photo_upload_url!=''){
			$image_array = explode(",",$photo_upload_url);
			for($i=0;$i<sizeof($image_array);$i++){
				$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_images"));
				$entry_ids = $sq_max['max'] + 1;
				$sq_image = mysql_query("insert into excursion_master_images (entry_id, exc_id, image_url) values ('$entry_ids', '$exc_id', '$image_array[$i]')");
				if(!$sq_image){
					echo "error--Sorry, Excursion Images not saved!";
					exit;
				}
			}
		}

		//Basic Costing
		for($i=0;$i<sizeof($bfrom_date_array);$i++){
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_tariff_basics"));
			$b_entry = $sq_max['max'] + 1;
			$bfrom_date_array[$i] = get_date_db($bfrom_date_array[$i]);
			$bto_date_array[$i] = get_date_db($bto_date_array[$i]);
			$sq_basic = mysql_query("INSERT INTO `excursion_master_tariff_basics`(`entry_id`, `exc_id`, `transfer_option`,`from_date`, `to_date`, `adult_cost`, `child_cost`, `infant_cost`, `markup_in`, `markup_cost`) VALUES ('$b_entry', '$exc_id','$transfer_option_array[$i]','$bfrom_date_array[$i]','$bto_date_array[$i]','$adult_cost_array[$i]','$child_cost_array[$i]','$infant_cost_array[$i]', '$markup_in_array[$i]', '$markup_cost_array[$i]')");
			if(!$sq_basic){
				echo "error--Sorry, Excursion Basic Costing not saved!";
				exit;
			}
		}
		
		//Offers/coupon Save
		for($i=0;$i<sizeof($type_array);$i++){
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_offers"));
			$offer_entry = $sq_max['max'] + 1;
			$from_date_array[$i] = get_date_db($from_date_array[$i]);
			$to_date_array[$i] = get_date_db($to_date_array[$i]);
			$sq_offer = mysql_query("INSERT INTO `excursion_master_offers`(`entry_id`, `exc_id`, `type`, `from_date`, `to_date`, `offer_in`,`coupon_code`, `offer_amount`, `agent_type`) VALUES ('$offer_entry', '$exc_id','$type_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$offer_in_array[$i]','$coupon_code_array[$i]','$offer_array[$i]','$agent_type_array[$i]')");
			if(!$sq_offer){
				echo "error--Sorry, Excursion Offers/Discounts not saved!";
				exit;
			}
		}

		echo "Excursion has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Excrusion not saved!";
		exit;
	}
}
public function service_update(){
	$exc_entry_id = $_POST['exc_entry_id'];
	$city_id = $_POST['city_id'];
	$service_name = $_POST['service_name'];
	$duration = $_POST['duration'];
	$dep_point = $_POST['dep_point'];
	$rep_time = $_POST['rep_time'];
	$description = $_POST['description'];
	$note = $_POST['note'];
	$inclusions = $_POST['inclusions'];
	$exclusions = $_POST['exclusions'];
	$terms = $_POST['terms'];
	$upolicy = $_POST['upolicy'];
	$bpolicy = $_POST['bpolicy'];
	$cpolicy = $_POST['cpolicy'];
	$currency_code = $_POST['currency_code'];
	$taxation = $_POST['taxation'];
	$active_flag = $_POST['active_flag'];
	$photo_upload_url = $_POST['photo_upload_url'];
	$off_days = $_POST['off_days'];

	$transfer_option_array = $_POST['transfer_option_array'];
	$bfrom_date_array = $_POST['bfrom_date_array'];
	$bto_date_array = $_POST['bto_date_array'];
	$adult_cost_array = $_POST['adult_cost_array'];
	$child_cost_array = $_POST['child_cost_array'];
	$infant_cost_array = $_POST['infant_cost_array'];
	$markup_in_array = $_POST['markup_in_array'];
	$markup_cost_array = $_POST['markup_cost_array'];
	$basic_entryid_array = $_POST['basic_entryid_array'];
	$cost_array = $_POST['cost_array'];

	$type_array = $_POST['type_array'];
	$from_date_array = $_POST['from_date_array'];
	$to_date_array = $_POST['to_date_array'];
	$offer_in_array = $_POST['offer_in_array'];
	$coupon_code_array = $_POST['coupon_code_array'];
	$offer_array = $_POST['offer_array'];
	$agent_type_array = $_POST['agent_type_array'];
	$offer_entryid_array = $_POST['offer_entryid_array'];
	$offers_array = $_POST['offers_array'];

	$sq_count = mysql_num_rows(mysql_query("select entry_id from excursion_master_tariff where excursion_name='$service_name' and city_id='$city_id' and entry_id!='$exc_entry_id'"));
	if($sq_count>0){
		echo "error--Sorry, Excursion name already exists!";
		exit;
	}

	$service_name = addslashes($service_name);
	$description = addslashes($description);
	$note = addslashes($note);
	$inclusions = addslashes($inclusions);
	$exclusions = addslashes($exclusions);
	$terms = addslashes($terms);
	$upolicy = addslashes($upolicy);
	$bpolicy = addslashes($bpolicy);
	$cpolicy = addslashes($cpolicy);

	$sq_service = mysql_query("update `excursion_master_tariff` set  `city_id`='$city_id', `excursion_name`= '$service_name', `duration`='$duration', `departure_point`='$dep_point', `rep_time`='$rep_time', `description`='$description', `note`='$note', `inclusions`='$inclusions', `exclusions`='$exclusions', `terms_condition`='$terms', `useful_info`='$upolicy', `booking_policy`='$bpolicy', `canc_policy`='$cpolicy', `currency_code`='$currency_code', `taxation`='$taxation', `active_flag`='$active_flag',`off_days`='$off_days' where entry_id='$exc_entry_id'");

	if($sq_service){
		//Basic Costing
		for($i=0;$i<sizeof($bfrom_date_array);$i++){
			if($cost_array[$i] == 'true'){
				if($basic_entryid_array[$i] == ''){
					$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_tariff_basics"));
					$b_entry = $sq_max['max'] + 1;
					$bfrom_date_array[$i] = get_date_db($bfrom_date_array[$i]);
					$bto_date_array[$i] = get_date_db($bto_date_array[$i]);
					$sq_basic = mysql_query("INSERT INTO `excursion_master_tariff_basics`(`entry_id`, `exc_id`,`transfer_option`, `from_date`, `to_date`, `adult_cost`, `child_cost`,`infant_cost`, `markup_in`,`markup_cost`) VALUES ('$b_entry', '$exc_entry_id','$transfer_option_array[$i]','$bfrom_date_array[$i]','$bto_date_array[$i]','$adult_cost_array[$i]','$child_cost_array[$i]','$infant_cost_array[$i]', '$markup_in_array[$i]', '$markup_cost_array[$i]')");
				}
				else{
					$bfrom_date_array[$i] = get_date_db($bfrom_date_array[$i]);
					$bto_date_array[$i] = get_date_db($bto_date_array[$i]);
					$sq_basic = mysql_query("update `excursion_master_tariff_basics` set `transfer_option`= '$transfer_option_array[$i]',`from_date`='$bfrom_date_array[$i]', `to_date`='$bto_date_array[$i]', `adult_cost`='$adult_cost_array[$i]', `child_cost`='$child_cost_array[$i]',`infant_cost`='$infant_cost_array[$i]', markup_in='$markup_in_array[$i]', markup_cost='$markup_cost_array[$i]' where entry_id='$basic_entryid_array[$i]'");
				}
				if(!$sq_basic){
					echo "error--Sorry, Excursion Basic Costing not updated!";
					exit;
				}
			}else{
				$sq_query1 = mysql_query("DELETE FROM `excursion_master_tariff_basics` WHERE `entry_id`='$basic_entryid_array[$i]'");
			}
		}
		
		//Offers Save
		for($i=0;$i<sizeof($type_array);$i++){
			if($offers_array[$i] == 'true'){
				if($offer_entryid_array[$i] == ''){
					$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_offers"));
					$offer_entry = $sq_max['max'] + 1;
					$from_date_array[$i] = get_date_db($from_date_array[$i]);
					$to_date_array[$i] = get_date_db($to_date_array[$i]);
					$sq_offer = mysql_query("INSERT INTO `excursion_master_offers`(`entry_id`, `exc_id`, `type`, `from_date`, `to_date`, `offer_in`,`coupon_code`, `offer_amount`, `agent_type`) VALUES ('$offer_entry', '$exc_entry_id','$type_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$offer_in_array[$i]','$coupon_code_array[$i]','$offer_array[$i]','$agent_type_array[$i]')");
				}
				else{
					$from_date_array[$i] = get_date_db($from_date_array[$i]);
					$to_date_array[$i] = get_date_db($to_date_array[$i]);
					$sq_offer = mysql_query("update `excursion_master_offers` set `type`='$type_array[$i]',`from_date`='$from_date_array[$i]', `to_date`='$to_date_array[$i]', `offer_in`='$offer_in_array[$i]',`coupon_code`='$coupon_code_array[$i]', `offer_amount`='$offer_array[$i]', `agent_type`='$agent_type_array[$i]' where entry_id='$offer_entryid_array[$i]'");
				}
				if(!$sq_offer){
					echo "error--Sorry, Excursion Offers/Coupons not updated!";
					exit;
				}
			}else{
				$sq_query1 = mysql_query("DELETE FROM `excursion_master_offers` WHERE `entry_id`='$offer_entryid_array[$i]'");
			}
		}

		echo "Excursion has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Excrusion not updated!";
		exit;
	}
}

public function image_delete(){
    $image_id = $_POST['image_id'];
    $sq_delete = mysql_query("delete from excursion_master_images where entry_id='$image_id'");
    if($sq_delete){
      echo "Image Deleted";
    }
}

function image_update(){
	$upload_url = $_POST['upload_url'];
	$exc_entry_id = $_POST['exc_entry_id'];

	//Excursion Images
	$sq_count=mysql_num_rows(mysql_query("select * from excursion_master_images where exc_id='$exc_entry_id'"));
	if($sq_count<3)
	{
		$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_images"));
		$entry_ids = $sq_max['max'] + 1;
		$sq_image = mysql_query("insert into excursion_master_images (entry_id, exc_id, image_url) values ('$entry_ids', '$exc_entry_id', '$upload_url')");
		if(!$sq_image){
			echo "error--Sorry, Excursion Image not uploaded!";
			exit;
		}else{
			echo "Excursion Image uploaded!";
			exit;
		}
	}else
	{
		echo "error--Sorry, you can upload only 3 images";
	}
}

public function exc_timing_slots(){
	$cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();
    $flag = true;

    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];

    begin_t();
    $count = 1;

    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {
        while(($data = fgetcsv($handle, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){
                
            $sq = mysql_query("select max(pricing_id) as max from hotel_vendor_price_master");
            $value = mysql_fetch_assoc($sq);
            $pricing_id = $value['max'] + 1;
            $arr = array(
					'sr_no' => $data[0],
					'from_time' => $data[1],
					'to_time' => $data[2]
			);

            array_push($pass_info_arr, $arr); 
            }  
            $count++;
        }
        fclose($handle);
    }
	echo json_encode($pass_info_arr);
}

function time_slot_update(){
	$exc_entry_id = $_POST['exc_entry_id'];
	$time_slot_array = ($_POST['time_slot_array']);
	$sq_service = mysql_query("update `excursion_master_tariff` set `timing_slots`='$time_slot_array' where entry_id='$exc_entry_id'");
	if($sq_service){
		echo "Timing Slot has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Timing Slot not updated!";
		exit;
	}
}
}
?>