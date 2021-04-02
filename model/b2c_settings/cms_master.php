<?php
class cms_master{

	public function save(){

		$section = $_POST['section'];
		$data = json_encode($_POST['data']);
		$sq_settings = mysql_num_rows(mysql_query("select * from b2c_settings"));
		if($sq_settings == '0'){
			if($section == '1'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, banner_images) values ( '1', '$data')");
			}
			
			if($section == '2'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, popular_dest) values ( '1', '$data')");
			}
			if($section == '3'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, popular_hotels) values ( '1', '$data')");
			}
			if($section == '4'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, popular_activities) values ( '1', '$data')");
			}
			if($section == '5'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, fit_tours) values ( '1', '$data')");
			}
			if($section == '6'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, footer_holidays) values ( '1', '$data')");
			}
			if($section == '7'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, book_enquiry_button) values ( '1', '$data')");
			}
			if($section == '8'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, customer_testimonials) values ( '1', '$data')");
			}
			if($section == '9'){

				$data = json_decode($data);
				$terms_of_use = addslashes($data[0]->terms_of_use);
				$privacy_policy = addslashes($data[0]->privacy_policy);
				$cancellation_policy = addslashes($data[0]->cancellation_policy);
				$refund_policy = addslashes($data[0]->refund_policy);
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id,cancellation_policy,refund_policy,privacy_policy,terms_of_use) values ( '1', '$cancellation_policy','$refund_policy','$privacy_policy','$terms_of_use')");
			}
			if($section == '10'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, social_media) values ( '1', '$data')");
			}
			if($section == '11'){
				$data = json_decode($data);
				$header_strip_note = addslashes($data[0]->header_strip_note);
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, header_strip_note) values ( '1', '$header_strip_note')");
			}
			if($section == '12'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, git_tours) values ( '1', '$data')");
			}
			if($section == '13'){
				$data = json_decode($data);
				$title = $data[0]->title;
				$image = $data[0]->image;
				$description = mysql_real_escape_string($data[0]->description);

				$new_array = array();
				$temp_object1->title = $title;
				$temp_object1->image = $image;
				$temp_object1->description = $description;
				array_push($new_array,$temp_object1);
				$new_array = json_encode($new_array);
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, blogs) values ( '1', '$data')");
			}
			if($section == '14'){
				$sq_setting = mysql_query("insert into b2c_settings ( setting_id, gallery) values ( '1', '$data')");
			}
			if($sq_setting){
				echo "sucess--B2C CMS settings saved.";
				exit;
			}
			else{
				echo "error--Sorry, B2C CMS Settings are not saved!";
			}
		}
		else{
			if($section == '1'){
				$sq_setting = mysql_query("update b2c_settings set banner_images = '$data' where setting_id='1'");
			}
			if($section == '2'){
				$sq_setting = mysql_query("update b2c_settings set popular_dest = '$data' where setting_id='1'");
			}
			if($section == '3'){
				$sq_setting = mysql_query("update b2c_settings set popular_hotels = '$data' where setting_id='1'");
			}
			if($section == '4'){
				$sq_setting = mysql_query("update b2c_settings set popular_activities = '$data' where setting_id='1'");
			}
			if($section == '5'){
				$sq_setting = mysql_query("update b2c_settings set fit_tours = '$data' where setting_id='1'");
			}
			if($section == '6'){
				$sq_setting = mysql_query("update b2c_settings set footer_holidays = '$data' where setting_id='1'");
			}
			if($section == '7'){
				$sq_setting = mysql_query("update b2c_settings set book_enquiry_button = '$data' where setting_id='1'");
			}
			if($section == '8'){
				$sq_setting = mysql_query("update b2c_settings set customer_testimonials = '$data' where setting_id='1'");
			}
			if($section == '9'){

				$data = json_decode($data);
				$terms_of_use = addslashes($data[0]->terms_of_use);
				$privacy_policy = addslashes($data[0]->privacy_policy);
				$cancellation_policy = addslashes($data[0]->cancellation_policy);
				$refund_policy = addslashes($data[0]->refund_policy);
				$sq_setting = mysql_query("update b2c_settings set cancellation_policy = '$cancellation_policy',refund_policy='$refund_policy',privacy_policy='$privacy_policy',terms_of_use='$terms_of_use' where setting_id='1'");
			}
			if($section == '10'){
				$sq_setting = mysql_query("update b2c_settings set social_media = '$data' where setting_id='1'");
			}
			if($section == '11'){
				$data = json_decode($data);
				$header_strip_note = addslashes($data[0]->header_strip_note);
				$sq_setting = mysql_query("update b2c_settings set header_strip_note = '$header_strip_note' where setting_id='1'");
			}
			if($section == '12'){
				$sq_setting = mysql_query("update b2c_settings set git_tours = '$data' where setting_id='1'");
			}
			if($section == '13'){
				$data = json_decode($data);
				$new_array = array();
				for($j=0;$j<sizeof($data);$j++){
					
					$temp_object1['title'] = $data[$j]->title;
					$temp_object1['image'] = $data[$j]->image;
					$temp_object1['description'] = mysql_real_escape_string($data[$j]->description);
					
					array_push($new_array,$temp_object1);
				}
				$new_array = json_encode($new_array);
				$sq_setting = mysql_query("update b2c_settings set blogs = '$new_array' where setting_id='1'");
			}
			if($section == '14'){
				$sq_setting = mysql_query("update b2c_settings set gallery = '$data' where setting_id='1'");
			}
		}
		
		if($sq_setting){
			echo "success--B2C CMS settings updated.";
			exit;
		}
		else{
			echo "error--Sorry, B2C CMS Settings are not updated!";
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
			$query = "update b2c_settings set banner_images = '$new_array' where setting_id='1'";
			$sq_setting = mysql_query($query);
		}
		if($section_name == '14'){

			$new_array = array();
			for($j=0;$j<sizeof($banner_images);$j++){
				$temp_object1['dest_id'] = $banner_images[$j]->dest_id;
				$temp_object1['image_url'] = $banner_images[$j]->image_url;
				array_push($new_array,$temp_object1);
			}
			$new_array = json_encode($new_array);
			$sq_setting = mysql_query("update b2c_settings set gallery = '$new_array' where setting_id='1'");
		}
		if($sq_setting){
			echo "Image Deleted successfully.";
			exit;
		}
		else{
			echo "error--Sorry, Image is not deleted!";
		}
	}
}

