<?php
include('../../../../model/model.php');
$cust_id = $_POST['customer_id'];
$sq_cust = mysql_fetch_array(mysql_query("Select * from customer_master  where customer_id='$cust_id'"));
?>
<div class="col-md-4">
	<input type="text" id="cust_email" name="cust_email" class="form-control"  placeholder="Email" title="Email" value="<?= $sq_cust['email_id'];?>" disabled>
</div>	  
<div class="col-md-4">
	<input type="text" name="cust_cont" id="cust_cont" class="form-control"  placeholder="Contact No." title="Contact No." value="<?= $sq_cust['contact_no']?>" disabled>
</div>	

