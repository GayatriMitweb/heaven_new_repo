<?php
include "../../model/model.php";
$entry_id = $_POST['entry_id'];
$sq_exc = mysql_fetch_assoc(mysql_query("select timing_slots from excursion_master_tariff where entry_id='$entry_id'"));
$timing_slots = json_decode($sq_exc['timing_slots']);
?>
<form id="frm_b2b_exc_update">
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document" style="width:50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Timing Slots</h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="exc_entry_id" id="exc_entry_id" value='<?= $entry_id ?>'>	
		<div class="row mg_bt_10">
			<div class="col-md-12 text-right">
				<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('table_exc_time_slot')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
			</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table id="table_exc_time_slot" name="table_exc_time_slot" class="table table-bordered no-marg pd_bt_51">
				<?php if($timing_slots == 0 || sizeof($timing_slots) == 0){ ?>
					<tr>
						<td><input class="css-checkbox" id="chk_time" type="checkbox" checked><label class="css-label" for="chk_basic"> </label></td>
						<td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
						<td><input type="text" id="from_time" class="form-control" name="from_time" placeholder="From Time" title="From Time" value="" /></td>
						<td><input type="text" id="to_time" class="form-control" name="to_time" placeholder="To Time" title="To Time" value="" /></td>
					</tr>
				<?php }
				else{ ?>
					<?php for($i=0;$i<sizeof($timing_slots);$i++){ ?>
					<tr>
						<td><input class="css-checkbox" id="chk_time" type="checkbox" checked><label class="css-label" for="chk_basic"> </label></td>
						<td><input maxlength="15" value="<?= $timing_slots[$i]->sr_no ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
						<td><input type="text" id="from_time" class="form-control" name="from_time" placeholder="From Time" title="From Time" value="<?= $timing_slots[$i]->from_time ?>" /></td>
						<td><input type="text" id="to_time" class="form-control" name="to_time" placeholder="To Time" title="To Time" value="<?= $timing_slots[$i]->to_time ?>" /></td>
					</tr>
					<?php } 
				} ?>
				</table>
			</div>
		</div>
		</div>
		<div class="row mg_tp_20 text-center">
			<div class="col-md-12">
				<button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
</form>
<script>
$('#update_modal').modal('show');
$('#from_time,#to_time').datetimepicker({ datepicker:false, format:'H:i A',showMeridian: true });
$(function(){
	$('#frm_b2b_exc_update').validate({
		rules:{
		},
		submitHandler:function(form){
			var exc_entry_id= $('#exc_entry_id').val();

			var time_slot_array = [];
			var table = document.getElementById("table_exc_time_slot");
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++){
				var row = table.rows[i];           
				if(row.cells[0].childNodes[0].checked){
					var from_time = row.cells[2].childNodes[0].value;
					var to_time = row.cells[3].childNodes[0].value;
					if(from_time=='' && row.cells[0].childNodes[0].checked){
						error_msg_alert('Select Valid From Time in Row-'+(i+1));
						return false;
					}
					if(to_time=='' && row.cells[0].childNodes[0].checked){
						error_msg_alert('Select Valid To Time in Row-'+(i+1));
						return false;
					}
					time_slot_array.push({
						'sr_no':parseInt(i+1),
						'from_time':from_time,
						'to_time':to_time
					});
				}
			}

			$('#btn_update').button('loading');
			$.ajax({
				type:'post',
				url: base_url()+'controller/b2b_excursion/b2b_exc_timeslot.php',
				data:{ exc_entry_id:exc_entry_id,time_slot_array:JSON.stringify(time_slot_array)},
				success:function(result){
					var msg = result.split('--');
					if(msg[0] != 'error'){
						msg_alert(result);
						$('#update_modal').modal('hide');
						list_reflect();
					}
					else{
						error_msg_alert(msg[1]);
						$('#btn_update').button('reset');
						return false;
					}
				}
			});
		}
	});
});
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>