<?php
include "../../../model/model.php";
$tariff_id = $_POST['tariff_id'];
$sq_tariff = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_tariff where tariff_id='$tariff_id'"));
$taxation = json_decode($sq_tariff['taxation']);
?>
<form id="frm_tariff_update">
<div class="modal fade" id="tariff_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Tariff</h4>
      </div>
      <div class="modal-body">       
          <input type="hidden" id="tariff_id" value="<?= $tariff_id ?>"/>
          <div class="row mg_bt_20">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select id="vehicle_id" name="vehicle_id" style="width:100%" title="Select Vehcile" data-toggle="tooltip" required>
                    <?php
                      $sq_vehicle = mysql_fetch_assoc(mysql_query("select entry_id,vehicle_name from b2b_transfer_master where entry_id='$sq_tariff[vehicle_id]'"));
                    ?>
                      <option value="<?= $sq_vehicle['entry_id'] ?>"><?= $sq_vehicle['vehicle_name'] ?></option>
                      <option value="">*Select Vehicle</option>
                      <?php
                      $sq_query = mysql_query("select entry_id,vehicle_name from b2b_transfer_master order by vehicle_name");
                      while($row_tariffentries = mysql_fetch_assoc($sq_query)){
                      ?>
                       <option value="<?= $row_tariffentries['entry_id'] ?>"><?= $row_tariffentries['vehicle_name'] ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select name="currency_code" id="currency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
                      <?php
                      $sq_currencyq = mysql_fetch_assoc(mysql_query("select id,currency_code from currency_name_master where id='$sq_tariff[currency_id]'"));
                      ?>
                      <option value="<?= $sq_currencyq['id'] ?>"><?= $sq_currencyq['currency_code'] ?></option>
                      <option value=''>Select Currency</option>
                      <?php
                      $sq_currency = mysql_query("select * from currency_name_master order by currency_code");
                      while($row_currency = mysql_fetch_assoc($sq_currency)){
                      ?>
                      <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div class="row mg_bt_10">
            <legend class="mg_tp_20 main_block text-center">Seasonal Tariff</legend>
            <div class="col-md-12 text-right text_center_xs">
                <?php
                $sq_tariff_count = mysql_num_rows(mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$tariff_id'"));
                if($sq_tariff_count == 0){
                  include_once 'get_tariff_rows.php'; 
                }
                else{
                  ?>
                    <button type="button" class="btn btn-excel btn-sm" onclick="addRow('table_transfer_tarrif')" title="Add row"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="row mg_bt_10">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table_transfer_tarrif" name="table_transfer_tarrif" class="table table-bordered table-hover table-striped no-marg pd_bt_51" style="width:100%;">
                    <?php
                    $sq_tariffentries = mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$tariff_id'");
                    $count = 0;
                    while($row_tariffentries = mysql_fetch_assoc($sq_tariffentries)){
                      $count++;
                      $tariff_data = json_decode($row_tariffentries['tariff_data']);
                      ?>
                      <tr>
                          <td><input class="css-checkbox" id="chk_transfer<?= $count ?>-u" type="checkbox" checked><label class="css-label" for="chk_ticket"> </label></td>
                          <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
                          <td><select name="pickup_from" id="pickup_from<?= $count ?>-u" data-toggle="tooltip" style="width:150px;" title="Pickup Location" class="form-control app_minselect2">
                            <?php
                            // Pickup
                            if($row_tariffentries['pickup_type'] == 'city'){
                              $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_tariffentries[pickup_location]'"));
                              $html = '<optgroup value="city" label="City Name"><option value="'.$row['city_id'].'">'.$row['city_name'].'</option></optgroup>';
                            }
                            else if($row_tariffentries['pickup_type'] == 'hotel'){
                              $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_tariffentries[pickup_location]'"));
                              $html = '<optgroup value="hotel" label="Hotel Name"><option value="'.$row['hotel_id'].'">'.$row['hotel_name'].'</option></optgroup>';
                            }
                            else{
                              $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_tariffentries[pickup_location]'"));
                              $airport_nam = clean($row['airport_name']);
                              $airport_code = clean($row['airport_code']);
                              $pickup = $airport_nam." (".$airport_code.")";
                              $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                            }
                            echo $html;
                            ?>

                          <option value="">Pickup Location</option>
                          <optgroup value='city' label="City Name">
                          <?php get_cities_dropdown('1'); ?>
                          </optgroup>
                          <optgroup value='airport' label="Airport Name">
                          <?php get_airport_dropdown(); ?>
                          </optgroup>
                          <optgroup value='hotel' label="Hotel Name">
                          <?php get_hotel_dropdown(); ?>
                          </optgroup>
                          </select></td>
                          <td><select name="drop_to" id="drop_to<?= $count ?>-u" style="width:155px;" data-toggle="tooltip" title="Drop-off Location" class="form-control app_minselect2">
                            <?php
                            // Drop-off
                            if($row_tariffentries['drop_type'] == 'city'){
                              $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_tariffentries[drop_location]'"));
                              $html = '<optgroup value="city" label="City Name"><option value="'.$row['city_id'].'">'.$row['city_name'].'</option></optgroup>';
                            }
                            else if($row_tariffentries['drop_type'] == 'hotel'){
                              $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_tariffentries[drop_location]'"));
                              $html = '<optgroup value="hotel" label="Hotel Name"><option value="'.$row['hotel_id'].'">'.$row['hotel_name'].'</option></optgroup>';
                            }
                            else{
                              $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_tariffentries[drop_location]'"));
                              $airport_nam = clean($row['airport_name']);
                              $airport_code = clean($row['airport_code']);
                              $pickup = $airport_nam." (".$airport_code.")";
                              $html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
                            }
                            echo $html;
                            ?>
                          <option value="">Drop-off Location</option>
                          <optgroup value='city' label="City Name">
                          <?php get_cities_dropdown('1'); ?></optgroup>
                          <optgroup value='airport' label="Airport Name">
                          <?php get_airport_dropdown(); ?></optgroup>
                          <optgroup value='hotel' label="Hotel Name">
                          <?php get_hotel_dropdown(); ?></optgroup>
                          </select></td>    
                          <td><input type="text" id="duration<?= $count ?>-u" name="duration" placeholder="Service Duration" title="Service Duration" value="<?= $row_tariffentries['service_duration'] ?>" style="width: 128px;" /></td>      
                          <td><input type="text" id="from_date<?= $count ?>-u" class="form-control" name="from_date" placeholder="Valid From" title="Valid From" value="<?= get_date_user($row_tariffentries['from_date']) ?>"  onchange="get_to_date(this.id,'to_date<?= $count ?>-u')" style="width: 120px;" /></td>
                          <td><input type="text" id="to_date<?= $count ?>-u" class="form-control" name="to_date" placeholder="Valid To " title="Valid To" onchange="validate_issueDate('from_date<?= $count ?>-u' ,'to_date<?= $count ?>-u')" value="<?= get_date_user($row_tariffentries['to_date']) ?>" style="width: 120px;" /></td>
                          <td><input type="text" id="luggage<?= $count ?>-u" name="luggage" placeholder="Luggage Capacity" title="Luggage Capacity" style="width: 137px;" value="<?= $tariff_data[0]->seating_capacity ?>" /></td>
                          <td><input type="text" id="total_cost<?= $count ?>-u" name="total_cost" placeholder="Total Cost" title="Total Cost" onchange="validate_balance(this.id)" style="width: 120px;" value="<?= $tariff_data[0]->total_cost ?>"/></td>
                          <td><select name="markup_in" id="markup_in<?= $count ?>-u" style="width:130px;" title="Markup In" data-toggle="tooltip" class="form-control app_select2">
                              <option value="<?= $tariff_data[0]->markup_in ?>"><?= $tariff_data[0]->markup_in ?></option>
                              <option value="">Markup In</option>
                              <option value="Percentage">Percentage</option>
                              <option value="Flat">Flat</option>
                            </select></td>
                          <td><input type="text" id="markup_amount<?= $count ?>-u" name="markup_amount" placeholder="Markup Amount" title="Markup Amount" value="<?= $tariff_data[0]->markup_amount ?>" onchange="validate_balance(this.id)" style="width: 127px;" /></td>
                          <td><input type="hidden" id="entry_id" name="entry_id" value="<?= $row_tariffentries['tariff_entries_id'] ?>" /></td>
                      </tr>
                      <script>
                      $('#pickup_from<?= $count ?>-u,#drop_to<?= $count ?>-u').select2({minimumInputLength:1});
                      $('#to_date<?= $count ?>-u,#from_date<?= $count ?>-u').datetimepicker({ timepicker:false, format:'d-m-Y' });
                      </script>
                    <?php } ?>
                    </table>
                </div>
            </div>
            </div>

          <?php } ?>

          <div class="row text-center mg_tp_20"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="tariff_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>            
          </div> </div>
      </div>      
    </div>
  </div>
</div>
</form>

<script>
$('#tariff_update_modal').modal('show');
$('#vehicle_id,#currency_code1').select2();
//Airport Name dropdown
function seasonal_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/transfer_tariff_import.csv";
}
setTimeout(() => {
  if(!<?php echo $sq_tariff_count; ?>){
    transfer_tarrif_save();  
  }
}, 500);
function transfer_tarrif_save(){
	var btnUpload=$('#b2btariff_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: 'tariff/upload_tariff_csv.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         if(!confirm('Do you want to import this file?')){
            return false;
         }
         if (! (ext && /^(csv)$/.test(ext))){ 
            error_msg_alert('Only CSV files are allowed');
            return false;
         }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
        } else{
          document.getElementById("transfer_tarrif_upload").value = response;
          status.text('Uploading...');
          hotel_tarrif1();
          status.text('');
          
        }
      }
    });
}

