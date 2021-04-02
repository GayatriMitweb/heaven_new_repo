<?php
class vendor_price_save{

public function hotel_tarrif_save(){
	//TAB-1
	$city_id = $_POST['city_id'];
	$hotel_id = $_POST['hotel_id']; 
	$currency_id = $_POST['currency_id'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];

	//TAB-2
	$tab2_room_cat_array = $_POST['tab2_room_cat_array'];
	$tab2_max_occ_array = $_POST['tab2_max_occ_array'];
	$tab2_from_date_array = $_POST['tab2_from_date_array'];
	$tab2_to_date_array = $_POST['tab2_to_date_array'];
	$tab2_double_bed_array = $_POST['tab2_double_bed_array'];
	$tab2_chwithbed_array = $_POST['tab2_chwithbed_array'];
	$tab2_chwobed_array = $_POST['tab2_chwobed_array'];
	$tab2_extra_bed_array = $_POST['tab2_extra_bed_array'];
	$tab2_markup_per_array = $_POST['tab2_markup_per_array'];
	$tab2_markup_cost_array = $_POST['tab2_markup_cost_array'];
	$tab2_meal_plan_array = $_POST['tab2_meal_plan_array'];

	//TAB-3
	$tab3_room_cat_array = $_POST['tab3_room_cat_array'];
	$tab3_max_occ_array = $_POST['tab3_max_occ_array'];
	$tab3_from_date_array = $_POST['tab3_from_date_array'];
	$tab3_to_date_array = $_POST['tab3_to_date_array'];
	$tab3_double_bed_array = $_POST['tab3_double_bed_array'];
	$tab3_chwithbed_array = $_POST['tab3_chwithbed_array'];
	$tab3_chwobed_array = $_POST['tab3_chwobed_array'];
	$tab3_extra_bed_array = $_POST['tab3_extra_bed_array'];
	$tab3_markup_per_array = $_POST['tab3_markup_per_array'];
	$tab3_markup_cost_array = $_POST['tab3_markup_cost_array'];
	$tab3_meal_plan_array = $_POST['tab3_meal_plan_array'];

	//TAB-4
	$tab4_room_cat_array = $_POST['tab4_room_cat_array'];
	$tab4_max_occ_array = $_POST['tab4_max_occ_array'];
	$tab4_day_array = $_POST['tab4_day_array'];
	$tab4_double_bed_array = $_POST['tab4_double_bed_array'];
	$tab4_chwithbed_array = $_POST['tab4_chwithbed_array'];
	$tab4_chwobed_array = $_POST['tab4_chwobed_array'];
	$tab4_extra_bed_array = $_POST['tab4_extra_bed_array'];
	$tab4_markup_per_array = $_POST['tab4_markup_per_array'];
	$tab4_markup_cost_array = $_POST['tab4_markup_cost_array'];
	$tab4_meal_plan_array = $_POST['tab4_meal_plan_array'];

	//TAB-5
	$type_array = $_POST['type_array'];
	$from_date_array = $_POST['from_date_array'];
	$to_date_array = $_POST['to_date_array'];
	$offer_array = $_POST['offer_array'];
	$coupon_code_array = $_POST['coupon_code_array'];
	$offer_amount_array = $_POST['offer_amount_array'];
	$agent_array = $_POST['agent_array'];
	
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("SELECT max(pricing_id) as max from hotel_vendor_price_master"));
	$pricing_id = $sq_max['max'] + 1;
	$created_at = date('Y-m-d H:i:s');
	$sq_hotel = mysql_query("update hotel_master set taxation_type='$taxation_type', taxation_id='$taxation_id',service_tax='$service_tax' where city_id='$city_id' and hotel_id='$hotel_id'");
	$sq_login = mysql_query("insert into hotel_vendor_price_master (pricing_id, city_id,hotel_id, currency_id , created_at) values ('$pricing_id','$city_id','$hotel_id','$currency_id', '$created_at')");
	if($sq_login){
		//TAB-2
		for($i=0; $i<sizeof($tab2_from_date_array); $i++){

			$sq = mysql_query("select max(entry_id) as max from hotel_contracted_tarrif");
			$value = mysql_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;
			
			$tab2_room_cat_array[$i] = mysql_real_escape_string($tab2_room_cat_array[$i]);
			$tab2_max_occ_array[$i] = mysql_real_escape_string($tab2_max_occ_array[$i]);
			$tab2_from_date_array[$i] = mysql_real_escape_string($tab2_from_date_array[$i]);
			$tab2_to_date_array[$i] = mysql_real_escape_string($tab2_to_date_array[$i]);
			$tab2_double_bed_array[$i] = mysql_real_escape_string($tab2_double_bed_array[$i]);
			$tab2_chwithbed_array[$i] = mysql_real_escape_string($tab2_chwithbed_array[$i]);
			$tab2_chwobed_array[$i] = mysql_real_escape_string($tab2_chwobed_array[$i]);
			$tab2_extra_bed_array[$i] = mysql_real_escape_string($tab2_extra_bed_array[$i]);
			$tab2_markup_per_array[$i] = mysql_real_escape_string($tab2_markup_per_array[$i]);
			$tab2_markup_cost_array[$i] = mysql_real_escape_string($tab2_markup_cost_array[$i]);
			$tab2_meal_plan_array[$i] = mysql_real_escape_string($tab2_meal_plan_array[$i]);

			if($tab2_from_date_array[$i]!=""){  $tab2_from_date_array[$i] = date("Y-m-d", strtotime($tab2_from_date_array[$i])); }
			if($tab2_to_date_array[$i]!=""){  $tab2_to_date_array[$i] = date("Y-m-d", strtotime($tab2_to_date_array[$i])); }

			$sq1 = mysql_query("INSERT INTO `hotel_contracted_tarrif`(`entry_id`, `pricing_id`, `room_category`, `from_date`, `to_date`, `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`,`markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab2_room_cat_array[$i]','$tab2_from_date_array[$i]','$tab2_to_date_array[$i]','$tab2_double_bed_array[$i]','$tab2_chwithbed_array[$i]','$tab2_chwobed_array[$i]','$tab2_extra_bed_array[$i]','$tab2_markup_per_array[$i]','$tab2_markup_cost_array[$i]','$tab2_meal_plan_array[$i]','$tab2_max_occ_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Hotel Seasonal Tarifff details not saved!";
			}
		}

		//TAB-3
		for($i=0; $i<sizeof($tab3_from_date_array); $i++){

			$sq = mysql_query("select max(entry_id) as max from hotel_blackdated_tarrif");
			$value = mysql_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;
			
			$tab3_room_cat_array[$i] = mysql_real_escape_string($tab3_room_cat_array[$i]);
			$tab3_max_occ_array[$i] = mysql_real_escape_string($tab3_max_occ_array[$i]);
			$tab3_from_date_array[$i] = mysql_real_escape_string($tab3_from_date_array[$i]);
			$tab3_to_date_array[$i] = mysql_real_escape_string($tab3_to_date_array[$i]);
			$tab3_double_bed_array[$i] = mysql_real_escape_string($tab3_double_bed_array[$i]);
			$tab3_chwithbed_array[$i] = mysql_real_escape_string($tab3_chwithbed_array[$i]);
			$tab3_chwobed_array[$i] = mysql_real_escape_string($tab3_chwobed_array[$i]);
			$tab3_extra_bed_array[$i] = mysql_real_escape_string($tab3_extra_bed_array[$i]);
			$tab3_markup_per_array[$i] = mysql_real_escape_string($tab3_markup_per_array[$i]);
			$tab3_markup_cost_array[$i] = mysql_real_escape_string($tab3_markup_cost_array[$i]);
			$tab3_meal_plan_array[$i] = mysql_real_escape_string($tab3_meal_plan_array[$i]);

			if($tab3_from_date_array[$i]!=""){  $tab3_from_date_array[$i] = date("Y-m-d", strtotime($tab3_from_date_array[$i])); }
			if($tab3_to_date_array[$i]!=""){  $tab3_to_date_array[$i] = date("Y-m-d", strtotime($tab3_to_date_array[$i])); }

			$sq1 = mysql_query("INSERT INTO `hotel_blackdated_tarrif`(`entry_id`, `pricing_id`, `room_category`, `from_date`, `to_date`, `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`,`markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab3_room_cat_array[$i]','$tab3_from_date_array[$i]','$tab3_to_date_array[$i]','$tab3_double_bed_array[$i]','$tab3_chwithbed_array[$i]','$tab3_chwobed_array[$i]','$tab3_extra_bed_array[$i]','$tab3_markup_per_array[$i]','$tab3_markup_cost_array[$i]','$tab3_meal_plan_array[$i]','$tab3_max_occ_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Black Dated Tariff details not saved!";
			}
		}

		//TAB-4
		for($i=0; $i<sizeof($tab4_room_cat_array); $i++){
	
			$sq = mysql_query("select max(entry_id) as max from hotel_weekend_tarrif");
			$value = mysql_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;

			$tab4_room_cat_array[$i] = mysql_real_escape_string($tab4_room_cat_array[$i]);
			$tab4_max_occ_array[$i] = mysql_real_escape_string($tab4_max_occ_array[$i]);
			$tab4_day_array[$i] = mysql_real_escape_string($tab4_day_array[$i]);
			$tab4_double_bed_array[$i] = mysql_real_escape_string($tab4_double_bed_array[$i]);
			$tab4_chwithbed_array[$i] = mysql_real_escape_string($tab4_chwithbed_array[$i]);
			$tab4_chwobed_array[$i] = mysql_real_escape_string($tab4_chwobed_array[$i]);
			$tab4_extra_bed_array[$i] = mysql_real_escape_string($tab4_extra_bed_array[$i]);
			$tab4_markup_per_array[$i] = mysql_real_escape_string($tab4_markup_per_array[$i]);
			$tab4_markup_cost_array[$i] = mysql_real_escape_string($tab4_markup_cost_array[$i]);
			$tab4_meal_plan_array[$i] = mysql_real_escape_string($tab4_meal_plan_array[$i]);
	
			$sq1 = mysql_query("INSERT INTO `hotel_weekend_tarrif`(`entry_id`, `pricing_id`, `room_category`, `day`,  `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`, `markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab4_room_cat_array[$i]','$tab4_day_array[$i]','$tab4_double_bed_array[$i]','$tab4_chwithbed_array[$i]','$tab4_chwobed_array[$i]','$tab4_extra_bed_array[$i]','$tab4_markup_per_array[$i]','$tab4_markup_cost_array[$i]','$tab4_meal_plan_array[$i]','$tab4_max_occ_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Weekend Tariff details not saved!";
			}
		}
		
		//TAB-5
		for($i=0; $i<sizeof($from_date_array); $i++){
	
			$sq = mysql_query("select max(entry_id) as max from hotel_offers_tarrif");
			$value = mysql_fetch_assoc($sq);
			$max_entry_id = $value['max'] + 1;
			$type_array[$i] = mysql_real_escape_string($type_array[$i]);
			$from_date_array[$i] = mysql_real_escape_string($from_date_array[$i]);
			$to_date_array[$i] = mysql_real_escape_string($to_date_array[$i]);
			$offer_array[$i] = mysql_real_escape_string($offer_array[$i]);
			$agent_array[$i] = mysql_real_escape_string($agent_array[$i]);
			$coupon_code_array[$i] = mysql_real_escape_string($coupon_code_array[$i]);
			$offer_amount_array[$i] = mysql_real_escape_string($offer_amount_array[$i]);
			
			if($from_date_array[$i]!=""){  $from_date_array[$i] = date("Y-m-d", strtotime($from_date_array[$i])); }
			if($to_date_array[$i]!=""){  $to_date_array[$i] = date("Y-m-d", strtotime($to_date_array[$i])); }
			$sq1 = mysql_query("INSERT INTO `hotel_offers_tarrif`(`entry_id`, `hotel_id`,`type`, `from_date`, `to_date`, `offer`,`offer_amount`,`coupon_code`, `agent_type`) VALUES ('$max_entry_id','$hotel_id','$type_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$offer_array[$i]','$offer_amount_array[$i]','$coupon_code_array[$i]','$agent_array[$i]')");
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Offers/Coupon Tariff details not saved!";
			}
		}
		
