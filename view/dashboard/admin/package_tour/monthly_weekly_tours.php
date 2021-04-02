<?php 
include "../../../../model/model.php";

$package_tour_montly_weekly_select = $_POST['package_tour_montly_weekly_select'];

if($package_tour_montly_weekly_select=='Weekly'){
	$sq_package_tours = mysql_query("select * from package_tour_booking_master where WEEKOFYEAR(tour_from_date)=WEEKOFYEAR(NOW())");
}
if($package_tour_montly_weekly_select=="Monthly"){
	$sq_package_tours = mysql_query("select * from package_tour_booking_master where YEAR(tour_from_date) = YEAR(NOW()) AND MONTH(tour_from_date)=MONTH(NOW())");
}
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
	
	<table class="table table-bordered table-hover">
		<thead>
			<th>Tour Name</th>
			<th>Tour Date</th>
			<th>File Number</th>
			<th>Mobile No</th>
		</thead>
		<tbody>
			<?php
			$today = date('Y-m-d');
			while($row_package_tours = mysql_fetch_assoc($sq_package_tours)){
				?>
				<tr>
					<td><?= $row_package_tours['tour_name'] ?></td>
					<td><?= date('d-m-Y', strtotime($row_package_tours['tour_from_date'])) ?></td>
					<td><?= 'File No-'.$row_package_tours['booking_id'] ?></td>
					<td><?= $row_package_tours['mobile_no'] ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

</div> </div> </div>