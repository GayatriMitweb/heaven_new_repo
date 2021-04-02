<?php
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role_id= $_SESSION['role_id'];
?>
<form id="frm_tab1">

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

		<input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>">
		<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
		<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
		<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
		<input type="hidden" id="hotel_sc" name="hotel_sc">
		<input type="hidden" id="hotel_markup" name="hotel_markup">
		<input type="hidden" id="hotel_taxes" name="hotel_taxes">
		<input type="hidden" id="hotel_markup_taxes" name="hotel_markup_taxes">
		<input type="hidden" id="hotel_tds" name="hotel_tds">
		<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
		<div class="row mg_tp_10">
			<div class="col-md-4 col-sm-6 col-xs-12">
				<select name="enquiry_id" id="enquiry_id" style="width:100%" onchange="get_enquiry_details()">
					<option value="">*Select Enquiry</option>
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
						<?php
					}
					?>
				</select>
			</div>	

			<div class="col-md-4 col-sm-6 col-xs-12">
			<input type="text" id="tour_name" name="tour_name" placeholder="Tour Name" title="Tour Name">
			</div>

			<div class="col-md-4 col-sm-6 col-xs-12">
				<select name="booking_type" id="booking_type" title="Booking Type">
					<option value="Domestic">Domestic</option>
					<option value="International">International</option>
				</select>
			</div>
		</div>
		<div class="row mg_tp_10">

			<div class="col-md-4 col-sm-6 col-xs-12">

			<input type="text" id="customer_name" name="customer_name" onchange="fname_validate(this.id)" placeholder="Customer Name" title="Customer Name">
            <input type="hidden" id="cust_data" name="cust_data" value='<?= get_customer_hint() ?>'>

			</div>

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID">

			</div>		        		                			        		        	        		
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" id="mobile_no" name="mobile_no" placeholder="WhatsApp No with country code" onchange="mobile_validate(this.id)" title="WhatsApp No with country code">
			</div>
		</div>
		<div class="row mg_tp_10">

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="from_date" name="from_date" placeholder="From Date" value="<?php echo $sq_enq['travel_from_date'];?>" title="From Date" onchange="validate_validDate('from_date','to_date');get_to_date(this.id,'to_date');total_days_reflect();">

			</div>

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="to_date" name="to_date" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date','to_date');total_days_reflect()" value="<?= $sq_enq['travel_to_date'] ?>">

			</div>	        		                			        		        	        		

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="total_days" name="total_days" placeholder="Total Days" title="Total Days" disabled>

			</div>	
		</div>
		<div class="row mg_tp_10">

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="total_adult" name="total_adult" value="0" placeholder="Total Adult" title="Total Adult" onchange="total_passangers_calculate(); validate_balance(this.id)" required>
			</div>

			<div class="col-md-4 col-sm-6 col-xs-12">

				<input type="text" id="total_infant" name="total_infant" value="0" placeholder="Total Infant" title="Total Infant" onchange="total_passangers_calculate(); validate_balance(this.id);" required>

			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" class="form-control" id="children_without_bed" name="children_without_bed" onchange="validate_balance(this.id);total_passangers_calculate();" placeholder="Child Without Bed" title="Child Without Bed" required>
			</div>
		</div>
		<div class="row mg_tp_10">	

			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" class="form-control" id="children_with_bed" name="children_with_bed" onchange="validate_balance(this.id);total_passangers_calculate();" placeholder="Child With Bed" title="Child With Bed" required> 
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" id="total_passangers" name="total_passangers" value="0" placeholder="Total Members" title="Total Members" disabled>
			</div>
		</div>
		<div class="row mg_tp_10">	
			<div class="col-md-4 col-sm-6 col-xs-12">
				<input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" value="<?= date('d-m-Y')?>" > 
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

$("#customer_name").autocomplete({
    source: JSON.parse($('#cust_data').val()),
    select: function (event, ui) {
	  $("#customer_name").val(ui.item.label);
    $('#mobile_no').val(ui.item.contact_no);
    $('#email_id').val(ui.item.email_id);
    },
    open: function(event, ui) {
		$(this).autocomplete("widget").css({
            "width": document.getElementById("customer_name").offsetWidth
        });
    }
}).data("ui-autocomplete")._renderItem = function(ul, item) {
      return $("<li disabled>")
        .append("<a>" + item.label +"</a>")
        .appendTo(ul);
	
};

// New Customization ----start
$(document).ready(function(){
	let searchParams = new URLSearchParams(window.location.search);
	if( searchParams.get('enquiry_id') ){
		$('#enquiry_id').val(searchParams.get('enquiry_id'));
		$('#enquiry_id').trigger('change');
	}
});
// New Customization ----end
$('#frm_tab1').validate({

	rules:{
		enquiry_id : { required : true },
	},
	submitHandler:function(form){
		$('#tab1_head').addClass('done');
		$('#tab2_head').addClass('active');
		$('.bk_tab').removeClass('active');
		$('#tab2').addClass('active');
		$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}
});
</script>

