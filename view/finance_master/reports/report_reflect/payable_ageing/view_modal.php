<?php include "../../../../../model/model.php";
$booking_id_arr = $_POST['booking_id_arr'];
$pending_amt_arr = $_POST['pending_amt_arr'];
$total_days_arr = $_POST['total_days_arr'];
$not_due_arr = $_POST['not_due_arr'];
$due_date_arr = $_POST['due_date_arr'];

$booking_id_arr = explode(',',$booking_id_arr);
$pending_amt_arr = explode(',',$pending_amt_arr);
$total_days_arr = explode(',',$total_days_arr);
$not_due_arr = explode(',',$not_due_arr);
$due_date_arr = explode(',',$due_date_arr);
?>

<div class="modal fade profile_box_modal" id="ageing_view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ageing Information</h4>
      </div>
      <div class="modal-body">      	
          <div class="panel panel-default panel-body fieldset profile_background">
          		<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
					<table class="table table-bordered" id="tbl_ageing_report" style="margin: 20px 0 !important;">
						<thead>
							<tr class="table-heading-row">
								<th>SR.NO</th>
								<th>Purchase_ID</th>
								<th>Due_Date</th>
								<th>Not_Due</th>
								<th>Total_Due</th>
								<th>Total_Days</th>
							</tr>
						</thead>
						<tbody>		
						 	<?php for($i=0;$i<sizeof($booking_id_arr);$i++){  ?>
								<tr>
									<td><?= ($i+1) ?></td>
									<td><?= $booking_id_arr[$i] ?></td>
									<td><?= get_date_user($due_date_arr[$i]) ?></td>
									<td><?= number_format($not_due_arr[$i],2) ?></td>
									<td><?= number_format($pending_amt_arr[$i],2) ?></td>
									<td><?= $total_days_arr[$i] ?></td>
								</tr>									 
							<?php } ?>
						</tbody>
					</table>
				</div> </div> </div>
		  </div>        
	   </div>     
      </div>
    </div>
</div>

<script>
$('#ageing_view_modal').modal('show');
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>