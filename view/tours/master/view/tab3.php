<div class="row">
	<div class="col-md-12">
	        <h3 class="editor_title">Cost Details</h3>
             <div class="table-responsive no-marg">
		        <table class="table no-marg table-bordered" >
		            <thead>
		                <tr class="table-heading-row">
							<th>Adult</th>
	         				<th>CWB Cost</th>
							<th>CWOB Cost</th>
					        <th>Infant </th>
					        <th>Extra Bed</th>
					    </tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $sq_tours['adult_cost']; ?></td>
							<td><?php echo $sq_tours['child_with_cost']; ?></td>
							<td><?php echo $sq_tours['child_without_cost']; ?></td>
							<td><?php echo $sq_tours['infant_cost']; ?></td>
							<td><?php echo $sq_tours['with_bed_cost']; ?></td>
						</tr>
					</tbody>
				</table>
    	 	</div>
	</div>
</div>
<div class="row mg_tp_30">
	<div class="col-md-6">
       	 	<h3 class="editor_title">Inclusions</h3>
	       	 	<div class="panel panel-default panel-body" style="min-height: 50px;">
	       	 		<?php echo $sq_tours['inclusions']; ?>
	       	 	</div>
        </div>

        <div class="col-md-6">
       	 	<h3 class="editor_title">Exclusions</h3>
	       	 	<div class="panel panel-default panel-body" style="min-height: 50px;">
	       	 		
	       	 		<?php echo $sq_tours['exclusions']; ?>
	       	 	
	       	 	</div>
        </div>
</div>  
<!-- -->