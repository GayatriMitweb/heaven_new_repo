<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>">

<input type="hidden" id="limit" name="limit">
<input type="hidden" id="start" name="start">

<div class="row text-right mg_bt_10">
	<div class="col-md-12">
    <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
    <button class="btn btn-info btn-sm ico_left pull-left" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download"></i>&nbsp;&nbsp;CSV Format</button>
		<div class="div-upload pull-left" id="div_upload_button">
          <div id="mobile_csv_upload" class="upload-button1"><span>Upload CSV</span></div>
          <span id="id_proof_status"></span>
          <ul id="files" ></ul>
          <input type="hidden" id="txt_mobile_csv_upload_dir" name="txt_mobile_csv_upload_dir">
    </div>
		<button class="btn btn-info btn-sm ico_left" onclick="add_all_system_contacts()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add System Contacts</button>
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#mobile_no_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Mobile No</button>
	</div>
</div>

<div id="div_mobile_no_edit_content"></div>

<?php include_once('mobile_no_save_modal.php'); ?>

<div class="row mg_tp_20">
    <div class="col-md-4 col-sm-6">
        <input type="checkbox" id="mobile_check" onchange="select_all_mobile(this);">&nbsp;&nbsp;<label for="mobile_check">Select All</label>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-4">
      <select name="sms_group_id" id="sms_group_id" title="Select SMS Group ID" class="form-control">
        <option value="">SMS Group ID</option>
        <?php 
        $query1 = "select * from sms_group_master where 1";
        if($branch_status=='yes' && $role=='Branch Admin'){
            $query1 .=" and branch_admin_id = '$branch_admin_id'";
          }
        $sq_sms_group = mysql_query($query1);
        while($row_sms_group = mysql_fetch_assoc($sq_sms_group)){
          ?>
          <option value="<?= $row_sms_group['sms_group_id'] ?>"><?= $row_sms_group['sms_group_name'] ?></option>
          <?php
        }
        ?>
      </select>
    </div>
    <div class="col-md-4">
      <button class="btn btn-sm btn-success" onclick="assign_sms_group()"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Assign</button>
    </div>
  </div>
  <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="email_id" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
<script>
$('#sms_group_id').select2();
function select_all_mobile(ele){
  var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
}

var column = [
	{ title : ""},
	{ title : "S_No."},
	{ title:"Mobile_No", className:"text-center"},
	{ title : "Group_Name"},
	{ title : "Actions"}
];

function mobile_list_reflect(){
	
		$('#tbl_mobile_no').show();
		$('#tbl_mobile_no tbody tr').remove();
		var branch_status = $('#branch_status').val();
		$.post('mobile_no/list_reflect.php', { branch_status : branch_status}, function(data){
			pagination_load(data, column, true, false, 20, 'email_id');
		});
}mobile_list_reflect();

function assign_sms_group()
{
	var sms_group_id = $('#sms_group_id').val();
	if(sms_group_id==""){
		error_msg_alert("Please select sms group!");
		return false;
	}

	var mobile_no_id_arr = new Array();
	$('input[name="chk_mobile_no"]:checked').each(function(){
	  mobile_no_id_arr.push($(this).val());
	});

	if(mobile_no_id_arr.length==0){
		error_msg_alert("Please select at least one mobile no!");
		return false;
	}

	var base_url = $('#base_url').val();

	$.ajax({
	    type:'post',
	    url:base_url+'controller/promotional_sms/mobile_no/mobile_no_group_assign.php',
	    data: { sms_group_id : sms_group_id, mobile_no_id_arr : mobile_no_id_arr },
	    success:function(result){
		  msg_alert(result);
		  $('#tbl_mobile_no tbody tr').remove();
			mobile_list_reflect();
	    }
	});
}

function add_all_system_contacts()
{
  var branch_admin_id = $('#branch_admin_id1').val();
  var branch_status = $('#branch_status').val();
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
	    callback: function(data1){
	        if(data1=="yes"){
				$.post(base_url+"controller/promotional_sms/mobile_no/fetch_mobile_no_from_system.php", {branch_status : branch_status, branch_admin_id : branch_admin_id }, function(data){
					msg_alert(data);
					mobile_list_reflect();
				});					          
	        }
	      }
	});	
}
</script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
mobile_csv_upload();
function mobile_csv_upload()
{   
    var type="id_proof";
    var btnUpload=$('#mobile_csv_upload');
    var status=$('#id_proof_status');
    new AjaxUpload(btnUpload, {
      action: 'mobile_no/upload_mobile_no_csv_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         if(!confirm('Do you want to import this file?')){
            return false;
          }

         if (! (ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
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
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_mobile_csv_upload_dir").value = response;
          mobile_no_from_csv_save();
        }
      }
    });

}

function mobile_no_from_csv_save()
{
	var csv_url = document.getElementById("txt_mobile_csv_upload_dir").value;

	var base_url = $('#base_url').val();


	$.ajax({
		type:'post',
		url: base_url+'controller/promotional_sms/mobile_no/mobile_no_from_csv_save.php',
		data:{ csv_url : csv_url , base_url:base_url },
		success:function(result){
			msg_alert(result);
			mobile_list_reflect();
		}
	});
}

function display_format_modal()
{
    var base_url = $('#base_url').val();
     window.location = base_url+"images/csv_format/mobile_no_import.csv";
}

function excel_report()
{ 
  var branch_status = $('#branch_status').val();
    window.location = 'mobile_no/excel_report.php?branch_status='+branch_status;
}
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>