		commit_t();
		echo "Hotel Tariff details Saved!";
	
	}
	else{
		$GLOBALS['flag'] = false;
		echo "error--Tariff details not saved!";
	}
}

public function hotel_tarrif_update(){
	//TAB-1
	$pricing_id = $_POST['pricing_id'];
	$city_id = $_POST['city_id'];
	$hotel_id = $_POST['hotel_id']; 
	$currency_id = $_POST['currency_id'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];

	//TAB-2
	$tab2_room_cat_array = $_POST['tab2_room_cat_array'];
	$tab2_max_occ_array = $_POST['tab2_max_occ_array'];
	$tab2_from_date_array = $_POST['tab2_from_date_array'];
	$tab2_to_date_array = $_POST['tab2_to_date_array'];
	$tab2_double_bed_array = $_POST['tab2_double_bed_array'];
	$tab2_chwithbed_array = $_POST['tab2_chwithbed_array'];
	$tab2_chwobed_array = $_POST['tab2_chwobed_array'];
	$tab2_extra_bed_array = $_POST['tab2_extra_bed_array'];
	$tab2_markup_per_array = $_POST['tab2_markup_per_array'];
	$tab2_markup_cost_array = $_POST['tab2_markup_cost_array'];
	$tab2_meal_plan_array = $_POST['tab2_meal_plan_array'];
	$tab2_entry_id_array = $_POST['tab2_entry_id_array'];
	$tab2_checked_id_array = $_POST['tab2_checked_id_array'];

	//TAB-3
	$tab3_room_cat_array = $_POST['tab3_room_cat_array'];
	$tab3_max_occ_array = $_POST['tab3_max_occ_array'];
	$tab3_from_date_array = $_POST['tab3_from_date_array'];
	$tab3_to_date_array = $_POST['tab3_to_date_array'];
	$tab3_double_bed_array = $_POST['tab3_double_bed_array'];
	$tab3_chwithbed_array = $_POST['tab3_chwithbed_array'];
	$tab3_chwobed_array = $_POST['tab3_chwobed_array'];
	$tab3_extra_bed_array = $_POST['tab3_extra_bed_array'];
	$tab3_markup_per_array = $_POST['tab3_markup_per_array'];
	$tab3_markup_cost_array = $_POST['tab3_markup_cost_array'];
	$tab3_meal_plan_array = $_POST['tab3_meal_plan_array'];
	$tab3_entry_id_array = $_POST['tab3_entry_id_array'];
	$tab3_checked_id_array = $_POST['tab3_checked_id_array'];

	//TAB-4
	$tab4_room_cat_array = $_POST['tab4_room_cat_array'];
	$tab4_max_occ_array = $_POST['tab4_max_occ_array'];
	$tab4_day_array = $_POST['tab4_day_array'];
	$tab4_double_bed_array = $_POST['tab4_double_bed_array'];
	$tab4_chwithbed_array = $_POST['tab4_chwithbed_array'];
	$tab4_chwobed_array = $_POST['tab4_chwobed_array'];
	$tab4_extra_bed_array = $_POST['tab4_extra_bed_array'];
	$tab4_markup_per_array = $_POST['tab4_markup_per_array'];
	$tab4_markup_cost_array = $_POST['tab4_markup_cost_array'];
	$tab4_meal_plan_array = $_POST['tab4_meal_plan_array'];
	$tab4_entry_id_array = $_POST['tab4_entry_id_array'];
	$tab4_checked_id_array = $_POST['tab4_checked_id_array'];

	//TAB-5
	$type_array = $_POST['type_array'];
	$from_date_array = $_POST['from_date_array'];
	$to_date_array = $_POST['to_date_array'];
	$offer_array = $_POST['offer_array'];
	$coupon_code_array = $_POST['coupon_code_array'];
	$offer_amount_array = $_POST['offer_amount_array'];
	$agent_array = $_POST['agent_array'];
	$tab5_entry_id_array = $_POST['tab5_entry_id_array'];
	$tab5_checked_id_array = $_POST['tab5_checked_id_array'];
	
	begin_t();
	
	$sq_hotel = mysql_query("update hotel_master set taxation_type='$taxation_type', taxation_id='$taxation_id',service_tax='$service_tax' where city_id='$city_id' and hotel_id='$hotel_id'");
	$sq_login = mysql_query("update hotel_vendor_price_master set city_id='$city_id',hotel_id='$hotel_id', currency_id='$currency_id' where pricing_id='$pricing_id'");
	if($sq_login){
		//TAB-2
		for($i=0; $i<sizeof($tab2_from_date_array); $i++){
			if($tab2_checked_id_array[$i] == 'true'){

				if($tab2_entry_id_array[$i] == ''){
					$sq = mysql_query("select max(entry_id) as max from hotel_contracted_tarrif");
					$value = mysql_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;
					
					$tab2_room_cat_array[$i] = mysql_real_escape_string($tab2_room_cat_array[$i]);
					$tab2_max_occ_array[$i] = mysql_real_escape_string($tab2_max_occ_array[$i]);
					$tab2_from_date_array[$i] = mysql_real_escape_string($tab2_from_date_array[$i]);
					$tab2_to_date_array[$i] = mysql_real_escape_string($tab2_to_date_array[$i]);
					$tab2_double_bed_array[$i] = mysql_real_escape_string($tab2_double_bed_array[$i]);
					$tab2_chwithbed_array[$i] = mysql_real_escape_string($tab2_chwithbed_array[$i]);
					$tab2_chwobed_array[$i] = mysql_real_escape_string($tab2_chwobed_array[$i]);
					$tab2_extra_bed_array[$i] = mysql_real_escape_string($tab2_extra_bed_array[$i]);
					$tab2_markup_per_array[$i] = mysql_real_escape_string($tab2_markup_per_array[$i]);
					$tab2_markup_cost_array[$i] = mysql_real_escape_string($tab2_markup_cost_array[$i]);
					$tab2_meal_plan_array[$i] = mysql_real_escape_string($tab2_meal_plan_array[$i]);

					if($tab2_from_date_array[$i]!=""){  $tab2_from_date_array[$i] = date("Y-m-d", strtotime($tab2_from_date_array[$i])); }
					if($tab2_to_date_array[$i]!=""){  $tab2_to_date_array[$i] = date("Y-m-d", strtotime($tab2_to_date_array[$i])); }
					$sq1 = mysql_query("INSERT INTO `hotel_contracted_tarrif`(`entry_id`, `pricing_id`, `room_category`, `from_date`, `to_date`, `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`, `markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab2_room_cat_array[$i]','$tab2_from_date_array[$i]','$tab2_to_date_array[$i]','$tab2_double_bed_array[$i]','$tab2_chwithbed_array[$i]','$tab2_chwobed_array[$i]','$tab2_extra_bed_array[$i]','$tab2_markup_per_array[$i]','$tab2_markup_cost_array[$i]','$tab2_meal_plan_array[$i]','$tab2_max_occ_array[$i]')");

				}
				else{

					if($tab2_from_date_array[$i]!=""){  $tab2_from_date_array[$i] = date("Y-m-d", strtotime($tab2_from_date_array[$i])); }
					if($tab2_to_date_array[$i]!=""){  $tab2_to_date_array[$i] = date("Y-m-d", strtotime($tab2_to_date_array[$i])); }

					$sq1 = mysql_query("UPDATE `hotel_contracted_tarrif` SET `room_category`='$tab2_room_cat_array[$i]',`from_date`='$tab2_from_date_array[$i]',`to_date`='$tab2_to_date_array[$i]',`double_bed`='$tab2_double_bed_array[$i]',`child_with_bed`='$tab2_chwithbed_array[$i]',`child_without_bed`='$tab2_chwobed_array[$i]',`extra_bed`='$tab2_extra_bed_array[$i]',`markup_per`='$tab2_markup_per_array[$i]',`markup`='$tab2_markup_cost_array[$i]',`meal_plan`='$tab2_meal_plan_array[$i]',`max_occupancy`='$tab2_max_occ_array[$i]' WHERE entry_id='$tab2_entry_id_array[$i]'");
				}
			}
			else{
				$sq1 = mysql_query("DELETE FROM `hotel_contracted_tarrif` WHERE `entry_id`='$tab2_entry_id_array[$i]'");
			}
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Hotel Seasonal Tarifff details not updated!";
			}
		}
		//TAB-3
		for($i=0; $i<sizeof($tab3_from_date_array); $i++){
			if($tab3_checked_id_array[$i] == 'true'){
					
				if($tab3_entry_id_array[$i] == ''){
					$sq = mysql_query("select max(entry_id) as max from hotel_blackdated_tarrif");
					$value = mysql_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;
					
					$tab3_room_cat_array[$i] = mysql_real_escape_string($tab3_room_cat_array[$i]);
					$tab3_max_occ_array[$i] = mysql_real_escape_string($tab3_max_occ_array[$i]);
					$tab3_from_date_array[$i] = mysql_real_escape_string($tab3_from_date_array[$i]);
					$tab3_to_date_array[$i] = mysql_real_escape_string($tab3_to_date_array[$i]);
					$tab3_double_bed_array[$i] = mysql_real_escape_string($tab3_double_bed_array[$i]);
					$tab3_chwithbed_array[$i] = mysql_real_escape_string($tab3_chwithbed_array[$i]);
					$tab3_chwobed_array[$i] = mysql_real_escape_string($tab3_chwobed_array[$i]);
					$tab3_extra_bed_array[$i] = mysql_real_escape_string($tab3_extra_bed_array[$i]);
					$tab3_markup_per_array[$i] = mysql_real_escape_string($tab3_markup_per_array[$i]);
					$tab3_markup_cost_array[$i] = mysql_real_escape_string($tab3_markup_cost_array[$i]);
					$tab3_meal_plan_array[$i] = mysql_real_escape_string($tab3_meal_plan_array[$i]);

					if($tab3_from_date_array[$i]!=""){  $tab3_from_date_array[$i] = date("Y-m-d", strtotime($tab3_from_date_array[$i])); }
					if($tab3_to_date_array[$i]!=""){  $tab3_to_date_array[$i] = date("Y-m-d", strtotime($tab3_to_date_array[$i])); }

					$sq1 = mysql_query("INSERT INTO `hotel_blackdated_tarrif`(`entry_id`, `pricing_id`, `room_category`, `from_date`, `to_date`, `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`, `markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab3_room_cat_array[$i]','$tab3_from_date_array[$i]','$tab3_to_date_array[$i]','$tab3_double_bed_array[$i]','$tab3_chwithbed_array[$i]','$tab3_chwobed_array[$i]','$tab3_extra_bed_array[$i]','$tab3_markup_per_array[$i]','$tab3_markup_cost_array[$i]','$tab3_meal_plan_array[$i]','$tab3_max_occ_array[$i]')");

				}
				else{

					if($tab3_from_date_array[$i]!=""){  $tab3_from_date_array[$i] = date("Y-m-d", strtotime($tab3_from_date_array[$i])); }
					if($tab3_to_date_array[$i]!=""){  $tab3_to_date_array[$i] = date("Y-m-d", strtotime($tab3_to_date_array[$i])); }

					$sq1 = mysql_query("UPDATE `hotel_blackdated_tarrif` SET `room_category`='$tab3_room_cat_array[$i]',`from_date`='$tab3_from_date_array[$i]',`to_date`='$tab3_to_date_array[$i]',`double_bed`='$tab3_double_bed_array[$i]',`child_with_bed`='$tab3_chwithbed_array[$i]',`child_without_bed`='$tab3_chwobed_array[$i]',`extra_bed`='$tab3_extra_bed_array[$i]',`markup_per`='$tab3_markup_per_array[$i]',`markup`='$tab3_markup_cost_array[$i]',`meal_plan`='$tab3_meal_plan_array[$i]',`max_occupancy`='$tab3_max_occ_array[$i]' WHERE entry_id='$tab3_entry_id_array[$i]'");
				}
			}
			else{
				$sq1 = mysql_query("DELETE FROM `hotel_blackdated_tarrif` WHERE `entry_id`='$tab3_entry_id_array[$i]'");
			}
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Hotel Blackdated Tariff details not updated!";
			}
		}
		//TAB-4
		for($i=0; $i<sizeof($tab4_room_cat_array); $i++){
			if($tab4_checked_id_array[$i] == 'true'){
						
				if($tab4_entry_id_array[$i] == ''){
					$sq = mysql_query("select max(entry_id) as max from hotel_weekend_tarrif");
					$value = mysql_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;

					$tab4_room_cat_array[$i] = mysql_real_escape_string($tab4_room_cat_array[$i]);
					$tab4_max_occ_array[$i] = mysql_real_escape_string($tab4_max_occ_array[$i]);
					$tab4_day_array[$i] = mysql_real_escape_string($tab4_day_array[$i]);
					$tab4_single_bed_array[$i] = mysql_real_escape_string($tab4_single_bed_array[$i]);
					$tab4_double_bed_array[$i] = mysql_real_escape_string($tab4_double_bed_array[$i]);
					$tab4_triple_bed_array[$i] = mysql_real_escape_string($tab4_triple_bed_array[$i]);
					$tab4_chwithbed_array[$i] = mysql_real_escape_string($tab4_chwithbed_array[$i]);
					$tab4_chwobed_array[$i] = mysql_real_escape_string($tab4_chwobed_array[$i]);
					$tab4_fchild_array[$i] = mysql_real_escape_string($tab4_fchild_array[$i]);
					$tab4_schild_array[$i] = mysql_real_escape_string($tab4_schild_array[$i]);
					$tab4_extra_bed_array[$i] = mysql_real_escape_string($tab4_extra_bed_array[$i]);
					$tab4_queen_bed_array[$i] = mysql_real_escape_string($tab4_queen_bed_array[$i]);
					$tab4_king_bed_array[$i] = mysql_real_escape_string($tab4_king_bed_array[$i]);
					$tab4_quad_bed_array[$i] = mysql_real_escape_string($tab4_quad_bed_array[$i]);
					$tab4_twin_bed_array[$i] = mysql_real_escape_string($tab4_twin_bed_array[$i]);
					$tab4_markup_per_array[$i] = mysql_real_escape_string($tab4_markup_per_array[$i]);
					$tab4_markup_cost_array[$i] = mysql_real_escape_string($tab4_markup_cost_array[$i]);
					$tab4_meal_plan_array[$i] = mysql_real_escape_string($tab4_meal_plan_array[$i]);
			
					$sq1 = mysql_query("INSERT INTO `hotel_weekend_tarrif`(`entry_id`, `pricing_id`, `room_category`, `day`, `double_bed`, `child_with_bed`, `child_without_bed`, `extra_bed`, `markup_per`, `markup`, `meal_plan`,`max_occupancy`) VALUES ('$max_entry_id','$pricing_id','$tab4_room_cat_array[$i]','$tab4_day_array[$i]','$tab4_double_bed_array[$i]','$tab4_chwithbed_array[$i]','$tab4_chwobed_array[$i]','$tab4_extra_bed_array[$i]','$tab4_markup_per_array[$i]','$tab4_markup_cost_array[$i]','$tab4_meal_plan_array[$i]','$tab4_max_occ_array[$i]')");
				}
				else{
					$sq1 = mysql_query("UPDATE `hotel_weekend_tarrif` SET `room_category`='$tab4_room_cat_array[$i]',`day`='$tab4_day_array[$i]',`double_bed`='$tab4_double_bed_array[$i]',`child_with_bed`='$tab4_chwithbed_array[$i]',`child_without_bed`='$tab4_chwobed_array[$i]',`extra_bed`='$tab4_extra_bed_array[$i]',`markup_per`='$tab4_markup_per_array[$i]',`markup`='$tab4_markup_cost_array[$i]',`meal_plan`='$tab4_meal_plan_array[$i]',`max_occupancy`='$tab4_max_occ_array[$i]' WHERE entry_id='$tab4_entry_id_array[$i]'");
				}
			}
			else{
				$sq1 = mysql_query("DELETE FROM `hotel_weekend_tarrif` WHERE `entry_id`='$tab4_entry_id_array[$i]'");
			}
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Hotel Weekend Tariff details not updated!";
			}
		}
		
		//TAB-5
		for($i=0; $i<sizeof($from_date_array); $i++){
			if($tab5_checked_id_array[$i] == 'true'){

				if($tab5_entry_id_array[$i] == ''){
					$sq = mysql_query("select max(entry_id) as max from hotel_offers_tarrif");
					$value = mysql_fetch_assoc($sq);
					$max_entry_id = $value['max'] + 1;

					$type_array[$i] = mysql_real_escape_string($type_array[$i]);
					$from_date_array[$i] = mysql_real_escape_string($from_date_array[$i]);
					$to_date_array[$i] = mysql_real_escape_string($to_date_array[$i]);
					$offer_array[$i] = mysql_real_escape_string($offer_array[$i]);
					$agent_array[$i] = mysql_real_escape_string($agent_array[$i]);
					$coupon_code_array[$i] = mysql_real_escape_string($coupon_code_array[$i]);
					$offer_amount_array[$i] = mysql_real_escape_string($offer_amount_array[$i]);

					if($from_date_array[$i]!=""){  $from_date_array[$i] = date("Y-m-d", strtotime($from_date_array[$i])); }
					if($to_date_array[$i]!=""){  $to_date_array[$i] = date("Y-m-d", strtotime($to_date_array[$i])); }
					$sq1 = mysql_query("INSERT INTO `hotel_offers_tarrif`(`entry_id`, `hotel_id`,`type`, `from_date`, `to_date`, `offer`,`offer_amount`,`coupon_code`, `agent_type`) VALUES ('$max_entry_id','$hotel_id','$type_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$offer_array[$i]','$offer_amount_array[$i]','$coupon_code_array[$i]','$agent_array[$i]')");
					if(!$sq1){
						$GLOBALS['flag'] = false;
						echo "error--Offers/Coupon Tariff details not saved!";
					}
				}
				else{
					if($from_date_array[$i]!=""){  $from_date_array[$i] = date("Y-m-d", strtotime($from_date_array[$i])); }
					if($to_date_array[$i]!=""){  $to_date_array[$i] = date("Y-m-d", strtotime($to_date_array[$i])); }
					$sq1 = mysql_query("UPDATE `hotel_offers_tarrif` SET  `type`='$type_array[$i]',`from_date`='$from_date_array[$i]', `to_date`='$to_date_array[$i]', `offer`='$offer_array[$i]', `agent_type`='$agent_array[$i]',`coupon_code`='$coupon_code_array[$i]',`offer_amount`='$offer_amount_array[$i]' WHERE entry_id='$tab5_entry_id_array[$i]'");
				}
			}
			else{
				$sq1 = mysql_query("DELETE FROM `hotel_offers_tarrif` WHERE `entry_id`='$tab5_entry_id_array[$i]'");
			}
			if(!$sq1){
				$GLOBALS['flag'] = false;
				echo "error--Offers/Coupon Tariff details not updated!";
			}
		}
		commit_t();
		echo "Hotel Tariff details Updated!";
	}
	else{
		$GLOBALS['flag'] = false;
		echo "error--Tariff details not updated!";
	}
}


