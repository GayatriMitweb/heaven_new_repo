<?php
include "../../model/model.php";
$booking_id = $_POST['booking_id'];
$hotel_flag = $_POST['hotel_flag'];
$activity_flag = $_POST['activity_flag'];
$booking_data = mysql_fetch_assoc(mysql_query("SELECT * from b2b_booking_master WHERE booking_id = '$booking_id'"));
$cart_checkout_data = json_decode($booking_data['cart_checkout_data']);
$hotel_count = 0;
?>
<form id="frm_save">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:40%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Voucher Details</h4>
      </div>
      <div class="modal-body">
      <?php if($hotel_flag) { ?>
	    <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
      <legend>Hotel Confirmation Number</legend>
<?php
      for($i=0;$i<sizeof($cart_checkout_data);$i++){
        if($cart_checkout_data[$i]->service->name == 'Hotel'){
          $hotel_uuid = $cart_checkout_data[$i]->service->uuid;
			
				  $confirmation_number_value = "";
				  if($booking_data['confirmation_no_details'] != ''){
					  $conf_json = json_decode($booking_data['confirmation_no_details']);
					  $confirmation_number_value = $conf_json->{$hotel_uuid};
          }
?>
        <div class="row mg_tp_20">
          <div class="col-md-4">
            <label for="conf_no<?= $hotel_count ?>"><?= $cart_checkout_data[$i]->service->hotel_arr->hotel_name ?></label>
          </div>
          <div class="col-md-8">
            <input id="conf_no<?= $hotel_count ?>" name="conf_no<?= $hotel_count ?>" placeholder="*Confirmation Number" title="Confirmation Number" type="text" value="<?= $confirmation_number_value ?>" required>
            <input type="hidden" id="hotel_id<?= $hotel_count ?>" value="<?= $hotel_uuid ?>">
          </div>
        </div>
                
<?php
        $hotel_count++;
       }
      }
?>
        <input type="hidden" id="nof_hotels" value="<?= $hotel_count ?>"> 
        </div>
<?php 
    } 
      $activity_count = 0;
      $timing_slots = explode(',',$booking_data['timing_slots']);
      if($activity_flag) {
?>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
          <legend>Activity Timing Slot</legend>
<?php
          for($i=0;$i<sizeof($cart_checkout_data);$i++){
            if($cart_checkout_data[$i]->service->name == 'Activity'){             
?>
          <div class="row mg_tp_20">
            <div class="col-md-4">
              <label for="exc_name<?= $activity_count ?>"><?= $cart_checkout_data[$i]->service->service_arr[0]->act_name ?></label>
            </div>
            <div class="col-md-8">
              <select name="tm_slot" id="tm_slot<?= $activity_count ?>">
                <option value="">Select Timing Slots</option>
<?php
      $timing_slots_exc = mysql_fetch_assoc(mysql_query("select * from  excursion_master_tariff where entry_id = ".$cart_checkout_data[$i]->service->service_arr[0]->id));
                        
      if($timing_slots_exc['timing_slots'] != ''){
        $json_values_timing = json_decode($timing_slots_exc['timing_slots']);
        foreach($json_values_timing as $values){
          if($timing_slots[$activity_count] != ''){
              $selected = ($values->from_time." To ".$values->to_time == $timing_slots[$activity_count]) ? "selected" : "";
          }
?>
        <option <?= $selected ?> ><?= $values->from_time." To ".$values->to_time ?></option>
<?php
       }  
     }
    else{
?>
        <option value="">No Timing Slots Found!!</option>
<?php 
    }
?>
      </select>
    </div>
  </div>

<?php 
         $activity_count++; 
      } 
    }
  }
?> 
        <input type="hidden" id="nof_activity" value="<?= $activity_count ?>"> 
        </div>
          <div class="row text-center mg_tp_20 mg_bt_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-print"></i>&nbsp;&nbsp;Generate Voucher</button>
              </div>
            </div>
      </div>      
      <input type="hidden" id="booking_id" value="<?= $booking_id ?>">
    </div>
  </div>
</div>
</form>
<script>
    $('#save_modal').modal('show');
    $(function(){

$('#frm_save').validate({
  submitHandler:function(form){
    var nof_hotels = $('#nof_hotels').val();
    var booking_id = $('#booking_id').val();
    var conf_numbers = {};
    for(var i=0;i<nof_hotels;i++){
        var hotel_id = $('#hotel_id'+i).val(),  conf_no = $('#conf_no'+i).val();
        if(typeof(conf_no) == 'undefined'){ msg_alert("error-NO"); return false;}
        conf_numbers[hotel_id] = conf_no;
    }


    var nof_activity = $('#nof_activity').val();
    var activity_times = [];
    for(var i=0;i<nof_activity;i++){
        var tm_slot = $('#tm_slot'+i).val();
        activity_times.push(tm_slot);
    }

    $('#btn_save').button('loading');
    $.ajax({
      type: 'POST',
      url: '<?= BASE_URL ?>controller/b2b_customer/sale/voucher_details_save.php',
      data:{ conf_numbers : conf_numbers, activity_times  : activity_times, booking_id : booking_id },
      success: function(){
          $('#btn_save').button('reset');
          loadOtherPage("<?= BASE_URL ?>model/app_settings/print_html/voucher_html/b2b_voucher.php?booking_id="+booking_id);
        }
      });
  }
});

});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>