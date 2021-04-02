<?php 
include "../../model.php";
$hotel_name = $_POST['hotel_name'];
?>
<!-- Modal feedback_suggestion-->
  <div class="modal fade acco_hotel_slider_moal" id="acco_hotel_slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" data-original-title="" title="">×</span></button>
           <div class="owl-carousel">
           <?php 
           $sq_hotel_count = mysql_num_rows(mysql_query("select * from hotel_vendor_images_entries where hotel_id = '$hotel_name'"));
            if($sq_hotel_count == '0'){
               $newUrl = BASE_URL.'images/dummy-image.jpg';
              for($i==0;$i<3;$i++){?>
                <div class="item">
                <img src="<?php echo $newUrl; ?>" class="img-responsive" style="height: 450px;width: 900px;">
              </div>
              <?php
            }
            }
            else{
           $sq_hotel_image = mysql_query("select * from hotel_vendor_images_entries where hotel_id = '$hotel_name'");
           while($row_hotel_image = mysql_fetch_assoc($sq_hotel_image)){
              $image = $row_hotel_image['hotel_pic_url']; 
              $newUrl = preg_replace('/(\/+)/','/',$image);
              $newUrl = explode('uploads', $newUrl);
              $newUrl = BASE_URL.'uploads'.$newUrl[1];
           ?>
              <div class="item">
                <img src="<?php echo $newUrl; ?>" class="img-responsive" style="height: 450px;width: 900px;">
              </div>
              <?php 
              }
              } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $('#acco_hotel_slider').modal('show');
   // Slider
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