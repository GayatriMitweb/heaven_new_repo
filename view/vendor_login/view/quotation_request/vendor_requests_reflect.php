<?php 
include "../../../../model/model.php";

$user_id = $_SESSION['user_id'];
$vendor_type = $_SESSION['vendor_type'];
$request_id_arr = array();
$query = mysql_query("select city_id,request_id from vendor_request_master where quotation_for in('DMC','Hotel','Transport')");
while($row_query  = mysql_fetch_assoc($query)){
	$arr = explode(',',$row_query['city_id']);
	if(in_array($user_id,$arr)){
		array_push($request_id_arr,$row_query['request_id']);
	}
}
?>
<div class="row"> <div class="col-md-12">
<div class="table-responsive">	
<table class="table table-bordered table-hover" id="tbl_req_list">
	<thead>
		<tr class="active table-heading-row">
			<th>S_No.</th>
			<th>Date</th>
			<th>Quotation_ID</th>
			<th>Customer Name</th>	
			<th>Interested_Tour</th>		
			<th>Sent_by</th>	
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		for($i=0;$i<sizeof($request_id_arr);$i++){
		$query = "select * from vendor_request_master where request_id ='$request_id_arr[$i]'";
		$row_req = mysql_fetch_assoc(mysql_query($query));
			$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row_req[enquiry_id]'"));
			$enquiry_content = $sq_enq['enquiry_content'];
			$enquiry_content_arr1 = json_decode($enquiry_content, true);
			
			$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_req[emp_id]'"));
			$bg = ($row_req['bid_status']=="Closed") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= get_date_user($row_req['created_at']) ?></td>
				<td><?= ge_vendor_request_id($row_req['request_id']) ?></td>
				<td><?= $sq_enq['name'] ?></td>
				<td><?= $enquiry_content_arr1[0]['value'] ?></td>
				<td><?= ($sq_emp['first_name']=="") ? 'Admin' : $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="vendor_request_view_modal(<?= $row_req['request_id'] ?>)" title="View"><i class="fa fa-eye"></i></button>
				</td>
			</tr>
			<?php

		}
		?>
	</tbody>
</table>
</div>
</div> </div>
<div id="div_req_view"></div>
<script>
$('#tbl_req_list').dataTable();
function vendor_request_view_modal(request_id){
	$.post('quotation_request/view/index.php', { request_id : request_id }, function(data){
		$('#div_req_view').html(data);
	});
}

</script>
