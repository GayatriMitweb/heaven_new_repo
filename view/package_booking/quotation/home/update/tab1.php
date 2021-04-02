<form id="frm_tab_u_1">

<div class="app_panel"> 


<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 
<!--=======Header panel end======-->

        <div class="container">

		<div class="row">
		 
		<input type="hidden" id="quotation_id1" name="quotation_id1" value="<?= $quotation_id ?>">

		<input type="hidden" id="package_id1" name="package_id1" value="<?= $package_id ?>">

		<div class="col-md-4 col-sm-6 col-xs-12">

			<select name="enquiry_id12" id="enquiry_id12" style="width:100%" onchange="get_enquiry_details('12')">

				<?php 

				$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$sq_quotation[enquiry_id]' and enquiry_type='Package Booking'"));

					?>

					<option value="<?= $sq_enq['enquiry_id'] ?>">Enq<?= $sq_enq['enquiry_id'] ?> : <?= $sq_enq['name'] ?></option>
					<option value="0"><?= "New Enquiry" ?></option>
				<?php
				if($role=='Admin'){
				    $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Package Booking') and status!='Disabled' order by enquiry_id desc");
				}
				if($branch_status=='yes'){
					if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Package Booking') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
						$q = "select * from enquiry_master where enquiry_type in('Package Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
						$sq_enq = mysql_query($q);
					}
				}
				elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
					$q = "select * from enquiry_master where enquiry_type in('Package Booking') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
					$sq_enq = mysql_query($q);
				}
				while($row_enq = mysql_fetch_assoc($sq_enq)){
					?>
					<option value="<?= $row_enq['enquiry_id'] ?>">Enq<?= $row_enq['enquiry_id'] ?> : <?= $row_enq['name'] ?></option>
				<?php } ?>

			</select>

		</div>	

		<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" id="tour_name12" name="tour_name12" placeholder="Tour Name" title="Tour Name" value="<?= $sq_quotation['tour_name'] ?>">

		</div>

		<div class="col-md-4 col-sm-6 col-xs-12">

		<select name="booking_type2" id="booking_type2" title="Booking Type">

				<option value="<?= $sq_quotation['booking_type'] ?>"><?= $sq_quotation['booking_type'] ?></option>

				<option value="Domestic">Domestic</option>

				<option value="International">International</option>

			</select>

		</div>
	</div>	
	<div class="row mg_tp_10"> 

		<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" id="customer_name12" name="customer_name12" onchange="validate_customer(this.id)" placeholder="Customer Name" title="Customer Name" value="<?= $sq_quotation['customer_name'] ?>">

		</div>

		<div class="col-md-4 col-sm-6 col-xs-12">
			<input type="text" id="email_id12" name="email_id12" placeholder="Email ID" title="Email ID" value="<?= $sq_quotation['email_id'] ?>">
		</div>	  	        		                			        		        	        		
		<div class="col-md-4 col-sm-6 col-xs-12">
			<input type="text" id="mobile_no12" name="mobile_no12" placeholder="WhatsApp No with country code" onchange="mobile_validate(this.id)" title="WhatsApp No with country code" value="<?= $sq_quotation['mobile_no'] ?>">
		</div>
	</div>	
	<div class="row mg_tp_10">	

		<div class="col-md-4 col-sm-6 col-xs-12">

		<input type="text" id="from_date12" name="from_date12" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date12');total_days_reflect('12');" value="<?= date('d-m-Y', strtotime($sq_quotation['from_date'])) ?>">

		</div>
	    <div class="col-md-4 col-sm-6 col-xs-12">

	     <input type="text" id="to_date12" name="to_date12" placeholder="To Date" title="To Date" onchange=" total_days_reflect('12')" value="<?= date('d-m-Y', strtotime($sq_quotation['to_date'])) ?>">

	    </div>

		<div class="col-md-4 col-sm-6 col-xs-12">

	      <input type="text" id="total_days12" name="total_days12" placeholder="Total Days" title="Total Days" value="<?= $sq_quotation['total_days'] ?>" disabled>

	    </div>
	</div>	
	<div class="row mg_tp_10">	

		<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" id="total_adult12" name="total_adult12" placeholder="Total Adult" title="Total Adult" title="Total Infant" onchange="total_passangers_calculate('12'); validate_balance(this.id)" value="<?= $sq_quotation['total_adult'] ?>">

		</div>

		<div class="col-md-4 col-sm-6 col-xs-12">

	      <input type="text" id="total_infant12" name="total_infant12" placeholder="Total Infant" title="Total Infant" onchange="total_passangers_calculate('12'); validate_balance(this.id)" value="<?= $sq_quotation['total_infant'] ?>">

	    </div>	

		<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" class="form-control" id="children_with_bed12" name="children_with_bed12" onchange="validate_balance(this.id);total_passangers_calculate('12');" placeholder="Child With Bed" title="Child With Bed" value="<?= $sq_quotation['children_with_bed'] ?>">   

		</div>	
	</div>	
	<div class="row mg_tp_10">	


		<div class="col-md-4 col-sm-6 col-xs-12">

		<input type="text" class="form-control" id="children_without_bed12" name="children_without_bed12" onchange="validate_balance(this.id);total_passangers_calculate('12');" placeholder="Child Without Bed" title="Child Without Bed" value="<?= $sq_quotation['children_without_bed'] ?>">

		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" id="total_passangers12" name="total_passangers12" placeholder="Total Members" title="Total Members" disabled value="<?= $sq_quotation['total_passangers'] ?>">

		</div>
	</div>	
	<div class="row mg_tp_10">	

		<div class="col-md-4 col-sm-6 col-xs-12">

			 <input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y', strtotime($sq_quotation['quotation_date'])) ?>">

		</div>	
	</div>
	<br><br>	

	<div class="row text-center">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</form>
<?= end_panel() ?>

<script>
$('#enquiry_id12').select2();
$('#frm_tab_u_1').validate({
	rules:{		 

	},
	submitHandler:function(form){
		//$('a[href="#tab_u_2"]').tab('show');

		$('#tab1_head').addClass('done');
		$('#tab2_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab2').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});

</script>

