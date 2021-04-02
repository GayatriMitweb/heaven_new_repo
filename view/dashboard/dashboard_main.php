<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
require_once('../../classes/tour_booked_seats.php');

$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$login_id = $_SESSION['login_id'];
$reminder_status = (isset($_SESSION['reminder_status'])) ? "true" : "false";
?>
<input type="hidden" id="role" name="role" value="<?= $role ?>">
<input type="hidden" id="login_id" name="login_id" value="<?= $login_id ?>">
<input type="hidden" id="reminder_status" name="reminder_status" value="<?= $reminder_status ?>">
<?php
if($role=="Admin"){
	include_once('admin/index.php');
}
if($role=="Sales"){
	include_once('sales/index.php');
}
if($role=="Backoffice"){
	include_once('backoffice/index.php');
}
if($role=="B2b"){
	include_once('agent/index.php');
}
if($role=="Branch Admin" || $role=="Accountant" || $role=="Hr"){
	include_once('branch_admin/index.php');
}
if($role_id > '7'){
	include_once('other/index.php');
}
?>
<script>

(function(){

	var role = $('#role').val();
	var login_id = $('#login_id').val();
	var reminder_status = $('#reminder_status').val();
	var status = false;

		if(localStorage.getItem("reminder") == "true"){		// Used local storage for maintaining confirm box
			status = confirm('Do you want to run reminders?');
		}
		
		if(status){
			localStorage.setItem("reminder", false);
			var url = '<?= BASE_URL ?>view/layouts/reminders_home.php'			
			window.open(url, '_blank', 'toolbar=0,location=0,menubar=0');
		}
		else{
			localStorage.setItem("reminder", false);
		}
})();

</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>