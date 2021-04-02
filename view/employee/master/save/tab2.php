<form id="frm_tab4">

<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

       <legend>Bank Information</legend>                

          <div class="row text-center mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control bank_suggest" type="text" id="txt_bank_name" name="txt_bank_name" placeholder="Bank Name" title="Bank Name" style="text-transform: uppercase;"> 

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" onchange="validate_branch(this.id);" type="text" id="txt_branch_name" name="txt_branch_name" placeholder="Branch Name"  title="Branch Name" >

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" onchange="validate_IFSC(this.id);" id="txt_ifsc" name="txt_ifsc" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" style="text-transform: uppercase;">

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_acc_no" onchange="validate_accountNo(this.id);" name="txt_acc_no" placeholder="A/c No" title="A/c No." >

              </div>
          </div>
        </div>

        

        <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">
          <legend>Salary Information</legend>
          <span>Monthly Package</span>
          <div class="row text-center mg_tp_10">
            <div class="col-sm-3 mg_bt_10">
              <input type="text" title="Basic Pay" id="txt_basic_pay" placeholder="Basic Pay" name="txt_basic_pay" onchange="calculate_total_payable();validate_balance(this.id)">
            </div> 
            <div class="col-sm-3 mg_bt_10">
              <input type="text" placeholder="Dearness Allowance" title="Dearness Allowance" id="txt_dear_allow" name="txt_basic_pay" onchange="calculate_total_payable();validate_balance(this.id)">
            </div>
            <div class="col-sm-3 mg_bt_10">
              <input type="text" title="HRA" id="hra" name="hra" placeholder="HRA" onchange="calculate_total_payable();validate_balance(this.id)">
            </div> 
            <div class="col-sm-3 mg_bt_10">
              <input type="text" placeholder="Travel Allowance" title="Travel Allowance" id="txt_travel_allow" name="txt_travel_allow" onchange="calculate_total_payable();validate_balance(this.id)">
            </div> 
            <div class="col-sm-3 mg_bt_10">
                <input type="text" placeholder="Medical Allowance" title="Medical Allowance" id="txt_medi_all" name="txt_medi_all" onchange="calculate_total_payable();validate_balance(this.id)"> 
            </div>
            <div class="col-sm-3 mg_bt_10_sm_xs">
              <input type="text" placeholder="Special Allowance" title="Special Allowance" id="special_allowance" name="special_allowance" onchange="calculate_total_payable();validate_balance(this.id)"> 
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" id="uniform_allowance" name="uniform_allowance" type="text"  placeholder="Uniform Allowance" title="Uniform Allowance" onchange="calculate_total_payable();validate_balance(this.id)"/>    
            </div>
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="txt_incentives" name="txt_incentives" type="text" placeholder="Incentives" title="Incentives" onchange="calculate_total_payable();validate_balance(this.id)" />
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="meal_allowance" name="meal_allowance" type="text" placeholder="Meal Allowance" title="Meal Allowance" onchange="calculate_total_payable();validate_balance(this.id)" />
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
              <input class="form-control" id="gross_salary" name="gross_salary" type="text" placeholder="Gross Salary" title="Gross Salary" disabled />
            </div> 

          </div> 

          <br>       
          <span>Deductions</span>
          <br>
          <div class="row mg_tp_10">
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input type="text" id="employer_pf" name="employer_pf" placeholder="Employer PF" title="Employer PF" onchange="calculate_total_payable();validate_balance(this.id);">
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="employee_pf" name="employee_pf" type="text" placeholder="Employee PF" title="Employee PF" onchange="calculate_total_payable();validate_balance(this.id);" />
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="txt_esic" name="txt_esic" type="text" placeholder="ESIC" title="ESIC" onchange="calculate_total_payable();validate_balance(this.id)"/>
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input type="text" id="txt_pt" name="txt_pt" placeholder="PT" title="PT" class="form-control" onchange="calculate_total_payable();validate_balance(this.id)">
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="txt_tds" name="txt_tds" type="text" placeholder="TDS" title="TDS" onchange="calculate_total_payable();validate_balance(this.id)"/>
            </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="txt_labour" name="txt_labour" type="text" placeholder="Labour Welfare Fund" title="Labour Welfare Fund" onchange="calculate_total_payable();validate_balance(this.id)"/>
            </div>
             <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="txt_deduction" name="txt_deduction" type="text" placeholder="Total Deductions" title="Total Deductions" disabled/>
            </div>
          </div>
          <div class="row mg_tp_10">
            <div class="col-md-2 mg_tp_20"><label for="net_salary">Net Salary</label></div>
            <div class="col-md-3 col-sm-6 mg_tp_10" style="margin-left: -54px;">
              <input type="text" id="net_salary" name="net_salary" placeholder="Net Salary" title="Net Salary" disabled >
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

