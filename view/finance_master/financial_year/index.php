<?php
include "../../../model/model.php";
?>

    <div class="row text-right">
        <div class="col-md-12">
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Financial Year</button>
        </div>
    </div>
    <div id="div_modal" class="main_block"></div>
    <div id="div_list_content"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('../finance_master/financial_year/save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}

function list_reflect()
{
	$.post('../finance_master/financial_year/list_reflect.php', {}, function(data){
        $('#div_list_content').html(data);
    });
}
list_reflect();

function update_modal(financial_year_id)
{
    $.post('../finance_master/financial_year/update_modal.php', {financial_year_id : financial_year_id}, function(data){
        $('#div_modal').html(data);
    });
}
</script>