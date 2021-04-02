<form id="frm_tab2">
  <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

      <legend>Contact Person Details</legend>
      <div class="row text-center mg_tp_10">
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="text" id="contact_personf" name="contact_personf" placeholder="*First Name" title="First Name" required> 
          </div>
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="text" id="contact_personl" name="contact_personl" placeholder="*Last Name" title="Last Name" required> 
          </div>
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="text" id="email_id" name="email_id" placeholder="*Email ID"  title="Email ID" onchange="validate_email(this.id)" required >
          </div>
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="text" id="mobile_no" name="mobile_no" placeholder="*Mobile No" title="Mobile No" onchange="mobile_validate(this.id);" required>
          </div>
      </div>
      <div class="row text-center mg_tp_10">
        <div class="col-md-3 col-sm-6">
            <input class="form-control" type="text"  id="whatsapp_no" name="whatsapp_no" placeholder="Whatsapp No" title="Whatsapp No">
        </div>
        <div class="col-md-3 col-sm-6">
            <input class="form-control" type="text" id="designation" name="designation" placeholder="Designation" title="Designation">
        </div>
        <div class="col-md-3 col-sm-6">
            <input class="form-control" type="text"  id="pan_card" name="pan_card" placeholder="PAN Card No" title="PAN Card No">
        </div>
        <div class="col-md-3 col-sm-6 text-left">
          <div class="div-upload">
            <div id="photo_upload_btn_p" class="upload-button1"><span>ID Proof</span></div>
            <span id="photo_status" ></span>
            <ul id="files" ></ul>
            <input type="hidden" id="photo_upload_url" name="photo_upload_url">
          </div>
        </div>
      </div>
  </div>
  <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

      <legend>Access Details</legend>
      <div class="row text-center mg_tp_10">
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="text" id="username" name="username" placeholder="*Username" title="Username" required> 
          </div>
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="password" id="password" name="password" placeholder="*Password" title="Password" required> 
          </div>
          <div class="col-md-3 col-sm-6">
              <input class="form-control" type="password" id="repassword" name="repassword" placeholder="*Re-enter Password"  title="Re-enter Password" required >
          </div>
      </div>
  </div>
        
  <div class="row text-center">
    <div class="col-md-12">
      <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Previous</button>
      &nbsp;&nbsp;
      <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
    </div>
  </div>

</form>

<script>
function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }

upload_id_proof();
function upload_id_proof(){

    var btnUpload=$('#photo_upload_btn_p');
    $(btnUpload).find('span').text('ID Proof');
    new AjaxUpload(btnUpload, {
      action: '../b2b_customer/inc/upload_photo_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  
        if (! (ext && /^(pdf|jpg|png|jpeg)$/.test(ext))){ 
         error_msg_alert('Only PDF,JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },

      onComplete: function(file, response){

        if(response==="error"){          
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload');
        }else{ 

          $(btnUpload).find('span').text('Uploaded');
          $("#photo_upload_url").val(response);
        }
      }
    });
}

$('#frm_tab2').validate({
  rules:{
  },
  submitHandler:function(form){
    
        var base_url = $('#base_url').val();

        //Basic Details
        var company_name = $("#company_name").val();
        var acc_name = $("#acc_name").val();
        var iata_status = $("#iata_status").val();
        var iata_reg = $("#iata_reg").val();
        var nature = $("#nature").val();
        var currency = $("#currency").val();
        var telephone = $('#telephone').val(); 
        var latitude = $("#latitude").val();
        var turnover_slab = $("#turnover_slab").val();
        var skype_id = $("#skype_id").val();
        var website = $("#website").val();
        var company_logo = $("#logo_upload_url").val();
        //Address Details
        var city = $("#city").val();
        var address1 = $("#address1").val(); 
        var address2 = $("#address2").val(); 
        var pincode = $("#pincode").val();
        var country = $('#country').val();
        var state = $('#cust_state').val();
        var timezone = $('#timezone').val(); 
        var address_upload_url = $('#address_upload_url').val();

        //Contact Person Details
        var contact_personf = $('#contact_personf').val();
        var contact_personl = $('#contact_personl').val();
        var email_id = $('#email_id').val();
        var mobile_no = $('#mobile_no').val();
        var whatsapp_no = $('#whatsapp_no').val();
        var designation = $('#designation').val();
        var pan_card = $('#pan_card').val();
        var photo_upload_url = $('#photo_upload_url').val();

        //Access Details
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if(password !== repassword){
          error_msg_alert('Password do not match!'); return false;
        }

      $('#btn_save').button('loading');
      $.ajax({
      type:'post',
      url: base_url+'controller/b2b_customer/customer_save.php',
      data:{ company_name : company_name, acc_name : acc_name, iata_status : iata_status, iata_reg : iata_reg, nature : nature, currency : currency, telephone : telephone, latitude : latitude, turnover_slab : turnover_slab, skype_id : skype_id, website : website,company_logo:company_logo,
        address1 : address1,address2 : address2, city : city , pincode : pincode , country : country, timezone : timezone, address_upload_url : address_upload_url,
        contact_personf : contact_personf , contact_personl : contact_personl,email_id:email_id, mobile_no : mobile_no, whatsapp_no : whatsapp_no, designation : designation, pan_card : pan_card, photo_upload_url : photo_upload_url,
        username : username, password : password,state:state},
      success: function(message){
          var data = message.split('--');
          if(data[0] == 'error'){
            error_msg_alert(data[1]);
            $('#btn_save').button('reset');
            return false;
          }
          else{
            success_msg_alert(message);
            $('#save_modal').modal('hide');
            customer_list_reflect();
          }
      }
    });
  } 
});
</script>