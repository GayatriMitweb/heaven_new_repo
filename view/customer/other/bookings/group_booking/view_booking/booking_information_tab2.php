<?php
$train_ticket_url = $sq_tourwise_det['train_upload_ticket'];
$train_ticket_url = preg_replace('/(\/+)/','/',$train_ticket_url); 
if($train_ticket_url!=""){
	$train_ticket_url = explode("uploads", $train_ticket_url);
	$train_ticket_url = BASE_URL.'uploads/'.$train_ticket_url[1];	
}

$plane_ticket_url = $sq_tourwise_det['plane_upload_ticket'];
$plane_ticket_url = preg_replace('/(\/+)/','/',$plane_ticket_url); 
if($plane_ticket_url!=""){
	$plane_ticket_url = explode("uploads", $plane_ticket_url);
	$plane_ticket_url = BASE_URL.'uploads/'.$plane_ticket_url[1];	
}

?>
<!--*********Section-6 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Train Information</div>
	<?php if($train_ticket_url!=""): ?>
		<div class="customer_badge_right">
				<a href="<?php echo $train_ticket_url ?>"  title="Download Train Ticket" download ><i class="fa fa-download"></i></a>
		</div>
	<?php endif; ?>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<?php 
			$sq_train_count = mysql_num_rows(mysql_query("select train_id from train_master where tourwise_traveler_id='$tourwise_id'"));

			if($sq_train_count>0)
			{

			 ?>
			 <table class="table table-bordered table-hover mg_bt_10">
			 	<tr class="active">
			 		<td>Sr. No</td>
			 		<td>Date</td>
			 		<td>From</td>
			 		<td>To</td>
			 		<td>Train Number</td>
			 		<td>Seats</td>
			 		<td>Amount</td>
			 		<td>Class</td>
			 		<td>Priority</td>
			 	</tr>	
			 <?php   

			    $train_count=0;
			    $sq_train = mysql_query("select * from train_master where tourwise_traveler_id='$tourwise_id'");
			    while($row_train = mysql_fetch_assoc($sq_train))
			    {			        
			        $train_count++;
			     ?>
			     <tr>
			     	<td><?php echo $train_count ?></td>
			     	<td><?php echo date("d-m-Y H:i:s", strtotime($row_train['date'])) ?></td>
			     	<td><?php echo $row_train['from_location'] ?></td>
			     	<td><?php echo $row_train['to_location'] ?></td>
			     	<td><?php echo $row_train['train_no'] ?></td>
			     	<td><?php echo $row_train['seats'] ?></td>
			     	<td><?php echo $row_train['amount'] ?></td>
			     	<td><?php echo $row_train['train_class'] ?></td>
			     	<td><?php echo $row_train['train_priority'] ?></td>
			     </tr>	
			     <?php   
			    }
			    ?>
			</table>
			    <?php
			}       

		?>
	</div> </div> </div>
</div>



<!--*********Section-7 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Plane Information</div>
	<?php if($plane_ticket_url!=""): ?>
		<div class="customer_badge_right">
			<a href="<?php echo $plane_ticket_url ?>"  title="Download Plane Ticket" download ><i class="fa fa-download"></i></a>
		</div>
	<?php endif; ?>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
	    <?php
	    $sq_plane_count = mysql_num_rows(mysql_query("select plane_id from plane_master where tourwise_traveler_id='$tourwise_id'"));

		if($sq_plane_count>0)
		{
			?>
			 <table class="table table-bordered table-hover mg_bt_10">
			 	<tr class="active">
			 		<td>Sr. No</td>
			 		<td>Departure_date/time</td>
			 		<td>From</td>
			 		<td>To</td>
			 		<td>Company</td>
			 		<td>Arrival_date/time</td>
			 		<td>Amount</td>
			 		<td>Seats</td>
			 	</tr>	
			 <?php  
		   

		    $plane_count=0;
		    $sq_train = mysql_query("select * from plane_master where tourwise_traveler_id='$tourwise_id'");
		    while($row_plane = mysql_fetch_assoc($sq_train))
		    {
		    	$plane_count++;
		    ?>
		    	<tr>
		    		<td><?php echo $plane_count ?></td>
		    		<td><?php echo date("d-m-Y H:i:s", strtotime($row_plane['date'])) ?></td>
		    		<td><?php echo $row_plane['from_location'] ?></td>
		    		<td><?php echo $row_plane['to_location'] ?></td>
		    		<td><?php echo $row_plane['company'] ?></td>
		    		<td><?php echo date("d-m-Y H:i:s", strtotime($row_plane['arraval_time'])) ?></td>
		    		<td><?php echo $row_plane['amount'] ?></td>
		    		<td><?php echo $row_plane['seats'] ?></td>
		    	</tr>	
		    <?php
		    }
		    ?>
			</table>
		    <?php
		}     

	    ?>
	</div> </div> </div>
</div>



<!--*********Section-8 start***************-->
<div class="panel panel-default panel-body pad_8 mg_bt_10 customer_pan">
	<div class="customer_badge">Travel Costing</div>
	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
		<table class="table table-bordered table-hover mg_bt_10 text-center">
			<tr class="active">
				<td><label>Train Expense</label></td>
				<td><label>Plane Expense</label></td>
				<td><label>Total Travel Expense</label></td>
			</tr>
			<tr>
				<td><?php echo $sq_tourwise_det['total_train_expense']; ?></td>
				<td><?php echo $sq_tourwise_det['total_plane_expense']; ?></td>
				<td><?php echo $sq_tourwise_det['total_travel_expense']; ?></td>
			</tr>
		</table>
	</div> </div> </div>
</div>

