<form id="frm_tab1">

	<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

	     <legend>Basic Details</legend>                

          <div class="row mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" type="text" id="company_name" name="company_name" placeholder="*Company Name" title="Company Name" data-toggle="tooltip" required /> 
              </div>
              <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" type="text" id="acc_name" name="acc_name" placeholder="Accounting Name" title="Accounting Name" data-toggle="tooltip"/>
              </div>
              <div class="col-md-3 col-sm-6 mg_bt_10">
                  <select class="form-control" id='iata_status' title='IATA Status' data-toggle="tooltip" name='iata_status'>
                    <option value=''>IATA Status</option>
                    <option value='Approved'>Approved</option>
                    <option value='Not Approved'>Not Approved</option>
                  </select>
              </div>
              <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" type="text" id="iata_reg" name="txt_mobile_no1" placeholder="IATA Reg.No" title="IATA Reg.No" data-toggle="tooltip"/>
              </div>
          </div>

          <div class="row">
          		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input class="form-control" type="text" id="nature" name="nature" placeholder="Nature Of Business" title="Nature Of Business" data-toggle="tooltip"/>
              </div>
	            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                <select class="form-control" id='currency' title='Preferred Currency' name='currency' style='width:100%;' data-toggle="tooltip">
                  <option value=''>Preferred Currency</option>
                  <?php
                  $sq_currency = mysql_query("select id,currency_code from currency_name_master where 1");
                  while($row_currency = mysql_fetch_assoc($sq_currency)){ ?>
                    <option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
                  <?php } ?>
                </select>
	            </div>
              <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="telephone" name="telephone" placeholder="Telephone" title="Telephone"/>
              </div>
              <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="latitude" name="latitude" placeholder="Latitude" title="Latitude"/>
              </div>
            </div>

            <div class="row mg_tp_10">
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="turnover_slab" name="turnover_slab" placeholder="Turnover Slab" title="Turnover Slab"/>
                </div>
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="skype_id" name="skype_id" placeholder="Skype ID" title="Skype ID"/>
                </div>
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="website" name="website" placeholder="Website" title="Website"/>
                </div>
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <div class="div-upload">
                    <div id="logo_upload_btn1" class="upload-button1"><span>Company Logo</span></div>
                    <span id="logo_proof_status" ></span>
                    <ul id="files" ></ul>
                    <input type="hidden" id="logo_upload_url" name="logo_upload_url" required>
                  </div>
                </div>
            </div>
            <div class="row text-right mg_tp_10">
              <div class="col-xs-12"> 
                  <div style="color: red;">Note : Upload Image size below 100KB, resolution : 220X85.</div>
              </div>
            </div>
        </div>

        <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
  	    <legend>Address Details</legend>

        	<div class="row mg_tp_10">
            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
              <select id='city' name='city' class='form-control' style='width:100%;' title="City Name" required>
                <?php get_cities_dropdown();?>
              </select>
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
              <input type="text" id="address1" name="address1" placeholder="Address1" title="Address1"/>
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
              <input type="text" id="address2" name="address2" placeholder="Address2" title="Address2"/>
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
              <input type="text" id="pincode" name="pincode" placeholder="Pincode" title="Pincode"/>
            </div>
          </div>
          <div class="row mg_tp_10">
              <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                <select class="form-control" id='country' title='Country' name='country' style='width:100%;'>
                  <option value=''>Country</option>
                  <?php
                  $sq_country = mysql_query("select * from country_list_master where 1");
                  while($row_country = mysql_fetch_assoc($sq_country)){ ?>
                    <option value="<?= $row_country['country_id'] ?>"><?= $row_country['country_name'].'('.$row_country['country_code'].')' ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                <input type="text" id="timezone" name="timezone" placeholder="Timezone" title="Timezone"/>
              </div>
	            <div class="col-md-6 col-sm-6 mg_bt_10_xs">
	              <div class="div-upload" role='button' title="Upload Address Proof" data-toggle="tooltip">
	                <div id="address_upload_btn1" class="upload-button1"><span>Address Proof</span></div>
	                <span id="id_proof_status" ></span>
	                <ul id="files" ></ul>
	                <input type="hidden" id="address_upload_url" name="address_upload_url">
	              </div>
                  <p style="color: red;">Note : Only PDF,JPG, PNG or GIF files are allowed.</p>
	            </div>
             
	        </div>
	    </div>
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
              <div class="div-upload" role='button' title="Upload ID Proof" data-toggle="tooltip">
                <div id="photo_upload_btn_p" class="upload-button1"><span>ID Proof</span></div>
                <span id="photo_status" ></span>
                <ul id="files" ></ul>
                <input type="hidden" id="photo_upload_url" name="photo_upload_url">
              </div>
              <div class="col-xs-12"> 
                  <div style="color: red;">Note : Only PDF,JPG, PNG or GIF files are allowed.</div>
              </div>
            </div>
          </div>
      </div>
      <div class="row text-center">
        <div class="col-xs-12">
        <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
        </div>
      </div>
</form>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
$('#currency').select2();
$('#city,#country').select2({minimumInputLength:1});

upload_logo_proof();
function upload_logo_proof(){
    var btnUpload=$('#logo_upload_btn1');
    $(btnUpload).find('span').text('Company Logo');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_logo.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(png|jpg|jpeg)$/.test(ext))){ 
         error_msg_alert('Only PNG,JPG or JPEG files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
       // alert(response);
        if(response=="error1"){
            $(btnUpload).find('span').text('Company Logo');
            error_msg_alert('Maximum size exceeds');
            return false;
        }
        else if(response==="error"){
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#logo_upload_url").val(response);
        }
      }
    });
}

