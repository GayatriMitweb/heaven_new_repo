<?php
include "../../../../model/model.php";
$emp_id= $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role= $_SESSION['role'];
$role_id= $_SESSION['role_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='vendor/quotation_request/index.php'"));
$branch_status = $sq['branch_status'];
$sq_max = mysql_fetch_assoc(mysql_query("select max(request_id) as max from vendor_request_master"));
$request_id = $sq_max['max']+1;
$year = date('Y');
?>
<form id="frm_hotel_save"> 
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Request</h4>
      </div>
      <div class="modal-body">
		
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Basic Information</legend>
          <div class="row"> 
            <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
              <input type="text" value="<?= ge_vendor_request_id($request_id,$year) ?>" Readonly>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
              <select name="enquiry_id" id="enquiry_id" title="Select Enquiry" style="width:100%" onchange="get_enquiry_details()";>
                <option value="">*Select Enquiry</option>
                <?php
                  $query = "SELECT * FROM `enquiry_master` where enquiry_type='Package Booking'";
                  $query .=" and status!='Disabled'";
                  
                  if($role=='Admin'){
                      $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Package Booking') and status!='Disabled' order by enquiry_id desc");
                  }
                  if($branch_status=='yes'){
                    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
                      $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Package Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
                    }
                    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                      $q = "select * from enquiry_master where enquiry_type in('Package Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
                      $sq_enq = mysql_query($q);
                    }
                  }
                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                    $q = "select * from enquiry_master where enquiry_type in('Package Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
                    $sq_enq = mysql_query($q);
                  }
                  while($row_enq = mysql_fetch_assoc($sq_enq)){

                  $booking_date = $row_enq['enquiry_date'];
                  $yr = explode("-", $booking_date);
                  $year =$yr[0];
                  $query1="select enquiry_id from enquiry_master_entries where entry_id=(select (entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]' group by enquiry_id) and followup_status !='Dropped'";
                  $sq_enq_query=mysql_query($query1);
                  while($row_enq_query =mysql_fetch_assoc($sq_enq_query)){
                  ?>
                  <option value="<?= $row_enq_query['enquiry_id']; ?>"><?= get_enquiry_id($row_enq_query['enquiry_id'],$year).' : '.$row_enq['name']; ?></option>
                  <?php
                  }
                }
                ?>
              </select>
            </div>
            
            <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
              <select name="quotation_for" id="quotation_for" title="Quotation For" onchange="load_supplier();quotation_fields_load(); quotation_tbl_load();">
                <option value="">*Quotation For</option>
                <option value="DMC">DMC</option>
                <option value="Hotel">Hotel</option>
                <option value="Transport">Transport</option>              
              </select>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
              <select name="city_name" id="city_name" title="City Name" class="form-control" style="width:100%" multiple="true">
                    <?php //get_cities_dropdown(); ?>
                    <optgroup label="Select Option">
                      <option value="">Select Option</option>
                    </optgroup>
              </select>
            </div>    
            <div class="col-md-2 col-sm-6 col-xs-12 mg_bt_10_xs">
              <input type="text" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y') ?>">
            </div>    
          </div>
        </div>
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Travel Information</legend>    
        <div class="row">
            <div class="col-sm-2 col-xs-12 mg_bt_10_sm_xs">
              <input type="text" id="from_date" name="from_date" onchange="get_to_date(this.id,'to_date')" placeholder="*From Date" title="From Date" value="<?= $from_date ?>">
            </div>
            <div class="col-sm-2 col-xs-12 mg_bt_10_sm_xs">
              <input type="text" id="to_date" name="to_date" onchange="validate_issueDate('from_date','to_date')" placeholder="*To Date" title="To Date" value="<?= $to_date ?>">
            </div>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <select name="tour_type" id="tour_type" title="Tour Type">
                <option value="">*Tour Type</option>
                <option value="Domestic">Domestic</option>
                <option value="International">International</option>
              </select>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
              <select name="airport_pickup" id="airport_pickup" title="Airport Pickup">
                <option value="">Airport Pickup</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
              <input type="text" id="cab_type" name="cab_type" onchange="validate_city(this.id);" placeholder="Cab Type" title="Cab Type">
            </div>
            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
              <input type="text" id="transfer_type" onchange="validate_city(this.id);" name="transfer_type" placeholder="Transfer Type" title="Transfer Type">
            </div>
        </div>
      </div>
      <div class="row mg_bt_20"> 
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h3 class="editor_title">Enquiry Specification</h3>
          <textarea id="enquiry_specification" class="feature_editor" name="enquiry_specification" placeholder="Enquiry Specification" title="Enquiry Specification" rows="1"></textarea>
        </div>  
      </div>
      <div class="row"> 
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h3 class="editor_title">Excursion</h3>
          <textarea id="excursion_specification" class="feature_editor" name="excursion_specification" placeholder="Enquiry Specification" title="Excursion Specification" rows="1"></textarea>
        </div>  
      </div>
      <div id="div_dynamic_fields"></div>
      <div id="div_dynamic_tbl"></div>
    </div>  
			<div class="row mg_bt_20 text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>    
			</div>

    </div>
  </div>
  </div>
