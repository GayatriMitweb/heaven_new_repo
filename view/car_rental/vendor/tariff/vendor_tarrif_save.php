<?php
include "../../../../model/model.php";
?> 
<form id="frm_car_rental_vendor_save" class="no-marg">
<div class="modal fade" id="vendor_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Car Rental Tariff</h4>
        </div>
        <div class="modal-body">
        <div class="row mg_bt_10">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <select name="tour_type" id="tour_type" title="Tour Type" onchange="reflect_feilds(this.id)">
	            <option value="">Select Tour Type</option>
	            <option value="Local">Local</option>
	            <option value="outstation">OutStation</option>
	        </select>
            </div>
            <div class="col-md-4"></div>
        </div>
    
        <div id="vendor_tarrif"></div>
      
        <div class="row text-center mg_tp_20">
        <div class="col-md-12">
            <button id="btn_vendor_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
        </div>
             
    </div>
  </div>
</div>
</form>

<script>
$('#vendor_save_modal').modal('show');
$(document).ready(function() {
$("#state,#vehicle_name1").select2();
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

$('#cmb_city_id').select2({minimumInputLength: 1});
});
// function supplier_company_name(id){
//   var city_id = $("#"+id).val();
//   $.get( "tariff/supplier_name_reflect.php" , { city_id : city_id } , function ( data ) {
//         $ ("#vendor_name").html( data );
//   });
// }
function reflect_feilds(id){
    var tour_type = $('#'+id).val();
    $.post('tariff/tariff_feild_reflect.php', { tour_type : tour_type }, function(data){
		$('#vendor_tarrif').html(data);
	});
}
$(function(){
  $('#frm_car_rental_vendor_save').validate({
      rules:{
        tour_type: {required: true },

      },
      submitHandler:function(form){
             
        var tour_type = $('#tour_type').val();            
       
        if(tour_type=='Local')
        {
            var vehicle_name_local_arr = new Array();
            var seating_capacity_local_arr = new Array();
            var total_hrs_arr = new Array();
            var total_km_arr = new Array();
            var extra_hrs_rate_local_arr = new Array();
            var extra_km_rate_local_arr = new Array();
            var rate_local_arr = new Array();
            
            var count = 0;
            var table = document.getElementById("tbl_dynamic_car_rental_vehicle_local");
            var rowCount = table.rows.length;
            for(var i=0; i<rowCount; i++)
            {
                var row = table.rows[i];
                if(row.cells[0].childNodes[0].checked == true)
                {
                    count++;
                    var vehicle_name = row.cells[2].childNodes[0].value;
                    var capacity = row.cells[3].childNodes[0].value;
                    var hrs = row.cells[4].childNodes[0].value;
                    var kms = row.cells[5].childNodes[0].value;
                    var extra_hr_rate = row.cells[6].childNodes[0].value;
                    var extra_km_rate = row.cells[7].childNodes[0].value;
                    var rate = row.cells[8].childNodes[0].value;
                   
                    // var msg = "";
                    // if(vehicle_name==""){ msg +="> Enter vehicle name in row "+(i+1)+"<br>"; }
                    // if(vehicle_type==""){ msg +="> Enter vehicle type  in row "+(i+1)+"<br>"; }
                    // if(msg!=""){ error_msg_alert(msg); return false; }
                    vehicle_name_local_arr.push(vehicle_name);
                    seating_capacity_local_arr.push(capacity);
                    total_hrs_arr.push(hrs);
                    total_km_arr.push(kms);
                    extra_hrs_rate_local_arr.push(extra_hr_rate);
                    extra_km_rate_local_arr.push(extra_km_rate);
                    rate_local_arr.push(rate);
                   
                }
            }
         }else{
            
                var vehicle_name_arr = new Array();
                var seating_capacity_arr = new Array();
                var route_arr = new Array();
                var total_days_arr = new Array();
                var total_max_km_arr = new Array();
                var rate_arr = new Array();
                var extra_hrs_rate_arr = new Array();
                var extra_km_rate_arr = new Array();
                var driver_allowance_arr = new Array();
                var permit_charges_arr = new Array();
                var toll_parking_arr = new Array();
                var state_entry_pass_arr = new Array();
                var other_charges_arr = new Array();
               
                var count = 0;
                var table = document.getElementById("tbl_dynamic_car_rental_vehicle_out");
                var rowCount = table.rows.length;
               
                for(var i=0; i<rowCount; i++)
                {
                    var row = table.rows[i];
                   
                    if(row.cells[0].childNodes[0].checked == true)
                    {
                    count++;
                    var vehicle_name = row.cells[2].childNodes[0].value;
                    var capacity = row.cells[3].childNodes[0].value;
                    var route = row.cells[4].childNodes[0].value;
                    var total_days = row.cells[5].childNodes[0].value;
                    var max_km = row.cells[6].childNodes[0].value;
                    var rate = row.cells[7].childNodes[0].value;
                    var extra_hrs = row.cells[8].childNodes[0].value;
                    var extra_km = row.cells[9].childNodes[0].value;
                    var driver_allowance = row.cells[10].childNodes[0].value;
                    var permit = row.cells[11].childNodes[0].value;
                    var toll_parking = row.cells[12].childNodes[0].value;
                    var state_entry = row.cells[13].childNodes[0].value;
                    var other_charge = row.cells[14].childNodes[0].value;
                    
                    // var msg = "";
                    // if(vehicle_name==""){ msg +="> Enter vehicle name in row "+(i+1)+"<br>"; }
                    // if(vehicle_type==""){ msg +="> Enter vehicle type  in row "+(i+1)+"<br>"; }

                    // if(msg!=""){ error_msg_alert(msg); return false; }
                    
                    vehicle_name_arr.push(vehicle_name);
                    seating_capacity_arr.push(capacity);
                    route_arr.push(route);
                    total_days_arr.push(total_days);
                    total_max_km_arr.push(max_km);
                    rate_arr.push(rate);
                    extra_hrs_rate_arr.push(extra_hrs);
                    extra_km_rate_arr.push(extra_km);
                    driver_allowance_arr.push(driver_allowance);
                    permit_charges_arr.push(permit);
                    toll_parking_arr.push(toll_parking);
                    state_entry_pass_arr.push(state_entry);
                    other_charges_arr.push(other_charge);
                    
                    }
                }
            }
              

            if(count==0){
            error_msg_alert("Enter at least one vehicle details.");
            return false;
            }

              var base_url = $('#base_url').val();
            $('#btn_vendor_save').button('loading');
             
              $.ajax({
                type:'post',
                url: base_url+'controller/car_rental/vendor/tariff_save.php',
                data:{tour_type:tour_type,vehicle_name_arr:vehicle_name_arr,seating_capacity_arr:seating_capacity_arr,route_arr:route_arr,total_days_arr:total_days_arr,total_max_km_arr:total_max_km_arr,rate_arr:rate_arr, extra_hrs_rate_arr:extra_hrs_rate_arr,extra_km_rate_arr:extra_km_rate_arr,driver_allowance_arr:driver_allowance_arr,permit_charges_arr:permit_charges_arr,toll_parking_arr:toll_parking_arr,state_entry_pass_arr:state_entry_pass_arr,other_charges_arr:other_charges_arr,vehicle_name_local_arr:vehicle_name_local_arr,seating_capacity_local_arr:seating_capacity_local_arr,total_hrs_arr:total_hrs_arr,total_km_arr:total_km_arr,extra_hrs_rate_local_arr:extra_hrs_rate_local_arr,extra_km_rate_local_arr:extra_km_rate_local_arr,rate_local_arr:rate_local_arr},
                success:function(result){
                  msg_alert(result);
                  $('#vendor_save_modal').modal('hide');
                  tarrif_list_reflect();
                  reset_form('frm_car_rental_vendor_save');
                  $('#btn_vendor_save').button('reset');
                },
                error:function(result){
                  console.log(result.responseText);
                }
              });

      }

  });

});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>