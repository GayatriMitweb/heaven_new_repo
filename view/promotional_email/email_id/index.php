<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>	
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left pull-left" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download"></i>&nbsp;&nbsp;CSV Format</button>
		<div class="div-upload pull-left" id="div_upload_button">
			<div id="email_csv_upload" class="upload-button1"><span>Upload CSV</span></div>
			<span id="id_proof_status" ></span>
			<ul id="files" ></ul>
			<input type="hidden" id="txt_mobile_csv_upload_dir" name="txt_mobile_csv_upload_dir">
		</div>
		<button class="btn btn-info btn-sm ico_left" onclick="add_all_system_emails()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add System Emails</button>
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#email_id_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Email ID</button>
	</div>
</div>

<div id="div_modal"></div>
	<div class="row mg_tp_20">
		<div class="col-md-4 col-sm-6">
			<input type="checkbox" id="email_id_check" onchange="select_all_emails(this);">&nbsp;&nbsp;<label for="email_id_check">Select All</label>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<select name="email_group_id" id="email_group_id" class="form-control" title="Select Email Group ID">
				<option value="">Email Group ID</option>
				<?php 
				$query1 = "select * from email_group_master where 1";
				if($branch_status=='yes' && $role=='Branch Admin'){
				$query1 .=" and branch_admin_id = '$branch_admin_id'";
				}
				$sq_sms_group = mysql_query($query1);			
				while($row_sms_group = mysql_fetch_assoc($sq_sms_group)){
					?>
					<option value="<?= $row_sms_group['email_group_id'] ?>"><?= $row_sms_group['email_group_name'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-md-4">
			<button class="btn btn-sm btn-success" id="assign_button" onclick="assign_email_group()"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Assign</button>
		</div>
	</div>

	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="email_id" class="table table-hover" ></table>
	</div></div></div>
</div>
<div id="div_mobile_no_edit_content"></div>

<?php
include_once('email_id_save_modal.php');
?>
<script>
$('#sms_group_id').select2();

function select_all_emails(ele){
	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = true;
			}
		}
	} 
	else {
		for (var i = 0; i < checkboxes.length; i++) {
		//  console.log(i)
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}
var column = [
	{ title : ""},
	{ title : "S_No."},
	{ title:"Email_ID"},
	{ title : "Group_Name"},
	{ title : "Actions", className:"text-center"}
];
function email_id_list_reflect(){
		
		$('#tbl_email_id').show();
		$('#tbl_email_id tbody tr').remove();
		var branch_status = $('#branch_status').val();
		$.post('email_id/list_reflect.php', {branch_status : branch_status}, function(data){
			pagination_load(data, column, true, false, 20, 'email_id');
		});
}
email_id_list_reflect();
function add_all_system_emails()
{
  var branch_status = $('#branch_status').val();
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
	    callback: function(data1){
	        if(data1=="yes"){
				$.post(base_url+"controller/promotional_email/email_id/fetch_email_id_from_system.php", {branch_status : branch_status}, function(data){
					msg_alert(data);
					email_id_list_reflect();
				});					          
	        }
	    }
	});	
}
function assign_email_group()
{
	var email_group_id = $('#email_group_id').val();
	if(email_group_id==""){
		error_msg_alert("Please select Email ID group!");
		return false;
	}

	var email_id_id_arr = new Array();

	$('input[name="chk_email_id"]:checked').each(function(){

		email_id_id_arr.push($(this).val());

	});
	if(email_id_id_arr.length==0){
		error_msg_alert("Please select at least one email id!");
		return false;
	}
	console.log({email_id_id_arr});
	console.log(email_group_id);
	var base_url = $('#base_url').val();
	$('#assign_button').button('loading');

	$.ajax({
	    type:'post',
	    url:base_url+'controller/promotional_email/email_id/email_id_group_assign.php',
	    data: { email_group_id : email_group_id, email_id_id_arr : email_id_id_arr },
	    success:function(result){
			msg_alert(result);
			$('#assign_button').button('reset');
			email_id_list_reflect();
	    }
	});
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
email_csv_upload();
function email_csv_upload()
{   
    var type="id_proof";
    var btnUpload=$('#email_csv_upload');
    var status=$('#id_proof_status');
    new AjaxUpload(btnUpload, {
		action: 'email_id/upload_email_id_csv_file.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){

			if(!confirm('Do you want to import this file?')){
			return false;
			}
			if (! (ext && /^(csv)$/.test(ext))){ 
			status.text('Only CSV files are allowed');
			return false;
		}
		status.text('Uploading...');
		},
		onComplete: function(file, response){
		//On completion clear the status
		status.text('');
		//Add uploaded file to list
		if(response==="error"){          
			alert("File is not uploaded.");           
		} else{
			document.getElementById("txt_mobile_csv_upload_dir").value = response;
			email_id_from_csv_save();
		}
		}
    });
}

function email_id_from_csv_save()
{
	var csv_url = document.getElementById("txt_mobile_csv_upload_dir").value;
	var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url+'controller/promotional_email/email_id/email_id_from_csv_save.php',
		data:{ csv_url : csv_url , base_url:base_url},
		success:function(result){
			msg_alert(result);
			email_id_list_reflect();
		}
	});
}

function display_format_modal()
{
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/email_id_import.csv";
}
function excel_report()
{
	var branch_status = $('#branch_status').val();
	window.location = 'email_id/excel_report.php?branch_status='+branch_status;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>