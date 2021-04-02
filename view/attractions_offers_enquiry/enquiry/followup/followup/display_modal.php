<?php
include "../../../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$enquiry_id = $_POST['enquiry_id'];


$sq_enquiry = mysql_fetch_assoc(mysql_query("Select * from enquiry_master where enquiry_id =". $enquiry_id));
?>
<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>"> 
<form id="frm_followup_reply">
<div class="modal fade" id="followup_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Followup</h4>
      </div>
      <div class="modal-body">
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
    <legend>New Followup</legend>
		<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select name="followup_status" id="followup_status" title="Followup Status" class="form-control" onchange="followup_type_reflect(this.value)">
            <option value="">*Status</option>
            <!-- <option value="Active">Active</option> -->
						<option value="In-Followup">In-Followup</option>
            <option value="Dropped">Dropped</option>
            <option value="Converted">Converted</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <select id="followup_type" name="followup_type" title="Followup Type" class="form-control">
              <option value="">*Type</option>
          </select>
        </div>
        
        <div class="col-md-3 col-sm-6 mg_bt_10">
              <select name="followup_stage" id="followup_stage" title="Enquiry Type" class="form-control">
                <option value="">Stage</option>
                <option value="<?= "Strong" ?>">Strong</option>
                <option value="<?= "Hot" ?>">Hot</option>
                <option value="<?= "Cold" ?>">Cold</option>
              </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10">
          <input type="text" id="followup_date" name="followup_date" placeholder="Next Followup Date" title="Next Followup Date" value="<?= date('d-m-Y H:i')?>" style="min-width:136px;" class="form-control">
        </div>
	</div>
	   <div class="row mg_bt_10">
		 <div class="col-md-12">
			<textarea id="followup_reply" name="followup_reply" onchange="validate_spaces(this.id);" placeholder="*Followup Description" class="form-control"></textarea>
		 </div>		
	   </div>
	<div class="row text-center mg_bt_20">
		<div class="col-md-12">
			<button class="btn btn-sm btn-success" id="btn_followup_reply"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
		</div>
	</div>
    </div>
    <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
    <legend>Followup History</legend>

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
	<div class="col-md-12"> 
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
</div>
	 </div>
    </div>
  </div>
</div>
    </form>
 <script>
    $('#followup_save_modal').modal( {keyboard: false,  backdrop: 'static'});
	$('#followup_date').datetimepicker({ format:'d-m-Y H:i:s' });
	$(function(){
  	$('#frm_followup_reply').validate({
    rules:{
      followup_reply: "required",
      followup_date:"required",
      followup_type: "required",
      followup_status: "required",
    },
    submitHandler:function(form,event){
    event.preventDefault();
    var enquiry_id = $("#enquiry_id").val(); 
    var followup_reply = $("#followup_reply").val(); 
    var followup_date = $('#followup_date').val();
    var followup_type = $('#followup_type').val();
    var followup_status = $('#followup_status').val();
    var followup_stage = $('#followup_stage').val();
    console.log(followup_reply+"||",followup_date+"||",followup_type+"||",followup_status+"||",followup_stage+"||");
    var base_url = $('#base_url').val();
    $('#btn_followup_reply').button('loading');
        $.post( 
               base_url+"controller/attractions_offers_enquiry/followup_reply_save.php",
               { enquiry_id : enquiry_id, followup_reply : followup_reply, followup_date : followup_date, followup_type : followup_type, followup_status : followup_status, followup_stage : followup_stage },
               function(data) {  
                      msg_alert(data);
                      $('#followup_save_modal').modal('hide');
                      enquiry_proceed_reflect();
        });
    }
  });
});

</script>
