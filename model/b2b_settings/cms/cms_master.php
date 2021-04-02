<?php
class cms_master{

public function save(){

	$section_name = $_POST['section_name'];
	$display_status = $_POST['display_status'];
	//For 1st settings table
	if($section_name == '1'||$section_name == '2'||$section_name == '3'||$section_name == '4'||$section_name == '5'||$section_name == '6'||$section_name == '7'||$section_name == '8'||$section_name == '9'){

		$sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings"));
		if($sq_settings == '0'){
			$banner_images = json_encode($_POST['banner_images']);
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_settings"));
			$entry_id = $sq_max['max'] + 1;
			if($section_name == '1'){
				$query = "insert into b2b_settings ( entry_id, banners) values ( '$entry_id', '$banner_images')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '2'){
				$query = "insert into b2b_settings ( entry_id, why_choose_us,why_choose_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '3'){
				$query = "insert into b2b_settings ( entry_id, amazing_dest_ideas,amazing_destideas_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '4'){
				$query = "insert into b2b_settings ( entry_id, popular_dest,popular_dest_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '5'){
				$query = "insert into b2b_settings ( entry_id, popular_honey_hotels,popular_honey_hotels_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '6'){
				$query = "insert into b2b_settings ( entry_id, popular_activities,popular_activities_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '7'){
				$query = "insert into b2b_settings ( entry_id, call_to_action,call_to_action_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '8'){
				$query = "insert into b2b_settings ( entry_id, popular_hotels,popular_hotels_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			else if($section_name == '9'){
				$query = "insert into b2b_settings ( entry_id, popular_honey_dest,popular_honey_dest_flag) values ( '$entry_id', '$banner_images','$display_status')";
				$sq_setting = mysql_query($query);
			}
			if($sq_setting){
				echo "sucess--B2B CMS settings saved.";
				exit;
			}
			else{
				echo "error--Sorry, B2B CMS Settings are not saved!";
			}
		}
		else{
			$row_query = mysql_fetch_assoc(mysql_query("SELECT * FROM `b2b_settings`"));
			if($section_name == '1'){
				$new_array = array();

				$banners = json_decode($row_query['banners']);
				for($i=0;$i<sizeof($banners);$i++){
					$temp_object['banner_count'] = $banners[$i]->banner_count;
					$temp_object['image_url'] = $banners[$i]->image_url;
					array_push($new_array,$temp_object);
				}
				$banner_images = json_encode($_POST['banner_images']);
				$banner_images = json_decode($banner_images);
				$count = sizeof($banners)+1;
				for($j=0;$j<sizeof($banner_images);$j++){
					$temp_object1['banner_count'] = $count++;
					$temp_object1['image_url'] = $banner_images[$j]->image_url;
					array_push($new_array,$temp_object1);
				}

				$banner_images1 = json_encode($new_array);
				$query = "update b2b_settings set banners = '$banner_images1' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '2'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set why_choose_us = '$banner_images',why_choose_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '3'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set amazing_dest_ideas = '$banner_images',amazing_destideas_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '4'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set popular_dest = '$banner_images',popular_dest_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '5'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set popular_honey_hotels = '$banner_images',popular_honey_hotels_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '6'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set popular_activities = '$banner_images',popular_activities_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '7'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set call_to_action = '$banner_images',call_to_action_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '8'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set popular_hotels = '$banner_images',popular_hotels_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			elseif($section_name == '9'){
				$banner_images = json_encode($_POST['banner_images']);
				$query = "update b2b_settings set popular_honey_dest = '$banner_images',popular_honey_dest_flag='$display_status' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			if($sq_setting){
				echo "sucess--B2B CMS settings updated.";
				exit;
			}
			else{
				echo "error--Sorry, B2B CMS Settings are not updated!";
			}
		}
	}
	else{
		//For 2nd settings table
	   $sq_settings = mysql_num_rows(mysql_query("select * from b2b_settings_second"));
	   if($sq_settings == '0'){
		    $banner_images = json_encode($_POST['banner_images']);
		    $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_settings_second"));
			$entry_id1 = $sq_max['max'] + 1;
			$activeTab = $_POST['activeTab'];
			$banner_images = json_encode($_POST['banner_images']);
			if($activeTab == 'hotels'){
				$query = "insert into b2b_settings_second ( entry_id, col1) values ( '$entry_id1', '$banner_images')";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'activities'){
				$query = "insert into b2b_settings_second ( entry_id, col2) values ( '$entry_id1', '$banner_images')";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'tours'){
				$query = "insert into b2b_settings_second ( entry_id, col3) values ( '$entry_id1', '$banner_images')";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'terms'){
				$banner_images = json_decode($banner_images);
				$terms_cond = addslashes($banner_images[0]->terms_cond);
				$privacy_policy = addslashes($banner_images[0]->privacy_policy);
				$cancellation_policy = addslashes($banner_images[0]->cancellation_policy);
				$refund_policy = addslashes($banner_images[0]->refund_policy);
				$careers_policy = addslashes($banner_images[0]->careers_policy);
				$copyright_text = addslashes($banner_images[0]->copyright_text);

				$sq_setting = mysql_query("insert into b2b_settings_second (terms_cond,privacy_policy,cancellation_policy,refund_policy,careers_policy,footer_strip)values('$entry_id1','$terms_cond','$privacy_policy','$cancellation_policy','$refund_policy','$careers_policy','$copyright_text')");
			}
			if($sq_setting){
				echo "sucess--B2B CMS settings saved.";
				exit;
			}
			else{
				echo "error--Sorry, B2B CMS Settings are not saved!";
			}
		}
		else{
			$activeTab = $_POST['activeTab'];
			$banner_images = json_encode($_POST['banner_images']);
			if($activeTab == 'hotels'){
				$query = "update b2b_settings_second set col1 = '$banner_images' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'activities'){
				$query = "update b2b_settings_second set col2 = '$banner_images' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'tours'){
				$query = "update b2b_settings_second set col3 = '$banner_images' where entry_id='1'";
				$sq_setting = mysql_query($query);
			}
			else if($activeTab == 'terms'){
				$banner_images = json_decode($banner_images);
				$terms_cond = addslashes($banner_images[0]->terms_cond);
				$privacy_policy = addslashes($banner_images[0]->privacy_policy);
				$cancellation_policy = addslashes($banner_images[0]->cancellation_policy);
				$refund_policy = addslashes($banner_images[0]->refund_policy);
				$careers_policy = addslashes($banner_images[0]->careers_policy);
				$copyright_text = addslashes($banner_images[0]->copyright_text);

				$sq_setting = mysql_query("update b2b_settings_second set terms_cond = '$terms_cond',privacy_policy = '$privacy_policy',cancellation_policy = '$cancellation_policy',refund_policy = '$refund_policy',careers_policy = '$careers_policy',footer_strip = '$copyright_text' where entry_id='1'");
			}
		}
	
		if($sq_setting){
			echo "sucess--B2B CMS settings updated.";
			exit;
		}
		else{
			echo "error--Sorry, B2B CMS Settings are not updated!";
		}
	}
}

public function delete(){
	$section_name = $_POST['section_name'];
	$banner_images = json_encode($_POST['banner_images']);
	$banner_images = json_decode($banner_images);
	if($section_name == '1'){
		$new_array = array();
		for($j=0;$j<sizeof($banner_images);$j++){
			$temp_object1['banner_count'] = $j+1;
			$temp_object1['image_url'] = $banner_images[$j]->image_url;
			array_push($new_array,$temp_object1);
		}
		$new_array = json_encode($new_array);
		$query = "update b2b_settings set banners = '$new_array' where entry_id='1'";
		$sq_setting = mysql_query($query);
	}
	if($section_name == '2'){
		$new_array = array();
		for($j=0;$j<sizeof($banner_images);$j++){
			$temp_object1['banner_count'] = $j+1;
			$temp_object1['image_url'] = $banner_images[$j]->image_url;
			$temp_object1['title'] = $banner_images[$j]->title;
			$temp_object1['description'] = $banner_images[$j]->description;
			array_push($new_array,$temp_object1);
		}
		$new_array = json_encode($new_array);
		$query = "update b2b_settings set why_choose_us = '$new_array' where entry_id='1'";
		$sq_setting = mysql_query($query);
	}
	if($sq_setting){
		echo "sucess--Image Deleted successfully.";
		exit;
	}
	else{
		echo "error--Sorry, Image is not deleted!";
	}
}
}

