<?php

include "../../model/model.php";

$active_flag = $_POST['active_flag'];
$city_id = $_POST['city_id'];

$query = "select * from cruise_master where 1 ";

if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($city_id!=""){
	$query .=" and city_id='$city_id' ";
}
?>

<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

	

<table class="table table-bordered table-hover" id="tbl_cruise_list" style="margin: 20px 0 !important;">

	<thead>

		<tr  class="table-heading-row">

			<th>S_No.</th>
			<th>City</th>
			<th>Company_Name</th>
			<th>Mobile</th>
			<th>Contact_Person</th>	
			<!-- <th>Address</th> -->		
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 

		$count = 0;

		$sq_cruise = mysql_query($query);

		while($row_cruise = mysql_fetch_assoc($sq_cruise)){



			$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_cruise[gl_id]'"));

			$bg = ($row_cruise['active_flag']=="Inactive") ? "danger" : "";
			$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_cruise[city_id]'"));
			$mobile_no = $encrypt_decrypt->fnDecrypt($row_cruise['mobile_no'], $secret_key);

			?>

			<tr class="<?= $bg ?>">

				<td><?= ++$count ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td><?= $row_cruise['company_name'] ?></td>
				<td><?= $mobile_no ?></td>
				<td><?= $row_cruise['contact_person_name'] ?></td>
				<!-- <td><?= $row_cruise['cruise_address'] ?></td> -->
				<td>

					<button class="btn btn-info btn-sm" onclick="cruise_view_modal(<?= $row_cruise['cruise_id'] ?>)" title="Supplier Information"><i class="fa fa-eye"></i></button>

				</td>

				<td>

					<button class="btn btn-info btn-sm" onclick="cruise_update_modal(<?= $row_cruise['cruise_id'] ?>)" title="Edit cruise Detail"><i class="fa fa-pencil-square-o"></i></button>

				</td>

			</tr>

			<?php

		}

		?>

	</tbody>

</table>



</div> </div> </div>



<div id="div_cruise_update"></div>
<div id="div_cruise_view"></div>


<script>

$('#tbl_cruise_list').dataTable({
		"pagingType": "full_numbers"
	});

function cruise_update_modal(cruise_id){

	$.post('cruise_update_modal.php', { cruise_id : cruise_id }, function(data){

		$('#div_cruise_update').html(data);

	});
}

function cruise_view_modal(cruise_id){

	$.post('view_modal.php', { cruise_id : cruise_id }, function(data){

		$('#div_cruise_view').html(data);

	});

}

</script>