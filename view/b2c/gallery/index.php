<?php
include '../../../model/model.php';
$dest_id1 = $_POST['dest_id1'];
$query = mysql_fetch_assoc(mysql_query("SELECT gallery FROM `b2c_settings` where setting_id='1'"));
$gallery = $query['gallery'];
?>
<form id="section_gallery">
    <legend>Define Destinationwise Gallery Images</legend>

    <input type="hidden" value='<?=$gallery?>' id="gallery"/>
    <div class="row mg_bt_20">
        <div class="col-md-3">
            <select class="form-control" style="width:100%" name="dest_id" id="dest_id" onchange="images_reflect(this.id);" title="Select Destination" data-toggle="tooltip" required>
            <?php 
                if($dest_id1!=''){
                    $sq_dest1 = mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id='$dest_id1'"));
                ?>
                <option value="<?= $sq_dest1['dest_id'] ?>"><?= $sq_dest1['dest_name'] ?></option>
                <?php } ?>
                <option value="">Select Destination</option>
                <?php
                $sq_dest = mysql_query("select * from destination_master where status='Active'");
                while($row_dest = mysql_fetch_assoc($sq_dest)){
                ?>
                <option value="<?= $row_dest['dest_id'] ?>"><?= $row_dest['dest_name'] ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <!-- Banner Images for uploading -->
    <div id='banner_images'></div>

    <div class="row mg_tp_20">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
$('#dest_id').select2();
$(function(){
$('#section_gallery').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();
    var dest_id = $('#dest_id').val();
    
    var images_array = new Array();
    var gimages = $("#gimages").val();
    var nodest_gallery = JSON.parse($('#nodest_gallery').val());
    if(nodest_gallery.length>0){ 
        for(var i=0;i<nodest_gallery.length;i++){
            images_array.push(nodest_gallery[i]); 
        }
    }
    for(var i=0;i<gimages;i++){
        var image_url = $("#imagel"+parseInt(i)).val();
        if(image_url!=''){
            images_array.push({
            'dest_id' : dest_id,
            'image_url' : image_url
            })
        } 
    }
    var image_url = $("#image_upload_url1").val();
    if(image_url!=''){
        images_array.push({
        'dest_id' : dest_id,
        'image_url'    : image_url
        })
    }
    
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '14', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
            error_msg_alert(data[1]);
            }else{
            success_msg_alert(data[1]);
            reflect_data('14',dest_id);
            update_b2c_cache();
            }
        }
    });
}
});
});

function images_reflect(dest_id){

	var base_url = $('#base_url').val();
    var dest_id1 = $('#'+dest_id).val();
    var gallery = $('#gallery').val();
    if(dest_id1!=''){
        $.post('gallery/get_dest_images.php', { dest_id : dest_id1,gallery:gallery}, function(data){
            $('#banner_images').html(data);
        });
    }
    else
        $('#banner_images').html('');
}

function delete_image(image_id){
    var base_url = $("#base_url").val();
    var dest_id = $('#dest_id').val();
    var dest_gallery = JSON.parse($("#dest_gallery").val());
    var filtered =  dest_gallery.filter(function(value, index, dest_gallery){
                                    return index != parseInt(image_id); 
                    });
                    
    var nodest_gallery = JSON.parse($('#nodest_gallery').val());
    if(nodest_gallery.length>0){ 
        for(var i=0;i<nodest_gallery.length;i++){
            filtered.push(nodest_gallery[i]); 
        }
    }

    $('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure?',
        true_btn_text:'Yes',
        false_btn_text:'No',
        callback: function(data1){
            if(data1=="yes"){
                $.ajax({
                type:'post',
                url: base_url+'controller/b2c_settings/cms_delete.php',
                data:{ section_name : '14', banner_images : filtered},
                success: function(message){
                    
                    var data = message.split('--');
                    if(data[0] == 'erorr'){
                        error_msg_alert(data[1]);
                    }else{
                        reflect_data('14',dest_id);
                        success_msg_alert(data[1]);
                        
                    }
                }
                });
            }
        }
    });
}
images_reflect('dest_id');
</script>