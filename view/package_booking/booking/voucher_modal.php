<?php
include "../../../model/model.php";
$booking_id = $_GET['booking_id'];
$count = 0;
$sq_count = mysql_num_rows( mysql_query("select * from package_tour_transport_service_voucher where booking_id='$booking_id'") );
$sq = mysql_fetch_assoc( mysql_query("select * from package_tour_transport_service_voucher where booking_id='$booking_id'") );
$sq_transport = mysql_fetch_assoc( mysql_query("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'") );

if($sq_count == 0){
	$sq_entry_n = mysql_query("select * from package_tour_transport_master where booking_id='$booking_id'");
}
else{
	$sq_entry_n = mysql_query("select * from package_tour_transport_voucher_entries where booking_id='$booking_id'");
}

$confirm_date =  (strtotime($sq['confirm_date'])>0) ? date('d-m-Y', strtotime($sq['confirm_date'])) : date('d-m-Y');
?>
<form id="frm_service_voucher">
<div class="modal fade" id="voucher_modal1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Voucher Details</h4>
      </div>
      <div class="modal-body">
	  <div class="panel panel-default panel-body">
	  <input type="hidden" id="cmb_booking_id" value='<?= $booking_id  ?>'>
	<?php
	while($row_entry1 = mysql_fetch_assoc($sq_entry_n)){
		$count++; ?>
					<div class="row">
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<select id="vehicle_name<?= $count?>" title="Vehicle Name" name="vehicle_name">
								<?php
								$q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_entry1[transport_bus_id]'"));
								?>
								<option value="<?=$q_transport['entry_id']?>"><?=$q_transport['vehicle_name']?></option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="text" id="driver_name<?= $count?>" name="driver_name" placeholder="Driver Name"  onchange="validate_city(this.id)"  title="Driver Name" value="<?= $row_entry1['driver_name'] ?>">
						</div>
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="text" id="driver_contact<?= $count?>" name="driver_contact" placeholder="Driver Contact"  onchange="mobile_validate(this.id)"  title="Driver Contact" value="<?= $row_entry1['driver_contact'] ?>">
						</div>
						<div class="col-md-4 col-sm-6 mg_bt_10">
							<input type="text" id="confirm_by<?= $count?>" name="confirm_by<?= $count?>"  onchange="validate_city(this.id)"  placeholder="Confirmed by" title="Confirmed by" value="<?= $row_entry1['confirm_by'] ?>" />
						</div>
					</div>
		<?php } ?>
		<input type="hidden" id="count" value="<?= $count?>"/>
		<div class="row">
			<div class="col-md-6 col-sm-6 mg_bt_10">
				<textarea id="special_arrangments" name="special_arrangments" onchange="validate_address(this.id)" placeholder="Special Arrangements" title="Special Arrangements"><?= $sq['special_arrangments'] ?></textarea>
			</div>
			<div class="col-md-6 col-sm-6 mg_bt_10">
				<textarea id="inclusions" name="inclusions" placeholder="Inclusions" onchange="validate_address(this.id)" title="Inclusions"><?= $sq['inclusions'] ?></textarea>
			</div>
		</div>
		<div class="row text-center mg_tp_20">
			<div class="col-md-12">
				<button class="btn btn-sm btn-info ico_left" title="Print"><i class="fa fa-print"></i>&nbsp;&nbsp;Voucher</button>
			</div>
		</div>
	</div>


    </div>      

    </div>

</div>

</div>



</form>



<script>
$('#city_id').select2({minimumInputLength: 1});
$('#voucher_modal1').modal('show');

$('#confirm_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$(function(){
		$('#frm_service_voucher').validate({
			rules:{
			},
			submitHandler:function(form, event){
					event.preventDefault();
					var base_url = $('#base_url').val();
					var count = $('#count').val();
					var booking_id = $('#cmb_booking_id').val();
					var vehicle_name_array = [];
					var pick_array = [];
					var driver_contact_array = [];
					var driver_name_array = [];
					var confirm_by_array = [];

					for(var i=1;i<=count;i++){
						var vehicle_name = $('#vehicle_name'+i).val();
						var pick_up_from = $('#pick_up_from'+i).val();
						var drop_to = $('#drop_to'+i).val();
						var driver_name = $('#driver_name'+i).val();
						var driver_contact = $('#driver_contact'+i).val();
						var confirm_by = $('#confirm_by'+i).val();
						if(vehicle_name == ''){
							error_msg_alert("Select Vehicle in row "+i); return false;
						}
						if(pick_up_from == ''){
							error_msg_alert("Enter Pick From in row "+i); return false;
						}
						if(vehicle_name == ''){
							error_msg_alert("Enter Drop To in row "+i); return false;
						}
						vehicle_name_array.push(vehicle_name);
						driver_name_array.push(driver_name);
						driver_contact_array.push(driver_contact);
						confirm_by_array.push(confirm_by);
					}
					var special_arrangments = $('#special_arrangments').val();
					var inclusions = $('#inclusions').val();
					var flag1 = validate_address('special_arrangments');
					var flag2 = validate_address('inclusions');
					if(!flag1 || !flag2){
						return false;
					}
					$.ajax({
						type:'post',
						url:base_url+'controller/package_tour/service_voucher/transport_service_voucher_save.php',
						data:{ booking_id : booking_id,vehicle_name_array:vehicle_name_array,driver_name_array : driver_name_array,driver_contact_array : driver_contact_array, special_arrangments : special_arrangments, inclusions : inclusions,confirm_by_array:confirm_by_array  },
						success: function(message){
						
							var msg = message.split('--');
							if(msg[0]=="error"){
								error_msg_alert(msg[1]);
								return false;
							}
							else
							{
								$('#vi_confirm_box').vi_confirm_box({
								false_btn: false,
								message: 'Information Saved Successfully',
								true_btn_text:'Ok',
								callback: function(data1){
										if(data1=="yes"){
											var url1 = base_url+'model/app_settings/print_html/voucher_html/fit_voucher.php?booking_id='+booking_id;
											loadOtherPage(url1);
										}
									}
								});
							}
						}
					});
			}
		});
	});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>