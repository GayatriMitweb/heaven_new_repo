<?php
include "../../model/model.php";
$branch_admin_id = $_SESSION['branch_admin_id'];
$approve_status = $_POST['approve_status'];
$active_flag = $_POST['active_flag'];
$branch_status = $_POST['branch_status'];

$query = "select * from b2b_registration where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($approve_status!=""){
	if($approve_status == 'Pending'){
		$query .=" and approval_status='' ";
	}else{
		$query .=" and approval_status='$approve_status' "; }
}
$query .=" order by register_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table table-hover" id="tbl_customer_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Company_Name</th>
			<th>Contact_Person</th>
			<th>Email_ID</th>
			<th>Mobile</th>
			<th>City</th>
			<th>Country</th>
			<th>View</th>
			<th>Status</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_customer = mysql_query($query);
		while($row_customer = mysql_fetch_assoc($sq_customer)){
			if($row_customer['approval_status']=="Rejected"){ $bg = "danger"; $icon = 'fa-times';}
			else if($row_customer['approval_status']=="Approved"){ $bg = "success"; $icon = 'fa-check';} 
			else{ $bg = '';  $icon = 'fa-check-square-o'; }
				
			$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_customer[city]'"));

			$color = ($row_customer['approval_status']=="Rejected") ? 'btn-danger' : 'btn-info'; 
			$sq_country = mysql_fetch_assoc(mysql_query("select * from country_list_master where country_id='$row_customer[country]'"));
			$country_name = ($row_customer['country']!='0') ? $row_customer['country_name'].'('.$sq_country['country_code'].')':'NA';
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_customer['company_name']?></td>
				<td><?= $row_customer['cp_first_name'].' '.$row_customer['cp_last_name']  ?></td>
				<td><?= $row_customer['email_id'] ?></td>
				<td><?= $row_customer['mobile_no'] ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td><?= $country_name ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="customer_display_modal(<?= $row_customer['register_id'] ?>)" title="View Information" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn <?= $color ?> btn-sm" onclick="customer_update_modal(<?= $row_customer['register_id'] ?>)" title="Update status" data-toggle="tooltip"><i class="fa <?= $icon?>" aria-hidden="true"></i></button>
				</td>
				<td>
					<button class="btn <?= $color ?> btn-sm" onclick="b2b_update_modal(<?= $row_customer['register_id'] ?>)" title="Update Agent" data-toggle="tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="delete_customer(<?= $row_customer['register_id'] ?>)" title="Delete Agent" id="delete" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			<?php } ?>
	</tbody>
</table>	
</div></div></div>
<div id="div_customer_update_modal"></div>
<script>
$('#tbl_customer_list').dataTable({
	"pagingType": "full_numbers"
});
function customer_update_modal(customer_id){
	$.post('customer_update_modal.php', { register_id : customer_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
function customer_display_modal(customer_id){
	$.post('view/index.php', { register_id : customer_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
function delete_customer(customer_id){
	var base_url = $('#base_url').val();
	$("#vi_confirm_box").vi_confirm_box({
	callback: function(result){
		if(result=="yes")
		{					
			$('#delete').button('loading');
			$.ajax({
				type: 'post',
				url: base_url+'controller/b2b_customer/customer_delete.php',
				data:{ register_id : customer_id},
				success: function(result){
					msg_alert(result);
					$('#delete').button('reset');
					customer_list_reflect();
				}
			});
		}
		}
	});
}
function b2b_update_modal(register_id){
	$.post('update/index.php', { register_id : register_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
</script>