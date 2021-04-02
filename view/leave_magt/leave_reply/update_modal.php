<?php 
include "../../../model/model.php";
 
$emp_id = $_POST['emp_id'];
$request_id = $_POST['request_id'];
$sq_req = mysql_fetch_assoc(mysql_query("select * from leave_request where emp_id='$emp_id' and request_id='$request_id'"));
$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_req[emp_id]'"));
$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
$sq_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_id='$sq_emp[role_id]'"));
?>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">User Leave Remark</h4>
      </div>
      <div class="modal-body">
        
        <form id="frm_update">
        	<input type="hidden" id="request_id" name="request_id" value="<?= $request_id ?>">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
        <input type="hidden" id="emp_id" name="emp_id" placeholder="*Employee Id" title="Employee Id" value="<?= $sq_req['emp_id'] ?>" disabled>
	            
          <div class="row mg_bt_10 hidden">
              <div class="col-md-3 text-right"><label for="emp_id">ID</label></div>
                <div class="col-sm-8 col-xs-12">
                <input type="text" id="status" name="status" placeholder="*Employee Id" title="Employee Id" value="<?= $sq_req['status'] ?>" disabled>
              </div>
          </div>
	       	<div class="row mg_bt_10">
	            <div class="col-md-2 text-right"><label for="emp_name">Name</label></div>
	            <div class="col-sm-4 col-xs-12">
	              <input type="text" id="emp_name" name="emp_name" placeholder="*Name" title="Name" value="<?= $sq_emp['first_name'].' '.$sq_emp['middle_name'].' '.$sq_emp['last_name']; ?>" disabled>
	            </div>
              <div class="col-md-2 text-right"><label for="emp_branch">Branch</label></div>
		        	<div class="col-sm-4 col-xs-12">
		              <input type="text" id="emp_branch" name="emp_branch" placeholder="*Branch" title="Branch" value="<?= $sq_branch['branch_name'] ?>" disabled>
		            </div>
	           
        	</div>                      
        	
		    <div class="row mg_bt_10">
	        	<div class="col-md-2 text-right"><label for="designation">Designation</label></div>      
		            <div class="col-sm-4 col-xs-12">
		              <input type="text" id="designation" name="designation" placeholder="*Designation" title="Designation" value="<?= $sq_role['role_name'] ?>" disabled>
		        </div> 
            <div class="col-md-2 text-right"><label for="reason_for_leave">Reason for leave</label></div>    
                <div class="col-sm-4 col-xs-12">
                  <textarea id="reason_for_leave" name="reason_for_leave"  placeholder="*Reason for leave" title="Reason for leave" rows="1"   disabled><?= $sq_req['reason_for_leave'] ?></textarea>
                </div>
		    </div> 
        
		    <div class="row mg_bt_10">
        		<div class="col-md-2 text-right"><label for="type_of_leave">Type Of Leave</label></div> 
		            <div class="col-md-4">
		              <select name="type_of_leave" id="type_of_leave"  title="Type Of Leave">
		              	<option value="<?= $sq_req['type_of_leave'] ?>"><?= $sq_req['type_of_leave'] ?></option>
		                <option value="">*Type Of Leave</option>
		                <option value="Casual">Casual</option>
		                <option value="Paid">Paid</option>
		                 <option value="Medical">Medical</option>
		                <option value="Maternity">Maternity</option>
		                <option value="Paternity"> Paternity</option>
		                <option value="Leave without pay">Leave without Pay</option>

		              </select>
		            </div> 
                <div class="col-md-2 text-right"><label for="from_date">From Date</label></div>                 
		             <div class="col-sm-4 col-xs-12">
		              <input type="text" id="from_date" name="from_date" placeholder="*From Date" title="From Date" value="<?= date('d-m-Y',strtotime($sq_req['from_date'])) ?>">
		            </div>
		    </div> 
		    
		    <div class="row mg_bt_10">
	        	<div class="col-md-2 text-right"><label for="to_date">To Date</label></div> 
	             	<div class="col-sm-4 col-xs-12">
	              		<input type="text" id="to_date" name="to_date" placeholder="*To Date" title="To Date" onchange="total_days_reflect()" value="<?= date('d-m-Y',strtotime($sq_req['to_date'])) ?>">
	            	</div> 
                <div class="col-md-2 text-right"><label for="no_of_days">No of days</label></div>     
		            <div class="col-sm-4 col-xs-12">
		              <input type="text" id="no_of_days" name="no_of_days"  placeholder="No of days" title="No of days" value="<?= $sq_req['no_of_days'] ?>" disabled>
		            </div>
	        </div> 
		    
	    	<div class="row mg_bt_10">
        		<div class="col-md-2 text-right"><label for="comments">Comments</label></div>    
	            	<div class="col-sm-10 col-xs-12">
	              	<textarea id="comments" name="comments"  placeholder="Comments" title="Comments" rows="1" ><?= $sq_req['comments'] ?></textarea>
	            	</div>
	        </div>
          <?php
          if(strtotime(date('d-m-Y',strtotime($sq_req['to_date']))) >= strtotime(date('d-m-Y')))
            {
          ?>
          <div class="row text-center mg_tp_20">
            <div class="col-xs-2 col-md-offset-4">
              <button class="btn btn-sm btn-success" id="btn_update" onclick="update_modal()"><i class="fa fa-check"></i>&nbsp;&nbsp;Approve</button>
            </div>
             <div class="col-xs-2">
              <button class="btn btn-danger table-danger-btn btn-sm ico_left" onclick="reject_modal()" id="btn_reject"><i class="fa fa-times"></i>&nbsp;&nbsp;Reject</button>
            </div>
          </div>
          <?php
            }
            ?>
          </form>

      </div>     
    </div>
  </div>
</div>
 
<script>
$('#save_modal').modal('show');
$('#from_date,#to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

function update_modal(){

$('#frm_update').validate({
  rules:{
      
  },
  submitHandler:function(form){
      var emp_id = $('#emp_id').val();
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var no_of_days = $('#no_of_days').val();
      var comments = $('#comments').val();
      var request_id = $('#request_id').val();
      var type_of_leave = $('#type_of_leave').val();
      var base_url = $('#base_url').val();

      $('#btn_update').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/leave/leave_reply_save.php',
        data:{ emp_id : emp_id, from_date : from_date, to_date : to_date, no_of_days : no_of_days, comments : comments , request_id : request_id , type_of_leave : type_of_leave },
        success: function(result){

          $('#btn_update').button('reset');

          msg_alert(result);

          $('#save_modal').modal('hide');
          list_reflect(); 
        }
      });
  }
});
}

function reject_modal(){

$('#frm_update').validate({
  rules:{
      
  },
  submitHandler:function(form){
      var emp_id = $('#emp_id').val();
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var comments = $('#comments').val();
      var request_id = $('#request_id').val();
      var base_url = $('#base_url').val();
      var no_of_days = $('#no_of_days').val();
      var status = $('#status').val();
      var type_of_leave = $('#type_of_leave').val();



      $('#btn_reject').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/leave/leave_request_reject.php',
        data:{ emp_id : emp_id, comments : comments ,from_date : from_date, to_date : to_date, request_id : request_id , no_of_days : no_of_days , status : status , type_of_leave : type_of_leave },
        success: function(result){

          $('#btn_update').button('reset');

          msg_alert(result);

          $('#save_modal').modal('hide');
          list_reflect();
          //window.open(base_url+'view/leave_magt/leave_reply/index.php');
        }
      });
  }
});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
  
 
