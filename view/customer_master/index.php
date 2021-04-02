<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');

$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='customer_master/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Customers Information',8) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >
 
<div class="row">
    <div class="col-sm-6 text-left">            
        <button class="btn btn-info btn-sm ico_left pull-left mg_bt_20" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;CSV Format</button>
        <div class="div-upload  mg_bt_20" id="div_upload_button">
              <div id="cust_csv_upload" class="upload-button1"><span>CSV</span></div>
              <span id="cust_status" ></span>
              <ul id="files" ></ul>
              <input type="hidden" id="txt_cust_csv_upload_dir" name="txt_cust_csv_upload_dir">
        </div>
    </div>
    <div class="col-sm-6 text-right text_left_sm_xs">
        <?php if($role == 'Admin' || $role == 'Branch Admin'){?>
        <button class="btn btn-excel btn-sm mg_bt_20" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
        <?php } ?>
        <button class="btn btn-info btn-sm ico_left mg_bt_20" onclick="customer_save_modal('master')"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Customer</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="cust_type_filter" id="cust_type_filter" onchange="customer_list_reflect();company_name_reflect();" title="Select Customer Type">
                <?php get_customer_type_dropdown(); ?>                
            </select>
        </div>
        <?php if($role=='Admin'){ ?>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
            <select name="branch_id_filter" id="branch_id_filter1" title="Branch Name" style="width: 100%" onchange="customer_list_reflect()">
            <?php get_branch_dropdown($role, $branch_admin_id, $branch_status) ?>
            </select>
        </div>
        <?php } ?>
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="active_flag_filter" id="active_flag_filter" title="Status" onchange="customer_list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3 mg_bt_10_xs" id="company_div">
        </div>
    </div>
</div>

<div id="div_customer_list" class="main_block loader_parent mg_tp_20">
    <div class="table-responsive">
        <table id="tbl_list" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>

<div id="div_customer_update_modal"></div>
<div id="div_view_modal"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
var columns = [
	{ title : "S_No." },
	{ title : "Customer_Name" },
	{ title : "Birth_Date" },
	{ title : "mobile_NO" },
	{ title : "Email_ID" },
	{ title : "Actions", className:"text-center" }
]
function customer_list_reflect(){

  $('#div_customer_list').append('<div class="loader"></div>');
  var active_flag = $('#active_flag_filter').val();
  var cust_type = $('#cust_type_filter').val();
  var company_name = $('#company_filter').val();
  var branch_status = $('#branch_status').val();
  var branch_id = $('#branch_id_filter1').val();

  $.post('customer_list_reflect.php', {active_flag : active_flag, cust_type : cust_type, company_name : company_name, branch_status : branch_status,branch_id : branch_id}, function(data){
        pagination_load(data,columns, true, false, 20, 'tbl_list');
		$('.loader').remove();
	});
}
customer_list_reflect();

cust_csv_upload();
function cust_csv_upload()
{   
    var type="id_proof";
    var btnUpload=$('#cust_csv_upload');
    var status=$('#cust_status');
    new AjaxUpload(btnUpload, {
      action: 'upload_cust_csv_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

         if(!confirm('Do you want to import this file?')){
            return false;
          }

         if (! (ext && /^(csv)$/.test(ext))){ 
          error_msg_alert('Only CSV files are allowed');
          return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        status.text('');
        if(response==="error"){          
          alert("File is not uploaded.");
        } else{
          document.getElementById("txt_cust_csv_upload_dir").value = response;
          status.text('Uploading...');
          cust_csv_save();
        }
      }
    });
}

function cust_csv_save(){
    var cust_csv_dir = document.getElementById("txt_cust_csv_upload_dir").value;
    var branch_admin_id = $('#branch_admin_id').val();
    var status=$('#cust_status');
    var base_url = $('#base_url').val();

    $.ajax({
        type:'post',
        url: base_url+'controller/customer_master/cust_csv_save.php',
        data:{cust_csv_dir : cust_csv_dir, branch_admin_id : branch_admin_id , base_url : base_url },
        success:function(result){
            msg_alert(result);
            status.text('');
            customer_list_reflect();
        }
    });
}

function company_name_reflect(){
	var cust_type = $('#cust_type_filter').val();
    var branch_status = $('#branch_status').val();
  	$.post('company_name_load.php', { cust_type : cust_type, branch_status : branch_status }, function(data){
    	$('#company_div').html(data);
    });
}
function display_format_modal(){
    var base_url = $('#base_url').val();
     window.location = base_url+"images/csv_format/customer.csv";
}

function excel_report(){
    var active_flag = $('#active_flag_filter').val();
    var branch_id = $('#branch_id_filter1').val();
    var cust_type = $('#cust_type_filter').val();
    var company_name = $('#company_filter').val();
    var branch_status = $('#branch_status').val();
    
    window.location = 'excel_report.php?active_flag='+active_flag+'&branch_id='+branch_id+'&cust_type='+cust_type+'&company_name='+company_name+'&branch_status='+branch_status;
}
function showNum(count)
{
	$("#phone-x"+count).removeClass('hidden');
	$("#phone-y"+count).addClass('hidden');
	var emp_id=$("#emp_id").val();
		$.post('send_notification.php', { emp_id : emp_id }, function(data){
	})
}
function showEmail(count)
{
	$("#phone-xe"+count).removeClass('hidden');
	$("#phone-ye"+count).addClass('hidden');
	var emp_id=$("#emp_id").val();
		$.post('send_notification.php', { emp_id : emp_id }, function(data){
	})
}
function customer_update_modal(customer_id)
{
	$.post('customer_update_modal.php', { customer_id : customer_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
function customer_display_modal(customer_id)
{
	$.post('view/index.php', { customer_id : customer_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
function customer_history_modal(customer_id)
{
	$.post('customer_history_modal.php', { customer_id : customer_id }, function(data){
		$('#div_customer_update_modal').html(data);
	})
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>
