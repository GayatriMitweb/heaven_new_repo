<?php 
include_once('../../../../model/model.php');
?>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 mg_bt_10_xs">
            <select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%">
              <?php get_customer_dropdown(); ?>
            </select>
        </div>
        <div class="col-md-3 mg_bt_10_xs">
            <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">
        </div>
        <div class="col-md-3 mg_bt_10_xs">
            <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
        </div>
        <div class="col-md-3">
            <button class="btn btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
    </div>
</div>

<div id="div_list" class="main_block"></div>

<script>
$('#customer_id').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

function list_reflect()
{
    var customer_id = $('#customer_id').val();
    var from_date = $('#from_date_filter').val();
    var to_date = $('#to_date_filter').val();

    $.post('enquiry/list_reflect.php', { customer_id : customer_id, from_date : from_date, to_date : to_date }, function(data){
        $('#div_list').html(data);
    });
}
list_reflect();
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>