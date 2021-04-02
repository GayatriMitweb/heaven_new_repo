
//Get destination ideas Icons
function get_icons(image_url){
    var base_url = $('#base_url').val();
    var cmp_image_url = $('#'+image_url).val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_icons.php',
        data:{image_url:image_url,cmp_image_url:cmp_image_url},
        success:function(result){
         $('#image_modal').html(result);
        }
    });
}
//Destination Images load
function get_dest_images(dest_id,image_url){
    var base_url = $('#base_url').val();
    var dest_id = $('#'+dest_id).val();
    var cmp_image_url = $('#'+image_url).val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/popular_destinations/get_dest_images.php',
        data:{dest_id:dest_id,image_url:image_url,cmp_image_url:cmp_image_url},
        success:function(result){
         $('#image_modal').html(result);
        }
    });
}

//Excursion load
function excursion_dynamic_reflect(city_name){
    var offset = city_name.split('-');
	var city_id = $("#"+city_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url + 'view/b2b_settings/cms/inc/popular_activities/get_excursions.php', 
		data: { city_id : city_id}, 
		success: function(result){
			$('#exc-'+offset[1]).html(result);
		}
	});
}

//Pacakges load
function package_dynamic_reflect(dest_name){
    var offset = dest_name.split('-');
	var dest_id = $("#"+dest_name).val();
    var base_url = $('#base_url').val();
	$.ajax({
		type:'post',
		url: base_url + 'view/b2b_settings/cms/inc/popular_destinations/get_packages.php', 
		data: { dest_id : dest_id}, 
		success: function(result){
			$('#package-'+offset[1]).html(result);
		}
	});
}

//Hotel list load
function hotel_names_load (id,offset) {
    var offset = id.split('-');
	var base_url = $('#base_url').val();
	var city_id = $('#' + id).val();
	$.post(base_url + 'Tours_B2B/view/hotel/inc/hotel_list_load.php', { city_id: city_id }, function (data) {
		$('#hotel_name-'+offset[1]).html(data);
	});
}
function load_images(){
	var base_url = $('#base_url').val();
    var section_name = $('#section_name').val();
    $.ajax({
          type:'post',
          url: base_url + 'view/b2b_settings/cms/inc/banners/display_banner_images.php',
          data:{section_name:section_name},
          success:function(result){
           $('#images_list').html(result);
          }
    });
}
function load_why_choose_section(){
	var base_url = $('#base_url').val();
    $.ajax({
        type:'post',
        url: base_url + 'view/b2b_settings/cms/inc/why_choose_us/display_section.php',
        data:{},
        success:function(result){
        $('#images_list').html(result);
        }
  });
}
function banner_images_reflect(banner_count){
    var banner_count = $('#'+banner_count).val();
    var section_name = $('#section_name').val();
	var base_url = $('#base_url').val();
    if(banner_count!=''){
        var banner_uploaded_count = $('#banner_uploaded_count').val();
        var total_upload_count = parseInt(banner_count)+parseInt(banner_uploaded_count);
        if(parseInt(total_upload_count)<=5){
                $.post(base_url + 'view/b2b_settings/cms/inc/banners/get_banner_images.php', { banner_uploaded_count:banner_uploaded_count,banner_count : banner_count}, function(data){
                    $('#banner_images').html(data);
                });
        }
        else{
            error_msg_alert('You can upload max 5 images. Already uploaded '+banner_uploaded_count+' images!');
            return false;
        }
    }
    else
        $('#banner_images').html('');
}
function ideas_cms_reflect(ideas_count){
    var ideas_count = $('#'+ideas_count).val();
	var base_url = $('#base_url').val();
    if(ideas_count!=''){
        var uploaded_count = $('#uploaded_count').val();
        var total_upload_count = parseInt(ideas_count)+parseInt(uploaded_count);
        if(parseInt(total_upload_count)<=6){
            $.post(base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_ideas_cms.php', { uploaded_count:0,ideas_count : ideas_count}, function(data){
                $('#images_list').html(data);
            });
        }
        else{
            error_msg_alert('You can upload max 6 ideas. Already uploaded '+uploaded_count+' ideas!');
            return false;
        }
    }
    else
        $('#ideas_data').html('');
}
function ideas_data_reflect(){
    var base_url = $('#base_url').val();
    $.post(base_url + 'view/b2b_settings/cms/inc/destination_ideas/get_ideas_data.php', {  }, function(data){
        $('#ideas_data').html(data);
    });
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
        url: base_url+'controller/b2b_settings/cms/cms_delete.php',
        data:{ section_name : section_name, banner_images : filtered},
        success: function(message){
            
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
            }
            
            if(section_name == '1'){
                document.getElementById('banner_count').selectedIndex=0;
                banner_images_reflect('banner_count');
                load_images();
            }
            else if(section_name == '2'){
                load_why_choose_section();
            }
        }
        });
    }
    }
    });
}