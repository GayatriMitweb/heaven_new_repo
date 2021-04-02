<?php
include "../../../../model/model.php";

$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id = '$enquiry_id'"));

$enquiry_type = $sq_enq['enquiry_type'];
if($enquiry_type == 'Package Booking' or $enquiry_type == 'Group Booking'){ 
		 include_once('../home/save/group_package_quotation.php');
 }
if($enquiry_type == 'Visa' or $enquiry_type == 'Passport'){ 
		 include_once('../home/save/visa_passport_quotation.php');

}
if($enquiry_type == 'Air Ticket' or $enquiry_type == 'Train Ticket'){ 
}
?>
<script>
	$('#enquiry_id, #currency_code').select2();
	$('#from_date, #to_date, #quotation_date, #train_arrival_date,#train_departure_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
	$('#txt_arrval1,#txt_dapart1').datetimepicker({ format:'d-m-Y H:i:s' });
	$('#quotation_save_modal').modal('show');
</script>

<script src="../js/quotation.js"></script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>