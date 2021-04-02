<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT blogs FROM `b2c_settings` where setting_id='1'"));
$blogs = json_decode($query['blogs']);
$blogs = ($query['blogs'] == '') ? '' : $query['blogs'];
?>
<form id="section_blogs">
    <legend>Define Blog</legend>
    <input type="hidden" value='<?= $blogs ?>' id="blogs" name='blogs'/>
    <div class="row mg_bt_20">
        <div class="col-md-7">
            <input type="text" name="btitle" placeholder="Blog Title" id="btitle" title="Blog Title" class="form-control" required/>
        </div>
        <div class="col-md-1">          
            <div class="div-upload">
                <div id="id_upload_btn" class="upload-button1"><span>Upload</span></div>
                <span id="id_proof_status" ></span>
                <ul id="files"></ul>
                <input type="hidden" id="image_upload_url" name="image_upload_url">
            </div>
        </div>
        <div class="col-md-5" style="margin-left:60%">
            <div style="color: red;">Note :Upload Image below 200KB, Format :JPEG,JPG,PNG</div>
        </div>
    </div>
    <div class="row mg_bt_20">
        <div class="col-md-12">
            <textarea name="desc" placeholder="Description(Upto 2000 chars)" title="Description(Upto 2000 chars)" class="form-control" id="desc" onchange="validate_char_size('desc',2000);" rows="5" required></textarea>
        </div>
    </div>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save1"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
upload_blog_image();
function upload_blog_image(){
    var btnUpload=$('#id_upload_btn');
    $(btnUpload).find('span').text('Image');

    new AjaxUpload(btnUpload, {
        action: 'blogs/upload_blog_img.php',
        name: 'uploadfile',
        onSubmit: function(file, ext)
        {
            if (! (ext && /^(png|jpeg|jpg)$/.test(ext))){ 
            error_msg_alert('Only JPG,JPEG,PNG files are allowed');
            return false;
            }
            $(btnUpload).find('span').text('Uploading...');
        },
        onComplete: function(file, response){
            var response1 = response.split('--');
            if(response1[0]=="error"){
                error_msg_alert(response1[1]);
                $(btnUpload).find('span').text('Image');
            }
            else{
                $(btnUpload).find('span').text('Uploaded');
                $("#image_upload_url").val(response);
            }
        }
    });
}

$(function(){
$('#section_blogs').validate({
    rules:{
    },
    submitHandler:function(form){

        var base_url = $('#base_url').val();

        var blogs = $("#blogs").val();
        if(blogs == ''){
            blogs = [];
        }else{
            blogs = JSON.parse(blogs);
        }
        var btitle = $("#btitle").val();
        var image = $("#image_upload_url").val();
        var description = $("#desc").val();
        if(image === ''){
            error_msg_alert("Upload image!"); return false;
        }
        var flag1 = validate_char_size('desc',2000);
        if(!flag1){
            return false;
        }
        blogs.push({
            'title':btitle,
            'image':image,
            'description':escape(description)
        });
        $('#btn_save1').button('loading');
        $.ajax({
        type:'post',
        url: base_url+'controller/b2c_settings/cms_save.php',
        data:{ section : '13', data : blogs},
            success: function(message){
            $('#btn_save1').button('reset');
                var data = message.split('--');
                if(data[0] == 'erorr'){
                    error_msg_alert(data[1]);
                }else{
                    success_msg_alert(data[1]);
                    reflect_data('13');
                    update_b2c_cache();
                }
            }
        });
    }
});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>