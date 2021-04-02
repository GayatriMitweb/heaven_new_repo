<?php
$login_id = $_SESSION['login_id'];
$emp_id = $_SESSION['emp_id'];
$financial_year_id = $_SESSION['financial_year_id'];

//**Enquiries
$assigned_enq_count = mysql_num_rows(mysql_query("select enquiry_id from enquiry_master where financial_year_id='$financial_year_id' and status!='Disabled'"));

$converted_count = 0;
$closed_count = 0;
$followup_count = 0;
$infollowup_count = 0;

$sq_enquiry = mysql_query("select * from enquiry_master where status!='Disabled' and financial_year_id='$financial_year_id'");
while($row_enq = mysql_fetch_assoc($sq_enquiry)){
  $sq_enquiry_entry = mysql_fetch_assoc(mysql_query("select followup_status from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
  if($sq_enquiry_entry['followup_status']=="Dropped"){
    $closed_count++;
  }
  if($sq_enquiry_entry['followup_status']=="Converted"){
    $converted_count++;
  }
  if($sq_enquiry_entry['followup_status']=="Active"){
    $followup_count++;
  }
  if($sq_enquiry_entry['followup_status']=="In-Followup"){
    $infollowup_count++;
  }
}
?>
<div class="app_panel"> 
<div class="dashboard_panel panel-body">
<div id="id_proof1"></div>
  <div class="dashboard_enqury_widget_panel main_block mg_bt_25">
            <div class="row">
                <div class="col-sm-3 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block blue_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-cubes"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $assigned_enq_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Total Enquiries
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block mg_bt_10_sm_xs yellow_enquiry_widget">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $followup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Active
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block gray_enquiry_widget mg_bt_10_sm_xs">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-folder-open-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $infollowup_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      In-Followup
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-xs-6" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                  <div class="single_enquiry_widget main_block green_enquiry_widget ">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-check-square-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $converted_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Converted
                    </div>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="single_enquiry_widget main_block red_enquiry_widget" onclick="window.open('<?= BASE_URL ?>view/attractions_offers_enquiry/enquiry/index.php', 'My Window');">
                    <div class="col-xs-3 text-left">
                      <i class="fa fa-trash-o"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <span class="single_enquiry_widget_amount"><?php echo $closed_count; ?></span>
                    </div>
                    <div class="col-sm-12 single_enquiry_widget_amount">
                      Dropped Enquiries
                    </div>
                  </div>
                </div>
            </div>
    </div>


    <!-- dashboard_tab -->
           <div class="row">
            <div class="col-md-12">
              <div class="dashboard_tab text-center">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs responsive" role="tablist">
                  <li role="presentation" class="active"><a href="#fol-w_tab" aria-controls="fol-w_tab" role="tab" data-toggle="tab">Todays Followups</a></li>
                  <li role="presentation"><a href="#tsk_tab" aria-controls="tsk_tab" role="tab" data-toggle="tab">Task</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content responsive main_block">
	          			<!-- Enquiry & Followup summary -->
			            <div role="tabpanel" class="tab-pane active" id="fol-w_tab">
                    <div class="dashboard_table dashboard_table_panel main_block">
                      <div class="row text-right">
                          <div class="col-md-6 text-left">
                            <div class="dashboard_table_heading main_block">
                            <div class="col-md-10 no-pad">
                              <h3>Followup Reminders</h3>
                            </div>
                            </div>
                          </div>
                          <div class="col-md-1"></div>
                          <div class="col-md-2 col-sm-6 mg_bt_10">
                            <input type="text" id="followup_from_date_filter" name="followup_from_date_filter" placeholder="Followup From D/T" title="Followup From D/T">
                          </div>
                          <div class="col-md-2 col-sm-6 mg_bt_10">
                            <input type="text" id="followup_to_date_filter" name="followup_to_date_filter" placeholder="Followup To D/T" title="Followup To D/T">
                          </div>
                          <div class="col-md-1 text-left col-sm-6 mg_bt_10">
                            <button class="btn btn-excel btn-sm" id="followup_reflect1" onclick="followup_reflect()" data-toggle="tooltip" title="" data-original-title="Proceed"><i class="fa fa-arrow-right"></i></button>
                          </div>
                        </div>
                          <div id='followup_data'></div>
                      </div>
                    </div>
				        <!-- Enquiry & Followup summary End -->

                <!-- Weekly Task -->
                  <div role="tabpanel" class="tab-pane" id="tsk_tab">
                    <?php
                    $assigned_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status!='Disabled'"));
                    $can_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status='Cancelled'"));
                    $completed_task_count = mysql_num_rows(mysql_query("select task_id from tasks_master where emp_id='$emp_id' and task_status='Completed'"));
                    $sq_task = mysql_query("select * from tasks_master where emp_id='$emp_id' and (task_status='Created' or task_status='Incomplete') order by task_id");
                    ?>
                      <div class="dashboard_table dashboard_table_panel main_block">
                        <div class="row text-left">
                            <div class="col-md-12">
                              <div class="dashboard_table_heading main_block">
                                <div class="col-md-12 no-pad">
                                  <h3 style="cursor: pointer;" onclick="window.open('<?= BASE_URL ?>view/tasks/index.php', 'My Window');">Allocated Task</h3>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="dashboard_table_body main_block">
                                <div class="col-sm-9 no-pad table_verflow table_verflow_two"> 
                                  <div class="table-responsive no-marg-sm">
                                    <table class="table table-hover" style="margin: 0 !important;border: 0;">
                                      <thead>
                                        <tr class="table-heading-row">
                                          <th>Task_Name</th>
                                          <th>Task_Type</th>
                                          <th>ID</th>
                                          <th>Assign_Date</th>
                                          <th>Due_DateTime</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php 
                                       while($row_task = mysql_fetch_assoc($sq_task)){ 
                                          $count++;
                                          if($row_task['task_status'] == 'Created'){
                                            $bg='warning';
                                          }
                                          elseif($row_task['task_status'] == 'Incomplete' ){
                                            $bg='danger';
                                          }
                                      ?>
                                          <tr class="odd">
                                            <td><?php echo $row_task['task_name']; ?></td>
                                            <td><?php echo $row_task['task_type']; ?></td>
                                            <td><?php echo ($row_task['task_type_field_id']!='')?$row_task['task_type_field_id']:'NA'; ?></td>
                                            <td><?php echo get_date_user($row_task['created_at']); ?></td>
                                            <td><?php echo get_datetime_user($row_task['due_date']); ?></td>
                                            <td><span class="<?= $bg ?>"><?php echo $row_task['task_status']; ?></span></td>
                                          </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>

                                  </div> 
                                </div>
                                <div class="col-sm-3 no-pad">
                                    <div class="table_side_widget_panel main_block">
                                      <div class="table_side_widget_content main_block">
                                        <div class="col-xs-12" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                          <div class="table_side_widget">
                                            <div class="table_side_widget_amount"><?= $assigned_task_count ?></div>
                                            <div class="table_side_widget_text widget_blue_text">Total Task</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                          <div class="table_side_widget">
                                            <div class="table_side_widget_amount"><?= $completed_task_count ?></div>
                                            <div class="table_side_widget_text widget_green_text">Task Completed</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-6" style="border-bottom: 1px solid hsla(180, 100%, 30%, 0.25)">
                                          <div class="table_side_widget">
                                            <div class="table_side_widget_amount"><?= $can_task_count ?></div>
                                            <div class="table_side_widget_text widget_red_text">Task Cancelled</div>
                                          </div>
                                        </div>
                                        <div class="col-xs-12">
                                          <div class="table_side_widget">
                                            <div class="table_side_widget_amount"><?= $assigned_task_count-$completed_task_count-$can_task_count ?></div>
                                            <div class="table_side_widget_text widget_yellow_text">Task Pending</div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                    <!-- Weekly Task End -->
                </div>
              </div>
            </div>
          </div>
      </div>
</div>
     
<script type="text/javascript">
$('#followup_from_date_filter, #followup_to_date_filter').datetimepicker({ format:'d-m-Y H:i' });
followup_reflect();
function followup_reflect(){
	var from_date = $('#followup_from_date_filter').val();
  var to_date = $('#followup_to_date_filter').val();
	$.post('other/followup_list_reflect.php', { from_date : from_date,to_date:to_date }, function(data){
		$('#followup_data').html(data);
	});
}
function display_history(enquiry_id){
  $.post('admin/followup_history.php', { enquiry_id : enquiry_id }, function(data){
  $('#id_proof1').html(data);
  });
}
function Followup_update(enquiry_id)
{
  $.post('admin/followup_update.php', { enquiry_id : enquiry_id }, function(data){
    $('#id_proof1').html(data);
  });
}
function followup_type_reflect(followup_status){
	$.post('admin/followup_type_reflect.php', {followup_status : followup_status}, function(data){
		$('#followup_type').html(data);
	}); 
}
</script>