</div>
</form>
<script>
$('#save_modal').modal('show');
$(document).ready(function() {
$('#enquiry_id, #service_id1, #city_name').select2();
$('#quotation_date,#from_date,#to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
});
function load_supplier()
{
  var quotation_for = $('#quotation_for').val();
  $.post('request/inc/load_supplier.php', { quotation_for : quotation_for }, function(data){
    $('#city_name').html(data);
  });
}
///////////////////////***Hotel Master Save start*********//////////////
function get_enquiry_details(){
  var enquiry_id = $('#enquiry_id').val();
  var base_url = $('#base_url').val();
  var quotation_for = $('#quotation_for').val();

  $.ajax({
    type:'post',
    url: base_url+'view/vendor/quotation_request/request/inc/get_enquiry_details.php', 
    dataType: "json",
    data: { enquiry_id : enquiry_id }, 
    success: function(result){
      $('#from_date').val(result.travel_from_date);
      $('#to_date').val(result.travel_to_date);

      var $iframe = $('#enquiry_specification-wysiwyg-iframe');
      $iframe.ready(function() {
            $iframe.contents().find("body").append(result.enquiry_specification);
      });
      if(quotation_for == 'DMC'){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var date=dd + '-' + mm + '-' + yyyy;
        var table = document.getElementById("tbl_vendor_quotation_dmc_entries");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            var hotel_type = (typeof result.hotel_type === 'undefined') ? '' : result.hotel_type;
            var travel_from_date = (typeof result.travel_from_date === 'undefined') ? date : result.travel_from_date;
            var travel_to_date = (typeof result.travel_to_date === 'undefined') ? date : result.travel_to_date;

            row.cells[2].childNodes[0].value = hotel_type;
            row.cells[3].childNodes[0].value = travel_from_date;
            row.cells[4].childNodes[0].value = travel_to_date;
          }
        }
      }
    },
    error:function(result){
      console.log(result.responseText);
    }
  });
}
function quotation_fields_load(){
  var quotation_for = $('#quotation_for').val();
  var enquiry_id = $('#enquiry_id').val();

  $.post('request/inc/quotation_fields_load.php', { quotation_for : quotation_for, enquiry_id : enquiry_id }, function(data){
    $('#div_dynamic_fields').html(data);
  });
}
function quotation_tbl_load()
{  
  var request_id = ''; 
  var quotation_for = $('#quotation_for').val();
  var enquiry_id = $('#enquiry_id').val();
  var base_url = $('#base_url').val();
  $.post('request/inc/quotation_tbl_load.php', { request_id : request_id, quotation_for : quotation_for }, function(data){
    $('#div_dynamic_tbl').html(data);
    $.ajax({
    type:'post',
    url: base_url+'view/vendor/quotation_request/request/inc/get_enquiry_details.php', 
    dataType: "json",
    data: { enquiry_id : enquiry_id }, 
    success: function(result){
      //DMC
      if(quotation_for == 'DMC'){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var date=dd + '-' + mm + '-' + yyyy;
        var table = document.getElementById("tbl_vendor_quotation_dmc_entries");
        var rowCount = table.rows.length;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            var hotel_type = (typeof result.hotel_type === 'undefined') ? '' : result.hotel_type;
            var travel_from_date = (typeof result.travel_from_date === 'undefined') ? date : result.travel_from_date;
            var travel_to_date = (typeof result.travel_to_date === 'undefined') ? date : result.travel_to_date;

            row.cells[2].childNodes[0].value = hotel_type;
            row.cells[3].childNodes[0].value = travel_from_date;
            row.cells[4].childNodes[0].value = travel_to_date;
          }
        }
      }
    }
  });
  });
  
  
}

function vendor_dropdown_load(id){
  var vendor_type = $('#'+id).val();
  var offset = id.substring(11);
  $.post('vendor_dropdown_load.php', { vendor_type : vendor_type }, function(data){
    $('#vendor_id'+offset).html(data);
  });
}
 
