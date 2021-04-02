<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='miscellaneous/index.php'"));
$branch_status = $sq['branch_status'];

?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Miscellaneous Booking',60) ?>
      <div class="header_bottom">
        <div class="row text-center text_left_sm_xs">
			<label for="rd_visa_home" class="app_dual_button active mg_bt_10">
		        <input type="radio" id="rd_visa_home" name="rd_visa" checked onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Booking
		    </label>    
		    <label for="rd_visa_payment" class="app_dual_button mg_bt_10">
		        <input type="radio" id="rd_visa_payment" name="rd_visa" onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_visa_report" class="app_dual_button mg_bt_10">
		        <input type="radio" id="rd_visa_report" name="rd_visa" onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		    <!-- <label for="rd_payment_status" class="app_dual_button mg_bt_10">
		        <input type="radio" id="rd_payment_status" name="rd_visa" onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Summary
		    </label> -->
		</div>
      </div> 

  <!--=======Header panel end======-->

<div class="app_panel_content">

<div id="div_visa_content"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
function visa_content_reflect()
{
	var branch_status = $('#branch_status').val();
	var id = $('input[name="rd_visa"]:checked').attr('id');
	if(id=="rd_visa_home"){
		$.post('home/index.php', {branch_status : branch_status}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_visa_payment"){
		$.post('payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_visa_report"){
		$.post('report/index.php', {branch_status : branch_status}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_payment_status"){
		$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
			$('#div_visa_content').html(data);
		});
	}
}
visa_content_reflect();
</script>
<script src="js/visa.js"></script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>