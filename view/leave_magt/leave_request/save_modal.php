<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id']; 
?>

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Request</h4>
      </div>
      <div class="modal-body">
        
        <form id="frm_customer_save">
        <div class="panel panel-default panel-body app_panel_style feildset-panel">
                          
        <div class="row mg_bt_10">
           <input type="hidden" id="emp_id" name="emp_id" value="<?= $emp_id ?>">
             <div class="col-sm-4 col-xs-12">
              <input type="text" id="from_date" name="from_date" placeholder="*From Date" title="From Date" onchange="get_to_date(this.id,'to_date');total_days_reflect()">
            </div>
             <div class="col-sm-4 col-xs-12">
              <input type="text" id="to_date" name="to_date" placeholder="*To Date" title="To Date" onchange="total_days_reflect()">
            </div>     
            <div class="col-sm-4 col-xs-12">
              <input type="text" id="no_of_days" name="no_of_days"  placeholder="No of days" title="No of days" disabled>
            </div>
        </div>
        <div class="row mg_bt_10">
            <div class="col-md-4">
              <select name="type_of_leave" id="type_of_leave"  title="Type Of Leave">
                <option value="">*Type Of Leave</option>
                <option value="Casual">Casual</option>
                <option value="Paid">Paid</option>
                 <option value="Medical">Medical</option>
                <option value="Maternity">Maternity</option>
                <option value="Paternity"> Paternity</option>
                <option value="Leave without Pay">Leave without Pay</option>

              </select>
            </div>    
            <div class="col-sm-8 col-xs-12">
              <textarea id="reason_for_leave" name="reason_for_leave" onchange="validate_spaces(this.id);" placeholder="*Reason for leave" title="Reason for leave" rows="1"></textarea>
            </div>
          </div>
          </div>

          <div class="row text-center">
            <div class="col-xs-12">
              <button class="btn btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Request</button>
            </div>
          </div>

          </form>

      </div>     
    </div>
  </div>
</div>
 
<script>
$('#save_modal').modal('show');
$('#from_date,#to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

  $(function(){

$('#frm_customer_save').validate({
  rules:{
      from_date : { required : true },
      to_date : { required : true },
      type_of_leave : { required : true },
      reason_for_leave : { required : true},
     
  },
  submitHandler:function(form){
      var emp_id = $('#emp_id').val();
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var no_of_days = $('#no_of_days').val();
      var type_of_leave = $('#type_of_leave').val();
      var reason_for_leave = $('#reason_for_leave').val();
      var base_url = $('#base_url').val();

      $('#btn_save').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/leave/leave_request_save.php',
        data:{ emp_id : emp_id, from_date : from_date, to_date : to_date, no_of_days : no_of_days, type_of_leave : type_of_leave, reason_for_leave : reason_for_leave  },
        success: function(result){

          $('#btn_save').button('reset');

          msg_alert(result);

          $('#save_modal').modal('hide');
 
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
