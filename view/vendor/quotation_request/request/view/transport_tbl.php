<?php  if($sq_req['quotation_for']=="Transport"): ?>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        <h3 class="editor_title">Transport Details</h3>

        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Transport_Company</th>
						</tr>
					</thead>
					<tbody>
			        	<?php 
			        	$transport_entries = $sq_req['transport_entries'];
						$transport_entries_arr = json_decode($transport_entries, true);

						$count = 1;
						foreach(array_chunk($transport_entries_arr, 1) as $transport_entries){
							$arr = array();
							foreach($transport_entries as $transport_entries1){
								$arr[$transport_entries1['name']] = $transport_entries1['value'];
							}

							$sq_tr = mysql_fetch_assoc(mysql_query("select transport_agency_id, transport_agency_name from transport_agency_master where transport_agency_id='$arr[transport_agency_id]'"));
							if($sq_tr['transport_agency_name'] != ''){
							?>
							<tr>
								<td><?= $count ?></td>
								<td><?= $sq_tr['transport_agency_name'] ?></td>
							</tr>
							<?php
							$count++;
						}
						}
			        	?>
	        		</tbody>
	        	</table>

        	</div> </div> </div>

        </div>
    </div>
</div>
<?php endif; ?>