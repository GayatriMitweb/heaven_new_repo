<form id="frm_tab1">

	<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

	     <legend>User Information</legend>                

          <div class="row text-center mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_first_name" name="txt_first_name" placeholder="*First Name" title="First Name" > 

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_last_name" name="txt_last_name" placeholder="Last Name" onchange="fname_validate(this.id)"  title="Last Name" >

              </div>
              <div class="col-md-1 col-sm-6 mg_bt_10">
                 <select name="country_code" id="country_code" style="width:100px;">
                  <?= get_country_code(); ?>
                 </select>
              </div>
              <div class="col-md-2 col-sm-6 mg_bt_10">
                  <input class="form-control" type="text" id="txt_mobile_no" name="txt_mobile_no" placeholder="Mobile No" onchange="mobile_validate(this.id);" title="Mobile Number" >
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_mobile_no1" onchange="mobile_validate(this.id);" name="txt_mobile_no1" placeholder="Alternative No" title="Alternative Mobile No." >

              </div>
          </div>

          <div class="row text-center">

          		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input class="form-control" type="text" id="txt_email_id" name="txt_email_id" placeholder="Email ID" title="Email ID" onchange="validate_email(this.id)">
              	</div>

	            <div class="col-md-3 col-sm-6 mg_bt_10_xs">
	                <input type="text" name="employee_birth_date" id="employee_birth_date" placeholder="*Date Of Birth" title="Date Of Birth" onchange="calculate_age_member(this.id);" value="<?= date('d-m-Y') ?>">
                  <p id="div_employee_age" style="color: red;"></p>
	            </div>

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">
                  <input type="text" id="txt_m_age1" name="txt_m_age1" placeholder="Age" disabled title="Age"/>
              </div>

            	<div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
                <select name="cmb_gender" id="cmb_gender" class="form-control" title="Select Gender" >
                    <option value="">Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            	</div>
            </div>

            <div class="row mg_tp_10 text-center">
                <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input type="text" id="txt_uan" name="txt_uan" placeholder="UAN" title="UAN"/>

                </div>

              <div class="col-md-3 col-sm-6 text-left">          

                <div class="div-upload">

                  <div id="photo_upload_btn_p" class="upload-button1"><span>Profile Image</span></div>

                  <span id="photo_status" ></span>

                  <ul id="files" ></ul>

                  <input type="hidden" id="photo_upload_url" name="photo_upload_url">

                </div>

              </div>  

            </div>

        </div>

        

        <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">

	     <legend>Official Information</legend>

        	<div class="row text-center mg_tp_10">

            	<div class="col-md-3 col-sm-6 mg_bt_10">

              <select name="location_id" id="location_id" title="Select Location" onchange="branch_name_load();address_reflect()" style="width:100%">

                <option value="">*Location</option>
	                  
                  <?php
                  if($role=='Admin'){ ?>
                    <?php
                    $sq_location = mysql_query("select * from locations where active_flag!='Inactive' order by location_name");
                    while($row_location = mysql_fetch_assoc($sq_location)){
                    ?>
                      <option value="<?= $row_location['location_id'] ?>"><?= $row_location['location_name'] ?></option>
                      <?php
                    }
                  }
                  else{
                    if($branch_status=='yes'){
                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where branch_id='$branch_admin_id'"));
                    }
                    else{
                      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where branch_id='$branch_admin_id'"));
                    }
                    $sq_location = mysql_query("select * from locations where location_id='$sq_emp[location_id]' order by location_name");
                    while($row_location = mysql_fetch_assoc($sq_location)){
                        ?>
                        <option value="<?= $row_location['location_id'] ?>"><?= $row_location['location_name'] ?></option>
                        <?php }
                  } ?>
	              </select>

	            </div>

	      		<div class="col-md-3 col-sm-6 mg_bt_10">
	              <select class="form-control" id="branch_id" name="branch_id" title="Select Branch" onchange="address_reflect()" >
                <?php  if($role=='Branch Admin'){
                  $sq_branch =mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_admin_id'"));
                   
                    echo '<option value="'.$sq_branch['branch_id'].'">'.$sq_branch['branch_name'].'</option>';


                  } else { ?>
	                  <option value="">*Branch</option>
                 <?php }  ?>
	              </select>

	         	</div>

              	<div class="col-md-3 col-sm-6 mg_bt_10">

                  	<textarea class="form-control" id="txt_address"  onchange="validate_address(this.id)" id="user_address" name="txt_address" placeholder="Address" title="Address" rows="1"> <?php  if($role=='Branch Admin'){
                  
                    $sq_address = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_admin_id' "));
                     
                      echo  $sq_address['address1'].' '.$sq_address['address2'];

                  } else { echo "Address"; } ?></textarea>

              	</div>

                <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" name="date_of_join" id="date_of_join" placeholder="Date Of Joining" title="Date Of Joining" value="<?= date('d-m-Y'); ?>">

                </div>

	        </div>

           	<div class="row text-center">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" class="form-control" id="emp_username" name="emp_username" title="Username" placeholder="*Username"/>

              </div>

	            <div class="col-md-3 col-sm-6 mg_bt_10">

	                <input type="password" id="emp_password" name="emp_password" placeholder="*Password" title="Password" class="form-control" />

	            </div> 

          		<div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="emp_repassword" name="emp_repassword" type="password" placeholder="*Confirm password" title="Confirm password" />

            	</div> 

            	<div class="col-md-3 col-sm-6 mg_bt_10">

                <select class="form-control" id="role_id" name="role_id" title="Select Role" >

                    <option value="">*Role</option>

                    <?php

                    if($role=='Branch Admin'){

                        $sq1 = mysql_query("select * from role_master where active_flag!='Inactive' and role_id not in('1','5') order by role_name");

                        while($row1 = mysql_fetch_assoc($sq1))

                        {

                         ?>

                            <option value="<?php echo $row1['role_id'] ?>"><?php echo strtoupper($row1['role_name']) ?></option>

                         <?php       

                        }    

                      }
                      else{

                        $sq = mysql_query("select * from role_master where active_flag!='Inactive' order by role_name");

                        while($row = mysql_fetch_assoc($sq))

                        {

                         ?>

                            <option value="<?php echo $row['role_id'] ?>"><?php echo strtoupper($row['role_name']) ?></option>

                         <?php       

                        }  
                    }  

                    ?>                            

                </select>

            	</div> 

            </div>        

	        <div class="row mg_bt_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_target1" name="txt_target1" type="text" placeholder="Monthly Target" title="Monthly Target To Sale" onchange="validate_balance(this.id);" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_incentive" name="txt_incentive" type="text" placeholder="Incentive(%)" title="Incentive(%)" onchange="validate_balance(this.id);" />

              </div> 

	            <div class="col-md-3 col-sm-6 mg_bt_10">

	              <select name="active_flag" id="active_flag" title="Status" class="hidden">

	                <option value="Active">Active</option>

	                <option value="Inactive">Inactive</option>

	              </select>

	            </div>
               <div class="col-md-3 col-sm-6 mg_bt_10 hidden">

                  <input type="hidden" id="salary" name="salary" placeholder="Salary" title="Salary" value="0.00" >

              </div> 
            </div>
            <div class="row">
	            <div class="col-md-3 col-sm-6">          

	              <div class="div-upload">

	                <div id="id_upload_btn1" class="upload-button1"><span>Upload</span></div>

	                <span id="id_proof_status" ></span>

	                <ul id="files" ></ul>

	                <input type="hidden" id="id_upload_url" name="id_upload_url">
	              </div>
	            </div>    

	        </div>

	    </div>
      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
        <legend>Mailing Information</legend>
          <div class="row mg_tp_10">
          <div class="col-xs-12"> 
            <div style="color: red;">Note : Please add individual Users Webmail SMTP details to send / receive email from respective email id's.</div>
          </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-3">
              <select id="app_smtp_status" name="app_smtp_status" title="SMTP Status">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
              <small>Note : Do you want SMTP mailing?</small>
            </div>
            <div class="col-md-3">
              <input type="text" id="app_smtp_host" onchange="fname_validate(this.id)" name="app_smtp_host" placeholder="SMTP Host" title="SMTP Host">
              <small>Note : Enter SMTP host name Ex. mail.itourscloud.com</small>
            </div>
            <div class="col-md-3">
              <input type="text" onchange="validate_alphanumeric(this.id);" id="app_smtp_port" name="app_smtp_port" placeholder="SMTP Port" title="SMTP Port">
              <small>Note : Enter SMTP port name Ex. 587</small>
            </div>
            <div class="col-md-3">
              <input type="password" id="app_smtp_password" name="app_smtp_password" class="form-control" placeholder="SMTP Password" title="SMTP Password">
              <small>Note : Enter SMTP password</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
              <input type="text" id="app_smtp_method" onchange="fname_validate(this.id);" name="app_smtp_method" placeholder="SMTP Method" title="SMTP Method">
              <small>Note : Enter SMTP method name Ex. SSL</small>
            </div>
        </div>
      </div>

      <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

       <legend>Visa Information</legend>                

          <div class="row mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="visa_country_name" id="visa_country_name" title="Visa Country Name" style="width:100%" >
                  <option value="">Visa Country</option>
                  <?php 
                  $sq_country = mysql_query("select * from country_list_master");
                  while($row_country = mysql_fetch_assoc($sq_country)){
                      ?>
                      <option value="<?= $row_country['country_name'] ?>"><?= $row_country['country_name'] ?></option>
                      <?php
                  }
                  ?>
                </select>

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">
                <select name="visa_type" id="visa_type" title="Visa Type">
                  <option value="">Visa Type</option>
                  <?php 
                  $sq_visa_type = mysql_query("select * from visa_type_master");
                  while($row_visa_type = mysql_fetch_assoc($sq_visa_type)){
                      ?>
                      <option value="<?= $row_visa_type['visa_type'] ?>"><?= $row_visa_type['visa_type'] ?></option>
                      <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                 <input type="text" id="issue_date" name="issue_date" placeholder="Issue Date" title="Issue Date" onchange="get_to_date(this.id,'expiry_date')">

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="expiry_date" name="expiry_date"  placeholder="Expire Date" title="Expire Date">

              </div>

              

          </div>

          <div class="row text-center">

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input class="form-control" type="text" id="txt_visa_amt" name="txt_visa_amt" placeholder="Visa Amount" title=" Visa Amount" onchange="validate_balance(this.id)" >

                </div>

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input type="text" name="renewal_amount" id="renewal_amount" placeholder="Renewal Amount" title="Renewal Amount" onchange="validate_balance(this.id)" >

              </div>

            </div>


        </div>

	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>

$('#visa_country_name, #location_id,#country_code').select2();
$('#date_of_join,#issue_date,#expiry_date').datetimepicker({timepicker:false, format:'d-m-Y'});

var date = new Date();
var yest = date.setDate(date.getDate()-1);
$('#employee_birth_date').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });

