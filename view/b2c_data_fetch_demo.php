<?php
include_once '../model/model.php';
$cached_array = json_decode(file_get_contents(BASE_URL.'view/b2c_cache.php'));

// echo "=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Company Profile</h3> ===================<br/>";
// var_dump($cached_array[0]->company_profile_data);
// // var_dump($cached_array[0]->company_profile_data[0]->contact_no);
var_dump($cached_array[0]->company_profile_data[0]->canc_policy_url);
// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Package Tours</h3> ===================<br/>";
// var_dump($cached_array[0]->package_tour_data);
// $item = null;
// $package_tour_data = $cached_array[0]->package_tour_data;
// foreach($package_tour_data as $struct) {
//     if (5 == $struct->package_id) {
//         $item = $struct;
//         break;
//     }
// }
// echo $item->package_name.'<br/>';
echo "<h3 style='margin:0px;'>"."(".$cached_array[0]->package_tour_data[$i]->package_id.")".$cached_array[0]->package_tour_data[0]->package_name."(".$cached_array[0]->package_tour_data[0]->package_code.")(".$cached_array[0]->package_tour_data[$i]->total_nights."N/".$cached_array[0]->package_tour_data[0]->total_days."D)</h3> ";
echo "<h3 style='margin:0px;'>Destination: ".$cached_array[0]->package_tour_data[0]->dest_name."(".$cached_array[0]->package_tour_data[0]->p_currency_name.": ".$cached_array[0]->package_tour_data[0]->p_currency_id.")</h3> ";
echo "<h3 style='margin:0px;'>Inclusions: ".$cached_array[0]->package_tour_data[0]->inclusions."<h3/>";
echo "<h3 style='margin:0px;'>Exclusions: ".$cached_array[0]->package_tour_data[0]->exclusions."<h3/>";

// echo "<h3 style='margin:0px;'>Exclusions: ".$cached_array[0]->package_tour_data[0]->image_url."<h3/>";

// echo "<h3 style='margin:0px;'>======================= Package Tours(Itinerary) ===========================</h3><br/>";
// $sightseeing_array = json_decode(($cached_array[0]->package_tour_data[0]->sightseeing_array));
// var_dump($sightseeing_array);

// echo "<h3 style='margin:0px; margin-top:10px'>======================== Package Tours(Hotels) ==============================</h3><br/>";
// $hotel_array = json_decode(($cached_array[0]->package_tour_data[0]->hotel_array));
// var_dump($hotel_array);

// echo "<h3 style='margin:0px;margin-top:10px'>========================= Package Tours(Transfer) ===========================</h3><br/>";
// $transport_array = json_decode(($cached_array[0]->package_tour_data[0]->transport_array));
// var_dump($transport_array);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Group Tours</h3> ===================<br/>";
// // echo "<br/>=================== <h3 style='margin:0px;'>Group Tours</h3> ===================<br/>";
// // var_dump($cached_array[0]->group_tour_data);
// echo "<h3 style='margin:0px;'>"."(".$cached_array[0]->group_tour_data[0]->tour_id.")".$cached_array[0]->group_tour_data[0]->tour_name."(".$cached_array[0]->group_tour_data[0]->tour_type.")</h3> ";
// echo "<h3 style='margin:0px;'>Destination: ".$cached_array[0]->group_tour_data[0]->dest_name."</h3> ";
// echo "<h3 style='margin:0px;'>Inclusions: ".$cached_array[0]->group_tour_data[0]->inclusions."<h3/>";
// echo "<h3 style='margin:0px;'>Exclusions: ".$cached_array[0]->group_tour_data[0]->exclusions."<h3/>";

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Tour Groups) ===========================</h3><br/>";
// $tour_groups_array = json_decode(($cached_array[0]->group_tour_data[0]->tour_groups_array));
// var_dump($tour_groups_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Itinerary) ===========================</h3><br/>";
// $sightseeing_array = json_decode(($cached_array[0]->group_tour_data[0]->sightseeing_array));
// var_dump($sightseeing_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Train) ===========================</h3><br/>";
// $train_groups_array = json_decode(($cached_array[0]->group_tour_data[0]->train_groups_array));
// var_dump($train_groups_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Hotels) ===========================</h3><br/>";
// $hotel_groups_array = json_decode(($cached_array[0]->group_tour_data[0]->hotel_groups_array));
// var_dump($hotel_groups_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Flight) ===========================</h3><br/>";
// $flight_groups_array = json_decode(($cached_array[0]->group_tour_data[0]->flight_groups_array));
// var_dump($flight_groups_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Group Tours(Cruise) ===========================</h3><br/>";
// $cruise_groups_array = json_decode(($cached_array[0]->group_tour_data[0]->cruise_groups_array));
// var_dump($cruise_groups_array);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Hotels</h3> ===================<br/>";
// var_dump($cached_array[0]->hotels_data);

// echo "<h3 style='margin:0px;'>".$cached_array[0]->hotels_data[0]->hotel_name."</h3>";
// echo "<h3 style='margin:0px;margin-top:10px'>======================= Hotels(Images) ===========================</h3><br/>";
// var_dump(json_decode($cached_array[0]->hotels_data[0]->hotel_images_array));

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Hotels(Blackdated Costing) =========================</h3><br/>";
// $hotel_costing_array = $cached_array[0]->hotels_data;
// var_dump($hotel_costing_array[0]->hotel_blackdated_costing_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Hotels(Weekend Costing) ===========================</h3><br/>";
// var_dump($hotel_costing_array[0]->hotel_weekend_costing_array);

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Hotels(Seasonal Costing) ============================</h3><br/>";
// var_dump($hotel_costing_array[0]->hotel_contracted_costing_array);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Activity</h3> ===================<br/>";
// // var_dump($cached_array[0]->activity_data);

// echo "<h3 style='margin:0px;'>".$cached_array[0]->activity_data[0]->activity_name."</h3>";

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Activity(Images) ===========================</h3><br/>";
// var_dump(json_decode($cached_array[0]->activity_data[4]->images_array));

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Activity(Costing) ============================</h3><br/>";
// $costing_array = json_decode(($cached_array[0]->activity_data[0]->costing_array));
// var_dump($costing_array);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Transfer</h3> ===================<br/>";
// // var_dump($cached_array[0]->transfer_data);
// echo "<h3 style='margin:0px;'>".$cached_array[0]->transfer_data[0]->vehicle_name."( ".$cached_array[0]->transfer_data[0]->vehicle_type.")</h3>";

// echo "<h3 style='margin:0px;margin-top:10px'>======================= Transfer(Costing) ============================</h3><br/>";
// $costing_array = json_decode(($cached_array[0]->transfer_data[0]->costing_array));
// var_dump($costing_array);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Visa Details</h3> ===================<br/>";
// // var_dump($cached_array[0]->visa_data);
// var_dump($cached_array[0]->visa_data[0]->country);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>Terms and conditions</h3> ===================<br/>";
// var_dump($cached_array[0]->terms_conditions_data);

// echo "<br/>=================== <h3 style='margin:0px;color:red;background-color: lightpink;'>B2C CMS</h3> ===================<br/>";
// var_dump($cached_array[0]->cms_data);
// echo '<br/><br/>';
// // $arr = json_decode($cached_array[0]->cms_data[0]->banner_images);
// // for($i=0;$i<sizeof($arr);$i++){
// //     echo $arr[$i]->image_url.'<br/>';
// // }
?>