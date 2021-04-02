<?php

include "../../../model/model.php";



$active_flag = $_POST['active_flag'];

$city_id = $_POST['city_id'];



$query = "select * from transport_agency_master where 1 ";



if($active_flag!=""){

	$query .=" and active_flag='$active_flag' ";

}

if($city_id!=""){

	$query .=" and city_id='$city_id' ";

}

?>

<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table table-bordered" id="tbl_transport_agency_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Transporter</th>
			<th>City</th>
			<th>Mobile</th>
			<th>Contact_Person</th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_transport_agency = mysql_query($query);
		while($row_transport_agency = mysql_fetch_assoc($sq_transport_agency)){
			$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_transport_agency[city_id]'"));
			$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_transport_agency[gl_id]'"));
			$bg = ($row_transport_agency['active_flag']=='Inactive') ? "danger" : "";
			$mobile_no = $encrypt_decrypt->fnDecrypt($row_transport_agency['mobile_no'], $secret_key);
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_transport_agency['transport_agency_name'] ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td><?= $mobile_no ?></td>
				<td><?= $row_transport_agency['contact_person_name'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="view_modal(<?= $row_transport_agency['transport_agency_id'] ?>)" title="Supplier Information"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_transport_agency['transport_agency_id'] ?>)" title="Edit Information"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>

	</tbody>
</table>
</div> </div> </div>
<script>
$('#tbl_transport_agency_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>