upload_hotel_pic_attch();

function upload_hotel_pic_attch()

{

    var btnUpload=$('#id_upload_btn1');

    $(btnUpload).find('span').text('ID Proof');

    //$("#id_upload_url").val('');

    

    new AjaxUpload(btnUpload, {

      action: 'upload_id_proof.php',

      name: 'uploadfile',

      onSubmit: function(file, ext)

      {  

        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 

         error_msg_alert('Only JPG, PNG or GIF files are allowed');

         return false;

        }

        $(btnUpload).find('span').text('Uploading...');

      },

      onComplete: function(file, response){

        if(response==="error"){          

          error_msg_alert("File is not uploaded.");           

          $(btnUpload).find('span').text('Upload');

        }else

        { 

          $(btnUpload).find('span').text('Uploaded');

          $("#id_upload_url").val(response);

        }

      }

    });

}

upload_user_pic_attch();

function upload_user_pic_attch()

{

    var btnUpload=$('#photo_upload_btn_p');

    $(btnUpload).find('span').text('Profile Image');

    //$("#photo_upload_url").val('');

    

    new AjaxUpload(btnUpload, {

      action: 'upload_photo_proof.php',

      name: 'uploadfile',

      onSubmit: function(file, ext)

      {  

        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 

         error_msg_alert('Only JPG, PNG or GIF files are allowed');

         return false;

        }

        $(btnUpload).find('span').text('Uploading...');

      },

      onComplete: function(file, response){

        if(response==="error"){          

          error_msg_alert("File is not uploaded.");           

          $(btnUpload).find('span').text('Upload');

        }else

        { 

          $(btnUpload).find('span').text('Uploaded');

          $("#photo_upload_url").val(response);

        }

      }

    });

}

 
$('#employee_birth_date').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });

$(function(){
$('#frm_tab1').validate({

	rules:{

			txt_first_name : { required : true , maxlength : 30},

            emp_username : { required : true },

            emp_password : { required : true },

            emp_repassword : { required : true },

            location_id : { required : true },

            branch_id : { required : true },

            role_id : { required : true },

            active_flag : { required : true },

            employee_birth_date : { required : true },
          
	},

	submitHandler:function(form){

  

        var password = $("#emp_password").val();
        var re_password = $("#emp_repassword").val();
        //alert(password +' = '+ re_password);
        if(password!=re_password)
        {
          error_msg_alert('Password did not match!'); 
          return false; 
        }
		  
		$('a[href="#tab2"]').tab('show');
     return false;
	}

});

});

</script>
<style>
#select2-location_id-container{
  text-align:left !important;
}
</style>