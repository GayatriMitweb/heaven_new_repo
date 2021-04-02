<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$cust_type = $_POST['cust_type']; 
$role = $_SESSION['role']; 
if($cust_type == 'Corporate')
{
?>
<select name="company_filter" style="width: 100%" id="company_filter" onchange="dynamic_customer_load('cust_type_filter',this.value);" title="Select Company">
	  <option value="">Company Name</option>
      <?php 
            if($role=='Admin') {
                  $sq_query = mysql_query("select distinct(company_name) from customer_master where type = 'Corporate' order by company_name");
                  while($row_query=mysql_fetch_assoc($sq_query)){ ?>
                        <option value="<?php echo $row_query['company_name']; ?>"><?php echo $row_query['company_name']; ?></option>
            <?php }  } 
            
      	if($branch_status=='yes' && $role!='Admin'){

                  $sq_query = mysql_query("select distinct(company_name) from customer_master where type = 'Corporate' and branch_admin_id='$branch_admin_id' order by company_name");
                  while($row_query=mysql_fetch_assoc($sq_query)){ ?>
                              <option value="<?php echo $row_query['company_name']; ?>"><?php echo $row_query['company_name']; ?></option>
            <?php   } 
                  }
            /*elseif($branch_status!='yes') {
                  $sq_query = mysql_query("select distinct(company_name) from customer_master where type = 'Corporate' order by company_name");
                  while($row_query=mysql_fetch_assoc($sq_query)){ ?>
                        <option value="<?php echo $row_query['company_name']; ?>"><?php echo $row_query['company_name']; ?></option>
            <?php }  } */
    
      ?>
</select>
<?php } 
else
{
	}?>
<script>
	 $('#company_filter').select2();
</script>
	<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>