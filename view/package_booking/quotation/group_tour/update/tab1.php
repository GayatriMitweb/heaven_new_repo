<?php
$role_id = $_SESSION['role_id'];
?>
<form id="frm_tab1_u">

	<div class="row">

		<input type="hidden" id="quotation_id1" name="quotation_id1" value="<?= $quotation_id ?>">

		<input type="hidden" id="package_id1" name="quotatiopackage_id1n_id1" value="<?= $package_id ?>">
		<input type="hidden" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y',strtotime($sq_quotation['quotation_date']) )?>"> 
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">

			<select name="enquiry_id1" id="enquiry_id1" title="Enquiry No" style="width:100%" onchange="get_enquiry_details('1');group_quotation_cost_calculate();">

				<?php 

				$sq_enq1 = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$sq_quotation[enquiry_id]' and enquiry_type='Group Booking'"));

					?>

					<option value="<?= $sq_enq1['enquiry_id'] ?>">Enq<?= $sq_enq1['enquiry_id'] ?> : <?= $sq_enq1['name'] ?></option>

					<?php
				if($role=='Admin'){
				    $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' order by enquiry_id desc");
				}	
				if($branch_status=='yes'){
					if($role=='Branch Admin'){
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){

						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc");
					}
					else{
						 $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
					
				}
				else{
					if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
						$q = "select * from enquiry_master where enquiry_type in('Group Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
						$sq_enq = mysql_query($q);
					}
					else{
						if($role=='B2b'){

						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' and assigned_emp_id='$emp_id' order by enquiry_id desc");
						}
						else{
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Group Booking') and status!='Disabled' order by enquiry_id desc");
						}
					}
				}
				while($row_enq = mysql_fetch_assoc($sq_enq)){

					?>

					<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>

				<?php

				}

				?>

			</select>

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="tour_name1" name="tour_name1" onchange="validate_spaces(this.id)" placeholder="Tour Name" title="Tour Name" value="<?= $sq_quotation['tour_name'] ?>">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="from_date1" name="from_date1" placeholder="From Date" title="From Date" onchange="total_days_reflect('1');get_to_date(this.id,'to_date1')" value="<?= date('d-m-Y', strtotime($sq_quotation['from_date'])) ?>">

	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	     <input type="text" id="to_date1" name="to_date1" placeholder="To Date" title="To Date" onchange="total_days_reflect('1')" value="<?= date('d-m-Y', strtotime($sq_quotation['to_date'])) ?>">

	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="total_days1" name="total_days1" placeholder="Total Days" title="Total Days" value="<?= $sq_quotation['total_days'] ?>" disabled>

	    </div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="customer_name1" name="customer_name1" onchange="validate_customer(this.id)" placeholder="Customer Name" title="Customer Name" value="<?= $sq_quotation['customer_name'] ?>">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="total_adult1" name="total_adult1" placeholder="Total Adult" title="Total Adult" title="Total Infant" onchange=" validate_balance(this.id);total_passangers_calculate('1'); cost_reflect();" value="<?= $sq_quotation['total_adult'] ?>">

	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	     <input type="text" class="form-control" id="children_with_bed1" name="children_with_bed1" title="Child With Bed" onchange="total_passangers_calculate('1');validate_balance(this.id);cost_reflect()" placeholder="Child With Bed" value="<?= $sq_quotation['children_with_bed'] ?>">   

	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" class="form-control" id="children_without_bed1" name="children_without_bed1" onchange="total_passangers_calculate('1');validate_balance(this.id)" placeholder="Child Without Bed" title="Child Without Bed" value="<?= $sq_quotation['children_without_bed'] ?>">

	    </div>

	    
		 <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	      <input type="text" id="total_infant1" name="total_infant1" placeholder="Total Infant" title="Total Infant" onchange="total_passangers_calculate('1');cost_reflect(); validate_balance(this.id)" value="<?= $sq_quotation['total_infant'] ?>">

	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			<input type="text" id="total_passangers1" name="total_passangers1" placeholder="Total Members" title="Total Members" disabled value="<?= $sq_quotation['total_passangers'] ?>">

		</div>	

		

	 	 <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	     <input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" value="<?= $sq_quotation['email_id'] ?>">

	    </div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

			 <input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y', strtotime($sq_quotation['quotation_date'])) ?>">

		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	       <select name="booking_type2" id="booking_type2" title="Booking Type">

	        	<option value="<?= $sq_quotation['booking_type'] ?>"><?= $sq_quotation['booking_type'] ?></option>

	        	<option value="Domestic">Domestic</option>

	        	<option value="International">International</option>

	        </select>

	    </div>

	</div>	



	<br><br>

	

	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>



<script>

 

$('#frm_tab1_u').validate({

	rules:{

			 

	},

	submitHandler:function(form){

		  

		$('a[href="#tab3_u"]').tab('show');



	}

});

</script>

