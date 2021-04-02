<?php
include '../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT header_strip_note FROM `b2c_settings` where setting_id='1'"));
?>
<form id="section_scm">
    <legend>Define Header Strip Note</legend>
    <div class="row mg_bt_20">
        <div class="col-md-6 mg_bt_10">
            <input type='text' name='header_strip_note' id='header_strip_note' value='<?= $query['header_strip_note'] ?>' placeholder="Eg. Mon - Sat 08:00  18:00 Sunday Closed" title="Eg.Mon - Sat 08:00  18:00 Sunday Closed" required/>
        </div>
    </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>

$(function(){
$('#section_scm').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var images_array = new Array();
    var header_strip_note = $("#header_strip_note").val();
    images_array.push({
        'header_strip_note':header_strip_note
    });
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '11', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('11');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>