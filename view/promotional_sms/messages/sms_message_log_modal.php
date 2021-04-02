<?php 
include "../../../model/model.php";

$sms_message_id = $_POST['sms_message_id'];
?>
<div class="modal fade" id="sms_msg_log_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Message Log</h4>
      </div>
      <div class="modal-body">
        
		<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
			<table class="table table-bordered">
				<thead>
					<th>S_No.</th>
					<th>SMS_Group</th>
					<th>SMS_Date</th>
				</thead>
				<tbody>
					<?php
					$count = 0;
					$sq_log = mysql_query("select * from sms_sending_log where sms_message_id='$sms_message_id'");
					while($row_log = mysql_fetch_assoc($sq_log)){

						$sms_group_id = $row_log['sms_group_id'];
						if($sms_group_id==0){
							$sms_group_name = "All";
						}
						else{
							$sq_sms_group = mysql_fetch_assoc(mysql_query("select * from sms_group_master where sms_group_id='$sms_group_id'"));	
							$sms_group_name = $sq_sms_group['sms_group_name'];
						}
						?>
						<tr>
							<td><?= ++$count ?></td>
							<td><?= $sms_group_name ?></td>
							<td><?= date('d/m/Y H:i:s', strtotime($row_log['created_at'])) ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

		</div> </div> </div>

      </div>      
    </div>
  </div>
</div>
<script>
	$('#sms_msg_log_modal').modal('show');
</script>