function vendor_acknowledge($login_id){

	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
 	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

 	 $sq_request_id=mysql_fetch_assoc(mysql_query("select * from vendor_login where login_id='$login_id'"));
 	 $sq_hotel_id=mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_request_id[user_id]'"));
 	 $sq_city_id=mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_hotel_id[city_id]'"));

	 $content = '

	 <style type="text/css">

		td,th

		{

			padding:15px; 

			border:0px solid #c5c5c5;

		}

	</style>

		<p>Dear Admin, Backoffice,</p>

	     <table style="border-collapse: collapse;">

		     <tr>

	            <td style="padding:7px;">You have received new hotel Tariff by <span style="color:green">'.$sq_hotel_id['hotel_name'].'</span>

	            </td>

	         <tr>

	         <tr>

	            <td style="padding:7px; ">City Name : &nbsp;<span>'.$sq_city_id['city_name'].'</span>

	            </td>

	         </tr>

	         <tr>

	            <td style="padding:7px; ">Country Name : &nbsp;<span>'.$sq_hotel_id['country'].'</span>

	            </td>

	         </tr>

          </table>

	     </p>

	    <p style="padding:7px;">

            <a href="'.BASE_URL.'/view/hotels/master/index.php" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">View Tariff</a>

          </p>

	  ';



	  global $model;
	  $subject = " Hotel Tariff Acknowlagement";
	  $model->app_email_master($app_email_id, $content, $subject);
}



