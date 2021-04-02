<?php
include "../../../model/model.php";
?>
<div class="modal fade" id="lgsave_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Current Logged-In Users</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12 no-pad"> <div class="table-responsive">
            <table class="table table-hover" id="tbl_list">
              <thead>
                <tr class="table-heading-row">
                  <th>S_No.</th>
                  <th>User_Name</th>
                  <th>Login_Date/Time</th>
                  <th>IP_Address</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $emp_id = $_SESSION['emp_id'];
                  $today = date('Y-m-d');
                  $query = "select * from user_logs where login_id in (select id from roles where login_date = '$today' and id != '1') and logout_time = '00:00:00' order by log_id desc";
                  $sq_log = mysql_query($query);
                  while($row_sq = mysql_fetch_assoc($sq_log)){
                    $sq_log_entry = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='$row_sq[login_id]'"));
                    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_log_entry[emp_id]'"));
                   ?>
                  <tr>
                    <td><?= ++$count ?></td>
                    <td><?= $sq_emp['first_name'].' '.$sq_emp['last_name']  ?></td>
                    <td><?= date('d-m-Y', strtotime($row_sq['login_date'])).' '.$row_sq['login_time'] ?></td>
                    <td><?= $row_sq['user_ip']  ?></td>
                  </tr>
                <?php 
                  } 
                ?>
              </tbody>
            </table>
          </div></div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
$('#lgsave_modal').modal('show');
</script>