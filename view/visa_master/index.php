<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>

<?= begin_panel('Visa Information',16) ?>
  <div class="header_bottom mg_bt_10">
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-info btn-sm ico_left" id="btn_typesave_modal" onclick="visa_type_save()" title="Add Visa Information"><i class="fa fa-plus"></i>&nbsp;&nbsp;Visa Type</button>
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="Add Visa Information"><i class="fa fa-plus"></i>&nbsp;&nbsp;Visa</button>
        </div>
    </div>
  </div>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
                
         <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                <select name="visa_country_name_filter" id="visa_country_name_filter" class="form-control" title="Visa Country Name" style="width:100%" onchange="visa_list_reflect();">
                    <option value="">Visa Country</option>
                    <?php 
                    $sq_country = mysql_query("select * from country_list_master");
                    while($row_country = mysql_fetch_assoc($sq_country)){
                        ?>
                        <option value="<?= $row_country['country_name'] ?>"><?= $row_country['country_name'] ?></option>
                        <?php
                    }
                    ?>
                 </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <select name="visa_type" id="visa_type_filter" class="form-control" title="Visa Type" onchange="visa_list_reflect();" style="width:100%">
                    <option value="">Visa Type</option>
                    <?php 
                    $sq_visa_type = mysql_query("select * from visa_type_master");
                    while($row_visa_type = mysql_fetch_assoc($sq_visa_type)){
                        ?>
                        <option value="<?= $row_visa_type['visa_type'] ?>"><?= $row_visa_type['visa_type'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

      </div>

    <!-- filetr-panel-end -->

<div class="app_panel_content">

<div id="div_visa_list" class="loader_parent"></div>
<div id="div_employee_modal"></div>

<?= end_panel() ?>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
$('#visa_country_name_filter,#visa_type_filter').select2();
function visa_list_reflect()
{
    $('#div_visa_list').append('<div class="loader"></div>');
    var country_name = $('#visa_country_name_filter').val();
    var visa_type = $('#visa_type_filter').val();  
    $.post('visa_list_reflect.php', { country_name : country_name,visa_type : visa_type }, function(data){
        $('#div_visa_list').html(data);
    });
}
visa_list_reflect();

function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_employee_modal').html(data);
    });
}
function update_modal(entry_id)
{
    $.post('update_modal.php', {entry_id : entry_id}, function(data){
        $('#div_employee_modal').html(data);
    });
}
function display_modal(entry_id)
{
    $.post('view/index.php', {entry_id : entry_id}, function(data){
        $('#div_employee_modal').html(data);
    });
}
function send(entry_id)
{
    $.post('send_visa_modal.php', {entry_id : entry_id}, function(data){
        $('#div_employee_modal').html(data);
    });
}

function visa_type_save()
{
    $('#btn_typesave_modal').button('loading');
    $.post('visa_type_save.php', {}, function(data){
        $('#btn_typesave_modal').button('reset');
        $('#div_employee_modal').html(data);
    });
}

</script>

<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>