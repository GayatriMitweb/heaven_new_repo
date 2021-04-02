<?php include "../../model/model.php"; ?>
<?php 
$bus_id = $_POST['bus_id'];
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];
$sq_bus_det = mysql_fetch_assoc(mysql_query("select * from bus_master where bus_id='$bus_id'"));
?>
<div class="col-md-6">

	<input type="hidden" id="txt_bus_capacity" name="txt_bus_capacity" value="<?php echo $sq_bus_det['capacity'] ?>">

	<div class="panel panel-default panel-body pad_8 mg_bt_-1 text-right">
		<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="bus_seating_arrangment_pdf()"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
	</div>

	<div class="row"> <div class="col-md-12"> <div class="table-responsive" style="height:400px">
	<table cellspacing="0" cellpadding="0" class="table table-bordered table-hover mg_bt_-1">
		<thead>
			<tr class="table-heading12">
				<td>Sr. No.</td>
				<td>Traveler Name</td>
				<td>Bus Seat Number</td>
			</tr>	
		</thead>
		<tbody>
	<?php

	$count = 0;

	$sq_traveler_det = mysql_query("select * from travelers_details where status!='Cancel' and traveler_group_id in (select traveler_group_id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id')");
	while($row_traveler_det = mysql_fetch_assoc($sq_traveler_det))
	{
		$sq_seat_booking_det = mysql_fetch_assoc(mysql_query("select seat_no from bus_seat_arrangment_master where tour_id='$tour_id' and tour_group_id='$tour_group_id' and bus_id='$bus_id' and traveler_id='$row_traveler_det[traveler_id]' "));

		$count++;
	?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><select id="cmb_traveler_id<?php echo $count ?>" class="form-control" disabled>
				<option value="<?php echo $row_traveler_det['traveler_id'] ?>"><?php echo $row_traveler_det['m_honorific']." ".$row_traveler_det['first_name']." ".$row_traveler_det['middle_name']." ".$row_traveler_det['last_name'] ?></option>
				</select></td>
			<td><input type="text" id="txt_seat_no<?php echo $count ?>" class="form-control" onchange="number_validate(this.id)" value="<?php echo $sq_seat_booking_det['seat_no'] ?>" placeholder="Bus Seat No"></td>	
		</tr>	
	<?php	
	}

	?>
		</tbody>
	</table>
	</div> </div> </div>
	<input type="hidden" id="txt_mem_count" name="txt_mem_count" value="<?php echo $count ?>">

	<div class="panel panel-default panel-body pad_8 text-center mg_bt_0">
		<button class="btn btn-success" onclick="bus_seat_arrangement_master_save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button> 
	</div>


</div>

<div class="col-md-6">
	<div class="panel panel-default panel-body pad_8 bus_layout_img_pan" style="height:499px">
		<?php 
		$bus_name = $sq_bus_det['bus_name'];		
		?>
		<img src="<?= BASE_URL ?>images/bus-layouts/<?= $bus_name ?>.jpg" alt="">		

	</div>
</div>

<script>
	(function($){
	    $(".table-responsive, .bus_layout_img_pan").mCustomScrollbar();
	})(jQuery);
</script>