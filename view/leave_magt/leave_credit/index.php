<?php
include "../../../model/model.php";
/*======******Header******=======*/
$role_id = $_SESSION['role_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='leave_magt/index.php'"));
$branch_status = $sq['branch_status'];
$emp_id = $_SESSION['emp_id']; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<input type="hidden" name="branch_status2" id="branch_status2" value="<?= $branch_status ?>">
<div class="row mg_bt_20">
  <div class="col-sm-12 text-right text_left_sm_xs">
      <button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
      <?php if($role_id=="1" || $role_id=="5"){ ?>
      <button class="btn btn-info btn-sm ico_left" onclick="credit_save_modal()"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;New credit</button>
      <?php } ?>
  </div>
</div>

 <div class="app_panel_content Filter-panel">
  <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs col-md-offset-4">
        <select name="emp_id_filter" id="emp_id_filter"  class="form-control" style="width: 100%;" title="User Name" title="User Name" onchange="list_reflect()">
          <option value="">Select User</option>
          <?php if($role=='Admin' || ($branch_status!='yes' && $role=='Branch Admin') || ($branch_status!='yes' && $role=='Hr') || ($branch_status!='yes' && $role=='Accountant')){
                    $query = "select * from emp_master where active_flag='Active' order by first_name desc";
                  $sq_emp = mysql_query($query);
                  while($row_emp = mysql_fetch_assoc($sq_emp)){
                      ?>
                      <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                      <?php
                    }
                  }
                  elseif($branch_status=='yes' && ($role=='Branch Admin' || $role=='Hr' || $role=='Accountant')){
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

                  <?php
                  }
                  ?>
        </select>
      </div>
  </div>
</div>  
<div id="div_list"></div>
<div id="div_modal"></div>
 
<script>
 $('#emp_id_filter').select2();
function list_reflect()
{
  var emp_id = $('#emp_id_filter').val();
  var branch_status = $('#branch_status2').val();
 
	$.post('leave_credit/list_reflect.php',{ emp_id : emp_id,branch_status: branch_status }, function(data){
		$('#div_list').html(data);
	});
}
 list_reflect();
function credit_save_modal()

{
 
  $('#btn_save_modal').button('loading');

  $.post('leave_credit/save_modal.php', {}, function(data){

    $('#btn_save_modal').button('reset');

    $('#div_modal').html(data);

  });

} 
function update_modal(emp_id)
{
  $.post('leave_credit/update_modal.php', { emp_id : emp_id }, function(data){
    $('#div_modal').html(data);
  })
}

function excel_report()
{
    var emp_id = $('#emp_id_filter').val();
    var branch_status = $('#branch_status2').val();
    window.location = 'leave_credit/excel_report.php?emp_id='+emp_id+'&branch_status='+branch_status;
}

</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
 