function vendor_update_acknowledge($login_id)

{

	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

 	 global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

 	 $sq_request_id=mysql_fetch_assoc(mysql_query("select * from vendor_login where login_id='$login_id'"));

 	 $sq_hotel_id=mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$sq_request_id[user_id]'"));

 	 $sq_city_id=mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_hotel_id[city_id]'"));

	 $content = '

	 <style type="text/css">

		td,th

		{

			padding:15px; 

			border:0px solid #c5c5c5;

		}

	</style>

		<p>Dear Admin, Backoffice,</p>

	     <table style="border-collapse: collapse;">

		     <tr>

	            <td style="padding:7px;">The Tariff updated by <span style="color:green">'.$sq_hotel_id['hotel_name'].'</span>

	            </td>

	         <tr>

	         <tr>

	            <td style="padding:7px; ">City Name : &nbsp;<span>'.$sq_city_id['city_name'].'</span>

	            </td>

	         </tr>

	         <tr>

	            <td style="padding:7px; ">Country Name : &nbsp;<span>'.$sq_hotel_id['country'].'</span>

	            </td>

	         </tr>

          </table>

	     </p>

	    <p style="padding:7px;">

            <a href="'.BASE_URL.'/view/hotels/master/index.php" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">View New Tariff</a>

          </p>

	  ';



	  global $model;

	  $subject = " Hotel Tariff Acknowlagement";

	  $model->app_email_master($app_email_id, $content, $subject);



}

}