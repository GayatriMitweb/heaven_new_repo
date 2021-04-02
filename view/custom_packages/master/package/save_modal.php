<?php
$vehcile_id_str = "vehicle_name1";
?>
<form id="frm_package_master_save">

<div class="app_panel">  
 <!--=======Header panel======-->


<div class="container mg_tp_10">


 <div class="app_panel_content no-pad">

        <div class="panel panel-default panel-body main_block bg_light">
          <legend>Tour Information</legend>
          <div class="bg_white main_block panel-default-inner">
            <div class="col-xs-12 no-pad mg_bt_20 mg_tp_20">
              <div class="col-md-3 col-sm-3"> 
                <select id="dest_name_s"  name="dest_name_s" title="Select Destination" class="form-control"  style="width:100%"> 
                  <option value="">*Destination</option>
                  <?php 
                  $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
                  while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                      <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
                      <?php } ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                  <select name="tour_type" id="tour_type" title="Tour Type" onchange="incl_reflect(this.id,'')">
                      <option value="">Tour Type</option>
                      <option value="Domestic">Domestic</option>
                      <option value="International">International</option>
                  </select>
              </div>
              <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10">
                  <select name="currency_code" id="currency_code" title="Currency" style="width:100%" data-toggle="tooltip" required>
                      <option value=''>*Select Currency</option>
                      <?php
                      $sq_currency = mysql_query("select * from currency_name_master order by currency_code");
                      while($row_currency = mysql_fetch_assoc($sq_currency)){
                      ?>
                      <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div> 
            <div class="col-xs-12 no-pad mg_bt_20">        
                <div class="col-md-3 col-sm-3 mg_bt_10_xs"> 
                    <input type="text" id="package_name" name="package_name"  onchange="package_name_check(this.id);fname_validate(this.id); " class="form-control"  placeholder="*Package Name" title="Package Name" />
                    <small>Note : Package Name : eg. Kerala amazing</small>
                </div>      
                <div class="col-md-3 col-sm-3 mg_bt_10_xs"> 
                    <input type="text" id="package_code" name="package_code"  class="form-control" placeholder="Package Code" title="Package Code" />
                    <small>Note : Package Code : eg. Ker001</small>
                </div>     
                <div class="col-md-3 col-sm-3 mg_bt_10_xs"> 
                    <input type="number" id="total_nights" onchange="validate_balance(this.id); calculate_days()" name="total_nights" placeholder="*Nights" title="Total Nights">
                </div>      
                <div class="col-md-3 col-sm-3 mg_bt_10_xs"> 
                    <input type="number" id="total_days"  onchange=" validate_days('total_nights' , 'total_days');" name="total_days" class="form-control"  placeholder="*Days" title="Total Days" readonly />
                </div>     
                <div class="col-md-3 col-sm-3"> 
                    <select id="status"  name="status" title="Status" class="form-control hidden">
                      <option value="Active">Active</option>
                      <option value="Inactive">Inactive</option>
                    </select>
                </div>    
            </div>
            <div class="col-xs-12 no-pad mg_bt_20">
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="adult_cost" name="adult_cost" onchange="validate_balance(this.id);" class="form-control"  placeholder="Adult Cost" title="Adult Cost" />
                </div>   
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="child_cost" name="child_cost" onchange="validate_balance(this.id);" class="form-control"  placeholder="Child Cost" title="Child Cost" />
                </div>
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="infant_cost" name="infant_cost" onchange="validate_balance(this.id);" class="form-control"  placeholder="Infant Cost" title="Infant Cost" />
                </div>
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="child_with" name="child_with" onchange="validate_balance(this.id);" class="form-control"  placeholder="Child with Bed Cost" title="Child with Bed Cost" />
                </div>
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="child_without" name="child_without" onchange="validate_balance(this.id);" class="form-control"  placeholder="Child w/o Bed Cost" title="Child w/o Bed Cost" />
                </div>
                <div class="col-md-2 col-sm-3 mg_bt_10_xs">
                    <input type="text" id="extra_bed" name="extra_bed" onchange="validate_balance(this.id);" class="form-control"  placeholder="Extra Bed Cost" title="Extra Bed Cost" />
                </div>
            </div>
          </div>
        </div>


        <div class="row">
            <div class="col-md-12" id="div_list1">
            </div>    
        </div>


        <div class="panel panel-default panel-body main_block bg_light">
          <legend>Hotel Information</legend>
            <small class="note">Note -  Pls ensure you added city wise hotel & tariff using Supplier Master</small>
          <div class="bg_white main_block panel-default-inner">
            <div class="col-xs-12 text-right mg_tp_10">
              <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10" title="Add Hotel" onclick="hotel_save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Hotel</button>
              <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10" onClick="addRow('tbl_package_hotel_master');city_lzloading('select[name^=city_name1]')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
              <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10" onClick="deleteRow('tbl_package_hotel_master')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div> 
            <div class="col-xs-12"> 
              <div class="table-responsive">
                <table id="tbl_package_hotel_master" name="tbl_package_hotel_master" class="table table-hover pd_bt_51" style="border-bottom: 0 !important;">
                  <tr>
                      <td><input id="chk_dest1" type="checkbox" checked></td>
                      <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                      <td><select id="city_name" name="city_name1" onchange="hotel_name_list_load(this.id);" class="city_master_dropdown app_select2" style="width:100%" title="Select City Name">
                          </select></td>
                      <td><select id="hotel_name" name="hotel_name1" onchange="hotel_type_load(this.id);" style="width:100%" title="Select Hotel Name">
                            <option value="">*Hotel Name</option>
                          </select></td>
                      <td><input type="text" id="hotel_type" name="hotel_type1" placeholder="*Hotel Type" title="Hotel Type" readonly></td>
                      <td><input type="text" id="hotel_tota_days1" onchange="validate_balance(this.id)" name="hotel_tota_days1" placeholder="*Total Night" title="Total Night"></td></td>
                  </tr>
                </table>  
              </div>
            </div>
          </div>
        </div>
        <div class="row mg_bt_20">
        </div>
        <div class="panel panel-default panel-body main_block bg_light">
          <legend>Transport Information</legend>
          <div class="row mg_bt_20">
            <div class="col-xs-12 text-right mg_tp_10">
              <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10" title="Add Vehicle" onclick="vehicle_save_modal('<?php echo $vehcile_id_str; ?>')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Vehicle</button>
              <button type="button" class="btn btn-info btn-sm ico_left mg_bt_10" onClick="addRow('tbl_package_tour_transport');destinationLoading('select[name^=pickup_from]', 'Pickup Location');destinationLoading('select[name^=drop_to]', 'Drop-off Location');"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
              <button type="button" class="btn btn-danger btn-sm ico_left mg_bt_10" onClick="deleteRow('tbl_package_tour_transport')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div> 
              <div class="col-xs-12">
                <div class="table-responsive">
                <table id="tbl_package_tour_transport" name="tbl_package_tour_transport" class="table mg_bt_0 table-bordered mg_bt_10 pd_bt_51">             
                    <tbody>
                      <tr>
                          <td class="col-md-1"><input class="css-checkbox labelauty" id="chk_transport1" type="checkbox" checked="" autocomplete="off" data-original-title="" title="" aria-hidden="true" style="display: none;"><label for="chk_transport1"><span class="labelauty-unchecked-image"></span><span class="labelauty-checked-image"></span></label><label class="css-label" for="chk_transport1"> </label></td>
                          <td class="col-md-1"><input maxlength="15" value="1" type="text" name="username" placeholder="Sr No." class="form-control" disabled="" autocomplete="off" data-original-title="" title=""></td>
                          <td class="col-md-3"><select name="vehicle_name1" id="vehicle_name1" style="width:100%" class="form-control app_select2">
                          <option value="">Select Vehicle</option>
                          <?php
                          $sq_query = mysql_query("select * from b2b_transfer_master where status != 'Inactive'"); 
                          while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
                              <option value="<?php echo $row_dest['entry_id']; ?>"><?php echo $row_dest['vehicle_name']; ?></option>
                          <?php } ?></select></td>
                          <td class="col-md-3"><select name="pickup_from" id="pickup_from" data-toggle="tooltip" style="width:250px;" title="Pickup Location" class="form-control app_minselect2">
                          </select></td>
                          <td class="col-md-3"><select name="drop_to" id="drop_to" style="width:250px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_minselect2">
                          </select></td>
                      </tr>
                    </tbody>
                </table>
                </div>
              </div>
            </div>
        </div>
        <div class="row mg_bt_20">
            <div class="col-md-6 col-sm-6 mg_bt_10_sm_xs">
                <h3 class="editor_title">Inclusions</h3>
                <textarea class="feature_editor" id="inclusions" name="inclusions" placeholder="Inclusions" title="Inclusions" rows="4"></textarea>
            </div>
            <div class="col-md-6 col-sm-6"> 
                <h3 class="editor_title">Exclusions</h3>
                <textarea class="feature_editor" id="exclusions" name="exclusions" class="form-control"  placeholder="Exclusions" title="Exclusions" rows="4"></textarea>
            </div>
        </div>
      </div>
   </div>
    <div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_0">
    <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
    </div>
