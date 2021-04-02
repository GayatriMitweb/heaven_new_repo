<?php 
include_once('../../../model/model.php');
$enquiry_id = $_POST['enquiry_id'];
?>
<div class="modal fade" id="id_history1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" data-original-title="" title="">×</span></button>   
           <h4 class="modal-title">Followup History</h4>     
        </div>
        <div class="modal-body">
			<div class="row"> <div class="col-md-12"> <div class="table-responsive">
				<table class="table table-bordered no-marg" style="border: 1px solid #ddd !important" id="foll_table_id">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Description</th>
							<th>Type</th>
							<th>Status</th>
							<th>Followup_DateTime</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$count = 0; 
					$sq_followup_entries = mysql_query("select * from enquiry_master_entries where enquiry_id='$enquiry_id'");
					 
					while($row_entry = mysql_fetch_assoc($sq_followup_entries)){
						?>
						<tr>
							<td><?= ++$count ?></td>
							<td><?= $row_entry['followup_reply'] ?></td>
							<td><?= $row_entry['followup_type'] ?></td>
							<td><?= $row_entry['followup_status'] ?></td>
							<td><?= date('d/m/Y H:i:s', strtotime($row_entry['followup_date'])) ?></td>
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

<script type="text/javascript">
$('#id_history1').modal('show');
</script>