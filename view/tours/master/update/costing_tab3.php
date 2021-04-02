<form id="frm_tour_update"> 
  <div class="app_panel">
    <!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
              <a>
                <i class="fa fa-arrow-right"></i>
              </a>
            </button>
          </div>
      </div>
    </div> 
    <div class="container">
        <div class="row text-center">   

          <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 

              <input type="text" id="txt_tour_cost" name="txt_tour_cost" onchange="validate_balance(this.id)" class="form-control" placeholder="Adult Cost" title="Adult Cost" value="<?php echo $tour_info['adult_cost']; ?>" maxlength="10"/>

          </div>

          <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 

              <input type="text" id="txt_child_with_cost" name="txt_child_with_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="CWB Cost" value="<?php echo $tour_info['child_with_cost']; ?>" title="CWB Cost" maxlength="10" />

          </div>

          <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 

              <input type="text" id="txt_child_without_cost" name="txt_child_without_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="CWOB Cost" value="<?php echo $tour_info['child_without_cost']; ?>" title="CWOB Cost" maxlength="10" />

          </div>                         

          <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 

              <input type="text" id="txt_infant_cost" name="txt_infant_cost" onchange="validate_balance(this.id)" class="form-control"  placeholder="Infant Cost"  value="<?php echo $tour_info['infant_cost']; ?>" title="Infant Cost" maxlength="10" />

          </div>  
      </div>
      <div class="row mg_tp_10 text-center"> 
        <div class="col-md-3 col-sm-6 mg_bt_10_xs"> 
          <input type="text" id="with_bed_cost" onchange="validate_balance(this.id)" value="<?php echo $tour_info['with_bed_cost']; ?>" name="with_bed_cost" placeholder="Extra bed cost" title="Extra bed cost">
        </div>
      </div>



        <div class="row mg_tp_20">                         

            <div class="col-md-6 col-sm-6 mg_bt_10_sm_xs">
                <h3 class="editor_title">Inclusions</h3>
                <textarea class="feature_editor" id="inclusions" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="4"><?php echo $tour_info['inclusions']; ?></textarea>
            </div>      

            <div class="col-md-6 col-sm-6"> 
                <h3 class="editor_title">Exclusions</h3>
                <textarea class="feature_editor" id="exclusions" name="exclusions" class="form-control"  placeholder="Exclusions" title="Exclusions" rows="4"><?php echo $tour_info['exclusions']; ?></textarea>
            </div>   

        </div>

        <div class="row mg_bt_10 mg_tp_20 text-center">
          <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>
      &nbsp;&nbsp;
          <button class="btn btn-sm btn-success ico_left" id="btn_update" >Update<i class="fa fa-floppy-o"></i>&nbsp;&nbsp;</button>
        </div>
      </div>
    </div>
