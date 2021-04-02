<form id="frm_tab1_u">

	<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">
      <input type="hidden" id="txt_emp_id" name="txt_emp_id" value="<?php echo $emp_id; ?>">
	     <legend>User Information</legend>                

           <div class="row text-center mg_tp_10">

            <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" type="text" id="txt_first_name1" name="txt_first_name" placeholder="First Name"  value="<?= $emp_info['first_name'] ?>" title="First Name"> 

            </div>

            <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" type="text"  onchange="fname_validate(this.id);" id="txt_last_name1" name="txt_last_name" placeholder="Last Name" value="<?= $emp_info['last_name'] ?>" title="Last Name">

            </div>
            <div class="col-sm-1 col-xs-12">
              <input type="hidden" name="country_code_val" id="country_code_val" value="<?= $emp_info['country_code'] ?>">
              <select name="country_code1" id="country_code1" style="width:100px;">
                <?= get_country_code() ?>
              </select>
            </div>

            <div class="col-md-2 col-sm-6 mg_bt_10">

                <input class="form-control" type="text" id="txt_mobile_no11" onchange="mobile_validate(this.id);" name="txt_mobile_no" placeholder="Mobile No" value="<?= str_replace($emp_info['country_code'],"",$emp_info['mobile_no']) ?>" title="Mobile Number">

            </div>

            <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" type="text" id="txt_mobile_no2" name="txt_mobile_no2" placeholder="Alternative Mobile No." onchange="mobile_validate(this.id);" value="<?= $emp_info['mobile_no2'] ?>" title="Alternative Mobile No."> 

            </div>            

        </div>

        <div class="row text-center">

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" type="text" id="txt_email_id1" name="txt_email_id" placeholder="Email ID"  value='<?= $emp_info['email_id'] ?>' onchange="validate_email(this.id)" title="Email ID">

            </div>

          <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" name="employee_birth_date1" id="employee_birth_date1" placeholder="*Date Of Birth" title="Date Of Birth" onchange="calculate_age_member(this.id); " value="<?= date('d-m-Y',strtotime($emp_info['dob']))?>">

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input type="text" id="txt_m_age1" name="txt_m_age1" placeholder="Age" disabled title="Age" value="<?=$emp_info['age'] ?>"/>

              </div>

            <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="cmb_gender1" id="cmb_gender1" class="form-control" title="Select Gender">
                  <?php if($emp_info['gender']!=''){?>
                    <option value="<?= $emp_info['gender'] ?>"><?= $emp_info['gender'] ?></option>

                    <option value="">Gender</option>

                    <option value="Male">Male</option>

                    <option value="Female">Female</option>
                  <?php 
                }else{
                   ?>
                   <option value="">Gender</option>
                    <option value="Male">Male</option>

                    <option value="Female">Female</option>
                  <?php } ?>
                </select>

            </div>

            </div>

            <div class="row mg_tp_10 text-center">

                <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input type="text" id="txt_uan1" name="txt_uan1" placeholder="UAN" title="UAN" value="<?php echo $emp_info['uan_code']; ?>"/>

                </div>
                <div class="col-md-3 col-sm-6 text-left">          

                  <div class="div-upload">

                    <div id="photo_upload_btn_u" class="upload-button1"><span>Profile Image</span></div>

                    <span id="photo_status" ></span>

                    <ul id="files" ></ul>

                    <input type="hidden" value="<?php echo $emp_info['photo_upload_url']; ?>" id="photo_upload_url_u" name="photo_upload_url_u">

                  </div>

                </div>  

        </div>

    </div>

    
    <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">

       <legend>Official Information</legend>

        <div class="row text-center mg_tp_10">

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="location_id" id="location_id" title="Location" onchange="branch_name_load()">                    

                    <?php

                    $location_id = $emp_info['location_id'];

                    $sq_location1 = mysql_fetch_assoc(mysql_query("select * from locations where location_id='$location_id'"));

                    echo '<option value="'.$sq_location1['location_id'].'">'.$sq_location1['location_name'].'</option>';
                    if($branch_status=='yes' && $role!='Branch Admin') {
                    ?>
                    <option value="">*Location</option>
                    <?php
                      $sq_location = mysql_query("select * from locations where active_flag!='Inactive' order by location_name");
                      while($row_location = mysql_fetch_assoc($sq_location)){

                        ?>
                        <option value="<?= $row_location['location_id'] ?>"><?= $row_location['location_name'] ?></option>
                        <?php
                      }
                    }
                    ?>

                </select>

            </div>

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <select class="form-control" id="branch_id" name="branch_id" title="Branch" onchange="address_reflect()">                    

                    <?php                    

                    $branch_id = $emp_info['branch_id'];

                    $sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$branch_id' order by branch_name"));

                    echo '<option value="'.$sq_branch['branch_id'].'">'.$sq_branch['branch_name'].'</option>';
                    ?>
                    <option value="">*Branch</option>
                    <?php
                    if($branch_status=='yes' && $role!='Branch Admin') {
                    $sq_branch = mysql_query("select * from branches where location_id='$location_id'");

                    while($row_branch = mysql_fetch_assoc($sq_branch)){

                        echo '<option value="'.$row_branch['branch_id'].'">'.$row_branch['branch_name'].'</option>';
                      }
                    }
                    ?>

                </select>

            </div>

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <textarea class="form-control" id="txt_address1" onchange="validate_address(this.id);"  name="txt_address" placeholder="Address" rows="1" title="Addresss"><?= $emp_info['address'] ?></textarea>

            </div> 

          <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" name="date_of_join1" id="date_of_join1" placeholder="Date Of Joining" title="Date Of Joining" value="<?= date('d-m-Y',strtotime($emp_info['date_of_join']));?>">

                </div>                      

         </div>  

        <div class="row">

            <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" id="emp_username11" name="emp_username1" onchange="validate_username(this.id);" type="text" placeholder="Username" value="<?= $username ?>" title="Username"/>



            </div>

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" id="txt_password1" onchange="validate_password(this.id);" name="txt_password" type="password" placeholder="Password" value="<?= $password ?>" title="Password" />

            </div>  

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <input class="form-control" id="txt_password11" onchange="validate_password(this.id);" name="txt_password1" type="password" placeholder="Confirm password" value="<?= $password ?>" title="Confirm password" />

            </div>  

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <select class="form-control" id="role_id1" name="role_id1" onchange="select_color(this.id)" title="Role">

                    <?php

                      $sq = mysql_fetch_assoc(mysql_query("select * from role_master where role_id='$emp_info[role_id]'"));

                        ?>

                            <option value="<?php echo $sq['role_id'] ?>"><?php echo strtoupper($sq['role_name']) ?></option>

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
                      else {

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

        <div class="row">

            <div class="col-md-3 col-sm-6 mg_bt_10">

              <input class="form-control" id="txt_target1" name="txt_target1" type="text" placeholder="Monthly Target" value="<?= $emp_info['target'] ?>" title="Monthly Target To Sale" onchange=" validate_balance(this.id)"/>

            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_incentive_per1" name="txt_incentive_per1" type="text" placeholder="Incentive(%)" title="Incentive(%)" onchange="validate_balance(this.id);" value="<?= $emp_info['incentive_per'] ?>" />

            </div>

          <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="active_flag" id="active_flag" title="Status">

                    <option value="<?= $emp_info['active_flag'] ?>"><?= $emp_info['active_flag'] ?></option>

                    <option value="Active">Active</option>

                    <option value="Inactive">Inactive</option>

                  </select>

            </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                <input type="hidden" id="salary" name="salary" placeholder="Salary" title="Salary" value="<?php echo $emp_info['salary'] ?>">

            </div>  

            <div class="col-md-3 col-sm-6">          

                <div class="div-upload">

                  <div id="id_upload_btn" class="upload-button1"><span>ID Proof</span></div>

                  <span id="id_proof_status" ></span>

                  <ul id="files" ></ul>

                  <input type="hidden" id="id_upload_url1" name="id_upload_url1" value="<?php echo $emp_info['id_proof_url']; ?>">

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
                <?php 
                if($emp_info['app_smtp_status']!=""){
                  ?>
                  <option value="<?= $emp_info['app_smtp_status'] ?>"><?= $emp_info['app_smtp_status'] ?></option>
                  <?php
                }
                ?>
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
              <small>Note : Do you want SMTP mailing?</small>
            </div>
            <div class="col-md-3">
              <input type="text" id="app_smtp_host" onchange="fname_validate(this.id)" name="app_smtp_host" placeholder="SMTP Host" title="SMTP Host" value="<?= $emp_info['app_smtp_host'] ?>">
              <small>Note : Enter SMTP host name Ex. mail.itourscloud.com</small>
            </div>
            <div class="col-md-3">
              <input type="text" onchange="validate_alphanumeric(this.id);" id="app_smtp_port" name="app_smtp_port" placeholder="SMTP Port" title="SMTP Port" value="<?= $emp_info['app_smtp_port'] ?>">
              <small>Note : Enter SMTP port name Ex. 587</small>
            </div>
            <div class="col-md-3">
              <input type="password" id="app_smtp_password" name="app_smtp_password" class="form-control" placeholder="SMTP Password" title="SMTP Password" value="<?= $emp_info['app_smtp_password'] ?>">
              <small>Note : Enter SMTP password</small>
            </div>
        </div>
        <div class="row mg_tp_10">
            <div class="col-md-3">
              <input type="text" id="app_smtp_method" onchange="fname_validate(this.id);" name="app_smtp_method" placeholder="SMTP Method" title="SMTP Method" value="<?= $emp_info['app_smtp_method'] ?>">
              <small>Note : Enter SMTP method name Ex. SSL</small>
            </div>
        </div>
      </div>

     <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

       <legend>Visa Information</legend>                

          <div class="row mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="visa_country_name1" id="visa_country_name1" title="Visa Country Name" style="width: 100%">
                  <?php if($emp_info['visa_country_name']!='') { ?>
                  <option value="<?= $emp_info['visa_country_name'] ?>"><?= $emp_info['visa_country_name'] ?></option>
                  <option value="">Visa Country</option>
                  <?php }
                   else{ ?>                      
                    <option value="">Visa Country</option>
                    <?php }
                    $sq_country = mysql_query("select * from country_list_master");
                    while($row_country = mysql_fetch_assoc($sq_country)){
                        ?>
                        <option value="<?= $row_country['country_name'] ?>"><?= $row_country['country_name'] ?></option>
                        <?php                 
                    } ?>
                </select>

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">
                <select name="visa_type1" id="visa_type1" title="Visa Type" style="width: 100%">
                  <?php if($emp_info['visa_type']!=''){?>
                  <option value="<?= $emp_info['visa_type'] ?>"><?= $emp_info['visa_type'] ?></option>
                  <option value="">Visa Type</option>
                  <?php
                  }
                  else{
                  ?>
                    <option value="">Visa Type</option>
                  <?php 
                  }
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

                 <input type="text" id="issue_date1" name="issue_date1" placeholder="Issue Date" title="Issue Date" onchange="get_to_date(this.id,'expiry_date1')" value="<?php echo get_date_user($emp_info['issue_date']);?>">

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="expiry_date1" name="expiry_date1" placeholder="Expire Date" title="Expire Date"/ value="<?php echo get_date_user($emp_info['expiry_date']);?>" >

              </div>

              

          </div>

          <div class="row text-center">

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input class="form-control" type="text" id="txt_visa_amt1" name="txt_visa_amt1" placeholder="Visa Amount" title="Visa Amount" value="<?= $emp_info['visa_amt'] ?>" onchange="validate_balance(this.id)" >

                </div>

              <div class="col-md-3 col-sm-6 mg_bt_10_xs">

                  <input type="text" name="renewal_amount1" id="renewal_amount1" placeholder="Renewal Amount" title="Renewal Amount" value="<?= $emp_info['renewal_amount'] ?>" onchange="validate_balance(this.id)">

              </div>

            </div>


        </div>

	<div class="row text-center">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>

</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
$('#visa_country_name1,#country_code1').select2();
$('#country_code1').val($('#country_code_val').val());
$('#country_code1').trigger('change');
$('#date_of_join1,#issue_date1,#expiry_date1').datetimepicker({timepicker:false, format:'d-m-Y'});

var date = new Date();
var yest = date.setDate(date.getDate()-1);
$('#employee_birth_date1').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });


