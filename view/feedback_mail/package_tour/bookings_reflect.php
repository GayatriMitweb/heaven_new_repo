<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$count = 0;
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-bordered" id="feedback_pckg_tour_id" style="margin: 20px 0 !important;">
		<thead>
		    <tr class="table-heading-row">
		    	<th>S_No.</th>
				<th>File_No.</th>
				<th>Tour</th>
				<th>From_Date</th>
				<th>To_Date</th>
				<th>Send_Mail</th>
		    </tr>
		</thead>
		<tbody>
			<?php
			$query = "select * from package_tour_booking_master where 1";
			if($booking_id!=""){
				$query .= " and booking_id='$booking_id'";
			}

			if($from_date!=""){
			$from_date1 = get_date_db($from_date);

			$query .= " and tour_from_date='$from_date1' ";
			}	

			if($to_date!=""){
			$to_date1 = get_date_db($to_date);

			$query .= " and tour_to_date='$to_date1' ";
			}	

			$sq_booking = mysql_query($query);
			while($row_booking = mysql_fetch_assoc($sq_booking)){
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= 'File No-'.$row_booking['booking_id'] ?></td>
					<td><?= $row_booking['tour_name'] ?></td>
					<td><?= date('d/m/Y', strtotime($row_booking['tour_from_date'])) ?></td>
					<td><?= date('d/m/Y', strtotime($row_booking['tour_to_date'])) ?></td>
					<td>
						<?php 
						if($row_booking['feedback_mail_status']=="Sent"){
							?>
							<button class="btn btn-danger btn-sm" disabled><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Sent</button>
							<?php
						}  
						else{
							?>
							<button id="btn_feedback_<?= $count ?>" class="btn btn-success btn-sm" onclick="feedback_package_tour_mail_send(<?= $row_booking['booking_id'] ?>, 'btn_feedback_<?= $count ?>')"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Send</button>
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
	$('#feedback_pckg_tour_id').dataTable({
		"pagingType": "full_numbers"
	});
</script>

<script>
	function feedback_package_tour_mail_send(booking_id, btn_id)
	{
		var $btn = $('#'+btn_id).button('loading');
		var base_url = $('#base_url').val();
		$.ajax({
			type:'post',
			url: base_url+'controller/feedback_mail/package_tour_mail_send.php',
			data: { booking_id : booking_id },
			success:function(result){
				msg_alert(result);
				bookings_reflect();
				$btn.button('reset');
			}
		});
	}
</script>