$('#frm_hotel_save').validate({
rules:{     
        enquiry_id : { required : true },
        tour_type : { required : true },
        quotation_date : { required : true },
        vehicle_name : { required : true },
        vehicle_type : { required : true }, 
        quotation_for : { required : true },  
        city_name : { required : true },
        from_date : { required : true },
        to_date : { required : true },
    },
    submitHandler:function(form){

      var enquiry_id = $('#enquiry_id').val();
      var quotation_for = $('#quotation_for').val();
      var city_name = $('#city_name').val();
      var tour_type = $('#tour_type').val();
      var quotation_date = $('#quotation_date').val();
      var airport_pickup = $('#airport_pickup').val();
      var cab_type = $('#cab_type').val();
      var transfer_type = $('#transfer_type').val();
      var enquiry_specification = $('#enquiry_specification').val();
      var vehicle_name = $('#vehicle_name').val();
      var vehicle_type = $('#vehicle_type').val();
      var branch_admin_id = $('#branch_admin_id1').val();
      var excursion_specification = $('#excursion_specification').val();
      var dynamic_fields = $('#div_dynamic_fields').find('select, input, textarea').serializeArray();
      var dynamic_tbl = $('#div_dynamic_tbl').find('select, input, textarea').serializeArray();
      var city_id_arr = [];
      $('#city_name').find("option:selected").each(function(){
        city_id_arr.push($(this).closest('optgroup').attr('value'));
      });
      var emp_id = $('#emp_id').val();
      var err_msg = "";
      if(city_name == ''){
        err_msg += "*City name required!<br>";
      }
      if(quotation_for!="DMC"){
        for(arr1 in dynamic_fields){
          var row = dynamic_fields[arr1];
          var field = row['name'];
          var field_val = $('#'+field).val();
          if(field_val == ""){
              var placeholder = $('#'+field).attr('placeholder');
              err_msg += placeholder+" is required!<br>";
          }
        }
      }
      if(quotation_for=="DMC"){
        var table = document.getElementById("tbl_vendor_quotation_dmc_entries");
        var rowCount = table.rows.length; 
        for(var i=0; i<rowCount; i++)
        {    
            var row = table.rows[i];   
            if(rowCount == 1){
              if(!row.cells[0].childNodes[0].checked){
                error_msg_alert("Atleast one dmc is required!");
                return false;
              }
            }       
            if(row.cells[0].childNodes[0].checked)
            {
               var hotel_id = row.cells[2].childNodes[0].value;
               var check_in_date = row.cells[3].childNodes[0].value;
               var check_out_date = row.cells[4].childNodes[0].value;
               var total_rooms = row.cells[5].childNodes[0].value;
               var room_type = row.cells[6].childNodes[0].value;
               var meal_plan = row.cells[7].childNodes[0].value;
               if(hotel_id == ''){err_msg += "Hotel Type is required in row "+(i+1)+"<br>";}
               if(check_in_date == ''){err_msg += "Check In Date is required in row "+(i+1)+"<br>";}
               if(check_out_date == ''){err_msg += "Check Out Date is required in row "+(i+1)+"<br>";}
               if(total_rooms == ''){err_msg += "Total Rooms is required in row "+(i+1)+"<br>";}
               if(room_type == ''){err_msg += "Room Type is required "+(i+1)+"<br>";}
               if(meal_plan == ''){err_msg += "Meal Plan is required in row "+(i+1)+"<br>";}
            }
        }
      }
      if(err_msg != ''){
        error_msg_alert(err_msg); return false;
      }
      $('#btn_save').button('loading');

      $.ajax({
        type:'post',
        url: base_url()+'controller/vendor/quotation_request/quotation_request_save.php',
        data : { enquiry_id : enquiry_id, quotation_for : quotation_for,city_name : city_name,city_id_arr:city_id_arr, tour_type : tour_type, quotation_date : quotation_date, airport_pickup : airport_pickup, cab_type : cab_type, transfer_type : transfer_type, enquiry_specification : enquiry_specification, dynamic_fields : dynamic_fields, dynamic_tbl : dynamic_tbl, vehicle_name : vehicle_name ,vehicle_type : vehicle_type, branch_admin_id : branch_admin_id , emp_id : emp_id, excursion_specification : excursion_specification},
        success:function(result){
                $('#btn_save').button('reset');
                msg_alert(result);  
                $('#save_modal').modal('hide');
                
                list_reflect();
              }

        });
      }
});

///////////////////////***Hotel Master Save ens*********//////////////
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>