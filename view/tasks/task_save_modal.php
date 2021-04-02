<?php 
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='tasks/index.php'"));
$branch_status = $sq['branch_status']
?>
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="tasks_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Task</h4>
      </div>
      <div class="modal-body">

        <form id="frm_task_save">

        <div class="row mg_bt_10">
          <div class="col-md-12">
            <textarea name="task_name" id="task_name" placeholder="*Task Name" onchange="validate_spaces(this.id);" title="Task Name"></textarea>
          </div>
        </div>
      
        <div class="row">
          <div class="col-sm-6 mg_bt_10">
            <input type="text" id="due_date" name="due_date" placeholder="*Due Date & Time" title="Due Date & Time" value="<?= date('d-m-Y H:i')?>">
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="assign_to" id="assign_to" style="width: 100%" title="Assign To">
              <option value="">*Assign To</option>
           
              <?php  if($role=='Admin' || ($branch_status!='yes' && $role=='Branch Admin')){
                      $query = "select * from emp_master where active_flag='Active' order by first_name desc";
                      $sq_emp = mysql_query($query);
                      while($row_emp = mysql_fetch_assoc($sq_emp)){
                          ?>
                          <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                          <?php
                        }
                      }
                      elseif($branch_status=='yes' && $role=='Branch Admin'){
                        $query = "select * from emp_master where active_flag='Active' and branch_id='$branch_admin_id' order by first_name asc";
                        $sq_emp = mysql_query($query);
                        while($row_emp = mysql_fetch_assoc($sq_emp)){
                            ?>
                            <option value="<?= $row_emp['emp_id'] ?>"><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></option>
                            <?php
                          }
                        }
                      else{
                      $query1 = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id' and active_flag='Active'")); ?>
                      <option value="<?= $query1['emp_id'] ?>"><?= $query1['first_name'].' '.$query1['last_name'] ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="remind" id="remind" title="Reminder">
              <option value="">*Reminder</option>
              <option value="None">None</option>
              <option value="On Due Time">On Due Time</option>
              <option value="Before 15 Mins">Before 15 Mins</option>
              <option value="Before 30 Mins">Before 30 Mins</option>
              <option value="Before 1 Hour">Before 1 Hour</option>
              <option value="Before 1 Day">Before 1 Day</option>
            </select>
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="remind_by" id="remind_by" title="Remind By">
              <option value="">Remind By </option>
              <option value="Email And SMS">Email And SMS</option>
              <option value="Email">Email</option>
              <option value="SMS">SMS</option>
            </select>
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="task_type" id="task_type" title="Task Type" onchange="tasks_type_reference_reflect(this.id, 'frm_task_save')">
              <option value="">*Task Type</option>
              <option value="Group Tour">Group Tour</option>
              <option value="Package Tour">Package Tour</option>
              <option value="Enquiry">Enquiry</option>
              <option value="Other">Other</option>

            </select>
          </div>
          <div class="col-sm-6 mg_bt_10 hidden booking_id">
            <select id="booking_id" name="booking_id" style="width:100%"> 
                <option value="">*Select File Number</option>
                <?php 
                     $query = "select * from package_tour_booking_master where 1 ";
                      include "../../model/app_settings/branchwise_filteration.php";
                    $sq_booking = mysql_query($query);
                    while($row_booking = mysql_fetch_assoc($sq_booking))
                    {
                        $sq_traveler = mysql_query("select m_honorific, first_name, last_name from package_travelers_details where booking_id='$row_booking[booking_id]' and status!='Cancel'");
                        while($row_traveler = mysql_fetch_assoc($sq_traveler))
                        {
                         ?>
                         <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo "File No-".$row_booking['booking_id']."-".$row_traveler['m_honorific']." ".$row_traveler['first_name']." ".$row_traveler['last_name']; ?></option>
                         <?php    
                        }    
                    }    
                 ?>
            </select>
          </div>
          <div class="col-md-6 hidden enquiry_id">
            <select name="enquiry_id" id="enquiry_id" title="Enquiry" style="width:100%">
              <option value="">*Select Enquiry</option>
              <?php 
                $query = "select * from enquiry_master where 1 ";
                  include "../../model/app_settings/branchwise_filteration.php";
                $sq_enquiry = mysql_query($query);
              while($row_enquiry = mysql_fetch_assoc($sq_enquiry)){
                ?>
                <option value="<?= $row_enquiry['enquiry_id'] ?>">Enq:<?= $row_enquiry['enquiry_id'] ?>-<?= $row_enquiry['name'] ?></option>
                <?php } ?>
            </select>
          </div>
        </div>

        <div class="row mg_bt_20 hidden tour_group_id">
          <div class="col-md-6">
            <select style="width:100%" id="tour_id" name="tour_id" onchange="tour_group_dynamic_reflect(this.id, 'tour_group_id');"> 
              <option value=""> *Select Tour  </option>
              <?php
                  $sq=mysql_query("select tour_id,tour_name from tour_master");
                  while($row=mysql_fetch_assoc($sq)){
                    echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                  }
              ?>
          </select>
          </div>
          <div class="col-md-6">
            <select name="tour_group_id" id="tour_group_id" title="Select Tour Group" style="width:100%">
              <option value="">*Select Tour Group</option>
            </select>
          </div>
        </div>
        <div class="row text-center mg_tp_20">
           <div class="col-md-12">
            <button class="btn btn-sm btn-success" id="task_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save Task</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$('#cmb_booking_id, #enquiry_id, #tour_id, #tour_group_id,#assign_to').select2();
$('#due_date').datetimepicker({ format:'d-m-Y H:i' });
$(function(){
  $('#frm_task_save').validate({
    rules:{
            task_name : { required:true },
            due_date : { required:true },
            assign_to : { required:true },
            remind : { required:true },
            task_type : { required:true },      
    },
    submitHandler:function(form){
            var task_name  = $('#task_name').val();
            var due_date  = $('#due_date').val();
            var assign_to  = $('#assign_to').val();
            var remind  = $('#remind').val();
            var remind_by  = $('#remind_by').val();
            var branch_admin_id = $('#branch_admin_id1').val();
            var task_type = $('#task_type').val();
  
            if(task_type=="Other"){
              var task_type_field_id = "";
            }
            if(task_type=="Group Tour"){
              var task_type_field_id = $('#tour_group_id').val();
              if(task_type_field_id==""){ error_msg_alert("Please select tour group"); return false; }
            }
            if(task_type=="Package Tour"){
              var task_type_field_id = $('#booking_id').val();;
              if(task_type_field_id==""){ error_msg_alert("Please select booking"); return false; }
            }
            if(task_type=="Enquiry"){
              var task_type_field_id = $('#enquiry_id').val();
              if(task_type_field_id==""){ error_msg_alert("Please select enquiry"); return false; }
            }

            var base_url = $('#base_url').val();
            $('#task_save').button('loading');
            whatsapp_send(task_name, due_date, assign_to,base_url);
            $.ajax({
              type:'post',
              url: base_url+'controller/tasks/task_save.php',
              data:{ task_name : task_name, due_date : due_date, assign_to : assign_to, remind : remind, remind_by : remind_by, task_type : task_type, task_type_field_id : task_type_field_id , branch_admin_id : branch_admin_id},
              success:function(result){
                msg_alert(result);
                reset_form('frm_task_save');
                $('#tasks_save_modal').modal('hide');
                tasks_list_reflect();
              }
            });
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>