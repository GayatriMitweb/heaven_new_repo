<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
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
        <form id="frm_visa_send1">
          <div class="row mg_bt_10"> 
            <input type="hidden" name="booking_type" id="booking_type" value="visa_booking"/>
    		      <div class="col-sm-4">
    			      <select name="visa_id_filter" id="visa_id_filter" style="width:100%" class="form-control" title="Booking ID" onchange="load_passenger(this.id)">
    			        <option value="">*Booking ID</option>
    			        <?php 
        			    $query = "select * from visa_master where 1";
                  if($branch_status=='yes' && $role!='Admin'){
                    $query .= " and branch_admin_id = '$branch_admin_id'";
                  }
                  elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
                    $query .= " and emp_id='$emp_id'";
                  }
                  $query .= " order by visa_id desc";
                  $sq_visa = mysql_query($query);
    			        while($row_visa = mysql_fetch_assoc($sq_visa)){
                     $booking_date = $row_visa['created_at'];
                      $yr = explode("-", $booking_date);
                      $year =$yr[0];
    			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_visa[customer_id]'"));
    			          ?>
    			          <option value="<?= $row_visa['visa_id'] ?>"><?= get_visa_booking_id($row_visa['visa_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
    			          <?php
    			        }
    			        ?>
    			      </select>
    			    </div>
              <div class="col-sm-4">
                <select id="cmb_traveler_id2" name="cmb_traveler_id" class="form-control" style="width:100%;" title="Passenger" onchange="load_visa_status(this.id,'2')">
                    <option value="">*Passenger Name</option>
                </select>
              </div>
              <div class="col-md-4">
                  <select id="doc_status2" name="doc_status" title="Select Status" class="form-control" style="width: 100%">
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
$('#cmb_traveler_id2,#visa_id_filter').select2();
$(function(){
  $('#frm_visa_send1').validate({
    rules:{
            visa_id_filter:{ required:true },
            cmb_traveler_id : { required:true },
            doc_status : { required:true },
    },

    submitHandler:function(form){
    var booking_type = $('#booking_type').val();  
    var doc_status = $('#doc_status2').val();
    var traveler_id = $('#cmb_traveler_id2').val();
    var visa_id = $('#visa_id_filter').val();
    var comment = $('#comment').val();


    $('#btn_save').button('loading');

    $.ajax({
      type: 'post',
      url: base_url()+'controller/visa_status/visa_status_save.php',
      data:{ booking_type : booking_type, doc_status : doc_status, traveler_id :traveler_id,booking_id : visa_id,comment : comment},
      success: function(result){
       msg_alert(result);
       reset_form('frm_visa_send1');
       $('#btn_save').button('reset');
       $('#send_modal').modal('hide');
      }
    });
  }
  });
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>