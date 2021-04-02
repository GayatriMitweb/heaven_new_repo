<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<!-- Save Modal -->
<div class="modal fade" id="send_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Visa Status</h4>
      </div>
      <div class="modal-body">
        <form id="frm_group_send">
          <input type="hidden" value="group_tour" id="booking_type" name="booking_type">
            <div class="row mg_bt_10">
               <div class="col-sm-4">
                  <select name="group_id_filter" id="group_id_filter" style="width:100%" title="Booking ID" onchange="load_passenger(this.id)">
                    <option value="">*Booking ID</option>
                    <?php 
                     $query = "select * from tourwise_traveler_details where 1";
                      if($branch_status=='yes' && $role!='Admin'){
                          $query .=" and branch_admin_id = '$branch_admin_id'";
                        } 
                         $query .=" order by traveler_group_id desc";
                      $sq_group = mysql_query($query);
                    while($row_group = mysql_fetch_assoc($sq_group)){
                      $booking_date = $row_group['form_date'];
                      $yr = explode("-", $booking_date);
                      $year =$yr[0];
                      $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_group[customer_id]'"));
                      ?>
                      <option value="<?= $row_group['id'] ?>"><?= get_group_booking_id($row_group['id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              <div class="col-sm-4">
                  <select id="cmb_traveler_id" name="cmb_traveler_id" title="Passenger Name" style="width:100%;" title="Passenger" onchange="load_visa_status(this.id,'')">
                      <option value="select">*Passenger Name</option>                     
                  </select>
              </div>
              <div class="col-md-4">
                <select id="doc_status" name="doc_status" title="Select Status" class="form-control" style="width: 100%">
                  <option value="">*Select Status</option>
                </select>
              </div>
          </div>
          <div class="row mg_tp_20">
              <div class="col-md-12">
              <h3 class="editor_title">Description</h3>
                 <textarea name="comment" placeholder="Description" title="Description" id="comment" class="feature_editor form-control" style="width: 100%"></textarea>
              </div>
          </div>
          <div class="row mg_tp_20 text-center">
              <div class="col-md-4 col-md-offset-4">
               <button id="btn_save" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
             </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#send_modal').modal('show');
$('#cmb_traveler_id,#group_id_filter').select2();

$(function(){
  $('#frm_group_send').validate({
    rules:{
            group_id_filter:{ required:true },
            cmb_traveler_id : { required:true },
            doc_status : { required:true },
    },

    submitHandler:function(form){
    var booking_type = $('#booking_type').val();   
    var doc_status = $('#doc_status').val();
    var traveler_id = $('#cmb_traveler_id').val();
    var group_id = $('#group_id_filter').val();
    var comment = $('#comment').val();

    $('#btn_save').button('loading');

    $.ajax({
      type: 'post',
      url: base_url()+'controller/visa_status/visa_status_save.php',
      data:{ booking_type : booking_type, doc_status : doc_status, traveler_id :traveler_id,booking_id : group_id,comment : comment},
      success: function(result){
        $('#btn_save').button('reset');
        $('#send_modal').modal('hide');
        msg_alert(result);
        reset_form('frm_group_send');
      }
    });
  }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>