upload_hotel_pic_attch();

function upload_hotel_pic_attch()

{

    var btnUpload=$('#id_upload_btn');

    $(btnUpload).find('span').text('ID Proof');

    //$("#id_upload_url1").val('');

    

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

          $("#id_upload_url1").val(response);

        }

      }

    });

}



upload_user_pic_attch();

function upload_user_pic_attch()

{

    var btnUpload=$('#photo_upload_btn_u');

    $(btnUpload).find('span').text('Profile Image');

   // $("#photo_upload_url_u").val('');

    

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

        }
        else{ 
          $(btnUpload).find('span').text('Uploaded');
          $("#photo_upload_url_u").val(response);
        }
      }
    });
}
$('#employee_birth_date').datetimepicker({ timepicker:false, maxDate:yest, format:'d-m-Y' });
$('#frm_tab1_u').validate({

	rules:{

			    txt_first_name : { required : true , maxlength : 30},

            emp_username11 : { required : true },

            txt_password1 : { required : true },

            txt_password11 : { required : true },

            location_id : { required : true },

            branch_id : { required : true },

            role_id1 : { required : true },

            active_flag : { required : true },

            employee_birth_date1 : { required : true },

          
	},

	submitHandler:function(form){
		$('a[href="#tab2u"]').tab('show');
	}

});
</script>

