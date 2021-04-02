<?php 
include "../../../model/model.php"; 
include_once('../../layouts/app_functions.php');

$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];
$traveler_group_id = $_POST['traveler_group_id'];

$sq_tourwise_id = mysql_fetch_assoc(mysql_query("select id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id = '$tour_group_id' and traveler_group_id = '$traveler_group_id' "));

 $tourwise_id = $sq_tourwise_id['id'];

 $sq = mysql_query("select total_travel_expense from tourwise_traveler_details where id='$tourwise_id'");
 while($row = mysql_fetch_assoc($sq))
 {
 	$total_travel_expense = $row['total_travel_expense'];
 }

 $sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as total from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='traveling' "));

 $paid_amount = $sq_paid_amount['total'];

 $refund_amount = $total_travel_expense - $paid_amount;

 if($refund_amount<=0)
 {
 	$refund="N/A";
 	$btn_status = "disabled";
 }
 if($refund_amount>0)
 {
 	$refund = $refund_amount;
 	$btn_status = "";
 }

?>

<div class="row">
	
	<div class="col-md-5">
		<?php  
		    begin_widget();
		        $title_arr = array("Total Travel Amount", "Paid Travel Amount", "Balance Amount");
		        $content_arr = array($total_travel_expense, $paid_amount, $refund);
		        $percent = ($paid_amount/$total_travel_expense)*100;
		        $percent = round($percent, 2);
		        $label = "Travel Fee Paid In Percent";
		        widget_element($title_arr, $content_arr, $percent, $label, $head_title);
		    end_widget();
		?>
	</div>
	<div class="col-md-7">

		<div class="table-responsive">
			<table id="tbl_travel_refund_amount" class="table table-bordered table-hover">
				<tr>
					<td class="text-right">Refund By</td>	
					<td>
						<select class="form-control" id="cmb_refund_mode" name="cmb_refund_mode">
				 			<option value="">Refund Mode</option>
				 			<option value="cash">Cash</option>
				 			<option value="cheque">Cheque</option>
				            <option value="NEFT">NEFT</option>
				            <option value="credit note">Credit Note</option>
				 		</select>	
					</td>	
				</tr>
				<tr>
					<td class="text-right">Refund Amount</td>
					<td><input class="form-control" type="text" id="txt_refund_amount" name="txt_refund_amount" placeholder="Refund Amount"></td>
				</tr>
				<tr class="text-center">
					<td colspan="2">
						<button class="btn btn-success" <?php echo $btn_status; ?> onclick="extra_travel_amount_refund_status_update()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Refund</button>
					</td>
				</tr>
			</table>
		</div>

		<div class="table-responsive">
			<div class="table-responsive">
			<table id="tbl_travel_refund_amount" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Sr. No</th>
						<th>Refund Mode</th>
						<th>Refund Amount</th>
						<th>Refund Date</th>
						<th>Invoice</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sq_refund = mysql_query("select * from refund_travel_extra_amount where tourwise_traveler_id='$tourwise_id'");
					while($row_refund = mysql_fetch_assoc($sq_refund))
					{
						?>
						<tr>
							<td><?= ++$count ?></td>
							<td><?= $row_refund['refund_mode'] ?></td>
							<td><?= $row_refund['refund_amount'] ?></td>
							<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
							<td>
								<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="generate_voucher_for_refund_travel_extra_cost(<?= $row_refund['refund_id'] ?>)"><i class="fa fa-file-pdf-o"></i></a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			</div>
		</div>
		
	</div>

</div>


	



<input type="hidden" id="txt_tourwise_id" name="txt_tourwise_id" value="<?php echo $tourwise_id; ?>" >