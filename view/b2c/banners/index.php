<?php
include '../../../model/model.php';
$query = mysql_fetch_assoc(mysql_query("SELECT banner_images FROM `b2c_settings` where setting_id='1'"));
$images = json_decode($query['banner_images']);
?>
<form id="section_banner">
    <legend>Define Home Page Banner Images</legend>
    <input type="hidden" value="<?=sizeof($images)?>" id="banner_uploaded_count"/>
    <input type="hidden" value='<?=$query['banner_images']?>' id="banner_uploaded_images"/>
    <div class="row mg_bt_20">
        <div class="col-md-3">
            <select class="form-control" style="width:100%" name="banner_count" id="banner_count" onchange="banner_images_reflect(this.id);" title="Select No of Images" data-toggle="tooltip">
            <option value=""><?= 'No of Images' ?></option>
            <?php for($i=1;$i<=5;$i++){ ?>
            <option value="<?= $i ?>"><?= $i ?></option>
            <?php } ?>
            </select>
        </div> 
        <div class="col-xs-9"> 
            <div style="color: red;">Note : Upload Image size below 1MB, resolution : 1800*400, Format : JPEG,JPG.</div>
        </div>
    </div>
    <!-- Banner Images for uploading -->
    <div id='banner_images'></div>

    <!-- Banner Images from database -->
    <?php if(sizeof($images) > 0){ ?>
    <div class="row mg_bt_20">
        <?php
        for($i=0;$i<sizeof($images);$i++){
            $url = $images[$i]->image_url;
            $pos = strstr($url,'uploads');
            if ($pos != false){
                $newUrl1 = preg_replace('/(\/+)/','/',$images[$i]->image_url); 
                $download_url = BASE_URL.str_replace('../', '', $newUrl1);
            }else{
                $download_url =  $images[$i]->image_url; 
            }
            ?>
            <div class="col-md-2">
                <div class="gallary-single-image mg_bt_20" style="height:100px;max-height: 100px;overflow:hidden;">
                <input type="hidden" value="<?= $images[$i]->image_url ?>" id="imagel<?=$i?>"/>
                    <img src="<?php echo $download_url; ?>" id="<?php echo $images[$i]->banner_count; ?>" width="100%" height="100%">
                    <span class="img-check-btn"><button type="button" class="btn btn-danger btn-sm" onclick="delete_image('<?php echo $images[$i]->banner_count; ?>')" title="Delete Image" data-toggle="tooltip"><i class="fa fa-times" aria-hidden="true"></i></button></span>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$(function(){
$('#section_banner').validate({
  rules:{
  },
  submitHandler:function(form){

    var base_url = $('#base_url').val();
    var banner_uploaded_count = $('#banner_uploaded_count').val();
    var activeTab = '';
    
    var images_array = new Array();
    var image_count = $('#banner_count').val();

    for(var i=0;i<banner_uploaded_count;i++){
        var image_url = $("#imagel"+parseInt(i)).val();
        if(image_url!=''){
            images_array.push({
            'banner_count' : (i+1),
            'image_url'    : image_url
            })
        } 
    }
    for(var i=1;i<=image_count;i++){
        
        banner_uploaded_count = parseInt(banner_uploaded_count) + 1;
        var image_url = $("#image_upload_url"+parseInt(i-1)).val();
        if(image_url!=''){
            images_array.push({
            'banner_count' : banner_uploaded_count,
            'image_url'    : image_url
            })
        }
    }
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '1', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
            error_msg_alert(data[1]);
            }else{
            success_msg_alert(data[1]);
            reflect_data('1');
            update_b2c_cache();
            }
        }
    });
}
});
});
function banner_images_reflect(banner_count){

	var base_url = $('#base_url').val();
    var banner_count = $('#'+banner_count).val();
    if(banner_count!=''){
        var banner_uploaded_count = $('#banner_uploaded_count').val();
        var total_upload_count = parseInt(banner_count) + parseInt(banner_uploaded_count);
        if(parseInt(total_upload_count)<=5){
                $.post('banners/get_banner_images_section.php', { banner_uploaded_count:banner_uploaded_count,banner_count : banner_count}, function(data){
                    $('#banner_images').html(data);
                });
        }
        else{
            error_msg_alert('You can upload max 5 images. Already uploaded '+banner_uploaded_count+' image(s)!');
            return false;
        }
    }
    else
        $('#banner_images').html('');
}

function delete_image(image_id){
    var base_url = $("#base_url").val();
    var section_name = $('#section_name').val();
    var banner_uploaded_images = JSON.parse($("#banner_uploaded_images").val());
    var filtered = banner_uploaded_images.filter(function(value, index, banner_uploaded_images){
                                    return parseInt(value['banner_count']) != parseInt(image_id); });
    
    $('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure?',
        true_btn_text:'Yes',
        false_btn_text:'No',
    callback: function(data1){
    if(data1=="yes"){    
        $.ajax({
        type:'post',
        url: base_url+'controller/b2c_settings/cms_delete.php',
        data:{ section_name : '1', banner_images : filtered},
        success: function(message){
            
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('1');
            }
        }
        });
    }
    }
    });
}
</script>