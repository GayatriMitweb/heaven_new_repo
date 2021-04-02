function get_why_choose_images(image_url){
    var cmp_image_url = $('#'+image_url).val();
    $.ajax({
        type:'post',
        url: 'cms/inc/why_choose_us/get_why_choose_images.php',
        data:{image_url:image_url,cmp_image_url:cmp_image_url},
        success:function(result){
         $('#image_modal').html(result);
        }
    });
}