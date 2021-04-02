<?php 
class attraction_images
{
	public function save()
	{
		 $att_url = $_POST['upload_url'];

		 $max_id1 = mysql_fetch_assoc(mysql_query("select max(id) as max from fourth_coming_attraction_master"));
 		 $max_id = $max_id1['max']+1;
 		 $max_img_entry_id = mysql_fetch_assoc(mysql_query("select max(attr_id) as max from fourth_coming_att_images"));
 		 $max_entry_id = $max_img_entry_id['max']+1;

 		  $sq_count=mysql_num_rows(mysql_query("select * from fourth_coming_att_images where fourth_id='$max_id'"));
 		  if($sq_count<3)
 		  {
			  $sq_img = mysql_query("INSERT INTO `fourth_coming_att_images`(`attr_id`, `fourth_id`, `upload`) VALUES ('$max_entry_id','$max_id','$att_url')");
			  if(!$sq_img)
			  {
			  	echo "error--Image Not Saved";
			  }else
			  {
			  	echo "Image Saved";
			  }
		  }else
		  {
		  	echo "error--Sorry,You can Upload upto 3 images.".$data[0]."/".$data[1];
		  }

	}

	public function update()
	{
		$attr_url = $_POST['upload_url'];
		$fourth_id = $_POST['fourth_id'];
	 	$max_img_entry_id = mysql_fetch_assoc(mysql_query("select max(id) as max from fourth_coming_att_images"));
	  	$max_entry_id = $max_img_entry_id['max']+1;

	  	$sq_count=mysql_num_rows(mysql_query("select * from fourth_coming_att_images where fourth_id='$fourth_id'"));
		  if($sq_count<3)
		  {
		  	$sq_img = mysql_query("INSERT INTO `fourth_coming_att_images`(`attr_id`, `fourth_id`, `upload`) VALUES ('$max_entry_id','$fourth_id','$attr_url')");
		  	if(!$sq_img)
		  	{
		  		echo "error--Image Not Saved";
		  	}else
		  	{
		  		echo "Image Saved";
		  	}
		  }else
		  {
		  	echo "error--Sorry,You can Upload upto 3 images.";
		  }
	} 
	
}
?>