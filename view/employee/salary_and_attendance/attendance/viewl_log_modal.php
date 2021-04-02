<?php
include "../../../../model/model.php";

$login_id = $_POST['login_id'];
$month = $_POST['month'];
$year = $_POST['year'];

$from_date = "1-$month-$year";
$from_date = get_date_db($from_date);

$days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
$to_date = "$days-$month-$year";
$to_date = get_date_db($to_date);

$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$login_id'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));
$salary = $sq_emp_info['salary'];
?>
<div class="modal fade" id="view_log_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        
		<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr class="table-heading-row">
						<th>S_No.</th>
						<th>Login_Date</th>
						<th>Day</th>
						<th>Login_Time</th>
						<th>Status</th>
						<th>Remark</th>
						<th>IP_Address</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 0; 
					for($i=0; strtotime($from_date)<=strtotime($to_date); $i++){

						$count++;
						$q1 = mysql_query("select log_id, min(login_time) as login_time, status, remark, user_ip from user_logs where login_date='$from_date' and login_id='$login_id'");
						$sq_log = mysql_fetch_assoc($q1);
						
						$login_time = $sq_log['login_time'];
						if($login_time=="" || $login_time=="00:00:00"){
							$login_time = "N/A";
						}

						$bg = ($sq_log['status']=="Present") ? "success" : "";
						if($sq_log['status']=="Absent") { $bg = "danger"; }

						$day = date('l', strtotime($from_date))
						?>
						<input type="hidden" id="log_id_<?= $count ?>" name="log_id" value="<?= $sq_log['log_id'] ?>">
						<input type="hidden" id="login_date_<?= $count ?>" name="login_date" value="<?= $from_date ?>">
						<tr class="<?= $bg ?>">
							<td><?= $count ?></td>
							<td><?= date('d/m/Y', strtotime($from_date)) ?></td>
							<td><?= $day ?></td>
							<td><?= $login_time ?></td>
							<td><?= $sq_log['status'] ?></td>
							<td><?= $sq_log['remark'] ?></td>
							<td><?= $sq_log['user_ip'] ?></td>
						</tr>
						<?php
						$date = strtotime("+1 day", strtotime($from_date));
						$from_date = date("Y-m-d", $date);
					}
					?>		
				</tbody>
			</table>
		</div> </div> </div>

      </div>     
    </div>
  </div>
</div>

<script>
$('#view_log_modal').modal('show');
</script>