function hotel_tarrif1(){
  var cust_csv_dir = document.getElementById("transfer_tarrif_upload").value;
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url+'controller/b2b_transfer/tariff_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir },
        success:function(result){
            var pass_arr = JSON.parse(result);
            if(pass_arr[0]['room_cat']!=''){
                var table = document.getElementById("table_transfer_tarrif");
                if(table.rows.length == 1){
                    for(var k=1; k<table.rows.length; k++){
                            document.getElementById("table_transfer_tarrif").deleteRow(k);
                    }
                }else{
                    while(table.rows.length > 1){
                            document.getElementById("table_transfer_tarrif").deleteRow(k);
                            table.rows.length--;
                    }
                }
                for(var i=0; i<pass_arr.length; i++){
                    var row = table.rows[i];

                    var pick_type = pass_arr[i]['pickup_type'][0].toUpperCase() + pass_arr[i]['pickup_type'].slice(1); 
                    var drop_type = pass_arr[i]['drop_type'][0].toUpperCase() + pass_arr[i]['drop_type'].slice(1); 

                    var pick_html =  '<optgroup value="'+pass_arr[i]['pickup_type']+'" label="'+pick_type+' Name">';
                    pick_html += '<option value="'+pass_arr[i]['pickup_id']+'">'+pass_arr[i]['pickup_location']+'</option></optgroup>';
                    var drop_html =  '<optgroup value="'+pass_arr[i]['drop_type']+'" label="'+drop_type+' Name">';
                    drop_html += '<option value="'+pass_arr[i]['drop_id']+'">'+pass_arr[i]['drop_location']+'</option></optgroup>';

                    $(row.cells[2].childNodes[0]).html(pick_html);
                    $(row.cells[3].childNodes[0]).html(drop_html);
                    row.cells[4].childNodes[0].value = pass_arr[i]['duration'];
                    row.cells[5].childNodes[0].value = pass_arr[i]['from_date'];
                    row.cells[6].childNodes[0].value = pass_arr[i]['to_date'];
                    row.cells[7].childNodes[0].value = pass_arr[i]['luggage'];
                    row.cells[8].childNodes[0].value = pass_arr[i]['total_cost'];			
                    row.cells[9].childNodes[0].value = pass_arr[i]['markup_in'];
                    row.cells[10].childNodes[0].value = pass_arr[i]['markup_amount'];

                    if(i!=pass_arr.length-1){
                        if(table.rows[i+1]==undefined){
                            addRow('table_transfer_tarrif','1');
                        }
                    }
                    $(row.cells[2].childNodes[0]).trigger('change');
                    $(row.cells[3].childNodes[0]).trigger('change');
                    $(row.cells[9].childNodes[0]).trigger('change');
                }
            }else{
                error_msg_alert('No Records in CSV!'); return false;
            }
        }
    });
}
$(function(){
  $('#frm_tariff_update').validate({
    rules:{
      service_tax : {required:true}
    },
    submitHandler:function(form){
      var base_url = $('#base_url').val();
      var tariff_id = $('#tariff_id').val();
      var vehicle_id = $('#vehicle_id').val();
      var currency_id = $('#currency_code1').val();
      var taxation_type = $('#taxation_type').val();
      var taxation_id = $('#taxation_id').val();
      var service_tax = $('#service_tax').val();
      if(service_tax == '0'){ error_msg_alert('Select Tax(%)'); return false;}
      var taxation = [{
        'taxation_type' : taxation_type,
        'taxation_id' : taxation_id,
        'service_tax' : service_tax
      }];
      var table = document.getElementById("table_transfer_tarrif");
      var rowCount = table.rows.length;
      var pickup_type = 0;
      var pickup_from = 0;
      var drop_type = 0;
      var drop_to = 0;
      var pickup_type_array = [];
      var pickup_from_array = [];
      var drop_type_array = [];
      var drop_to_array = [];
      var duration_array = [];
      var from_date_array = [];
      var to_date_array = [];
      var capacity_array = [];
      var total_cost_array = [];
      var markup_in_array = [];
      var markup_amount_array = [];
      var entry_id_array = [];
      var checked_id_array = [];
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        $('#'+row.cells[2].childNodes[0].id).find("option:selected").each(function(){
          pickup_type = ($(this).closest('optgroup').attr('value'));
          pickup_from = ($(this).closest('option').attr('value'));
        });
        $('#'+row.cells[3].childNodes[0].id).find("option:selected").each(function(){
          drop_type = ($(this).closest('optgroup').attr('value'));
          drop_to = ($(this).closest('option').attr('value'));
        });
        var duration = row.cells[4].childNodes[0].value;
        var from_date = row.cells[5].childNodes[0].value;
        var to_date = row.cells[6].childNodes[0].value;
        var capacity = row.cells[7].childNodes[0].value;
        var total_cost = row.cells[8].childNodes[0].value;
        var markup_in = row.cells[9].childNodes[0].value;
        var markup_amount = row.cells[10].childNodes[0].value;
        if(row.cells[11]){
          var entry_id = row.cells[11].childNodes[0].value;
        }
        else{
          var entry_id = '';
        }
        
        if(pickup_from=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Select Pickup location in Row-'+(i+1));
          return false;
        }
        if(drop_to=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Select Drop-off Location in Row-'+(i+1));
          return false;
        }
        if(duration=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Enter Service Duration in Row-'+(i+1));
          return false;
        }
        if(from_date=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Select Valid From Date in Row-'+(i+1));
          return false;
        }
        if(to_date=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Select Valid To Date in Row-'+(i+1));
          return false;
        }
        if(capacity=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Enter Luggage Capacity in Row-'+(i+1));
          return false;
        }
        if(total_cost=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Enter Total Cost in Row-'+(i+1));
          return false;
        }
        if(markup_in=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Enter Markup In in Row-'+(i+1));
          return false;
        }
        if(markup_amount=='' && row.cells[0].childNodes[0].checked){
          error_msg_alert('Enter Markup Amount in Row-'+(i+1));
          return false;
        }
        pickup_type_array.push(pickup_type);
        pickup_from_array.push(pickup_from);
        drop_type_array.push(drop_type);
        drop_to_array.push(drop_to);
        duration_array.push(duration);
        from_date_array.push(from_date);
        to_date_array.push(to_date);
        capacity_array.push(capacity);
        total_cost_array.push(parseFloat(total_cost).toFixed(2));
        markup_in_array.push(markup_in);
        markup_amount_array.push(parseFloat(markup_amount).toFixed(2));
        entry_id_array.push(entry_id);
        checked_id_array.push(row.cells[0].childNodes[0].checked);
      }
      $('#tariff_update').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/b2b_transfer/tariff_update.php',
        data: {tariff_id:tariff_id,vehicle_id:vehicle_id,currency_id:currency_id,taxation:JSON.stringify(taxation),
        pickup_type_array:pickup_type_array,pickup_from_array:pickup_from_array,drop_type_array:drop_type_array,drop_to_array:drop_to_array,duration_array:duration_array,from_date_array:from_date_array,to_date_array:to_date_array,capacity_array:capacity_array,total_cost_array:total_cost_array,markup_in_array:markup_in_array,markup_amount_array:markup_amount_array,entry_id_array:entry_id_array,checked_id_array:checked_id_array},
          success:function(result){
              var msg = result.split('--');
              if(msg[0]=='error'){
                  error_msg_alert(msg[1]);
                  $('#tariff_update').button('reset');
                  return false;
                }
              else{
                  msg_alert(result);
				          update_b2c_cache();
                  $('#tariff_save').button('reset');
                  $('#tariff_update_modal').modal('hide');
                  reset_form('frm_tariff_update');
                  tariff_list_reflect();
              }
          }
      });
      return false;
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>