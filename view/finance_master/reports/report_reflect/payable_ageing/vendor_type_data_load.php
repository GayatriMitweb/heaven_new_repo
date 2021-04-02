<?php
include "../../../../../model/model.php";

$vendor_type = $_POST['vendor_type'];
$offset = $_POST['offset'];
$vendor_type_id = $_POST['vendor_type_id'];

if($vendor_type=="Hotel Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="hotel_id<?= $offset ?>" id="hotel_id<?= $offset ?>" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Hotel</option>	
			<?php
		}
		else{
			$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_hotel['hotel_id'] ?>"><?= $sq_hotel['hotel_name'] ?></option>
			<?php
		}

		$sq_hotel = mysql_query("select * from hotel_master where active_flag!='Inactive' order by hotel_name");
		while($row_hotel = mysql_fetch_assoc($sq_hotel)){
			?>
			<option value="<?= $row_hotel['hotel_id'] ?>"><?= $row_hotel['hotel_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#hotel_id<?= $offset ?>').select2();
</script>
<?php
}
if($vendor_type=="Transport Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="transport_agency_id<?= $offset ?>" id="transport_agency_id<?= $offset ?>" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Transport Agency</option>
			<?php
		}
		else{
			$sq_transport = mysql_fetch_assoc(mysql_query("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));			
			?>
			<option value="<?= $sq_transport['transport_agency_id'] ?>"><?= $sq_transport['transport_agency_name'] ?></option>
			<?php
		}

		$sq_transport = mysql_query("select * from transport_agency_master where active_flag!='Inactive' order by transport_agency_name");
		while($row_transport = mysql_fetch_assoc($sq_transport)){
			?>
			<option value="<?= $row_transport['transport_agency_id'] ?>"><?= $row_transport['transport_agency_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#transport_agency_id<?= $offset ?>').select2();
</script>
<?php
}
if($vendor_type=="Car Rental Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from car_rental_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="DMC Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="dmc_id<?= $offset ?>" id="dmc_id<?= $offset ?>" title="Select DMC" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select DMC</option>
			<?php
		}
		else{
			$sq_dmc = mysql_fetch_assoc(mysql_query("select * from dmc_master where dmc_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_dmc['dmc_id'] ?>"><?= $sq_dmc['company_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_dmc = mysql_query("select * from dmc_master where active_flag!='Inactive' order by company_name");
			while($row_dmc = mysql_fetch_assoc($sq_dmc)){
				?>
				<option value="<?= $row_dmc['dmc_id'] ?>"><?= $row_dmc['company_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#dmc_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Visa Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from visa_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Passport Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from passport_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from passport_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Ticket Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Ticket Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Ticket Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from ticket_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Train Ticket Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Ticket Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Ticket Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from train_ticket_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Excursion Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Excursion Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Excursion supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from site_seeing_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Insurance Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Insurance Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Insurance Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from insuarance_vendor where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}

if($vendor_type=="Other Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			 
	<select name="vendor_id<?= $offset ?>" id="vendor_id<?= $offset ?>" title="Select Other Supplier" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Other Supplier</option>
			<?php
		}
		else{
			$sq_vendor = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_vendor['vendor_id'] ?>"><?= $sq_vendor['vendor_name'] ?></option>
			<?php
		}
		?>
		
		<?php 
			$sq_vendor = mysql_query("select * from other_vendors where active_flag!='Inactive' order by vendor_name");
			while($row_vendor = mysql_fetch_assoc($sq_vendor)){
				?>
				<option value="<?= $row_vendor['vendor_id'] ?>"><?= $row_vendor['vendor_name'] ?></option>
				<?php
			}
		?>
	</select>
</div>
<script>
$('#vendor_id<?= $offset ?>').select2();
</script>
<?php
}
if($vendor_type=="Cruise Vendor"){
?>
<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
	<select name="cruise_id<?= $offset ?>" id="cruise_id<?= $offset ?>" style="width:100%" onchange="report_reflect();">
		<?php 
		if($vendor_type_id==""){
			?>
			<option value="">Select Cruise</option>	
			<?php
		}
		else{
			$sq_cruise = mysql_fetch_assoc(mysql_query("select * from cruise_master where cruise_id='$vendor_type_id'"));
			?>
			<option value="<?= $sq_cruise['cruise_id'] ?>"><?= $sq_cruise['company_name'] ?></option>
			<?php
		}

		$sq_cruise = mysql_query("select * from cruise_master where active_flag!='Inactive' order by cruise_id");
		while($row_cruise = mysql_fetch_assoc($sq_cruise)){
			?>
			<option value="<?= $row_cruise['cruise_id'] ?>"><?= $row_cruise['company_name'] ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
$('#cruise_id<?= $offset ?>').select2();
</script>
<?php
}
?>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>