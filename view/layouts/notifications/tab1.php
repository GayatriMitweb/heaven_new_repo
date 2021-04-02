<div class="notification_scroller">
	<ul class="no-pad">
		<?php
			$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='attractions_offers_enquiry/enquiry/index.php'"));
			$branch_status = $sq['branch_status'];
			if($login_id == "1"){
				$emp_id = 0;
			}
		 if(($role!='Admin' && $role!='Branch Admin') || $login_id == "1"){
		  $sq_enquiry = mysql_query("select * from enquiry_master where status='' and assigned_emp_id='$emp_id' group by enquiry_id order by enquiry_id desc limit 5");
		  while($row_enquiry = mysql_fetch_assoc($sq_enquiry)){
			$date = $row_enquiry['enquiry_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
		?>
		<li class="single_notification">
			<h5 class="single_notification_text no-marg"><?= $row_enquiry['enquiry_type'].'('.get_enquiry_id($row_enquiry['enquiry_id'],$year).')' ?></h5>
			<p class="single_notification_date_time no-marg"><?= date('d-m-Y',strtotime($row_enquiry['enquiry_date'])) ?></p>
		</li>
		<?php }
	    }
	    else{
        $query ="select * from enquiry_master as en left join enquiry_master_entries as ef on en.enquiry_id=ef.enquiry_id where en.status!='Disabled'";
	    	if($role=="Branch Admin"){
				if($branch_status=='yes'){
						$query .= " and en.branch_admin_id = '$branch_admin_id'";
				}
			}
			$query .=" and ef.followup_status='Converted'";
			$query .="group by en.enquiry_id order by ef.created_at desc limit 5";
			$sq_enquiry = mysql_query($query);
		   while($row_enquiry = mysql_fetch_assoc($sq_enquiry)){
			$date = $row_enquiry['enquiry_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
		?>
		<li class="single_notification">

			<h5 class="single_notification_text no-marg"><?= $row_enquiry['enquiry_type'].'('.get_enquiry_id($row_enquiry['enquiry_id'],$year).')' ?></h5>
			<p class="single_notification_date_time no-marg"><?= date('d-m-Y',strtotime($row_enquiry['enquiry_date'])) ?></p>

		</li>
		<?php }
		 } ?>
	</ul>

	<div class="all_notification">
		<?php $path="view/attractions_offers_enquiry/enquiry/index.php"; ?>
		<a href= <?= BASE_URL.$path ?> target="_blank">View All Notifications</a>

	</div>

</div>