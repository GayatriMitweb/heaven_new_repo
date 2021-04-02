<?php
include "../../model/model.php";
$active_flag = $_POST['active_flag'];
$city_id = $_POST['city_id'];

$query = "select * from other_vendors where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($city_id!=""){
	$query .=" and city_id='$city_id' ";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-bordered" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Company_Name</th>
			<th>City</th>
			<th>Occupation</th>
			<th>Mobile</th>
			<th>Contact_Person</th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_vendors = mysql_query($query);
		while($row_vendors = mysql_fetch_assoc($sq_vendors)){
			$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_vendors[city_id]'"));
			$bg = ($row_vendors['active_flag']=="Inactive") ? "danger" : "";
			$mobile_no = $encrypt_decrypt->fnDecrypt($row_vendors['mobile_no'], $secret_key);
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_vendors['vendor_name'] ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td><?= $row_vendors['profession'] ?></td>
				<td><?= $mobile_no ?></td>
				<td><?= $row_vendors['contact_person_name'] ?></td>
				<!-- <td><?= $row_vendors['address'] ?></td> -->
				<td>
					<button class="btn btn-info btn-sm" onclick="view_modal(<?= $row_vendors['vendor_id'] ?>)" title="View Supplier"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_vendors['vendor_id'] ?>)" title="Edit Detail"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>