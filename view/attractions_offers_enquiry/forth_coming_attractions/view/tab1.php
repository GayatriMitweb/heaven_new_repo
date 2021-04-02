 	<div class="app_panel_content Filter-panel">        

        <div class="col-sm-6">

            <select id="hotel_names" name="hotel_names" onchange="load_images()">

                   <?php 

                  $sq_hotel1 = mysql_query("select * from custom_package_hotels where package_id = '$package_id'");

                  while($row_hotel1 = mysql_fetch_assoc($sq_hotel1))

                  {

                    $sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id = '$row_hotel1[hotel_name]'"));   

                      ?>

                      <option value="<?= $sq_hotel['hotel_id'] ?>"><?= $sq_hotel['hotel_name'] ?></option>

                      <?php

                  }

                  ?>

            </select>

        </div>

    </div>

 

<div class="main_block mg_tp_20" id="images_list_div">

   

      <!-- <div class="item">

               <img src="" id="images_list" class="img-resposive">

        </div> 

        <div class="item">

               <img src="" id="images_list1"  class="img-resposive">

        </div> 

        <div class="item">

               <img src="" id="images_list2"  class="img-resposive">

        </div> 

    </div> --> 

</div>     

         

<script type="text/javascript">

load_images();

function load_images()

{

  var hotel_names = $('#hotel_names').val();
  var base_url = $('#base_url').val();
    $.ajax({

          type:'post',

          url: base_url+'view/custom_packages/master/view/get_hotel_images.php',

          data:{hotel_name : hotel_names },

          success:function(result)

          {

            $('#images_list_div').html(result);

           /* var splitted = result.split(","); // RESULT

           

            $("#images_list").attr('src',splitted[1]); 

            $("#images_list1").attr('src',splitted[2]);

            $("#images_list2").attr('src',splitted[3]);*/

        

          }

  });

}

</script>  