<?php
include "../../../../../../model/model.php";
$comp_id = $_POST['comp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq_comp = mysql_fetch_assoc(mysql_query("select * from other_complaince_master where id='$comp_id'"));
?>

<form id="frm_comp_update">

<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="comp_id" name="comp_id" value="<?= $comp_id ?>" >
<div class="modal fade" id="comp_update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Compliance</h4>
      </div>
      <div class="modal-body">
            <div class="row mg_bt_10">
              <div class="col-md-3">
                <input type="text" name="comp_name" id="comp_name" title="Compliance Name" placeholder="Compliance Name" value="<?= $sq_comp['comp_name'] ?>" readonly>
              </div>
              <div class="col-md-3">
                <input type="text" name="under_statue" id="under_statue" title="Under Statute" placeholder="Under Statute" value="<?= $sq_comp['under_statue'] ?>" readonly>
              </div>
              <div class="col-md-3">
                <input type="text" name="payment" id="payment" title="Payment(if Any)" placeholder="Payment(if Any)" value="<?= $sq_comp['payment'] ?>" readonly>
              </div>
              <div class="col-md-3">
                <input type="text" name="due_date" id="due_date" title="Due Date" placeholder='Due date' readonly value="<?= get_date_user($sq_comp['due_date']) ?>">
              </div>
            </div>
            <div class="row mg_bt_10">
              <div class="col-md-3">
                <input type="text" name="resp_person" id="resp_person" title="Responsible Person" placeholder="Responsible Person" value="<?= $sq_comp['resp_person'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <textarea readonly id="description" name="description" title="Description" placeholder="Description"><?= $sq_comp['description'] ?></textarea>
              </div>         
            </div>
            <div class="row mg_bt_10">              
              <div class="col-md-3">
                <input type="text" name="comp_date" id="comp_date" title="Complied Date" placeholder='Complied date' >
              </div>
              <div class="col-md-6">
                <textarea id="comment" name="comment" title="Add Comment" placeholder="Comment"></textarea>
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
$('#comp_update_modal').modal('show');
$('#comp_date').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#frm_comp_update').validate({
    rules:{

            comp_date : { required : true },
    },

    submitHandler:function(){
        var comp_date = $('#comp_date').val();
        var comment = $('#comment').val();
        var comp_id = $('#comp_id').val();
 
            $('#btn_save').button('loading');

            $.ajax({
              type: 'post',
              url: base_url()+'controller/finance_master/reports/other_compliances/master_update.php',
              data:{ comp_date : comp_date,comment : comment, comp_id : comp_id },
              success: function(result){
                $('#btn_save').button('reset');
                msg_alert(result);
                $('#comp_update_modal').modal('hide');
                report_reflect();
              }
            });
    }
});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>