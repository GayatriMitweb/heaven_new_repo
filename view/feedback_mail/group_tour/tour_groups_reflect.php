<?php
include "../../../model/model.php";

$tour_id = $_POST['tour_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
 
$sq_tour_info = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$tour_id'"));
$count = 0;
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-bordered" id="feedback_grp_tour_id" style="margin: 20px 0 !important;">
		<thead>
			<tr class="table-heading-row">
				<th>S_No.</th>
				<th>Tour</th>
				<th>From_Date</th>
				<th>To_Date</th>
				<th>Send_Mail</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$query =  "select * from tour_groups where 1";

			if($tour_id!=""){
			$query .=" and tour_id='$tour_id'";
			}

			if($from_date!="" && $to_date!=""){
			$from_date1 = get_date_db($from_date);
			$to_date1 = get_date_db($to_date);

			$query .= " and date(form_date) between '$from_date1' and '$to_date1'";

			}	
			$sq_tour_groups = mysql_query($query);
			while($row_tour_groups = mysql_fetch_assoc($sq_tour_groups)){

				$sq_tour_info =  mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id = '$row_tour_groups[tour_id]'"));
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $sq_tour_info['tour_name'] ?></td>
					<td><?= date('d/m/Y', strtotime($row_tour_groups['from_date'])) ?></td>
					<td><?= date('d/m/Y', strtotime($row_tour_groups['to_date'])) ?></td>
					<td>
						<?php 
						if($row_tour_groups['feedback_mail_status']=="Sent"){
							?>
							<button class="btn btn-danger btn-sm" disabled><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Sent</button>
							<?php
						}
						else{
							?>
							<button class="btn btn-success btn-sm" id="btn_feedback_<?= $count ?>" onclick="feedback_tour_group_mail_send(<?= $row_tour_groups['group_id'] ?>, 'btn_feedback_<?= $count ?>')"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Send</button>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
			}
			?>			
		</tbody>
	</table>

</div> </div> </div>
<script type="text/javascript">
	$('#feedback_grp_tour_id').dataTable({
		"pagingType": "full_numbers"
	});
</script>

<script>
	function feedback_tour_group_mail_send(tour_group_id, btn_id)
	{
		var $btn = $('#'+btn_id).button('loading');
		var base_url = $('#base_url').val();
		$.ajax({
			type:'post',
			url: base_url+'controller/feedback_mail/group_tour_mail_send.php',
			data: { tour_group_id : tour_group_id },
			success:function(result){
				msg_alert(result);
				tour_groups_reflect();
				$btn.button('reset');
			}
		});
	}
</script>

