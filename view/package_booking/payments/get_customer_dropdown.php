<?php
include "../../../model/model.php";
$branch_admin_id = $_SESSION['branch_admin_id'];
$company_name = $_GET['company_name'];
$cust_type = $_GET['cust_type'];
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];

$query = "select * from customer_master where 1 ";
if($company_name != "") {
	$query .= " and company_name = '$company_name' "; 
}
if($cust_type != "") {
$query .= " and type = '$cust_type' "; 
}
if($branch_status=='yes' && $role!='Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
$query .=" and active_flag != 'Inactive'";
?>
<select name="customer_id_filter" id="customer_id_filter" onchange="customer_booking_dropdown_load('customer_id_filter', 'booking_id_filter')" class="form-control" title="Select Customer" style="width:100%">
	<option value="">Select Customer</option>
	<?php
		$sq_customer = mysql_query($query); 
		while($row_cust = mysql_fetch_assoc($sq_customer)){ ?>
			<option value="<?php echo $row_cust['customer_id']; ?>"><?php echo $row_cust['first_name'].' '.$row_cust['last_name']; ?></option>; 
	<?php 
	} ?>
</select>
<script>

	$('#customer_id_filter').select2();
</script>