</div>
<div id="div_modal_content"></div>

</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>
$('#dest_name_s,#vehicle_name1,#currency_code').select2();
city_lzloading('select[name^="city_name1"]');
destinationLoading('select[name^="pickup_from"]', "Pickup Location");
destinationLoading('select[name^="drop_to"]', "Drop-off Location");
function generate_list(){

    var total_days = $("#total_days").val();
    $.post('generate_program_list.php', {total_days : total_days}, function(data){
        $('#div_list1').html(data);
    });
}

function calculate_days(){
   var total_nights = $("#total_nights").val();
   var days = parseInt(total_nights) + 1;
   $("#total_days").val(days);
   generate_list();
}

function package_name_check(package_name){
  var package_name1 = $('#'+package_name).val();

  $.post( "../package_name_check.php" , { package_name : package_name1 } , function ( data ) {
    if(data == 'This package name already exists.'){
      error_msg_alert(data);
      return false;
    }else{
      return true;
    }
  });
}

function table_info_validate(){

  g_validate_status = true; 
  var validate_message = "";

  //Special attraction table
  var table = document.getElementById("dynamic_table_list");
  var rowCount = table.rows.length;

  for(var i=0; i<rowCount; i++){

    var row = table.rows[i];
    validate_dynamic_empty_fields(row.cells[0].childNodes[0]);
    validate_dynamic_empty_fields(row.cells[1].childNodes[0]);
    validate_dynamic_empty_fields(row.cells[2].childNodes[0]);

    var flag1 = validate_spattration(row.cells[0].childNodes[0].id);
    var flag2 = validate_dayprogram(row.cells[1].childNodes[0].id);
    var flag3 = validate_onstay(row.cells[2].childNodes[0].id);
    if(!flag1 || !flag2 || !flag3){
        return false;
    }
  }
  var service_tax = $('#service_tax').val();
  if(service_tax === ''){
    error_msg_alert('Select Tax(%)!'); return false;
  }
  //Hotel info table
  var total_nights = $('#total_nights').val();
  var table = document.getElementById("tbl_package_hotel_master");
  var rowCount = table.rows.length;

  for(var i=0; i<rowCount; i++){

    var row = table.rows[i];       
    if(rowCount == 1){
      if(!row.cells[0].childNodes[0].checked){
        error_msg_alert("Atleast One Hotel is required!");
        g_validate_status = false; 
        return false;
      }
    }

    if(row.cells[0].childNodes[0].checked){

        validate_dynamic_empty_fields(row.cells[2].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[3].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[4].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[5].childNodes[0]);

        if(row.cells[2].childNodes[0].value==""){
              validate_message += "Enter City Name in row-"+(i+1)+"<br>";
        }
        if(row.cells[3].childNodes[0].value==""){
              validate_message += "Enter Hotel Name in row-"+(i+1)+"<br>";
        }
        if(row.cells[4].childNodes[0].value==""){
              validate_message += "Enter Hotel Type in row-"+(i+1)+"<br>";
        }
        if(row.cells[5].childNodes[0].value==""){
              validate_message += "Enter Total Nights in row-"+(i+1)+"<br>";
        }
      }
  }
  g_validate_status = true;

  //Transport info table
  var table = document.getElementById("tbl_package_tour_transport");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++){
    var row = table.rows[i];
    if(row.cells[0].childNodes[0].checked){

        validate_dynamic_empty_fields(row.cells[2].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[3].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[4].childNodes[0]);

        if(row.cells[2].childNodes[0].value==""){
            validate_message += "Enter Vehicle Name in row-"+(i+1)+"<br>";
        }
        if(row.cells[3].childNodes[0].value==""){
            validate_message += "Enter Vehicle pickup in row-"+(i+1)+"<br>";
        }
        if(row.cells[4].childNodes[0].value==""){
            validate_message += "Enter Vehicle drop in row-"+(i+1)+"<br>";
        }
    }
  }
  if(validate_message!=""){
      $('#site_alert').vialert({ 
          type:"error",
          message:validate_message,
          delay:10000,
      });
  }
  if(g_validate_status==false){ return false; }
}

