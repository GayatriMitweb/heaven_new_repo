<?php 
include "../../model/model.php";
$cust_type = $_POST['cust_type'];
$customer_id = $_POST['customer_id'];

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
if($cust_type == 'Corporate' || $cust_type == 'B2B') {
?>
	 <div class="col-sm-4 col-xs-12 mg_bt_10">
		<input type="text" id="corpo_company_name" name="corpo_company_name" onchange="validate_alphanumeric(this.id)" placeholder="*Company Name" value="<?= $sq_customer['company_name'] ?>" title="Company Name" required>
	 </div>
	 <div class="col-sm-4 col-xs-12 mg_bt_10">
	 	<input type="text" id="cust_landline_no" name="cust_landline_no" onchange="mobile_validate(this.id)" placeholder="Landline No" value="<?= $sq_customer['landline_no'] ?>" title="Landline No">
	 </div>
	 <div class="col-sm-4 col-xs-12 mg_bt_10">
	 	<input type="text" id="cust_alt_email_id" name="cust_alt_email_id" placeholder="Alternate Email id (E.g. abc@gmail.com)" value="<?= $sq_customer['alt_email'] ?>" title="Alternate Email id" onchange="validate_email(this.id)">
	 </div>
<?php }
else
{

}
 ?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>