<?php
include '../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT social_media FROM `b2c_settings` where setting_id='1'"));
$social_media = json_decode($query['social_media']);
?>
<form id="section_scm">
    <legend>Define Social Media Links</legend>
    <div class="row mg_bt_20">
        <div class="col-md-3 mg_bt_10">
            <h6>Facebook</h6>
            <input type='text' name='bf' id='fb' value='<?= $social_media[0]->fb ?>' onchange="validURL(this.id)"/>
        </div>
        <div class="col-md-3 mg_bt_10">
            <h6>Twitter</h6>
            <input type='text' name='tw' id='tw' value='<?= $social_media[0]->tw ?>' onchange="validURL(this.id)"/>
        </div>
        <div class="col-md-3 mg_bt_10">
            <h6>LinkedIn</h6>
            <input type='text' name='li' id='li' value='<?= $social_media[0]->li ?>' onchange="validURL(this.id)"/>
        </div>
        <div class="col-md-3 mg_bt_10">
            <h6>Whats App</h6>
            <input type='text' name='wa' id='wa' value='<?= $social_media[0]->wa ?>' onchange="validURL(this.id)"/>
        </div>
        <div class="col-md-3 mg_bt_10">
            <h6>YouTube</h6>
            <input type='text' name='yu' id='yu' value='<?= $social_media[0]->yu ?>' onchange="validURL(this.id)"/>
        </div>
        <div class="col-md-3 mg_bt_10">
            <h6>Instagram</h6>
            <input type='text' name='inst' id='inst' value='<?= $social_media[0]->inst ?>' onchange="validURL(this.id)"/>
        </div>
    </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script>

$(function(){
$('#section_scm').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var images_array = new Array();
    var fb = $("#fb").val();
    var tw = $("#tw").val();
    var li = $("#li").val();
    var wa = $("#wa").val();
    var yu = $("#yu").val();
    var inst = $('#inst').val();

    var flag1 = validURL('fb');
    if(!flag1) {
		error_msg_alert('Invalid url: '+fb);
		return false;
    }
    flag1 = validURL('tw');
    if(!flag1) {
		error_msg_alert('Invalid url: '+tw);
		return false;
    }
    flag1 = validURL('li');
    if(!flag1) {
		error_msg_alert('Invalid url: '+li);
		return false;
    }
    flag1 = validURL('wa');
    if(!flag1) {
		error_msg_alert('Invalid url: '+wa);
		return false;
    }
    flag1 = validURL('yu');
    if(!flag1) {
		error_msg_alert('Invalid url: '+yu);
		return false;
    }
    flag1 = validURL('inst');
    if(!flag1) {
		error_msg_alert('Invalid url: '+inst);
		return false;
    }
    images_array.push({
        'fb':fb,
        'tw':tw,
        'li': li,
        'wa'  : wa,
        'yu'  : yu,
        'inst':inst
    });
    $('#btn_save').button('loading');
    
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '10', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('10');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>