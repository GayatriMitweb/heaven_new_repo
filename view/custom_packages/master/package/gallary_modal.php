<form id="frm_tab_2">

<div class="app_panel"> 

    <!--=======Header panel======-->

    <div class="app_panel_head">
      <div class="container">
        <h2 class="pull-left"></h2>
        <div class="pull-right header_btn">
          <button type="button" onclick="back_to_tab_2()">
              <a data-original-title="" title="">
                  <i class="fa fa-arrow-left"></i>
              </a>
          </button>
        </div>
        <div class="pull-right header_btn">
          <button>
              <a data-original-title="" title=""></a>
          </button>
        </div>
      </div>
    </div> 



  <!--=======Header panel end======-->
   <div class="container">

      <div class="app_panel_content no-pad"> 

        <div class="panel panel-default panel-body mg_bt_10 mg_tp_20">

             <div class="row">

             <div class="col-md-3 col-sm-6 mg_bt_20">

                <select id="dest_name2" name="dest_name" title="Select Destination" onchange="image_list_reflect(this.value)" class="form-control" style="width:100%"> 

                    <option value="">Select Destination</option>

                     <?php 

                     $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 

                        while($row_dest = mysql_fetch_assoc($sq_query)){ ?>

                          <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

                      <?php } ?>

                </select>

             </div>
             <div class="col-md-9 col-sm-9 no-pad mg_bt_20">
               <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note">Note : Select atleast one sightseeing image</span>
             </div>

             </div>

             <div id="image_div"></div>         

        </div>

    </div>

   </div>

          <div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_0">

              <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;

              <button class="btn btn-sm btn-success" id="btn_save1"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

          </div>



<?= end_panel() ?>



</form>

    <div id="div_modal"></div>

<script>

$('#dest_name2').select2();

function image_list_reflect(dest_name2)

{

  var dest_id = $('#dest_name2').val();



  $.post('image_list_reflect.php', {dest_id : dest_id}, function(data){

        $('#image_div').html(data);

    });

}



image_list_reflect();

function back_to_tab_2()

{

  $('#tab_3_head').removeClass('active');

  $('#tab_2_head').addClass('active');

  $('.bk_tab').removeClass('active');

  $('#tab_2').addClass('active');

  $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

}



