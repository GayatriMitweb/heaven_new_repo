<?php 
include_once('../../../../model/model.php');
include_once('../../layouts/admin_header.php');

$customer_id = $_SESSION['customer_id'];
?>
<?= begin_panel('Customer Enquiry') ?>

<div class="row text-right">
    <div class="col-md-12">
        <button class="btn btn-info ico_left btn-sm" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>New Enquiry</button>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-3">
        <input type="text" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date">
    </div>
    <div class="col-md-3">
        <input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
    </div>
    <div class="col-md-3">
        <button class="btn btn-info ico_right" onclick="list_reflect()">Submit&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
    </div>
</div>
<hr>
<div id="div_modal"></div>
<div id="div_content"></div>
<?= end_panel() ?>

<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function save_modal()
{
    $('#btn_save_modal').button('loading');
    $.post('save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}
function list_reflect()
{
    var from_date = $('#from_date_filter').val();
    var to_date = $('#to_date_filter').val();

    $.post('list_reflect.php', { from_date : from_date, to_date : to_date }, function(data){
        $('#div_content').html(data);
    });
}
list_reflect();
function update_modal(enquiry_id)
{
    $.post('update_modal.php', { enquiry_id : enquiry_id }, function(data){
        $('#div_modal').html(data);
    });
}
</script>
<?php 
include_once('../../layouts/admin_footer.php');
?>