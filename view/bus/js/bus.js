/////////////********** Bus master save start ***********************************
$(function(){
  $('#frm_bust_master_save').validate({
    rules:{
            txt_bus_name : { required : true },
            txt_bus_capacity : { required : true },            
    },
    submitHandler:function(form){

      var base_url = $("#base_url").val();
      var bus_name = $("#txt_bus_name").val();
      var bus_capacity = $("#txt_bus_capacity").val();
      var bus_rows = $("#txt_bus_rows").val();
      var bus_cols = $("#txt_bus_cols").val();
      var bus_gap = $("#txt_gap").val();
      var bus_blank_space = $("#txt_blank_space").val();
      var bus_cabin_seat_status = $("#cmb_bus_cabin_seat_status").val();
      var bus_combination_status = $("#cmb_bus_combination_status").val();  

        
      $.post( 
               base_url+"controller/group_tour/bus/bus_master_save.php",
               { bus_name : bus_name, bus_capacity : bus_capacity },
               function(data) {   
                  msg_popup_reload(data);
               });
    }
  });
});
/////////////********** Bus master save end ***********************************

bus_layout_upload();
function bus_layout_upload()
{
  var type="adnary";
  var btnUpload=$('#bust_layout_upload');
  var status=$('#bus_layout_status');
  new AjaxUpload(btnUpload, {
    action: 'upload_bus_layout_image.php',
    name: 'uploadfile',
    onSubmit: function(file, ext){
      
       if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                  // extension is not allowed 
        status.text('Only JPG, PNG or GIF files are allowed');
        //return false;
      }
      status.text('Uploading...');
    },
    onComplete: function(file, response){
      //On completion clear the status
      status.text('');
      //Add uploaded file to list
      if(response==="error"){          
        alert("File is not uploaded.");           
        //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
      } else{
        ///$('<li></li>').appendTo('#files').text(file).addClass('error');
        document.getElementById("txt_bus_upload_dir").value = response;
        alert("File Uploaded Successfully.");  
      }
    }
  });

}