$(function(){

  $('#frm_tab_2').validate({

    rules:{

      },

      submitHandler:function(form){

            var base_url = $('#base_url').val();

            var dest_id = $("#dest_name_s").val();

            var package_code = $("#package_code").val();

            var package_name = $("#package_name").val();

            var total_days1 = $("#total_days").val();

            var total_nights = $("#total_nights").val();
            var adult_cost = $("#adult_cost").val();
            var child_cost = $("#child_cost").val();
            var infant_cost = $("#infant_cost").val();
            var child_with = $("#child_with").val();
            var child_without = $("#child_without").val();
            var extra_bed = $("#extra_bed").val();
            var status = $("#status").val();


            var inclusions = $("#inclusions").val();

            var exclusions = $("#exclusions").val();



            //Gallery 

            var gallary_arr2 = new Array();
            var gallary_arr = new Array();
            var gallary_arr2 = (function() {  var a = ''; $("input[name='image_check']:checked").each(function() { a += this.value+','; });  return a; })();

            var gallary_arr1 = gallary_arr2.split(",");

            for(var i=0; i<gallary_arr1.length-1;i++){
              gallary_arr.push(gallary_arr1[i]);
            }

            //Daywise program 

            var day_program_arr = new Array();

            var special_attaraction_arr = new Array();

            var overnight_stay_arr = new Array();
            var meal_plan_arr = new Array();

            var table = document.getElementById("dynamic_table_list");

            var rowCount = table.rows.length;

                for(var i=0; i<rowCount; i++)

                {

                     var row = table.rows[i];

                     var special_attaraction = row.cells[0].childNodes[0].value;
                     var day_program = row.cells[1].childNodes[0].value;
                     var overnight_stay = row.cells[2].childNodes[0].value;
                     var meal_plan = row.cells[3].childNodes[0].value;


                     day_program_arr.push(day_program);
                     special_attaraction_arr.push(special_attaraction);
                     overnight_stay_arr.push(overnight_stay);                 
                     meal_plan_arr.push(meal_plan);                 

                }

           

           //Hotel information

            var city_name_arr = new Array();

            var hotel_name_arr = new Array();

            var hotel_type_arr = new Array();

            var total_days_arr = new Array();

            var table = document.getElementById("tbl_package_hotel_master");

            var rowCount = table.rows.length;

                for(var i=0; i<rowCount; i++)

                {

                    var row = table.rows[i];

                  if(row.cells[0].childNodes[0].checked)

                  {  

                    var city_name = row.cells[2].childNodes[0].value;

                    var hotel_name = row.cells[3].childNodes[0].value;

                    var hotel_type = row.cells[4].childNodes[0].value;

                    var total_days = row.cells[5].childNodes[0].value;



                     city_name_arr.push(city_name);

                     hotel_name_arr.push(hotel_name);

                     hotel_type_arr.push(hotel_type);  

                     total_days_arr.push(total_days);  

                  }

                }

             //Transport information
              var vehicle_name_arr = new Array();
              var cost_name_arr = new Array();
              var table = document.getElementById("tbl_package_tour_transport");
              var rowCount = table.rows.length;
              for(var i=0; i<rowCount; i++){
                var row = table.rows[i];
                if(row.cells[0].childNodes[0].checked){  

                  var vehicle_name = row.cells[2].childNodes[0].value;
                  var cost = row.cells[3].childNodes[0].value;
                  vehicle_name_arr.push(vehicle_name);
                  cost_name_arr.push(cost);
                }

              }

            var tour_type = $('#tour_type').val();  
            $('#btn_save1').button('loading');  

            $("#vi_confirm_box").vi_confirm_box({

              callback: function(result){

                if(result=="yes"){

                  $("#btn_save1").prop("disabled", true);
                  $("#btn_save1").val('Saving...');

                  $.post(base_url+"controller/custom_packages/package_master_save.php",

                     { tour_type:tour_type,dest_id : dest_id, package_code : package_code, package_name : package_name, total_days : total_days1, total_nights : total_nights, status : status, city_name_arr : city_name_arr, hotel_name_arr : hotel_name_arr, hotel_type_arr : hotel_type_arr, total_days_arr : total_days_arr,vehicle_name_arr:vehicle_name_arr,cost_name_arr:cost_name_arr,child_cost : child_cost,adult_cost : adult_cost,infant_cost: infant_cost,child_with : child_with,child_without: child_without,extra_bed:extra_bed,inclusions : inclusions, exclusions : exclusions, day_program_arr : day_program_arr, special_attaraction_arr : special_attaraction_arr,overnight_stay_arr : overnight_stay_arr,meal_plan_arr : meal_plan_arr,gallary_arr : gallary_arr},

                     function(data) {
                      
                      var msg = data.split('--');
                      if(msg[0]=="error"){
                          error_msg_alert(msg[1]);
                          $('#btn_save1').button('reset');
                          return false;
                      }
                      else{ 
                        console.log(data);
                        booking_save_message(data);
                        $('#btn_save1').button('reset'); 
                      }  
                     });
                }
                else{
                  $('#btn_save1').button('reset'); 
                }
          }

        }); 





    }

  });

});

function back_to_tab_2()

{

  $('#tab_3_head').removeClass('active');

  $('#tab_2_head').addClass('active');

  $('.bk_tab').removeClass('active');

  $('#tab_2').addClass('active');

  $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

}



function booking_save_message(data)

{

  var base_url = $("#base_url").val();

      $('#vi_confirm_box').vi_confirm_box({

                false_btn: false,

                message: data,

                true_btn_text:'Ok',

        callback: function(data1){

            if(data1=="yes"){

              window.location.href =  '../index.php';

            }

          }

      });

}

</script>