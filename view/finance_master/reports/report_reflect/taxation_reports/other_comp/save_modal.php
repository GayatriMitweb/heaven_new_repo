<?php
include "../../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>

<form id="frm_comp_save">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<div class="modal fade" id="comp_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">New Compliance</h4>
      </div>
      <div class="modal-body">
            <div class="row mg_bt_10">
              <div class="col-md-3">
                <input type="text" name="comp_name" id="comp_name" title="Compliance Name" placeholder="*Compliance Name">
              </div>
              <div class="col-md-3">
                <input type="text" name="under_statue" id="under_statue" title="Under Statute" placeholder="Under Statute">
              </div>
              <div class="col-md-3">
                <input type="text" name="payment" id="payment" title="Payment(if Any)" placeholder="Payment(if Any)">
              </div>
              <div class="col-md-3">
                <input type="text" name="due_date" id="due_date" title="Due Date" placeholder="<?= date('d-m-Y') ?>">
              </div>
            </div>
            <div class="row mg_bt_10">
              <div class="col-md-3">
                <input type="text" name="resp_person" id="resp_person" title="Responsible Person" placeholder="*Responsible Person">
              </div>
              <div class="col-md-6">
                <textarea id="description" name="description" title="Description" placeholder="*Description"></textarea>
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
$('#comp_save_modal').modal('show');
$('#due_date').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#frm_comp_save').validate({
    rules:{

            comp_name : { required : true },
            resp_person : { required : true },
            description : { required : true },
    },

    submitHandler:function(){
        var comp_name = $('#comp_name').val();
        var under_statue = $('#under_statue').val();
        var payment = $('#payment').val();
        var due_date = $('#due_date').val();
        var resp_person = $('#resp_person').val();
        var description = $('#description').val();
        var branch_admin_id = $('#branch_admin_id').val();
 
            $('#btn_save').button('loading');

            $.ajax({
              type: 'post',
              url: base_url()+'controller/finance_master/reports/other_compliances/master_save.php',
              data:{ comp_name : comp_name,under_statue : under_statue,payment : payment,due_date : due_date,resp_person : resp_person,description : description, branch_admin_id : branch_admin_id },
              success: function(result){
                $('#btn_save').button('reset');
                msg_alert(result);
                $('#comp_save_modal').modal('hide');
                report_reflect();
              }
            });
    }
});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>