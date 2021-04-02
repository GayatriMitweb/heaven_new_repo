<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id']; 
$branch_admin_id = $_SESSION['branch_admin_id']; 
?>
<div class="row text-right mg_bt_20">
    <div class="col-sm-6 text-left">
    <?php if($role=='Admin' || $role=='Accountant' || $role=='Branch Admin'){ ?>
        <button class="btn btn-info btn-sm ico_left pull-left" data-toggle='tooltip' title="Download CSV Format" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;CSV Format</button>
        <div class="div-upload mg_bt_20" id="div_upload_button" role="button" title="Upload Opening Balance CSV" data-toggle='tooltip'>
            <div id="csv_upload" class="upload-button1"><span id="vendor_status1">CSV</span></div>
            <span id="vendor_status"></span>
            <ul id="files" ></ul>
            <input type="hidden" id="csv_upload_dir" name="csv_upload_dir">
        </div>
    <?php } ?>
    </div>
    <div class="col-md-6 text-right">
    <?php if($role=='Admin'){ ?>
    <button class="btn btn-excel btn-sm mg_bt_10" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
    <?php } ?>
    <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Account Ledger</button>
    </div>
</div>

<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">
<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3">
            <select id="active_filter" name="active_filter" style="width: 100%" title="Status" onchange="list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="group_id_filter" name="group_id_filter" style="width: 100%" title="Group" onchange="list_reflect()">
                <option value="">Select Group</option>
                <?php 
                $sq_group = mysql_query("select * from subgroup_master");
                while($row_group = mysql_fetch_assoc($sq_group)){
                ?>
                <option value="<?= $row_group['subgroup_id'] ?>"><?= $row_group['subgroup_name'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="checkbox" id="chk_balance" name="chk_balance" onclick="list_reflect()" checked><label for="chk_balance">&nbsp;&nbsp;Nil Balance A/c</label>
        </div>
  </div>
</div>


<div id="div_modal"></div>

<div id="div_list_content" class="main_block loader_parent mg_tp_20">
 <div class="table-responsive">
    <table id="tbl_ledger_list" class="table table-hover" style="margin: 20px 0 !important;">         
    </table>
</div>
</div>

<div id="div_ledger_modal"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
$('#group_id_filter').select2();
<?php if($role=='Admin' || $role=='Accountant' || $role=='Branch Admin'){ ?> 
csv_upload();
<?php } ?>
function csv_upload(){   

    var btnUpload=$('#csv_upload');
    var status=$('#vendor_status');
    new AjaxUpload(btnUpload, {
      action: '../finance_master/ledger_master/csv_upload.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){

        if(!confirm('Do you want to import this file?')){
            return false;
        }
        if (! (ext && /^(csv)$/.test(ext))){ 
           // extension is not allowed 
          error_msg_alert('Only CSV files are allowed');
          return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
        } else{
            document.getElementById("csv_upload_dir").value = response;
            update_ledger_balance();
        }
      }
    });
}

function update_ledger_balance(){

    var base_url = $('#base_url').val();
    var csv_upload_dir = document.getElementById("csv_upload_dir").value;
    $.post(
            base_url+"controller/finance_master/ledger_master/opening_balances.php",
            { csv_upload_dir : csv_upload_dir },
            function(data) {
                var msg = data.split('--');
                if(msg[0] === 'error'){
                    error_msg_alert(msg[1]);
                    return false;
                }
                else if(msg[0] === 'unprocess'){
                    error_msg_alert("Check Ledger Opening balances properly!");
                    var url = data.split('/');
                    window.location ='<?= BASE_URL ?>'+url[4]+'/'+url[5];
                    return false;
                }
                else{
                    success_msg_alert(data);
                }
            }
    );
}
function display_format_modal(){

    $.post('../finance_master/ledger_master/download_ledgers.php', {}, function(data){
        var url = data.split('/');
        window.location ='<?= BASE_URL ?>'+url[4]+'/'+url[5];
    });
}
function save_modal(){

    $('#btn_save_modal').button('loading');
    $.post('../finance_master/ledger_master/save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}
var columns= [
    { title: "S_NO" },
    { title: "Ledger_Name" },
    { title: "Opening_Bal" },
    { title: "Group_Name" },
    { title: "Closing_Bal" },
    { title: "Actions", className:"text-center" }
];
function list_reflect(){

    $('#div_list_content').append('<div class="loader"></div>');
    var group_id = $('#group_id_filter').val();
    var financial_year_id = $('#financial_year_id').val();
    var branch_admin_id = $('#branch_admin_id').val();
    var active_filter = $('#active_filter').val();
    var chk_balance = $('input[name="chk_balance"]:checked').length;

    $.post('../finance_master/ledger_master/list_reflect.php', { group_id : group_id,financial_year_id : financial_year_id,branch_admin_id : branch_admin_id,active_filter:active_filter,chk_balance:chk_balance }, function(data){
	setTimeout(() => {
        pagination_load(data,columns, true, false, 20, 'tbl_ledger_list');
        $('.loader').remove();
    }, 1000);
  });
}list_reflect();

function update_modal(ledger_id)
{
    $.post('../finance_master/ledger_master/update_modal.php', {ledger_id : ledger_id}, function(data){
        $('#div_modal').html(data);
    });
}
function reflect_side(group_id,div_id)
{
    var group_id = $('#'+group_id).val();
    $.post('../finance_master/ledger_master/get_dr_cr.php', {group_id : group_id}, function(data){
        $('#'+div_id).html(data);
    });
}
function display_modal(ledger_id)
{
    $.post('../finance_master/ledger_master/view/index.php', {ledger_id : ledger_id}, function(data){
        $('#div_ledger_modal').html(data);
    });
}

function excel_report()
{
    var group_id = $('#group_id_filter').val()
    var financial_year_id = $('#financial_year_id').val();
    var branch_admin_id = $('#branch_admin_id').val();
    var active_filter = $('#active_filter').val();
    var chk_balance = $('input[name="chk_balance"]:checked').length;

    window.location = '<?= BASE_URL ?>/view/finance_master/ledger_master/excel_report.php?group_id='+group_id+'&financial_year_id='+financial_year_id+'&branch_admin_id='+branch_admin_id+'&active_filter='+active_filter+'&chk_balance='+chk_balance;
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>