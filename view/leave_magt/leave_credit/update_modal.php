<?php 
include "../../../model/model.php";
 $emp_id = $_POST['emp_id'];
 $sq_leave = mysql_fetch_assoc(mysql_query("select * from leave_credits where emp_id='$emp_id'"));
?>

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Credit</h4>
      </div>
      <div class="modal-body">
        
        <form id="frm_save">
        <div class="panel-body">
                          
         <div class="row mg_bt_10">
              <div class="col-md-4"><label for="emp_id">User Name</label></div>
                <div class="col-sm-6 col-xs-12">
                <select name="emp_id" id="emp_id1"  class="form-control" style="width: 100%;" title="User Name" title="User Name" disabled>
                  <?php
                    $sq_user =mysql_fetch_assoc(mysql_query("select emp_id, first_name, last_name from emp_master where emp_id='$emp_id' ")); ?>
                    <option value="<?= $sq_user['emp_id'] ?>"><?= $sq_user['first_name'].' '.$sq_user['last_name'] ?></option>
                </select>

              </div>
          </div>
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="casual">Casual Leave</label></div>
              <div class="col-sm-6 col-xs-12">
                <input type="text" id="casual" name="casual" placeholder="*Casual" title="Casual" value="<?= $sq_leave['casual'] ?>">
              </div>
             
          </div>                      
          <div class="row mg_bt_10">
            <div class="col-md-4"><label for="paid">Paid Leave</label></div>
              <div class="col-sm-6 col-xs-12">
                  <input type="text" id="paid" name="paid" placeholder="*Paid" title="Paid" value="<?= $sq_leave['paid'] ?>">
                </div> 
        </div> 
        <div class="row mg_bt_10">
            <div class="col-md-4"><label for="medical">Medical Leave</label></div>      
                <div class="col-sm-6 col-xs-12">
                  <input type="text" id="medical" name="medical" placeholder="*Medical" title="Medical" value="<?= $sq_leave['medical'] ?>">
            </div> 
        </div> 
        <div class="row mg_bt_10">
            <div class="col-md-4"><label for="maternity">Maternity Leave</label></div> 
                <div class="col-md-6">
                  <input type="text" id="maternity" name="maternity" placeholder="*Maternity" title="Maternity" value="<?= $sq_leave['maternity'] ?>"> 
                </div> 
        </div> 
        <div class="row mg_bt_10">
            <div class="col-md-4"><label for="paternity">Paternity Leave</label></div>    
                <div class="col-sm-6 col-xs-12">
                  <input type="text" id="paternity" name="paternity"  placeholder="*Paternity" title="Paternity" value="<?= $sq_leave['paternity'] ?>">
                </div>
          </div>
        <div class="row mg_bt_10">
            <div class="col-md-4"><label for="leave_without_pay">Leave without Pay</label></div>                 
                 <div class="col-sm-6 col-xs-12">
                  <input type="text" id="leave_without_pay" name="leave_without_pay" placeholder="*Leave without Pay" title="Leave without Pay" value="<?= $sq_leave['leave_without_pay'] ?>">
                </div>
            </div> 

          <div class="row text-center mg_tp_20">
            <div class="col-xs-12">
              <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>

          </form>

      </div>     
    </div>
  </div>
</div>
 
<script>
$('#update_modal').modal('show');

$(function(){

$('#frm_save').validate({
  rules:{
      emp_id : { required : true },
      casual : { required : true },
      paid : { required : true },
      medical : { required : true }, 
      maternity : { required : true }, 
      paternity : { required : true }, 
      leave_without_pay : { required : true },
     
  },
  submitHandler:function(form){
      var emp_id = $('#emp_id1').val();
      var paid = $('#paid').val();
      var casual = $('#casual').val();
      var medical = $('#medical').val();
      var maternity = $('#maternity').val();
      var paternity = $('#paternity').val();
      var leave_without_pay = $('#leave_without_pay').val();
      var base_url = $('#base_url').val();

      $('#btn_update').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/leave/leave_credit_update.php',
        data:{ emp_id : emp_id, paid : paid, casual : casual, medical : medical, maternity : maternity , paternity : paternity, leave_without_pay : leave_without_pay },
        success: function(result){

          $('#btn_update').button('reset');

          msg_alert(result);

          $('#update_modal').modal('hide');
          list_reflect();
 
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
