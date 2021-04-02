<form id="frm_tab2_u">

<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

       <legend>Bank Information</legend>                

          <div class="row text-center mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_bank_name1" name="txt_bank_name" placeholder="Bank Name" title="Bank Name" value="<?= $emp_info['bank_name'] ?>" style="text-transform: uppercase;" > 

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_branch_name1" name="txt_branch_name" placeholder="Branch Name"  title="Branch Name" onchange="validate_branch(this.id);" value="<?= $emp_info['branch_name'] ?>"  >

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_ifsc1" name="txt_ifsc" placeholder="IFSC/Swift Code" title="IFSC/Swift Code" onchange="validate_IFSC(this.id);" value="<?= $emp_info['ifsc'] ?>" style="text-transform: uppercase;" >

              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" type="text" id="txt_acc_no1" name="txt_acc_no" placeholder="A/c No" title="A/c No." onchange="validate_accountNo(this.id);" value="<?= $emp_info['acc_no'] ?>" >

              </div>
          </div>
        </div>

        

        <div class="panel panel-default panel-body app_panel_style mg_tp_30 feildset-panel">

       <legend>Salary Information</legend>
       <h3 class="editor_title">Monthly Package</h3>

          <div class="row text-center mg_tp_10">
            <div class="col-sm-3 mg_bt_10">
          <input type="text" title="Basic Pay" id="txt_basic_pay1" placeholder="Basic Pay" name="txt_basic_pay" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['basic_pay'] ?>" >
        </div> 
        <div class="col-sm-3 mg_bt_10">
          <input type="text" placeholder="Dearness Allowance" title="Dearness Allowance" id="txt_dear_allow1" name="txt_dear_allow" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['dear_allow'] ?>" >
        </div> 
              <div class="col-sm-3 mg_bt_10">
          <input type="text" title="HRA" id="hra1" name="hra" placeholder="HRA" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['hra'] ?>" >
        </div> 
        <div class="col-sm-3 mg_bt_10">
          <input type="text" placeholder="Travel Allowance" title="Travel Allowance" id="txt_travel_allow1" name="txt_travel_allow" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['travel_allow'] ?>" >
        </div> 
        <div class="col-sm-3 mg_bt_10">
            <input type="text" placeholder="Medical Allowance" title="Medical Allowance" id="txt_medi_all1" name="txt_medi_all" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['medi_allow'] ?>" > 
        </div>
        <div class="col-sm-3 mg_bt_10_sm_xs">
          <input type="text" placeholder="Special Allowance" title="Special Allowance" id="special_allowance1" name="special_allowance"  onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['special_allow'] ?>" > 
        </div>
           
              <div class="col-md-3 col-sm-6 mg_bt_10">
                    <input class="form-control" id="uniform_allowance1" name="uniform_allowance" type="text"  placeholder="Uniform Allowance" title="Uniform Allowance" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['uniform_allowance'] ?>" />    
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_incentives1" name="txt_incentives" type="text" placeholder="Incentives" title="Incentives" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['incentive'] ?>"  />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="meal_allowance1" name="meal_allowance" type="text" placeholder="Meal Allowance" title="Meal Allowance" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['meal_allowance'] ?>" />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">
         <input class="form-control" id="gross_salary1" name="gross_salary" type="text" placeholder="Gross Salary" title="Gross Salary" value="<?= $emp_info['gross_salary'] ?>" disabled />
              </div> 

            </div> 
            <br>    

          <h3 class="editor_title">Deductions</h3>
          <div class="row mg_tp_10">

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="employer_pf1" name="employer_pf" placeholder="Employer PF" title="Employer PF" onchange="calculate_total_payable('1');validate_balance(this.id);" value="<?= $emp_info['employer_pf'] ?>" >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="employee_pf1" name="employee_pf" type="text" placeholder="Employee PF" title="Employee PF" onchange="calculate_total_payable('1');validate_balance(this.id);" value="<?= $emp_info['employee_pf'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_esic1" name="txt_esic" type="text" placeholder="ESIC" title="ESIC" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['esic'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="txt_pt1" name="txt_pt" placeholder="PT" title="PT" class="form-control" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['pt'] ?>" >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_tds1" name="txt_tds" type="text" placeholder="TDS" title="TDS" onchange="calculate_total_payable('1');validate_balance(this.id)" value="<?= $emp_info['tds'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_labour1" name="txt_labour" type="text" placeholder="Labour Welfare Fund" title="Labour Welfare Fund" onchange="calculate_total_payable('1');validate_balance(this.id);" value="<?= $emp_info['labour_all'] ?>" />

              </div>
               <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_deduction1" name="txt_deduction" type="text" placeholder="Total Deductions" title="Total Deductions" value="<?= $emp_info['deduction'] ?>"  disabled/>

              </div>
               
            </div>
             <div class="row mg_tp_10">
              <div class="col-md-2 mg_tp_20"><label for="net_salary">Net Salary</label></div>
              <div class="col-md-3 col-sm-6 mg_tp_10" style="margin-left: -54px;">
                <input type="text" id="net_salary1" name="net_salary" placeholder="Net Salary" title="Net Salary" disabled value="<?= $emp_info['net_salary'] ?>" >
              </div> 
            </div> 
 </div>
      <div class="row mg_tp_20 text-center">

        <div class="col-md-12">

          <button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Previous</button>

          &nbsp;&nbsp;

          <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

        </div>

  </div>

</form>



<script>

function switch_to_tab1(){ $('a[href="#tab1u"]').tab('show'); }

$('#frm_tab2_u').validate({

  rules:{

       // txt_bank_name : { required : true },
  },

  submitHandler:function(form){
      var base_url = $('#base_url').val();
      var emp_id = $('#txt_emp_id').val();

      var first_name = $("#txt_first_name1").val();

      var last_name = $("#txt_last_name1").val();

      var username = $("#emp_username11").val();

      var gender = $("#cmb_gender1").val();

      var password = $("#txt_password1").val();

      var re_password = $("#txt_password11").val();

      var address = $("#txt_address1").val();

      var mobile_no = $("#txt_mobile_no11").val();

      var country_code = $('#country_code1').val();

      var email_id = $("#txt_email_id1").val();

      var location_id = $("#location_id").val(); 

      var branch_id = $("#branch_id").val(); 

      var salary = $("#salary").val(); 

      var role_id = $("#role_id1").val();

      var target = $('#txt_target1').val(); 
      var incentive_per = $('#txt_incentive_per1').val(); 
      var active_flag = $('#active_flag').val();

      var employee_birth_date = $('#employee_birth_date1').val();

      var age = $('#txt_m_age1').val();

      var landline_no = $('#txt_mobile_no2').val();

      var date_of_join = $('#date_of_join1').val();

      var id_upload_url = $('#id_upload_url1').val();

      var photo_upload_url = $('#photo_upload_url_u').val();
      var uan_code = $('#txt_uan1').val();
      var visa_country_name = $('#visa_country_name1').val();
      var visa_type = $('#visa_type1').val();
      var issue_date = $('#issue_date1').val();
      var expiry_date = $('#expiry_date1').val();
      var visa_amt = $('#txt_visa_amt1').val();
      var renewal_amount = $('#renewal_amount1').val();

      var bank_name = $('#txt_bank_name1').val();
      var branch_name = $('#txt_branch_name1').val();
      var ifsc = $('#txt_ifsc1').val();
      var acc_no = $('#txt_acc_no1').val();

          var basic_pay = $('#txt_basic_pay1').val();
      var dear_allow = $('#txt_dear_allow1').val();
      var hra = $('#hra1').val();
      var travel_allow = $('#txt_travel_allow1').val();
      var medi_allow = $('#txt_medi_all1').val();
      var special_allow = $('#special_allowance1').val();
      var uniform_allowance = $('#uniform_allowance1').val();
      var incentive = $('#txt_incentives1').val();
      var meal_allowance = $('#meal_allowance1').val();
      var gross_salary = $('#gross_salary1').val();
      var employee_pf = $('#employee_pf1').val();
      var esic = $('#txt_esic1').val();
      var pt = $('#txt_pt1').val();
      var tds = $('#txt_tds1').val();
      var labour_all = $('#txt_labour1').val();
      var employer_pf = $('#employer_pf1').val();
      var deduction = $('#txt_deduction1').val();
      var net_salary = $('#net_salary1').val();

      //Mailing details
      var app_smtp_status = $('#app_smtp_status').val();
      var app_smtp_host = $('#app_smtp_host').val();
      var app_smtp_port = $('#app_smtp_port').val();
      var app_smtp_password = $('#app_smtp_password').val();
      var app_smtp_method = $('#app_smtp_method').val();
 
        if(password!=re_password)

        {

          error_msg_alert('Password did not match!'); 

          return false; 

        }

    $('#btn_update').button('loading');

    $.ajax({

      type:'post',

      url: base_url+'controller/employee/emp_master_update.php',

      data:{ emp_id : emp_id, first_name : first_name, last_name : last_name, gender : gender, username : username, password : password, address : address, mobile_no : mobile_no, email_id : email_id, location_id : location_id, branch_id : branch_id, salary : salary, role_id : role_id,target : target, active_flag : active_flag , employee_birth_date : employee_birth_date , age : age, landline_no : landline_no, date_of_join : date_of_join, id_upload_url : id_upload_url , photo_upload_url : photo_upload_url,incentive_per:incentive_per, visa_country_name : visa_country_name, visa_type : visa_type, issue_date : issue_date, expiry_date : expiry_date, visa_amt : visa_amt, renewal_amount : renewal_amount, bank_name : bank_name, branch_name : branch_name, ifsc : ifsc, acc_no : acc_no, basic_pay : basic_pay, dear_allow : dear_allow, hra : hra, travel_allow : travel_allow, medi_allow : medi_allow, special_allow : special_allow, uniform_allowance : uniform_allowance, incentive : incentive, meal_allowance : meal_allowance, gross_salary : gross_salary, employee_pf : employee_pf, esic :esic, pt : pt, tds : tds, labour_all : labour_all, employer_pf : employer_pf, deduction : deduction, net_salary : net_salary,uan_code : uan_code, app_smtp_status : app_smtp_status, app_smtp_host : app_smtp_host, app_smtp_port : app_smtp_port, app_smtp_password : app_smtp_password, app_smtp_method : app_smtp_method , country_code : country_code},

      success: function(message){

          $('#btn_update').button('reset');

                  var msg = message.split('--');

          if(msg[0]=="error"){

            error_msg_alert(msg[1]);

          }

          else{

            
            msg_alert(message);
                  $('#update_modal').modal('hide');
                  $('#update_modal').on('hidden.bs.modal',
                  function(){
                   employee_list_reflect();
                  });

          }
       }  
              

    });

  }  


});

</script>