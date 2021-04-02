<?php

include "../../../../../model/model.php";
 
require_once('../../../../layouts/app_functions.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$salary_id = $_POST['salary_id'];
 
$sq_sal = mysql_fetch_assoc(mysql_query("select * from employee_salary_master where salary_id='$salary_id'"));
  
?>

<form id="frm_update">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="salary_id" name="salary_id" value="<?= $salary_id ?>" >
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Salary</h4>

      </div>

      <div class="modal-body">
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
            <div class="row">
              <div class="col-md-4 mg_bt_10_xs">
                <select id="emp_id" name="emp_id" title="User Name" style="width: 100%" disabled>
                  <?php 
                  $query ="select * from emp_master where emp_id='$sq_sal[emp_id]'";  
                  $sq_users = mysql_query($query);
                  while($row_users = mysql_fetch_assoc($sq_users)){
                    ?>
                    <option value="<?= $row_users['emp_id'] ?>"><?= $row_users['first_name'].' '.$row_users['last_name'] ?></option>
                    <?php
                  } ?>
                </select>
              </div>  
              <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                <input type='text' name="year_filter2" style="width: 100%" id="year_filter2" title="Year" value="<?= $sq_sal['year'] ?>" disabled>
              </div>
              <div class="col-md-4 col-sm-6 mg_bt_10_xs">
                <select name="month_filter2" style="width: 100%" id="month_filter2" title="Month" disabled>
                  <?php 
                  $month = $sq_sal['month'];
                     if($month==01){ $month_name ="January"; }
                     if($month==2){ $month_name ="February"; } 
                     if($month==3){ $month_name ="March"; } 
                     if($month==4){ $month_name ="April"; }
                     if($month==5){ $month_name ="May"; }
                     if($month==6){ $month_name ="June"; }
                     if($month==7){ $month_name ="July"; } 
                     if($month==8){ $month_name ="August"; }
                     if($month==9){ $month_name ="September"; }
                     if($month==10){ $month_name ="October"; }
                     if($month==11){ $month_name ="November"; }
                     if($month==12){ $month_name ="December"; }
                 ?>
                  <option value="<?= $month ?>"><?= $month_name ?></option>
                </select>

              </div>
            </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_30">

            <legend>Monthly Package</legend>

            <div class="row text-center mg_tp_10">
              <div class="col-sm-3 mg_bt_10">
                <input type="text" title="Basic Pay" id="txt_basic_pay" placeholder="Basic Pay" name="txt_basic_pay" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['basic_pay'] ?>">
              </div> 
              <div class="col-sm-3 mg_bt_10">
                <input type="text" placeholder="Dearness Allowance" title="Dearness Allowance" id="txt_dear_allow" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['dear_allow'] ?>">
              </div> 
              <div class="col-sm-3 mg_bt_10">
                <input type="text" title="HRA" id="hra" placeholder="HRA" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['hra'] ?>">
              </div> 
              <div class="col-sm-3 mg_bt_10">
                <input type="text" placeholder="Travel Allowance" title="Travel Allowance" id="txt_travel_allow" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['travel_allow'] ?>" >
              </div> 
              <div class="col-sm-3 mg_bt_10">
                  <input type="text" placeholder="Medical Allowance" title="Medical Allowance" id="txt_medi_all" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['medi_allow'] ?>"> 
              </div>
              <div class="col-sm-3 mg_bt_10_sm_xs">
                <input type="text" placeholder="Special Allowance" title="Special Allowance" id="special_allowance" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['special_allow'] ?>"> 
              </div>
           
              <div class="col-md-3 col-sm-6 mg_bt_10">
                    <input class="form-control" id="uniform_allowance" name="uniform_allowance" type="text"  placeholder="Uniform Allowance" title="Uniform Allowance" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['uniform_allowance'] ?>"/>    
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_incentives" name="txt_incentives" type="text" placeholder="Incentives" title="Incentives" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['incentive'] ?>"  />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="meal_allowance" name="meal_allowance" type="text" placeholder="Meal Allowance" title="Meal Allowance" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['meal_allowance'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="phone_allowance" name="phone_allowance" type="text" placeholder="Phone Allowance" title="Phone Allowance" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['phone_allowance'] ?>"  />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="misc_earning" name="misc_earning" type="text" placeholder="Misc Earning" title="Misc Earning" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['misc_earning'] ?>" />

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">
                <input class="form-control" id="gross_salary" name="gross_salary" type="text" placeholder="Gross Salary" title="Gross Salary"   disabled value="<?= $sq_sal['gross_salary'] ?>"/>
              </div> 
            </div> 
         </div>
            <br>  
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">

            <legend>Deductions</legend>     
             
          <div class="row mg_tp_10">
             <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="salary_advance" name="salary_advance" type="text" placeholder="Salary Advance" title="Salary Advance" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['salary_advance'] ?>"/>

              </div> 
            <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="loan_ded" name="loan_ded" placeholder="Loan" title="Loan" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['loan_ded'] ?>"  >

              </div> 
              
               <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="surcharge_deduction" name="surcharge_deduction" placeholder="Surcharge" title="Surcharge" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['surcharge_deduction'] ?>" >

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="cess_deduction" name="cess_deduction" placeholder="Cess" title="Cess" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['cess_deduction'] ?>" >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="employer_pf" name="employer_pf" placeholder="Employer PF" title="Employer PF" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['employer_pf'] ?>" >

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="employee_pf" name="employee_pf" type="text" placeholder="Employee PF" title="Employee PF" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['employee_pf'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_esic" name="txt_esic" type="text" placeholder="ESIC" title="ESIC" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['esic'] ?>"  />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input type="text" id="txt_pt" name="txt_pt" placeholder="PT" title="PT" class="form-control" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['pt'] ?>">

              </div> 

              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_tds" name="txt_tds" type="text" placeholder="TDS" title="TDS" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['tds'] ?>" />

              </div> 
              <div class="col-md-3 col-sm-6 mg_bt_10">

                  <input class="form-control" id="txt_labour" name="txt_labour" type="text" placeholder="Labour Welfare Fund" title="Labour Welfare Fund" onchange="validate_balance(this.id);calculate_total_payable()" value="<?= $sq_sal['labour_all'] ?>"  />

              </div>
               <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" id="leave_deduction" name="leave_deduction" type="text" placeholder="Leave Deductions" title="Leave Deductions"  onchange="validate_balance(this.id);calculate_total_payable()"  value="<?= $sq_sal['leave_deduction'] ?>" />
              </div>
               <div class="col-md-3 col-sm-6 mg_bt_10">
                  <input class="form-control" id="txt_deduction" name="txt_deduction" type="text" placeholder="Total Deductions" title="Total Deductions" value="<?= $sq_sal['deduction'] ?>" disabled/>

              </div>
            </div>
          </div> 
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
             <div class="row mg_tp_10">
              <div class="col-md-2 mg_tp_20"><label for="net_salary">Net Salary</label></div>
              <div class="col-md-3 col-sm-6 mg_tp_10" style="margin-left: -54px;">
                <input type="text" id="net_salary" name="net_salary" placeholder="Net Salary" title="Net Salary" value="<?= $sq_sal['net_salary'] ?>" disabled  >
              </div> 
            </div> 
          </div>

        <div class="row text-center">

          <div class="col-md-12">

            <button id="btn_update" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

          </div>

      </div>

    </div>

  </div>

</div>

</form>
<script>

$('#update_modal').modal('show');

$('#frm_update').validate({

    rules:{

            emp_id  : { required : true },
            year_filter2 : { required : true },
            month_filter2 : { required : true },

    },

    submitHandler:function(){
    
        var salary_id = $('#salary_id').val();
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
        var phone_allowance = $('#phone_allowance').val();
        var misc_earning = $('#misc_earning').val();
        var salary_advance = $('#salary_advance').val();
        var loan_ded = $('#loan_ded').val();
        var surcharge_deduction = $('#surcharge_deduction').val();
        var cess_deduction = $('#cess_deduction').val();
        var employee_pf = $('#employee_pf').val();
        var esic = $('#txt_esic').val();
        var pt = $('#txt_pt').val();
        var tds = $('#txt_tds').val();
        var labour_all = $('#txt_labour').val();
        var employer_pf = $('#employer_pf').val();
        var leave_deduction = $('#leave_deduction').val();
        var deduction = $('#txt_deduction').val();
        var net_salary = $('#net_salary').val();

           $('#btn_update').button('loading');

            $.ajax({

              type: 'post',

              url: base_url()+'controller/employee/salary/employee_salary_update.php',

              data:{ salary_id : salary_id , basic_pay : basic_pay, dear_allow : dear_allow, hra : hra, travel_allow : travel_allow, medi_allow : medi_allow, special_allow : special_allow, uniform_allowance : uniform_allowance, incentive : incentive, meal_allowance : meal_allowance, gross_salary : gross_salary, employee_pf : employee_pf, esic :esic, pt : pt, tds : tds, labour_all : labour_all, employer_pf : employer_pf, deduction : deduction, net_salary : net_salary , phone_allowance : phone_allowance, misc_earning : misc_earning, salary_advance : salary_advance, loan_ded : loan_ded, surcharge_deduction : surcharge_deduction, cess_deduction : cess_deduction, leave_deduction : leave_deduction},

              success: function(result){

                $('#btn_update').button('reset');

                msg_alert(result);

                $('#update_modal').modal('hide');
                report_reflect();
              }

            });



    }

});

</script>
 
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>