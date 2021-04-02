<?php

include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
?>

<form id="frm_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" name="emp_salry_count" id="emp_salry_count">
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">New Salary</h4>

      </div>

      <div class="modal-body">
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
            <div class="row">
              <div class="col-md-4 mg_bt_10_xs">
                <select id="emp_id_filter" name="emp_id_filter" title="User Name" style="width: 100%" onchange="salary_reflect()">
                  <option value="">Select User</option>
                  <?php 
                  $query ="select * from emp_master where 1 and active_flag!='Inactive'";  
                  if($branch_status=='yes' && $role!='Admin'){
                      $query .=" and branch_id='$branch_admin_id'";
                  } 
                   
                  $sq_users = mysql_query($query);
                  while($row_users = mysql_fetch_assoc($sq_users)){
                    ?>
                    <option value="<?= $row_users['emp_id'] ?>"><?= $row_users['first_name'].' '.$row_users['last_name'] ?></option>
                    <?php
                  } ?>
                </select>
              </div>  
              <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                <select name="year_filter" style="width: 100%" id="year_filter" title="Year">
                  <option value="">Year</option>
                  <?php 
                  for($year_count=2018; $year_count<2099; $year_count++){
                    ?>
                    <option value="<?= $year_count ?>"><?= $year_count ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                <select name="month_filter" style="width: 100%" id="month_filter" title="Month" onchange="get_emp_salary_status();get_incentive_amt()">
                  <option value="">Month</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>

              </div>
            </div>
          </div>
          
          <br>
        <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">

            <legend>Monthly Package</legend>

            <div class="row text-center mg_tp_10">
              <div class="col-sm-3 mg_bt_10">
                <input type="text" title="Basic Pay" id="txt_basic_pay1" placeholder="Basic Pay" name="txt_basic_pay" onchange="validate_balance(this.id);calculate_total_payable('1')">
              </div> 
              <div class="col-sm-3 mg_bt_10">
                <input type="text" placeholder="Dearness Allowance" title="Dearness Allowance" id="txt_dear_allow1" onchange="validate_balance(this.id);calculate_total_payable('1')" >
              </div> 
                    <div class="col-sm-3 mg_bt_10">
                <input type="text" title="HRA" id="hra1" placeholder="HRA" onchange="validate_balance(this.id);calculate_total_payable('1')" >
              </div> 
              <div class="col-sm-3 mg_bt_10">
                <input type="text" placeholder="Travel Allowance" title="Travel Allowance" id="txt_travel_allow1" onchange="validate_balance(this.id);calculate_total_payable('1')" >
              </div> 
              <div class="col-sm-3 mg_bt_10">
                  <input type="text" placeholder="Medical Allowance" title="Medical Allowance" id="txt_medi_all1" onchange="validate_balance(this.id);calculate_total_payable('1')"> 
              </div>
              <div class="col-sm-3 mg_bt_10_sm_xs">
                <input type="text" placeholder="Special Allowance" title="Special Allowance" id="special_allowance1" onchange="validate_balance(this.id);calculate_total_payable('1')"> 
              </div>
           
              <div class="col-md-3 col-sm-6 mg_bt_10">
                    <input class="form-control" id="uniform_allowance1" name="uniform_allowance" type="text"  placeholder="Uniform Allowance" title="Uniform Allowance" onchange="validate_balance(this.id);calculate_total_payable('1') "/>    
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_incentives1" name="txt_incentives" type="text" placeholder="Incentives" title="Incentives" onchange="validate_balance(this.id);calculate_total_payable('1')"   />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="meal_allowance1" name="meal_allowance" type="text" placeholder="Meal Allowance" title="Meal Allowance" onchange="validate_balance(this.id);calculate_total_payable('1')"  />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="phone_allowance1" name="phone_allowance1" type="text" placeholder="Phone Allowance" title="Phone Allowance" onchange="validate_balance(this.id);calculate_total_payable('1')"   />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="misc_earning1" name="misc_earning1" type="text" placeholder="Misc Earning" title="Misc Earning" onchange="validate_balance(this.id);calculate_total_payable('1')"  />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="gross_salary1" name="gross_salary" type="text" placeholder="Gross Salary" title="Gross Salary"   disabled />
              </div> 
              

            </div> 
         </div>
            <br>  
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">

            <legend>Deductions</legend>     
             
          <div class="row mg_tp_10">
             <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="salary_advance1" name="salary_advance" type="text" placeholder="Salary Advance" title="Salary Advance" onchange="validate_balance(this.id);calculate_total_payable('1')" />

              </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="loan_ded1" name="loan_ded1" placeholder="Loan" title="Loan" onchange="validate_balance(this.id);calculate_total_payable('1')"  >

              </div> 
              
               <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="surcharge_deduction1" name="surcharge_deduction" placeholder="Surcharge" title="Surcharge" onchange="validate_balance(this.id);calculate_total_payable('1')"  >

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="cess_deduction1" name="cess_deduction" placeholder="Cess" title="Cess" onchange="validate_balance(this.id);calculate_total_payable('1')"  >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="employer_pf1" name="employer_pf" placeholder="Employer PF" title="Employer PF" onchange="validate_balance(this.id);calculate_total_payable('1')"  >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="employee_pf1" name="employee_pf" type="text" placeholder="Employee PF" title="Employee PF" onchange="validate_balance(this.id);calculate_total_payable('1')"  />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_esic1" name="txt_esic" type="text" placeholder="ESIC" title="ESIC" onchange="validate_balance(this.id);calculate_total_payable('1')"   />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="txt_pt1" name="txt_pt" placeholder="PT" title="PT" class="form-control" onchange="validate_balance(this.id);calculate_total_payable('1')" >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_tds1" name="txt_tds" type="text" placeholder="TDS" title="TDS" onchange="validate_balance(this.id);calculate_total_payable('1')" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_labour1" name="txt_labour" type="text" placeholder="Labour Welfare Fund" title="Labour Welfare Fund" onchange="validate_balance(this.id);calculate_total_payable('1')"   />

              </div>
               <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" id="leave_deduction1" name="leave_deduction" type="text" placeholder="Leave Deductions" title="Leave Deductions"  onchange="validate_balance(this.id);calculate_total_payable('1')" />
              </div>
               <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" id="txt_deduction1" name="txt_deduction" type="text" placeholder="Total Deductions" title="Total Deductions"  disabled/>
              </div>
            </div>
          </div> 
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
             <div class="row mg_tp_10">
              <div class="col-md-2 mg_tp_20"><label for="net_salary">Net Salary</label></div>
              <div class="col-md-3 col-sm-6 mg_tp_10" style="margin-left: -54px;">
                <input type="text" id="net_salary1" name="net_salary" placeholder="Net Salary" title="Net Salary" disabled  >
              </div> 
            </div> 
          </div>

        <div class="row text-center">
          <div class="col-md-12">
            <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
          </div>
        </div>
    </div>
  </div>
</div>
</form>

<script>
$('#save_modal').modal('show');
$('#emp_id_filter, #year_filter, #month_filter').select2();

  //Validation employee salary for perticular month gets saved only once 
function get_emp_salary_status()
{
  var emp_id = $('#emp_id_filter').val();
  var year = $('#year_filter').val();
  var month = $('#month_filter').val();
  $.post(base_url()+'view/reports/staff_mgmt/report_reflect/emp_salary/get_emp_salary_status.php', { emp_id : emp_id, year : year, month : month}, function(data){
    $('#emp_salry_count').val(data);
  });
}
function get_incentive_amt(){
  var emp_id = $('#emp_id_filter').val();
  var year = $('#year_filter').val();
  var month = $('#month_filter').val();
  var financial_year_id = <?= $financial_year_id ?>;

  $.post(base_url()+'view/reports/staff_mgmt/report_reflect/emp_salary/get_incentive_amt.php', { emp_id : emp_id, year : year, month : month,financial_year_id:financial_year_id}, function(data){
    console.log(data);
    $('#txt_incentives1').val(data);
  });
}
$('#frm_save').validate({
    rules:{
            emp_id_filter : { required : true },
            year_filter : { required : true },
            month_filter : { required : true },
    },
    submitHandler:function()
    {
        

        var emp_id = $('#emp_id_filter').val();
        var year = $('#year_filter').val();
        var month = $('#month_filter').val();
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
        var phone_allowance = $('#phone_allowance1').val();
        var misc_earning = $('#misc_earning1').val();
        var salary_advance = $('#salary_advance1').val();
        var loan_ded = $('#loan_ded1').val();
        var surcharge_deduction = $('#surcharge_deduction1').val();
        var cess_deduction = $('#cess_deduction1').val();
        var employee_pf = $('#employee_pf1').val();
        var esic = $('#txt_esic1').val();
        var pt = $('#txt_pt1').val();
        var tds = $('#txt_tds1').val();
        var labour_all = $('#txt_labour1').val();
        var employer_pf = $('#employer_pf1').val();
        var leave_deduction = $('#leave_deduction1').val();
        var deduction = $('#txt_deduction1').val();
        var net_salary = $('#net_salary1').val();        
        var count = $('#emp_salry_count').val();

        if(parseFloat(count) != '0'){ error_msg_alert("User Salary already added for this month!"); return false; }
        else
        {
          $('#btn_save').button('loading');
          $.ajax({

            type: 'post',

            url: base_url()+'controller/employee/salary/employee_salary_save.php',

            data:{ emp_id : emp_id, year : year, month : month, basic_pay : basic_pay, dear_allow : dear_allow, hra : hra, travel_allow : travel_allow, medi_allow : medi_allow, special_allow : special_allow, uniform_allowance : uniform_allowance, incentive : incentive, meal_allowance : meal_allowance, gross_salary : gross_salary, employee_pf : employee_pf, esic :esic, pt : pt, tds : tds, labour_all : labour_all, employer_pf : employer_pf, deduction : deduction, net_salary : net_salary , phone_allowance : phone_allowance, misc_earning : misc_earning, salary_advance : salary_advance, loan_ded : loan_ded, surcharge_deduction : surcharge_deduction, cess_deduction : cess_deduction, leave_deduction : leave_deduction},

            success: function(result){

              $('#btn_save').button('reset');
              msg_alert(result);
              $('#save_modal').modal('hide');

            }

          });
        }
    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>