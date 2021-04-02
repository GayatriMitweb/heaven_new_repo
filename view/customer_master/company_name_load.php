<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$cust_type = $_POST['cust_type']; 
$branch_status = $_POST['branch_status'];
if($cust_type == 'Corporate')
{
?>
<select name="company_filter" id="company_filter" onchange="customer_list_reflect();" title="Select Company">
	  <option value="">Company Name</option>
    <?php 

		if($branch_status=='yes' && $role=='Branch Admin'){

	      	$sq_query = mysql_query("select distinct(company_name) from customer_master where type = 'Corporate' and branch_admin_id='$branch_admin_id' order by company_name");
	      	while($row_query=mysql_fetch_assoc($sq_query)){ ?>
	      		<option value="<?php echo $row_query['company_name']; ?>"><?php echo $row_query['company_name']; ?></option>
	<?php   } 
	   	}
    	else {
      	$sq_query = mysql_query("select distinct(company_name) from customer_master where type = 'Corporate' order by company_name");
      	while($row_query=mysql_fetch_assoc($sq_query)){ ?>
      		<option value="<?php echo $row_query['company_name']; ?>"><?php echo $row_query['company_name']; ?></option>
      <?php	}  } 
    }
      ?>
</select>
 

	<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>