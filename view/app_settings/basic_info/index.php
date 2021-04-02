<?php
include "../../../model/model.php";
$sq_settings = mysql_fetch_assoc(mysql_query("select * from app_settings"));
$sq_settings_g = mysql_fetch_assoc(mysql_query("select * from generic_count_master"));
?>

<form id="frm_basic_info">



	<div class="row mg_bt_30">



		<div class="col-md-2 col-md-offset-6 text-right"><label for="app_version">App Version</label></div>

		<div class="col-md-4">

			<input type="text" id="app_version" name="app_version" onchange="validate_alphanumeric(this.id)" placeholder="App Version(eg. 2017)" title="App Version" value="<?= $sq_settings['app_version'] ?>">

		</div>

	</div>



<div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">

	<legend>Company Details</legend>

	<div class="row mg_tp_20">
		<div class="col-md-2 text-right"><label for="app_name">Company Name</label></div>
		<div class="col-md-4">
			<input type="text" id="app_name" name="app_name" onchange="validate_company(this.id);" placeholder="*Company Name" title="Company Name" value="<?= $sq_settings['app_name'] ?>">
		</div>

		<div class="col-md-2 text-right"><label for="app_website">Website</label></div>
		<div class="col-md-4">
			<input type="text" id="app_website" onchange="validate_domain(this.id)" name="app_website" placeholder="Website" title="Website" value="<?= $sq_settings['app_website'] ?>">
		</div>
	</div>

	<div class="row mg_tp_20">



		<div class="col-md-2 text-right"><label for="app_contact_no">Contact No</label></div>

		<div class="col-md-4">

			<input type="text" id="app_contact_no" name="app_contact_no" onchange="mobile_validate(this.id);" placeholder="Contact No" title="Contact No" value="<?= $sq_settings['app_contact_no'] ?>" maxlength="20">

		</div>	



		<div class="col-md-2 text-right"><label for="app_landline_no">Landline No</label></div>

		<div class="col-md-4">

			<input type="text" id="app_landline_no" name="app_landline_no" onchange="mobile_validate(this.id);" placeholder="Landline No" title="Landline No" value="<?= $sq_settings['app_landline_no'] ?>">

		</div>



	</div>

	<div class="row mg_tp_20">

		

		
	    <div class="col-md-2 text-right"><label for="acc_email">Accountant Email Id</label></div> 
        <div class="col-sm-4 ">
        	<input type="text" id="acc_email" name="acc_email" placeholder="Accountant Email Id" title="Accountant Email Id" value="<?= $sq_settings['accountant_email'] ?>" onchange="validate_email(this.id)">
        	<small>Note : Pls enter webmail Email ID. eg. info@example.com</small>
	    </div>
		<div class="col-md-2 text-right"><label for="app_address">Address</label></div>

		<div class="col-md-4">

			<textarea id="app_address" name="app_address" onchange="validate_address(this.id);" placeholder="Address" title="Address" style="min-height:88px"><?= $sq_settings['app_address'] ?></textarea>

		</div>
	</div>

	<div class="row mg_tp_20">

	
		<div class="col-md-2 text-right"><label for="tax_name">TAX Name</label></div>

		<div class="col-md-4">

			<input type="text" id="tax_name" name="tax_name" placeholder="Tax Name" onchange="validate_taxname(this.id)" title="Tax Name" style="text-transform: uppercase;" value="<?= $sq_settings['tax_name'] ?>">

		</div>



	    <div class="col-md-2 text-right"><label for="service_tax_no">TAX No</label></div>

		<div class="col-md-4">

			<input type="text" id="service_tax_no" name="service_tax_no" placeholder="TAX No" title="TAX No" value="<?= $sq_settings['service_tax_no'] ?>" style="text-transform: uppercase;">

		</div>



	</div>

	<div class="row mg_tp_20">

		<div class="col-md-2 text-right"><label for="bank_cin_no">CIN No</label></div>

		<div class="col-md-4">
			<input type="text" id="cin_no" name="cin_no" placeholder="CIN No" title="CIN No" style="text-transform: uppercase;" value="<?= $sq_settings['app_cin'] ?>">
		</div>	

		<div class="col-md-2 text-right"><label for="currency_code1">Default Currency</label></div>
		<div class="col-md-4">
			<select name="currency_code" id="currency_code1" title="Currency" style="width:100%">
			<?php $sq_curr = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$sq_settings[currency]'")); ?>
				<option value="<?= $sq_curr['id'] ?>"><?= $sq_curr ['currency_code'] ?></option>
				<?php
				$sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");
				while($row_currency = mysql_fetch_assoc($sq_currency)){
					?>
				<option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="row mg_tp_20">
		
		<div class="col-md-2 text-right"><label for="state">Country</label></div> 
        <div class="col-sm-4 ">
		    <select name="country" id="country" title="Select Country" class='form-control' style='width:100%'>
			<?php
			if($sq_settings['country']!="0"){
			 $sq_country = mysql_fetch_assoc(mysql_query("select country_id,country_name from country_list_master where country_id='$sq_settings[country]'"));
	                ?>
	        	<option value="<?= $sq_settings['country_id'] ?>"><?= $sq_country['country_name'] ?></option>
	        <?php } ?>
  			<option value="">Country Name</option>
			<?php $sq_country1 = mysql_query("select country_id,country_name from country_list_master where 1");
			 while($row_c = mysql_fetch_assoc($sq_country1)){
				 ?>
				 <option value="<?= $row_c['country_id'] ?>"><?= $row_c['country_name'] ?></option>
			 <?php } ?>
		    </select>
	    </div>

		<div class="col-md-2 text-right"><label for="state">State</label></div> 
        <div class="col-sm-4 ">
		    <select name="state" id="state" title="Select State" class='form-control' style='width:100%'>
			<?php
			if($sq_settings['state_id']!=""){
			 $sq_state = mysql_fetch_assoc(mysql_query("select * from state_master where id='$sq_settings[state_id]'")); ?>
	        <option value="<?= $sq_settings['state_id'] ?>"><?= $sq_state['state_name'] ?></option>
	        <?php } ?>			
	        <?php get_states_dropdown() ?>
		    </select>
	    </div>
	</div>

	<div class="row mg_tp_20">
		<div class="col-md-2 text-right"><label for="tax_type">Credit Card Charges</label></div> 
        <div class="col-sm-4 ">
		   <input type="text" id="credit_card" name="credit_card" onchange="validate_balance(this.id)" placeholder="Credit Card(%)" value="<?= $sq_settings['credit_card_charges'] ?>" title="Credit Card(%)">
	    </div>
		<div class="col-md-2 text-right"><label for="tax_type">Tax Pay Type</label></div> 
        <div class="col-sm-4 ">
		    <select name="tax_type1" id="tax_type1" title="Select Tax Pay">
		    	<?php	if($sq_settings['tax_type']!=""){ ?>
		        <option value="<?= $sq_settings['tax_type'] ?>"><?= $sq_settings['tax_type'] ?></option>
		        <?php } ?>
		        <option value="">Select Tax Type</option>
		        <option value="Monthly">Monthly</option> 
		        <option value="Quarterly">Quarterly</option>
		        <option value="Yearly">Yearly</option>
		    </select>
	    </div>

	</div>

	<div class="row mg_tp_20">
	    <div class="col-md-2 text-right"><label for="tax_pay_date">Tax Pay Date</label></div> 
        <div class="col-sm-4 ">
        	<input type="text" id="tax_pay_date" name="tax_pay_date" placeholder="Tax Pay Date" title="Tax Pay Date" value="<?= get_date_user($sq_settings['tax_pay_date']) ?>">
	    </div>

		<div class="col-md-2 text-right"><label for="pdf_upload_btn">Cancellation Policy</label></div> 
			<?php
			if($sq_settings['policy_url'] != ''){
				$url = explode('uploads', $sq_settings['policy_url']);
				$url1 = BASE_URL.'uploads'.$url[1];	
				$text = "Uploaded";
			}	
			else{
				$text = "PDF";
			}			
			?>
		<div class="col-md-4">     

          	<div class="div-upload">

          	<div id="pdf_upload_btn" class="upload-button1"><span><?= $text ?></span></div>

          	<span id="id_proof_status" ></span>

         	<ul id="files"></ul>

          	<input type="hidden" id="pdf_upload_url" name="pdf_upload_url" value="<?= $sq_settings['policy_url'] ?>">

            </div>  

		</div>



		

	</div>

</div>
<div class="row text-center mg_tp_20">

	<div class="col-md-12">

		<button class="btn btn-sm btn-success" id="setting_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

	</div>

</div>



</form>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script type="text/javascript">

$('#tax_pay_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#state,#currency_code1,#country').select2();
upload_can_policy_pdf();

function upload_can_policy_pdf()
{
	var btnUpload=$('#pdf_upload_btn');
	var status = $("#pdf_upload_url").val();
	var text = (status == '')?'PDF':'Uploaded';
    $(btnUpload).find('span').text(text);

    new AjaxUpload(btnUpload, {
      action: 'basic_info/upload_pdf.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  
        if (! (ext && /^(pdf)$/.test(ext))){ 
         error_msg_alert('Only PDF files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload PDF');
		}
		else{ 
			  if(response=="error1"){
            $(btnUpload).find('span').text('PDF');
            error_msg_alert('Maximum size exceeds');
            return false;
          }else
          {
            $(btnUpload).find('span').text('Uploaded');
            $("#pdf_upload_url").val(response);
          }
        }
      }
    });

}
$('input').keyup(function(){	$(this).removeAttr('style');	});
$(function(){

	$('#frm_basic_info').validate({

		rules:{
				app_name : { required: true },
				state : { required : true },
				credit_card:	{	max	:	100},
				cin_no:	{ maxlength:	150, regex: /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/ },
				service_tax_no:	{maxlength:	200}	
		},
		messages:{
			cin_no:	"Please Enter Valid CIN number",
		},
		onkeyup: false,
		errorPlacement: function(error, element) {
			if($(element).val() != ''){
				$(element).css({ border: '1px solid red' });
				error_msg_alert(error[0].innerText);
				$(element).val('');
			}
			
		},

		submitHandler:function(form){

			var app_version = $('#app_version').val();
			var currency_code = $('#currency_code1').val();
			var app_contact_no = $('#app_contact_no').val();
			var app_landline_no = $('#app_landline_no').val();
			var app_address = $('#app_address').val();
			var app_name = $('#app_name').val();
		 	var tax_name = $('#tax_name').val();
		 	var app_website = $('#app_website').val();
		 	var cin_no = $('#cin_no').val();
		 	var service_tax_no = $('#service_tax_no').val();
		 	var pdf_upload_url = $('#pdf_upload_url').val();
		 	var state = $('#state').val();
			var country = $('#country').val();
		 	var acc_email = $('#acc_email').val(); 
		 	var tax_type = $('#tax_type1').val();
		 	var tax_pay_date = $('#tax_pay_date').val();
		 	var credit_card =  $('#credit_card').val(); 
			var base_url = $('#base_url').val();

			$('#setting_save').button('loading');
			if($('#frm_basic_info').valid()){
				$('#vi_confirm_box').vi_confirm_box({
			    callback: function(data1){
			        if(data1=="yes"){
			          $.ajax({
			          	type:'post',
			          	url:base_url+'controller/app_settings/setting/app_basic_info_save.php',
			          	data:{ app_version : app_version, currency_code : currency_code, app_contact_no : app_contact_no, app_landline_no : app_landline_no, service_tax_no : service_tax_no,tax_name : tax_name, app_address : app_address, app_website : app_website, app_name : app_name, cin_no : cin_no, pdf_upload_url : pdf_upload_url, state : state, country:country,acc_email : acc_email, tax_type : tax_type, tax_pay_date : tax_pay_date, credit_card : credit_card},
			          	success:function(result){
			          		msg_popup_reload(result);
							  update_b2c_cache();
							$('#setting_save').button('reset');
			          	}
			          });
					}
					else{
						$('#setting_save').button('reset');
					}
			      }
			});
			}
				
			return false;			
		}
	});

});


</script>