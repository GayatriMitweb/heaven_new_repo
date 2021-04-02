<?php  if($quotation_for=="Transport Vendor"): ?>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>transport_cost</th>
							<th>total_cost</th>
							<th>currency_code</th>
						</tr>
					</thead>
					<tbody>
			        	<?php
			        	$count=0;
						$query = "select * from vendor_reply_master where 1 ";
						//$query.=" and supplier_id='$supplier_id'";
						$query .=" and quotation_for='$quotation_for'";
						//$query .=" and request_id in(select request_id from vendor_request_master where enquiry_id='$enquiry_id')";
						$sq_req = mysql_query($query);
						while($row= mysql_fetch_assoc($sq_req)){
							$sq_currency1 = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id = '$row[currency_code]'"));
							$count++;
							?>
							<tr>
								<td><?= $count ?></td>
								<td><?= $row['transport_cost'] ?></td>
								<td><?= $row['total_cost'] ?></td>
								<td><?= $sq_currency1['currency_name'] ?></td>
							</tr>
							<?php } ?>
	        		</tbody>
	        	</table>
        	</div> </div> </div>
        </div>
    </div>
</div>
<?php endif; ?>