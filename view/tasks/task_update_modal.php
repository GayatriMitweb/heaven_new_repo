<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$task_id = $_POST['task_id'];

$sq_task = mysql_fetch_assoc(mysql_query("select * from tasks_master where task_id='$task_id'"));
?>
<div class="modal fade" id="tasks_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update</h4>
      </div>
      <div class="modal-body">

        <form id="frm_task_update">

        <input type="hidden" id="task_id" name="task_id" value="<?= $task_id ?>">

        <div class="row mg_bt_10">
          <div class="col-md-12">
            <textarea name="task_name1" id="task_name1" placeholder="Task Name" onchange="validate_spaces(this.id)" title="Task Name"><?= $sq_task['task_name'] ?></textarea>
          </div>
        </div>
      
        <div class="row">
          <div class="col-sm-6 mg_bt_10">
            <input type="text" id="due_date1" name="due_date1" placeholder="Due Date" title="Due Date" value="<?= date('d-m-Y H:i:s', strtotime($sq_task['due_date'])) ?>">
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="assign_to1" id="assign_to1" style="width: 100%" class="app-select2" title="Assign To">
              <?php 
              $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_task[emp_id]'"));
              ?>
              <option value="<?= $sq_emp['emp_id'] ?>"><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></option>
              <?php
             $query = "select * from emp_master where emp_id!='0'";
              if($role!='Admin' && $branch_status=='yes')
              {
                $query .=" and branch_id='$branch_admin_id'";
              }
              $sq_employee = mysql_query($query);
              while($row_employee = mysql_fetch_assoc($sq_employee)){
                ?>
                <option value="<?= $row_employee['emp_id'] ?>"><?= $row_employee['first_name'].' '.$row_employee['last_name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="remind1" id="remind1" title="Reminder">
              <option value="<?= $sq_task['remind'] ?>"><?= $sq_task['remind'] ?></option>
              <option value="None">None</option>
              <option value="On Due Time">On Due Time</option>
              <option value="Before 15 Mins">Before 15 Mins</option>
              <option value="Before 30 Mins">Before 30 Mins</option>
              <option value="Before 1 Hour">Before 1 Hour</option>
              <option value="Before 1 Day">Before 1 Day</option>
            </select>
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="remind_by1" id="remind_by1" title="Remind By">
              <option value="<?= $sq_task['remind_by'] ?>"><?= $sq_task['remind_by'] ?></option>
              <option value="Email And SMS">Email And SMS</option>
              <option value="Email">Email</option>
              <option value="SMS">SMS</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6 mg_bt_10">
            <select name="task_type1" id="task_type1" title="Task Type" onchange="tasks_type_reference_reflect(this.id, 'frm_task_update')">
              <option value="<?= $sq_task['task_type'] ?>"><?= $sq_task['task_type'] ?></option>
              <option value="Other">Other</option>
              <option value="Group Tour">Group Tour</option>
              <option value="Package Tour">Package Tour</option>
              <option value="Enquiry">Enquiry</option>
            </select>
          </div>

          <?php 
            $hidden_state = ($sq_task['task_type']=="Package Tour") ? "" : "hidden"; 
          ?>
          <div class="col-sm-6 mg_bt_10 <?= $hidden_state ?> booking_id">
            <select id="booking_id1" name="booking_id1" style="width:100%"> 
                <?php 
                    if($hidden_state==""){

                      $sq_booking = mysql_query("select booking_id from package_tour_booking_master where booking_id='$sq_task[task_type_field_id]'");
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

                    }
                    ?>
                    <option value="">Select File Number</option>
                    <?php
                    $sq_booking = mysql_query("select booking_id from package_tour_booking_master");
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

          <?php $hidden_state = ($sq_task['task_type']=="Enquiry") ? "" : "hidden"; ?>
          <div class="col-sm-6 mg_bt_10 <?= $hidden_state ?> enquiry_id">
            <select name="enquiry_id1" id="enquiry_id1" title="Enquiry" style="width:100%">
              <?php 
              if($hidden_state==""){
                  $sq_enquiry = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$sq_task[task_type_field_id]'"));
                  echo '<option value="'.$sq_enquiry['enquiry_id'].'">Enq:'.$sq_enquiry['enquiry_id'].' - '.$sq_enquiry['name'].'</option>';
              }
              ?>
              <option value="">Select Enquiry</option>
              <?php
              $sq_enquiry = mysql_query("select * from enquiry_master");
              while($row_enquiry = mysql_fetch_assoc($sq_enquiry)){
                ?>
                <option value="<?= $row_enquiry['enquiry_id'] ?>">Enq:<?= $row_enquiry['enquiry_id'] ?>-<?= $row_enquiry['name'] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
        </div>

        <?php $hidden_state = ($sq_task['task_type']=="Group Tour") ? "" : "hidden"; ?>
        <div class="row <?= $hidden_state ?> tour_group_id">
          <div class="col-sm-6 mg_bt_10">
            <select style="width:100%" id="tour_id1" name="tour_id1" onchange="tour_group_dynamic_reflect(this.id, 'tour_group_id1');"> 
              <?php 
              if($hidden_state==""){
                $sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$sq_task[task_type_field_id]'"));

                $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_tour_group[tour_id]'"));
                echo '<option value="'.$sq_tour['tour_id'].'">'.$sq_tour['tour_name'].'</option>';
              }
              ?>
              <option value=""> Select Tour  </option>
              <?php
                  $sq=mysql_query("select tour_id,tour_name from tour_master");
                  while($row=mysql_fetch_assoc($sq))
                  {
                    echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                  }    
              ?>
          </select>    
          </div>
          <div class="col-sm-6 mg_bt_10">
            <select name="tour_group_id1" id="tour_group_id1" title="Select Tour Group" style="width:100%">
              <?php 
              if($hidden_state==""){
                echo '<option value="'.$sq_tour_group['tour_group_id'].'">'.date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date'])).'</option>';
              }
              ?>
              <option value="">Select Tour Group</option>
            </select>
          </div>
        </div>

        <div class="row text-center mg_tp_20"> <div class="col-md-12">
          <button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update Task</button>
        </div> </div>

        </form>

      </div>    
    </div>
  </div>
</div>

<script>
$('#tasks_update_modal').modal('show');

$('#cmb_booking_id1, #enquiry_id1, #tour_id1, #tour_group_id1,#assign_to1').select2();
$('#due_date1').datetimepicker({ format:'d-m-Y H:i' });
$(function(){
  $('#frm_task_update').validate({
    rules:{
            task_name1 : { required:true },
            due_date1 : { required:true },
            assign_to1 : { required:true },
            remind1 : { required:true },
            task_type1 : { required:true },          
    },
    submitHandler:function(form){
            var task_id = $('#task_id').val();
            var task_name  = $('#task_name1').val();
            var due_date  = $('#due_date1').val();
            var assign_to  = $('#assign_to1').val();
            var remind  = $('#remind1').val();
            var remind_by  = $('#remind_by1').val();

            var task_type = $('#task_type1').val();
  
            if(task_type=="Other"){
              var task_type_field_id = "";
            }
            if(task_type=="Group Tour"){
              var task_type_field_id = $('#tour_group_id1').val();
              if(task_type_field_id==""){ error_msg_alert("Please select tour group"); return false; }
            }
            if(task_type=="Package Tour"){
              var task_type_field_id = $('#booking_id1').val();;
              if(task_type_field_id==""){ error_msg_alert("Please select booking"); return false; }
            }
            if(task_type=="Enquiry"){
              var task_type_field_id = $('#enquiry_id1').val();
              if(task_type_field_id==""){ error_msg_alert("Please select enquiry"); return false; }
            }

            var base_url = $('#base_url').val();

            $.ajax({
              type:'post',
              url: base_url+'controller/tasks/task_update.php',
              data:{ task_id : task_id, task_name : task_name, due_date : due_date, assign_to : assign_to, remind : remind, remind_by : remind_by, task_type : task_type, task_type_field_id : task_type_field_id },
              success:function(result){
                msg_alert(result);
                $('#tasks_update_modal').modal('hide');
                tasks_list_reflect();
              }
            });
    }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>