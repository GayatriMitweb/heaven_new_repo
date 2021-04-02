<?php
include "../../../model/model.php";
$city_id = $_POST['city_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$query = "select * from hotel_inventory_master where 1 ";
if($city_id != ''){
	$query .= " and city_id = '$city_id'";
}
include "../../../model/app_settings/branchwise_filteration.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="table_hotel_inv" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>City_name</th>
			<th>Hotel_Name</th>
			<th>Rate</th>
			<th>Rooms_Purchased</th>
			<th>Rooms_Available</th>
			<th>Category</th>
			<th>Valid_From</th>
			<th>Valid_To</th>
			<th>Edit</th>
			<th>Download</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		$sq_serv = mysql_query($query);
		while($row_ser = mysql_fetch_assoc($sq_serv)){
			$bg = ($row_ser['active_flag'] == 'Inactive')?'danger':'';
			
			$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_ser[city_id]'"));
			$sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id='$row_ser[hotel_id]'"));

			$sq_package = mysql_fetch_assoc(mysql_query("select sum(rooms) as package_rooms from package_hotel_accomodation_master where city_id='$row_ser[city_id]' and hotel_id='$row_ser[hotel_id]' and catagory='$row_ser[room_type]' and (from_date between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')"));
			$sq_hotel_c = mysql_fetch_assoc(mysql_query("select sum(rooms) as hotel_rooms from hotel_booking_entries where city_id='$row_ser[city_id]' and hotel_id ='$row_ser[hotel_id]' and category='$row_ser[room_type]' and (check_in between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')"));
			$total_avail =  $row_ser['total_rooms'] - ($sq_package['package_rooms'] + $sq_hotel_c['hotel_rooms']);
		?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td onclick="history_modal(<?= $row_ser['entry_id'] ?>)" style="color:#009898;"><?= $sq_hotel['hotel_name'] ?></td>
				<td><?= $row_ser['rate'] ?></td>
				<td><?= $row_ser['total_rooms'] ?></td>
				<td><?= ($total_avail <= 0) ? 0 : $total_avail ?></td>
				<td><?= $row_ser['room_type'] ?></td>
				<td><?= date("d-m-Y", strtotime($row_ser['valid_from_date'])) ?></td>
				<td><?= date("d-m-Y", strtotime($row_ser['valid_to_date'])) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_ser['entry_id'] ?>)" title="Update"><i class="fa fa-pencil-square-o"></i></button></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="excel_report(<?= $row_ser['entry_id'] ?>)" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button></td>
			</tr>
			<?php } ?>
	</tbody>
</table>
</div> </div> </div>
<script type="text/javascript">
$('#table_hotel_inv').dataTable({
	"pagingType": "full_numbers"
});
</script>