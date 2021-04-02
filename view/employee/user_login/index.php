<?php
include "../../../model/model.php";
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='employee/user_login/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('User Log',93) ?>
 <div class="col-sm-12 text-right text_left_sm_xs">
 	<?php if($role=='Admin' || $role=='Branch Admin' || $role=='Hr'){ ?>
      <button class="btn btn-excel btn-sm mg_bt_10" onclick="view_logged_in_users()" data-toggle="tooltip" title="View Current Logged In Users"><i class="fa fa-eye"></i></button>&nbsp;&nbsp;
      <button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
    <?php } ?>
  </div>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
	 	<div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">
	    </div> 
	    <div class="col-md-3 col-sm-6 mg_bt_10_xs">
	        <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
	    </div>
	    <div class="col-md-3 col-sm-6 mg_bt_10_xs">
			<select name="login_id11" style="width: 100%" id="login_id11">
				<option value="">User</option>
				<?php
					if($role=='Admin'){
					$query = "select * from emp_master where active_flag='Active' order by first_name desc";
					$sq_emp = mysql_query($query);
					while($row_emp = mysql_fetch_assoc($sq_emp)){
							?>
							<option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
							<?php
						}
					}
				 elseif($branch_status!='yes' && ($role=='Branch Admin' || $role=='Hr')){
						$query = "select * from emp_master where active_flag='Active' order by first_name desc";
						$sq_emp = mysql_query($query);
						while($row_emp = mysql_fetch_assoc($sq_emp)){
								?>
								<option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
								<?php
							}
				 }
				 elseif($branch_status=='yes' && ($role=='Branch Admin' || $role=='Hr')){
					$query = "select * from emp_master where active_flag='Active' and branch_id='$branch_admin_id' order by first_name asc";
					$sq_emp = mysql_query($query);
					while($row_emp = mysql_fetch_assoc($sq_emp)){
							?>
							<option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
							<?php
						}
				 }
				 else{
				 $query1 = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id' and active_flag='Active'")); ?>
				<option value="<?= $query1['emp_id'] ?>"><?= $query1['first_name'].' '.$query1['last_name'] ?>
							</option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6">
				<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
			</div>
	</div>
</div>

<div id="div_content1"></div>
<div id="div_content" class="main_block loader_parent"></div>
<?= end_panel() ?>
<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#login_id11').select2();

function list_reflect()
{
	$('#div_content').append('<div class="loader"></div>');
	var login_id = $('#login_id11').val();
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('list_reflect.php', { login_id : login_id, from_date : from_date, to_date : to_date, branch_status : branch_status }, function(data){
		$('#div_content').html(data);
	});
}
list_reflect();

function excel_report()
{
	var login_id = $('#login_id11').val();
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
    window.location = 'excel_report.php?login_id='+login_id+'&from_date='+from_date+'&to_date='+to_date+'&branch_status='+branch_status;
}
function view_logged_in_users(){
	$.post('display_current_log.php', {}, function(data){
      $('#div_content1').html(data);
    });
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>