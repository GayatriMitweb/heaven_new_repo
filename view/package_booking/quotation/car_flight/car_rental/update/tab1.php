<form id="frm_tab11_c">

	<div class="row">

		<input type="hidden" id="quotation_id1" name="quotation_id1" value="<?= $quotation_id ?>">


		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">
			<select name="enquiry_id1" title="Enquiry No" id="enquiry_id1" style="width:100%" onchange="get_enquiry_details('1')">
				<?php 
				$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$sq_quotation[enquiry_id]' and enquiry_type='Car Rental'"));
					?>
					<option value="<?= $sq_enq['enquiry_id'] ?>">Enq<?= $sq_enq['enquiry_id'] ?> : <?= $sq_enq['name'] ?></option>
					<?php
				if($role=='Admin'){
				    $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' order by enquiry_id desc");
				}	
				if($branch_status=='yes'){
					if($role=='Branch Admin'){
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
					elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){

						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Car Rental') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc");
					}
					else{
						$sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' and branch_admin_id='$branch_admin_id' order by enquiry_id desc");
					}
				}
				else{
					if($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
						$q = "select * from enquiry_master where enquiry_type in('Car Rental') and assigned_emp_id='$emp_id' and status!='Disabled' order by enquiry_id desc";
						$sq_enq = mysql_query($q);
					}
					else{
						 $sq_enq = mysql_query("select * from enquiry_master where enquiry_type in('Car Rental') and status!='Disabled' order by enquiry_id desc");
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
	      <input type="text" id="customer_name1" name="customer_name1" onchange="fname_validate(this.id)" placeholder="Customer Name" title="Customer Name" value="<?php echo $sq_quotation['customer_name'];?>" >
	    </div>

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="email_id1" name="email_id1" placeholder="Email ID" title="Email ID" onchange="validate_email(this.id)" value="<?= $sq_quotation['email_id'] ?>">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="mobile_no1" name="mobile_no1" onchange="mobile_validate(this.id)" placeholder="Mobile No" title="Mobile No" value="<?= $sq_quotation['mobile_no'] ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="total_pax1" name="total_pax1" placeholder="No Of Pax" onchange="validate_balance(this.id)" title="No Of Pax" value="<?php echo $sq_quotation['total_pax'];?>" >
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		  <select name="travel_type" id="travel_type" title="Travel Type" onchange="reflect_feilds1();get_car_cost();">
		  <?php if( $sq_quotation['travel_type']!=""){?>
		  		<option value="<?= $sq_quotation['travel_type'] ?>"><?= $sq_quotation['travel_type'] ?></option>
	            <option value="">Select Travel Type</option>
	            <option value="Local">Local</option>
	            <option value="Outstation">OutStation</option>
		  <?php }else{?>
			<option value="">Select Tour Type</option>
	            <option value="Local">Local</option>
	            <option value="Outstation">OutStation</option>
		  <?php } ?>
	        </select>
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
		  <select name="vehicle_name" id="vehicle_name" title="Vehicle Name" class="form-control" onchange="get_capacity();;get_car_cost();">
		  <?php if( $sq_quotation['vehicle_name']!=""){?>
		 		 <option value="<?= $sq_quotation['vehicle_name'] ?>"><?= $sq_quotation['vehicle_name'] ?></option>
                <option value="">*Select Vehicle</option>
                <?php
                    $sql = mysql_query("select * from b2b_transfer_master");
                    while($row = mysql_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php } }else{  ?>
					<option value="">*Select Vehicle</option>
                <?php
                    $sql = mysql_query("select * from b2b_transfer_master");
                    while($row = mysql_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php } } ?>
            </select>
	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="capacity" name="capacity"  placeholder="Capacity" title="Capacity"  value="<?= $sq_quotation['capacity'] ?>">
	    </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" class="form-control" id="local_places_to_visit" name="local_places_to_visit" placeholder="Route" onchange="validate_spaces(this.id)" title="Route" value="<?= $sq_quotation['local_places_to_visit'] ?>"> 
		  <select name="places_to_visit" id="places_to_visit" title="Route" class="form-control" onchange="get_car_cost();">
				<option value="<?= $sq_quotation['places_to_visit'] ?>"><?= $sq_quotation['places_to_visit'] ?></option>
				<option value="">Select Route</option>
					<?php
						$sql = mysql_query("select * from car_rental_tariff_entries where tour_type='Outstation'");
						while($row = mysql_fetch_assoc($sql)){ 
						?>
							<option value="<?= $row['route']?>"><?= $row['route']?></option>
					<?php }  ?>
			</select>
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="extra_km_cost" name="extra_km_cost" placeholder="Extra KM Cost" title="Extra KM Cost" value="<?= $sq_quotation['extra_km_cost'] ?>" onchange="validate_balance(this.id);get_basic_amount();">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" class="form-control" id="extra_hr_cost" name="extra_hr_cost" placeholder="Extra Hr Cost" title="Extra Hr Cost" value="<?= $sq_quotation['extra_hr_cost'] ?>" onchange="validate_balance(this.id);get_basic_amount();"> 
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="rate" name="rate"  placeholder="Rate" title="Rate" value="<?= $sq_quotation['rate'] ?>" >
	    </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="total_hr" name="total_hr"  placeholder="Total Hrs" title="Total Hrs" value="<?= $sq_quotation['total_hrs'] ?>" onchange=";validate_balance(this.id);get_basic_amount();">
	    </div>

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="total_km" name="total_km"  placeholder="Total Km" title="Total Km" value="<?= $sq_quotation['total_km'] ?>" onchange=";validate_balance(this.id);get_basic_amount();">
	    </div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date" name="from_date" placeholder="From Date" title="From Date" value="<?= get_date_user($sq_quotation['from_date'])?>" onchange="total_days_reflect()">
		</div>	

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="to_date" name="to_date" placeholder="To Date" title="To Date" value="<?= get_date_user($sq_quotation['to_date'])?>" onchange="total_days_reflect()">
	    </div>
	</div>
	<div class="row">  		            
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="total_max_km" name="total_max_km"  placeholder="Total Max Km" title="Total Max Km" onchange=";validate_balance(this.id);get_basic_amount();" value="<?= $sq_quotation['total_max_km']?>">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" id="traveling_date1" name="traveling_date1" placeholder="Travelling Date" title="Travelling Date" value="<?= get_date_user($sq_quotation['traveling_date']) ?>">
	    </div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	     <input type="text" id="days_of_traveling" name="days_of_traveling" onchange="validate_balance(this.id);get_basic_amount();" placeholder="Days Of Travelling" title="Days Of Travelling" value="<?= $sq_quotation['days_of_traveling']?>">
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	      <input type="text" class="form-control" id="quotation_date" name="quotation_date" placeholder="Quotation Date" title="Quotation Date" onchange="get_auto_values('quotation_date','subtotal','payment_mode','service_charge','markup_cost','update','true','basic', true);" value="<?= get_date_user($sq_quotation['quotation_date']) ?>"> 
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
$('#from_date,#to_date,#total_hr,#total_km,#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry,#other_charges,#local_places_to_visit,#places_to_visit,#traveling_date1').hide();

$('input').keyup(function(){	$(this).removeAttr('style');	});

$('#frm_tab11_c').validate({

	rules:{
		enquiry_id : { required : true },
		extra_km_cost	:	{	regex	:	/^[0-9\.]*$/	},
		extra_hr_cost	:	{	regex	:	/^[0-9\.]*$/	},
	},
	messages:{
		extra_km_cost	:	"Only Numbers Allowed",
		extra_hr_cost	:	"Only Numbers Allowed",
	},
	onkeyup: false,
	errorPlacement: function(error, element) {
		$(element).css({ border: '1px solid red' });
		$(element).val('');
		error_msg_alert(error[0].innerText);
	},

	submitHandler:function(form){

		$('a[href="#tab_2_c"]').tab('show');
	}

});
function reflect_feilds1(){
	
	var type = $('#travel_type').val();
	
	if(type=='Local'){
		$('#from_date,#to_date,#total_hr,#total_km,#local_places_to_visit').show();
		$('#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry,#other_charges,#places_to_visit,#traveling_date1').hide();
	}
	if(type=='Outstation'){
		$('#from_date,#to_date,#total_hr,#total_km,#local_places_to_visit').hide();
		$('#total_max_km,#driver_allowance1,#permit1,#toll_parking1,#state_entry,#other_charges,#places_to_visit,#traveling_date1').show();
	}
}reflect_feilds1();
function get_basic_amount(){
	
	var travel_type = $('#travel_type').val();
	var capacity = $('#capacity').val();
	var rate = $('#rate').val();
	var days_of_traveling = $('#days_of_traveling').val();
	var total_pax = $('#total_pax1').val();
	if(capacity==""){ capacity = 0;}
	if(rate==""){ rate = 0;}
	if(days_of_traveling==""){ days_of_traveling = 0;}
	if(total_pax==""){ total_pax = 0;}
	var no_of_vehicle = Math.ceil(parseFloat(total_pax)/parseFloat(capacity)); 
	
	var basic_amount = parseFloat(rate)*parseFloat(days_of_traveling)*parseFloat(no_of_vehicle);
	
	$('#subtotal').val(basic_amount.toFixed(2));
	// $('#total_tour_cost').val(basic_amount.toFixed(2));
	quotation_cost_calculate1();
}
function total_days_reflect(offset=''){
    var from_date = $('#from_date'+offset).val(); 
    var to_date = $('#to_date'+offset).val(); 

    var edate = from_date.split("-");
    e_date = new Date(edate[2],edate[1]-1,edate[0]).getTime();
    var edate1 = to_date.split("-");
    e_date1 = new Date(edate1[2],edate1[1]-1,edate1[0]).getTime();

    var one_day=1000*60*60*24;

    var from_date_ms = new Date(e_date).getTime();
    var to_date_ms = new Date(e_date1).getTime();
    
    var difference_ms = to_date_ms - from_date_ms;
    var total_days = Math.round(Math.abs(difference_ms)/one_day); 

	total_days = parseFloat(total_days)+1;
	
    $('#days_of_traveling'+offset).val(total_days);
}
function get_capacity(){

	var vehicle_name = $('#vehicle_name').val();
	var travel_type = $('#travel_type').val();
	var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url+'view/package_booking/quotation/car_flight/car_rental/get_capacity.php', 
		
		data: { travel_type : travel_type,vehicle_name:vehicle_name },
		success: function(result){
			
			$('#capacity').val(result);
		quotation_cost_calculate1();
		}
	});
}

</script>

