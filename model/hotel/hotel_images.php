<?php 
class hotel_images
{
	public function save()
	{
		 $hotel_url = $_POST['hotel_upload_url'];
		 $hotel_names = $_POST['hotel_names'];
		 
 		 $max_img_entry_id = mysql_fetch_assoc(mysql_query("select max(id) as max from hotel_vendor_images_entries"));
 		 $max_entry_id = $max_img_entry_id['max']+1;
 		 $sq_count=mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id='$hotel_names'"));
 		  if($sq_count<10)
 		  {
			  $sq_count++;
			  $sq_img = mysql_query("INSERT INTO `hotel_vendor_images_entries`(`id`, `hotel_id`, `hotel_pic_url`) VALUES ('$max_entry_id','$hotel_names','$hotel_url')");
			  if(!$sq_img)
			  {
			  	echo "error--Image Not Saved";
			  }else
			  {
			  	echo $sq_count." Images Saved";
			  }
		  }else
		  {
		  	echo "error--Sorry, you can upload upto 10 images.";
		  }

	}

	public function update()
	{
		$hotel_url = $_POST['hotel_upload_url'];
		$hotel_id = $_POST['hotel_id'];
	 	$max_img_entry_id = mysql_fetch_assoc(mysql_query("select max(id) as max from hotel_vendor_images_entries"));
	  	$max_entry_id = $max_img_entry_id['max']+1;

	  	$sq_count=mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id='$hotel_id'"));
		  if($sq_count<10)
		  {
		  	$sq_img = mysql_query("INSERT INTO `hotel_vendor_images_entries`(`id`, `hotel_id`, `hotel_pic_url`) VALUES ('$max_entry_id','$hotel_id','$hotel_url')");
		  	if(!$sq_img)
		  	{
		  		echo "error--Image Not Saved";
		  	}else
		  	{
		  		echo "Image Saved";
		  	}
		  }else
		  {
		  	echo "error--Sorry, you can upload upto 10 images.";
		  }
	} 
}
?>