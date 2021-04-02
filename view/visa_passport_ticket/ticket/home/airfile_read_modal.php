<?php 
include "../../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
?>
<input type="hidden" id="unique_timestamp" name="unique_timestamp" value="<?= md5(time()) ?>">
<input type="hidden" id="base_url" value="<?= BASE_URL ?>">
<input type="hidden" id="branch_admin_id1" name="branch_admin_id1" value="<?= $branch_admin_id ?>" >
<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>" >
<div class="modal fade" id="ticket_save_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Read GDS</h4>
      </div>
      <div class="modal-body">

      	
            <form id="frm_form_send">
                <div class="row mg_tp_10">
                    <div class="col-md-6 col-sm-6 mg_bt_10">
                        <select name="air_type" id="air_type">
                            <option value="">Select GDS</option>
                            <option>Amadeus</option>
                            <option>Galileo</option>
                        </select>
                    </div>          
                    <div class="col-md-6 col-sm-6 mg_bt_10">
                      <button class="btn btn-sm btn-success" id="read_airfile"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Read GDS</button>
                    </div>
                </div>
            </form>
      </div>  
    </div>
  </div>
</div>


<script>
$('#ticket_save_modal').modal({backdrop: 'static', keyboard: false});
$('#read_airfile').on('click', function(event){
  event.preventDefault();
  var base_url = $('#base_url').val();
  var type = $('#air_type').val();
  $.get(base_url + '/controller/airfiles/read_airfile.php', {type : type}, function(result){
    // alert(1);
    msg_alert(result);
  });
});

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>