</form>
<script>
function switch_to_tab3(){ 
  $('#tab4_head').removeClass('active');
	$('#tab3_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab3').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$('#frm_tour_update').validate({

    rules:{

    },

    submitHandler:function(form){   

      var base_url = $('#base_url').val();

      var tour_id = $("#txt_tour_id").val();

      var tour_type = $("#cmb_tour_type").val();

      var tour_name = $("#txt_tour_name").val();

      var adult_cost = $("#txt_tour_cost").val();

      var child_with_cost = $("#txt_child_with_cost").val();
      var child_without_cost = $("#txt_child_without_cost").val();

      var infant_cost = $("#txt_infant_cost").val();

      var with_bed_cost = $("#with_bed_cost").val();

      var visa_country_name = $("#visa_country_name").val();

      var company_name = $("#company_name").val();

      var active_flag = $('#active_flag1').val();

      var inclusions = $('#inclusions').val();

      var exclusions = $('#exclusions').val();



      //Tour group table

      var from_date = new Array();

      var to_date = new Array();

      var capacity = new Array();

      var tour_group_id = new Array();



      var table = document.getElementById("tbl_dynamic_tour_group");

      var rowCount = table.rows.length;

      var latest_date="";

      

      for(var i=0; i<rowCount; i++)

      {

        var row = table.rows[i];

         

        if(row.cells[0].childNodes[0].checked)

        {

           var from_date1 = row.cells[2].childNodes[0].value;         

           var to_date1 = row.cells[3].childNodes[0].value;         

           var capacity1 = row.cells[4].childNodes[0].value;   

           var tour_group_id1 = row.cells[5].childNodes[0].value;   



           if(from_date1=="" || to_date1=="" ){  

               error_msg_alert('From date and To Date is required'+(i+1));

               return false; 

           } 



           if(capacity1=="" ){  

                 error_msg_alert('Capacity is required'+(i+1));

                 return false; 

          }



           var get_from = from_date1.split('-');

           var day=get_from[0];

           var month=get_from[1];

           var year=get_from[2];

           var dateOne = new Date(year, month, day);      



           var get_to = to_date1.split('-');

           var day=get_to[0];

           var month=get_to[1];

           var year=get_to[2];

           var dateTwo = new Date(year, month, day);
           var latest_date = dateTwo;



           from_date.push(from_date1);

           to_date.push(to_date1);

           capacity.push(capacity1);    

           tour_group_id.push(tour_group_id1);    

        }      

      }



    //Daywise program 

        var day_program_arr = new Array();

        var special_attaraction_arr = new Array();

        var overnight_stay_arr = new Array();
        var meal_plan_arr = new Array();

        var entry_id_arr = new Array();

        var table = document.getElementById("dynamic_table_list1");

        var rowCount = table.rows.length;

        

            for(var i=0; i<rowCount; i++)

            {

                 var row = table.rows[i];

                 var special_attaraction = row.cells[1].childNodes[0].value;

                 var day_program = row.cells[2].childNodes[0].value;

                 var overnight_stay = row.cells[3].childNodes[0].value;
                 var meal_plan = row.cells[4].childNodes[0].value;

                 var entry_id = row.cells[6].childNodes[0].value;

                 if(day_program=="") {error_msg_alert("Day-wise program important"); return false;} 

                 
                 day_program_arr.push(day_program);

                 special_attaraction_arr.push(special_attaraction);

                 overnight_stay_arr.push(overnight_stay);  
                 meal_plan_arr.push(meal_plan);  

                 entry_id_arr.push(entry_id);   

            }





    //Train Information

    var train_from_location_arr = new Array();

        var train_to_location_arr = new Array();
        var train_class_arr = new Array();
        var train_id_arr = new Array();
            var table = document.getElementById("tbl_group_tour_save_dynamic_train_update");
            var rowCount = table.rows.length;
              for(var i=0; i<rowCount; i++)

              {
                var row = table.rows[i];

                if(row.cells[0].childNodes[0].checked)

                {

                   var train_from_location1 = row.cells[2].childNodes[0].value;         

                   var train_to_location1 = row.cells[3].childNodes[0].value;   

                   var train_class = row.cells[4].childNodes[0].value;         

                   if(train_from_location1=="")

                   {

                      error_msg_alert('Enter train from location in row'+(i+1));

                      return false;

                   }



                   if(train_to_location1=="")

                   {

                      error_msg_alert('Enter train to location in row'+(i+1));

                      return false;

                   }                   


                   if(row.cells[5] && row.cells[5].childNodes[0]){

                    var train_id = row.cells[5].childNodes[0].value;

                   }

                   else{

                    var train_id = "";

                   }    

                   train_from_location_arr.push(train_from_location1);
                   train_to_location_arr.push(train_to_location1);
                   train_class_arr.push(train_class);
                   train_id_arr.push(train_id); 

                }      

              }
// Hotel Information
var city_name_arr = new Array();

var hotel_name_arr = new Array();

var hotel_type_arr = new Array();

var total_days_arr = new Array();

var hotel_entry_id_arr = new Array();

var table = document.getElementById("tbl_package_hotel_master_dynamic_update");

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

       
        if(row.cells[6] && row.cells[6].childNodes[0]){
          var hotel_entry_id = row.cells[6].childNodes[0].value;
           }
           else{
            var plane_id = "";
           }


         city_name_arr.push(city_name);

         hotel_name_arr.push(hotel_name);

         hotel_type_arr.push(hotel_type);  

         total_days_arr.push(total_days); 

         hotel_entry_id_arr.push(hotel_entry_id); 

      }
      
    }

        //Plane Information     

    var from_city_id_arr = new Array();
    var to_city_id_arr = new Array();
    var plane_from_location_arr = new Array();
    var plane_to_location_arr = new Array();
    var airline_name_arr = new Array();
    var plane_class_arr = new Array();
    var plane_id_arr = new Array();

    var table = document.getElementById("tbl_group_tour_quotation_dynamic_plane_update");
      var rowCount = table.rows.length;
      
      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];
         
        if(row.cells[0].childNodes[0].checked)
        {
           
           var plane_from_location1 = row.cells[2].childNodes[0].value;
           var plane_to_location1 = row.cells[3].childNodes[0].value;
           var airline_name = row.cells[4].childNodes[0].value;  
           var plane_class = row.cells[5].childNodes[0].value;      
           var from_city_id1 = row.cells[6].childNodes[0].value;   
           var to_city_id1 = row.cells[7].childNodes[0].value;


           if(plane_from_location1=="")
           {
              error_msg_alert('Enter from sector in row'+(i+1));
              return false;
           }

           if(plane_to_location1=="")

          {

                error_msg_alert('Enter to sector in row'+(i+1));

                return false;

          }

           if(airline_name=="")
        { 
          error_msg_alert('Airline Name is required in row:'+(i+1)); 
          return false;
        }
           if(plane_class=="")
            { 
              error_msg_alert("Class is required in row:"+(i+1)); 
               return false;
          }


           if(row.cells[8] && row.cells[8].childNodes[0]){
            var plane_id = row.cells[8].childNodes[0].value;
           }
           else{
            var plane_id = "";
           }
              
           from_city_id_arr.push(from_city_id1);
           to_city_id_arr.push(to_city_id1);
           plane_from_location_arr.push(plane_from_location1);
           plane_to_location_arr.push(plane_to_location1);
           airline_name_arr.push(airline_name);
           plane_class_arr.push(plane_class);
           plane_id_arr.push(plane_id);

            }      

          }


    //Cruise Information
    var route_arr = new Array();
    var cabin_arr = new Array();
    var c_entry_id_arr = new Array();

    var table = document.getElementById("tbl_dynamic_cruise_update");
    var rowCount = table.rows.length;

      for(var i=0; i<rowCount; i++)
      {
        var row = table.rows[i];   
        if(row.cells[0].childNodes[0].checked)
        {   
           var route = row.cells[2].childNodes[0].value;    
           var cabin = row.cells[3].childNodes[0].value;          
           if(row.cells[4]){
            var entry_id = row.cells[4].childNodes[0].value;        
           }
           else{ 
            var entry_id = '';
           }
           if(route=="")
           {
              error_msg_alert('Enter route in row'+(i+1));
              return false;
           }        
           route_arr.push(route);
           cabin_arr.push(cabin);
           c_entry_id_arr.push(entry_id);

        }      
      }
          
    $('#btn_quotation_update').button('loading');
    var daywise_url =  $('#new_image_url').val() ;
    

    $.post( 

      base_url+"controller/group_tour/tours/tour_master_update.php",

      {  tour_id : tour_id,tour_type : tour_type, tour_name : tour_name, adult_cost : adult_cost, child_with_cost : child_with_cost, child_without_cost : child_without_cost, infant_cost : infant_cost, with_bed_cost : with_bed_cost, 'from_date[]' : from_date, 'to_date[]' : to_date, 'capacity[]' : capacity,tour_group_id : tour_group_id,visa_country_name : visa_country_name,company_name : company_name ,active_flag : active_flag,day_program_arr : day_program_arr, special_attaraction_arr : special_attaraction_arr,overnight_stay_arr : overnight_stay_arr,meal_plan_arr : meal_plan_arr, entry_id_arr : entry_id_arr,train_from_location_arr : train_from_location_arr, train_to_location_arr : train_to_location_arr, train_class_arr : train_class_arr,train_id_arr : train_id_arr, from_city_id_arr : from_city_id_arr, to_city_id_arr : to_city_id_arr, plane_from_location_arr : plane_from_location_arr, plane_to_location_arr : plane_to_location_arr,airline_name_arr : airline_name_arr , plane_class_arr : plane_class_arr,plane_id_arr : plane_id_arr, route_arr : route_arr, cabin_arr : cabin_arr,city_name_arr,hotel_name_arr,hotel_type_arr,total_days_arr,hotel_entry_id_arr, c_entry_id_arr : c_entry_id_arr, inclusions : inclusions, exclusions : exclusions, daywise_url:daywise_url  },

    function(data) {

      var msg = data.split('--');
      if(msg[0]=="error"){
          error_msg_alert(msg[1]);
          $('#btn_update').button('reset');
          return false;
      }

      else{
        $('#btn_update').button('reset');
        $('#vi_confirm_box').vi_confirm_box({
          false_btn: false,
          message: data,
          true_btn_text:'Ok',
          callback: function(data1){
            if(data1=="yes"){
              update_b2c_cache();
              window.location.href =  '../index.php';
            }
            }
        });
      }  

    });

}  



});
function hotel_name_list_load(id)
{

  var city_id = $("#"+id).val();

  var count = id.substring(9);

  $.get( "../../../view/custom_packages/master/package/hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name"+count).html( data ) ;                            
  } ) ;   

}
function hotel_type_load(id)

{

  var hotel_id = $("#"+id).val();

  var count = id.substring(10);

  $.get( "../../../view/custom_packages/master/package/hotel/hotel_type_load.php" , { hotel_id : hotel_id } , function ( data ) {

        $ ("#hotel_type"+count).val( data ) ;                            

  } ) ;

}
</script>