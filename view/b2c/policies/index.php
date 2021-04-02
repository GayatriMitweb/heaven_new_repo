<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT cancellation_policy,refund_policy,privacy_policy,terms_of_use FROM `b2c_settings` where setting_id='1'"));

$cancellation_policy = $query['cancellation_policy'];
$refund_policy = $query['refund_policy'];
$privacy_policy = $query['privacy_policy'];
$terms_of_use = $query['terms_of_use'];
?>
<form id="section_policies">
    <legend>Define Policies</legend>
    <div class="row mg_bt_20">
        <div class="col-md-6 mg_bt_10">
            <h3 class="editor_title">Cancellation Policy</h3>
            <textarea class="feature_editor" id="cancellation" style="width:100%" name="cancellation" title="Cancellation Policy"><?= $cancellation_policy ?></textarea>
        </div>   
        <div class="col-md-6 mg_bt_10">
            <h3 class="editor_title">Refund Policy</h3>
            <textarea class="feature_editor" id="refund" style="width:100%" name="refund" title="Refund Policy"><?= $refund_policy ?></textarea>
        </div> 
        <div class="col-md-6 mg_bt_10">
            <h3 class="editor_title">Privacy Policy</h3>
            <textarea class="feature_editor" id="privacy" style="width:100%" name="privacy" title="Privacy Policy"><?= $privacy_policy ?></textarea>
        </div> 
        <div class="col-md-6 mg_bt_10">
            <h3 class="editor_title">Terms of Use</h3>
            <textarea class="feature_editor" id="terms_of_use" style="width:100%" name="terms_of_use" title="Terms of Use"><?= $terms_of_use ?></textarea>
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
$('#section_policies').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var images_array = new Array();
    var terms_of_use = $("#terms_of_use").val();
    var privacy = $("#privacy").val();
    var cancellation = $("#cancellation").val();
    var refund = $("#refund").val();
    
    images_array.push({
        'cancellation_policy':cancellation,
        'refund_policy':refund,
        'privacy_policy': privacy,
        'terms_of_use'  : terms_of_use
    });
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '9', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('9');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>