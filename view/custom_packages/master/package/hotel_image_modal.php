<form id="frm_hotel_image_save">
<div class="app_panel"> 

 <!--=======Header panel======-->
    <div class="app_panel_head">
      <div class="container">
        <h2 class="pull-left"></h2>
        <div class="pull-right header_btn">
          <button>
              <a data-original-title="" title="">
                  <i class="fa fa-arrow-right"></i>
              </a>
          </button>
        </div>
        <div class="pull-right header_btn">
          <button type="button" onclick="back_to_tab_1()">
              <a data-original-title="" title="">
                  <i class="fa fa-arrow-left"></i>
              </a>
          </button>
        </div>
      </div>
    </div>
  <!--=======Header panel end======-->
  <div class="container">
     <div class="app_panel_content no-pad">
            <div class="row mg_tp_20">        
                <div class="col-sm-3 mg_bt_10_sm_xs">
                  <select id="hotel_names" name="hotel_names" onchange="load_images(this.value)">
                    <option value="">Select Hotel</option>
                  </select>
                </div>
                <div class="col-sm-9">
                    <div class="div-upload">
                      <div id="hotel_upload_btn" class="upload-button1"><span>Upload Images</span></div>
                      <span id="id_proof_status" ></span>
                      <ul id="files" ></ul>
                      <input type="Hidden" id="hotel_upload_url" name="hotel_upload_url">
                   </div>(Upload Maximum 3 photos)
                </div>
            </div>
            <div class="row mg_tp_10">     
              <div class="col-sm-9 col-sm-offset-3">  
                <span style="color: red;" class="note">Note : Image size should be less than 100KB, resolution : 900X450.</span>
              </div>
            </div>
            <div class="row mg_tp_20 mg_bt_20" id="images_list"></div>
     </div>
  </div>
  <div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_0">
     <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;
     <button class="btn btn-sm btn-info ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
  </div>
 </div>        
</form>

<script>
$(function(){
  $('#frm_hotel_image_save').validate({
    rules:{
    },

    submitHandler:function(form){
        var valid_state = table_info_validate();
        if(valid_state==false){ return false; }

        $('#tab_2_head').addClass('done');
        $('#tab_3_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab_3').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

        return false;
    }
  });
});



upload_hotel_pic_attch();
function upload_hotel_pic_attch()
{
     
    var btnUpload=$('#hotel_upload_btn');
    $(btnUpload).find('span').text('Upload Images');
    $("#hotel_upload_url").val('');
    var hotel_names = $('#hotel_names').val();

    new AjaxUpload(btnUpload, {
      action: 'upload_ticket.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  
        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload Images');
        }else
        { 
          if(response=="error1")
          {
            $(btnUpload).find('span').text('Upload Images');
            error_msg_alert('Maximum size exceeds');
            return false;
          }else
          {
            if(hotel_names != ''){
              $(btnUpload).find('span').text('Uploaded'); 
              $("#hotel_upload_url").val(response); }
            else{
              $(btnUpload).find('span').text('Upload Images');
              $("#hotel_upload_url").val(response);  
            }
            upload_pic();            
          }
        }
      }
    });
}

function upload_pic(){

  var base_url = $("#base_url").val();
  var hotel_upload_url = $('#hotel_upload_url').val();
  var hotel_names = $('#hotel_names').val();

  if(hotel_names == ''){
   error_msg_alert("Select Hotel first"); return false;
  }
  $.ajax({
          type:'post',
          url: base_url+'controller/hotel/hotel_img_save_c.php',
          data:{ hotel_upload_url : hotel_upload_url,hotel_names : hotel_names },
          success:function(result)
          {
            msg_alert(result);
            load_images(hotel_names);
          }
  });
}

function back_to_tab_1(){

  $('#tab_2_head').removeClass('active');
  $('#tab_1_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab_1').addClass('active');
  $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
  $("#hotel_names").html('');  
  var opt = new Option('Select Hotel','');
  $("#hotel_names").append(opt);      

}

</script>