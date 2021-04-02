<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='tasks/index.php'"));
$branch_status = $sq['branch_status'];
$login_id = $_SESSION['login_id'];
?>
<?= begin_panel('Tasks Dashboard',91) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>" >
<div class="row text-right mg_bt_20"> <div class="col-md-12">
	<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#tasks_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Task</button>
</div> </div>

<div class="app_panel_content Filter-panel">
<div class="row">
	<?php if($role=='Admin' || $role=='Branch Admin') : ?>
	<div class="col-sm-4 mg_bt_10_sm_xs">
		<select name="emp_id_filter" id="emp_id_filter" onchange="tasks_list_reflect()" title="User">
			<option value="">User</option>
			<?php
                $query = "select * from emp_master where 1";
                if($branch_status=='yes' && $role=='Branch Admin'){
				    $query .= " and branch_id = '$branch_admin_id'";
				} 
				$query .= " order by first_name";
				$sq_employee = mysql_query($query);
              while($row_employee = mysql_fetch_assoc($sq_employee)){
                ?>
                <option value="<?= $row_employee['emp_id'] ?>"><?= $row_employee['first_name'].' '.$row_employee['last_name'] ?></option>
                <?php
              }
            ?>
		</select>
	</div>
	<?php endif; ?>
	<div class="col-sm-4 mg_bt_10_sm_xs">
		<input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" onchange="tasks_list_reflect()" title="From Date">
	</div>
	<div class="col-sm-4">
		<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" onchange="tasks_list_reflect()" title="To Date">
	</div>
</div>
</div>

<?php include_once('task_save_modal.php'); ?>

<div id="div_tasks_list" class="text-left"></div>
<div id="div_task_update_modal" class="text-left"></div>
<div id="div_task_status_modal" class="text-left"></div>
<div id="div_task_extra_note_modal" class="text-left"></div>
<div id="div_task_clone_modal" class="text-left"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ format:'d-m-Y', timepicker:false });
function tasks_list_reflect()
{
	var from_date_filter = $('#from_date_filter').val();
	var to_date_filter = $('#to_date_filter').val();
	var emp_id_filter = $('#emp_id_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('tasks_list_reflect.php', { from_date_filter : from_date_filter, to_date_filter : to_date_filter, emp_id_filter : emp_id_filter , branch_status : branch_status}, function(data){
		$('#div_tasks_list').html(data);
	});
}
tasks_list_reflect();

function tour_group_reflect(tour_id, tour_group_id)
{
	$.post('tour_group_reflect.php', { tour_id : tour_id }, function(data){
		$('#'+tour_group_id).html(data);
	});
}

function tasks_type_reference_reflect(task_type_id, form_id)
{
	var task_type = $('#'+task_type_id).val();
	
	if(task_type=="Other"){
		$('#'+form_id+' .booking_id').addClass('hidden');
		$('#'+form_id+' .enquiry_id').addClass('hidden');
		$('#'+form_id+' .tour_group_id').addClass('hidden');
	}
	if(task_type=="Group Tour"){
		$('#'+form_id+' .booking_id').addClass('hidden');
		$('#'+form_id+' .enquiry_id').addClass('hidden');
		$('#'+form_id+' .tour_group_id').removeClass('hidden');
	}
	if(task_type=="Package Tour"){
		$('#'+form_id+' .booking_id').removeClass('hidden');
		$('#'+form_id+' .enquiry_id').addClass('hidden');
		$('#'+form_id+' .tour_group_id').addClass('hidden');
	}
	if(task_type=="Enquiry"){
		$('#'+form_id+' .booking_id').addClass('hidden');
		$('#'+form_id+' .enquiry_id').removeClass('hidden');
		$('#'+form_id+' .tour_group_id').addClass('hidden');
	}
}
function whatsapp_send(task_name, due_date, assign_to,base_url){
	$.post(base_url+'controller/tasks/whatsapp_send.php',{task_name:task_name, due_date:due_date,assign_to:assign_to}, function(data){
		window.open(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>
