
<div class="modal fade" id="activity_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 80%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Daily Activities</h4>
      </div>
      <div class="modal-body">

          <input type="hidden" title="Employee Id" name= "emp_id" id="emp_id" value="<?php echo $emp_id; ?>"/>
          <div class="row mg_bt_10 text-right">
            <div class="col-md-12">
              <button type="button" class="btn btn-info btn-sm ico_left" onClick="addRow('tbl_dynamic_daily_activity')"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add</button>
              <button type="button" class="btn btn-danger btn-sm ico_left" onClick="deleteRow('tbl_dynamic_daily_activity')"><i class="fa fa-times"></i>&nbsp;&nbsp;Delete</button>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="tbl_dynamic_daily_activity" name="tbl_dynamic_daily_activity" class="table table-bordered table-hover no-marg"  cellspacing="0">
                    <tr>
                        <td><input id="chk_tour_group1" type="checkbox" checked></td>
                        <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." disabled  class="form-control" /></td>
                        <td class="col-md-2 no-pad"><input placeholder="*Select Date" title="Activity Date" id="activity_date" class="form-control app_datepicker"/></td>
                        <td class="col-md-3 no-pad"><input placeholder="Activity Type" onchange="validate_spaces(this.id);validate_specialChar(this.id)" title="Activity Type" id="activity_type" class="form-control" /></td>
                        <td class="col-md-2 no-pad"><input placeholder="Time Taken" onchange="validate_spaces(this.id);validate_specialChar(this.id)"  title="Time Taken" id="time_taken" class="form-control" />
                        </td>
                        <td class="col-md-5 no-pad"><textarea placeholder="Description" onchange="validate_spaces(this.id);"  title="Description" id="description" class="form-control"></textarea> </td>                        
                    </tr>                                
                </table>
              </div>
            </div>
          </div>
            

            <div class="row text-center mg_tp_20">
              <div class="col-md-12">
                <button onclick="activity_master_save()" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
            </div>
        
      </div>      
    </div>
  </div>
</div>
<script type="text/javascript">
$('#activity_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
function activity_master_save()
{
  var base_url = $('#base_url').val();
  var emp_id = $('#emp_id').val();

  var activity_date_arr = new Array();
  var activity_type_arr = new Array();
  var time_taken_arr = new Array();
  var description_arr = new Array();

  var table = document.getElementById("tbl_dynamic_daily_activity");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    if(rowCount == 1){
      if(!row.cells[0].childNodes[0].checked){
        error_msg_alert("Atleast one activity is required!");
        return false;
      }
    }
    if(row.cells[0].childNodes[0].checked)
    {  
      var activity_date = row.cells[2].childNodes[0].value;
      var activity_type = row.cells[3].childNodes[0].value;
      var time_taken = row.cells[4].childNodes[0].value;
      var description = row.cells[5].childNodes[0].value;

      if(activity_date=="")
      {
        error_msg_alert("Enter Activity Date in row"+(i+1));
        return false;
      }

      activity_date_arr.push(activity_date);
      activity_type_arr.push(activity_type);
      time_taken_arr.push(time_taken);
      description_arr.push(description);
    }
    
  }


  $.post( 
         base_url+"controller/daily_activity/activity_save.php",
         { emp_id : emp_id, activity_date_arr : activity_date_arr, activity_type_arr : activity_type_arr,time_taken_arr : time_taken_arr, description_arr : description_arr },
         function(data) {  
                msg_popup_reload(data);
         });
}  
</script>
