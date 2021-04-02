<?php 
include_once('../../../../model/model.php');
$hotel_name = $_POST['hotel_name'];

$query = "select * from hotel_vendor_images_entries where hotel_id='$hotel_name'";
$sq_hotel_image = mysql_query($query);
?>

<div class="owl-carousel">
<?php
	$sq_hotel_count = mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id = '$hotel_name'"));
	if($sq_hotel_count == 0){
	    $newUrl1 = BASE_URL.'images/dummy-image.jpg'; 
	    for($i = 0;$i<3;$i++){
	?>
	     <div class="item">
	      	<img src="<?= $newUrl1 ?>" id="images_list" class="img-resposive">
	     </div>
	<?php } 	
	}
	 while($row_hotel = mysql_fetch_assoc($sq_hotel_image))
	 { 
		  $image = $row_hotel['hotel_pic_url']; 
		  $newUrl = preg_replace('/(\/+)/','/',$image);
		  $newUrl = explode('uploads', $newUrl);
		  $newUrl = BASE_URL.'uploads'.$newUrl[1];

/*$sq_count = mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id='$hotel_name' "));

if($sq_count==0){
	echo $download_url = ','.BASE_URL.'images/dummy-image.jpg'.','.BASE_URL.'images/dummy-image.jpg'.','.BASE_URL.'images/dummy-image.jpg';
}

if($sq_count==1){
	$query = "select * from hotel_vendor_images_entries where hotel_id='$hotel_name' ";
 
	$sq_hotel_image = mysql_query($query);
	while($row_image = mysql_fetch_assoc($sq_hotel_image)){
		$newUrl = preg_replace('/(\/+)/','/',$row_image['hotel_pic_url']); 
	
	echo $download_url = ','.BASE_URL.str_replace('../', '', $newUrl).','.BASE_URL.'images/dummy-image.jpg'.','.BASE_URL.'images/dummy-image.jpg';
	}
}

if($sq_count==2){
	$query = "select * from hotel_vendor_images_entries where hotel_id='$hotel_name' ";
 
	$sq_hotel_image = mysql_query($query);
	while($row_image = mysql_fetch_assoc($sq_hotel_image)){
		$newUrl = preg_replace('/(\/+)/','/',$row_image['hotel_pic_url']); 
	
	echo $download_url = ','.BASE_URL.str_replace('../', '', $newUrl).','.BASE_URL.'images/dummy-image.jpg';
	}
}

$query = "select * from hotel_vendor_images_entries where hotel_id='$hotel_name' ";
 
$sq_hotel_image = mysql_query($query);
while($row_image = mysql_fetch_assoc($sq_hotel_image)){
	$newUrl = preg_replace('/(\/+)/','/',$row_image['hotel_pic_url']); 
    $download_url = BASE_URL.str_replace('../', '', $newUrl);

 echo ','.$download_url;

 }*/

 //echo ','.$newUrl;
 ?> 
      <div class="item">
      	<img src="<?= $newUrl ?>" id="images_list" class="img-resposive">
      </div>

<?php 
} ?>
 </div>
<script type="text/javascript">
	 $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        pagination:false,
        autoPlay:true,
        singleItem:true,
        navigation:true,
        navigationText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
</script>