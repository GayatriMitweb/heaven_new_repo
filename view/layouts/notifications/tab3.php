<div class="notification_scroller notification_scroller_task">
	<ul class="no-pad">
		<?php
			$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='leave_magt/leave_request/index.php'"));
			$branch_status1 = $sq['branch_status'];
		 if($role=='Admin' || $role=='Branch Admin' || $role=="Hr"){
			 if($role=="Hr"){
				$query = "SELECT x.* FROM 
				(
						(SELECT emp_id,type_of_leave,status,request_id,from_date,to_date FROM leave_request as status_nblank WHERE status_nblank.status != '' and status_nblank.emp_id='$emp_id'";
						
						$query .= " order by status_nblank.request_id desc limit 5)";
						
						$query .= "UNION ALL
						
						(SELECT emp_id, type_of_leave,status,request_id,from_date,to_date FROM leave_request as status_blank WHERE status_blank.status = '' ";
						
						$query .= " order by status_blank.request_id desc limit 5)
						 order by request_id desc limit 5
				)x ";
				$sq_leave = mysql_query($query);
			 }
			 else{
				if($role=="Branch Admin"){
					$query = "SELECT x.* FROM 
					(
							(SELECT emp_id,type_of_leave,status,request_id,from_date,to_date FROM leave_request as status_nblank WHERE status_nblank.status != '' and status_nblank.emp_id='$emp_id'";
							
							$query .= " order by status_nblank.request_id desc limit 5)";
							
							$query .= "UNION ALL
							
							(SELECT emp_id, type_of_leave,status,request_id,from_date,to_date FROM leave_request as status_blank WHERE status_blank.status = '' ";
							
							$query .= " order by status_blank.request_id desc limit 5)
							order by request_id desc limit 5
					)x ";
					$sq_leave = mysql_query($query);
				}
				else{
					$query = "select * from leave_request where 1 ";
					$query .=" and status=''";
					$query .=" order by request_id desc limit 5";
					$sq_leave = mysql_query($query);
				}
			}
			while($row_leave = mysql_fetch_assoc($sq_leave)){
				$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_leave[emp_id]'"));
				$d_date = '('.get_date_user($row_leave['from_date']).' To '.get_date_user($row_leave['to_date']).')';
				$l_status = ($row_leave['status'] != '') ? '('.$row_leave['status'].')' : $d_date;
			?>
			<li class="single_notification">
				<h5 class="single_notification_text no-marg"><?= $row_leave['type_of_leave'].$l_status ?></h5>
				<p class="single_notification_date_time no-marg"><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></p>
			</li>
			<?php }
		}
		else{
			$query = "select * from leave_request where 1 ";
				$query .= " and status!='' and emp_id='$emp_id'";
			$query .=" order by request_id desc limit 5";
			$sq_leave = mysql_query($query);
			while($row_leave = mysql_fetch_assoc($sq_leave)){
			$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_leave[emp_id]'"));
			$d_date = '('.get_date_user($row_leave['from_date']).' To '.get_date_user($row_leave['to_date']).')';
			$l_status = ($row_leave['status'] != '') ? '('.$row_leave['status'].')' : $d_date;
			?>
			<li class="single_notification">
				<h5 class="single_notification_text no-marg"><?= $row_leave['type_of_leave'].$d_date ?></h5>
				<p class="single_notification_date_time no-marg"><?= $row_leave['status']?></p>
			<?php if($role_id==6){ ?> <p class="single_notification_date_time no-marg"><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></p><?php } ?>
			</li>
			<?php }
		}?>
	</ul>

	<div class="all_notification">
		<?php $path="view/leave_magt/index.php"; ?>
		<a href= <?= BASE_URL.$path ?> target="_blank">View All Notifications</a>
	</div>
</div>