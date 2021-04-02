<?php
include_once('../../model/model.php');
include_once('app_functions.php');

$_SESSION['reminder_status'] = "true";
$today = date('Y-m-d');
$day = date("D", strtotime($today));

$sq_b2b = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='b2b_credit_payment_overdue' and date='$today'"));
//Inventory
$sq_hotel_inv = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='hotel_inventory' and date='$today'"));
$sq_exc_inv = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='excursion_inventory' and date='$today'"));

$sq_birt_re = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='emp_birthday' and remainder_name='cust_birthday' and date='$today'"));

$sq_hap_jou = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='git_happy_journey' and remainder_name='fit_happy_journey' and date='$today'"));

$sq_chk_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='checklist_git_pending_remainder' and remainder_name='checklist_fit_pending_remainder' and date='$today'"));

$sq_grp_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='git_payment_pending_remainder' and date='$today'"));

$sq_fit_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='fit_payment_pending_remainder'  and date='$today'"));

$sq_visa_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='visa_payment_pending_remainder'  and date='$today'"));

$sq_passport_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='passport_payment_pending_remainder'  and date='$today'"));

$sq_air_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='air_payment_pending_remainder'  and date='$today'"));
$sq_misc_pay = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='misc_payment_pending_remainder'  and date='$today'"));

$sq_exc_pen = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='excursion_payment_pending_remainder' and date='$today'"));

$sq_train = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='train_payment_pending_remainder'  and date='$today'"));

$sq_hotel= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='hotel_payment_pending_remainder'  and date='$today'"));

$sq_car= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='car_payment_pending_remainder'  and date='$today'"));

$sq_vendor= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='vendor_payment_pending_remainder'  and date='$today'"));

$sq_git_fed= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='git_feedback_remainder' and date='$today'"));

$sq_fit_fed= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='fit_feedback_remainder' and date='$today'"));

$sq_hotel_tarrif= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='hotel_tarrif_remainder' and date='$today'"));

$sq_emp_anni= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='emp_anniversary' and date='$today'"));

$sq_user_visa= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='user_visa_renewal' and date='$today'"));

$sq_topup= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='topup_recharge_remainder' and date='$today'"));

$sq_visa_topup= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='visa_topup_recharge_remainder' and date='$today'"));

$sq_tax_pay= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='tax_pay_raminder' and date='$today'"));

$sq_cust_passport= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='customer_passport_renewal' and date='$today'"));

$sq_cust_feedback= mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='customer_feedback' and date='$today'"));

$sq_cust_fit_feedback = mysql_num_rows(mysql_query("select * from remainder_status where remainder_name='fit_customer_feedback' and date='$today'"));
?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <title><?= $app_name ?> Reminders</title>

  <meta name="description" content="The HTML5 Herald">

  <meta name="author" content="SitePoint">



  <?php admin_header_scripts(); ?>



</head>



