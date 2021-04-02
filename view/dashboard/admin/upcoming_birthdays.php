<div class="head"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp;Upcoming Bithdays</div>
<div class="body" style="height:270px;">

<div class="row"> <div class="col-md-12"> <div class="table-responsive">

	<table class="table table-bordered table-hover mg_bt_0">
		<thead>
			<tr>
				<th>Sr. No</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Birth Date</th>
				<th>Age</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$data_arr = array();

			$today = date('Y-m-d');
			$sq = mysql_query("select * from travelers_details where MONTH(birth_date)=MONTH(NOW()) and day(birth_date)>DAYOFMONTH('$today')");
			while($row = mysql_fetch_assoc($sq)){

				array_push($data_arr, array(

					'name' => $row['m_honorific'].' '.$row['first_name'].' '.$row['last_name'],
					'gender' => $row['gender'],
					'date' => strtotime($row['birth_date']),
					'age' => $row['age'], 

				));
				
			}

			$sq = mysql_query("select * from package_travelers_details where MONTH(birth_date)=MONTH(NOW()) and day(birth_date)>DAYOFMONTH('$today')");
			while($row = mysql_fetch_assoc($sq)){

				array_push($data_arr, array(

					'name' => $row['m_honorific'].' '.$row['first_name'].' '.$row['last_name'],
					'gender' => $row['gender'],
					'date' => strtotime($row['birth_date']),
					'age' => $row['age'], 

				));
				
			}


			$count = 0;
			foreach($data_arr as $row_arr){
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $row_arr['name'] ?></td>
					<td><?= $row_arr['gender'] ?></td>
					<td><?= date('d-m-Y', $row_arr['date']) ?></td>
					<td><?= $row_arr['age'] ?></td>
				</tr>
				<?php
			}
			?>		
		</tbody>
	</table>
	
</div> </div> </div>

</div>