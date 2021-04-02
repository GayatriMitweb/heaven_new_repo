<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Transporter Information',21) ?>

<div class="row text-right mg_bt_20">
    <div class="col-sm-6 text-left">
        <button class="btn btn-info btn-sm ico_left pull-left" style="margin-right:10px" onclick="display_format_modal();"><i class="fa fa-download"></i>&nbsp;&nbsp;CSV Format</button>
        <div class="div-upload  mg_bt_20" id="div_upload_button">
              <div id="vendor_csv_upload" class="upload-button1"><span  id="vendor_status1">CSV</span></div>
              <span id="vendor_status"></span>
              <ul id="files" ></ul>
              <input type="hidden" id="txt_vendor_csv_upload_dir" name="txt_vendor_csv_upload_dir">
        </div>
    </div>
    <div class="col-md-6">
    	<button class="btn btn-info btn-sm ico_left" onclick="generic_city_save_modal()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;City</button>
    	&nbsp;&nbsp;
        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Transporter</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="list_reflect()">
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="active_flag_filter" id="active_flag_filter" title="Status" onchange="list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>


<div id="div_modal_content"></div>
<div id="div_transport_list" class="main_block"></div>
<div id="div_view_content"></div>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
city_lzloading('#city_id_filter');
function list_reflect()
{
	var active_flag = $('#active_flag_filter').val();
	var city_id = $('#city_id_filter').val();
	$.post('list_reflect.php', { active_flag : active_flag, city_id : city_id }, function(data){
		$('#div_transport_list').html(data);
	});
}
list_reflect();

vendor_csv_upload();
function vendor_csv_upload()
{   
    var type="id_proof";
    var btnUpload=$('#vendor_csv_upload');
    var status=$('#vendor_status');
    new AjaxUpload(btnUpload, {
      action: 'upload_vendor_csv_file.php',
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
        //On completion clear the status
        status.text('');
        //Add uploaded file to list
        if(response==="error"){          
          alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_vendor_csv_upload_dir").value = response;
          vendor_form_csv_save();
        }
      }
    });

}

function vendor_form_csv_save()
{
    var vendor_csv_dir = document.getElementById("txt_vendor_csv_upload_dir").value;    
    var status=$('#vendor_status1');
    status.text('Uploading...');
    
    var base_url = $('#base_url').val();


    $.ajax({
        type:'post',
        url: base_url+'controller/group_tour/transport_agency/vendor_csv_save.php',
        data:{ vendor_csv_dir : vendor_csv_dir , base_url : base_url },
        success:function(result){
            msg_alert(result);
            list_reflect();
            status.text('CSV');
        }
    });
}

function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal_content').html(data);
	});
}

function update_modal(transport_agency_id)
{
	$.post('update_modal.php', {transport_agency_id : transport_agency_id}, function(data){
		$('#div_modal_content').html(data);
	});
}

function view_modal(transport_agency_id)
{
    $.post('view_modal.php', {transport_agency_id : transport_agency_id}, function(data){
        $('#div_view_content').html(data);
    });
}
function display_format_modal()
{
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/transporter_vendor.csv";
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>