<body>

	<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">
	<input type="hidden" id="sq_b2b" name="sq_b2b" value="<?= $sq_b2b ?>">
	<input type="hidden" id="sq_hotel_inv" name="sq_hotel_inv" value="<?= $sq_hotel_inv ?>">
	<input type="hidden" id="sq_exc_inv" name="sq_exc_inv" value="<?= $sq_exc_inv ?>">

	<input type="hidden" id="bday_mail" name="bday_mail" value="<?= $sq_birt_re ?>">

	<input type="hidden" id="journey_mail" name="journey_mail" value="<?= $sq_hap_jou ?>">

	<input type="hidden" id="checklist_pending" name="checklist_pending" value="<?= $sq_chk_pen ?>">

	<input type="hidden" id="git_pay_pen" name="git_pay_pen" value="<?= $sq_grp_pen ?>">

	<input type="hidden" id="fit_pay_pen" name="fit_pay_pen" value="<?= $sq_fit_pen ?>">

	<input type="hidden" id="visa_pay_pen" name="visa_pay_pen" value="<?= $sq_visa_pen ?>">

	<input type="hidden" id="passport_pay_pen" name="passport_pay_pen" value="<?= $sq_passport_pen ?>">

	<input type="hidden" id="air_pay_pen" name="air_pay_pen" value="<?= $sq_air_pen ?>">

	<input type="hidden" id="exc_pay_pen" name="exc_pay_pen" value="<?= $sq_exc_pen ?>">
	<input type="hidden" id="misc_pay_rem" name="misc_pay_rem" value="<?= $sq_misc_pay ?>">

	<input type="hidden" id="train_pay_pen" name="train_pay_pen" value="<?= $sq_train  ?>">

	<input type="hidden" id="hotel_pay_pen" name="hotel_pay_pen" value="<?= $sq_hotel ?>">

	<input type="hidden" id="car_pay_pen" name="car_pay_pen" value="<?= $sq_car ?>">

	<input type="hidden" id="vendor_pay_pen" name="vendor_pay_pen" value="<?= $sq_vendor ?>">

	<input type="hidden" id="git_fed" name="git_fed" value="<?= $sq_git_fed ?>">

	<input type="hidden" id="fit_fed" name="fit_fed" value="<?= $sq_fit_fed ?>">

	<input type="hidden" id="day" name="day" value="<?= $day ?>">

	<input type="hidden" id="hotel_tarrif" name="hotel_tarrif" value="<?= $sq_hotel_tarrif ?>">

	<input type="hidden" id="emp_anni" name="emp_anni" value="<?= $sq_emp_anni ?>">
	<input type="hidden" id="user_visa" name="user_visa" value="<?= $sq_user_visa ?>">
	<input type="hidden" id="top_up" name="top_up" value="<?= $sq_topup ?>">
	<input type="hidden" id="visa_top_up" name="visa_top_up" value="<?= $sq_visa_topup ?>">
	<input type="hidden" id="tax_pay" name="tax_pay" value="<?= $sq_tax_pay ?>">
	<input type="hidden" id="cust_passort" name="cust_passort" value="<?= $sq_cust_passport ?>">
	<input type="hidden" id="cust_feedback" name="cust_feedback" value="<?= $sq_cust_feedback ?>">
	<input type="hidden" id="cust_fit_feedback" name="cust_feedback" value="<?= $sq_cust_fit_feedback ?>">
	<script>
		//B2B outstanding overdue reminder
		var sq_b2b = $('#sq_b2b').val();
		if(sq_b2b==0){
			function b2b_poverdue(){
				var base_url = $('#base_url').val();
				$.post(base_url+'model/remainders/b2b_payment_overdue.php', {}, function(data){
				});
			}
			b2b_poverdue();
		}
		//Inventory Expiry reminder
		var sq_hotel = $('#sq_hotel_inv').val();
		if(sq_hotel==0){
			function hotel_invetory(){
				var base_url = $('#base_url').val();
				var type = 'hotel';
				$.post(base_url+'model/remainders/invetory_reminder_admin.php', {type : type}, function(data){
				});
			}
			hotel_invetory();
		}
		var sq_exc = $('#sq_exc_inv').val();
		if(sq_exc==0){
			function exc_invetory(){
				var base_url = $('#base_url').val();
				var type = 'excursion';
				$.post(base_url+'model/remainders/invetory_reminder_admin.php', {type:type }, function(data){
				});
			}
			exc_invetory();
		}

		//**Task reminder

		function task_reminder_scheduler()

		{
			var base_url = $('#base_url').val();	
			$.post(base_url+'model/remainders/task_reminder.php', { }, function(data){
			});

		}

		 setInterval(task_reminder_scheduler,1000); //1 min


		function checklist_remider_scheduler()
		{
			var base_url = $('#base_url').val();
			$.post(base_url+'model/remainders/checklist_remider_scheduler.php', { }, function(data){
 
			});
		}
		checklist_remider_scheduler();

		//**Followup and birthday remider

		function followup_and_birthday_reminder()
		{
			var base_url = $('#base_url').val();
			$.post(base_url+'model/remainders/followup_and_birthday_reminder.php', { }, function(data){
				alert(data);
			});
		}
	    // setInterval(followup_and_birthday_reminder, 60000*60);

		followup_and_birthday_reminder();
		var chk_status = $('#checklist_pending').val();
		if(chk_status==0){

		function checklist_pending_email(){

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/checklist_pending_mail.php', { }, function(data){
			});

		}
	 	checklist_pending_email();
	 	}



	 	var journey_status = $('#journey_mail').val();

		if(journey_status==0){

		function happy_journey_tour_mail()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/mail_while_tour.php', { }, function(data){

			});
		}

		happy_journey_tour_mail();

	}



		var bday_status = $('#bday_mail').val();
		if(bday_status==0){

			function happy_baddy_wish()
			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/baddy_email_employee_cust.php', { }, function(data){

				});

			}

			 happy_baddy_wish();

		}

		// Topup recharge
		var toup_status = $('#top_up').val();

		if(toup_status==0){

			function topup_recharge_remainder()

			{
				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/topup_remiander_mail.php', { }, function(data){
						 
				});

			}

			topup_recharge_remainder();

		}

		// Topup recharge
		var visa_toup_status = $('#visa_top_up').val();

		if(visa_toup_status==0){

			function visa_topup_recharge_remainder()

			{
				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/visa_topup_remiander_mail.php', { }, function(data){
				});

			}

			visa_topup_recharge_remainder();

		}

		var git_status = $('#git_pay_pen').val();

		if(git_status==0){

		function git_payment_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/payment_remainders.php', { }, function(data){

			});

		}

		git_payment_remainder();

	}



		var fit_status = $('#fit_pay_pen').val();

			if(fit_status==0){

			function fit_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/fit_payment_remainder.php', { }, function(data){

				});

			}

			fit_payment_remainder();

		}



		var visa_status = $('#visa_pay_pen').val();

			if(visa_status==0){

			function visa_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/visa_payment_remainder.php', { }, function(data){

				});

			}

			visa_payment_remainder();

		}



		var passport_status = $('#passport_pay_pen').val();

			if(passport_status==0){

			function passport_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/passport_payment_remainder.php', { }, function(data){

				});

			}

			 

			passport_payment_remainder();

		}





		var air_status = $('#air_pay_pen').val();

			if(air_status==0){

			function air_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/air_payment_remainder.php', { }, function(data){

				});

			}

			 air_payment_remainder();

		 }
		 var air_status1 = $('#exc_pay_pen').val();
			if(air_status1==0){
		

			function excursion_payment_remainder()

			{
				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/excursion_payment_reminder.php', { }, function(data){
				});

			}

			 excursion_payment_remainder();

		 }
		
		 var miscp_status = $('#misc_pay_rem').val();

			if(miscp_status==0){

			function misc_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/misc_payment_reminder.php', { }, function(data){

				});

			}

			misc_payment_remainder();

		 }

		var train_status = $('#train_pay_pen').val();

			if(train_status==0){

			function train_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/train_payment_remainder.php', { }, function(data){

				});

			}

			 train_payment_remainder();

		}

		

		var hotel_status = $('#hotel_pay_pen').val();

			if(hotel_status==0){

			function hotel_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/hotel_payment_remainder.php', { }, function(data){
// alert(data);
				});

			}

			hotel_payment_remainder();

		}



		var car_status = $('#car_pay_pen').val();

			if(car_status==0){

			function car_payment_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/car_rental_pay_rem.php', { }, function(data){

				});

			}

			car_payment_remainder();

		}



		var vendor_status = $('#vendor_pay_pen').val();

		if(vendor_status==0){

		function vendor_payment_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/vendor_payment_remainder.php', { }, function(data){

			});

		}

		vendor_payment_remainder();

	  }





	  	var git_fed = $('#git_fed').val();

		if(git_fed==0){

			function tour_feedback_remainder()

			{

				var base_url = $('#base_url').val();

				$.post(base_url+'model/remainders/git_feedback_mail.php', { }, function(data){

				});

			}

			tour_feedback_remainder();
		} 

		var fit_fed = $('#fit_fed').val();

		if(fit_fed==0){
			function package_feedback_remainder()
			{
				var base_url = $('#base_url').val();
				$.post(base_url+'model/remainders/fit_feedback_mail.php', { }, function(data){
				});
			}
			package_feedback_remainder();

		}


		var day = $('#day').val();

		if(day=='Sat'){
			function weekly_summary_report()
			{
				var base_url = $('#base_url').val();
				$.post(base_url+'model/remainders/weekly_summary_report.php', { }, function(data){

				});
			}
			weekly_summary_report();
	    } 


		function tour_visit_vendor_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/tour_visit_vendor_remainder.php', { }, function(data){

			});

		}
		tour_visit_vendor_remainder(); 



		function app_settings_remainder()
		{
			var base_url = $('#base_url').val();
			$.post(base_url+'model/remainders/app_settings_remainder.php', { }, function(data){
			});
		}
		app_settings_remainder();


		var tarrif_status = $('#hotel_tarrif').val();

			if(tarrif_status==0){

		function hotel_tarrif_remainder()
		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/hotel_tarrif_reminder.php', { }, function(data){

			});

		}

		hotel_tarrif_remainder();

	}



	    var emp_anni = $('#emp_anni').val();

			if(emp_anni==0){

		function emp_ani_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/emp_anniversary_reminder.php', { }, function(data){

			});

		}

		emp_ani_remainder();

	}

	var user_visa = $('#user_visa').val();

			if(user_visa==0){

		function user_visa_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/user_visa.php', { }, function(data){
				// alert(data);
			});

		}

		user_visa_remainder();

	}

	var tax_pay = $('#tax_pay').val();

			if(tax_pay==0){

		function tax_pay_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/tax_pay.php', { }, function(data){
//  alert(data);
			});

		}

		tax_pay_remainder();

	}
	var cust_passort = $('#cust_passort').val();

	if(cust_passort==0){

		function cust_passport_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/customer_passport_renewal.php', { }, function(data){	
						
			});

		}

		cust_passport_remainder();

	}

	var cust_feedback = $('#cust_feedback').val();

	if(cust_feedback==0){

		function cust_git_feedback_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/customer_feedback.php', { }, function(data){	
			 			
			});

		}

		cust_git_feedback_remainder();

	}

	var cust_fit_feedback = $('#cust_fit_feedback').val();

	if(cust_fit_feedback==0){

		function cust_fit_feedback_remainder()

		{

			var base_url = $('#base_url').val();

			$.post(base_url+'model/remainders/fit_customer_feedback.php', { }, function(data){	
			 	 		
			});

		}

		cust_fit_feedback_remainder();

	}
	</script>

</body>

</html>