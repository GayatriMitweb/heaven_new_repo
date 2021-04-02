<?php
include "../../../model/model.php";
/*======******Header******=======*/
 
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='leave_magt/index.php'"));
$branch_status = $sq['branch_status'];
$emp_id = $_SESSION['emp_id']; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
 
 <div class="app_panel_content Filter-panel">

  <div class="row">

  <input type="hidden" name="branch_status2" id="branch_status2" value="<?= $branch_status ?>">
      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

        <select name="emp_id" id="emp_id1"  class="form-control" style="width: 100%;" title="User Name" title="User Name">

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

      <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

        <input type="text" id="from_date_filter" name="from_date_filter" class="form-control" placeholder="From Date" title="From Date">

      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">

        <input type="text" id="to_date_filter" name="to_date_filter" class="form-control" placeholder="To Date" title="To Date" >

      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">

        <button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

      </div>


  </div>

</div>  

<div id="div_list"></div>
<div id="div_modal"></div>
 
<script>
$('#from_date_filter,#to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
 $('#emp_id1').select2();
 function total_days_reflect()
{
    var from_date = $('#from_date_filter').val(); 
    var to_date = $('#to_date_filter').val(); 
    var parts = from_date.split('-');
    var date = new Date();
    var new_month = parseInt(parts[1])-1;
    date.setFullYear(parts[2]);
    date.setDate(parts[0]);
    date.setMonth(new_month);

    var parts1 = to_date.split('-');
    var date1 = new Date();
    var new_month1 = parseInt(parts1[1])-1;
    date1.setFullYear(parts1[2]);
    date1.setDate(parts1[0]);
    date1.setMonth(new_month1);

    var one_day=1000*60*60*24;

    var from_date_ms = date.getTime();
    var to_date_ms = date1.getTime();
   

    var difference_ms = to_date_ms - from_date_ms;

    var total_days = Math.round(difference_ms/one_day); 

    total_days = parseFloat(total_days)+1;

    $('#no_of_days').val(total_days);

}

function list_reflect()
{
	var emp_id = $('#emp_id1').val();
	var from_date = $('#from_date_filter').val();
  var to_date = $('#to_date_filter').val();
	$.post('leave_reply/list_reflect.php',{ emp_id : emp_id, from_date : from_date, to_date : to_date}, function(data){
		$('#div_list').html(data);
	});
}
 list_reflect();

function display_modal(emp_id,request_id)
{
  $.post('leave_reply/update_modal.php', { emp_id : emp_id , request_id : request_id}, function(data){
    $('#div_modal').html(data);
  })
}
</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>