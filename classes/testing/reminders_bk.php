<script>
//**Task reminder
function task_reminder_scheduler()
{
	var base_url = $('#base_url').val();

	$.post(base_url+'controller/tasks/tasks_reminder_scheduler.php', { }, function(data){
	});
}
setInterval(task_reminder_scheduler, 5000*60);

function checklist_remider_scheduler()
{
	var base_url = $('#base_url').val();

	$.post(base_url+'controller/checklist/checklist_remider_scheduler.php', { }, function(data){
	});
}
setInterval(checklist_remider_scheduler, 5000*60*60*24);

//**Followup and birthday remider
function followup_and_birthday_reminder()
{
	var base_url = $('#base_url').val();

	$.post(base_url+'controller/app_settings/followup_and_birthday_reminder.php', { }, function(data){
	});
}
setInterval(followup_and_birthday_reminder, 60000*60);

function checklist_pending_email()
{
	var base_url = $('#base_url').val();
	$.post(base_url+'controller/checklist/checklist_pending_email.php', { }, function(data){
	});
}
checklist_pending_email();

function happy_journey_tour_mail()
{
	var base_url = $('#base_url').val();
	$.post(base_url+'controller/happy_journey_tour_mail/mail_while_tour.php', { }, function(data){
	});
}
happy_journey_tour_mail();

function happy_baddy_wish()
{
	var base_url = $('#base_url').val();
	$.post(base_url+'controller/baddy_email_employee_cust.php', { }, function(data){
	});
}
happy_baddy_wish();
</script>