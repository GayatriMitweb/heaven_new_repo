<?php
include "../../../../../model/model.php";

$quotation_for = $_POST['quotation_for'];
$meal_plan = mysql_query("Select * from meal_plan_master");
if(isset($_POST['request_id'])){
	$request_id = $_POST['request_id'];
	$sq_req = mysql_fetch_assoc(mysql_query("select * from vendor_request_master where request_id = '$request_id'"));

	$hotel_entries = $sq_req['hotel_entries'];
	$hotel_entries_arr = json_decode($hotel_entries, true);

	$dmc_entries = $sq_req['dmc_entries'];
	$dmc_entries_arr = json_decode($dmc_entries, true);

	$transport_entries = $sq_req['transport_entries'];
	$transport_entries_arr = json_decode($transport_entries, true);
}
else{
	$request_id = '';
	$hotel_entries_arr = array();
	$dmc_entries_arr = array();
	$transport_entries_arr = array();
}
?>
<hr><?php
if($quotation_for=="DMC"){
	?>
	<div class="panel panel-default panel-body app_panel_style feildset-panel">
            <legend>Hotel Details</legend>
	<div class="row mg_bt_20">
		<div class="col-md-12 text-right">
			<button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_vendor_quotation_dmc_entries',1)"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
			<?php if($request_id==""){ ?>
            <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_vendor_quotation_dmc_entries')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            <?php } ?>
		</div>
	</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		
		<table class="table" id="tbl_vendor_quotation_dmc_entries">
			
			<?php 
			if($request_id=="" || sizeof($dmc_entries)==0){
				?>
				<tr style="height: 60px">
					<td style="width:2px"><input type="checkbox" id="chk_dmc" checked></td>
					<td style="width:5%"><input type="text" placeholder="Sr. No" value="1" disabled></td>
					<td><input type="text" id="dmc_id" name="dmc_id" placeholder="Hotel Type" title="Hotel Type"></td>
					<td><input type="text" id="checkin_date" name="checkin_date" onchange="get_to_date(this.id,'checkout_date');validate_validDate('checkin_date' , 'checkout_date')" placeholder="Travel Start Date" title="Travel Start Date" class="app_datepicker"  value="<?= date('d-m-Y') ?>"></td>
					<td><input type="text" id="checkout_date" onchange="validate_issueDate('checkin_date' , 'checkout_date')"  name="checkout_date" placeholder="Travel End Date" title="Travel End Date" class="app_datepicker"  value="<?= date('d-m-Y') ?>"></td>

					<td><input type="text" id="total_rooms" style="width:100px;" onchange="validate_balance(this.id)"  name="total_rooms" placeholder="Total Rooms" title="Total Rooms"></td>
					<td><select name="room_cat1" id="room_cat1" style="width:145px;" title="Room Category" class="form-control app_select2"><?php get_room_category_dropdown(); ?></select></td>
					<td><select name="meal_plan" id="meal_plan" title="Meal Plan" placeholder="Meal Plan" placeholder="Meal Plan">
						<option value="">Meal Plan</option>
						<?php 
						while($row = mysql_fetch_assoc($meal_plan)){?>
							<option value="<?= $row[meal_plan]?>"><?= $row[meal_plan]?></option>
						<?php
						}
						?>
					</select></td>
				</tr>
				<?php
			}	
			else{
				$count = 0;
				foreach(array_chunk($dmc_entries_arr, 6) as $dmc_entries){
					$count++;					
				
					$arr = array();
					foreach($dmc_entries as $dmc_entries1){
						$arr[$dmc_entries1['name']] = $dmc_entries1['value'];
					}
				

					?>
					<tr style="height: 60px">
						<td  style="width:2px"><input type="checkbox" id="chk_hotel<?= $count ?>_u" checked disabled></td>
						<td  style="width:5%"><input type="text" placeholder="Sr. No" value="<?= $count ?>" disabled></td>
						<td><input type="text" id="dmc_id<?= $count ?>_u" name="dmc_id" placeholder="Hotel" title="Hotel" value="<?= $hotel_name1 ?>"></td>
						<td><input type="text" id="checkin_date<?= $count ?>_u" onchange="get_to_date(this.id,'checkout_date<?= $count ?>_u');validate_validDate('checkin_date<?= $count ?>_u' , 'checkout_date<?= $count ?>_u')"  name="checkin_date" placeholder="Check-In Date" title="Check-In Date" class="app_datepicker" value="<?= $arr['checkin_date'] ?>"></td>
						<td><input type="text" id="checkout_date<?= $count ?>_u" onchange="validate_issueDate('checkin_date<?= $count ?>_u' , 'checkout_date<?= $count ?>_u')" name="checkout_date" placeholder="Check-Out Date" title="Check-Out Date" class="app_datepicker" value="<?= $arr['checkout_date'] ?>"></td>
						<td><input type="text" id="total_rooms<?= $count ?>_u" style="width:100px;" onchange="validate_balance(this.id)"  name="total_rooms" placeholder="Total Rooms" title="Total Rooms" value="<?= $arr['total_rooms']?>"></td>
						<td><select name="room_cat1" id="room_cat1<?= $count ?>_u" style="width:145px;" title="Room Category" class="form-control app_select2"></select></td>
						<?php
							if($arr['room_cat1']!=''){
						?>
						<option value="<?= $arr['room_cat1'] ?>"><?= $arr['room_cat1'] ?></option>
						<?php		
						get_room_category_dropdown();	
						}
						else{
							get_room_category_dropdown();	
						 } ?>
						<td><select name="meal_plan" id="meal_plan<?= $count ?>_u" title="Meal Plan" placeholder="Meal Plan">
							<?php if($arr['meal_plan']!=''){ ?>
								<option value="<?= $arr['meal_plan'] ?>"><?= $arr['meal_plan'] ?></option>
								<?php 
								while($row = mysql_fetch_assoc($meal_plan)){?>
								<option value="<?= $row[meal_plan]?>"><?= $row[meal_plan]?></option>
							<?php
							}
							?>
					        <?php }else{ ?>
								<option value="">Meal Plan</option>
								<?php 
								while($row = mysql_fetch_assoc($meal_plan)){?>
								<option value="<?= $row[meal_plan]?>"><?= $row[meal_plan]?></option>
								<?php
								}
								?>
					        <?php } ?>
						</select></td>
					</tr>
					<script>
						$('#checkin_date<?= $count ?>_u, #checkout_date<?= $count ?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
					</script>
					<?php
				}

			}
			?>

			</table>

	</div> </div> </div>
	<script>
		$('#checkin_date, #checkout_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	</script>
	<?php
}
?>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
