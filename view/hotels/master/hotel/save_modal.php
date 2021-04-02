<?php
include "../../../../model/model.php";
$client_modal_type = $_POST['client_modal_type'];
?>
<input type="hidden" id="client_modal_type" name="client_modal_type" value="<?= $client_modal_type ?>">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style='width:80%'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Hotel Supplier Details</h4>
      </div>
      <div class="modal-body">
		  <form id="frm_hotel_save"> 
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
         <legend>Basic Information</legend>           
         <div class="row mg_bt_10"> 
            <div class="col-md-2 col-sm-6 ">
                <select id="cmb_city_id" name="cmb_city_id" class="form-control" style="width:100%" title="Select City Name">
                    <?php //get_cities_dropdown(); ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-6 ">
                <input type="text" class="form-control" id="txt_hotel_name" onchange="validate_spaces(this.id);" onkeypress="return blockSpecialChar(event);" name="txt_hotel_name" placeholder="*Hotel Name" title="Hotel Name" required>        
            </div>
            <div class="col-md-2 col-sm-6 ">
                <input type="text" class="form-control" id="txt_mobile_no" onchange="mobile_validate(this.id);" name="txt_mobile_no" placeholder="Mobile Number" title="Mobile Number">
            </div>	
            <div class="col-md-2 col-sm-6 ">
                <input type="text" class="form-control" id="txt_landline_no" name="txt_landline_no" placeholder="Landline Number" title="Landline Number">
            </div>
            <div class="col-md-2 col-sm-6 ">
                <input type="text" class="form-control" id="txt_email_id" name="txt_email_id"  placeholder="Email ID" title="Email ID" onchange="validate_email(this.id)">
            </div>
            <div class="col-md-2 col-sm-6 ">
                <input type="text" class="form-control" id="txt_email_id_1" name="txt_email_id"  placeholder="Alternative Email ID 1" title="Alternative Email ID 1" onchange="validate_email(this.id)">
            </div>
            
         </div>
        <div class="row mg_bt_10">
             <div class="col-md-2 col-sm-6 ">
                  <input type="text" class="form-control" id="txt_email_id_2" name="txt_email_id"  placeholder="Alternative Email ID 2" title="Alternative Email ID 2" onchange="validate_email(this.id)">
              </div>
              <div class="col-md-2 col-sm-6 ">
                  <input type="text" class="form-control" id="txt_contact_person_name" name="txt_contact_person_name" placeholder="Contact Person Name" title="Contact Person Name">
              </div> 
            <div class="col-md-2 col-sm-6 ">
                <input type="text" id="immergency_contact_no"  onchange="mobile_validate(this.id);" name="immergency_contact_no" placeholder="Emergency Contact No" title="Emergency Contact No" >
            </div>
            <div class="col-sm-2 col-xs-12 ">
                  <select name="state" id="state" title="Select State" style="width:100%" required>
                    <?php get_states_dropdown() ?>
                  </select>
            </div>
            <div class="col-md-2 col-sm-6 ">
              <input type="text" id="country" name="country" placeholder="Country" title="Country">
            </div>
            <div class="col-md-2 col-sm-6 ">
              <input type="text" id="website" name="website" placeholder="Website" title="Website">
            </div>
            
        </div>
        <div class="row mg_bt_10">
          <div class="col-md-2 col-sm-6 ">
              <select name="rating_star" id="rating_star" class="form-control" title="Hotel Category" style='width:100%' >
                <option value=''>Hotel Category</option>
                <option value="1 Star">1 Star</option>
                <option value="2 Star">2 Star</option>
                <option value="3 Star">3 Star</option>
                <option value="4 Star">4 Star</option>
                <option value="5 Star">5 Star</option>
                <option value="7 Star">7 Star</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-2 col-sm-6 ">
              <select name="hotel_type" id="hotel_type" title="Hotel Type" style='width:100%' style='width:100%' class="form-control">
              <?php get_hotel_type_dropdown(); ?>
              </select>
            </div>
            <div class="col-md-2 col-sm-6 ">
              <select name="meal_plan" id="meal_plan" title="Meal Plan" class="form-control" style='width:100%'>
              <?php get_mealplan_dropdown(); ?>
              </select>
            </div>
            <div class="col-md-4 col-sm-6 ">
              <textarea id="txt_hotel_address" onchange="validate_address(this.id);" name="txt_hotel_address" placeholder="Hotel Address" class="form-control" title="Hotel Address" rows="1"></textarea>
            </div>
          </div>
       </div>
      <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
       <legend>Bank Information</legend>
        <div class="row mg_bt_10"> 
          <div class="col-md-2 col-sm-6 ">
            <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" title="Bank Name" class="bank_suggest" >
          </div>
          <div class="col-md-2 col-sm-6 ">
            <input type="text" id="account_name" name="account_name" placeholder="A/c Name" title="A/c Name" >
          </div> 
          <div class="col-md-2 col-sm-6 ">
            <input type="text" id="account_no" name="account_no" onchange="validate_accountNo(this.id);" placeholder="A/c No" title="A/c No" >
          </div>           
          <div class="col-md-2 col-sm-6 ">
            <input type="text" id="branch" name="branch" onchange="validate_branch(this.id);" placeholder="Branch" title="Branch">
          </div> 
          <div class="col-md-2 col-sm-6 ">
            <input type="text" id="ifsc_code" name="ifsc_code" onchange="validate_IFSC(this.id);" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">
          </div>
          <div class="col-md-2 col-sm-6">
              <input type="text"  class="form-control" onchange="validate_alphanumeric(this.id);"  name="service_tax_no" id="service_tax_no"  placeholder="Tax No" title="Tax No" style="text-transform: uppercase;">
              <input type="hidden" id="opening_balance" name="opening_balance" placeholder="Opening Balance" title="Opening Balance" value="0"  onchange="validate_balance(this.id);">
          </div>
        </div>  
        <div class="row mg_bt_10">
          <div class="col-sm-2 ">
            <input type="text" id="supp_pan" name="supp_pan" onchange="validate_alphanumeric(this.id)"  placeholder="PAN/TAN No" title="PAN/TAN No" style="text-transform: uppercase;">
            <input type="hidden" id="as_of_date" name="as_of_date" placeholder="*As of Date" title="As of Date" required>
          </div>
          <div class="col-md-2 col-sm-6 hidden">
            <select name="side" id="side" title="Select side" data-toggle='tooltip' style="width:100%;">
              <option value="Credit">Credit</option>
              <option value="Debit">Debit</option>
            </select>
          </div>
        </div>
        <select name="active_flag" id="active_flag" title="Status" class="hidden">
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
      </div>

		<div class="row">
		<div class="col-md-12 app_accordion">
		<div class="panel-group main_block" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="accordion_content package_content" style="width: 100% !important;">
      <div class="panel panel-default main_block">
        <div class="panel-heading main_block" role="tab" id="heading1">
          <div class="Normal collapsed main_block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1" id="collapsed1">                  
            <div class="col-md-12"><span><em style="margin-left: 15px;"><?php echo "Hotel Amenities and Policies"; ?></em></span></div>
          </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse main_block" role="tabpanel" aria-labelledby="heading1">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12 col-sm-6 ">
                <textarea id="description" name="description" placeholder="Hotel Description" class="form-control" title="Hotel Description" rows="3"></textarea>
              </div>
            </div>
            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
              <legend>Hotel Amenities</legend>
              <div class="row mg_tp_10">
                <div class="col-md-12 col-sm-4 col-xs-12 ">
                  <div class="row">
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="wifi" name="amenities" value="WIFI">
                      <label for="wifi">WIFI</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="swm" name="amenities" value="Swimming Pool">
                      <label for="swm">Swimming Pool</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="tele" name="amenities" value="Television">
                      <label for="tele">Television</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="coffee" name="amenities" value="Coffee">
                      <label for="coffee">Coffee</label>
                    </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="air" name="amenities" value="Air Conditioner">
                      <label for="air">Air Conditioner</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="fit" name="amenities" value="Fitness Facility">
                      <label for="fit">Fitness Facility</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="fridge" name="amenities" value="Fridge">
                      <label for="fridge">Fridge</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="winebar" name="amenities" value="Wine Bar">
                        <label for="winebar">Wine Bar</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="smoke" name="amenities" value="Smoking Allowed">
                      <label for="smoke">Smoking Allowed</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="enter" name="amenities" value="Entertainment">
                      <label for="enter">Entertainment</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="secure" name="amenities" value="Secure Vault">
                      <label for="secure">Secure Vault</label>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                      <input type="checkbox" id="pick" name="amenities" value="Pick & Drop">
                      <label for="pick">Pick & Drop</label>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="room" name="amenities" value="Room Service">
                        <label for="room">Room Service</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="pets" name="amenities" value="Pets Allowed">
                        <label for="pets">Pets Allowed</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="play" name="amenities" value="Play Place">
                        <label for="play">Play Place</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="comp" name="amenities" value="Complimentary Breakfast">
                        <label for="comp">Complimentary Breakfast</label> 
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="free" name="amenities" value="Free Parking">
                        <label for="free">Free Parking</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="conf" name="amenities" value="Conference Room">
                        <label for="conf">Conference Room</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="fire" name="amenities" value="Fire Place">
                        <label for="fire">Fire Place</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="handi" name="amenities" value="Handicap Accessible">
                        <label for="handi">Handicap Accessible</label>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="doorman" name="amenities" value="Doorman">
                        <label for="doorman">Doorman</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="hot" name="amenities" value="Hot Tub">
                        <label for="hot">Hot Tub</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="elev" name="amenities" value="Elevator">
                        <label for="elev">Elevator</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="suita" name="amenities" value="Suitable For Events">
                        <label for="suita">Suitable For Events</label>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="laundry" name="amenities" value="Laundry Service">
                        <label for="laundry">Laundry Service</label>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="forex_chk" style='float: left;min-width: 200px;margin-bottom: 10px;'>
                        <input type="checkbox" id="doctor" name="amenities" value="Doctor On Call">
                        <label for="doctor">Doctor On Call</label>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            </div>
            <div class='row'>
                <div class="col-md-6 col-sm-3 "> 
                  <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
                    <legend>Child Without Bed</legend>
                    <div class="col-md-4 col-sm-3 "><label>From Age</label>
                        <select name="cwob_from" id="cwob_from" title="Child Without Bed From Age" class='form-control' data-toggle='tooltip' required>
                            <option value=''>*From Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-3 "><label>To Age</label>
                        <select name="cwob_to" id="cwob_to" title="Child Without Bed To Age" class='form-control' data-toggle='tooltip' required>
                            <option value=''>*To Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-3 ">
                  <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
                    <legend>Child With Bed</legend>         
                    <div class="col-md-4 col-sm-3 "><label>From Age</label>
                        <select name="cwb_from" id="cwb_from" title="Child With Bed From Age" class='form-control' data-toggle='tooltip' required>
                            <option value=''>*From Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-3 "><label>To Age</label>
                        <select name="cwb_to" id="cwb_to" title="Child With Bed To Age" class='form-control' data-toggle='tooltip' required>
                            <option value=''>*To Age</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                        </select>
                    </div>
                  </div>
                </div>
            </div>
            <div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
            <legend>Hotel Policies</legend>
            <div class="row mg_tp_10">
            <div class="col-md-12 col-sm-6 ">
                <textarea class="feature_editor" name="policies" id="policies" style="width:100% !important" rows="12"></textarea>
            </div>
            </div>
            </div>
          </div>
        </div>
    </div>
    </div>
        </div>
    </div>
    </div>
      <div class="row">
          <div class="col-sm-6">
              <div class="div-upload">
                <div id="hotel_upload_btn" class="upload-button1"><span>Upload Images</span></div>
                <span id="id_proof_status" ></span>
                <ul id="files" ></ul>
                <input type="Hidden" id="hotel_upload_url" name="hotel_upload_url">
              </div>  (Upload Maximum 10 images)
          </div>
      </div>
      <div class="row mg_tp_10"> 
          <div class="col-sm-6">  
            <span style="color: red;" class="note">Note : Image size should be less than 100KB, resolution : 900X450.</span>
          </div>
      </div>
			<div class="row mg_tp_20 text-center">
				<div class="col-md-12">
					<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>    
			</div>

      <input type="hidden" name="hotel_image_path" id="hotel_image_path">
	  </form>
  </div>
  </div>
  </div>