upload_address_proof();
function upload_address_proof(){
    var btnUpload=$('#address_upload_btn1');
    $(btnUpload).find('span').text('Address Proof');    

    new AjaxUpload(btnUpload, {
      action: '../inc/upload_address_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only PDF,JPG, PNG or GIF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },

      onComplete: function(file, response){

        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#address_upload_url").val(response);
        }
      }
    });
}

upload_id_proof();
function upload_id_proof(){

    var btnUpload=$('#photo_upload_btn_p');
    $(btnUpload).find('span').text('ID Proof');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_photo_proof.php',
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
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#photo_upload_url").val(response);
        }
      }
    });
}

$(function(){
$('#frm_tab1').validate({
	rules:{
	},
	submitHandler:function(form){
  
  var base_url = $('#base_url').val();
  var company_logo = $("#logo_upload_url").val();
  if(company_logo==''){
    error_msg_alert('Company logo required!'); return false;
  }
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

  //Address Details
  var city = $("#city").val();
  var address1 = $("#address1").val(); 
  var address2 = $("#address2").val(); 
  var pincode = $("#pincode").val();
  var country = $('#country').val();
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

  $('#btn_save').button('loading');
  $.ajax({
      type:'post',
      url: '../../../controller/b2b_customer/reg_customer_save.php',
      data:{ company_name : company_name, acc_name : acc_name, iata_status : iata_status, iata_reg : iata_reg, nature : nature, currency : currency, telephone : telephone, latitude : latitude, turnover_slab : turnover_slab, skype_id : skype_id, website : website, 
      address1 : address1,address2 : address2, city : city , pincode : pincode , country : country, timezone : timezone, address_upload_url : address_upload_url,
      contact_personf : contact_personf , contact_personl : contact_personl,email_id:email_id, mobile_no : mobile_no, whatsapp_no : whatsapp_no, designation : designation, pan_card : pan_card, photo_upload_url : photo_upload_url,company_logo:company_logo},
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
          setInterval(() => {
            window.location.replace('../../../Tours_B2B/login.php');
          },1000);
        }
      }
      });
  }
});
});
</script>