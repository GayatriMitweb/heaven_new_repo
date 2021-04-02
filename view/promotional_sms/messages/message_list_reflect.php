<?php 
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>

<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table id="tbl_sms_message" class="table table-bordered" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Sms_Message</th>
			<th>Group_Name</th>
			<th>Send</th>
			<th>View_Log</th>
			<th>Edit</th>
		</tr>
		
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$query = "select * from sms_message_master where 1";
		if($branch_status=='yes' && $role=='Branch Admin'){
	      $query .=" and branch_admin_id = '$branch_admin_id'";
	    }
		$sq_sms_message = mysql_query($query);
		while($row_sms_message = mysql_fetch_assoc($sq_sms_message)){
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td class="text-left"><?= $row_sms_message['message'] ?></td>
				<td>
					<select name="sms_group_id" id="sms_group_id_<?= $count ?>" title="Select SMS Group ID" style="height: 30px;width:100px;" class="form-control">
						<option value="">All</option>
						<?php 
						$query1 = "select * from sms_group_master where 1";
						if($branch_status=='yes' && $role=='Branch Admin'){
					      $query1 .=" and branch_admin_id = '$branch_admin_id'";
					    }
						$sq_sms_group = mysql_query($query1);
						while($row_sms_group = mysql_fetch_assoc($sq_sms_group)){
							?>
							<option value="<?= $row_sms_group['sms_group_id'] ?>"><?= $row_sms_group['sms_group_name'] ?></option>
							<?php
						}
						?>
					</select>
				</td>
				<td>
					<button class="btn btn-success btn-sm" onclick="sms_message_send(<?= $row_sms_message['sms_message_id'] ?>, <?= $count ?>)"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="sms_message_log_modal(<?= $row_sms_message['sms_message_id'] ?>)" title="Message Log"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="sms_message_edit_modal(<?= $row_sms_message['sms_message_id'] ?>)" title="Edit Message"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<div id="div_sms_message_edit_content"></div>
<div id="div_sms_message_log_content"></div>

<script>
	$('#tbl_sms_message').dataTable({"pagingType": "full_numbers"});	
</script>