$('#frm_tab4').validate({

  rules:{
        //txt_bank_name : { required : true },
  },

  submitHandler:function(form){
    
        var base_url = $('#base_url').val();

        var first_name = $("#txt_first_name").val();

        var last_name = $("#txt_last_name").val();

        var username = $("#emp_username").val();

        var gender = $("#cmb_gender").val();

        var password = $("#emp_password").val();

        var re_password = $("#emp_repassword").val();

        var address = $("#txt_address").val();

        var mobile_no = $("#txt_mobile_no").val();

        var country_code = $('#country_code').val();

        var email_id = $("#txt_email_id").val();

        var location_id = $("#location_id").val(); 

        var branch_id = $("#branch_id").val(); 

        var salary = $("#salary").val(); 

        var role_id = $("#role_id").val();

        var target = $('#txt_target1').val(); 
        var incentive_per = $('#txt_incentive').val(); 
        var active_flag = $('#active_flag').val();

        var employee_birth_date = $('#employee_birth_date').val();

        var age = $('#txt_m_age1').val();

        var landline_no = $('#txt_mobile_no1').val();

        var date_of_join = $('#date_of_join').val();

        var id_upload_url = $('#id_upload_url').val();

        var photo_upload_url = $('#photo_upload_url').val();
        var uan_code = $('#txt_uan').val();

        var visa_country_name = $('#visa_country_name').val();
        var visa_type = $('#visa_type').val();
        var issue_date = $('#issue_date').val();
        var expiry_date = $('#expiry_date').val();
        var visa_amt = $('#txt_visa_amt').val();
        var renewal_amount = $('#renewal_amount').val();

        var bank_name = $('#txt_bank_name').val();
        var branch_name = $('#txt_branch_name').val();
        var ifsc = $('#txt_ifsc').val();
        var acc_no = $('#txt_acc_no').val();

        var basic_pay = $('#txt_basic_pay').val();
        var dear_allow = $('#txt_dear_allow').val();
        var hra = $('#hra').val();
        var travel_allow = $('#txt_travel_allow').val();
        var medi_allow = $('#txt_medi_all').val();
        var special_allow = $('#special_allowance').val();
        var uniform_allowance = $('#uniform_allowance').val();
        var incentive = $('#txt_incentives').val();
        var meal_allowance = $('#meal_allowance').val();
        var gross_salary = $('#gross_salary').val();

        var employee_pf = $('#employee_pf').val();
        var esic = $('#txt_esic').val();
        var pt = $('#txt_pt').val();
        var tds = $('#txt_tds').val();
        var labour_all = $('#txt_labour').val();
        var employer_pf = $('#employer_pf').val();
        var deduction = $('#txt_deduction').val();
        var net_salary = $('#net_salary').val();

        //Mailing details
        var app_smtp_status = $('#app_smtp_status').val();
			  var app_smtp_host = $('#app_smtp_host').val();
			  var app_smtp_port = $('#app_smtp_port').val();
			  var app_smtp_password = $('#app_smtp_password').val();
			  var app_smtp_method = $('#app_smtp_method').val();

        // if(issue_date>=expiry_date){
        //   error_msg_alert("Visa issue date can't be equal or greater than expiry date"); 
        //  return false; }
  
    
    $('#btn_save').button('loading');

    $.ajax({

      type:'post',

      url: base_url+'controller/employee/emp_master_save.php',

      data:{ first_name : first_name, last_name : last_name, gender : gender, username : username, password : password, address : address, mobile_no : mobile_no, email_id : email_id, location_id : location_id, branch_id : branch_id, salary : salary, role_id : role_id,target : target, active_flag : active_flag , employee_birth_date : employee_birth_date , age : age, mobile_no : mobile_no, date_of_join : date_of_join, id_upload_url : id_upload_url , photo_upload_url : photo_upload_url,incentive_per:incentive_per, visa_country_name : visa_country_name, visa_type : visa_type, issue_date : issue_date, expiry_date : expiry_date, visa_amt : visa_amt, renewal_amount : renewal_amount, bank_name : bank_name, branch_name : branch_name, ifsc : ifsc, acc_no : acc_no, basic_pay : basic_pay, dear_allow : dear_allow, hra : hra, travel_allow : travel_allow, medi_allow : medi_allow, special_allow : special_allow, uniform_allowance : uniform_allowance, incentive : incentive, meal_allowance : meal_allowance, gross_salary : gross_salary, employee_pf : employee_pf, esic :esic, pt : pt, tds : tds, labour_all : labour_all, employer_pf : employer_pf, deduction : deduction, net_salary : net_salary, landline_no : landline_no,uan_code : uan_code, app_smtp_status : app_smtp_status, app_smtp_host : app_smtp_host, app_smtp_port : app_smtp_port, app_smtp_password : app_smtp_password, app_smtp_method : app_smtp_method , country_code : country_code},

      success: function(message){
             message = message.trim();
                if(message == 'error--The username has already been taken..')
                {
                  error_msg_alert(message); 
                  $('#btn_save').button('reset');
                } 
                else
                { 
                  msg_alert(message);
                  $('#save_modal').modal('hide');
                  $('#save_modal').on('hidden.bs.modal',
                  function(){
                   employee_list_reflect();
                  });
                }
                }  

    });

  } 
});



           

</script>