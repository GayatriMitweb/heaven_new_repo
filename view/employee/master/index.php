<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
 $sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='employee/master/index.php'"));
 $branch_status = $sq['branch_status'];
?>

<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="login_role" name="login_role" value="<?= $role ?>" >
<div class="alert alert-danger hidden" role="alert" id="package_permission">
 Please upgrade the subscription to add more users.
 <button type="button" class="close" onclick="remove_hidden_class()"><span>x</span></button>
</div>

<?= begin_panel('Users Information',7) ?>
  <div class="header_bottom">
    <div class="row">

        <div class="col-md-12 text-right mg_tp_20 mg_bt_20">
          <?php if($role=='Admin' || $role=='Branch Admin'){ ?>
           <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
         <?php } ?>
            <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal();" title="Add New User"><i class="fa fa-plus"></i>&nbsp;&nbsp;User</button>
        </div>
    </div>
  </div> 



    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
                
         <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_xs">
                <select name="role_filter" id="role_filter" title="Select Role">
                    <option value="">Role</option>
                    <?php 
                    $sq_role = mysql_query("select * from role_master where active_flag!='Inactive' order by role_name ");
                    while($row_role = mysql_fetch_assoc($sq_role)){
                        ?>
                        <option value="<?= $row_role['role_name'] ?>"><?= $row_role['role_name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <?php if($role=='Admin'){ ?>
            <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_xs">
            <select name="location_id_filter" id="location_id_filter" onchange="branch_name_load('_filter')" title="Select Location" style="width:100%">
                  <option value="">Select Location</option>
                  <?php 
                  $sq_location = mysql_query("select * from locations where active_flag='Active' order by location_name");
                  while($row_location = mysql_fetch_assoc($sq_location))
                  {
                      ?>
                      <option value="<?= $row_location['location_id'] ?>"><?= $row_location['location_name'] ?></option>
                      <?php
                  }
                  ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_xs">
               <select class="form-control" id="branch_id_filter" name="branch_id_filter" title="Select Branch" >
                  <option value="">Branch</option>
              </select>
            </div>
            <?php } ?>
             
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button class="btn btn-info btn-sm ico_right" onclick="employee_list_reflect()" title="Filter">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

      </div>

    <!-- filetr-panel-end -->

<div class="app_panel_content">
<div id="div_quotation_form"></div>
<div id="div_employee_list" class="loader_parent"></div>
<div id="div_employee_modal"></div>

<input type="hidden" name="user_count" id="user_count">

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
 $('#location_id_filter').select2();
function calculate_total_payable(offset='')
{
  var basic_pay = $('#txt_basic_pay'+offset).val();
  var dear_allow = $('#txt_dear_allow'+offset).val();
  var hra = $('#hra'+offset).val();
  var travel_allow = $('#txt_travel_allow'+offset).val();
  var medi_allow = $('#txt_medi_all'+offset).val();
  var special_allow = $('#special_allowance'+offset).val();
  var uniform_allowance = $('#uniform_allowance'+offset).val();
  var incentive = $('#txt_incentives'+offset).val();
  var meal_allowance = $('#meal_allowance'+offset).val();

  var employee_pf = $('#employee_pf'+offset).val();
  var esic = $('#txt_esic'+offset).val();
  var pt = $('#txt_pt'+offset).val();
  var tds = $('#txt_tds'+offset).val();
  var labour_all = $('#txt_labour'+offset).val();
  var employer_pf = $('#employer_pf'+offset).val();
 
  if(basic_pay==""){ basic_pay=0; }
  if(dear_allow==""){ dear_allow=0; }
  if(hra==""){ hra=0; }
  if(travel_allow==""){ travel_allow=0; }
  if(medi_allow==""){ medi_allow=0; }
  if(special_allow==""){ special_allow=0; }
  if(uniform_allowance==""){ uniform_allowance=0; }
  if(incentive==""){ incentive=0;}
  if(meal_allowance==""){ meal_allowance=0; }

  if(employee_pf==""){ employee_pf=0; }
  if(esic==""){ esic=0; }
  if(pt==""){ pt=0; }
  if(labour_all==""){ labour_all=0; }
  if(employer_pf==""){ employer_pf=0; }
  if(tds==""){ tds=0; }

  var total_addition= parseFloat(basic_pay) + parseFloat(dear_allow) + parseFloat(hra) + parseFloat(travel_allow) + parseFloat(medi_allow) + parseFloat(special_allow) + parseFloat(uniform_allowance) + parseFloat(incentive) + parseFloat(meal_allowance);
  total_addition = round_off_value(total_addition);
  $('#gross_salary'+offset).val(total_addition);

var total_deduction = parseFloat(employee_pf) + parseFloat(esic) + parseFloat(pt) + parseFloat(labour_all) + parseFloat(employer_pf) + parseFloat(tds);
  total_deduction = round_off_value(total_deduction);
  $('#txt_deduction'+offset).val(total_deduction);
  
  var total_add_value =  parseFloat(total_addition) - parseFloat(total_deduction);
  total_add_value = round_off_value(total_add_value);
  $('#net_salary'+offset).val(total_add_value);


}
function employee_list_reflect()
{
    $('#div_employee_list').append('<div class="loader"></div>');
    var role = $('#role_filter').val();
    var active_flag = $('#active_flag_filter').val();
    var location_id = $('#location_id_filter').val();
    var branch_id = $('#branch_id_filter').val();   
    var branch_status = $('#branch_status').val();
    var login_role = $('#login_role').val();
    $.post('employee_list_reflect.php', { role : role, active_flag : active_flag, location_id : location_id, branch_id : branch_id , branch_status : branch_status,login_role  : login_role}, function(data){
        $('#div_employee_list').html(data);
    });
}
employee_list_reflect();

function save_modal()
{
  var branch_status = $('#branch_status').val();
  check_package_type('<?= $setup_package ?>','user');
  var user_count = $('#user_count').val();
  if(<?= $setup_package ?> == '1'){
      if(user_count < '5'){
         $.post('save/index.php', {branch_status, branch_status}, function(data){
          $('#div_quotation_form').html(data);
         });
      }
      else {
        $('#package_permission').removeClass('hidden');   
      }
  }
  else{
    $.post('save/index.php', {branch_status, branch_status}, function(data){
          $('#div_quotation_form').html(data);
    });
  }

  /*if(status == 'true'){
    var branch_status = $('#branch_status').val();
      $.post('save/index.php', {branch_status, branch_status}, function(data){
          $('#div_quotation_form').html(data);
      });
  }*/
}
function update_modal(emp_id)
{
  var branch_status = $('#branch_status').val();
    $.post('update/index.php', {emp_id : emp_id, branch_status : branch_status}, function(data){
        $('#div_employee_modal').html(data);
    });
}

function branch_name_load(offset='')
{
  var location_id = $('#location_id'+offset).val();

  $.post('branch_name_load.php', { location_id : location_id }, function(data){
    $('#branch_id'+offset).html(data);
  });
}
function address_reflect(offset='')
{
  var branch_id = $('#branch_id'+offset).val();
  $.post('address_load.php', { branch_id : branch_id}, function(data){
    $('#txt_address'+offset).html(data);
   
  });
}
address_reflect();
function display_modal(emp_id)
{
    $.post('view/index.php', {emp_id : emp_id}, function(data){
        $('#div_employee_modal').html(data);
    });
}
function calculate_age_member(id) 
{
  var dateString1=$("#"+id).val();
  var get_new = dateString1.split('-');
  var day=get_new[0];
  var month=get_new[1];
  var year=get_new[2];

  var dateString = month+"/"+day+"/"+year;


  tagText = dateString.replace(/-/g, '/');
  var today = new Date(); 
  var birthDate = new Date(tagText);
  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  } 
 //var count=id.substr(11);
 //var id1="txt_m_age"+count; 

 if(age<1)
 {  
  //document.getElementById("id").value="";
  var age_error ="Age should be greater than 0."; 
 }
 else{
  var age_error ="";
 }
 $('#div_employee_age').html(age_error); 
 $('#txt_m_age1').val(age); 
  
}

function excel_report()
{
  var role = $('#role_filter').val();
  var location_id = $('#location_id_filter').val();
  var branch_id = $('#branch_id_filter').val();
  
  window.location = 'excel_report.php?role='+role+'&location_id='+location_id+'&branch_id='+branch_id;
}
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>