<?php
include "../../../model/model.php";
?>
<form id="frm_tariff_save">
<div class="modal fade" id="tariff_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="width:85%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tariff</h4>
      </div>
      <div class="modal-body">       
          
          <div class="row mg_bt_20">
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select id="vehicle_id" name="vehicle_id" style="width:100%" title="Select Vehcile" data-toggle="tooltip" required>
                      <option value="">*Select Vehicle</option>
                      <?php
                      $sq_query = mysql_query("select entry_id,vehicle_name from b2b_transfer_master order by vehicle_name");
                      while($row_query = mysql_fetch_assoc($sq_query)){
                      ?>
                      <option value="<?= $row_query['entry_id'] ?>"><?= $row_query['vehicle_name'] ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <select name="currency_code" id="currency_code1" title="Currency" style="width:100%" data-toggle="tooltip" required>
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
            <?php include_once 'get_tariff_rows.php'; ?>

          <div class="row text-center mg_tp_20"> <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="tariff_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
          </div> </div>
      </div>      
    </div>
  </div>
</div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#tariff_save_modal').modal('show');
$('#vehicle_id,#currency_code1').select2();
//Airport Name dropdown
function seasonal_csv(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/transfer_tariff_import.csv";
}
transfer_tarrif_save();
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
  $('#frm_tariff_save').validate({
    rules:{
      service_tax : {required:true}
    },
    submitHandler:function(form){
      var base_url = $('#base_url').val();
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
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];        
        if(row.cells[0].childNodes[0].checked){
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
         
          if(pickup_from==''){
            error_msg_alert('Select Pickup location in Row-'+(i+1));
            return false;
          }
          if(drop_to==''){
            error_msg_alert('Select Drop-off Location in Row-'+(i+1));
            return false;
          }
          if(duration==''){
            error_msg_alert('Enter Service Duration in Row-'+(i+1));
            return false;
          }
          if(from_date==''){
            error_msg_alert('Select Valid From Date in Row-'+(i+1));
            return false;
          }
          if(to_date==''){
            error_msg_alert('Select Valid To Date in Row-'+(i+1));
            return false;
          }
          if(capacity==''){
            error_msg_alert('Enter Luggage Capacity in Row-'+(i+1));
            return false;
          }
          if(total_cost==''){
            error_msg_alert('Enter Total Cost in Row-'+(i+1));
            return false;
          }
          if(markup_in==''){
            error_msg_alert('Enter Markup In in Row-'+(i+1));
            return false;
          }
          if(markup_amount==''){
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
          markup_amount_array.push(markup_amount);
        }
      }
      $('#tariff_save').button('loading');
      $.ajax({
        type:'post',
        url: base_url+'controller/b2b_transfer/tariff_save.php',
        data: {vehicle_id:vehicle_id,currency_id:currency_id,taxation:JSON.stringify(taxation),
        pickup_type_array:pickup_type_array,pickup_from_array:pickup_from_array,drop_type_array:drop_type_array,drop_to_array:drop_to_array,duration_array:duration_array,from_date_array:from_date_array,to_date_array:to_date_array,capacity_array:capacity_array,total_cost_array:total_cost_array,markup_in_array:markup_in_array,markup_amount_array:markup_amount_array},
          success:function(result){
              var msg = result.split('--');
              if(msg[0]=='error'){
                  error_msg_alert(msg[1]);
                  $('#tariff_save').button('reset');
                  return false;
                }
              else{
                  msg_alert(result);
				          update_b2c_cache();
                  $('#tariff_save').button('reset');
                  $('#tariff_save_modal').modal('hide');
                  reset_form('frm_tariff_save');
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