</div>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#save_modal').modal('show');
$('#as_of_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$("#state,#rating_star,#hotel_type,#side,#meal_plan").select2();
city_lzloading('#cmb_city_id');
///////////////////////***Hotel Master Save start*********//////////////
upload_hotel_pic_attch();
function upload_hotel_pic_attch()
{
    var img_array = new Array(); 

    var btnUpload=$('#hotel_upload_btn');
    $(btnUpload).find('span').text('Upload Images');
    $("#hotel_upload_url").val('');

    new AjaxUpload(btnUpload, {
      action: 'hotel/upload_hotel_images.php',
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
              $(btnUpload).find('span').text('Uploaded'); 
              $("#hotel_upload_url").val(response);
          }
          img_array.push(response);
          if(img_array.length==1) { image_text = 'image'; }else{ image_text = 'images'; }
          msg_alert(img_array.length+" "+image_text+" uploaded!");
        }
        if(img_array.length>10){
          error_msg_alert("Sorry, you can upload up to 10 images"); return false;
        }
        $("#hotel_image_path").val(img_array); 
      }
    });
}

$(function(){
  $('#frm_hotel_save').validate({
    rules:{
      cmb_city_id : {required : true },
      rating_star : { required : true },
    },
    submitHandler:function(form){
      var base_url = $("#base_url").val();
      var city_id = $("#cmb_city_id").val();
      var hotel_name = $("#txt_hotel_name").val();
      var mobile_no = $("#txt_mobile_no").val();
      var landline_no = $('#txt_landline_no').val();
      var email_id = $("#txt_email_id").val();
      var email_id_1 = $("#txt_email_id_1").val();
      var email_id_2 = $("#txt_email_id_2").val();
      var contact_person_name = $("#txt_contact_person_name").val();
      var immergency_contact_no =$("#immergency_contact_no").val();
      var hotel_address = $("#txt_hotel_address").val();
      var country = $("#country").val();
      var website = $("#website").val();
      var bank_name = $("#bank_name").val();
      var branch = $("#branch").val();
      var ifsc_code = $("#ifsc_code").val();
      var account_no = $("#account_no").val();
      var account_name = $("#account_name").val();
      var opening_balance = $('#opening_balance').val();
      var rating_star = $('#rating_star').val();
      var hotel_type = $('#hotel_type').val();
      var meal_plan = $('#meal_plan').val();
      var active_flag = $('#active_flag').val();
      var service_tax_no = $('#service_tax_no').val();
      var state = $('#state').val();
      var side = $('#side').val();
      var supp_pan = $('#supp_pan').val();
      var hotel_image_path = $('#hotel_image_path').val();
      var as_of_date = $('#as_of_date').val();
      var description = $('#description').val();
      var policies = $('#policies').val();
      var cwb_from = $('#cwb_from').val();
      var cwb_to = $('#cwb_to').val();
      var cwob_from = $('#cwob_from').val();
      var cwob_to = $('#cwob_to').val();
      
      var amenities = (function() {  var a = ''; $("input[name='amenities']:checked").each(function() { a += this.value+','; });  return a; })();
      amenities = amenities.slice(0,-1);

      var add = validate_address('txt_hotel_address');
      if(!add){
        error_msg_alert('More than 155 characters are not allowed.');
        return false;
      }
      if(parseInt(cwb_from) == 0 || cwb_from == ''){
        error_msg_alert('Enter Child With Bed From Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseInt(cwb_to) == 0 || cwb_to == ''){
        error_msg_alert('Enter Child With Bed To Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseInt(cwob_from) == 0 || cwob_from == ''){
        error_msg_alert('Enter Child Without Bed From Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseInt(cwob_to) == 0 || cwob_to == ''){
        error_msg_alert('Enter Child Without Bed To Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseInt(cwb_from) > parseInt(cwb_to)||parseInt(cwob_to) == parseInt(cwb_from)){
        error_msg_alert('Invalid Child With Bed From-To Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseInt(cwob_from)>parseInt(cwob_to)){
        error_msg_alert('Invalid Child Without Bed From-To Age in Hotel Amenities & Policies'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      if(parseFloat(cwob_to)>parseFloat(cwb_from)){
        error_msg_alert('Invalid Child Without-Bed and With-Bed Ages'); $('#accordion').css({ border: '1px solid red' }); return false;
      }
      
      $('#btn_save').button('loading');
      $.post( 
            base_url+"controller/hotel/hotel_master_save_c.php",
            { city_id : city_id, hotel_name : hotel_name, mobile_no : mobile_no, landline_no : landline_no, email_id : email_id, contact_person_name : contact_person_name, immergency_contact_no : immergency_contact_no, hotel_address : hotel_address, country : country, website :website,  opening_balance : opening_balance,rating_star : rating_star,hotel_type:hotel_type,meal_plan:meal_plan, active_flag : active_flag, bank_name : bank_name, account_no: account_no, branch : branch, ifsc_code :ifsc_code, service_tax_no : service_tax_no, state : state,side :side ,account_name : account_name ,supp_pan : supp_pan,hotel_image_path : hotel_image_path,as_of_date : as_of_date,description:description,policies:policies,amenities:amenities,cwb_from:cwb_from,cwb_to:cwb_to,cwob_from:cwob_from,cwob_to:cwob_to,email_id_1:email_id_1,email_id_2:email_id_2},

            function(data){ 
                var msg = data.split('--');
                var result_arr = data.split('==');
                var error_arr = data.split('--');
                if(msg[0]=="error"){
                  error_msg_alert(data); 
                  $('#btn_save').button('reset');
                }
                else{
                  var client_modal_type = $('#client_modal_type').val();
                  if(client_modal_type=="master"){
                    list_reflect();
                  }
                  else{
                    if(error_arr.length==1){
                      hotel_dropdown_reload(result_arr[1]);  
                    }
                  }
                  success_msg_alert(data);
                  update_b2c_cache();
                  $('#btn_save').button('reset');
                  $('#save_modal').modal('hide');
                  list_reflect();
                }
            });
    }
  });
});
$('select').on('change', function(){
	$(this).valid()
});
///////////////////////***Hotel Master Save ens*********//////////////
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>