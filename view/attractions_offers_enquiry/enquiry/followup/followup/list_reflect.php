<?php
include_once('../../../../../model/model.php');
$enquiry_id = $_POST['enquiry_id'];
$sq_enquiry = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
?>
<div class="row mg_bt_20 text-right">
		<div class="col-md-3 col-sm-6 col-md-offset-5">
				<select name="enquiry_type" id="enquiry_type" title="Enquiry For" class="form-control form-control-visible" disabled>
						<option value="<?= $sq_enquiry['enquiry_type'] ?>"><?= $sq_enquiry['enquiry_type'] ?></option>
				</select>
		</div>
		<div class="col-md-3 col-sm-6">
				<input type="text" class="form-control form-control-visible" id="txt_name" name="txt_name" onchange="name_validate(this.id)" placeholder="Customer Name" title="Customer Name" value="<?= $sq_enquiry['name'] ?>" readonly>
		</div>
</div>
<div class="row"> 
	<div class="col-md-10 col-md-offset-1"> 
		<ul class="followup_entries main_block mg_tp_20 mg_bt_0">
				<?php
				$count = 0;
				$sq_followup_entries = mysql_query("select * from enquiry_master_entries where enquiry_id='$enquiry_id'");
				while($row_entry = mysql_fetch_assoc($sq_followup_entries)){
					$bg = $row_entry['followup_stage'];
					$date1 = date_create($due_date);
					$date2 = date_create($status_date);
					$diff = date_diff($date1,$date2);
					$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row_entry[enquiry_id]'"));
					$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_enq[assigned_emp_id]'"));
					?>

					<li class="main_block <?= $bg ?>">
						<div class="single_folloup_entry main_block mg_bt_20">
							<div class="col-sm-3 entry_detail"><?= date('d-m-Y H:i:s', strtotime($row_entry['created_at'])) ?></div>
							<div class="col-sm-2 entry_detail"><?= $row_entry['followup_type'] ?></div>
							<div class="col-sm-2 entry_detail"><?= $row_entry['followup_status'] ?></div>
							<div class="col-sm-3 entry_detail"><?= date('d-m-Y H:i:s', strtotime($row_entry['followup_date'])) ?></div>
							<div class="col-sm-2 entry_detail"><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></div>
							<div class="col-sm-12 entry_discussion">
								<p><?= $row_entry['followup_reply'] ?></p>
							</div>
						</div>
					</li>
					<?php } ?>
		</ul>
		<div class="col-md-12 no-pad text-right">
			<ul class="color_identity no-pad no-marg">
				<li>
					<span class="identity_color cold"></span>
					<span class="identity_name">Cold</span>
				</li>
				<li>
					<span class="identity_color hot"></span>
					<span class="identity_name">Hot</span>
				</li>
				<li>
					<span class="identity_color strong"></span>
					<span class="identity_name">Strong</span>
				</li>
			</ul>
		</div>
	</div>
</div>