function load_images(hotel_names){
    $.ajax({
      type:'post',
      url: 'get_hotel_img.php',
      data:{hotel_name : hotel_names },
      success:function(result){

        $('#images_list').html(result);
      }
  });
}

function delete_image(image_id,hotel_name){

    var base_url = $("#base_url").val();
    $.ajax({
          type:'post',
          url: base_url+'controller/custom_packages/delete_hotel_image.php',
          data:{ image_id : image_id },
          success:function(result){
            msg_alert(result);
            load_images(hotel_name);
          }
  });
}

/**Hotel Name load start**/

function hotel_name_list_load(id)
{

  var city_id = $("#"+id).val();

  var count = id.substring(9);

  $.get( "hotel/hotel_name_load.php" , { city_id : city_id } , function ( data ) {
        $ ("#hotel_name"+count).html( data ) ;                            
  } ) ;   

}

function hotel_type_load(id)

{

  var hotel_id = $("#"+id).val();

  var count = id.substring(10);

  $.get( "hotel/hotel_type_load.php" , { hotel_id : hotel_id } , function ( data ) {

        $ ("#hotel_type"+count).val( data ) ;                            

  } ) ;

}

$(function(){

$('#frm_package_master_save').validate({

  rules:{
        dest_name_s : { required: true },
        package_name : { required: true },
        total_days : { required: true, number:true },
        total_nights : { required: true, number:true },          
        day_program : {required : true },
    },

    submitHandler:function(form, event){
        event.preventDefault();
          var base_url = $('#base_url').val();

          var dest_id = $("#dest_name_s").val();

          var currency_id = $('#currency_code').val();
          var taxation_type = $('#taxation_type').val();
          var taxation_id = $('#taxation_id').val();
          var service_tax = $('#service_tax').val();

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

          var iframe = document.getElementById("inclusions-wysiwyg-iframe");
          var inclusions = iframe.contentWindow.document.body.innerHTML;
          var iframe1 = document.getElementById("exclusions-wysiwyg-iframe");
          var exclusions = iframe1.contentWindow.document.body.innerHTML;
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
          var total_night = 0;
          var city_name_arr = new Array();

          var hotel_name_arr = new Array();

          var hotel_type_arr = new Array();

          var total_days_arr = new Array();

          var table = document.getElementById("tbl_package_hotel_master");

          var rowCount = table.rows.length;

              for(var i=0; i<rowCount; i++){

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
                  total_night = parseFloat(total_night) + parseFloat(row.cells[5].childNodes[0].value);

                }

            }
            if(parseFloat(total_night) !== parseFloat(total_nights)){
                error_msg_alert("Invalid Total Hotel stay nights!");
                return false;
            }
            //Transport information
            var vehicle_name_arr = new Array();
            var drop_arr = new Array();
            var drop_type_arr = new Array();
            var pickup_arr = new Array();
            var pickup_type_arr = new Array();
            var pickup_type ='';
            var pickup_from ='';
            var drop_type ='';
            var drop_to ='';
            var table = document.getElementById("tbl_package_tour_transport");
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++){
              var row = table.rows[i];
              if(row.cells[0].childNodes[0].checked){  

                
                $('#'+row.cells[3].childNodes[0].id).find("option:selected").each(function(){
                  pickup_type = ($(this).closest('optgroup').attr('value'));
                  pickup_from = ($(this).closest('option').attr('value'));
                });
                $('#'+row.cells[4].childNodes[0].id).find("option:selected").each(function(){
                  drop_type = ($(this).closest('optgroup').attr('value'));
                  drop_to = ($(this).closest('option').attr('value'));
                });
                
                var vehicle_name = row.cells[2].childNodes[0].value;
                if(vehicle_name==""){
                    error_msg_alert('Transport Vehicle is mandatory in row'+(i+1));
                    return false;
                }
                if(pickup_type==""){
                    error_msg_alert('Transport pickup location is mandatory in row'+(i+1));
                    return false;
                }
                if(drop_type==""){
                    error_msg_alert('Transport drop location is mandatory in row'+(i+1));
                    return false;
                }

                vehicle_name_arr.push(vehicle_name);
                pickup_arr.push(pickup_from);
                pickup_type_arr.push(pickup_type);
                drop_arr.push(drop_to);
                drop_type_arr.push(drop_type);
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

                  { tour_type:tour_type,dest_id : dest_id,currency_id:currency_id, taxation_type :      
                    taxation_type, taxation_id:taxation_id,service_tax : service_tax, package_code : package_code, package_name : package_name, total_days : total_days1, total_nights : total_nights, status : status, city_name_arr : city_name_arr, hotel_name_arr : hotel_name_arr, hotel_type_arr : hotel_type_arr, total_days_arr : total_days_arr,vehicle_name_arr:vehicle_name_arr,drop_arr:drop_arr,drop_type_arr:drop_type_arr,pickup_arr:pickup_arr,pickup_type_arr:pickup_type_arr,child_cost : child_cost,adult_cost : adult_cost,infant_cost: infant_cost,child_with : child_with,child_without: child_without,extra_bed:extra_bed,inclusions : inclusions, exclusions : exclusions, day_program_arr : day_program_arr, special_attaraction_arr : special_attaraction_arr,overnight_stay_arr : overnight_stay_arr,meal_plan_arr : meal_plan_arr},

                  function(data) {
                    var msg = data.split('--');
                    if(msg[0]=="error"){
                        error_msg_alert(msg[1]);
                        $('#btn_save1').button('reset');
                        return false;
                    }
                    else{
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
function booking_save_message(data){
  var base_url = $("#base_url").val();
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
</script>

