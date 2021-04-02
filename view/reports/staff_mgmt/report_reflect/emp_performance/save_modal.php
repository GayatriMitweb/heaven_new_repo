<?php
include "../../../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>

<form id="frm_save">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Performance</h4>
      </div>

      <div class="modal-body">
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">
            <div class="row">
              <div class="col-md-4 mg_bt_10_xs">
                <select id="emp_id1" name="emp_id1" title="User Name" style="width: 100%">
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
                <select name="month_filter_save" style="width: 100%" id="month_filter_save" title="Month">
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
            </div>
          </div>
          <div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_10">

            <div class="row text-center mg_tp_10">
              <div class="col-sm-3 mg_bt_10">
               <select name="teamwork" style="width: 100%" id="teamwork" title="Teamwork" onchange="rating_reflect()">
                  <option value="">Teamwork</option>
                  <?php 
                   for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div> 
              <div class="col-sm-3 mg_bt_10">
              <select name="leadership" style="width: 100%" id="leadership" title="Leadership" onchange="rating_reflect()">
                  <option value="">Leadership</option>
                  <?php 
                   for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div> 
              <div class="col-sm-3 mg_bt_10">
                 <select name="communication" style="width: 100%" id="communication" title="Communication" onchange="rating_reflect()">
                  <option value="">Communication</option>
                  <?php 
                   for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-3 mg_bt_10_sm_xs">
               <select name="analytical_skills" style="width: 100%" id="analytical_skills" title="Analytical Skills" onchange="rating_reflect()">
                  <option value="">Analytical Skills</option>
                  <?php 
                  for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="row text-center mg_tp_10">
              <div class="col-md-3 col-sm-6">
                   <select name="ethics" style="width: 100%" id="ethics" title="Ethics" onchange="rating_reflect()">
                  <option value="">Ethics</option>
                  <?php 
                   for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>   
              </div>

              <div class="col-md-3 col-sm-6 mg_bt_10">

                <select name="conceptual_thinking" style="width: 100%" id="conceptual_thinking" title="Conceptual Thinking" onchange="rating_reflect()">
                  <option value="">Conceptual Thinking</option>
                  <?php 
                  for($i=1; $i<=5; $i++){
                    ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                  }
                  ?>
                </select>

              </div> 
              <input type="hidden" id="ave_ratings" name="ave_ratings">

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

$('#emp_id1, #year_filter,#month_filter_save').select2();


$('#frm_save').validate({

    rules:{

            emp_id1 : { required : true },
            year_filter : { required : true },

    },

    submitHandler:function(){
        var emp_id = $('#emp_id1').val();
        var year = $('#year_filter').val();
        var month = $('#month_filter_save').val();
        var leadership = $('#leadership').val();
        var communication = $('#communication').val();
        var analytical_skills = $('#analytical_skills').val();
        var ethics = $('#ethics').val();
        var conceptual_thinking = $('#conceptual_thinking').val();
        var teamwork = $('#teamwork').val();
        var ave_ratings = $('#ave_ratings').val();
 
            $('#btn_save').button('loading');

            $.ajax({

              type: 'post',

              url: base_url()+'controller/employee/performance/performance_save.php',

              data:{ emp_id : emp_id, year : year,month: month,  leadership : leadership, communication : communication, analytical_skills : analytical_skills, ethics : ethics , conceptual_thinking : conceptual_thinking ,  teamwork : teamwork , ave_ratings : ave_ratings},

              success: function(result){

                $('#btn_save').button('reset');
                var data = result.split('--');
                if(data[0] =="error"){
                  error_msg_alert(data[1]);
                  return false;
                }
                else{
                  success_msg_alert(result);
                  $('#save_modal').modal('hide');
                  report_reflect();
                }

              }

            });



    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>